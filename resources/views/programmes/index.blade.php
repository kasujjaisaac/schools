<x-layouts.app title="Programmes">
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">Programme Finder</h1>
        <form class="mt-6 flex gap-3 rounded-lg border border-[#ded6c8] bg-white p-4">
            <input name="q" value="{{ request('q') }}" class="min-w-0 flex-1 rounded-md border border-[#d9d2c3] px-3 py-2" placeholder="Search programme or field">
            <button class="rounded-md bg-[#1d72b8] px-4 py-2 font-semibold text-white">Search</button>
        </form>
        <div class="mt-8 grid gap-4 md:grid-cols-3">
            @forelse ($programmes as $programme)
                <a href="{{ route('programmes.show', $programme) }}" class="rounded-lg border border-[#ded6c8] bg-white p-5">
                    <span class="font-bold">{{ $programme->name }}</span>
                    <span class="mt-2 block text-sm text-[#6b6256]">{{ $programme->qualification ?? 'Qualification varies' }} · {{ $programme->institutions_count }} institutions</span>
                    <span class="mt-3 block text-sm">{{ $programme->field }}</span>
                </a>
            @empty
                <x-empty-state title="No programmes found" message="Try a broader search term." />
            @endforelse
        </div>
        <div class="mt-8">{{ $programmes->links() }}</div>
    </section>
</x-layouts.app>
