<x-layouts.app :title="'Institutions in '.$location->name">
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">Institutions in {{ $location->name }}</h1>
        <div class="mt-8 grid gap-5 md:grid-cols-3">
            @forelse ($institutions as $institution)
                <x-institution-card :institution="$institution" />
            @empty
                <x-empty-state title="No institutions found" message="This location has no published institutions yet." />
            @endforelse
        </div>
        <div class="mt-8">{{ $institutions->links() }}</div>
    </section>
</x-layouts.app>
