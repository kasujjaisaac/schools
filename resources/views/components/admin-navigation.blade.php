@php
    $groups = [
        'Workspace' => [
            ['Overview', 'admin.dashboard', 'admin.dashboard', '01'],
            ['Institutions', 'admin.institutions.index', 'admin.institutions.*', '02'],
            ['Programmes', 'admin.programmes.index', 'admin.programmes.*', '03'],
            ['Admissions', 'admin.admissions.index', 'admin.admissions.*', '04'],
        ],
        'Opportunities & content' => [
            ['Scholarships', 'admin.scholarships.index', 'admin.scholarships.*', '05'],
            ['Education jobs', 'admin.education-jobs.index', 'admin.education-jobs.*', '06'],
            ['Careers', 'admin.careers.index', 'admin.careers.*', '07'],
            ['Guides', 'admin.articles.index', 'admin.articles.*', '08'],
        ],
        'Inbox' => [
            ['Enquiries', 'admin.enquiries.index', 'admin.enquiries.*', '09'],
            ['Profile claims', 'admin.claims.index', 'admin.claims.*', '10'],
        ],
    ];
@endphp
<nav {{ $attributes->merge(['class' => 'space-y-4']) }} aria-label="Administration">
    @foreach ($groups as $label => $items)
        <div>
            <p class="mb-1.5 px-3 text-[9px] font-bold uppercase tracking-widest text-slate-400">{{ $label }}</p>
            <div class="space-y-1">
                @foreach ($items as [$label, $route, $pattern, $number])
                    <a href="{{ route($route) }}" @if (request()->routeIs($pattern)) aria-current="page" @endif class="flex items-center gap-2.5 border-l-2 px-3 py-2 text-xs font-medium transition {{ request()->routeIs($pattern) ? 'border-[#f2b705] bg-white/10 text-white' : 'border-transparent text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <span class="text-[10px] font-semibold opacity-50" aria-hidden="true">{{ $number }}</span>
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</nav>
