@extends('front.layouts.master')
@section('title', 'Blog details')
@section('content')
    <main>
        <section class="pt-[235px] pb-[100px]"
            style="
background: url('{{ asset('assets/images/bg/brcm.jpg') }}') no-repeat center
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
        <section class="py-20 lg:py-120">
            <div class="mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <div>
                    <div class="pb-5 border-b border-b-interface-200">
                        <div class="relative">
                            <img src="{{ asset('assets/images/bg/brcm.jpg') }}" class="rounded-lg w-full" alt />
                            <div class="absolute bg-white top-4 flex items-center right-4 rounded-md py-3 px-4 gap-3">
                                <button class="inline-flex items-center gap-1 text-xs text-interface-200 font-medium">
                                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M9.41797 2.5H11.0846C15.2268 2.5 18.5846 5.85786 18.5846 10C18.5846 14.1421 15.2268 17.5 11.0846 17.5H5.2513C3.41035 17.5 1.91797 16.0076 1.91797 14.1667V10C1.91797 5.85786 5.27583 2.5 9.41797 2.5ZM10.2513 10.8333C10.7115 10.8333 11.0846 10.4602 11.0846 10C11.0846 9.53976 10.7115 9.16667 10.2513 9.16667C9.79106 9.16667 9.41797 9.53976 9.41797 10C9.41797 10.4602 9.79106 10.8333 10.2513 10.8333ZM14.418 10C14.418 10.4602 14.0449 10.8333 13.5846 10.8333C13.1244 10.8333 12.7513 10.4602 12.7513 10C12.7513 9.53976 13.1244 9.16667 13.5846 9.16667C14.0449 9.16667 14.418 9.53976 14.418 10ZM6.91797 10.8333C7.37821 10.8333 7.7513 10.4602 7.7513 10C7.7513 9.53976 7.37821 9.16667 6.91797 9.16667C6.45773 9.16667 6.08464 9.53976 6.08464 10C6.08464 10.4602 6.45773 10.8333 6.91797 10.8333Z"
                                            fill="#747681" />
                                    </svg>
                                    <span>03</span>
                                </button>
                                <button class="inline-flex items-center gap-1 text-xs text-interface-200 font-medium">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.0003 4.60352L10.6379 3.91857C12.3984 2.02714 15.2527 2.02714 17.0133 3.91857C18.7738 5.81 18.7738 8.87661 17.0133 10.768L11.2754 16.9326C10.5712 17.6891 9.42945 17.6891 8.72524 16.9326L2.98738 10.768C1.22686 8.87662 1.22686 5.81 2.98738 3.91857C4.7479 2.02714 7.60227 2.02714 9.36278 3.91857L10.0003 4.60352ZM14.167 4.375C13.8218 4.375 13.542 4.65482 13.542 5C13.542 5.34518 13.8218 5.625 14.167 5.625C14.7423 5.625 15.2087 6.09137 15.2087 6.66667C15.2087 7.01184 15.4885 7.29167 15.8337 7.29167C16.1788 7.29167 16.4587 7.01184 16.4587 6.66667C16.4587 5.40101 15.4326 4.375 14.167 4.375Z"
                                            fill="#FF0640" />
                                    </svg>
                                    <span>200</span>
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between mt-10">
                            <div>
                                <h4 class="text-lg font-medium text-interface-500">
                                    Crated by Admin
                                </h4>
                                <span>20 Jan. 2023</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="text-lg font-medium text-interface-500">Share this Service</span>
                                <div class="flex space-x-3">
                                    <a href="http://"
                                        class="text-white bg-interface-100 hover:bg-blue-500 transition-all text-lg w-10 h-10 rounded-full inline-flex justify-center items-center"
                                        target="_blank" rel="noopener noreferrer">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="http://"
                                        class="text-white bg-interface-100 hover:bg-blue-500 transition-all text-lg w-10 h-10 rounded-full inline-flex justify-center items-center"
                                        target="_blank" rel="noopener noreferrer">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="http://"
                                        class="text-white bg-interface-100 hover:bg-blue-500 transition-all text-lg w-10 h-10 rounded-full inline-flex justify-center items-center"
                                        target="_blank" rel="noopener noreferrer">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a href="http://"
                                        class="text-white bg-interface-100 hover:bg-blue-500 transition-all text-lg w-10 h-10 rounded-full inline-flex justify-center items-center"
                                        target="_blank" rel="noopener noreferrer">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-10">
                        <h3 class="text-2xl font-semibold mb-5">
                            We offer training to organizations of all sizes.
                        </h3>
                        <p class="text-xl text-interface-200 mb-5">
                            It is a long established fact that a reader will be distracted
                            by the readable content of a page when looking at its layout.
                            The point of using Lorem Ipsum is that it has a the a
                            more-or-less normal distribution of letters, as opposed to using
                            '
                        </p>
                        <p class="text-xl text-interface-200 mb-10">
                            Content here, content here', making it look like readable
                            English. Many desktop into a publishing packages and web page
                            editors now use Lorem Ipsum as their default to a model text,
                            and a search for 'lorem ipsum' will uncover many web sites still
                            in their to infancy. Various versions have evolved over the
                            years, sometimes by accident, sometimes on purpose injected
                            humour and the like
                        </p>
                        <h3 class="text-2xl font-semibold mb-5">
                            Do your research ahead of time
                        </h3>
                        <p class="text-xl text-interface-200">
                            It is a long established fact that a reader will be distracted
                            by the readable content of a page when looking at its layout.
                            The point of using Lorem Ipsum is that it has a the a
                            more-or-less normal distribution of letters, as opposed to using
                            '
                        </p>
                    </div>
                    <ul class="mt-10 mb-14 space-y-2 list-disc pl-5">
                        <li class="text-interface-200 text-xl">
                            Brainwriting: Everyone writes down three ideas and passes their
                            ideas to the person on their left (or right), who builds off
                            those ideas before passing them on again. This way, ideas can
                            cross-pollinate, morph and build on top of each other from
                            different perspectives. After all, two heads are better than
                            one.
                        </li>
                        <li class="text-interface-200 text-xl">
                            Rapid ideation: Everyone writes down as many ideas as they can
                            in a set amount of time before anything is discussed or
                            critiqued. This is a fun way to get all the good (and bad) ideas
                            out fast and bring a sense of fun urgency to the session.
                        </li>
                        <li class="text-interface-200 text-xl">
                            Figure storming: The group picks a well-known figure who is not
                            in the room and asks how they would approach the problem. For
                            example, “How would Barack Obama (or Harry Potter, or anyone
                            else) approach this problem?” - prepare for some funny answers
                            here, this method is a good ice-breaker for everyone involved.
                        </li>
                    </ul>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <div class="lg:col-span-1 w-full">
                        <div class="bg-white p-8 shadow-custom rounded border border-borderl-500">
                            <h4 class="text-lg text-interface-100 font-semibold mb-4">
                                Latest Blog
                            </h4>
                            <div class="space-y-7">
                                <article class="flex space-x-4">
                                    <a href class="block">
                                        <img src="{{asset('assets/images/logo/Futech_Logo.png')}}" class="rounded w-20" alt />
                                    </a>
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">
                                            Organic Food Isn’t Much Better Health.
                                        </h3>
                                        <span class="flex space-x-3">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.9894 3.25799C17.9894 5.27443 17.9894 7.29086 17.9894 9.30729C17.941 9.26327 17.897 9.21924 17.8486 9.17962C17.4833 8.85382 17.1225 8.51921 16.7485 8.20222C16.634 8.10536 16.5768 8.02611 16.5812 7.87202C16.5944 7.45376 16.5856 7.0311 16.5856 6.60844C11.5162 6.60844 6.46879 6.60844 1.40817 6.60844C1.40817 6.68329 1.40817 6.74933 1.40817 6.81097C1.40817 9.78719 1.40817 12.7634 1.40817 15.7396C1.40817 16.312 1.6722 16.5805 2.24428 16.5805C4.0617 16.5805 5.87472 16.5893 7.69214 16.5717C7.99138 16.5673 8.1982 16.629 8.32142 16.9063C8.34782 16.9636 8.39623 17.012 8.44024 17.0604C8.73067 17.3686 9.02551 17.6812 9.31594 17.9894C6.83404 17.9894 4.35213 17.9894 1.86583 17.9894C1.79102 17.9718 1.72061 17.9542 1.6458 17.9366C0.65568 17.6988 0.00440054 16.8711 0 15.8409C0 13.9345 0 12.0238 0 10.113C0 7.92045 0 5.73231 0 3.53977C0 2.50954 0.65128 1.66422 1.6458 1.45729C2.00225 1.38245 2.37629 1.41326 2.74594 1.39565C2.81194 1.39125 2.87795 1.39565 2.96156 1.39565C2.96156 0.911358 2.96156 0.45788 2.96156 0C3.43242 0 3.89008 0 4.36093 0C4.36093 0.466686 4.36093 0.920163 4.36093 1.38245C7.45451 1.38245 10.5349 1.38245 13.6373 1.38245C13.6373 0.91576 13.6373 0.453477 13.6373 0C14.1169 0 14.5746 0 15.0454 0C15.0454 0.466686 15.0454 0.924566 15.0454 1.39565C15.3491 1.39565 15.6395 1.38685 15.9344 1.39565C16.612 1.42207 17.1577 1.70825 17.5758 2.24537C17.8046 2.54476 17.9102 2.89697 17.9894 3.25799ZM13.6373 2.81332C10.5305 2.81332 7.45011 2.81332 4.35213 2.81332C4.35213 3.28001 4.35213 3.73348 4.35213 4.19577C3.88128 4.19577 3.42362 4.19577 2.94396 4.19577C2.94396 3.72468 2.94396 3.2668 2.94396 2.80011C2.66233 2.80011 2.39829 2.79571 2.13426 2.80011C1.69861 2.80892 1.40817 3.09509 1.40377 3.53096C1.39937 3.95802 1.40377 4.38508 1.40377 4.81214C1.40377 4.93102 1.40377 5.05429 1.40377 5.17316C6.47319 5.17316 11.525 5.17316 16.5812 5.17316C16.5812 4.59201 16.59 4.02406 16.5768 3.45611C16.568 3.12591 16.3216 2.83974 15.9916 2.80892C15.6791 2.7825 15.3623 2.80452 15.0322 2.80452C15.0322 3.2756 15.0322 3.73348 15.0322 4.19136C14.557 4.19136 14.1037 4.19136 13.6373 4.19136C13.6373 3.73348 13.6373 3.28001 13.6373 2.81332Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M12.9041 17.9869C12.4465 17.8768 11.9668 17.8195 11.5311 17.6478C10.0878 17.0755 9.10644 16.0321 8.70599 14.5307C8.19113 12.6244 8.69279 10.9646 10.1714 9.65255C11.2451 8.69717 12.5301 8.33174 13.9514 8.55628C15.6588 8.82485 16.8778 9.77583 17.5863 11.3388C17.7799 11.7614 17.8415 12.2457 17.9647 12.6992C17.9823 12.7609 17.9867 12.8225 17.9999 12.8841C17.9999 13.1175 17.9999 13.3508 17.9999 13.5886C17.9383 13.8967 17.9075 14.2137 17.8151 14.5131C17.3751 16.0012 16.4377 17.0623 14.9944 17.639C14.5543 17.8151 14.0703 17.8724 13.6082 17.9869C13.3706 17.9869 13.1373 17.9869 12.9041 17.9869ZM13.2518 16.5824C15.0868 16.5824 16.5918 15.0767 16.5918 13.2407C16.5874 11.4092 15.0956 9.91231 13.265 9.90351C11.4299 9.8947 9.92054 11.396 9.91614 13.2363C9.91174 15.0723 11.4167 16.578 13.2518 16.5824Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M2.67773 9.47263C2.67773 9.00567 2.67773 8.55192 2.67773 8.08496C3.14006 8.08496 3.59359 8.08496 4.06032 8.08496C4.06032 8.53871 4.06032 9.00126 4.06032 9.47263C3.6068 9.47263 3.14887 9.47263 2.67773 9.47263Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M6.87967 8.08496C6.87967 8.55192 6.87967 9.00567 6.87967 9.46822C6.41294 9.46822 5.95501 9.46822 5.48828 9.46822C5.48828 9.00567 5.48828 8.55192 5.48828 8.08496C5.94621 8.08496 6.40413 8.08496 6.87967 8.08496Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M9.69508 8.08472C9.69508 8.55168 9.69508 9.00542 9.69508 9.46798C9.23275 9.46798 8.77923 9.46798 8.3125 9.46798C8.3125 9.01423 8.3125 8.55608 8.3125 8.08472C8.76602 8.08472 9.22395 8.08472 9.69508 8.08472Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M2.67773 12.2788C2.67773 11.8162 2.67773 11.3581 2.67773 10.8955C3.14447 10.8955 3.60239 10.8955 4.06912 10.8955C4.06912 11.3581 4.06912 11.8118 4.06912 12.2788C3.6112 12.2788 3.15327 12.2788 2.67773 12.2788Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M5.48828 12.2832C5.48828 11.8162 5.48828 11.3625 5.48828 10.8955C5.95061 10.8955 6.40413 10.8955 6.87086 10.8955C6.87086 11.3493 6.87086 11.8118 6.87086 12.2832C6.41734 12.2832 5.95942 12.2832 5.48828 12.2832Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M2.67773 13.7061C3.14447 13.7061 3.59799 13.7061 4.06032 13.7061C4.06032 14.1686 4.06032 14.6224 4.06032 15.0893C3.6068 15.0893 3.14887 15.0893 2.67773 15.0893C2.67773 14.6356 2.67773 14.1774 2.67773 13.7061Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M6.87967 13.7168C6.87967 14.1794 6.87967 14.6331 6.87967 15.1001C6.41294 15.1001 5.95501 15.1001 5.48828 15.1001C5.48828 14.6419 5.48828 14.1838 5.48828 13.7168C5.9418 13.7168 6.39973 13.7168 6.87967 13.7168Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M12.5293 10.8955C12.9958 10.8955 13.449 10.8955 13.9199 10.8955C13.9199 11.4414 13.9199 11.9786 13.9199 12.5333C14.3203 12.5333 14.7076 12.5333 15.108 12.5333C15.108 13.0088 15.108 13.4623 15.108 13.929C14.2587 13.929 13.4006 13.929 12.5293 13.929C12.5293 12.9251 12.5293 11.9169 12.5293 10.8955Z"
                                                    fill="#2662FA" />
                                            </svg>
                                            <span class="text-pcolor-500 text-base">
                                                31 May 2023</span>
                                        </span>
                                    </div>
                                </article>
                                <article class="flex space-x-4">
                                    <a href class="block">
                                        <img src="{{asset('assets/images/logo/Futech_Logo.png')}}" class="rounded w-20" alt />
                                    </a>
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">
                                            The Start-Up Ultimate Guide to Make ....
                                        </h3>
                                        <span class="flex space-x-3">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.9894 3.25799C17.9894 5.27443 17.9894 7.29086 17.9894 9.30729C17.941 9.26327 17.897 9.21924 17.8486 9.17962C17.4833 8.85382 17.1225 8.51921 16.7485 8.20222C16.634 8.10536 16.5768 8.02611 16.5812 7.87202C16.5944 7.45376 16.5856 7.0311 16.5856 6.60844C11.5162 6.60844 6.46879 6.60844 1.40817 6.60844C1.40817 6.68329 1.40817 6.74933 1.40817 6.81097C1.40817 9.78719 1.40817 12.7634 1.40817 15.7396C1.40817 16.312 1.6722 16.5805 2.24428 16.5805C4.0617 16.5805 5.87472 16.5893 7.69214 16.5717C7.99138 16.5673 8.1982 16.629 8.32142 16.9063C8.34782 16.9636 8.39623 17.012 8.44024 17.0604C8.73067 17.3686 9.02551 17.6812 9.31594 17.9894C6.83404 17.9894 4.35213 17.9894 1.86583 17.9894C1.79102 17.9718 1.72061 17.9542 1.6458 17.9366C0.65568 17.6988 0.00440054 16.8711 0 15.8409C0 13.9345 0 12.0238 0 10.113C0 7.92045 0 5.73231 0 3.53977C0 2.50954 0.65128 1.66422 1.6458 1.45729C2.00225 1.38245 2.37629 1.41326 2.74594 1.39565C2.81194 1.39125 2.87795 1.39565 2.96156 1.39565C2.96156 0.911358 2.96156 0.45788 2.96156 0C3.43242 0 3.89008 0 4.36093 0C4.36093 0.466686 4.36093 0.920163 4.36093 1.38245C7.45451 1.38245 10.5349 1.38245 13.6373 1.38245C13.6373 0.91576 13.6373 0.453477 13.6373 0C14.1169 0 14.5746 0 15.0454 0C15.0454 0.466686 15.0454 0.924566 15.0454 1.39565C15.3491 1.39565 15.6395 1.38685 15.9344 1.39565C16.612 1.42207 17.1577 1.70825 17.5758 2.24537C17.8046 2.54476 17.9102 2.89697 17.9894 3.25799ZM13.6373 2.81332C10.5305 2.81332 7.45011 2.81332 4.35213 2.81332C4.35213 3.28001 4.35213 3.73348 4.35213 4.19577C3.88128 4.19577 3.42362 4.19577 2.94396 4.19577C2.94396 3.72468 2.94396 3.2668 2.94396 2.80011C2.66233 2.80011 2.39829 2.79571 2.13426 2.80011C1.69861 2.80892 1.40817 3.09509 1.40377 3.53096C1.39937 3.95802 1.40377 4.38508 1.40377 4.81214C1.40377 4.93102 1.40377 5.05429 1.40377 5.17316C6.47319 5.17316 11.525 5.17316 16.5812 5.17316C16.5812 4.59201 16.59 4.02406 16.5768 3.45611C16.568 3.12591 16.3216 2.83974 15.9916 2.80892C15.6791 2.7825 15.3623 2.80452 15.0322 2.80452C15.0322 3.2756 15.0322 3.73348 15.0322 4.19136C14.557 4.19136 14.1037 4.19136 13.6373 4.19136C13.6373 3.73348 13.6373 3.28001 13.6373 2.81332Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M12.9041 17.9869C12.4465 17.8768 11.9668 17.8195 11.5311 17.6478C10.0878 17.0755 9.10644 16.0321 8.70599 14.5307C8.19113 12.6244 8.69279 10.9646 10.1714 9.65255C11.2451 8.69717 12.5301 8.33174 13.9514 8.55628C15.6588 8.82485 16.8778 9.77583 17.5863 11.3388C17.7799 11.7614 17.8415 12.2457 17.9647 12.6992C17.9823 12.7609 17.9867 12.8225 17.9999 12.8841C17.9999 13.1175 17.9999 13.3508 17.9999 13.5886C17.9383 13.8967 17.9075 14.2137 17.8151 14.5131C17.3751 16.0012 16.4377 17.0623 14.9944 17.639C14.5543 17.8151 14.0703 17.8724 13.6082 17.9869C13.3706 17.9869 13.1373 17.9869 12.9041 17.9869ZM13.2518 16.5824C15.0868 16.5824 16.5918 15.0767 16.5918 13.2407C16.5874 11.4092 15.0956 9.91231 13.265 9.90351C11.4299 9.8947 9.92054 11.396 9.91614 13.2363C9.91174 15.0723 11.4167 16.578 13.2518 16.5824Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M2.67773 9.47263C2.67773 9.00567 2.67773 8.55192 2.67773 8.08496C3.14006 8.08496 3.59359 8.08496 4.06032 8.08496C4.06032 8.53871 4.06032 9.00126 4.06032 9.47263C3.6068 9.47263 3.14887 9.47263 2.67773 9.47263Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M6.87967 8.08496C6.87967 8.55192 6.87967 9.00567 6.87967 9.46822C6.41294 9.46822 5.95501 9.46822 5.48828 9.46822C5.48828 9.00567 5.48828 8.55192 5.48828 8.08496C5.94621 8.08496 6.40413 8.08496 6.87967 8.08496Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M9.69508 8.08472C9.69508 8.55168 9.69508 9.00542 9.69508 9.46798C9.23275 9.46798 8.77923 9.46798 8.3125 9.46798C8.3125 9.01423 8.3125 8.55608 8.3125 8.08472C8.76602 8.08472 9.22395 8.08472 9.69508 8.08472Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M2.67773 12.2788C2.67773 11.8162 2.67773 11.3581 2.67773 10.8955C3.14447 10.8955 3.60239 10.8955 4.06912 10.8955C4.06912 11.3581 4.06912 11.8118 4.06912 12.2788C3.6112 12.2788 3.15327 12.2788 2.67773 12.2788Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M5.48828 12.2832C5.48828 11.8162 5.48828 11.3625 5.48828 10.8955C5.95061 10.8955 6.40413 10.8955 6.87086 10.8955C6.87086 11.3493 6.87086 11.8118 6.87086 12.2832C6.41734 12.2832 5.95942 12.2832 5.48828 12.2832Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M2.67773 13.7061C3.14447 13.7061 3.59799 13.7061 4.06032 13.7061C4.06032 14.1686 4.06032 14.6224 4.06032 15.0893C3.6068 15.0893 3.14887 15.0893 2.67773 15.0893C2.67773 14.6356 2.67773 14.1774 2.67773 13.7061Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M6.87967 13.7168C6.87967 14.1794 6.87967 14.6331 6.87967 15.1001C6.41294 15.1001 5.95501 15.1001 5.48828 15.1001C5.48828 14.6419 5.48828 14.1838 5.48828 13.7168C5.9418 13.7168 6.39973 13.7168 6.87967 13.7168Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M12.5293 10.8955C12.9958 10.8955 13.449 10.8955 13.9199 10.8955C13.9199 11.4414 13.9199 11.9786 13.9199 12.5333C14.3203 12.5333 14.7076 12.5333 15.108 12.5333C15.108 13.0088 15.108 13.4623 15.108 13.929C14.2587 13.929 13.4006 13.929 12.5293 13.929C12.5293 12.9251 12.5293 11.9169 12.5293 10.8955Z"
                                                    fill="#2662FA" />
                                            </svg>
                                            <span class="text-pcolor-500 text-base">
                                                31 May 2023</span>
                                        </span>
                                    </div>
                                </article>
                                <article class="flex space-x-4">
                                    <a href class="block">
                                        <img src="{{asset('assets/images/logo/Futech_Logo.png')}}" class="rounded w-20" alt />
                                    </a>
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">
                                            Definitive Guide to Make a Daily ....
                                        </h3>
                                        <span class="flex space-x-3">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17.9894 3.25799C17.9894 5.27443 17.9894 7.29086 17.9894 9.30729C17.941 9.26327 17.897 9.21924 17.8486 9.17962C17.4833 8.85382 17.1225 8.51921 16.7485 8.20222C16.634 8.10536 16.5768 8.02611 16.5812 7.87202C16.5944 7.45376 16.5856 7.0311 16.5856 6.60844C11.5162 6.60844 6.46879 6.60844 1.40817 6.60844C1.40817 6.68329 1.40817 6.74933 1.40817 6.81097C1.40817 9.78719 1.40817 12.7634 1.40817 15.7396C1.40817 16.312 1.6722 16.5805 2.24428 16.5805C4.0617 16.5805 5.87472 16.5893 7.69214 16.5717C7.99138 16.5673 8.1982 16.629 8.32142 16.9063C8.34782 16.9636 8.39623 17.012 8.44024 17.0604C8.73067 17.3686 9.02551 17.6812 9.31594 17.9894C6.83404 17.9894 4.35213 17.9894 1.86583 17.9894C1.79102 17.9718 1.72061 17.9542 1.6458 17.9366C0.65568 17.6988 0.00440054 16.8711 0 15.8409C0 13.9345 0 12.0238 0 10.113C0 7.92045 0 5.73231 0 3.53977C0 2.50954 0.65128 1.66422 1.6458 1.45729C2.00225 1.38245 2.37629 1.41326 2.74594 1.39565C2.81194 1.39125 2.87795 1.39565 2.96156 1.39565C2.96156 0.911358 2.96156 0.45788 2.96156 0C3.43242 0 3.89008 0 4.36093 0C4.36093 0.466686 4.36093 0.920163 4.36093 1.38245C7.45451 1.38245 10.5349 1.38245 13.6373 1.38245C13.6373 0.91576 13.6373 0.453477 13.6373 0C14.1169 0 14.5746 0 15.0454 0C15.0454 0.466686 15.0454 0.924566 15.0454 1.39565C15.3491 1.39565 15.6395 1.38685 15.9344 1.39565C16.612 1.42207 17.1577 1.70825 17.5758 2.24537C17.8046 2.54476 17.9102 2.89697 17.9894 3.25799ZM13.6373 2.81332C10.5305 2.81332 7.45011 2.81332 4.35213 2.81332C4.35213 3.28001 4.35213 3.73348 4.35213 4.19577C3.88128 4.19577 3.42362 4.19577 2.94396 4.19577C2.94396 3.72468 2.94396 3.2668 2.94396 2.80011C2.66233 2.80011 2.39829 2.79571 2.13426 2.80011C1.69861 2.80892 1.40817 3.09509 1.40377 3.53096C1.39937 3.95802 1.40377 4.38508 1.40377 4.81214C1.40377 4.93102 1.40377 5.05429 1.40377 5.17316C6.47319 5.17316 11.525 5.17316 16.5812 5.17316C16.5812 4.59201 16.59 4.02406 16.5768 3.45611C16.568 3.12591 16.3216 2.83974 15.9916 2.80892C15.6791 2.7825 15.3623 2.80452 15.0322 2.80452C15.0322 3.2756 15.0322 3.73348 15.0322 4.19136C14.557 4.19136 14.1037 4.19136 13.6373 4.19136C13.6373 3.73348 13.6373 3.28001 13.6373 2.81332Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M12.9041 17.9869C12.4465 17.8768 11.9668 17.8195 11.5311 17.6478C10.0878 17.0755 9.10644 16.0321 8.70599 14.5307C8.19113 12.6244 8.69279 10.9646 10.1714 9.65255C11.2451 8.69717 12.5301 8.33174 13.9514 8.55628C15.6588 8.82485 16.8778 9.77583 17.5863 11.3388C17.7799 11.7614 17.8415 12.2457 17.9647 12.6992C17.9823 12.7609 17.9867 12.8225 17.9999 12.8841C17.9999 13.1175 17.9999 13.3508 17.9999 13.5886C17.9383 13.8967 17.9075 14.2137 17.8151 14.5131C17.3751 16.0012 16.4377 17.0623 14.9944 17.639C14.5543 17.8151 14.0703 17.8724 13.6082 17.9869C13.3706 17.9869 13.1373 17.9869 12.9041 17.9869ZM13.2518 16.5824C15.0868 16.5824 16.5918 15.0767 16.5918 13.2407C16.5874 11.4092 15.0956 9.91231 13.265 9.90351C11.4299 9.8947 9.92054 11.396 9.91614 13.2363C9.91174 15.0723 11.4167 16.578 13.2518 16.5824Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M2.67773 9.47263C2.67773 9.00567 2.67773 8.55192 2.67773 8.08496C3.14006 8.08496 3.59359 8.08496 4.06032 8.08496C4.06032 8.53871 4.06032 9.00126 4.06032 9.47263C3.6068 9.47263 3.14887 9.47263 2.67773 9.47263Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M6.87967 8.08496C6.87967 8.55192 6.87967 9.00567 6.87967 9.46822C6.41294 9.46822 5.95501 9.46822 5.48828 9.46822C5.48828 9.00567 5.48828 8.55192 5.48828 8.08496C5.94621 8.08496 6.40413 8.08496 6.87967 8.08496Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M9.69508 8.08472C9.69508 8.55168 9.69508 9.00542 9.69508 9.46798C9.23275 9.46798 8.77923 9.46798 8.3125 9.46798C8.3125 9.01423 8.3125 8.55608 8.3125 8.08472C8.76602 8.08472 9.22395 8.08472 9.69508 8.08472Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M2.67773 12.2788C2.67773 11.8162 2.67773 11.3581 2.67773 10.8955C3.14447 10.8955 3.60239 10.8955 4.06912 10.8955C4.06912 11.3581 4.06912 11.8118 4.06912 12.2788C3.6112 12.2788 3.15327 12.2788 2.67773 12.2788Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M5.48828 12.2832C5.48828 11.8162 5.48828 11.3625 5.48828 10.8955C5.95061 10.8955 6.40413 10.8955 6.87086 10.8955C6.87086 11.3493 6.87086 11.8118 6.87086 12.2832C6.41734 12.2832 5.95942 12.2832 5.48828 12.2832Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M2.67773 13.7061C3.14447 13.7061 3.59799 13.7061 4.06032 13.7061C4.06032 14.1686 4.06032 14.6224 4.06032 15.0893C3.6068 15.0893 3.14887 15.0893 2.67773 15.0893C2.67773 14.6356 2.67773 14.1774 2.67773 13.7061Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M6.87967 13.7168C6.87967 14.1794 6.87967 14.6331 6.87967 15.1001C6.41294 15.1001 5.95501 15.1001 5.48828 15.1001C5.48828 14.6419 5.48828 14.1838 5.48828 13.7168C5.9418 13.7168 6.39973 13.7168 6.87967 13.7168Z"
                                                    fill="#2662FA" />
                                                <path
                                                    d="M12.5293 10.8955C12.9958 10.8955 13.449 10.8955 13.9199 10.8955C13.9199 11.4414 13.9199 11.9786 13.9199 12.5333C14.3203 12.5333 14.7076 12.5333 15.108 12.5333C15.108 13.0088 15.108 13.4623 15.108 13.929C14.2587 13.929 13.4006 13.929 12.5293 13.929C12.5293 12.9251 12.5293 11.9169 12.5293 10.8955Z"
                                                    fill="#2662FA" />
                                            </svg>
                                            <span class="text-pcolor-500 text-base">
                                                31 May 2023</span>
                                        </span>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-8 shadow-custom rounded border border-borderl-500">
                        <h4 class="text-lg text-interface-100 font-semibold mb-4">
                            Category
                        </h4>
                        <ul class="flex flex-wrap gap-3">
                            <li>
                                <a href="#"
                                    class="py-2 px-4 flex justify-between items-center text-pcolor-500 hover:bg-blue-500 hover:text-white text-base transition-all rounded border border-borderl-500">
                                    Sass Landing
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="py-2 px-4 flex justify-between items-center text-pcolor-500 hover:bg-blue-500 hover:text-white text-base transition-all rounded border border-borderl-500">
                                    Sass Landing
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="py-2 px-4 flex justify-between items-center text-pcolor-500 hover:bg-blue-500 hover:text-white text-base transition-all rounded border border-borderl-500">
                                    UI Kit
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="py-2 px-4 flex justify-between items-center text-pcolor-500 hover:bg-blue-500 hover:text-white text-base transition-all rounded border border-borderl-500">
                                    App Landing
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="py-2 px-4 flex justify-between items-center text-pcolor-500 hover:bg-blue-500 hover:text-white text-base transition-all rounded border border-borderl-500">
                                    Web UI
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="py-2 px-4 flex justify-between items-center text-pcolor-500 hover:bg-blue-500 hover:text-white text-base transition-all rounded border border-borderl-500">
                                    iOS
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="py-2 px-4 flex justify-between items-center text-pcolor-500 hover:bg-blue-500 hover:text-white text-base transition-all rounded border border-borderl-500">
                                    Landing Page
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="py-2 px-4 flex justify-between items-center text-pcolor-500 hover:bg-blue-500 hover:text-white text-base transition-all rounded border border-borderl-500">
                                    Mobile UI
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="py-2 px-4 flex justify-between items-center text-pcolor-500 hover:bg-blue-500 hover:text-white text-base transition-all rounded border border-borderl-500">
                                    Wireframe
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="py-2 px-4 flex justify-between items-center text-pcolor-500 hover:bg-blue-500 hover:text-white text-base transition-all rounded border border-borderl-500">
                                    UI/UX
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="py-2 px-4 flex justify-between items-center text-pcolor-500 hover:bg-blue-500 hover:text-white text-base transition-all rounded border border-borderl-500">
                                    UI Color
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="py-2 px-4 flex justify-between items-center text-pcolor-500 hover:bg-blue-500 hover:text-white text-base transition-all rounded border border-borderl-500">
                                    Prototyping
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
