(function ($) {

    "use strict";

    // sticky header
    $(window).on("scroll", function () {
        var scroll = $(window).scrollTop();
        if (scroll < 200) {
            $(".main-menu.sticky-header").removeClass("affix");

        } else {
            $(".main-menu.sticky-header").addClass("affix");

        }
    });


    //Counter up
    $(".counter").counterUp({
        delay: 10,
        time: 1000,
    });

    // Menu
    // Show Menu
    const showMenu = (toggleId, navId) => {
        const toggle = document.getElementById(toggleId),
            nav = document.getElementById(navId)

        toggle.addEventListener('click', () => {
            // add show menu to nav menu  
            nav.classList.toggle('show-menu')
            //add show icon to hide
            toggle.classList.toggle('show-icon')
        })
    }
    showMenu('nav-toggle', 'nav-menu');

    // Dropdown
    const dropdownItems = document.querySelectorAll('.dropdown__item');
    // select each dropdown item
    dropdownItems.forEach((item) => {
        const dropdownButton = item.querySelector('.dropdown__button');
        // Select each button click
        dropdownButton.addEventListener('click', () => {

            // select the current dropdown class
            const showDropdown = document.querySelector('.show-dropdown')

            // Call the toggle item function
            toggleItem(item);

            //Remove the show-dropdown class from other item
            if (showDropdown && showDropdown != item) {
                toggleItem(showDropdown)
            }

        })
    })
    // Create function to display dropdown
    const toggleItem = (item) => {
        // select each dropdown
        const dropdownContainer = item.querySelector('.dropdown__container');

        // if same item contain the show-dropdown class, remove
        if (item.classList.contains('show-dropdown')) {
            dropdownContainer.removeAttribute('style')
            item.classList.remove('show-dropdown')
        } else {
            //add height
            dropdownContainer.style.height = dropdownContainer.scrollHeight + 'px';
            item.classList.add('show-dropdown')
        }

    }

    // Lightbox
    var lightbox = GLightbox({
        selector: ".video-popup",
        touchNavigation: true,
        loop: false,
    });

    // Lightbox Gallery
    var lightboxGallery = GLightbox({
        selector: ".gallery",
        touchNavigation: true,
        loop: true,
    });


    // Accordion
    // Get all the accordion headers and bodies
    const headers = document.querySelectorAll(".accordion-header");
    const bodies = document.querySelectorAll(".accordion-body");

    // Add click event listeners to the headers
    headers.forEach((header) => {
        header.addEventListener("click", () => {
            // Toggle the visibility of the accordion body
            header.nextElementSibling.classList.toggle("hidden");

            // Toggle the transform of the accordion icon
            const icon = header.querySelector(".accordion-icon svg");
            icon.classList.toggle("rotate-0");
            icon.classList.toggle("rotate-180");
        });
    });


    // Isotope
    var $portfolioGrid = $(".ph-grid-container").imagesLoaded(function () {
        // init Isotope after all images have loaded
        $portfolioGrid.isotope({
            // options...
            itemSelector: '.pg-item',
            layoutMode: 'masonry',
            masonry: {
                gutter: 30,
                columnWidth: '.pg-item',
            },
            percentPosition: true,
            fitColumns: {
                gutter: '.gutter-sizer'
            }

        });
    });

    var $portfolioGridTwo = $(".portfolio-container").imagesLoaded(function () {
        // init Isotope after all images have loaded
        $portfolioGridTwo.isotope({
            // options...
            itemSelector: '.portfolio-item',
            layoutMode: 'masonry',
            masonry: {
                gutter: 30,
                columnWidth: '.portfolio-item',
            },
            percentPosition: true,
            fitColumns: {
                gutter: '.gutter-sizer'
            }

        });
    });

    var clientLogo = new Swiper(".clientLogoSlider", {
        loop: true,
        autoplay: {
            delay: 2000,
        },
        breakpoints: {
            576: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 40,
            },
            992: {
                slidesPerView: 5,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 6,
                spaceBetween: 40,
            },
        },
    });

    var clientLogo = new Swiper(".clientLogoSliderLight", {
        spaceBetween: 40,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        breakpoints: {

            575: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 40,
            },
            992: {
                slidesPerView: 5,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 6,
                spaceBetween: 40,
            },
        },
    });

    // Services Slider
    var servicesSlider = new Swiper(".servicesSlider", {
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".service-pagination.swiper-pagination",
        },
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        breakpoints: {
            576: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1500: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });

    // Blog Slider
    var blogSlider = new Swiper(".blogSliderLight", {
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".service-pagination.swiper-pagination",
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        breakpoints: {
            576: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            992: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1400: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });

    var blogSliderDark = new Swiper(".blogSliderDark", {
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".service-pagination.swiper-pagination",
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        breakpoints: {
            576: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            992: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1400: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });

    var relatedWork = new Swiper(".relatedWork", {
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".service-pagination.swiper-pagination",
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        breakpoints: {
            576: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1500: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });

    var devServiceSlider = new Swiper(".devServiceSlider", {
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".service-pagination.dev-style.swiper-pagination",
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        breakpoints: {
            576: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1500: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });

    var photographySlider = new Swiper(".photographySlider", {
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".service-pagination.ph-style.swiper-pagination",
        },
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        breakpoints: {
            576: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1500: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });

    var teacherSlider = new Swiper(".teacherSlider", {
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".service-pagination.ph-style.swiper-pagination",
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        breakpoints: {
            576: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1500: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });

    var designerServices = new Swiper(".designerServices", {
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".service-pagination.swiper-pagination",
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        breakpoints: {
            576: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1500: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });

    var lawServiceSlider = new Swiper(".lawServiceSlider", {
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".service-pagination.swiper-pagination",
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        breakpoints: {
            576: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1500: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });


    var clientLogo = new Swiper(".clientLogoSliderLight", {
        spaceBetween: 40,
        loop: true,
        autoplay: {
            delay: 2000,
        },
        breakpoints: {
            576: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 40,
            },
            992: {
                slidesPerView: 5,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 6,
                spaceBetween: 40,
            },
        },
    });

    var feedbackTwo = new Swiper(".twoColumnFeedback", {
        spaceBetween: 40,
        loop: true,
        pagination: {
            el: ".service-pagination.swiper-pagination",
        },
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        breakpoints: {
            576: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
            992: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
            1500: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
        },
    });

    var feedbackTwoDark = new Swiper(".twoColumnFeedbackDark", {
        spaceBetween: 40,
        loop: true,
        pagination: {
            el: ".service-pagination.dev-style.swiper-pagination",
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        breakpoints: {
            576: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
            992: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
            1500: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
        },
    });

    var relatedProduct = new Swiper(".relatedProduct", {
        spaceBetween: 40,
        loop: true,
        pagination: {
            el: ".service-pagination.swiper-pagination",
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        breakpoints: {
            576: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            992: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
            1500: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
        },
    });


    var photoGallery = new Swiper(".photoGallery", {
        loop: true,
        centeredSlides: true,
        navigation: {
            nextEl: ".gallery-swiper .swiper-button-next",
            prevEl: ".gallery-swiper .swiper-button-prev",
        },
        pagination: {
            el: ".gallery-pagination.swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
            },
            640: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });

    var photoTeam = new Swiper(".photoTeam", {
        loop: true,
        navigation: {
            nextEl: ".gallery-swiper .swiper-button-next",
            prevEl: ".gallery-swiper .swiper-button-prev",
        },
        pagination: {
            el: ".gallery-pagination.swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
            },
            640: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
        },
    });

    var brandLogo = new Swiper(".brandlogo", {
        spaceBetween: 40,
        loop: true,
        autoplay: {
            delay: 2500,
        },
        breakpoints: {
            320: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            576: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 40,
            },
            992: {
                slidesPerView: 5,
                spaceBetween: 30,
            },
            1200: {
                slidesPerView: 6,
                spaceBetween: 40,
            },
        },
    });

    var singleTestimonial = new Swiper(".singleTestimonial", {
        slidesPerView: 1,
        loop: true,
        autoplay: {
            delay: 3000,
        },
    });

    //Product Details
    var swiper = new Swiper(".mySwiper", {
        spaceBetween: 10,
        slidesPerView: 1,
        breakpoints: {
            375: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            640: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 40,
            },
            1024: {
                slidesPerView: 1,
            },
        },
    });
    var swiper2 = new Swiper(".mySwiper2", {
        spaceBetween: 10,
        slidesPerView: 1,
        thumbs: {
            swiper: swiper,
        },
    });


})(jQuery);
