<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'site_tagline' => 'Branding · Growth · Creative Media',
            'hero_heading' => 'We build brands that grow beyond their market.',
            'hero_highlight' => 'grow beyond',
            'hero_subheading' => 'GrowSphere Solutions helps individuals, startups and SMEs build impactful brands, improve business performance and achieve sustainable growth — from identity to launch.',

            'stat_one_value' => '8+',
            'stat_one_label' => 'Service lines',
            'stat_two_value' => '3',
            'stat_two_label' => 'Training cohorts',
            'stat_three_value' => 'Africa',
            'stat_three_label' => '& worldwide reach',

            'mission' => 'To empower businesses and individuals with innovative branding, consulting and digital solutions that drive growth, visibility, profitability and long-term success.',
            'vision' => "To become Africa's leading growth and business solutions company, recognised for delivering exceptional branding, consulting, technology and business development services.",
            'community_mission' => 'To educate, inspire and support individuals on their personal growth and financial journey — providing resources, guidance and community to help them overcome obstacles, build resilience and unlock their true potential.',
            'founder_name' => 'Adukwu Helen',
            'founder_role' => 'Founder, GrowSphere',
            'founder_bio' => 'Adukwu Helen is a visionary driven by value and the founder of GrowSphere, a brand dedicated to personal development, growth and financial growth. Her leadership style is rooted in authenticity, collaboration and a strong belief in the power of community to drive meaningful change.',

            'contact_email' => 'growspheresolutions2@gmail.com',
            'contact_phone' => '08146872417',
            'contact_location' => 'Remote-first · Africa & worldwide',

            'substack_url' => 'https://growspherecommunity.substack.com',
            'substack_embed_url' => 'https://growspherecommunity.substack.com/embed',
            'substack_blurb' => 'Growth notes, cohort announcements and practical playbooks — straight from the GrowSphere Community.',

            'social_whatsapp' => 'https://wa.me/2348146872417',
            'social_instagram' => 'https://www.instagram.com/growsphere_officiall',
            'social_linkedin' => 'https://www.linkedin.com/company/growsphere-community/',
            'social_x' => 'https://x.com/growsphere0',
            'social_youtube' => '',

            'cohort_cadence' => 'Cohorts run once every 2 months.',
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
