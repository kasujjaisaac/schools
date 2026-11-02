<x-layouts.admin :title="$article->exists ? 'Edit Guide' : 'Add Guide'">
    <section class="mx-auto max-w-4xl px-4 py-6 sm:px-5 lg:px-6">
        <a href="{{ route('admin.articles.index') }}" class="mb-5 inline-block text-sm font-semibold text-[#1d72b8]">Back to list</a>
<form method="POST" action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}" class="grid gap-4 bg-white p-6 ">@csrf @if ($article->exists) @method('PUT') @endif
        <h1 class="text-2xl font-bold text-[#082c56]">{{ $article->exists ? 'Edit Guide' : 'Add Guide' }}</h1>@if ($errors->any())<p class="bg-red-50 p-3 text-sm text-red-700">{{ $errors->first() }}</p>@endif
        <div class="grid gap-3 md:grid-cols-2"><input name="title" value="{{ old('title', $article->title) }}" class="border border-[#d9d2c3] px-3 py-2" placeholder="Title" required><input name="slug" value="{{ old('slug', $article->slug) }}" class="border border-[#d9d2c3] px-3 py-2" placeholder="Slug"><input name="category" value="{{ old('category', $article->category) }}" class="border border-[#d9d2c3] px-3 py-2" placeholder="Category" required><input type="datetime-local" name="published_at" value="{{ old('published_at', $article->published_at?->format('Y-m-d\\TH:i')) }}" class="border border-[#d9d2c3] px-3 py-2"></div>
        <textarea name="excerpt" rows="3" class="border border-[#d9d2c3] px-3 py-2" placeholder="Excerpt" required>{{ old('excerpt', $article->excerpt) }}</textarea><textarea name="content" rows="8" class="border border-[#d9d2c3] px-3 py-2" placeholder="Content">{{ old('content', $article->content) }}</textarea>
        <select name="status" class="border border-[#d9d2c3] px-3 py-2">@foreach (['draft','published','archived'] as $value)<option @selected(old('status', $article->status) === $value)>{{ $value }}</option>@endforeach</select><button class="bg-[#1d72b8] px-4 py-3 font-bold text-white">Save guide</button>
    </form></section>
</x-layouts.admin>
