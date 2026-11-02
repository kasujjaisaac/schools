<x-layouts.app title="Institutions">
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <p class="text-sm font-bold text-[#1d72b8]">Institution directory</p>
                <h1 class="mt-1 text-3xl font-bold text-[#082c56]">Find Institutions</h1>
                <p class="mt-2 text-sm text-[#5d6b7c]">{{ $institutions->total() }} matching profiles across Greater Masaka.</p>
            </div>
            @if (request()->query())
                <a href="{{ route('institutions.index') }}" class="border border-[#9dbbe0] px-4 py-2 text-sm font-bold text-[#082c56]">Reset filters</a>
            @endif
        </div>

        <form class="mt-6 grid gap-3 border border-[#c7d7ea] bg-white p-4 shadow-sm md:grid-cols-6">
            <input name="q" value="{{ request('q') }}" class="border border-[#d9d2c3] px-3 py-2 outline-none focus:border-[#1d72b8] md:col-span-2" placeholder="Search name or programme">
            <select name="category" class="border border-[#d9d2c3] px-3 py-2 outline-none focus:border-[#1d72b8]"><option value="">Type</option>@foreach ($categories as $category)<option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>@endforeach</select>
            <select name="location" class="border border-[#d9d2c3] px-3 py-2 outline-none focus:border-[#1d72b8]"><option value="">Location</option>@foreach ($locations as $location)<option value="{{ $location->id }}" @selected(request('location') == $location->id)>{{ $location->name }}</option>@endforeach</select>
            <select name="level" class="border border-[#d9d2c3] px-3 py-2 outline-none focus:border-[#1d72b8]"><option value="">Level</option>@foreach ($levels as $level)<option value="{{ $level->id }}" @selected(request('level') == $level->id)>{{ $level->name }}</option>@endforeach</select>
            <button class="bg-[#1d72b8] px-4 py-2 font-semibold text-white hover:bg-[#155d96]">Filter</button>
        </form>
        <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($institutions as $institution)
                <x-institution-card :institution="$institution" />
            @empty
                <x-empty-state title="No institutions found" message="Try removing a filter or searching a nearby location." />
            @endforelse
        </div>
        <div class="mt-8">{{ $institutions->links() }}</div>
    </section>
</x-layouts.app>
