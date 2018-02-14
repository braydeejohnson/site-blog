@extends('base')

@section('container')
    <div class="w-full h-screen container flex">
        <div class="w-2/3 p-6">
            @for($post = 0; $post < 40; $post++)
                <div class="w-full rounded overflow-hidden border bg-white mb-6">
                    <div class="px-6 py-4">
                        <h2 class="font-bold text-2xl text-grey-darker mb-4"><a class="no-underline text-grey-darker hover:text-red-dark" href="{{ url('/slug') }}">Blog Post Title</a></h2>
                        <div class="flex flex-wrap items-center justify-between text-xs">
                            <span class="text-grey-dark"><span>@icon('calendar.svg', 'h-3 fill-current text-red-dark')&nbsp;</span>{{ date('Y-m-d') }}</span>
                        </div>
                    </div>
                    <img class="w-full" src="https://picsum.photos/1024/500?image={{$post}}" alt="Sunset in the mountains">
                    <div class="px-6 py-4 relative">
                        <p class="text-grey-darker text-sm">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
                        </p>
                        <span class="absolute pin-b pin-r mr-6"><a class="text-xs text-grey-dark hover:text-red-dark no-underline" href="{{ url('/slug') }}">Read More</a></span>
                    </div>
                    <div class="mx-6 my-2 border-b border-grey-light"></div>
                    <div class="px-6 py-4">
                        <span class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2">#tag1</span>
                        <span class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2">#tag2</span>
                        <span class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker">#tag3</span>
                    </div>
                </div>
            @endfor
        </div>
        <div class="w-1/3 h-screen p-6">
            @include('sidebar')
        </div>
    </div>
@endsection