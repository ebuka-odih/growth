<?php

use App\Models\Course;
use App\Models\Post;
use App\Models\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The single-image columns this migration folds into the shared media table.
     *
     * @var list<array{0: string, 1: string, 2: class-string}>
     */
    private array $legacy = [
        ['projects', 'image', Project::class],
        ['courses', 'image', Course::class],
        ['posts', 'cover', Post::class],
    ];

    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->morphs('mediable');
            $table->string('path');
            $table->string('alt')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->string('website_url')->nullable()->after('year');
            $table->string('video_url')->nullable()->after('website_url');
        });

        // The image a record already has becomes the featured item of its new gallery.
        foreach ($this->legacy as [$table, $column, $type]) {
            $rows = DB::table($table)
                ->whereNotNull($column)
                ->where($column, '!=', '')
                ->get(['id', $column]);

            foreach ($rows as $row) {
                DB::table('media')->insert([
                    'mediable_type' => $type,
                    'mediable_id' => $row->id,
                    'path' => $row->{$column},
                    'is_featured' => true,
                    'position' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            Schema::table($table, fn (Blueprint $t) => $t->dropColumn($column));
        }
    }

    public function down(): void
    {
        foreach ($this->legacy as [$table, $column, $type]) {
            Schema::table($table, fn (Blueprint $t) => $t->string($column)->nullable());

            DB::table('media')
                ->where('mediable_type', $type)
                ->where('is_featured', true)
                ->get(['mediable_id', 'path'])
                ->each(fn ($row) => DB::table($table)->where('id', $row->mediable_id)->update([$column => $row->path]));
        }

        Schema::table('projects', fn (Blueprint $t) => $t->dropColumn(['website_url', 'video_url']));

        Schema::dropIfExists('media');
    }
};
