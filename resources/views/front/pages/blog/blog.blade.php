@extends('front.layouts.master')
@section('title', 'Blog')
@section('content')
    <main>
        <section class="pt-[235px] pb-[100px]"
            style="
background: url('{{ asset('assets/images/bg/brcm.jpg') }}') no-repeat center
  center/cover;
">
            <div class="max-w-lg mx-auto text-center">
                <h1 class="text-5xl text-interface-100 font-semibold mb-2.5">
                    Blog
                </h1>
                <ul class="flex justify-center items-center space-x-2">
                    <li class="text-xl font-medium text-interface-100">Home</li>
                    <li>
                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 7.5L14 12.5L10 17.5" stroke="#04091E" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </svg>
                    </li>
                    <li class="text-xl font-medium text-interface-100">Blog</li>
                </ul>
            </div>
        </section>
        @if (count($blogs))
            <section class="text-gray-600 body-font">
                <div class="container px-4 py-24 mx-auto">
                    <div class="max-w-2xl mx-auto mb-10 text-center">
                        <h4 class="text-porange-700  leading-normal text-xl font-medium capitalize mb-2">
                            Our Blogs
                        </h4>
                        <h2 class="text-4xl leading-normal lg:text-5xl lg:leading-snug font-bold text-black">
                            Stay Up To Date With Our News.
                        </h2>
                    </div>
                    <div class="flex flex-wrap -m-4">
                        @foreach ($blogs as $blog)
                        <div class="p-4 md:w-1/3">
                            <div class="h-full rounded-xl overflow-hidden shadow-lg">
                                @if ($blog->image)
                                <img class="lg:h-48 md:h-36 w-full object-cover object-center  transform hover:scale-110 transition duration-500"
                                    src="{{ $blog->image_path['real'] }}" alt="{{ $blog->title }}">
                                    @else
                                    <img class="lg:h-48 md:h-36 w-full object-cover object-center  transform hover:scale-110 transition duration-500"
                                    src="{{asset('assets/images/bg.jpg')}}" alt="{{ $blog->title }}">
                                    @endif

                                <div class="p-6">
                                    <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">
                                        {{ $blog->categories[0]->title }}</h2>
                                    <h1 class="title-font text-lg font-medium text-gray-600 mb-3">{{ $blog->title }}</h1>
                                    <p class="leading-relaxed mb-3">{!! Str::limit($blog->content, 100, '...') !!}</p>
                                    <div class="flex items-center flex-wrap ">
                                        <button
                                            class="bg-black text-white transform hover:scale-110 transition duration-500 px-4 py-1 rounded-lg">Learn
                                            more</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </main>
@endsection
