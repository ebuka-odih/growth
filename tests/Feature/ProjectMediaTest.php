<?php

namespace Tests\Feature;

use App\Models\Media;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectMediaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->actingAs(User::factory()->create());
    }

    /** @return array<string, mixed> */
    private function payload(array $overrides = []): array
    {
        return array_merge(['title' => 'Identity system', 'is_published' => '1'], $overrides);
    }

    public function test_a_project_takes_up_to_five_images_with_one_featured(): void
    {
        $images = collect(range(1, 5))->map(fn ($i) => UploadedFile::fake()->image("shot-{$i}.jpg"))->all();

        $this->post(route('admin.projects.store'), $this->payload([
            'images' => $images,
            'featured_media' => 'upload:2',
        ]))->assertRedirect(route('admin.projects.index'));

        $project = Project::firstOrFail();

        $this->assertCount(5, $project->media);
        $this->assertSame([0, 1, 2, 3, 4], $project->media->pluck('position')->all());
        $this->assertCount(1, $project->media->where('is_featured', true));
        $this->assertSame($project->media[2]->id, $project->featuredMedia()->id);

        $project->media->each(fn ($item) => Storage::disk('public')->assertExists($item->path));
    }

    public function test_a_sixth_image_is_rejected(): void
    {
        $images = collect(range(1, 6))->map(fn ($i) => UploadedFile::fake()->image("shot-{$i}.jpg"))->all();

        $this->post(route('admin.projects.store'), $this->payload(['images' => $images]))
            ->assertSessionHasErrors('images');

        $this->assertSame(0, Project::count());
    }

    public function test_the_limit_counts_images_that_are_being_removed(): void
    {
        $project = Project::create(['title' => 'Identity system']);
        $existing = collect(range(1, 5))->map(fn ($i) => $project->media()->create([
            'path' => "projects/shot-{$i}.jpg",
            'position' => $i,
        ]));

        // Full gallery, so a new upload only fits once something is dropped.
        $this->put(route('admin.projects.update', $project), $this->payload([
            'images' => [UploadedFile::fake()->image('new.jpg')],
        ]))->assertSessionHasErrors('images');

        $this->put(route('admin.projects.update', $project), $this->payload([
            'images' => [UploadedFile::fake()->image('new.jpg')],
            'remove_media' => [$existing->first()->id],
        ]))->assertSessionHasNoErrors();

        $this->assertCount(5, $project->fresh()->media);
        $this->assertDatabaseMissing('media', ['id' => $existing->first()->id]);
    }

    public function test_removing_an_image_deletes_its_file_and_moves_the_featured_flag(): void
    {
        $project = Project::create(['title' => 'Identity system']);
        $path = UploadedFile::fake()->image('cover.jpg')->store('projects', 'public');
        $featured = $project->media()->create(['path' => $path, 'is_featured' => true]);
        $other = $project->media()->create(['path' => 'projects/other.jpg', 'position' => 1]);

        $this->put(route('admin.projects.update', $project), $this->payload([
            'remove_media' => [$featured->id],
        ]))->assertSessionHasNoErrors();

        Storage::disk('public')->assertMissing($path);
        $this->assertSame($other->id, $project->fresh()->featuredMedia()->id);
    }

    public function test_deleting_a_project_takes_its_gallery_with_it(): void
    {
        $project = Project::create(['title' => 'Identity system']);
        $path = UploadedFile::fake()->image('cover.jpg')->store('projects', 'public');
        $project->media()->create(['path' => $path]);

        $this->delete(route('admin.projects.destroy', $project))->assertRedirect();

        Storage::disk('public')->assertMissing($path);
        $this->assertSame(0, Media::count());
    }

    public function test_a_bare_domain_is_stored_as_a_full_website_url(): void
    {
        $this->post(route('admin.projects.store'), $this->payload(['website_url' => 'growsphere.ng']))
            ->assertSessionHasNoErrors();

        $this->assertSame('https://growsphere.ng', Project::firstOrFail()->website_url);
    }

    public function test_only_youtube_and_vimeo_links_are_accepted_as_the_video(): void
    {
        $this->post(route('admin.projects.store'), $this->payload(['video_url' => 'https://example.com/clip.mp4']))
            ->assertSessionHasErrors('video_url');

        $this->post(route('admin.projects.store'), $this->payload(['video_url' => 'youtu.be/dQw4w9WgXcQ']))
            ->assertSessionHasNoErrors();

        $project = Project::firstOrFail();

        $this->assertTrue($project->hasVideo());
        $this->assertStringContainsString('/embed/dQw4w9WgXcQ', $project->videoEmbedUrl());
    }

    public function test_the_project_page_leads_with_the_video_and_lists_the_gallery(): void
    {
        $project = Project::create([
            'title' => 'Identity system',
            'is_published' => true,
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'website_url' => 'https://growsphere.ng',
        ]);
        $project->media()->create(['path' => 'projects/one.jpg', 'is_featured' => true]);
        $project->media()->create(['path' => 'projects/two.jpg', 'position' => 1]);

        $this->get(route('work.show', $project))
            ->assertOk()
            ->assertSee('data-video-play', escape: false)
            ->assertSee('i.ytimg.com/vi/dQw4w9WgXcQ', escape: false)
            ->assertSee('data-gallery-thumb="2"', escape: false)
            ->assertSee('Visit growsphere.ng');
    }
}
