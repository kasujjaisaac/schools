<x-layouts.admin :title="$admission->exists ? 'Edit Admission' : 'Add Admission'">
    <section class="mx-auto max-w-4xl px-4 py-6 sm:px-5 lg:px-6">
        <a href="{{ route('admin.admissions.index') }}" class="mb-5 inline-block text-sm font-semibold text-[#1d72b8]">Back to list</a>

        <form method="POST" action="{{ $admission->exists ? route('admin.admissions.update', $admission) : route('admin.admissions.store') }}" class="grid gap-4 bg-white p-6 ">
            @csrf @if ($admission->exists) @method('PUT') @endif
            <h1 class="text-2xl font-bold text-[#082c56]">{{ $admission->exists ? 'Edit Admission Intake' : 'Add Admission Intake' }}</h1>
            @if ($errors->any())<p class="bg-red-50 p-3 text-sm text-red-700">{{ $errors->first() }}</p>@endif
            <select name="institution_id" class="border border-[#d9d2c3] px-3 py-2" required><option value="">Institution</option>@foreach ($institutions as $institution)<option value="{{ $institution->id }}" @selected(old('institution_id', $admission->institution_id) == $institution->id)>{{ $institution->name }}</option>@endforeach</select>
            <div class="grid gap-3 md:grid-cols-2"><input name="name" value="{{ old('name', $admission->name) }}" class="border border-[#d9d2c3] px-3 py-2" placeholder="Intake name" required><input name="academic_year" value="{{ old('academic_year', $admission->academic_year) }}" class="border border-[#d9d2c3] px-3 py-2" placeholder="Academic year"><input type="date" name="opening_date" value="{{ old('opening_date', $admission->opening_date?->format('Y-m-d')) }}" class="border border-[#d9d2c3] px-3 py-2"><input type="date" name="closing_date" value="{{ old('closing_date', $admission->closing_date?->format('Y-m-d')) }}" class="border border-[#d9d2c3] px-3 py-2"></div>
            <textarea name="description" rows="4" class="border border-[#d9d2c3] px-3 py-2" placeholder="Description">{{ old('description', $admission->description) }}</textarea>
            <textarea name="requirements" rows="4" class="border border-[#d9d2c3] px-3 py-2" placeholder="Requirements">{{ old('requirements', $admission->requirements) }}</textarea>
            <input name="application_url" value="{{ old('application_url', $admission->application_url) }}" class="border border-[#d9d2c3] px-3 py-2" placeholder="Application URL">
            <div class="flex flex-wrap gap-4"><select name="status" class="border border-[#d9d2c3] px-3 py-2">@foreach (['open','closed','draft'] as $value)<option @selected(old('status', $admission->status) === $value)>{{ $value }}</option>@endforeach</select><label class="px-3 py-2"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $admission->is_featured))> Featured</label></div>
            <button class="bg-[#1d72b8] px-4 py-3 font-bold text-white">Save admission</button>
        </form>
    </section>
</x-layouts.admin>
