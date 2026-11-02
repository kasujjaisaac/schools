<x-layouts.app title="Institution Dashboard">
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div><p class="text-sm font-semibold text-[#1d72b8]">Institution Portal</p><h1 class="text-3xl font-bold">{{ $institution->name }}</h1></div>
            <a href="{{ route('institution.profile.edit') }}" class="rounded-md bg-[#1d72b8] px-4 py-3 font-bold text-white">Edit profile</a>
        </div>
        <div class="mt-8 grid gap-4 md:grid-cols-4">
            <div class="rounded-lg bg-white p-5"><p class="text-3xl font-bold">{{ $institution->profile_completeness }}%</p><p class="text-sm text-[#6b6256]">Profile completion</p></div>
            <div class="rounded-lg bg-white p-5"><p class="text-3xl font-bold">{{ $institution->programmes->count() }}</p><p class="text-sm text-[#6b6256]">Programmes</p></div>
            <div class="rounded-lg bg-white p-5"><p class="text-3xl font-bold">{{ $openAdmissions->count() }}</p><p class="text-sm text-[#6b6256]">Open intakes</p></div>
            <div class="rounded-lg bg-white p-5"><p class="text-3xl font-bold">{{ $enquiries->count() }}</p><p class="text-sm text-[#6b6256]">Recent enquiries</p></div>
        </div>
        <div class="mt-8 rounded-lg bg-white p-6">
            <h2 class="font-bold">Latest enquiries</h2>
            <div class="mt-4 grid gap-3">@forelse ($enquiries as $enquiry)<div class="rounded-md border border-[#ded6c8] p-4"><p class="font-semibold">{{ $enquiry->name }}</p><p class="text-sm text-[#6b6256]">{{ $enquiry->telephone }} · {{ $enquiry->status }}</p></div>@empty <x-empty-state title="No enquiries yet" message="New public enquiries will appear here." />@endforelse</div>
        </div>
    </section>
</x-layouts.app>
