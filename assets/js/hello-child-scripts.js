jQuery(document).ready(function ($) {
    $('.salon-type span').on('click', function () {
        $('.salon-type span').removeClass('active');
        $(this).addClass('active');

        $('#searchblogpost').val('');

        const filterType = $(this).parent().hasClass('salon-tags')
            ? 'artist_tag'
            : 'salon_type';
        const salonSlug = $(this).data('slug');
        const data = {
            filterType,
            salonSlug,
        };
        console.log(salonSlug)
        loadPosts(data);
    });

    $('#searchblogpost').on('keyup', function () {
        let searchpost = $(this).val();
        loadPosts(null, searchpost);
    });

    function loadPosts(data = {}, searchpost = '') {
        let nonce = document.querySelector('.filter-nonce')?.dataset.nonce;

        $('#load-salon-posts').html(
            `<div class='preloader'><img src="${ajax.preloader}"/></div>`
        );

        wp.ajax
            .post('loadmore_posts', { data, nonce, searchpost })
            .done((res) => {
                if (res) {
                    $('#load-salon-posts').html(res.page);
                }
            })
            .fail((err) => {
                $('#load-salon-posts').html(err.message);
                console.log(err.responseText);
                // $('#load-salon-posts').html(err.responseText);
            });
    }

    loadPosts();

    $('.quality-image-nav-slider-init .quality-image-nav-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        asNavFor: '.quality-image-nav-slider-init .quality-image-nav-slidernav',
    });
    $('.quality-image-nav-slider-init .quality-image-nav-slidernav').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        asNavFor: '.quality-image-nav-slider-init .quality-image-nav-slider',
        dots: true,
        focusOnSelect: true,
    });
});
