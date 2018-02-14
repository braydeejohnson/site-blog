@extends('base')

@section('title')
    Blog Home
@endsection

@section('container')
    <div class="w-full h-screen container flex">
        <div class="w-2/3 p-6">
            @foreach($posts as $post)
                <div class="w-full rounded overflow-hidden border bg-white mb-6">
                    <div class="px-6 py-4">
                        <h2 class="font-bold text-2xl text-grey-darker mb-4"><a class="no-underline text-grey-darker hover:text-red-dark" href="{{ url($post["slug"]) }}">{{ $post["title"] }}</a></h2>
                        <div class="flex flex-wrap items-center justify-between text-xs">
                            <span class="text-grey-dark"><span>@icon('calendar.svg', 'h-3 fill-current text-red-dark')&nbsp;</span>{{ $post['date'] }}</span>
                        </div>
                        <div class="my-2 border-b border-grey-light"></div>
                    </div>
                    {{--<img class="w-full" src="https://picsum.photos/1024/500?random" alt="Sunset in the mountains">--}}
                    <div class="px-6 py-4 relative post">
                        {!! $post['body'] !!}
                        <span class="absolute pin-b pin-r mr-6"><a class="text-xs text-grey-dark hover:text-red-dark no-underline" href="{{ url($post["slug"]) }}">Read More</a></span>
                    </div>
                    <div class="mx-6 my-2 border-b border-grey-light"></div>
                    <div class="px-6 py-4">
                        @foreach($post['tags'] as $tag)
                        <a class="hover:text-red-dark" href="{{ url("/tags/$tag") }}"><span class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2">#{{ $tag }}</span></a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <div class="w-1/3 h-screen p-6">
            @include('sidebar')
        </div>
    </div>
@endsection