<x-layouts.app title="Create Account">
    <section class="mx-auto max-w-md px-4 py-12">
        <form method="POST" action="{{ route('register.store') }}" class="grid gap-4 rounded-lg border border-[#ded6c8] bg-white p-6">
            @csrf
            <h1 class="text-2xl font-bold">Create account</h1>
            @if ($errors->any())<p class="rounded-md bg-red-50 p-3 text-sm text-red-700">{{ $errors->first() }}</p>@endif
            <input name="name" value="{{ old('name') }}" class="rounded-md border border-[#d9d2c3] px-3 py-2" placeholder="Name" required>
            <input name="email" value="{{ old('email') }}" class="rounded-md border border-[#d9d2c3] px-3 py-2" placeholder="Email" required>
            <input name="password" type="password" class="rounded-md border border-[#d9d2c3] px-3 py-2" placeholder="Password" required>
            <input name="password_confirmation" type="password" class="rounded-md border border-[#d9d2c3] px-3 py-2" placeholder="Confirm password" required>
            <button class="rounded-md bg-[#1d72b8] px-4 py-3 font-bold text-white">Create account</button>
        </form>
    </section>
</x-layouts.app>
