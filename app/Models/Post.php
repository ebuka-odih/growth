<?php

namespace App\Models;

use App\Models\Concerns\HasMedia;
use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasMedia, HasSlug;

    public const MEDIA_LIMIT = 3;

    protected $guarded = [];

    protected $with = ['media'];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('is_published', true)
            ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function scopeLatestFirst(Builder $q): Builder
    {
        return $q->orderByDesc('published_at')->orderByDesc('id');
    }

    public function coverUrl(): ?string
    {
        return $this->featuredImageUrl();
    }

    public function readingTime(): int
    {
        return max(1, (int) ceil(Str::wordCount(strip_tags((string) $this->body)) / 200));
    }
}
