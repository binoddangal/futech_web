@extends('front.layouts.master')
@section('title', 'Blog details')
@section('content')
    <main>
        <section class="pt-[235px] pb-[100px]"
            style="
background: url('{{ asset('futech/assets/images/bg/brcm.jpg') }}') no-repeat center
  center/cover;
">
            <div class="max-w-lg mx-auto text-center">
                <h1 class="text-5xl text-interface-100 font-semibold mb-2.5">
                    Blog details
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
                    <li class="text-xl font-medium text-interface-100">Blog details</li>
                </ul>
            </div>
        </section>
        <div class="overflow-x-hidden">

            <div class="px-6 py-8">
                <div class="container flex justify-between mx-auto">
                    <div class="w-full lg:w-8/12">
                        <div class="mt-6">
                            <div class="max-w-4xl px-10 py-6 mx-auto bg-white rounded-lg shadow-md">
                                <div class="w-full bg-cover bg-center" style="height:20rem; background-image: url('{{asset('futech/assets/images/bg/hero-2.jpg')}}');">
                                </div>
                                <div class="flex py-2 items-center justify-between"><span class="font-light text-gray-600">March 27,
                                        2020</span><a href="#" class="px-2 py-1 font-bold text-white bg-gray-600 rounded hover:bg-gray-800">Category</a>
                                </div>
                                <div class="mt-2"><a href="#" class="text-2xl font-bold text-gray-600 hover:text-gray-800">The Catalyzer</a>
                                    <p class="mt-2 text-justify text-gray-600">Lorem Ipsum is simply dummy text of the
                                        printing and typesetting industry. Lorem Ipsum has been the industry's standard
                                        dummy text ever since the 1500s, when an unknown printer took a galley of type and
                                        scrambled it to make a type specimen
                                        book. It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially
                                        unchanged. It was popularised in the 1960s with the release of Letraset sheets
                                        containing Lorem Ipsum passages, and more
                                        recently with desktop publishing software like Aldus PageMaker including versions of
                                        Lorem Ipsum. <br>
                                        It is a long established fact that a reader will be distracted by the readable
                                        content of a page when looking at its
                                        layout. The point of using Lorem Ipsum is that it has a more-or-less normal
                                        distribution of letters, as opposed to using
                                        'Content here, content here', making it look like readable English. Many desktop
                                        publishing packages and web page
                                        editors now use Lorem Ipsum as their default model text, and a search for 'lorem
                                        ipsum' will uncover many web sites
                                        still in their infancy. Various versions have evolved over the years, sometimes by
                                        accident, sometimes on purpose
                                        (injected humour and the like). <br>
                                        Lorem Ipsum is simply dummy text of the
                                        printing and typesetting industry. Lorem Ipsum has been the industry's standard
                                        dummy text ever since the 1500s, when an unknown printer took a galley of type and
                                        scrambled it to make a type specimen
                                        book. It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially
                                        unchanged. It was popularised in the 1960s with the release of Letraset sheets
                                        containing Lorem Ipsum passages, and more
                                        recently with desktop publishing software like Aldus PageMaker including versions of
                                        Lorem Ipsum. <br>
                                        It is a long established fact that a reader will be distracted by the readable
                                        content of a page when looking at its
                                        layout. The point of using Lorem Ipsum is that it has a more-or-less normal
                                        distribution of letters, as opposed to using
                                        'Content here, content here', making it look like readable English. Many desktop
                                        publishing packages and web page
                                        editors now use Lorem Ipsum as their default model text, and a search for 'lorem
                                        ipsum' will uncover many web sites
                                        still in their infancy. Various versions have evolved over the years, sometimes by
                                        accident, sometimes on purpose
                                        (injected humour and the like).</p>
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    <div>
                                        <h1 class="font-bold text-gray-600 hover:text-gray-800">Binod Dangal</h1>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden w-4/12 -mx-8 lg:block">
                        <div class="px-8 mt-10">
                            <h1 class="mb-4 text-xl font-bold text-gray-800">Categories</h1>
                            <div class="flex flex-col max-w-sm px-4 py-6 mx-auto bg-white rounded-lg shadow-md">
                                <ul>
                                    <li><a href="#" class="mx-1 font-bold text-gray-700 hover:text-gray-600 hover:underline">-
                                            category</a><span class="text-sm flex -mt-6 justify-end font-light text-gray-700">
                                            23</span> </li>
                                    <li class="mt-2"><a href="#" class="mx-1 font-bold text-gray-700 hover:text-gray-600 hover:underline">-
                                            category</a><span class="text-sm flex -mt-6 justify-end font-light text-gray-700">
                                            30
                                        </span> </li>
                                    <li class="mt-2"><a href="#" class="mx-1 font-bold text-gray-700 hover:text-gray-600 hover:underline">-
                                            category</a><span class="text-sm flex -mt-6 justify-end font-light text-gray-700">
                                            80
                                        </span> </li>
                                    <li class="mt-2"><a href="#" class="mx-1 font-bold text-gray-700 hover:text-gray-600 hover:underline">-
                                            category</a><span class="text-sm flex -mt-6 justify-end font-light text-gray-700">
                                            110
                                        </span> </li>
                                    <li class="mt-2"><a href="#" class="mx-1 font-bold text-gray-700 hover:text-gray-600 hover:underline">-
                                            category</a><span class="text-sm flex -mt-6 justify-end font-light text-gray-700">
                                            10
                                        </span> </li>
                                    <li class="mt-2"><a href="#" class="mx-1 font-bold text-gray-700 hover:text-gray-600 hover:underline">-
                                            category</a><span class="text-sm flex -mt-6 justify-end font-light text-gray-700">
                                            70
                                        </span> </li>
                                </ul>
                            </div>
                        </div>
                        <div class="px-8 mt-10">
                            <h1 class="mb-4 text-xl font-bold text-gray-800">Recent Post</h1>
                            <div class="flex flex-col max-w-sm px-8 py-2 mx-auto bg-white rounded-lg shadow-md">

                                <div class="mt-4"><a href="#" class="text-lg font-medium text-gray-600 hover:text-gray-800">The Title</a></div>
                                <div class="flex items-center justify-left"><a href="#" class="px-2 py-1 text-sm text-white bg-gray-600 rounded hover:bg-gray-800">category</a>
                                </div>
                                <p class="mt-2  text-justify text-gray-600">Lorem ipsum dolor sit, amet
                                    consectetur
                                    adipisicing elit.
                                    Tempora expedita dicta totam aspernatur doloremque. Excepturi iste iusto eos enim.
                                </p>
                            </div>
                            <div class="flex my-2 flex-col max-w-sm px-8 py-2 mx-auto bg-white rounded-lg shadow-md">
                                <div class="mt-4"><a href="#" class="text-lg font-medium text-gray-600 hover:text-gray-800">The Title</a></div>
                                <div class="flex items-center justify-left"><a href="#" class="px-2 py-1 text-sm text-white bg-gray-600 rounded hover:bg-gray-800">category</a>
                                </div>
                                <p class="mt-2  text-justify text-gray-600">Lorem ipsum dolor sit, amet
                                    consectetur
                                    adipisicing elit.
                                    Tempora expedita dicta totam aspernatur doloremque. Excepturi iste iusto eos enim.
                                </p>
                            </div>
                            <div class="flex my-2 flex-col max-w-sm px-8 py-2 mx-auto bg-white rounded-lg shadow-md">
                                <div class="mt-4"><a href="#" class="text-lg font-medium text-gray-600 hover:text-gray-800">The Title</a></div>
                                <div class="flex items-center justify-left"><a href="#" class="px-2 py-1 text-sm text-white bg-gray-600 rounded hover:bg-gray-800">category</a>
                                </div>
                                <p class="mt-2  text-justify text-gray-600">Lorem ipsum dolor sit, amet
                                    consectetur
                                    adipisicing elit.
                                    Tempora expedita dicta totam aspernatur doloremque. Excepturi iste iusto eos enim.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
