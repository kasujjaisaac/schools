<x-layouts.app title="Locations">
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">Location Browsing</h1>
        <div class="mt-8 grid gap-4 md:grid-cols-3">
            @foreach ($locations as $location)
                <a href="{{ route('locations.show', $location) }}" class="rounded-lg border border-[#ded6c8] bg-white p-5">
                    <span class="font-bold">{{ $location->name }}</span>
                    <span class="mt-2 block text-sm text-[#6b6256]">{{ $location->institutions_count }} published institutions</span>
                </a>
            @endforeach
        </div>
    </section>
</x-layouts.app>
