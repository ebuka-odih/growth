@php
    use App\Models\Setting;

    $type = old('type', $presetType);
    $inputClass =
        'w-full rounded-xl border border-deep/15 bg-white px-4 py-3 text-[0.94rem] text-ink transition placeholder:text-muted/50 focus:border-violet focus:outline-none';
    $labelClass = 'block text-[0.72rem] font-semibold uppercase tracking-[0.14em] text-deep';
@endphp

<x-layouts.site title="Contact" description="Tell us about your project, book a cohort, or request one-on-one mentorship.">
    <x-page-header eyebrow="Get in touch" title="Tell us what you're building.">
        Start a project, book a place in the next cohort, or request one-on-one mentorship. We reply within 24 hours.
    </x-page-header>

    <section class="py-20 lg:py-24">
        <div class="mx-auto grid max-w-6xl gap-14 px-6 lg:grid-cols-[1.35fr_1fr]">
            <div class="reveal">
                @if ($errors->any())
                    <div class="mb-8 rounded-xl border border-violet/30 bg-lilac px-5 py-4">
                        <p class="text-sm font-semibold text-deep">Please fix the following:</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-deep/80">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                    @csrf

                    <fieldset>
                        <legend class="{{ $labelClass }}">What can we help with?</legend>
                        <div class="mt-3 grid gap-2.5 sm:grid-cols-2">
                            @foreach ([['project', 'Start a project', 'Branding, web, product, motion or campaign work'], ['cohort', 'Book a cohort', 'Join a 3-week community training programme'], ['mentorship', '1-on-1 mentorship', 'Personalised guidance sessions'], ['course', 'Skill course', 'Graphic, motion or website design courses']] as [$value, $label, $hint])
                                <label
                                    class="flex cursor-pointer gap-3 rounded-xl border border-deep/15 bg-white p-4 transition has-[:checked]:border-violet has-[:checked]:bg-lilac-soft">
                                    <input type="radio" name="type" value="{{ $value }}"
                                        @checked($type === $value) class="mt-1 accent-[#9900CC]">
                                    <span>
                                        <span class="block text-[0.92rem] font-semibold text-deep-900">{{ $label }}</span>
                                        <span class="mt-0.5 block text-xs leading-relaxed text-muted">{{ $hint }}</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="name" class="{{ $labelClass }}">Name *</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                class="mt-2 {{ $inputClass }}" placeholder="Your full name">
                        </div>
                        <div>
                            <label for="email" class="{{ $labelClass }}">Email *</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                class="mt-2 {{ $inputClass }}" placeholder="you@email.com">
                        </div>
                        <div>
                            <label for="phone" class="{{ $labelClass }}">Phone / WhatsApp</label>
                            <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                                class="mt-2 {{ $inputClass }}" placeholder="Optional">
                        </div>
                        <div>
                            <label for="company" class="{{ $labelClass }}">Company / brand</label>
                            <input id="company" type="text" name="company" value="{{ old('company') }}"
                                class="mt-2 {{ $inputClass }}" placeholder="Optional">
                        </div>
                    </div>

                    @if ($cohorts->isNotEmpty())
                        <div>
                            <label for="cohort_id" class="{{ $labelClass }}">Which cohort?</label>
                            <select id="cohort_id" name="cohort_id" class="mt-2 {{ $inputClass }}">
                                <option value="">No preference / next available</option>
                                @foreach ($cohorts as $cohort)
                                    <option value="{{ $cohort->id }}"
                                        @selected((string) old('cohort_id', $presetCohort) === (string) $cohort->id)>
                                        {{ $cohort->code ? $cohort->code . ' — ' : '' }}{{ $cohort->title }}
                                        ({{ $cohort->statusLabel() }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-xs text-muted">Only applied when "Book a cohort" is selected.</p>
                        </div>
                    @endif

                    @if ($courses->isNotEmpty())
                        <div>
                            <label for="course_id" class="{{ $labelClass }}">Which course?</label>
                            <select id="course_id" name="course_id" class="mt-2 {{ $inputClass }}">
                                <option value="">No preference</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        @selected((string) old('course_id', $presetCourse) === (string) $course->id)>
                                        {{ $course->title }} ({{ $course->level }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-xs text-muted">Only applied when "Skill course" is selected.</p>
                        </div>
                    @endif

                    <div>
                        <label for="subject" class="{{ $labelClass }}">Subject</label>
                        <input id="subject" type="text" name="subject"
                            value="{{ old('subject', request('subject')) }}" class="mt-2 {{ $inputClass }}"
                            placeholder="e.g. Brand identity for a new fintech">
                    </div>

                    <div>
                        <label for="message" class="{{ $labelClass }}">Message *</label>
                        <textarea id="message" name="message" rows="6" required class="mt-2 {{ $inputClass }}"
                            placeholder="Tell us about your business, your goals and your timeline.">{{ old('message') }}</textarea>
                    </div>

                    {{-- Honeypot --}}
                    <div class="hidden" aria-hidden="true">
                        <label for="website">Leave this field empty</label>
                        <input id="website" type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <x-button variant="accent" type="submit">Send message</x-button>
                </form>
            </div>

            <aside class="reveal space-y-5">
                <div class="rounded-[var(--radius-brand)] bg-deep p-8 text-white">
                    <x-eyebrow tone="light">Direct</x-eyebrow>
                    <ul class="mt-5 space-y-4 text-[0.94rem]">
                        @if (Setting::get('contact_email'))
                            <li>
                                <span class="block text-xs text-lilac/60">Email</span>
                                <a href="mailto:{{ Setting::get('contact_email') }}" class="hover:text-violet">
                                    {{ Setting::get('contact_email') }}
                                </a>
                            </li>
                        @endif
                        @if (Setting::get('contact_phone'))
                            <li>
                                <span class="block text-xs text-lilac/60">Phone / WhatsApp</span>
                                <a href="tel:{{ Setting::get('contact_phone') }}" class="hover:text-violet">
                                    {{ Setting::get('contact_phone') }}
                                </a>
                            </li>
                        @endif
                        @if (Setting::get('contact_location'))
                            <li>
                                <span class="block text-xs text-lilac/60">Where we work</span>
                                {{ Setting::get('contact_location') }}
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="rounded-[var(--radius-brand)] border border-deep/10 bg-white p-8">
                    <h2 class="text-[1rem] font-semibold text-deep-900">What happens next</h2>
                    <ol class="mt-4 space-y-3.5">
                        @foreach (['We read your message and reply within 24 hours.', 'We book a strategic consultation to understand your goals.', 'You get a scoped proposal — or a place in the next cohort.'] as $i => $step)
                            <li class="flex gap-3 text-[0.92rem] text-ink">
                                <span
                                    class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-lilac font-display text-[0.65rem] text-deep">
                                    {{ $i + 1 }}
                                </span>
                                {{ $step }}
                            </li>
                        @endforeach
                    </ol>
                </div>

                <x-substack-embed compact heading="Follow along on Substack" :height="260" />
            </aside>
        </div>
    </section>
</x-layouts.site>
