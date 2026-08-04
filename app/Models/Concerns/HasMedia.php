<?php

namespace App\Models\Concerns;

use App\Models\Media;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;

/**
 * A gallery of uploaded images, one of which is the featured (cover) image.
 * The using model declares how many it accepts with a MEDIA_LIMIT constant.
 */
trait HasMedia
{
    /** Deleting the record must not leave its rows or its files behind. */
    protected static function bootHasMedia(): void
    {
        static::deleting(function ($model) {
            $model->media()->get()->each(function (Media $item) {
                Storage::disk('public')->delete($item->path);
                $item->delete();
            });
        });
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')->orderBy('position')->orderBy('id');
    }

    public function mediaLimit(): int
    {
        return static::MEDIA_LIMIT;
    }

    /** Falls back to the first image so a gallery is never left without a cover. */
    public function featuredMedia(): ?Media
    {
        return $this->media->firstWhere('is_featured', true) ?? $this->media->first();
    }

    public function featuredImageUrl(): ?string
    {
        return $this->featuredMedia()?->url();
    }

    /** The whole gallery with the featured image pulled to the front. */
    public function orderedMedia(): Collection
    {
        $featured = $this->featuredMedia();

        return $featured
            ? $this->media->reject(fn (Media $item) => $item->is($featured))->prepend($featured)->values()
            : $this->media;
    }

    /** Everything except the cover — what a gallery strip shows. */
    public function extraMedia(): Collection
    {
        return $this->orderedMedia()->skip(1)->values();
    }
}
