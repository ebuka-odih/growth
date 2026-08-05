<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Gallery uploads for models using App\Models\Concerns\HasMedia: several images
 * per record, capped at the model's MEDIA_LIMIT, one of them ticked as featured.
 *
 * The form posts:
 *   images[]        new files
 *   remove_media[]  ids of saved images to drop
 *   featured_media  a saved id, or "upload:{index}" for one of the new files
 */
trait HandlesMediaUploads
{
    /** @return array<string, mixed> */
    protected function mediaRules(Request $request, ?Model $model, int $limit): array
    {
        return [
            'images' => ['nullable', 'array', function (string $attribute, mixed $value, callable $fail) use ($request, $model, $limit) {
                $kept = $model?->exists
                    ? $model->media()->whereKeyNot($this->removedMediaIds($request))->count()
                    : 0;

                if ($kept + count((array) $value) > $limit) {
                    $fail("Up to {$limit} images — remove one before adding another.");
                }
            }],
            'images.*' => ['image', 'max:5120'],
            'remove_media' => ['nullable', 'array'],
            'remove_media.*' => ['integer'],
            'featured_media' => ['nullable', 'string', 'max:40'],
        ];
    }

    /** The gallery inputs are handled separately, so they never reach the model. */
    protected function mediaInputKeys(): array
    {
        return ['images', 'remove_media', 'featured_media'];
    }

    /** Apply the gallery edits: removals first, then uploads, then the featured pick. */
    protected function syncMedia(Request $request, Model $model, string $directory): void
    {
        $model->media()
            ->whereKey($this->removedMediaIds($request))
            ->get()
            ->each(function (Media $item) {
                Storage::disk('public')->delete($item->path);
                $item->delete();
            });

        $position = (int) $model->media()->max('position');
        $uploads = [];

        foreach (array_values($request->file('images', [])) as $index => $file) {
            $uploads[$index] = $model->media()->create([
                'path' => $file->store($directory, 'public'),
                'position' => ++$position,
            ]);
        }

        $featured = (string) $request->input('featured_media', '');

        // A radio on a file that had not been saved yet arrives as "upload:{index}".
        if (str_starts_with($featured, 'upload:')) {
            $featured = (string) ($uploads[(int) substr($featured, 7)]?->id ?? '');
        }

        $this->applyFeatured($model, $featured === '' ? null : (int) $featured);

        $model->unsetRelation('media');
    }

    /** Exactly one image is featured, and positions stay contiguous. */
    private function applyFeatured(Model $model, ?int $featuredId): void
    {
        $media = $model->media()->get();

        $target = $media->firstWhere('id', $featuredId)
            ?? $media->firstWhere('is_featured', true)
            ?? $media->first();

        $media->values()->each(fn (Media $item, int $index) => $item->update([
            'position' => $index,
            'is_featured' => $target !== null && $item->is($target),
        ]));
    }

    /** @return list<int> */
    private function removedMediaIds(Request $request): array
    {
        return collect($request->input('remove_media', []))
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->values()
            ->all();
    }
}
