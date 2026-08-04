<?php

namespace App\Models;

use App\Models\Concerns\HasMedia;
use App\Models\Concerns\HasSlug;
use App\Support\Url;
use App\Support\Video;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasMedia, HasSlug;

    public const MEDIA_LIMIT = 5;

    protected $guarded = [];

    protected $with = ['media'];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'position' => 'integer',
    ];

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('is_published', true);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('position')->orderByDesc('id');
    }

    public function imageUrl(): ?string
    {
        return $this->featuredImageUrl();
    }

    public function hasVideo(): bool
    {
        return Video::isSupported($this->video_url);
    }

    public function videoEmbedUrl(bool $autoplay = false): ?string
    {
        return Video::embedUrl($this->video_url, $autoplay);
    }

    public function websiteHost(): ?string
    {
        return Url::host($this->website_url);
    }
}
