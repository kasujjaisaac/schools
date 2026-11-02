<x-layouts.admin :title="$programme->name">
    <section class="mx-auto max-w-5xl px-4 py-6 sm:px-5 lg:px-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div><p class="text-sm font-bold text-[#1d72b8]">Programme</p><h1 class="text-2xl font-bold text-[#082c56]">{{ $programme->name }}</h1></div>
            <div class="flex gap-2">
                <a href="{{ route('admin.programmes.edit', $programme) }}" class="bg-[#1d72b8] px-4 py-3 font-bold text-white">Edit</a>
                <form method="POST" action="{{ route('admin.programmes.destroy', $programme) }}" data-confirm="Delete this record? This action cannot be undone.">@csrf @method('DELETE')<button class="border border-red-200 px-4 py-3 font-bold text-red-700">Delete</button></form>
            </div>
        </div>
        <div class="mt-8 grid gap-5 bg-white p-6 ">
            <p class="text-sm text-[#5d6b7c]">{{ $programme->field ?? 'Field not set' }} · {{ $programme->qualification ?? 'Qualification not set' }} · {{ $programme->duration ?? 'Duration not set' }}</p>
            <p class="leading-7">{{ $programme->description ?? 'No description yet.' }}</p>
            <div><h2 class="font-bold text-[#082c56]">Institutions</h2><div class="mt-3 flex flex-wrap gap-2">@foreach ($programme->institutions as $institution)<span class="border border-[#c7d7ea] px-3 py-1 text-sm">{{ $institution->name }}</span>@endforeach</div></div>
        </div>
    </section>
</x-layouts.admin>
