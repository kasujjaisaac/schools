<x-layouts.admin title="Admin Education Jobs">
    <section class="mx-auto max-w-7xl px-4 py-6 sm:px-5 lg:px-6">
        <div class="flex flex-wrap items-center justify-between gap-4"><div><p class="text-sm font-bold text-[#1d72b8]">Admin</p><h1 class="text-2xl font-bold text-[#082c56]">Education Jobs</h1></div><a href="{{ route('admin.education-jobs.create') }}" class="bg-[#1d72b8] px-4 py-3 font-bold text-white">Add job</a></div>
        <x-admin-filters :statuses="['draft', 'published', 'archived']" />
        <div class="mt-8 overflow-x-auto border border-[#c7d7ea] bg-white "><table class="w-full text-left text-sm"><thead class="bg-[#eef4fb]"><tr><th class="p-3">Job</th><th class="p-3">Employer</th><th class="p-3">Deadline</th><th class="p-3">Status</th><th class="p-3"></th></tr></thead><tbody>@forelse ($jobs as $job)<tr class="border-t border-[#d7e3f2]"><td class="p-3 font-semibold">{{ $job->title }}</td><td class="p-3">{{ $job->institution?->name ?? $job->employer_name ?? 'Not set' }}</td><td class="p-3">{{ $job->deadline?->toFormattedDateString() ?? 'Rolling' }}</td><td class="p-3">{{ ucfirst($job->status) }}</td><td class="p-3"><a href="{{ route('admin.education-jobs.show', $job) }}" class="font-semibold text-[#1d72b8]">Open</a></td></tr>@empty<tr><td colspan="8" class="px-6 py-12 text-center text-slate-500">No records found. Try another search or reset your filters.</td></tr>@endforelse</tbody></table></div>
        <div class="mt-8">{{ $jobs->links() }}</div>
    </section>
</x-layouts.admin>
