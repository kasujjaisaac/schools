@props(['statuses' => []])
<form method="GET" action="{{ url()->current() }}" class="mt-6 flex flex-wrap items-end gap-3 rounded-none border border-slate-200 bg-white p-4">
    <label class="grid min-w-48 flex-1 gap-2 text-xs font-semibold text-slate-600">
        Search records
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search by name or title…" maxlength="120" class="w-full rounded-none border border-slate-300 px-3 py-2.5 text-sm font-normal text-slate-900 focus:border-blue-500 focus:outline-2 focus:outline-blue-100">
    </label>
    @if ($statuses)
        <label class="grid gap-2 text-xs font-semibold text-slate-600">Status
            <select name="status" class="rounded-none border border-slate-300 bg-white px-3 py-2.5 text-sm font-normal"><option value="">All statuses</option>@foreach ($statuses as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>@endforeach</select>
        </label>
    @endif
    <button class="rounded-none bg-[#082c56] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#1d72b8]">Apply filters</button>
    <a href="{{ url()->current() }}" class="rounded-none px-3 py-2.5 text-sm font-semibold text-slate-500 hover:bg-slate-50">Reset</a>
</form>
