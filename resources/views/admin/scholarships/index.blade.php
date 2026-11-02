<x-layouts.admin title="Admin Scholarships">
    <section class="mx-auto max-w-7xl px-4 py-6 sm:px-5 lg:px-6">
        <div class="flex flex-wrap items-center justify-between gap-4"><div><p class="text-sm font-bold text-[#1d72b8]">Admin</p><h1 class="text-2xl font-bold text-[#082c56]">Scholarships</h1></div><a href="{{ route('admin.scholarships.create') }}" class="bg-[#1d72b8] px-4 py-3 font-bold text-white">Add scholarship</a></div>
        <x-admin-filters :statuses="['draft', 'published', 'archived']" />
        <div class="mt-8 overflow-x-auto border border-[#c7d7ea] bg-white "><table class="w-full text-left text-sm"><thead class="bg-[#eef4fb]"><tr><th class="p-3">Scholarship</th><th class="p-3">Provider</th><th class="p-3">Deadline</th><th class="p-3">Status</th><th class="p-3"></th></tr></thead><tbody>@forelse ($scholarships as $scholarship)<tr class="border-t border-[#d7e3f2]"><td class="p-3 font-semibold">{{ $scholarship->title }}</td><td class="p-3">{{ $scholarship->provider }}</td><td class="p-3">{{ $scholarship->deadline?->toFormattedDateString() ?? 'Rolling' }}</td><td class="p-3">{{ ucfirst($scholarship->status) }}</td><td class="p-3"><a href="{{ route('admin.scholarships.show', $scholarship) }}" class="font-semibold text-[#1d72b8]">Open</a></td></tr>@empty<tr><td colspan="8" class="px-6 py-12 text-center text-slate-500">No records found. Try another search or reset your filters.</td></tr>@endforelse</tbody></table></div>
        <div class="mt-8">{{ $scholarships->links() }}</div>
    </section>
</x-layouts.admin>
