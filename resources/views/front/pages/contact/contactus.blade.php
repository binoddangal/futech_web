@extends('front.layouts.master')
@section('title', 'Contact Us')
@section('content')
    <main>
        <section class="pt-[235px] pb-[100px]"
            style="
background: url('{{ asset('assets/images/bg/brcm.jpg') }}') no-repeat center
  center/cover;
">
            <div class="max-w-lg mx-auto text-center">
                <h1 class="text-5xl text-interface-100 font-semibold mb-2.5">
                    Contact Us
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
                    <li class="text-xl font-medium text-interface-100">Contact Us</li>
                </ul>
            </div>
        </section>
        <section class="mt-20">
            <div class="mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <div
                    class="grid lg:grid-cols-2 bg-[#F8FBFF] divide-y lg:divide-y-0 lg:divide-x divide-[#DFEAF9] border border-[#DFEAF9] shadow-customFive rounded-[15px]">

                    @if (getSetting() && getSetting()->address)
                        <div class="flex flex-col md:flex-row  gap-6 py-14 px-20">
                            <div>
                                <img src="{{ asset('assets/images/icons/ci-1.svg') }}" alt="">
                            </div>
                            <div class="grow">
                                <h4 class="text-2xl font-semibold text-interface-100">
                                    Our Address
                                </h4>
                                <address class="text-lg text-interface-200 not-italic">
                                    {!! getSetting()->address !!}
                                </address>
                            </div>
                        </div>
                    @endif

                    <div class="flex flex-col md:flex-row gap-6 py-14 px-20">
                        <div>
                            <img src="{{ asset('assets/images/icons/ci-2.svg') }}" alt="">
                        </div>
                        <div class="grow">
                            <h4 class="text-2xl font-semibold text-interface-100">
                                Contact Info
                            </h4>
                            <p class="text-lg text-interface-200 not-italic">
                                Open a chat or give us call at <br>
                                @if (getSetting() && getSetting()->phone)
                                    <a href="tel:{!! getSetting()->phone !!}"
                                        class="font-bold text-interface-100">{!! getSetting()->phone !!}</a> <br>
                                @endif
                                @if (getSetting() && getSetting()->email)
                                    <a href="mailto:{!! getSetting()->email !!}"
                                        class="font-bold text-interface-100">{!! getSetting()->email !!}</a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-20">
            <div class="mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="place-items-center">
                    <div class="xl:col-span-4">

                        <div class="px-8 py-10 rounded-lg"
                            style="
                          background: url('{{ asset('assets/images/bg/contact-form-bg-shape.jpg') }}')
                            no-repeat center center/cover;
                        ">
                            <form>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-7 gap-y-5">
                                    <div>
                                        <label for="fname"
                                            class="block mb-2 text-base font-medium text-interface-100">First Name</label>
                                        <input type="text" placeholder="Max"
                                            class="px-4 py-2.5 bg-white rounded-lg border-0 w-full placeholder:text-blue-200 placeholder:text-sm focus:ring-0 focus:border focus:border-blue-700">
                                    </div>
                                    <div>
                                        <label for="lname"
                                            class="block mb-2 text-base font-medium text-interface-100">Last Name</label>
                                        <input type="text" placeholder="Mustermann"
                                            class="px-4 py-2.5 bg-white rounded-lg border-0 w-full placeholder:text-interface-200 placeholder:text-sm focus:ring-0 focus:border focus:border-porange-700">
                                    </div>
                                    <div>
                                        <label for="email"
                                            class="block mb-2 text-base font-medium text-interface-100">Email</label>
                                        <input type="text" placeholder="Mustermann"
                                            class="px-4 py-2.5 bg-white rounded-lg border-0 w-full placeholder:text-interface-200 placeholder:text-sm focus:ring-0 focus:border focus:border-porange-700">
                                    </div>
                                    <div>
                                        <label for="telephone"
                                            class="block mb-2 text-base font-medium text-interface-100">Telephone</label>
                                        <input type="text" placeholder="Mustermann"
                                            class="px-4 py-2.5 bg-white rounded-lg border-0 w-full placeholder:text-interface-200 placeholder:text-sm focus:ring-0 focus:border focus:border-porange-700">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="telephone"
                                            class="block mb-2 text-base font-medium text-interface-100">Description</label>
                                        <textarea type="text" placeholder="Mustermann"
                                            class="px-4 py-2.5 bg-white rounded-lg border-0 w-full placeholder:text-interface-200 placeholder:text-sm resize-none h-40 focus:ring-0 focus:border focus:border-porange-700">                      </textarea>
                                    </div>
                                </div>
                                <div class="mt-8 flex justify-end">
                                    <button
                                        class="py-4 px-6 rounded-lg bg-porange-700 transition-all hover:bg-porange-900 text-interface-100 font-medium text-lg">
                                        Send Now
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @if (getSetting() && getSetting()->map_url)
            <section class="mx-auto py-20 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="w-full h-96">
                    {!! getSetting()->map_url !!}
                    {{-- <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3531.7556425573225!2d85.322988!3d27.72483!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19b17cf31635%3A0xc8831dd91bee2135!2sChaa%20Brothers%20Trade%20Pvt%20Ltd!5e0!3m2!1sen!2sus!4v1692968881946!5m2!1sen!2sus"
                    class="w-full  h-96" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
                </div>
            </section>
        @endif
    </main>
@endsection
