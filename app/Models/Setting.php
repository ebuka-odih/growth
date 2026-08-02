<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    /**
     * Shipped values for every editable setting.
     *
     * These are the single source of truth: the seeder writes them into a new
     * database, and they are also the runtime fallback, so a deployment that
     * has never been seeded still renders correct content. Anything saved in
     * the admin overrides the value here.
     *
     * @var array<string, string>
     */
    public const DEFAULTS = [
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
        'social_whatsapp_community' => 'https://chat.whatsapp.com/KORoXIUtRofH8HONLFZzl9',
        'social_instagram' => 'https://www.instagram.com/growsphere_officiall',
        'social_linkedin' => 'https://www.linkedin.com/company/growsphere-community/',
        'social_x' => 'https://x.com/growsphere0',
        'social_youtube' => '',

        'cohort_cadence' => 'Cohorts run once every 2 months.',
    ];

    protected $guarded = [];

    public $timestamps = true;

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings.all'));
        static::deleted(fn () => Cache::forget('settings.all'));
    }

    /**
     * Raw stored values, straight from the database.
     *
     * @return array<string, string|null>
     */
    public static function cached(): array
    {
        return Cache::rememberForever('settings.all', fn () => static::query()->pluck('value', 'key')->all());
    }

    /**
     * Stored values layered over the shipped defaults.
     *
     * @return array<string, string|null>
     */
    public static function resolved(): array
    {
        $stored = array_filter(static::cached(), fn ($value) => filled($value));

        return array_merge(self::DEFAULTS, $stored);
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        $value = static::cached()[$key] ?? null;

        if (filled($value)) {
            return $value;
        }

        return self::DEFAULTS[$key] ?? $default;
    }

    public static function put(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
