<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Editable settings, grouped for the form. Keys must match the settings table.
     *
     * @var array<string, array<string, array{label: string, type: string, help?: string}>>
     */
    private const GROUPS = [
        'Hero' => [
            'site_tagline' => ['label' => 'Eyebrow tagline', 'type' => 'text'],
            'hero_heading' => ['label' => 'Hero heading', 'type' => 'text'],
            'hero_highlight' => ['label' => 'Highlighted words', 'type' => 'text', 'help' => 'A phrase inside the heading to underline in brand purple.'],
            'hero_subheading' => ['label' => 'Hero paragraph', 'type' => 'textarea'],
        ],
        'Hero stats' => [
            'stat_one_value' => ['label' => 'Stat 1 value', 'type' => 'text'],
            'stat_one_label' => ['label' => 'Stat 1 label', 'type' => 'text'],
            'stat_two_value' => ['label' => 'Stat 2 value', 'type' => 'text'],
            'stat_two_label' => ['label' => 'Stat 2 label', 'type' => 'text'],
            'stat_three_value' => ['label' => 'Stat 3 value', 'type' => 'text'],
            'stat_three_label' => ['label' => 'Stat 3 label', 'type' => 'text'],
        ],
        'Story' => [
            'mission' => ['label' => 'Mission', 'type' => 'textarea'],
            'vision' => ['label' => 'Vision', 'type' => 'textarea'],
            'community_mission' => ['label' => 'Community mission', 'type' => 'textarea'],
            'founder_name' => ['label' => 'Founder name', 'type' => 'text'],
            'founder_role' => ['label' => 'Founder role', 'type' => 'text'],
            'founder_bio' => ['label' => 'Founder bio', 'type' => 'textarea'],
            'cohort_cadence' => ['label' => 'Cohort cadence note', 'type' => 'text'],
        ],
        'Substack' => [
            'substack_url' => ['label' => 'Substack URL', 'type' => 'url', 'help' => 'e.g. https://growspherecommunity.substack.com'],
            'substack_embed_url' => ['label' => 'Substack embed URL', 'type' => 'url', 'help' => 'Usually the Substack URL with /embed on the end. Clear this to hide every embed.'],
            'substack_blurb' => ['label' => 'Embed blurb', 'type' => 'textarea'],
        ],
        'Contact' => [
            'contact_email' => ['label' => 'Email', 'type' => 'text'],
            'contact_phone' => ['label' => 'Phone / WhatsApp', 'type' => 'text'],
            'contact_location' => ['label' => 'Location line', 'type' => 'text'],
        ],
        'Social links' => [
            'social_whatsapp' => ['label' => 'WhatsApp (direct chat)', 'type' => 'url', 'help' => 'A wa.me link to your number.'],
            'social_whatsapp_community' => ['label' => 'WhatsApp community invite', 'type' => 'url', 'help' => 'The chat.whatsapp.com group invite. Shown as a join button on the Community page.'],
            'social_instagram' => ['label' => 'Instagram', 'type' => 'url'],
            'social_linkedin' => ['label' => 'LinkedIn', 'type' => 'url'],
            'social_x' => ['label' => 'X (Twitter)', 'type' => 'url'],
            'social_youtube' => ['label' => 'YouTube', 'type' => 'url'],
        ],
    ];

    public function edit(): View
    {
        return view('admin.settings', [
            'groups' => self::GROUPS,
            'values' => Setting::cached(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $keys = collect(self::GROUPS)->flatMap(fn ($fields) => array_keys($fields))->all();

        $rules = [];
        foreach (self::GROUPS as $fields) {
            foreach ($fields as $key => $field) {
                $rules['settings.'.$key] = $field['type'] === 'url'
                    ? ['nullable', 'url', 'max:255']
                    : ['nullable', 'string', 'max:2000'];
            }
        }

        $validated = $request->validate($rules);
        $submitted = $validated['settings'] ?? [];

        foreach ($keys as $key) {
            Setting::put($key, $submitted[$key] ?? null);
        }

        return redirect()->route('admin.settings.edit')->with('status', 'Settings saved.');
    }
}
