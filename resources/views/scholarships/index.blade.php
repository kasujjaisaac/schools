<x-layouts.app title="Scholarships">
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">Scholarships</h1>
        <div class="mt-8 grid gap-4 md:grid-cols-2">
            @foreach ($scholarships as $scholarship)
                <article class="rounded-lg border border-[#ded6c8] bg-white p-5">
                    <h2 class="font-bold">{{ $scholarship->title }}</h2>
                    <p class="mt-1 text-sm font-semibold text-[#1d72b8]">{{ $scholarship->provider }}</p>
                    <p class="mt-3 text-sm text-[#6b6256]">{{ $scholarship->description }}</p>
                    <p class="mt-3 text-sm">Deadline: {{ $scholarship->deadline?->toFormattedDateString() ?? 'Rolling or to be confirmed' }}</p>
                </article>
            @endforeach
        </div>
        <div class="mt-8">{{ $scholarships->links() }}</div>
    </section>
</x-layouts.app>
