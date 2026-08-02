<?php

namespace Database\Seeders;

use App\Models\Cohort;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CohortSeeder extends Seeder
{
    public function run(): void
    {
        $cohorts = [
            [
                'code' => '1.0',
                'title' => 'Personal Development',
                'tagline' => 'Build the mindset and habits behind sustainable growth.',
                'description' => 'A three-week training on personal development — the foundation cohort of the GrowSphere Community. We work on self-awareness, discipline, goal setting and the daily systems that make growth repeatable rather than accidental.',
                'curriculum' => "Self-awareness and personal audit\nGoal setting that survives contact with real life\nHabits, discipline and accountability systems\nCommunication and personal presence\nBuilding a personal growth plan",
                'duration' => '3 weeks',
                'status' => 'open',
                'has_certificate' => true,
            ],
            [
                'code' => '2.0',
                'title' => 'Wealth Creation',
                'tagline' => 'A 3-week intensive on financial management.',
                'description' => 'An intensive on financial management: how money actually moves, how to make it from the platforms you already use, and how to keep it. Practical, not theoretical.',
                'curriculum' => "Financial management fundamentals\nHow to make money from social media\nStocks and market basics\nSavings, budgeting and personal cashflow\nBuilding multiple income streams",
                'duration' => '3 weeks',
                'status' => 'upcoming',
                'has_certificate' => true,
            ],
            [
                'code' => '3.0',
                'title' => 'Selling Like a Pro',
                'tagline' => 'Creating and marketing, capped with a live sales challenge.',
                'description' => 'A three-week intensive on creating and marketing an offer, ending in a live sales challenge. The best-performing participant receives an award; every participant receives a Certificate of Participation.',
                'curriculum' => "Building an offer people want\nPositioning and messaging\nMarketing channels that convert\nSales conversations and objection handling\nLive sales challenge and review",
                'duration' => '3 weeks',
                'status' => 'upcoming',
                'has_certificate' => true,
            ],
        ];

        foreach ($cohorts as $i => $cohort) {
            Cohort::firstOrCreate(
                ['slug' => Str::slug($cohort['title'])],
                $cohort + ['position' => $i, 'is_published' => true],
            );
        }
    }
}
