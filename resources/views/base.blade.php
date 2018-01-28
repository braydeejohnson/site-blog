<!doctype html>
<html lang="EN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="bg-grey-lighter">
<nav class="bg-grey-darkest p-6 flex justify-center shadow">
    <div class="container flex items-center justify-center flex-wrap">
        <div class="w-full font-semibold text-xl text-center text-white">Random posts from a tech-nerd.</div>
    </div>
</nav>
<div class="flex justify-center">
    <div class="w-full h-screen container flex">
        <div class="w-2/3 p-6">
            @for($post = 0; $post <= 3; $post++)
            <div class="w-full rounded overflow-hidden border bg-white mb-6">
                <div class="px-6 py-4">
                    <h2 class="font-bold text-xl text-grey-darker mb-2"><a class="no-underline text-grey-darker hover:text-red-dark" href="#">Blog Post Title</a></h2>
                    <div class="flex flex-wrap items-center justify-between text-xs">
                        <span class="text-grey-dark">Posted: {{ date('m/d/Y') }}</span>
                    </div>
                </div>
                <img class="w-full" src="https://tailwindcss.com/img/card-top.jpg" alt="Sunset in the mountains">
                <div class="px-6 py-4 relative">
                    <p class="text-grey-darker text-sm">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
                    </p>
                    <span class="absolute pin-b pin-r mr-6"><a class="text-xs text-grey-dark hover:text-red-dark no-underline" href="#">Read More</a></span>
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
            <div class="relative rounded overflow-hidden border text-center bg-white mb-8">
                <div class="bg-grey-darker h-24 pt-8">
                    <div class="text-xl text-white">Braydee Johnson</div>
                    <div class="text-xs text-grey-light">Web Developer</div>
                </div>
                <div class="absolute card-portrait"><img class="block h-12 border-4 border-white sm:h-16 rounded-full mx-auto mb-4 sm:mb-0 sm:mr-4 sm:ml-0" src="https://avatars1.githubusercontent.com/u/6641710?s=70&v=4" alt=""></div>
                <div class="px-6 py-4 h-24 text-center mt-2">
                    <p class="text-grey-darker text-xs">
                        I focus on developing great Web Applications. Creating a great experience requires understanding the story that your business is trying to tell, and how you want to tell that story. I'm here to help you tell the story of your business to the world.
                    </p>
                </div>
            </div>

            <div class="card ">
                <p class="text-red-darker">Hoobla</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>