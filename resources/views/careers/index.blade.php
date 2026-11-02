<x-layouts.app title="Careers">
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">Career Explorer</h1>
        <div class="mt-8 grid gap-4 md:grid-cols-3">
            @foreach ($careers as $career)
                <article class="rounded-lg border border-[#ded6c8] bg-white p-5">
                    <h2 class="font-bold">{{ $career->title }}</h2>
                    <p class="mt-2 text-sm text-[#6b6256]">{{ $career->summary }}</p>
                    <p class="mt-4 text-xs font-semibold text-[#1d72b8]">{{ $career->programmes->pluck('name')->join(', ') }}</p>
                </article>
            @endforeach
        </div>
        <div class="mt-8">{{ $careers->links() }}</div>
    </section>
</x-layouts.app>
