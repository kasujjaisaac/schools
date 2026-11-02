<x-layouts.admin :title="$career->exists ? 'Edit Career' : 'Add Career'">
    <section class="mx-auto max-w-4xl px-4 py-6 sm:px-5 lg:px-6">
        <a href="{{ route('admin.careers.index') }}" class="mb-5 inline-block text-sm font-semibold text-[#1d72b8]">Back to list</a>

        <form method="POST" action="{{ $career->exists ? route('admin.careers.update', $career) : route('admin.careers.store') }}" class="grid gap-4 bg-white p-6 ">
            @csrf @if ($career->exists) @method('PUT') @endif
            <h1 class="text-2xl font-bold text-[#082c56]">{{ $career->exists ? 'Edit Career' : 'Add Career' }}</h1>
            @if ($errors->any())<p class="bg-red-50 p-3 text-sm text-red-700">{{ $errors->first() }}</p>@endif
            <div class="grid gap-3 md:grid-cols-2"><input name="title" value="{{ old('title', $career->title) }}" class="border border-[#d9d2c3] px-3 py-2" placeholder="Title" required><input name="slug" value="{{ old('slug', $career->slug) }}" class="border border-[#d9d2c3] px-3 py-2" placeholder="Slug"></div>
            <textarea name="summary" rows="3" class="border border-[#d9d2c3] px-3 py-2" placeholder="Summary" required>{{ old('summary', $career->summary) }}</textarea>
            <textarea name="duties" rows="4" class="border border-[#d9d2c3] px-3 py-2" placeholder="Duties">{{ old('duties', $career->duties) }}</textarea>
            <textarea name="skills" rows="4" class="border border-[#d9d2c3] px-3 py-2" placeholder="Skills">{{ old('skills', $career->skills) }}</textarea>
            <textarea name="recommended_subjects" rows="4" class="border border-[#d9d2c3] px-3 py-2" placeholder="Recommended subjects">{{ old('recommended_subjects', $career->recommended_subjects) }}</textarea>
            <textarea name="education_pathway" rows="4" class="border border-[#d9d2c3] px-3 py-2" placeholder="Education pathway">{{ old('education_pathway', $career->education_pathway) }}</textarea>
            <div class="grid gap-2"><p class="font-semibold text-[#082c56]">Related programmes</p><div class="grid gap-2 sm:grid-cols-2">@foreach ($programmes as $programme)<label class="border border-[#d9d2c3] px-3 py-2 text-sm"><input type="checkbox" name="programme_ids[]" value="{{ $programme->id }}" @checked(in_array($programme->id, old('programme_ids', $career->programmes?->pluck('id')->all() ?? [])))> {{ $programme->name }}</label>@endforeach</div></div>
            <select name="status" class="border border-[#d9d2c3] px-3 py-2">@foreach (['draft','published','archived'] as $value)<option @selected(old('status', $career->status) === $value)>{{ $value }}</option>@endforeach</select>
            <button class="bg-[#1d72b8] px-4 py-3 font-bold text-white">Save career</button>
        </form>
    </section>
</x-layouts.admin>
