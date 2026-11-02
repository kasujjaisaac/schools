<x-layouts.admin title="Admin Guides">
    <section class="mx-auto max-w-7xl px-4 py-6 sm:px-5 lg:px-6">
        <div class="flex flex-wrap items-center justify-between gap-4"><div><p class="text-sm font-bold text-[#1d72b8]">Admin</p><h1 class="text-2xl font-bold text-[#082c56]">Guides</h1></div><a href="{{ route('admin.articles.create') }}" class="bg-[#1d72b8] px-4 py-3 font-bold text-white">Add guide</a></div>
        <x-admin-filters :statuses="['draft', 'published', 'archived']" />
        <div class="mt-8 overflow-x-auto border border-[#c7d7ea] bg-white "><table class="w-full text-left text-sm"><thead class="bg-[#eef4fb]"><tr><th class="p-3">Guide</th><th class="p-3">Category</th><th class="p-3">Published</th><th class="p-3">Status</th><th class="p-3"></th></tr></thead><tbody>@forelse ($articles as $article)<tr class="border-t border-[#d7e3f2]"><td class="p-3 font-semibold">{{ $article->title }}</td><td class="p-3">{{ $article->category }}</td><td class="p-3">{{ $article->published_at?->toFormattedDateString() ?? 'Not set' }}</td><td class="p-3">{{ ucfirst($article->status) }}</td><td class="p-3"><a href="{{ route('admin.articles.show', $article) }}" class="font-semibold text-[#1d72b8]">Open</a></td></tr>@empty<tr><td colspan="8" class="px-6 py-12 text-center text-slate-500">No records found. Try another search or reset your filters.</td></tr>@endforelse</tbody></table></div>
        <div class="mt-8">{{ $articles->links() }}</div>
    </section>
</x-layouts.admin>
