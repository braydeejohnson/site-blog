@extends('base')

@section('container')
    <div class="w-full h-screen container flex">
        <div class="w-2/3 p-6">
            <div class="w-full rounded overflow-hidden border bg-white mb-6 px-6 py-4">
                <span class="text-grey-dark font-semibold"><a class="no-underline text-grey-darker hover:text-red-dark" href="/">Blog</a></span>
                <span class="text-grey-dark font-hairline">&gt;</span>
                <span class="text-grey-dark text-muted">Blog Post Title</span>
            </div>
            <div class="w-full rounded overflow-hidden border bg-white mb-6">
                <div class="post">
                    {{ $body }}
                </div>
                <div class="mx-6 my-2 border-b border-grey-light"></div>
                <div class="px-6 py-4">
                    <span class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2">#tag1</span>
                    <span class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2">#tag2</span>
                    <span class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker">#tag3</span>
                </div>
            </div>
        </div>
        <div class="w-1/3 h-screen p-6">
            @include('sidebar')
        </div>
    </div>
@endsection