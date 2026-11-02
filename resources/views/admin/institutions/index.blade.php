<x-layouts.admin title="Admin Institutions">
    <section class="mx-auto max-w-7xl px-4 py-6 sm:px-5 lg:px-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-2xl font-bold">Admin Institutions</h1>
            <a href="{{ route('admin.institutions.create') }}" class="rounded-none bg-[#1d72b8] px-4 py-3 font-bold text-white">Add institution</a>
        </div>
        <x-admin-filters :statuses="['draft', 'pending', 'published', 'archived']" />
        <div class="mt-8 overflow-x-auto rounded-none border border-[#ded6c8] bg-white">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#f7f4ed]"><tr><th class="p-3">Institution</th><th class="p-3">Location</th><th class="p-3">Status</th><th class="p-3">Leads</th><th class="p-3">Claims</th><th class="p-3"></th></tr></thead>
                <tbody>
                    @forelse ($institutions as $institution)
                        <tr class="border-t border-[#ded6c8]">
                            <td class="p-3 font-semibold">{{ $institution->name }}</td>
                            <td class="p-3">{{ $institution->location?->name }}</td>
                            <td class="p-3">{{ ucfirst($institution->status) }}{{ $institution->is_verified ? ' · verified' : '' }}</td>
                            <td class="p-3">{{ $institution->enquiries_count }}</td>
                            <td class="p-3">{{ $institution->claims_count }}</td>
                            <td class="p-3"><a href="{{ route('admin.institutions.show', $institution) }}" class="font-semibold text-[#1d72b8]">Open</a></td>
                        </tr>
                    @empty<tr><td colspan="8" class="px-6 py-12 text-center text-slate-500">No records found. Try another search or reset your filters.</td></tr>@endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-8">{{ $institutions->links() }}</div>
    </section>
</x-layouts.admin>
