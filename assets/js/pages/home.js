export function initializeHomePage($) {
  // .fv__news FVが過ぎたら非表示
  var fvHeight = $('.fv').outerHeight() - 50;
  var $fvNews = $('.fv .fv__news');
  var isFvNewsVisible = true;

  $(window).on('scroll', function () {
    if ($(window).scrollTop() > fvHeight && isFvNewsVisible) {
      $fvNews.removeClass('slide-in').addClass('slide-out');
      isFvNewsVisible = false;
    } else if ($(window).scrollTop() <= fvHeight && !isFvNewsVisible) {
      $fvNews.removeClass('slide-out').addClass('slide-in');
      isFvNewsVisible = true;
    }
  });

  $fvNews.on('click', function () {
    $(this).addClass('fadeOut');

    setTimeout(function () {
      $fvNews.hide();
      isFvNewsVisible = false;
    }, 300);
  });
}
