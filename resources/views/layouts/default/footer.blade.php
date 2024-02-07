    <!-- ==Footer Section == -->
    <div class="relative mt-16 bg-futech">
        <div class="px-4 pt-12 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8">
            <div class="grid gap-16 row-gap-10 mb-8 lg:grid-cols-6">
                <div class="md:max-w-md lg:col-span-2">
                    <img src="{{ getLogo(true) }}" class="mr-3 h-9 sm:h-12" alt="futech Logo" />
                    <div class="mt-4 lg:max-w-sm">
                        <p class="text-sm text-white">
                            Nepal Taiwan Culture Centre is a well-known nongovernmental organization (NGO) established in 2018 by a group of intellectual circles coming from diverse professional backgrounds.
                        </p>
                    </div>
                </div>
                <div class="grid gap-5 row-gap-10 lg:col-span-4 md:grid-cols-3">
                    <div>
                        <p class="font-semibold tracking-wide text-gray-900">
                            Useful Links
                        </p>
                        <ul class="mt-2 space-y-2">
                            <li>
                                <a href="/page/about-futech"
                                    class="transition-colors duration-300 text-white hover:text-gray-500">About futech
                                    Nepal</a>
                            </li>
                            <li>
                                <a href="/team"
                                    class="transition-colors duration-300 text-white hover:text-gray-500">Meet the
                                    Team</a>
                            </li>
                            {{-- <li>
                                <a href="/blog"
                                    class="transition-colors duration-300 text-white hover:text-gray-500">Blogs</a>
                            </li>
                            <li>
                                <a href="/news"
                                    class="transition-colors duration-300 text-white hover:text-gray-500">News and
                                    Updates</a>
                            </li> --}}
                        </ul>
                    </div>
                    <div>
                        <p class="font-semibold tracking-wide text-gray-900">
                            Contact Us
                        </p>
                        <ul class="mt-2 space-y-2">
                            @if (getSetting() && getSetting()->address)
                                <p class="text-sm text-white">
                                    futech <br> {!! getSetting()->address !!}
                                </p>
                            @endif
                            @if (getSetting() && getSetting()->phone)
                                <li>
                                    <a href=""
                                        class="transition-colors duration-300 text-white hover:text-gray-500">Phone:
                                        {!! getSetting()->phone !!}</a>
                                </li>
                            @endif
                            @if (getSetting() && getSetting()->email)
                                <li>
                                    <a href="/"
                                        class="transition-colors duration-300 text-white hover:text-gray-500">Email:
                                        {!! getSetting()->email !!}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    {{-- <div>
                        <p class="font-semibold tracking-wide text-gray-500">
                            Find Us
                        </p>
                        <ul class="mt-2 space-y-2">
                            <iframe class="w-full s:w-52"
                                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7065.498039010097!2d85.33028600000002!3d27.694151!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb1996f5c132a3%3A0x59fe1e4a3369083a!2sntcc%20Nepal!5e0!3m2!1sen!2snp!4v1684318869608!5m2!1sen!2snp"
                                style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </ul>
                    </div> --}}
                </div>
            </div>
            <br>
            <div class="flex flex-col justify-between pt-5 pb-10 border-t border-blue-800 sm:flex-row">
                <p class="text-sm text-gray-100">
                    © Copyright 2024 <a class="text-black hover:text-red-700" href="https://futechnepal.com/"
                        target="_blank">Futech Nepal</a> All rights reserved.
                </p>
                <div class="flex items-center mt-4 space-x-4 sm:mt-0">
                    <div class="">
                        @if (getSetting() && getSetting()->twitter)
                            <a href="{!! getSetting()->twitter !!}" target="_blank">
                                <i
                                    class="fab fa-twitter fa-lg transition-colors duration-300 text-futech hover:text-white h-5"></i>
                            </a>
                        @endif
                        @if (getSetting() && getSetting()->facebook)
                            <a href="{!! getSetting()->facebook !!}" target="_blank">
                                <i
                                    class="fab fa-facebook-square fa-lg transition-colors duration-300 text-futech hover:text-white h-5"></i>
                            </a>
                        @endif
                        @if (getSetting() && getSetting()->linkedin)
                            <a href="{!! getSetting()->linkedin !!}" target="_blank">
                                <i
                                    class="fab fa-linkedin-in fa-lg transition-colors duration-300 text-futech hover:text-white h-5"></i>
                            </a>
                        @endif
                        @if (getSetting() && getSetting()->youtube)
                            <a href="{!! getSetting()->youtube !!}" target="_blank">
                                <i
                                    class="fab fa-youtube fa-lg transition-colors duration-300 text-futech hover:text-white h-5"></i>
                            </a>
                        @endif
                        @if (getSetting() && getSetting()->instagram)
                            <a href="{!! getSetting()->instagram !!}" target="_blank">
                                <i
                                    class="fab fa-instagram fa-lg transition-colors duration-300 text-futech hover:text-white h-5"></i>
                            </a>
                        @endif
                        @if (getSetting() && getSetting()->tiktok)
                            <a href="{!! getSetting()->tiktok !!}" target="_blank">
                                <i
                                    class="fab fa-tiktok fa-lg transition-colors duration-300 text-futech hover:text-white h-5"></i>
                            </a>
                        @endif
                        @if (getSetting() && getSetting()->pininterest)
                            <a href="{!! getSetting()->pininterest !!}" target="_blank">
                                <i
                                    class="fab fa-pinterest fa-lg transition-colors duration-300 text-futech hover:text-white h-5"></i>
                            </a>
                        @endif
                        @if (getSetting() && getSetting()->viber)
                            <a href="{!! getSetting()->viber !!}" target="_blank">
                                <i
                                    class="fab fa-viber fa-lg transition-colors duration-300 text-futech hover:text-white h-5"></i>
                            </a>
                        @endif
                        @if (getSetting() && getSetting()->whatsapp)
                            <a href="{!! getSetting()->whatsapp !!}" target="_blank">
                                <i
                                    class="fab fa-whatsapp fa-lg transition-colors duration-300 text-futech hover:text-white h-5"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==Footer Section Ends == -->
    <button type="button" data-mdb-ripple="true" data-mdb-ripple-color="light"
        class="inline-block p-3 bg-black text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-red-600 hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out bottom-5 right-5"
        id="btn-back-to-top">
        <svg aria-hidden="true" focusable="false" data-prefix="fas" class="w-4 h-4" role="img"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path fill="currentColor"
                d="M34.9 289.5l-22.2-22.2c-9.4-9.4-9.4-24.6 0-33.9L207 39c9.4-9.4 24.6-9.4 33.9 0l194.3 194.3c9.4 9.4 9.4 24.6 0 33.9L413 289.4c-9.5 9.5-25 9.3-34.3-.4L264 168.6V456c0 13.3-10.7 24-24 24h-32c-13.3 0-24-10.7-24-24V168.6L69.2 289.1c-9.3 9.8-24.8 10-34.3.4z">
            </path>
        </svg>
    </button>

    <script src="{{ asset('futech/js/scroll.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.0.2/glide.js"></script>
    <script>
        var glide06 = new Glide('.glide-06', {
            type: 'slider',
            focusAt: 'center',
            perView: 1,
            autoplay: 3500,
            animationDuration: 700,
            gap: 0,
            classes: {
                activeNav: '[&>*]:bg-slate-700',
            },

        });

        glide06.mount();

        let defaultTransform = 0;

        function goNext() {
            defaultTransform = defaultTransform - 398;
            var slider = document.getElementById("slider");
            if (Math.abs(defaultTransform) >= slider.scrollWidth / 1.7) defaultTransform = 0;
            slider.style.transform = "translateX(" + defaultTransform + "px)";
        }
        next.addEventListener("click", goNext);

        function goPrev() {
            var slider = document.getElementById("slider");
            if (Math.abs(defaultTransform) === 0) defaultTransform = 0;
            else defaultTransform = defaultTransform + 398;
            slider.style.transform = "translateX(" + defaultTransform + "px)";
        }
        prev.addEventListener("click", goPrev);
    </script>
    <!-- End Card Slider -->

    <!-- AOS init -->
    {{-- <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <!-- Slider -->

    {{-- Team Modal --}}
    {{-- <script>
		const modal = document.querySelector('.main-modal');
		const closeButton = document.querySelectorAll('.modal-close');

		const modalClose = () => {
			modal.classList.remove('fadeIn');
			modal.classList.add('fadeOut');
			setTimeout(() => {
				modal.style.display = 'none';
			}, 500);
		}

		const openModal = (key) => {
			modal.classList.remove('fadeOut');
			modal.classList.add('fadeIn');
			modal.style.display = 'flex';

            var elementTitle = null;
            var elementDescription = null;
            var elementImage = null;
            var elementJobTitle = null;
            var elementfbUrl = null;
            var elementLinkedUrl = null;
            var elementSocialMedia = null;

            elementTitle = document.getElementById('btntitle-'+key);
            elementDescription = document.getElementById('teamdescription-'+key);
            elementImage = document.getElementById('teamimage-'+key);
            elementJobTitle = document.getElementById('teamjob-'+key);
            elementfbUrl = document.getElementById('teamfb-'+key);
            elementLinkedUrl = document.getElementById('teamlinked-'+key);
            elementSocialMedia = document.getElementById('socialmedia');



            var title = elementTitle.getAttribute('data-title');
            var description = elementDescription.getAttribute('data-description');
            var image = elementImage.getAttribute('data-image');
            var job_title = elementJobTitle.getAttribute('data-job-title');
            var fb_url = elementfbUrl ? elementfbUrl.getAttribute('data-fb-url') : null ;
            var linked_url = elementLinkedUrl ? elementLinkedUrl.getAttribute('data-linked-url') : null;

            document.getElementById('modalTitle').innerHTML=title;
            document.getElementById('modalDescription').innerHTML=description;
            document.getElementById('modalJobTitle').innerHTML=job_title;
            document.getElementById('modalImage').src=image;
            if(fb_url){
                elementSocialMedia.classList.remove('hidden');
                document.getElementById('modalFbUrl').href=fb_url
            }
            else{
                elementSocialMedia.classList.add('hidden');
            }
            if(linked_url){
                elementSocialMedia.classList.remove('hidden');
                document.getElementById('modalLinkedurl').href=linked_url
            }
            else{
                elementSocialMedia.classList.add('hidden');
            }
		}

		for (let i = 0; i < closeButton.length; i++) {

			const elements = closeButton[i];

			elements.onclick = (e) => modalClose();

			modal.style.display = 'none';

			window.onclick = function (event) {
				if (event.target == modal) modalClose();
			}
		}



	</script> --}}
    </body>

    </html>
