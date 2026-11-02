<x-layouts.app title="Education Jobs">
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">Education Jobs</h1>
        <div class="mt-8 grid gap-4 md:grid-cols-2">
            @foreach ($jobs as $job)
                <article class="rounded-lg border border-[#ded6c8] bg-white p-5">
                    <h2 class="font-bold">{{ $job->title }}</h2>
                    <p class="mt-1 text-sm font-semibold text-[#1d72b8]">{{ $job->institution?->name ?? $job->employer_name }}</p>
                    <p class="mt-3 text-sm text-[#6b6256]">{{ $job->description }}</p>
                    <p class="mt-3 text-sm">Deadline: {{ $job->deadline?->toFormattedDateString() ?? 'To be confirmed' }}</p>
                </article>
            @endforeach
        </div>
        <div class="mt-8">{{ $jobs->links() }}</div>
    </section>
</x-layouts.app>
