<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Post;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_the_admin_forms_render_the_gallery_field_with_the_right_limit(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('admin.projects.create'))->assertOk()->assertSee('0 of 5 used');
        $this->get(route('admin.courses.create'))->assertOk()->assertSee('0 of 3 used');
        $this->get(route('admin.posts.create'))->assertOk()->assertSee('0 of 3 used');
    }

    public function test_courses_and_posts_take_three_images_but_not_four(): void
    {
        $this->actingAs(User::factory()->create());

        $four = fn () => collect(range(1, 4))->map(fn ($i) => UploadedFile::fake()->image("s{$i}.jpg"))->all();
        $three = fn () => collect(range(1, 3))->map(fn ($i) => UploadedFile::fake()->image("s{$i}.jpg"))->all();

        $this->post(route('admin.courses.store'), ['title' => 'Motion basics', 'level' => 'Foundation', 'images' => $four()])
            ->assertSessionHasErrors('images');

        $this->post(route('admin.courses.store'), ['title' => 'Motion basics', 'level' => 'Foundation', 'images' => $three()])
            ->assertSessionHasNoErrors();

        $this->post(route('admin.posts.store'), ['title' => 'Why brand systems', 'category' => 'Insight', 'images' => $four()])
            ->assertSessionHasErrors('images');

        $this->post(route('admin.posts.store'), ['title' => 'Why brand systems', 'category' => 'Insight', 'images' => $three()])
            ->assertSessionHasNoErrors();

        $this->assertCount(3, Course::firstOrFail()->media);
        $this->assertCount(3, Post::firstOrFail()->media);
    }

    public function test_the_public_pages_show_the_featured_image_and_the_gallery(): void
    {
        $course = Course::create(['title' => 'Motion basics', 'level' => 'Foundation', 'is_published' => true]);
        $course->media()->create(['path' => 'courses/one.jpg']);
        $course->media()->create(['path' => 'courses/two.jpg', 'is_featured' => true, 'position' => 1]);

        $post = Post::create(['title' => 'Why brand systems', 'category' => 'Insight', 'is_published' => true, 'published_at' => now()]);
        $post->media()->create(['path' => 'posts/one.jpg']);

        $this->get(route('community.course', $course))
            ->assertOk()
            // The featured image leads even though it was uploaded second.
            ->assertSeeInOrder(['courses/two.jpg', 'courses/one.jpg'], escape: false)
            ->assertSee('data-gallery-thumb="1"', escape: false);

        $this->get(route('insights.show', $post))
            ->assertOk()
            ->assertSee('posts/one.jpg', escape: false)
            // A lone image needs no thumbnail strip.
            ->assertDontSee('data-gallery-thumb', escape: false);
    }

    public function test_a_project_card_flags_a_video_and_the_extra_images(): void
    {
        $project = Project::create([
            'title' => 'Identity system',
            'is_published' => true,
            'video_url' => 'https://vimeo.com/123456789',
        ]);
        $project->media()->create(['path' => 'projects/one.jpg']);
        $project->media()->create(['path' => 'projects/two.jpg', 'position' => 1]);

        $this->get(route('work.index'))->assertOk()->assertSee('Video')->assertSee('+1');
    }

    public function test_a_project_without_media_still_renders(): void
    {
        $project = Project::create(['title' => 'Identity system', 'is_published' => true]);

        $this->get(route('work.show', $project))->assertOk()->assertSee('Project image');
        $this->get(route('work.index'))->assertOk();
        $this->get(route('home'))->assertOk();
    }
}
