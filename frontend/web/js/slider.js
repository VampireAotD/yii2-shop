$('.promo-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    infinite: true,
    dots: true,
    fade: true,
    cssEase: 'linear',
    speed: 500,
    responsive: [
        {
            breakpoint: 546,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                dots: false,
                arrows : false,
            }
        },
    ]
});