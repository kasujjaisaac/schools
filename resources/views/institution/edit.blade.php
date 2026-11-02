<x-layouts.app title="Edit Institution Profile">
    <section class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('institution.profile.update') }}" class="grid gap-4 rounded-lg bg-white p-6">
            @csrf @method('PUT')
            <h1 class="text-2xl font-bold">Edit Profile</h1>
            @if ($errors->any())<p class="rounded-md bg-red-50 p-3 text-sm text-red-700">{{ $errors->first() }}</p>@endif
            <input name="name" value="{{ old('name', $institution->name) }}" class="rounded-md border border-[#d9d2c3] px-3 py-2" required>
            <input name="tagline" value="{{ old('tagline', $institution->tagline) }}" class="rounded-md border border-[#d9d2c3] px-3 py-2" placeholder="Tagline">
            <textarea name="description" class="rounded-md border border-[#d9d2c3] px-3 py-2" rows="5" placeholder="Description">{{ old('description', $institution->description) }}</textarea>
            <textarea name="mission" class="rounded-md border border-[#d9d2c3] px-3 py-2" rows="4" placeholder="Mission">{{ old('mission', $institution->mission) }}</textarea>
            <textarea name="vision" class="rounded-md border border-[#d9d2c3] px-3 py-2" rows="4" placeholder="Vision">{{ old('vision', $institution->vision) }}</textarea>
            <div class="grid gap-3 sm:grid-cols-3"><input name="primary_color" value="{{ old('primary_color', $institution->primary_color) }}" class="rounded-md border border-[#d9d2c3] px-3 py-2"><input name="secondary_color" value="{{ old('secondary_color', $institution->secondary_color) }}" class="rounded-md border border-[#d9d2c3] px-3 py-2"><input name="accent_color" value="{{ old('accent_color', $institution->accent_color) }}" class="rounded-md border border-[#d9d2c3] px-3 py-2"></div>
            <input name="telephone" value="{{ old('telephone', $institution->telephone) }}" class="rounded-md border border-[#d9d2c3] px-3 py-2" placeholder="Telephone">
            <input name="email" value="{{ old('email', $institution->email) }}" class="rounded-md border border-[#d9d2c3] px-3 py-2" placeholder="Email">
            <input name="website" value="{{ old('website', $institution->website) }}" class="rounded-md border border-[#d9d2c3] px-3 py-2" placeholder="Website">
            <input name="whatsapp" value="{{ old('whatsapp', $institution->whatsapp) }}" class="rounded-md border border-[#d9d2c3] px-3 py-2" placeholder="WhatsApp">
            <button class="rounded-md bg-[#1d72b8] px-4 py-3 font-bold text-white">Save profile</button>
        </form>
    </section>
</x-layouts.app>
