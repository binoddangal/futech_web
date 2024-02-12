@extends('front.layouts.master')
@section('title', 'Home')
@section('content')
    <main>
        <section class="pt-36"
            style="
  background: url('{{ asset('assets/images/bg/hero-2.jpg') }}') no-repeat center
center/cover;
">
            <div class="mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="flex flex-col lg:flex-row items-center gap-14 justify-between">
                    <div class="lg:w-1/2 relative order-2 lg:order-1 pb-16 lg:pb-0">
                        <h1 class="text-5xl xl:text-6xl mb-3 xl:leading-snug font-bold text-white">
                            Welcometo <br />
                            Futech Solutions
                        </h1>
                        <p class="text-borderl-500 lg:text-xl text-lg xl:text-2xl mt-4 mb-8">
                            Futech Solutions, your destination for comprehensive IT solutions, invites you to embark on a
journey of innovation and transformation. We specialize in UI/UX design, product development,
SEO Specialists, digital marketing, and content writing at the crossroads of technology and
creativity.
                        </p>
                        <div class="flex items-center flex-wrap ">
                            <button onclick="window.location.href='{{ route('about') }}';"
                                class="bg-black text-white transform hover:scale-110 transition duration-500 px-4 py-1 rounded-lg">Learn
                                more</button>
                        </div>
                    </div>

                    <div class="lg:w-1/2 order-1 lg:order-2">
                        <div class="relative ">
                            <img src="{{ asset('assets/images/logo/Futech_Logo.png') }}" alt />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if (count($ourProjects))
            <section class="lg:py-120 py-20 bg-green-50">
                <div class="mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                    <div class="max-w-2xl mx-auto mb-10 text-center">
                        <h4 class="text-porange-700  leading-normal text-xl font-medium capitalize mb-2">
                            Our Services
                        </h4>
                        <h2 class="text-4xl leading-normal lg:text-5xl lg:leading-snug font-bold text-interface-100">
                            What we Provide to Every Clients
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                        @foreach ($ourProjects as $ourProject)
                            <div
                                class="bg-white rounded-custom p-6 overflow-hidden relative hover:shadow-custom transition-all hover:border-porange-500">
                                <span class="gradient-text">{{ $ourProject['title'] }}</span>
                                <div
                                    class="w-36 h-36 rounded-full inline-flex items-center justify-center bg-blue-600 bg-opacity-10 absolute -right-5 -top-5">
                                    @if ($ourProject && $ourProject->featured_photo_path)
                                        <img src="{{ $ourProject->featured_photo_path['real'] }}"
                                            alt="{{ $ourProject['title'] }}">
                                    @else
                                        <img style="height: 5rem;" src="{{ asset('assets/images/logo/Futech_Logo.png') }}"
                                            alt="{{ $ourProject['title'] }}">
                                    @endif
                                </div>
                                <h3 class="text-2xl font-bold mb-3 text-interface-100">
                                    {{ $ourProject['title'] }}
                                </h3>
                                <p class="text-lg text-interface-200 mb-3">
                                    {!! $ourProject['description'] !!}
                                </p>
                                {{-- <a href="#" class="text-interface-100 transition-all group text-base underline inline-flex">
                            <span>Learn more</span>
                            <svg class="stroke-interface-100 group-hover:stroke-porange-500" width="25" height="26"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M7 17L17 7M17 7H8M17 7V16" stroke="#000000" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </a> --}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

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

        <section class="lg:py-120 py-20">
            <div class="mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="grid lg:grid-cols-5 gap-8 lg:gap-12 items-center">
                    <div class="lg:col-span-2">
                        <h4 class="text-porange-500 text-xl font-medium capitalize mb-2">
                            Our Clients
                        </h4>
                        <h2 class="text-4xl leading-normal lg:text-5xl lg:leading-snug font-bold text-interface-100">
                            My Take care of our Customers
                        </h2>
                    </div>
                    <div class="lg:col-span-3 w-full">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-y-10">
                            <div>
                                <img class="h-20 w-20" src="{{ asset('assets/images/clients/logo (1).png') }}"
                                    alt="">
                            </div>
                            <div>
                                <img class="h-20 w-full" src="{{ asset('assets/images/clients/logo.png') }}" alt="">
                            </div>
                            <div>
                                <img class="h-20 w-full" src="{{ asset('assets/images/clients/QUEEN-PNG.png') }}"
                                    alt="">
                            </div>
                            <div>
                                <img class="h-20 w-full" src="{{ asset('assets/images/clients/Royal-musk.png') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
