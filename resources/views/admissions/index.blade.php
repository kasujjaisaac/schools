<x-layouts.app title="Admissions">
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">Admissions</h1>
        <form class="mt-6 grid gap-3 rounded-lg border border-[#ded6c8] bg-white p-4 sm:grid-cols-3">
            <select name="institution" class="rounded-md border border-[#d9d2c3] px-3 py-2"><option value="">All institutions</option>@foreach ($institutions as $institution)<option value="{{ $institution->id }}" @selected(request('institution') == $institution->id)>{{ $institution->name }}</option>@endforeach</select>
            <select name="status" class="rounded-md border border-[#d9d2c3] px-3 py-2"><option value="">Any status</option><option value="open" @selected(request('status') === 'open')>Open</option><option value="upcoming" @selected(request('status') === 'upcoming')>Upcoming</option><option value="closed" @selected(request('status') === 'closed')>Closed</option></select>
            <button class="rounded-md bg-[#1d72b8] px-4 py-2 font-semibold text-white">Filter</button>
        </form>
        <div class="mt-8 grid gap-4 md:grid-cols-2">
            @forelse ($admissions as $admission)
                <article class="rounded-lg border border-[#ded6c8] bg-white p-5">
                    <div class="flex justify-between gap-3"><h2 class="font-bold">{{ $admission->name }}</h2><span class="rounded-md bg-[#e8f1fb] px-2 py-1 text-xs font-semibold text-[#1d72b8]">{{ ucfirst($admission->status) }}</span></div>
                    <a href="{{ route('institutions.show', $admission->institution) }}" class="mt-2 block text-sm font-semibold text-[#1d72b8]">{{ $admission->institution->name }}</a>
                    <p class="mt-3 text-sm text-[#6b6256]">{{ $admission->description }}</p>
                    <p class="mt-3 text-sm font-semibold">Deadline: {{ $admission->closing_date?->toFormattedDateString() ?? 'To be confirmed' }}</p>
                </article>
            @empty
                <x-empty-state title="No admissions found" message="Admissions will appear when institutions publish intakes." />
            @endforelse
        </div>
        <div class="mt-8">{{ $admissions->links() }}</div>
    </section>
</x-layouts.app>
