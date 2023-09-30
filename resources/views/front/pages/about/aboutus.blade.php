@extends('front.layouts.master')
@section('title', 'About us')
@section('content')
    <main>
        <section class="pt-[235px] pb-[100px]"
            style="
background: url('{{ asset('futech/assets/images/bg/brcm.jpg') }}') no-repeat center
  center/cover;
">
            <div class="max-w-lg mx-auto text-center">
                <h1 class="text-5xl text-interface-100 font-semibold mb-2.5">
                    About us
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
                    <li class="text-xl font-medium text-interface-100">About us</li>
                </ul>
            </div>
        </section>
        <section class="pt-120 lg:pb-0 pb-120 py-20">
            <div class="mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-20">

                    <div class="relative">
                        <img src="{{ asset(asset('futech/assets/images/logo/Futech_Logo.png')) }}" class="w-full"
                            alt="">
                    </div>

                    <div>
                        <h2
                            class="text-interface-500 font-bold text-4xl leading-normal xl:text-5xl capitalize xl:leading-snug mb-4">
                            About
                            <span class="relative">
                                <span class="relative z-20">Futech Nepal</span>
                                <svg class="absolute -left-1 z-0 -top-2" width="211" height="69" viewBox="0 0 211 69"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M30.8353 5.20707C71.3242 4.06296 158.3 8.31774 193.87 22.426C232.179 37.6211 183.09 57.6423 130.454 63.5062C75.9959 69.573 16.3894 60.6604 5.75954 45.3131C-12.1857 19.4037 66.1136 2.68084 126.531 3.86657"
                                        stroke="#DAED1A" stroke-width="6" stroke-linecap="round"></path>
                                </svg>
                            </span>
                        </h2>
                        <p class="text-xl text-interface-200 mb-4">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                            the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                            of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                            but also the leap into electronic typesetting, remaining essentially unchanged. It was
                            popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                            and more recently with desktop publishing software like Aldus PageMaker including versions of
                            Lorem Ipsum.
                        </p>
                        <div>
                            <img src="{{ asset(asset('futech/assets/images/icons/ux.svg')) }}" alt="">
                            <span class="text-xl text-interface-100 font-medium">CEO &amp; Founder of QuomodoSoft</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                    <div
                        class="bg-white rounded-custom p-6 overflow-hidden relative hover:shadow-custom transition-all hover:border-porange-500">
                        <span class="gradient-text">UI <br>
                            Design</span>
                        <div
                            class="w-36 h-36 rounded-full inline-flex items-center justify-center bg-blue-600 bg-opacity-10 absolute -right-5 -top-5">
                            <img src="http://futech.local/futech/assets/images/icons/ui.svg" alt="">
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-interface-100">
                            UI Design
                        </h3>
                        <p class="text-lg text-interface-200 mb-3">
                            Pellentesque non nibh sapien to a find rutrrnec into a
                            vestibulum in aand find to mollis.
                        </p>
                        <a href="#" class="text-interface-100 transition-all group text-base underline inline-flex">
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
                        </a>
                    </div>
                    <div class="bg-white rounded-custom p-6 overflow-hidden relative transition-all">
                        <span class="gradient-text">UX <br>
                            Design</span>
                        <div
                            class="w-36 h-36 rounded-full inline-flex items-center justify-center bg-blue-600 bg-opacity-10 absolute -right-5 -top-5">
                            <img src="http://futech.local/futech/assets/images/icons/ux.svg" alt="">
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-interface-100">
                            UX Design
                        </h3>
                        <p class="text-lg text-interface-200 mb-3">
                            Pellentesque non nibh sapien to a find rutrrnec into a
                            vestibulum in aand find to mollis.
                        </p>
                        <a href="#" class="text-interface-100 transition-all group text-base underline inline-flex">
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
                        </a>
                    </div>
                    <div class="bg-white rounded-custom p-6 overflow-hidden relative transition-all">
                        <span class="gradient-text">Product <br>
                            Design</span>
                        <div
                            class="w-36 h-36 rounded-full inline-flex items-center justify-center bg-blue-600 bg-opacity-10 absolute -right-5 -top-5">
                            <img src="http://futech.local/futech/assets/images/icons/pd.svg" alt="">
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-interface-100">
                            Product Design
                        </h3>
                        <p class="text-lg text-interface-200 mb-3">
                            Pellentesque non nibh sapien to a find rutrrnec into a
                            vestibulum in aand find to mollis.
                        </p>
                        <a href="#" class="text-interface-100 transition-all group text-base underline inline-flex">
                            <span>Learn more</span>
                            <svg class="stroke-interface-100 group-hover:stroke-porange-500" width="25"
                                height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M7 17L17 7M17 7H8M17 7V16" stroke="#000000" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </a>
                    </div>
                    <div class="bg-white rounded-custom p-6 overflow-hidden relative transition-all">
                        <span class="gradient-text">Digital <br>
                            Marketing</span>
                        <div
                            class="w-36 h-36 rounded-full inline-flex items-center justify-center bg-blue-600 bg-opacity-10 absolute -right-5 -top-5">
                            <img src="http://futech.local/futech/assets/images/icons/mk.svg" alt="">
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-interface-100">
                            Digital Marketing
                        </h3>
                        <p class="text-lg text-interface-200 mb-3">
                            Pellentesque non nibh sapien to a find rutrrnec into a
                            vestibulum in aand find to mollis.
                        </p>
                        <a href="#" class="text-interface-100 transition-all group text-base underline inline-flex">
                            <span>Learn more</span>
                            <svg class="stroke-interface-100 group-hover:stroke-porange-500" width="25"
                                height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M7 17L17 7M17 7H8M17 7V16" stroke="#000000" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </a>
                    </div>
                    <div class="bg-white rounded-custom p-6 overflow-hidden relative transition-all">
                        <span class="gradient-text">Content <br>
                            Writing</span>
                        <div
                            class="w-36 h-36 rounded-full inline-flex items-center justify-center bg-blue-600 bg-opacity-10 absolute -right-5 -top-5">
                            <img src="http://futech.local/futech/assets/images/icons/cont.svg" alt="">
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-interface-100">
                            Content Writing
                        </h3>
                        <p class="text-lg text-interface-200 mb-3">
                            Pellentesque non nibh sapien to a find rutrrnec into a
                            vestibulum in aand find to mollis.
                        </p>
                        <a href="#" class="text-interface-100 transition-all group text-base underline inline-flex">
                            <span>Learn more</span>
                            <svg class="stroke-interface-100 group-hover:stroke-porange-500" width="25"
                                height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M7 17L17 7M17 7H8M17 7V16" stroke="#000000" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </a>
                    </div>
                    <div class="bg-white rounded-custom p-6 overflow-hidden relative transition-all">
                        <span class="gradient-text">SEO<br>
                            Specialist</span>
                        <div
                            class="w-36 h-36 rounded-full inline-flex items-center justify-center bg-blue-600 bg-opacity-10 absolute -right-5 -top-5">
                            <img src="http://futech.local/futech/assets/images/icons/search.svg" alt="">
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-interface-100">
                            SEO Specialist
                        </h3>
                        <p class="text-lg text-interface-200 mb-3">
                            Pellentesque non nibh sapien to a find rutrrnec into a
                            vestibulum in aand find to mollis.
                        </p>
                        <a href="#" class="text-interface-100 transition-all group text-base underline inline-flex">
                            <span>Learn more</span>
                            <svg class="stroke-interface-100 group-hover:stroke-porange-500" width="25"
                                height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M7 17L17 7M17 7H8M17 7V16" stroke="#000000" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
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
                                <img class="h-20 w-20" src="http://futech.local/futech/assets/images/clients/logo (1).png"
                                    alt="">
                            </div>
                            <div>
                                <img class="h-20 w-full" src="http://futech.local/futech/assets/images/clients/logo.png"
                                    alt="">
                            </div>
                            <div>
                                <img class="h-20 w-full"
                                    src="http://futech.local/futech/assets/images/clients/QUEEN-PNG.png" alt="">
                            </div>
                            <div>
                                <img class="h-20 w-full"
                                    src="http://futech.local/futech/assets/images/clients/Royal-musk.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
