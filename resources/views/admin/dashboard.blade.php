<x-layouts.admin title="Overview">
    <section class="mx-auto max-w-7xl px-4 py-6 sm:px-5 lg:px-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div><p class="text-xs font-bold uppercase tracking-widest text-[#1d72b8]">Your platform at a glance</p><h1 class="mt-2 text-2xl font-bold tracking-tight text-[#082c56]">Management Dashboard</h1><p class="mt-2 text-sm text-slate-500">Keep education information current. Help learners find their next step.</p></div>
            <a href="{{ route('admin.institutions.create') }}" class="rounded-none bg-[#082c56] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#1d72b8]">+ Add institution</a>
        </div>
        <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['Institutions', $institutionCount, 'admin.institutions.index', $publishedInstitutionCount.' published'],
                ['Programmes', $programmeCount, 'admin.programmes.index', 'Education pathways'],
                ['New enquiries', $newEnquiryCount, 'admin.enquiries.index', 'Awaiting follow-up'],
                ['Pending claims', $submittedClaimCount, 'admin.claims.index', 'Awaiting review'],
            ] as [$label, $count, $route, $description])
                <a href="{{ route($route) }}" class="group rounded-none border border-slate-200 bg-white p-4  transition hover:border-blue-300">
                    <div class="flex items-center justify-between"><p class="text-xs font-semibold text-slate-500">{{ $label }}</p><span class="text-slate-300 group-hover:text-[#1d72b8]" aria-hidden="true">↗</span></div><p class="mt-3 text-3xl font-bold tracking-tight text-[#082c56]">{{ number_format($count) }}</p><p class="mt-2 text-xs text-slate-500">{{ $description }}</p>
                </a>
            @endforeach
        </div>
        <div class="mt-5 flex flex-wrap items-center justify-between gap-4 rounded-none border border-amber-200 bg-amber-50 px-4 py-3">
            <div><p class="text-sm font-bold text-[#082c56]">Review queue</p><p class="mt-1 text-xs text-slate-600">{{ $pendingInstitutionCount }} institutions pending publication · {{ $submittedClaimCount }} profile claims awaiting review</p></div>
            <div class="flex flex-wrap gap-3 text-xs font-bold text-[#1d72b8]"><a href="{{ route('admin.institutions.index', ['status' => 'pending']) }}">Review institutions →</a><a href="{{ route('admin.claims.index', ['status' => 'submitted']) }}">Review claims →</a></div>
        </div>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <section class="overflow-hidden rounded-none border border-slate-200 bg-white xl:col-span-2">
                <div class="flex items-center justify-between border-b border-slate-100 p-4"><div><h2 class="font-bold text-[#082c56]">Latest institutions</h2><p class="mt-1 text-xs text-slate-500">Recently added school and college profiles</p></div><a href="{{ route('admin.institutions.index') }}" class="text-xs font-bold text-[#1d72b8]">View all →</a></div>
                <div class="overflow-x-auto"><table class="w-full text-left text-sm"><thead class="bg-slate-50 text-xs text-slate-500"><tr><th class="px-4 py-2.5">Institution</th><th class="px-4 py-2.5">Location</th><th class="px-4 py-2.5">Status</th></tr></thead><tbody class="divide-y divide-slate-100">
                    @forelse ($recentInstitutions as $institution)
                        <tr><td class="px-4 py-3"><a href="{{ route('admin.institutions.show', $institution) }}" class="font-semibold text-[#082c56] hover:text-[#1d72b8]">{{ $institution->name }}</a><p class="mt-1 text-xs text-slate-400">{{ $institution->category?->name }}</p></td><td class="px-4 py-3 text-xs text-slate-500">{{ $institution->location?->name ?? 'Not set' }}</td><td class="px-4 py-3"><span class="rounded-none px-2.5 py-1 text-xs font-semibold {{ $institution->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">{{ ucfirst($institution->status) }}</span></td></tr>
                    @empty
                        <tr><td colspan="3" class="px-5 py-12 text-center text-slate-500">No institutions yet. Add your first institution to get started.</td></tr>
                    @endforelse
                </tbody></table></div>
            </section>
            <section class="rounded-none bg-[#082c56] p-4 text-white">
                <p class="text-[10px] font-bold uppercase tracking-widest text-blue-200">Build your directory</p><h2 class="mt-3 text-xl font-bold">Next actions</h2><p class="mt-2 text-xs leading-6 text-slate-300">Publish useful information, connect programmes to institutions, and keep opportunities up to date.</p>
                <div class="mt-5 grid divide-y divide-white/10 text-sm font-semibold">@foreach ([['Add a programme', 'admin.programmes.create'], ['Create an admission intake', 'admin.admissions.create'], ['Post a scholarship', 'admin.scholarships.create'], ['Write an education guide', 'admin.articles.create']] as [$label, $route])<a href="{{ route($route) }}" class="flex items-center justify-between py-3 hover:text-[#f2b705]">{{ $label }}<span aria-hidden="true">+</span></a>@endforeach</div>
            </section>
        </div>
        <div class="mt-5 grid gap-4 xl:grid-cols-2">
            <section class="rounded-none border border-slate-200 bg-white p-4"><div class="flex items-center justify-between"><h2 class="font-bold text-[#082c56]">Recent enquiries</h2><a href="{{ route('admin.enquiries.index') }}" class="text-xs font-bold text-[#1d72b8]">View all →</a></div><div class="mt-4 divide-y divide-slate-100">
                @forelse ($recentEnquiries as $enquiry)<a href="{{ route('admin.enquiries.show', $enquiry) }}" class="flex items-center justify-between gap-4 py-4"><div><p class="text-sm font-semibold">{{ $enquiry->name }}</p><p class="mt-1 text-xs text-slate-500">{{ $enquiry->institution?->name }}</p></div><span class="rounded-none bg-slate-100 px-3 py-1 text-xs text-slate-600">{{ ucfirst($enquiry->status) }}</span></a>@empty<p class="py-10 text-center text-sm text-slate-500">Public enquiries will appear here.</p>@endforelse
            </div></section>
            <section class="rounded-none border border-slate-200 bg-white p-4"><div class="flex items-center justify-between"><h2 class="font-bold text-[#082c56]">Recent profile claims</h2><a href="{{ route('admin.claims.index') }}" class="text-xs font-bold text-[#1d72b8]">View all →</a></div><div class="mt-4 divide-y divide-slate-100">
                @forelse ($recentClaims as $claim)<a href="{{ route('admin.claims.show', $claim) }}" class="flex items-center justify-between gap-4 py-4"><div><p class="text-sm font-semibold">{{ $claim->claimant_name }}</p><p class="mt-1 text-xs text-slate-500">{{ $claim->institution?->name }}</p></div><span class="rounded-none bg-slate-100 px-3 py-1 text-xs text-slate-600">{{ ucfirst($claim->status) }}</span></a>@empty<p class="py-10 text-center text-sm text-slate-500">Profile claim requests will appear here.</p>@endforelse
            </div></section>
        </div>
        <div class="mt-5 grid grid-cols-2 gap-3 md:grid-cols-5">@foreach ([['Admissions', $admissionCount, 'admin.admissions.index'], ['Scholarships', $scholarshipCount, 'admin.scholarships.index'], ['Education jobs', $jobCount, 'admin.education-jobs.index'], ['Careers', $careerCount, 'admin.careers.index'], ['Guides', $articleCount, 'admin.articles.index']] as [$label, $count, $route])<a href="{{ route($route) }}" class="rounded-none border border-slate-200 bg-white p-4"><p class="text-xl font-bold text-[#082c56]">{{ $count }}</p><p class="mt-1 text-xs text-slate-500">{{ $label }}</p></a>@endforeach</div>
    </section>
</x-layouts.admin>
