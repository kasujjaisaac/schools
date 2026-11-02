<x-layouts.app title="Contact Us">
    <section class="border-b border-[#c7d7ea] bg-white">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 lg:grid-cols-[minmax(0,1fr)_380px] lg:px-8">
            <div>
                <p class="text-sm font-bold text-[#1d72b8]">Contact Study Greater Masaka</p>
                <h1 class="mt-2 max-w-3xl text-3xl font-bold leading-tight text-[#082c56] sm:text-4xl">Talk to us about schools, admissions, opportunities, or institution profiles.</h1>
                <p class="mt-4 max-w-2xl text-base leading-7 text-[#5d6b7c]">Reach out when you need help finding information, correcting a profile, listing an institution, or sharing an education opportunity for Greater Masaka.</p>

                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <a href="{{ route('institutions.index') }}" class="border border-[#c7d7ea] bg-[#eef4fb] p-5 hover:border-[#9dbbe0]">
                        <span class="text-sm font-bold text-[#1d72b8]">Families and learners</span>
                        <span class="mt-2 block text-lg font-bold text-[#082c56]">Find education options</span>
                        <span class="mt-2 block text-sm leading-6 text-[#5d6b7c]">Search institutions, programmes, locations, admissions, and scholarships.</span>
                    </a>
                    <a href="{{ route('register') }}" class="border border-[#c7d7ea] bg-[#eef4fb] p-5 hover:border-[#9dbbe0]">
                        <span class="text-sm font-bold text-[#1d72b8]">Institutions</span>
                        <span class="mt-2 block text-lg font-bold text-[#082c56]">List or claim a profile</span>
                        <span class="mt-2 block text-sm leading-6 text-[#5d6b7c]">Request access to publish accurate school, college, or training information.</span>
                    </a>
                </div>

                <div id="raise-concern" class="mt-5 border border-[#c7d7ea] bg-white p-5 shadow-sm">
                    <span class="text-sm font-bold text-[#1d72b8]">Raise a concern</span>
                    <h2 class="mt-2 text-xl font-bold text-[#082c56]">Report incorrect information, access issues, or a concern about a listed profile.</h2>
                    <p class="mt-2 text-sm leading-6 text-[#5d6b7c]">Include the institution name, page link if available, your contact details, and what needs attention so the team can review it.</p>
                    <a href="mailto:info@studygreatermasaka.com?subject=Concern%20about%20Study%20Greater%20Masaka" class="mt-4 inline-block bg-[#082c56] px-4 py-2 text-sm font-bold text-white hover:bg-[#0b3768]">Email a concern</a>
                </div>
            </div>

            <aside class="border border-[#c7d7ea] bg-[#082c56] text-white shadow-sm">
                <div class="border-b border-white/10 p-5">
                    <p class="text-sm font-bold text-[#b8d7f5]">Send us a message</p>
                    <h2 class="mt-1 text-2xl font-bold">We are ready to help.</h2>
                </div>
                <div class="grid gap-4 p-5 text-sm leading-6 text-white/75">
                    <p>For faster support, include your name, phone number, location, and the institution or opportunity you are asking about.</p>
                    <div class="grid gap-3">
                        <div class="border border-white/15 bg-white/8 p-4">
                            <span class="block text-xs font-bold uppercase tracking-normal text-[#b8d7f5]">Profile corrections</span>
                            <span class="mt-1 block text-white">Tell us what information should be updated and which institution profile it belongs to.</span>
                        </div>
                        <div class="border border-white/15 bg-white/8 p-4">
                            <span class="block text-xs font-bold uppercase tracking-normal text-[#b8d7f5]">Partnerships</span>
                            <span class="mt-1 block text-white">Share your organization name and how you would like to work with Study Greater Masaka.</span>
                        </div>
                    </div>
                    <a href="mailto:info@studygreatermasaka.com" class="bg-[#f2b705] px-4 py-3 text-center font-bold text-[#082c56] hover:bg-[#dca400]">Email us</a>
                </div>
            </aside>
        </div>
    </section>

    <section class="mx-auto grid max-w-7xl gap-5 px-4 py-10 sm:px-6 md:grid-cols-3 lg:px-8">
        @foreach ([
            ['label' => 'Admissions support', 'text' => 'Ask about current application windows and where to find official institution details.'],
            ['label' => 'Opportunities', 'text' => 'Share scholarships, education jobs, guides, and local learning opportunities.'],
            ['label' => 'Institution updates', 'text' => 'Request profile corrections, claim access, or submit missing institution details.'],
        ] as $item)
            <article class="border border-[#c7d7ea] bg-white p-5 shadow-sm">
                <h2 class="text-lg font-bold text-[#082c56]">{{ $item['label'] }}</h2>
                <p class="mt-2 text-sm leading-6 text-[#5d6b7c]">{{ $item['text'] }}</p>
            </article>
        @endforeach
    </section>
</x-layouts.app>
