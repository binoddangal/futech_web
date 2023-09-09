<header class="main-header">

    <div class="mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="flex justify-between py-3">
            <div class="grow">
                <div class="flex space-x-0 md:space-x-14">

                    <div class="flex items-center space-x-2">
                        <i class="fas fa-envelope text-porange-700"></i>
                        <a href="#" class="text-black text-base"><span>info@futech.com</span></a>
                    </div>

                    <div class="space-x-2 hidden md:flex items-center">
                        <i class="fas fa-phone text-porange-700"></i>
                        <a href="#" class="text-black text-base">+977 9860098323</a>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-6">
                <a href="http://" class="group transition-all text-black hover:text-porange-700" target="_blank">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="http://" class="group transition-all text-black hover:text-porange-700" target="_blank">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="http://" class="group transition-all text-black hover:text-porange-700" target="_blank">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="http://" class="group transition-all text-black hover:text-porange-700" target="_blank">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="main-menu sticky-header">
        <div class="mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
            <nav class="nav nav-teacher">
                <div class="nav__data">
                    <a href="{{ route('home') }}" class="nav__logo">
                        <img src="{{ asset('futech/assets/images/logo/Futech_Logo.png') }}" alt />
                    </a>
                    <div class="nav__toggle" id="nav-toggle">
                        <i class="fas fa-bars nav__toggle-menu"></i>
                        <svg class="nav__toggle-close" fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                            <path x-show="!open" fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                                clip-rule="evenodd" style="display: none;"></path>
                            <path x-show="open" fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <!-- <i class="fas fa-x nav__toggle-close"></i> -->
                    </div>
                </div>
                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">

                        <li class="">
                            <a href="{{ route('home') }}" class="nav__link">
                                Home
                            </a>
                        </li>

                        <li class="">
                            <a href="#" class="nav__link">
                                Services
                            </a>
                        </li>

                        <li class="">
                            <a href="#" class="nav__link">
                                Portfolio
                            </a>
                        </li>

                        <li class="">
                            <a href="#" class="nav__link">
                                Blog
                            </a>
                        </li>

                        <li class="">
                            <a href="#" class="nav__link">
                                About Us
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="hidden xl:block">
                    <a href="{{ route('contact') }}"
                        class="bg-porange-700 group text-interface-100 px-6 py-4 font-medium rounded-lg inline-flex justify-center items-center transition-all hover:bg-porange-900">
                        <span>Let's Talk <i class="fas fa-arrow-right fa-sm mt-1 "></i></span>
                    </a>
                </div>
            </nav>
        </div>
    </div>
</header>
