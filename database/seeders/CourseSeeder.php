<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'title' => 'Graphic Design Foundations',
                'category' => 'Graphic Design',
                'level' => 'Foundation',
                'summary' => 'Learn the craft behind social graphics, flyers and brand collateral — from layout to export.',
                'description' => 'A self-paced course covering the fundamentals of graphic design: composition, colour, type and the production skills you need to deliver client-ready files. Includes tutorials and downloadable resources.',
                'outcomes' => "Design principles: layout, hierarchy, contrast\nWorking with colour and type systems\nBuilding reusable social media templates\nPreparing files for print and digital\nPortfolio piece review",
                'format' => 'Self-paced · Tutorials & resources',
            ],
            [
                'title' => 'Advanced Graphic Design',
                'category' => 'Graphic Design',
                'level' => 'Advanced',
                'summary' => 'For designers who can already execute — this is about art direction and client work.',
                'description' => 'The advanced tier. Art direction, brand systems, pitching work and running a design engagement from brief to handover.',
                'outcomes' => "Art direction and concept development\nBuilding a full brand system\nPresenting and defending design work\nPricing and scoping client projects",
                'format' => 'Advanced tier',
            ],
            [
                'title' => 'Motion Design',
                'category' => 'Motion Design',
                'level' => 'Foundation',
                'summary' => 'Animate brand content, explainers and product showcases that hold attention.',
                'description' => 'From keyframes to a finished explainer. Learn timing, easing and storytelling for short-form brand motion, plus the export settings that keep quality on every platform.',
                'outcomes' => "Motion principles: timing, easing, anticipation\nAnimating logos and brand elements\nStoryboarding an explainer video\nSound, pacing and edit rhythm\nExporting for social and web",
                'format' => 'Self-paced · Tutorials & resources',
            ],
            [
                'title' => 'Website Design',
                'category' => 'Website Design',
                'level' => 'Foundation',
                'summary' => 'Design and ship real business websites — structure, layout and launch.',
                'description' => 'Covers how to structure a business website around what customers need, design it responsively and get it live. Practical, project-based, with resources you keep.',
                'outcomes' => "Information architecture and content structuring\nResponsive layout and design systems\nDesigning for conversion\nHandover, launch and maintenance basics",
                'format' => 'Self-paced · Tutorials & resources',
            ],
        ];

        foreach ($courses as $i => $course) {
            Course::firstOrCreate(
                ['slug' => Str::slug($course['title'])],
                $course + ['position' => $i, 'is_published' => true],
            );
        }
    }
}
