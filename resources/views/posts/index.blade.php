<x-blog-layout>
    <section class="max-w-screen-lg mx-auto w-full">
        <h1 class="text-3xl font-bold">Posts</h1>

        <div class="mt-8">
            @foreach ($posts as $post)
            <a href="{{ route('posts.show', $post) }}" class="rounded border border-neutral-200 hover:border-neutral-400 p-4">
                    {{ $post->title }}
                </a>
            @endforeach
        </div>
    </section>
</x-blog-layout>
