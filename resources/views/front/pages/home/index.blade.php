@extends('front.layouts.master')
@section('title', 'Home')
@section('content')
    <main>
        <section class="pt-36"
            style="
  background: url('{{ asset('futech/assets/images/bg/hero-2.jpg') }}') no-repeat center
center/cover;
">
            <div class="mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="flex flex-col lg:flex-row items-center gap-14 justify-between">
                    <div class="lg:w-1/2 relative order-2 lg:order-1 pb-16 lg:pb-0">
                        <h1 class="text-5xl xl:text-6xl mb-3 xl:leading-snug font-bold text-white">
                            The Future <br />
                            Belongs to Those
                            <span class="relative"
                                style="
background: url('assets/images/shape/line-t.svg') no-repeat bottom;
  ">who
                                Learn </span>
                        </h1>
                        <p class="text-borderl-500 lg:text-xl text-lg xl:text-2xl mt-4 mb-8">
                            Guiding students to discover their unique talents <br />
                            and find to make strengths.
                        </p>
                        <div class="hidden xl:block">
                            <img src="assets/images/shape/o-arr.svg" class="absolute bottom-28 -left-36" alt />
                        </div>
                    </div>
                    <div class="lg:w-1/2 order-1 lg:order-2">
                        <div class="relative ">
                            <img src="{{ asset('futech/assets/images/person.png') }}" alt />
                            <ul class="hidden xl:block">
                                <li class="absolute -left-20 top-52">
                                    <img src="assets/images/hero/hero-two/sh-1.png" alt />
                                </li>
                                <li class="absolute -right-10 top-48">
                                    <img src="assets/images/hero/hero-two/sh-2.png" alt />
                                </li>
                                <li class="absolute bottom-20 -right-10">
                                    <img src="assets/images/hero/hero-two/sh-3.png" alt />
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="pb-10">
            <div class="container mx-auto px-4">
                <div data-aos="flip-up" class="flex flex-wrap aos-init aos-animate">
                    <div class="lg:pt-12 pt-6 w-full md:w-4/12 px-4 text-center">
                        <div
                            class="relative flex flex-col min-w-0 break-words bg-white shadow-md hover:shadow-xl hover:bg-yellow-50 transform hover:scale-110 transition duration-500 w-full mb-8 rounded-lg">
                            <div class="px-4 py-5 flex-auto">
                                <div
                                    class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-blue-400">
                                    <i class="fas fa-bullseye"></i>
                                </div>
                                <h6 class="text-xl font-medium">Our Mission</h6>
                                <p class="mt-2 mb-4 text-gray-500">Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry.</p>
                            </div>
                        </div>
                    </div>
                    <div class="lg:pt-12 pt-6 w-full md:w-4/12 px-4 text-center">
                        <div
                            class="relative flex flex-col min-w-0 break-words bg-white shadow-md hover:shadow-xl hover:bg-yellow-50 transform hover:scale-110 transition duration-500 w-full mb-8 rounded-lg">
                            <div class="px-4 py-5 flex-auto">
                                <div
                                    class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-red-400">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <h6 class="text-xl font-medium">Our Vision</h6>
                                <p class="mt-2 mb-4 text-gray-500">Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry.</p>
                            </div>
                        </div>
                    </div>
                    <div class="lg:pt-12 pt-6 w-full md:w-4/12 px-4 text-center">
                        <div
                            class="relative flex flex-col min-w-0 break-words bg-white shadow-md hover:shadow-xl hover:bg-yellow-50 transform hover:scale-110 transition duration-500 w-full mb-8 rounded-lg">
                            <div class="px-4 py-5 flex-auto">
                                <div
                                    class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-green-400">
                                    <i class="fas fa-crosshairs"></i>
                                </div>
                                <h6 class="text-xl font-medium">Our Goal</h6>
                                <p class="mt-2 mb-4 text-gray-500">Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry.</p>
                            </div>
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
                            <img src="{{asset('futech/assets/images/icons/ui.svg')}}" alt="">
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
                            <img src="{{asset('futech/assets/images/icons/ux.svg')}}" alt="">
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
                        <span class="gradient-text">Product <br>
                            Design</span>
                        <div
                            class="w-36 h-36 rounded-full inline-flex items-center justify-center bg-blue-600 bg-opacity-10 absolute -right-5 -top-5">
                            <img src="{{asset('futech/assets/images/icons/pd.svg')}}" alt="">
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
                            <img src="{{asset('futech/assets/images/icons/mk.svg')}}" alt="">
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
                            <img src="{{asset('futech/assets/images/icons/cont.svg')}}" alt="">
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
                            <img src="{{asset('futech/assets/images/icons/search.svg')}}" alt="">
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
                    <div class="p-4 md:w-1/3">
                        <div class="h-full rounded-xl overflow-hidden shadow-lg">
                            <img class="lg:h-48 md:h-36 w-full object-cover object-center  transform hover:scale-110 transition duration-500"
                                src="https://images.unsplash.com/photo-1618172193622-ae2d025f4032?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1064&q=80"
                                alt="blog">
                            <div class="p-6">
                                <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">
                                    CATEGORY-1</h2>
                                <h1 class="title-font text-lg font-medium text-gray-600 mb-3">The Catalyzer</h1>
                                <p class="leading-relaxed mb-3">Photo booth fam kinfolk cold-pressed sriracha leggings
                                    jianbing
                                    microdosing tousled waistcoat.</p>
                                <div class="flex items-center flex-wrap ">
                                    <button
                                        class="bg-black text-white transform hover:scale-110 transition duration-500 px-4 py-1 rounded-lg">Learn
                                        more</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 md:w-1/3">
                        <div class="h-full rounded-xl overflow-hidden shadow-lg">
                            <img class="lg:h-48 md:h-36 w-full object-cover object-center transform hover:scale-110 transition duration-500"
                                src="https://images.unsplash.com/photo-1624628639856-100bf817fd35?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8M2QlMjBpbWFnZXxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=600&q=60"
                                alt="blog">
                            <div class="p-6">
                                <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">
                                    CATEGORY-1</h2>
                                <h1 class="title-font text-lg font-medium text-gray-600 mb-3">The Catalyzer</h1>
                                <p class="leading-relaxed mb-3">Photo booth fam kinfolk cold-pressed sriracha leggings
                                    jianbing
                                    microdosing tousled waistcoat.</p>
                                <div class="flex items-center flex-wrap ">
                                    <button
                                        class="bg-black text-white transform hover:scale-110 transition duration-500 px-4 py-1 rounded-lg">Learn
                                        more</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 md:w-1/3">
                        <div class="h-full rounded-xl overflow-hidden shadow-lg">
                            <img class="lg:h-48 md:h-36 w-full object-cover object-center transform hover:scale-110 transition duration-500"
                                src="https://images.unsplash.com/photo-1631700611307-37dbcb89ef7e?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1yZWxhdGVkfDIwfHx8ZW58MHx8fHw%3D&auto=format&fit=crop&w=600&q=60"
                                alt="blog">
                            <div class="p-6">
                                <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">
                                    CATEGORY-1</h2>
                                <h1 class="title-font text-lg font-medium text-gray-600 mb-3">The Catalyzer</h1>
                                <p class="leading-relaxed mb-3">Photo booth fam kinfolk cold-pressed sriracha leggings
                                    jianbing
                                    microdosing tousled waistcoat.</p>
                                <div class="flex items-center flex-wrap ">
                                    <button
                                        class="bg-black text-white transform hover:scale-110 transition duration-500 px-4 py-1 rounded-lg">Learn
                                        more</button>
                                </div>
                            </div>
                        </div>
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
                                <img class="h-20 w-20" src="{{asset('futech/assets/images/clients/logo (1).png')}}" alt="">
                            </div>
                            <div>
                                <img class="h-20 w-full" src="{{asset('futech/assets/images/clients/logo.png')}}" alt="">
                            </div>
                            <div>
                                <img class="h-20 w-full" src="{{asset('futech/assets/images/clients/QUEEN-PNG.png')}}" alt="">
                            </div>
                            <div>
                                <img class="h-20 w-full" src="{{asset('futech/assets/images/clients/Royal-musk.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
