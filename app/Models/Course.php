<?php

namespace App\Models;

use App\Models\Concerns\HasMedia;
use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasMedia, HasSlug;

    public const LEVELS = ['Foundation', 'Advanced'];

    public const MEDIA_LIMIT = 3;

    protected $guarded = [];

    protected $with = ['media'];

    protected $casts = [
        'price' => 'decimal:2',
        'is_published' => 'boolean',
        'position' => 'integer',
    ];

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('is_published', true);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('position')->orderBy('id');
    }

    public function imageUrl(): ?string
    {
        return $this->featuredImageUrl();
    }

    /** @return list<string> */
    public function outcomeList(): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $this->outcomes))
            ->map(fn ($l) => trim($l))
            ->filter()
            ->values()
            ->all();
    }
}
