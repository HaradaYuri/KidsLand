export function initializeCommon($) {
  // fvを過ぎたら topback btn 表示
  const $fv = $('.fv, .page-fv');
  const fvHeight = $fv.outerHeight() - 300;
  const $btnTopBack = $('.btn-topback');
  let isBtnVisible = false;

  $(window).on('scroll', () => {
    const scrollTop = $(window).scrollTop();

    if (scrollTop > fvHeight && !isBtnVisible) {
      $btnTopBack.removeClass('fadeOut').addClass('fadeUp').show();
      isBtnVisible = true;
    } else if (scrollTop <= fvHeight && isBtnVisible) {
      $btnTopBack.removeClass('fadeUp').addClass('fadeOut').hide();
      isBtnVisible = false;
    }
  });

  $btnTopBack.on('click', function () {
    $(this).removeClass('fadeUp').addClass('fadeOut');
    setTimeout(() => {
      $btnTopBack.hide();
      isBtnVisible = false;
    }, 300);
  });
}
