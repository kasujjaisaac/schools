<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $metaDescription ?? 'Study Greater Masaka helps learners, parents and institutions discover education pathways, admissions and opportunities.' }}">
    <title>{{ isset($title) ? $title.' | ' : '' }}Study Greater Masaka</title>
    <link rel="icon" type="image/png" href="{{ asset('images/sgm-logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/sgm-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/sgm-logo.png') }}">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-[#eef4fb] text-[#111827] antialiased">
    @php
        $navigationItems = [
            ['label' => 'Home', 'route' => 'home', 'active' => 'home'],
            ['label' => 'Institutions', 'route' => 'institutions.index', 'active' => 'institutions.*'],
            ['label' => 'Programmes', 'route' => 'programmes.index', 'active' => 'programmes.*'],
            ['label' => 'Admissions', 'route' => 'admissions.index', 'active' => 'admissions.*'],
            ['label' => 'Careers', 'route' => 'careers.index', 'active' => 'careers.*'],
            ['label' => 'Guides', 'route' => 'guides.index', 'active' => 'guides.*'],
            ['label' => 'Contact', 'route' => 'contact', 'active' => 'contact'],
        ];
    @endphp

    <div class="border-b border-white/10 bg-[#041d38]">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-2 text-xs font-semibold sm:px-6 lg:px-8">
            <span class="text-white/70">Greater Masaka education discovery, admissions and opportunities</span>
            <div class="hidden items-center gap-4 text-white/75 sm:flex">
                <a href="{{ route('locations.index') }}">Locations</a>
                <a href="{{ route('scholarships.index') }}">Scholarships</a>
                <a href="{{ route('jobs.index') }}">Education jobs</a>
                <a href="{{ route('contact') }}#raise-concern">Raise a concern</a>
                <a href="{{ route('contact') }}">Contact</a>
            </div>
        </div>
    </div>
    <header class="sticky top-0 z-40 border-b border-[#d9d2c3] bg-white text-[#082c56] shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3 font-bold">
                <span class="grid h-14 w-36 shrink-0 place-items-center overflow-hidden">
                    <img src="{{ asset('images/sgm-logo.png') }}" alt="Study Greater Masaka logo" class="max-h-14 w-full object-contain">
                </span>
            </a>
            <nav class="hidden items-center gap-1 text-sm font-semibold lg:flex">
                @foreach ($navigationItems as $item)
                    <a href="{{ route($item['route']) }}" class="px-3 py-2 {{ request()->routeIs($item['active']) ? 'bg-[#eef4fb] text-[#1d72b8]' : 'hover:bg-[#eef4fb]' }}">{{ $item['label'] }}</a>
                @endforeach
                @auth
                    @if (auth()->user()->isAdministrator())
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 {{ request()->routeIs('admin.*') ? 'bg-[#eef4fb] text-[#1d72b8]' : 'hover:bg-[#eef4fb]' }}">Admin</a>
                    @endif
                @endauth
            </nav>
            <div class="flex items-center gap-2 text-sm font-semibold">
                @auth
                    <a href="{{ route('dashboard') }}" class="border border-[#9dbbe0] px-3 py-2 text-[#082c56]">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">@csrf <button class="bg-[#082c56] px-3 py-2 text-white">Sign out</button></form>
                @else
                    <a href="{{ route('register') }}" class="bg-[#082c56] px-3 py-2 text-white">List your institution</a>
                @endauth
                <details class="relative lg:hidden">
                    <summary class="list-none border border-[#9dbbe0] px-3 py-2 text-[#082c56] marker:hidden">Menu</summary>
                    <div class="absolute right-0 top-full mt-3 w-64 border border-[#c7d7ea] bg-white shadow-xl">
                        <nav class="grid divide-y divide-[#d7e3f2] text-sm">
                            @foreach ($navigationItems as $item)
                                <a href="{{ route($item['route']) }}" class="px-4 py-3 {{ request()->routeIs($item['active']) ? 'bg-[#eef4fb] text-[#1d72b8]' : 'text-[#082c56]' }}">{{ $item['label'] }}</a>
                            @endforeach
                            @auth
                                @if (auth()->user()->isAdministrator())
                                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-3 {{ request()->routeIs('admin.*') ? 'bg-[#eef4fb] text-[#1d72b8]' : 'text-[#082c56]' }}">Admin</a>
                                @endif
                            @endauth
                            <a href="{{ route('locations.index') }}" class="px-4 py-3 text-[#082c56]">Locations</a>
                            <a href="{{ route('scholarships.index') }}" class="px-4 py-3 text-[#082c56]">Scholarships</a>
                            <a href="{{ route('jobs.index') }}" class="px-4 py-3 text-[#082c56]">Education jobs</a>
                            <a href="{{ route('contact') }}#raise-concern" class="px-4 py-3 text-[#082c56]">Raise a concern</a>
                        </nav>
                    </div>
                </details>
            </div>
        </div>
    </header>

    @if (session('status'))
        <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-md border border-[#9dbbe0] bg-[#e8f1fb] px-4 py-3 text-sm text-[#082c56]">{{ session('status') }}</div>
        </div>
    @endif

    <main>
        {{ $slot }}
    </main>

    <footer class="mt-16 border-t border-[#d9d2c3] bg-[#082c56] text-white">
        <div class="border-b border-white/10 bg-[#041d38]">
            <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-5 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                <div>
                    <p class="text-sm font-bold text-[#b8d7f5]">Study Greater Masaka</p>
                    <p class="mt-1 text-xl font-bold">Find the right education path with confidence.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('institutions.index') }}" class="bg-[#f2b705] px-4 py-2 text-sm font-bold text-[#082c56] hover:bg-[#dca400]">Explore institutions</a>
                    <a href="{{ route('contact') }}" class="border border-white/30 px-4 py-2 text-sm font-bold text-white hover:bg-white/10">Contact us</a>
                </div>
            </div>
        </div>

        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 md:grid-cols-[1.4fr_1fr_1fr_1fr] lg:px-8">
            <div class="max-w-sm">
                <a href="{{ route('home') }}" class="inline-grid h-14 w-36 place-items-center overflow-hidden bg-white px-3">
                    <img src="{{ asset('images/sgm-logo.png') }}" alt="Study Greater Masaka logo" class="max-h-12 w-full object-contain">
                </a>
                <p class="mt-4 text-sm leading-6 text-white/70">Regional education discovery, admissions, scholarships, jobs, and pathway guidance for learners, families, and institutions across Greater Masaka.</p>
            </div>

            <div class="grid gap-2 text-sm text-white/75">
                <p class="mb-1 font-semibold text-white">Discover</p>
                <a href="{{ route('institutions.index') }}" class="hover:text-white">Institutions</a>
                <a href="{{ route('programmes.index') }}" class="hover:text-white">Programmes</a>
                <a href="{{ route('locations.index') }}" class="hover:text-white">Locations</a>
                <a href="{{ route('admissions.index') }}" class="hover:text-white">Admissions</a>
            </div>

            <div class="grid gap-2 text-sm text-white/75">
                <p class="mb-1 font-semibold text-white">Opportunities</p>
                <a href="{{ route('scholarships.index') }}" class="hover:text-white">Scholarships</a>
                <a href="{{ route('jobs.index') }}" class="hover:text-white">Education jobs</a>
                <a href="{{ route('careers.index') }}" class="hover:text-white">Careers</a>
                <a href="{{ route('guides.index') }}" class="hover:text-white">Guides</a>
            </div>

            <div class="grid gap-2 text-sm text-white/75">
                <p class="mb-1 font-semibold text-white">Support</p>
                <a href="{{ route('contact') }}" class="hover:text-white">Contact us</a>
                <a href="{{ route('contact') }}#raise-concern" class="hover:text-white">Raise a concern</a>
                <a href="{{ route('register') }}" class="hover:text-white">List your institution</a>
            </div>
        </div>

        <div class="border-t border-white/10">
            <div class="mx-auto max-w-7xl px-4 py-4 text-sm text-white/70 sm:px-6 lg:px-8">
                <p>&copy; {{ date('Y') }} Study Greater Masaka. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
