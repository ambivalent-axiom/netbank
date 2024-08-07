<div>
    <div class="m-4 text-4xl">
        <h1>
            {{ $newsArticles->author }}
        </h1>
    </div>
    <div class="mb-3 font-bold">
        {{ $newsArticles->title }}
    </div>
    <div class="mb-2 ">
        <img
            src="{{ $newsArticles->image }}"
            class="rounded-2xl"
        >
    </div>
    <div>
        <a href="{{ $newsArticles->url }}">
            {{ $newsArticles->description }}
        </a>
    </div>
</div>
