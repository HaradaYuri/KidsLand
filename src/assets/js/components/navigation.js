export function initializeNavigation($) {
  // nav for SP
  $('.btn-menu').click(function () {
    $(this).toggleClass('active');

    var overlay = $('.header__nav');
    var list = $('.header__list');

    if (overlay.hasClass('active')) {
      overlay.removeClass('fadeIn').addClass('fadeOut');
      setTimeout(function () {
        overlay.removeClass('active fadeOut');
        list.removeClass('active');
      }, 300);
    } else {
      overlay.addClass('active fadeIn');
      list.addClass('active');
      setTimeout(function () {
        overlay.removeClass('fadeIn');
      }, 300);
    }
  });
}
