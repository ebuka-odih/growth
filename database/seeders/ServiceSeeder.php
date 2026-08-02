<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Brand Identity Creation',
                'icon' => 'sphere',
                'excerpt' => 'Logos, colour palettes, typography, style guides, messaging and full identity systems.',
                'description' => 'We build identity systems that hold up everywhere your brand shows up — from the logo mark to the way you talk about yourself. Every decision is documented so your team can apply it without us in the room.',
                'deliverables' => "Logo design\nBrand colour palette development\nTypography selection\nBrand style guides\nBrand messaging and positioning\nBrand naming and identity systems",
            ],
            [
                'title' => 'Graphic Design',
                'icon' => 'image',
                'excerpt' => 'Social media graphics, flyers, brochures, posters, event and print materials.',
                'description' => 'Day-to-day design that keeps your brand consistent and your calendar full — built from templates your team can actually reuse.',
                'deliverables' => "Social media graphics\nMarketing and promotional materials\nFlyers, brochures and posters\nOutdoor and print advertising materials\nEvent branding materials",
            ],
            [
                'title' => 'Website Design & Development',
                'icon' => 'monitor',
                'excerpt' => 'Business websites, maintenance, optimisation and content structuring.',
                'description' => 'Fast, accessible websites that are structured around how your customers actually buy — then maintained and optimised after launch.',
                'deliverables' => "Business website development\nWebsite maintenance and optimisation\nWebsite content structuring",
            ],
            [
                'title' => 'Product Design (UI/UX)',
                'icon' => 'phone',
                'excerpt' => 'Mobile and web app design, design systems and user research.',
                'description' => 'Research-led product design for teams shipping real software — interfaces, flows and a design system that scales with the roadmap.',
                'deliverables' => "Mobile app design\nWeb application design\nDesign systems development\nUser research",
            ],
            [
                'title' => 'Motion Graphics & Explainers',
                'icon' => 'play',
                'excerpt' => 'Animated brand content, explainer videos and product showcase videos.',
                'description' => 'Motion that explains the thing your static assets cannot — scripted, storyboarded and produced end to end.',
                'deliverables' => "Motion graphics design\nAnimated brand content\nExplainer videos\nProduct and service showcase videos",
            ],
            [
                'title' => 'Advertisement Creation',
                'icon' => 'send',
                'excerpt' => 'Social ads, digital campaign creative, outdoor, print and launch campaigns.',
                'description' => 'Campaign creative built to be tested — multiple concepts, sized for every placement, with the messaging logic written down.',
                'deliverables' => "Social media advertisements\nDigital campaign creativity\nOutdoor and print advertising materials\nProduct launch campaigns",
            ],
            [
                'title' => 'Marketing Strategy & Campaigns',
                'icon' => 'chart',
                'excerpt' => 'Strategy, campaign execution, audience targeting, lead generation and tracking.',
                'description' => 'The plan behind the creative: who you are talking to, what you are saying, where it runs and how you will know it worked.',
                'deliverables' => "Marketing strategy development\nCampaign planning and execution\nContent marketing strategy\nAudience targeting and segmentation\nPerformance tracking and optimisation\nBrand awareness campaigns\nDigital marketing support\nLead generation strategies",
            ],
            [
                'title' => 'Consultancy Services',
                'icon' => 'user',
                'excerpt' => 'Strategic branding consultation and business growth strategy sessions.',
                'description' => 'Working sessions for founders and teams who need direction before they need deliverables.',
                'deliverables' => "Strategic branding consultation\nBusiness growth strategy",
            ],
        ];

        foreach ($services as $i => $service) {
            Service::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($service['title'])],
                $service + ['position' => $i, 'is_published' => true],
            );
        }
    }
}
