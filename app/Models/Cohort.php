<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Cohort extends Model
{
    use HasSlug;

    public const STATUSES = ['upcoming', 'open', 'running', 'closed'];

    protected $guarded = [];

    protected $casts = [
        'starts_on' => 'date',
        'price' => 'decimal:2',
        'has_certificate' => 'boolean',
        'is_published' => 'boolean',
        'position' => 'integer',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('is_published', true);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('position')->orderBy('id');
    }

    public function scopeOpen(Builder $q): Builder
    {
        return $q->whereIn('status', ['upcoming', 'open']);
    }

    /** @return list<string> */
    public function curriculumList(): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $this->curriculum))
            ->map(fn ($l) => trim($l))
            ->filter()
            ->values()
            ->all();
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'open' => 'Enrolling now',
            'running' => 'In session',
            'closed' => 'Closed',
            default => 'Upcoming',
        };
    }

    public function isBookable(): bool
    {
        return in_array($this->status, ['upcoming', 'open'], true);
    }
}
