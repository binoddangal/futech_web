
/**
 * Main Navigation Toggle Button Animation
 */
$(window).on('load', function() {
    popup_modalTogglerFunction('#homepage');
});

function popup_modalTogglerFunction(modal) {

    let modelId = modal+'_popup_modal section';
    let elements = document.querySelectorAll(modelId);
    for (let i = 0; i < elements.length; i++) {
        let id = '#'+elements[i].getAttribute('id');
        let modalWrapper = document.querySelector(id);
        // console.log('it is working popup')
        showModal(modalWrapper)
    }
    let closeBtn = document.querySelectorAll('button#closebtn')
    for (let i = 0; i < elements.length; i++) {
        closeBtn[i].addEventListener('click', function (e) {
            e.preventDefault();
            let modalWrapper = document.querySelector(this.getAttribute('data-target'));
            modalWrapper.classList.remove('futech__modal--show')
            modalWrapper.addEventListener('click', function (event) {
                if (
                    event.target.matches('futech__modal__closebtn') ||
                    !event.target.closest(".futech__modal__content")
                ) {
                    closeModal(modalWrapper)
                }
            })
        });
    }
}

function closeModal(modalWrapper) {
    // console.log('check it working')
    document.querySelector('body').classList.remove('futech__show-modal');
    modalWrapper.classList.remove('futech__modal--show')
}

function showModal(modalWrapper) {
    // console.log('check it working')
    document.querySelector('body').classList.add('futech__show-modal');
    modalWrapper.classList.add('futech__modal--show')
}

function futech__modalTogglerFunction(btnId) {
    // let modalToggleBtn = document.querySelectorAll('.futech__modal-toggle-btn');
    // console.log(btnId)
    let modalToggleBtn = btnId
    let id = modalToggleBtn.getAttribute('data-target');
    let modalWrapper = document.querySelector(id);
    console.log('it is working')
    showModal(modalWrapper)
    // console.log(id);


    // modalToggleBtn.forEach(btn => {
    //     id = btn.dataset.target;
    //     modalWrapper = document.querySelector(id);
    //     btn.addEventListener('click', function () {
    //         document.querySelector('body').classList.add('futech__show-modal');
    //         modalWrapper.classList.add('futech__modal--show');
    //     })
    // })

    // modalWrapper = document.querySelector(id);
    let closeBtn = modalWrapper.querySelector('.futech__modal__closebtn')

    closeBtn.addEventListener('click', function () {
        closeModal(modalWrapper)
    });



    modalWrapper.addEventListener('click', function (event) {
        if (
            event.target.matches('futech__modal__closebtn') ||
            !event.target.closest(".futech__modal__content")
        ) {
            closeModal(modalWrapper)
        }
    })
}

var description = $('.team-description');

for (let i = 0; i < description.length; i++) {
    $(`.read-more-show-`+i).on('click', function(e) {
        $('.read-more-content-'+i).removeClass('d-none');
        $(this).addClass('d-none');
        e.preventDefault();
        $('.read-more-hide-'+i).removeClass('d-none');
    });

    $(`.read-more-hide-`+i).on('click', function(e) {
        $('.read-more-content-'+i).addClass('d-none');
        $(this).addClass('d-none');
        e.preventDefault();
        $('.read-more-show-'+i).removeClass('d-none');
    });
}

