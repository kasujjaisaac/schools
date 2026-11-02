<x-layouts.admin title="Admin Admissions">
    <section class="mx-auto max-w-7xl px-4 py-6 sm:px-5 lg:px-6">
        <div class="flex flex-wrap items-center justify-between gap-4"><div><p class="text-sm font-bold text-[#1d72b8]">Admin</p><h1 class="text-2xl font-bold text-[#082c56]">Admissions</h1></div><a href="{{ route('admin.admissions.create') }}" class="bg-[#1d72b8] px-4 py-3 font-bold text-white">Add intake</a></div>
        <x-admin-filters :statuses="['open', 'closed', 'draft']" />
        <div class="mt-8 overflow-x-auto border border-[#c7d7ea] bg-white "><table class="w-full text-left text-sm"><thead class="bg-[#eef4fb]"><tr><th class="p-3">Intake</th><th class="p-3">Institution</th><th class="p-3">Closes</th><th class="p-3">Status</th><th class="p-3"></th></tr></thead><tbody>@forelse ($admissions as $admission)<tr class="border-t border-[#d7e3f2]"><td class="p-3 font-semibold">{{ $admission->name }}</td><td class="p-3">{{ $admission->institution?->name }}</td><td class="p-3">{{ $admission->closing_date?->toFormattedDateString() ?? 'When filled' }}</td><td class="p-3">{{ ucfirst($admission->status) }}</td><td class="p-3"><a href="{{ route('admin.admissions.show', $admission) }}" class="font-semibold text-[#1d72b8]">Open</a></td></tr>@empty<tr><td colspan="8" class="px-6 py-12 text-center text-slate-500">No records found. Try another search or reset your filters.</td></tr>@endforelse</tbody></table></div>
        <div class="mt-8">{{ $admissions->links() }}</div>
    </section>
</x-layouts.admin>
