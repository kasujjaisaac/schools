<x-layouts.admin :title="$programme->exists ? 'Edit Programme' : 'Add Programme'">
    <section class="mx-auto max-w-4xl px-4 py-6 sm:px-5 lg:px-6">
        <a href="{{ route('admin.programmes.index') }}" class="mb-5 inline-block text-sm font-semibold text-[#1d72b8]">Back to list</a>

        <form method="POST" action="{{ $programme->exists ? route('admin.programmes.update', $programme) : route('admin.programmes.store') }}" class="grid gap-4 bg-white p-6 ">
            @csrf
            @if ($programme->exists) @method('PUT') @endif
            <h1 class="text-2xl font-bold text-[#082c56]">{{ $programme->exists ? 'Edit Programme' : 'Add Programme' }}</h1>
            @if ($errors->any())<p class="bg-red-50 p-3 text-sm text-red-700">{{ $errors->first() }}</p>@endif
            <div class="grid gap-3 md:grid-cols-2">
                <input name="name" value="{{ old('name', $programme->name) }}" class="border border-[#d9d2c3] px-3 py-2" placeholder="Name" required>
                <input name="slug" value="{{ old('slug', $programme->slug) }}" class="border border-[#d9d2c3] px-3 py-2" placeholder="Slug">
                <input name="field" value="{{ old('field', $programme->field) }}" class="border border-[#d9d2c3] px-3 py-2" placeholder="Field">
                <input name="qualification" value="{{ old('qualification', $programme->qualification) }}" class="border border-[#d9d2c3] px-3 py-2" placeholder="Qualification">
                <input name="duration" value="{{ old('duration', $programme->duration) }}" class="border border-[#d9d2c3] px-3 py-2 md:col-span-2" placeholder="Duration">
            </div>
            <textarea name="description" rows="5" class="border border-[#d9d2c3] px-3 py-2" placeholder="Description">{{ old('description', $programme->description) }}</textarea>
            <textarea name="career_prospects" rows="4" class="border border-[#d9d2c3] px-3 py-2" placeholder="Career prospects">{{ old('career_prospects', $programme->career_prospects) }}</textarea>
            <div class="grid gap-2">
                <p class="font-semibold text-[#082c56]">Offered by institutions</p>
                <div class="grid gap-2 sm:grid-cols-2">
                    @foreach ($institutions as $institution)
                        <label class="border border-[#d9d2c3] px-3 py-2 text-sm"><input type="checkbox" name="institution_ids[]" value="{{ $institution->id }}" @checked(in_array($institution->id, old('institution_ids', $programme->institutions?->pluck('id')->all() ?? [])))> {{ $institution->name }}</label>
                    @endforeach
                </div>
            </div>
            <button class="bg-[#1d72b8] px-4 py-3 font-bold text-white">Save programme</button>
        </form>
    </section>
</x-layouts.admin>
