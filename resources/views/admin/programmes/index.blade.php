<x-layouts.admin title="Admin Programmes">
    <section class="mx-auto max-w-7xl px-4 py-6 sm:px-5 lg:px-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm font-bold text-[#1d72b8]">Admin</p>
                <h1 class="text-2xl font-bold text-[#082c56]">Programmes</h1>
            </div>
            <a href="{{ route('admin.programmes.create') }}" class="bg-[#1d72b8] px-4 py-3 font-bold text-white">Add programme</a>
        </div>
        <x-admin-filters />
        <div class="mt-8 overflow-x-auto border border-[#c7d7ea] bg-white ">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#eef4fb]"><tr><th class="p-3">Programme</th><th class="p-3">Field</th><th class="p-3">Qualification</th><th class="p-3">Institutions</th><th class="p-3"></th></tr></thead>
                <tbody>
                    @forelse ($programmes as $programme)
                        <tr class="border-t border-[#d7e3f2]">
                            <td class="p-3 font-semibold">{{ $programme->name }}</td>
                            <td class="p-3">{{ $programme->field ?? 'Not set' }}</td>
                            <td class="p-3">{{ $programme->qualification ?? 'Not set' }}</td>
                            <td class="p-3">{{ $programme->institutions_count }}</td>
                            <td class="p-3"><a href="{{ route('admin.programmes.show', $programme) }}" class="font-semibold text-[#1d72b8]">Open</a></td>
                        </tr>
                    @empty<tr><td colspan="8" class="px-6 py-12 text-center text-slate-500">No records found. Try another search or reset your filters.</td></tr>@endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-8">{{ $programmes->links() }}</div>
    </section>
</x-layouts.admin>
