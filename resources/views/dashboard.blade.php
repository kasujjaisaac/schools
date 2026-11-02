<x-layouts.app title="Dashboard">
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">My Education Dashboard</h1>
        <div class="mt-8 grid gap-4 md:grid-cols-3">
            <div class="rounded-lg bg-white p-5"><p class="text-3xl font-bold">{{ $institutionCount }}</p><p class="text-sm text-[#6b6256]">Published institutions</p></div>
            <div class="rounded-lg bg-white p-5"><p class="text-3xl font-bold">{{ $openAdmissionCount }}</p><p class="text-sm text-[#6b6256]">Open admissions</p></div>
            <div class="rounded-lg bg-white p-5"><p class="text-3xl font-bold">{{ $enquiryCount }}</p><p class="text-sm text-[#6b6256]">Matched enquiries</p></div>
        </div>
        <div class="mt-8 rounded-lg border border-[#ded6c8] bg-white p-6">
            <h2 class="font-bold">Saved searches and deadline alerts</h2>
            <p class="mt-2 text-sm text-[#6b6256]">{{ $savedMessage }}</p>
        </div>
    </section>
</x-layouts.app>
