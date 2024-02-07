@extends('front.layouts.master')
@section('title', 'Blog')
@section('content')
    <main>
        <section class="pt-[235px] pb-[100px]"
            style="
background: url('{{ asset('futech/assets/images/bg/brcm.jpg') }}') no-repeat center
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
                                    <button window.location.href="{{ route('blogdetail') }}";
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
                                    <button window.location.href="{{ route('blogdetail') }}";
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
                                    <button window.location.href="{{ route('blogdetail') }}";
                                        class="bg-black text-white transform hover:scale-110 transition duration-500 px-4 py-1 rounded-lg">Learn
                                        more</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
