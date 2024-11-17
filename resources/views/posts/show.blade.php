<x-blog-layout>
    <div class="px-4">
        <div class="prose prose-neutral prose-h1:font-bold prose-h1:text-xl prose-h2:text-lg mx-auto max-w-screen-md">
            {!! $html !!}
        </div>
    </div>

    <x-slot:vue>
        <div id="app" />
    </x-slot>
</x-blog-layout>
