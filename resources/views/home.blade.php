<x-layouts.app title="Discover Education in Greater Masaka">
    <section class="border-b border-[#c7d7ea] bg-[#082c56] text-white">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 py-6 sm:px-6 lg:grid-cols-[minmax(0,1fr)_340px] lg:px-8">
            <div class="min-w-0">
                <h1 class="max-w-4xl text-2xl font-bold leading-tight sm:text-3xl lg:text-4xl">Find schools, programmes, and opportunities in Greater Masaka</h1>
                <p class="mt-3 max-w-2xl text-base leading-7 text-white/75">Compare verified institutions, admissions, scholarships, and career pathways across the region.</p>

                <form action="{{ route('institutions.index') }}" class="mt-5 grid max-w-4xl border border-[#b8d7f5]/40 bg-white p-2 text-[#111827] shadow-xl lg:grid-cols-[minmax(0,1fr)_140px]">
                    <label class="sr-only" for="home-search">Search schools, programmes or locations</label>
                    <input id="home-search" name="q" class="min-h-10 border border-transparent px-4 outline-none focus:border-[#1d72b8]" placeholder="Search schools, programmes, locations...">
                    <button class="min-h-10 bg-[#f2b705] px-5 font-bold text-[#082c56] hover:bg-[#dca400]">Search</button>
                </form>

                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach (['Nursery', 'Primary', 'Secondary', 'Vocational', 'University', 'Scholarships'] as $filter)
                        <a href="{{ route($filter === 'Scholarships' ? 'scholarships.index' : 'institutions.index', $filter === 'Scholarships' ? [] : ['q' => $filter]) }}" class="border border-white/20 bg-white/10 px-3 py-1.5 text-sm font-semibold text-white hover:bg-white/18">{{ $filter }}</a>
                    @endforeach
                </div>
            </div>

            <aside class="border border-[#b8d7f5]/30 bg-white text-[#082c56] shadow-xl">
                <div class="border-b border-[#d7e3f2] p-4">
                    <p class="text-sm font-bold text-[#1d72b8]">Education discovery desk</p>
                    <p class="mt-1 text-sm leading-6 text-[#5d6b7c]">Start with a school, programme, location or application window.</p>
                </div>
                <div class="grid grid-cols-2 divide-x divide-y divide-[#d7e3f2]">
                    <div class="p-4">
                        <span class="block text-2xl font-bold">{{ $institutionCount }}+</span>
                        <span class="mt-1 block text-xs font-bold uppercase tracking-normal text-[#5d6b7c]">Institutions</span>
                    </div>
                    <div class="p-4">
                        <span class="block text-2xl font-bold">{{ $programmes->count() }}+</span>
                        <span class="mt-1 block text-xs font-bold uppercase tracking-normal text-[#5d6b7c]">Programmes</span>
                    </div>
                    <div class="p-4">
                        <span class="block text-2xl font-bold">{{ $openAdmissions->count() }}</span>
                        <span class="mt-1 block text-xs font-bold uppercase tracking-normal text-[#5d6b7c]">Open Admissions</span>
                    </div>
                    <a href="{{ route('scholarships.index') }}" class="block p-4 hover:bg-[#eef4fb]">
                        <span class="block text-2xl font-bold">Local</span>
                        <span class="mt-1 block text-xs font-bold uppercase tracking-normal text-[#5d6b7c]">Opportunities</span>
                    </a>
                </div>
                <div class="border-t border-[#d7e3f2] bg-[#eef4fb] p-4">
                    <a href="{{ route('institutions.index') }}" class="font-bold text-[#1d72b8]">Browse all institutions</a>
                </div>
            </aside>
        </div>
    </section>

    <section class="border-b border-[#c7d7ea] bg-white">
        <div class="mx-auto grid max-w-7xl divide-y divide-[#d7e3f2] px-4 sm:px-6 md:grid-cols-4 md:divide-x md:divide-y-0 lg:px-8">
            @foreach ([
                ['label' => 'Discover', 'title' => 'Institutions', 'route' => route('institutions.index')],
                ['label' => 'Compare', 'title' => 'Programmes', 'route' => route('programmes.index')],
                ['label' => 'Apply', 'title' => 'Admissions', 'route' => route('admissions.index')],
                ['label' => 'Grow', 'title' => 'Careers & Jobs', 'route' => route('careers.index')],
            ] as $item)
                <a href="{{ $item['route'] }}" class="block p-5 hover:bg-[#eef4fb]">
                    <span class="text-xs font-bold uppercase tracking-normal text-[#1d72b8]">{{ $item['label'] }}</span>
                    <span class="mt-1 block text-lg font-bold">{{ $item['title'] }}</span>
                </a>
            @endforeach
        </div>
    </section>

    <section class="mx-auto grid max-w-7xl gap-6 px-4 py-10 sm:px-6 lg:grid-cols-[300px_minmax(0,1fr)] lg:px-8">
        <aside class="border border-[#c7d7ea] bg-white">
            <div class="border-b border-[#d7e3f2] p-5">
                <p class="text-sm font-bold text-[#082c56]">Explore Greater Masaka</p>
                <p class="mt-1 text-sm text-[#5d6b7c]">Start with a location, level or opportunity type.</p>
            </div>
            <div class="grid divide-y divide-[#d7e3f2]">
                @foreach ($locations as $location)
                    <a href="{{ route('locations.show', $location) }}" class="flex items-center justify-between px-5 py-3 text-sm font-semibold hover:bg-[#eef4fb]">
                        <span>{{ $location->name }}</span>
                        <span class="text-[#1d72b8]">View</span>
                    </a>
                @endforeach
            </div>
        </aside>

        <div class="grid gap-6">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <p class="text-sm font-bold text-[#1d72b8]">Featured institution profiles</p>
                    <h2 class="text-2xl font-bold text-[#082c56]">Professional digital homes for schools and colleges</h2>
                </div>
                <a href="{{ route('institutions.index') }}" class="hidden border border-[#1d72b8] px-4 py-2 text-sm font-bold text-[#1d72b8] sm:inline-block">View all</a>
            </div>

            <div class="grid gap-5 md:grid-cols-3">
                @forelse ($featuredInstitutions as $institution)
                    <x-institution-card :institution="$institution" />
                @empty
                    <x-empty-state title="No featured institutions yet" message="Published institutions will appear here after moderation." />
                @endforelse
            </div>
        </div>
    </section>

</x-layouts.app>
