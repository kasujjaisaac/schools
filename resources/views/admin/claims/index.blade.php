<x-layouts.admin title="Admin Claims">
    <section class="mx-auto max-w-7xl px-4 py-6 sm:px-5 lg:px-6">
        <div><p class="text-sm font-bold text-[#1d72b8]">Admin</p><h1 class="text-2xl font-bold text-[#082c56]">Profile Claims</h1></div>
        <x-admin-filters :statuses="['submitted', 'approved', 'rejected']" />
        <div class="mt-8 overflow-x-auto border border-[#c7d7ea] bg-white "><table class="w-full text-left text-sm"><thead class="bg-[#eef4fb]"><tr><th class="p-3">Claimant</th><th class="p-3">Institution</th><th class="p-3">Role</th><th class="p-3">Status</th><th class="p-3"></th></tr></thead><tbody>@forelse ($claims as $claim)<tr class="border-t border-[#d7e3f2]"><td class="p-3 font-semibold">{{ $claim->claimant_name }}</td><td class="p-3">{{ $claim->institution?->name }}</td><td class="p-3">{{ $claim->role_title }}</td><td class="p-3">{{ ucfirst($claim->status) }}</td><td class="p-3"><a href="{{ route('admin.claims.show', $claim) }}" class="font-semibold text-[#1d72b8]">Review</a></td></tr>@empty<tr><td colspan="8" class="px-6 py-12 text-center text-slate-500">No records found. Try another search or reset your filters.</td></tr>@endforelse</tbody></table></div>
        <div class="mt-8">{{ $claims->links() }}</div>
    </section>
</x-layouts.admin>
