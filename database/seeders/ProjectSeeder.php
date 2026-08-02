<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Brand identity — Fintech startup',
                'client' => 'Confidential',
                'category' => 'Brand Identity',
                'disciplines' => 'Logo · Style guide · Messaging',
                'year' => '2025',
                'summary' => 'A full identity system for an early-stage fintech: mark, palette, type scale and a messaging framework the team could apply without a designer.',
            ],
            [
                'title' => 'E-commerce website — Retail SME',
                'client' => 'Confidential',
                'category' => 'Website',
                'disciplines' => 'Web design · Development',
                'year' => '2025',
                'summary' => 'Storefront rebuild focused on structure and speed, with a content model the client owns and updates themselves.',
            ],
            [
                'title' => 'Explainer video — SaaS product',
                'client' => 'Confidential',
                'category' => 'Motion',
                'disciplines' => 'Motion graphics · Script',
                'year' => '2025',
                'summary' => 'Script, storyboard and animated explainer built to carry the product story across landing page, sales deck and paid social.',
            ],
            [
                'title' => 'Launch campaign — Consumer brand',
                'client' => 'Confidential',
                'category' => 'Campaign',
                'disciplines' => 'Ads · Social · Print',
                'year' => '2024',
                'summary' => 'Multi-channel launch: campaign concept, ad creative sized for every placement, and print collateral for retail.',
            ],
            [
                'title' => 'Mobile app UI — Logistics platform',
                'client' => 'Confidential',
                'category' => 'Product Design',
                'disciplines' => 'UI/UX · Design system',
                'year' => '2024',
                'summary' => 'End-to-end product design for a logistics app, delivered with a component library the engineering team builds against.',
            ],
            [
                'title' => 'Personal brand kit — Creator',
                'client' => 'Confidential',
                'category' => 'Brand Identity',
                'disciplines' => 'Identity · Content templates',
                'year' => '2024',
                'summary' => 'A lightweight identity and content template set for a creator publishing daily across three platforms.',
            ],
        ];

        foreach ($projects as $i => $project) {
            Project::firstOrCreate(
                ['slug' => Str::slug($project['title'])],
                $project + [
                    'position' => $i,
                    'is_published' => true,
                    'is_featured' => $i < 3,
                ],
            );
        }
    }
}
