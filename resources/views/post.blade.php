@extends('base')

@section('title')
    {{ $title }}
@endsection

@section('container')
    <div class="w-full h-screen container flex">
        <div class="w-2/3 p-6">
            <div class="w-full rounded overflow-hidden border bg-white mb-6 px-6 py-4">
                <span class="text-grey-dark font-semibold"><a class="no-underline text-grey-darker hover:text-red-dark" href="/">Blog</a></span>
                <span class="text-grey-dark font-hairline">&gt;</span>
                <span class="text-grey-dark text-muted">{{ $title }}</span>
            </div>
            <div class="w-full rounded overflow-hidden border bg-white mb-6">
                <div class="post">
                    {{ $body }}
                </div>
                <div class="mx-6 my-2 border-b border-grey-light"></div>
                <div class="px-6 pb-2">
                    @foreach($tags as $tag)
                        <a class="hover:text-red-dark" href="{{ url("/tags/$tag") }}"><span class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2">#{{ $tag }}</span></a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="w-1/3 h-screen p-6">
            @include('sidebar')
        </div>
    </div>
@endsection