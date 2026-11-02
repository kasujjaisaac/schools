<x-layouts.app :title="$programme->name">
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <p class="text-sm font-semibold text-[#1d72b8]">{{ $programme->field }}</p>
            <h1 class="mt-2 text-3xl font-bold">{{ $programme->name }}</h1>
            <p class="mt-4 text-[#4d463d]">{{ $programme->description }}</p>
            @if ($programme->career_prospects)<p class="mt-4 text-sm text-[#6b6256]">{{ $programme->career_prospects }}</p>@endif
        </div>
        <h2 class="mt-10 text-2xl font-bold">Institutions Offering This Programme</h2>
        <div class="mt-5 grid gap-5 md:grid-cols-3">
            @forelse ($programme->institutions as $institution)
                <x-institution-card :institution="$institution" />
            @empty
                <x-empty-state title="No institutions linked" message="Institutions offering this programme will appear after verification." />
            @endforelse
        </div>
    </section>
</x-layouts.app>
