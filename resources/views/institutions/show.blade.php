<x-layouts.app :title="$institution->seo_title ?? $institution->name" :meta-description="$institution->seo_description ?? $institution->tagline">
    <section style="--institution-primary: {{ $institution->primary_color }}; --institution-secondary: {{ $institution->secondary_color }}; --institution-accent: {{ $institution->accent_color }};" class="institution-profile">
        <div class="relative bg-[var(--institution-primary)] text-white">
            @if ($institution->cover_image_url)
                <img src="{{ $institution->cover_image_url }}" alt="{{ $institution->name }} cover image" class="absolute inset-0 h-full w-full object-cover opacity-30">
            @endif
            <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-6 md:flex-row md:items-end">
                    <img src="{{ $institution->logo_url ?: 'https://ui-avatars.com/api/?name='.urlencode($institution->short_name ?: $institution->name).'&background=1d72b8&color=fff&bold=true' }}" alt="{{ $institution->name }} logo" class="size-24 rounded-lg border-4 border-white bg-white object-cover">
                    <div class="max-w-3xl">
                        <div class="flex flex-wrap gap-2">
                            @if ($institution->is_verified)<span class="rounded-md bg-white px-2 py-1 text-xs font-bold text-[var(--institution-primary)]">Verified by Study Greater Masaka</span>@endif
                            <span class="rounded-md bg-white/15 px-2 py-1 text-xs font-semibold">{{ $institution->category?->name }}</span>
                            <span class="rounded-md bg-white/15 px-2 py-1 text-xs font-semibold">{{ $institution->boarding_type ?? 'Mode to be confirmed' }}</span>
                        </div>
                        <h1 class="mt-4 text-4xl font-bold">{{ $institution->name }}</h1>
                        <p class="mt-2 text-white/85">{{ $institution->tagline ?? 'A Study Greater Masaka institution profile.' }}</p>
                        <p class="mt-2 text-sm text-white/80">{{ $institution->location?->name ?? 'Location to be confirmed' }}{{ $institution->address ? ' · '.$institution->address : '' }}</p>
                    </div>
                </div>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#admissions" class="rounded-md bg-[var(--institution-secondary)] px-4 py-3 font-bold text-[#17211e]">Admission Information</a>
                    <a href="#enquire" class="rounded-md bg-white px-4 py-3 font-bold text-[var(--institution-primary)]">Enquire</a>
                    @if ($institution->telephone)<a href="tel:{{ $institution->telephone }}" class="rounded-md border border-white px-4 py-3 font-bold">Call</a>@endif
                    @if ($institution->whatsapp)<a href="https://wa.me/{{ preg_replace('/\D+/', '', $institution->whatsapp) }}" class="rounded-md border border-white px-4 py-3 font-bold">WhatsApp</a>@endif
                </div>
            </div>
        </div>
        <nav class="sticky top-[73px] z-30 border-b border-[#ded6c8] bg-white">
            <div class="mx-auto flex max-w-7xl gap-4 overflow-x-auto px-4 py-3 text-sm font-semibold sm:px-6 lg:px-8">
                <a href="#overview">Overview</a><a href="#programmes">Programmes</a><a href="#admissions">Admissions</a><a href="#facilities">Facilities</a><a href="#contact">Contact</a>
            </div>
        </nav>
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 lg:grid-cols-[1fr_320px] lg:px-8">
            <div class="grid gap-8">
                <section id="overview" class="rounded-lg bg-white p-6">
                    <h2 class="text-2xl font-bold">Overview</h2>
                    <p class="mt-4 text-[#4d463d]">{{ $institution->description ?: 'This institution has not added a detailed description yet. Verified representatives can claim and complete this profile.' }}</p>
                    <div class="mt-6 grid gap-3 sm:grid-cols-3">
                        @foreach (['Ownership' => $institution->ownership, 'Gender' => $institution->gender_type, 'Founded' => $institution->established_year] as $label => $value)
                            @if ($value)<div class="rounded-lg border border-[#ded6c8] p-4"><p class="text-xs text-[#6b6256]">{{ $label }}</p><p class="font-bold">{{ $value }}</p></div>@endif
                        @endforeach
                    </div>
                    <div class="mt-6 grid gap-4 md:grid-cols-2">@if ($institution->mission)<div><h3 class="font-bold">Mission</h3><p class="mt-2 text-sm text-[#4d463d]">{{ $institution->mission }}</p></div>@endif @if ($institution->vision)<div><h3 class="font-bold">Vision</h3><p class="mt-2 text-sm text-[#4d463d]">{{ $institution->vision }}</p></div>@endif</div>
                </section>
                <section id="programmes" class="rounded-lg bg-white p-6">
                    <h2 class="text-2xl font-bold">Programmes and Education Levels</h2>
                    <div class="mt-4 flex flex-wrap gap-2">@foreach ($institution->educationLevels as $level)<span class="rounded-md bg-[#f7f4ed] px-3 py-2 text-sm">{{ $level->name }}</span>@endforeach</div>
                    <div class="mt-5 grid gap-3 md:grid-cols-2">@forelse ($institution->programmes as $programme)<a href="{{ route('programmes.show', $programme) }}" class="rounded-lg border border-[#ded6c8] p-4"><span class="font-bold">{{ $programme->name }}</span><span class="block text-sm text-[#6b6256]">{{ $programme->qualification }} · {{ $programme->duration }}</span></a>@empty <x-empty-state title="Programmes not published" message="Contact the institution for current academic offerings." />@endforelse</div>
                </section>
                <section id="admissions" class="rounded-lg bg-white p-6">
                    <h2 class="text-2xl font-bold">Admissions</h2>
                    <div class="mt-5 grid gap-3">@forelse ($institution->admissions as $admission)<article class="rounded-lg border border-[#ded6c8] p-4"><div class="flex justify-between gap-4"><h3 class="font-bold">{{ $admission->name }}</h3><span class="rounded-md bg-[#e8f1fb] px-2 py-1 text-xs font-semibold text-[#1d72b8]">{{ ucfirst($admission->status) }}</span></div><p class="mt-2 text-sm text-[#6b6256]">{{ $admission->description }}</p><p class="mt-2 text-sm font-semibold">Deadline: {{ $admission->closing_date?->toFormattedDateString() ?? 'To be confirmed' }}</p></article>@empty <x-empty-state title="No open admission intakes" message="This profile will show admissions when the institution publishes them." />@endforelse</div>
                </section>
                <section id="facilities" class="rounded-lg bg-white p-6">
                    <h2 class="text-2xl font-bold">Facilities</h2>
                    <div class="mt-4 flex flex-wrap gap-2">@forelse ($institution->facilities as $facility)<span class="rounded-md border border-[#ded6c8] px-3 py-2 text-sm">{{ $facility->name }}</span>@empty <span class="text-sm text-[#6b6256]">Facilities have not been published yet.</span>@endforelse</div>
                </section>
            </div>
            <aside class="grid content-start gap-5">
                <div class="rounded-lg bg-white p-5">
                    <p class="text-sm text-[#6b6256]">Profile completeness</p>
                    <p class="mt-1 text-3xl font-bold">{{ $institution->profile_completeness }}%</p>
                    <div class="mt-3 h-2 rounded-full bg-[#e8e0d4]"><div class="h-2 rounded-full bg-[var(--institution-primary)]" style="width: {{ $institution->profile_completeness }}%"></div></div>
                </div>
                <div id="contact" class="rounded-lg bg-white p-5">
                    <h2 class="font-bold">Contact</h2>
                    <div class="mt-3 grid gap-2 text-sm text-[#4d463d]">
                        @if ($institution->telephone)<a href="tel:{{ $institution->telephone }}">{{ $institution->telephone }}</a>@endif
                        @if ($institution->email)<a href="mailto:{{ $institution->email }}">{{ $institution->email }}</a>@endif
                        @if ($institution->website)<a href="{{ $institution->website }}">{{ $institution->website }}</a>@endif
                        <span>{{ $institution->address ?? 'Address to be confirmed' }}</span>
                    </div>
                </div>
                <form id="enquire" method="POST" action="{{ route('institutions.enquiries.store', $institution) }}" class="grid gap-3 rounded-lg bg-white p-5">
                    @csrf
                    <h2 class="font-bold">Send Enquiry</h2>
                    <input name="name" value="{{ old('name') }}" class="rounded-md border border-[#d9d2c3] px-3 py-2" placeholder="Your name" required>
                    <input name="telephone" value="{{ old('telephone') }}" class="rounded-md border border-[#d9d2c3] px-3 py-2" placeholder="Phone number" required>
                    <input name="email" value="{{ old('email') }}" class="rounded-md border border-[#d9d2c3] px-3 py-2" placeholder="Email optional">
                    <select name="preferred_contact_method" class="rounded-md border border-[#d9d2c3] px-3 py-2"><option value="phone">Phone</option><option value="whatsapp">WhatsApp</option><option value="email">Email</option></select>
                    <textarea name="message" class="rounded-md border border-[#d9d2c3] px-3 py-2" rows="4" placeholder="What would you like to know?">{{ old('message') }}</textarea>
                    <button class="rounded-md bg-[var(--institution-primary)] px-4 py-3 font-bold text-white">Send enquiry</button>
                </form>
                <form method="POST" action="{{ route('institutions.claims.store', $institution) }}" class="grid gap-3 rounded-lg bg-white p-5">
                    @csrf
                    <h2 class="font-bold">Claim this profile</h2>
                    <input name="claimant_name" class="rounded-md border border-[#d9d2c3] px-3 py-2" placeholder="Your name" required>
                    <input name="role_title" class="rounded-md border border-[#d9d2c3] px-3 py-2" placeholder="Role or title" required>
                    <input name="phone" class="rounded-md border border-[#d9d2c3] px-3 py-2" placeholder="Phone" required>
                    <input name="email" class="rounded-md border border-[#d9d2c3] px-3 py-2" placeholder="Email" required>
                    <textarea name="proof" class="rounded-md border border-[#d9d2c3] px-3 py-2" rows="3" placeholder="How can admins verify this claim?" required></textarea>
                    <button class="rounded-md border border-[var(--institution-primary)] px-4 py-3 font-bold text-[var(--institution-primary)]">Submit claim</button>
                </form>
            </aside>
        </div>
    </section>
</x-layouts.app>
