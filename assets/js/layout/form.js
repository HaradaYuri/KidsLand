export function initializeForm($) {
  // date 初期表示 空白
  const $dateInputs = $('.form__input[type="date"]');

  function setDateInputColor($input) {
    $input.css(
      'color',
      $input.val() || $input.is(':focus') ? 'black' : 'white'
    );
  }

  $dateInputs.each(function () {
    setDateInputColor($(this));
  });

  $dateInputs.on('focus blur change', function () {
    setDateInputColor($(this));
  });

  // 承諾ボタンの機能追加
  function toggleAgreement($element) {
    var $checkbox = $element.find('input[type="checkbox"]');
    $checkbox.prop('checked', !$checkbox.prop('checked')).trigger('change');

    if (typeof wpcf7 !== 'undefined') {
      var $form = $element.closest('.wpcf7-form');
      if ($form.length) {
        $form.trigger('change');
      }
    }
  }

  $(document).on('click', '.form__field-agreement', function (e) {
    if (!$(e.target).is('input[type="checkbox"]')) {
      toggleAgreement($(this));
    }
  });
}
