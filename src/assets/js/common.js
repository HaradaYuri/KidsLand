export function initializeCommon($) {
  // fv過ぎたら.btn-topback表示
  var $fv = $('.fv, .page-fv');
  var fvHeight = $fv.outerHeight() - 300;
  var $btnTopBack = $('.btn-topback');
  var isBtnVisible = false;

  $(window).on('scroll', function () {
    var scrollTop = $(this).scrollTop();

    if (scrollTop > fvHeight) {
      if (!isBtnVisible) {
        $btnTopBack.removeClass('fadeOut').addClass('fadeUp').show();
        isBtnVisible = true;
      }
    } else {
      if (isBtnVisible) {
        $btnTopBack.removeClass('fadeUp').addClass('fadeOut').hide();
        isBtnVisible = false;
      }
    }
  });

  $btnTopBack.on('click', function () {
    $(this).removeClass('fadeUp').addClass('fadeOut');
    setTimeout(function () {
      $btnTopBack.hide();
      $isBtnVisible = false;
    }, 300);
  });
}
