<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasSlug;

    public const LEVELS = ['Foundation', 'Advanced'];

    protected $guarded = [];

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
        return $this->image ? Storage::url($this->image) : null;
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
