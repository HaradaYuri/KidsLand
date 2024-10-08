export function initializeAnimation($) {
  function fadeAnime() {
    $('.fadeUpTrigger').each(function () {
      var elemPos = $(this).offset().top - 50;
      var scroll = $(window).scrollTop();
      var windowHeight = $(window).height();
      if (scroll >= elemPos - windowHeight) {
        $(this).addClass('fadeUp');
      } else {
        $(this).removeClass('fadeUp');
      }
    });
  }

  $('.fadeUpTriggerFV').each(function () {
    $(this).removeClass('fadeUp');
    $(this).addClass('fadeUp');
  });

  $(window).scroll(function () {
    fadeAnime();
  });

  $(window).on('load', function () {
    fadeAnime();
  });
}
