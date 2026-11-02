@props(['title' => 'Administration'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title }} | Study Greater Masaka Admin</title>
    <link rel="icon" type="image/png" href="{{ asset('images/sgm-logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-admin text-sm text-slate-800 antialiased">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-none focus:bg-white focus:p-3">Skip to content</a>
    <aside class="fixed inset-y-0 left-0 hidden w-56 flex-col bg-[#082c56] lg:flex">
        <a href="{{ route('admin.dashboard') }}" class="flex shrink-0 flex-col items-center gap-2 border-b border-slate-200 bg-white px-4 py-3">
            <img src="{{ asset('images/sgm-logo.png') }}" alt="Study Greater Masaka" class="h-auto w-28 object-contain">
        </a>
        <div class="min-h-0 flex-1 overflow-y-auto px-3 py-4 [scrollbar-color:#365574_#082c56] [scrollbar-width:thin]"><x-admin-navigation /></div>
        <a href="{{ route('home') }}" class="shrink-0 border-t border-white/10 px-5 py-3 text-xs font-semibold text-slate-300 hover:text-white">View public website <span aria-hidden="true">↗</span></a>
    </aside>
    <div class="lg:pl-56">
        <header class="sticky top-0 z-30 flex min-h-16 items-center justify-between gap-3 border-b border-slate-200 bg-white px-4 sm:px-6">
            <div class="flex min-w-0 items-center gap-4">
                <details class="relative lg:hidden">
                    <summary class="cursor-pointer rounded-none border border-slate-200 px-3 py-2 text-sm font-semibold">Menu</summary>
                    <div class="absolute left-0 top-full mt-3 max-h-[75vh] w-64 overflow-y-auto rounded-none bg-[#082c56] p-4 shadow-xl"><x-admin-navigation /><a href="{{ route('home') }}" class="mt-5 block px-3 text-sm text-white">View public website</a></div>
                </details>
                <a href="{{ route('admin.dashboard') }}" class="shrink-0 lg:hidden"><img src="{{ asset('images/sgm-logo.png') }}" alt="Study Greater Masaka" class="h-auto w-16 object-contain"></a>
                <div class="hidden min-w-0 sm:block"><p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Admin workspace</p><p class="truncate text-sm font-semibold text-[#082c56]">{{ $title }}</p></div>
            </div>
            <div class="flex items-center gap-4">
                <span class="hidden text-right text-xs text-slate-500 sm:block"><strong class="block text-sm text-slate-800">{{ auth()->user()->name }}</strong>{{ auth()->user()->role?->label ?? 'Administrator' }}</span>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="rounded-none border border-slate-200 px-3 py-2 text-xs font-semibold hover:bg-slate-50">Sign out</button></form>
            </div>
        </header>
        <main id="main-content" class="min-h-[calc(100dvh-109px)] min-w-0 pb-6">
            @if (session('status'))
                <div role="status" class="mx-4 mt-6 rounded-none border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800 sm:mx-8">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div role="alert" class="mx-4 mt-6 rounded-none border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800 sm:mx-8">
                    <p class="font-bold">Please correct the following:</p>
                    <ul class="mt-2 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            @unless (request()->routeIs('admin.dashboard'))
                <div class="mx-auto flex max-w-7xl flex-wrap items-center gap-2 px-4 pt-6 text-xs text-slate-500 sm:px-6 lg:px-8" aria-label="Breadcrumb">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-[#1d72b8]">Overview</a>
                    @php
                        $module = explode('.', request()->route()->getName())[1];
                        $moduleLabels = ['institutions' => 'Institutions', 'programmes' => 'Programmes', 'admissions' => 'Admissions', 'scholarships' => 'Scholarships', 'education-jobs' => 'Education jobs', 'careers' => 'Careers', 'articles' => 'Guides', 'enquiries' => 'Enquiries', 'claims' => 'Profile claims'];
                    @endphp
                    <span aria-hidden="true">/</span><a href="{{ route('admin.'.$module.'.index') }}" class="hover:text-[#1d72b8]">{{ $moduleLabels[$module] ?? ucfirst($module) }}</a>
                    @unless (request()->routeIs('admin.*.index'))<span aria-hidden="true">/</span><span>{{ $title }}</span>@endunless
                </div>
            @endunless
            {{ $slot }}
        </main>
        <footer class="border-t border-slate-200 px-6 py-3 text-xs text-slate-400">Study Greater Masaka <span aria-hidden="true">/</span> Education management</footer>
    </div>
</body>
</html>
