@php use Carbon\Carbon; @endphp
<div>
    @foreach($newsArticles as $article)
        <div class="flex justify-between m-4 text-4xl">
            <h1>
                {{ $article->author }}
            </h1>
            <p class="text-base"
            >Published at:
                {{ Carbon::parse($article->published_at)->timezone('Europe/Riga') }}</p>
        </div>
        <div class="mb-3 font-bold">
            {{ $article->title }}
        </div>
        <div class="mb-2 ">
            <img
                src="{{ $article->image }}"
                class="rounded-2xl"
            >
        </div>
        <div>
            <a href="{{ $article->url }}">
                {{ $article->description }}
            </a>
        </div>
    @endforeach
    <div class="mt-4">
        {{ $newsArticles->links() }}
    </div>
</div>
