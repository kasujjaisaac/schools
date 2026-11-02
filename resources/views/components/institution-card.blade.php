@props(['institution'])

<article {{ $attributes->merge(['class' => 'group overflow-hidden border border-[#c7d7ea] bg-white shadow-sm transition hover:-translate-y-0.5 hover:border-[#9dbbe0] hover:shadow-md']) }}>
    <a href="{{ route('institutions.show', $institution) }}">
        <div class="relative aspect-[16/9] bg-[#dfe8e2]">
            @if ($institution->cover_image_url)
                <img src="{{ $institution->cover_image_url }}" alt="{{ $institution->name }} cover image" class="h-full w-full object-cover">
            @else
                <div class="grid h-full place-items-center bg-[#eef4fb] text-sm font-semibold text-[#1d72b8]">Study Greater Masaka</div>
            @endif

            @if ($institution->is_verified)
                <span class="absolute left-3 top-3 bg-white px-2 py-1 text-xs font-bold text-[#1d72b8] shadow-sm">Verified</span>
            @endif
        </div>
    </a>

    <div class="grid gap-4 p-5">
        <div>
            <a href="{{ route('institutions.show', $institution) }}" class="text-lg font-bold text-[#082c56] group-hover:text-[#1d72b8]">{{ $institution->name }}</a>
            <p class="mt-1 text-sm text-[#5d6b7c]">{{ $institution->location?->name ?? 'Location to be confirmed' }} &middot; {{ $institution->category?->name ?? 'Institution' }}</p>
        </div>

        @if ($institution->tagline)
            <p class="text-sm leading-6 text-[#4d5a68]">{{ $institution->tagline }}</p>
        @endif

        <div class="flex flex-wrap gap-2">
            @foreach ($institution->educationLevels->take(3) as $level)
                <span class="border border-[#c7d7ea] bg-[#eef4fb] px-2 py-1 text-xs font-semibold text-[#082c56]">{{ $level->name }}</span>
            @endforeach

            @if ($institution->educationLevels->count() > 3)
                <span class="border border-[#c7d7ea] px-2 py-1 text-xs font-semibold text-[#5d6b7c]">+{{ $institution->educationLevels->count() - 3 }}</span>
            @endif
        </div>

        <a href="{{ route('institutions.show', $institution) }}" class="border-t border-[#d7e3f2] pt-4 text-sm font-bold text-[#1d72b8]">View profile</a>
    </div>
</article>
