<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasSlug;

    protected $guarded = [];

    protected $casts = [
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

    /** @return list<string> */
    public function deliverableList(): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $this->deliverables))
            ->map(fn ($l) => trim($l))
            ->filter()
            ->values()
            ->all();
    }
}
