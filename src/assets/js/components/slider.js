export function initializeSlider($) {
  $('.slider').slick({
    autoplay: true,
    // 一回一回止まらない永続ループ時はautoplaySpeed==0
    autoplaySpeed: 0,
    speed: 5000,
    infinite: true,
    cssEase: 'linear',
    slidesToShow: 5,
    // slidesToScroll: 1,
    swipe: false,
    arrows: false,
    dots: false,

    pauseOnFocus: false,
    pauseOnHover: false,
    pauseOnDotsHover: false,
    // responsive: [
    //   {
    //     breakpoint: 1200,
    //     settings: {
    //       slidesToShow: 4,
    //     },
    //   },
    //   {
    //     breakpoint: 992,
    //     settings: {
    //       slidesToShow: 3,
    //     },
    //   },
    //   {
    //     breakpoint: 768,
    //     settings: {
    //       slidesToShow: 2,
    //     },
    //   },
    //   {
    //     breakpoint: 576,
    //     settings: {
    //       slidesToShow: 1,
    //     },
    //   },
    // ],
  });
}
