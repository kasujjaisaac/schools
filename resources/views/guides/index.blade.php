<x-layouts.app title="Guides">
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">Education Guides</h1>
        <div class="mt-8 grid gap-4 md:grid-cols-3">
            @foreach ($articles as $article)
                <article class="rounded-lg border border-[#ded6c8] bg-white p-5">
                    <p class="text-xs font-semibold text-[#1d72b8]">{{ $article->category }}</p>
                    <h2 class="mt-2 font-bold">{{ $article->title }}</h2>
                    <p class="mt-3 text-sm text-[#6b6256]">{{ $article->excerpt }}</p>
                </article>
            @endforeach
        </div>
        <div class="mt-8">{{ $articles->links() }}</div>
    </section>
</x-layouts.app>
