<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Cohort 1.0 participant',
                'role' => 'Personal Development',
                'company' => 'GrowSphere Community',
                'quote' => 'Three weeks changed how I plan my days. The accountability inside the community is the part that actually made it stick.',
            ],
            [
                'name' => 'SME founder',
                'role' => 'Retail',
                'company' => 'Branding client',
                'quote' => 'They did not just hand over a logo. We got a system, the reasoning behind it, and the confidence to apply it ourselves.',
            ],
            [
                'name' => 'Startup team lead',
                'role' => 'Product',
                'company' => 'Website & product design client',
                'quote' => 'Clear process, fast turnaround, and the site is structured the way our customers actually think.',
            ],
        ];

        foreach ($testimonials as $i => $t) {
            Testimonial::firstOrCreate(
                ['name' => $t['name'], 'quote' => $t['quote']],
                $t + ['position' => $i, 'is_published' => true],
            );
        }
    }
}
