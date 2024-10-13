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
        enableScroll();
      }, 300);
    } else {
      overlay.addClass('active fadeIn');
      list.addClass('active');
      disableScroll();
      setTimeout(function () {
        overlay.removeClass('fadeIn');
      }, 300);
    }
  });

  // スクロールを無効にする関数
  function disableScroll() {
    $('body').css('overflow', 'hidden');
  }

  // スクロールを有効にする関数
  function enableScroll() {
    $('body').css('overflow', '');
  }
}
