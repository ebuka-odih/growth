<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Cohort 1.0 — Personal Development is now enrolling',
                'category' => 'Announcement',
                'author' => 'GrowSphere Community',
                'excerpt' => 'Our foundation cohort opens again. Three weeks, a certificate, and a room of people building the same habits you are.',
                'body' => "Cohort 1.0 is the entry point to the GrowSphere Community. Over three weeks we work through the mindset and habits behind sustainable growth — self-awareness, goal setting, discipline systems and personal presence.\n\nEvery participant who completes the programme receives a certificate. Cohorts run once every two months, so if you miss this one the next intake is roughly eight weeks away.\n\nBook your place from the Community page, or join the waitlist for the next intake.",
            ],
            [
                'title' => 'Why your brand needs a system, not just a logo',
                'category' => 'Insight',
                'author' => 'GrowSphere Solutions',
                'excerpt' => 'A logo is one asset. A brand system is the set of rules that keeps every asset after it consistent.',
                'body' => "Most businesses that come to us already have a logo. What they do not have is a system: the palette, the type scale, the tone of voice and the rules for how it all gets applied.\n\nWithout that system, every new flyer, every new post and every new hire pulls the brand slightly further apart. Six months later nothing matches, and the market has no consistent impression of who you are.\n\nA brand system is what makes a small team look like a serious company. It is also what makes design work cheaper over time — because the decisions are already made.",
            ],
            [
                'title' => 'Growth is a sphere, not a ladder',
                'category' => 'Insight',
                'author' => 'GrowSphere Community',
                'excerpt' => 'Personal growth and financial growth are not separate tracks. The brand is built on that idea.',
                'body' => "GROW signifies progress, learning and transformation. SPHERE is a perfectly symmetrical shape, representing balance and unity — a closed, connected space.\n\nPut together, they describe how we think growth actually works: personal and financial growth nurtured in harmony, inside a tight-knit and supportive community, rather than climbed one rung at a time in isolation.\n\nThat is why the community and the agency sit under one roof. The skills we teach are the skills we practise for clients.",
            ],
        ];

        foreach ($posts as $i => $post) {
            Post::firstOrCreate(
                ['slug' => Str::slug($post['title'])],
                $post + [
                    'is_published' => true,
                    'published_at' => now()->subDays($i * 9 + 2),
                ],
            );
        }
    }
}
