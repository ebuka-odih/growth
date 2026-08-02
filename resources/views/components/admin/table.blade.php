@props(['headers' => []])

{{-- Card list below md (see .admin-table in app.css), scrollable table from md up. --}}
<div
    {{ $attributes->merge(['class' => 'md:overflow-x-auto md:rounded-2xl md:border md:border-deep/10 md:bg-white']) }}>
    <table class="admin-table w-full text-left md:min-w-[640px]">
        <thead class="border-b border-deep/10 bg-lilac-soft">
            <tr>
                @foreach ($headers as $header)
                    <th
                        class="px-5 py-3.5 text-[0.68rem] font-semibold tracking-[0.13em] text-deep uppercase {{ $loop->last ? 'text-right' : '' }}">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-deep/8">
            {{ $slot }}
        </tbody>
    </table>
</div>
