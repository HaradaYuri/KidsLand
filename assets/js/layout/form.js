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

  // confirm date format
  function formatDate(dateString) {
    // YYYYを抜いた部分を-から/に置換
    return dateString.replace(
      /(\d{4})-(\d{1,2})-(\d{1,2})/,
      function (match, year, month, day) {
        return year + '年' + parseInt(month) + '月' + parseInt(day) + '日';
      }
    );
  }

  function updateDateFormat() {
    $('input.wpcf7-date').each(function () {
      var $input = $(this);
      var originalValue = $input.val();
      console.log('Original value:', originalValue);
      var formattedValue = formatDate(originalValue);
      console.log('Formatted value:', formattedValue);
    });

    $('.form__fields.birthdate').each(function () {
      var $field = $(this);
      var originalText = $field.text().trim();
      console.log('Original text:', originalText);
      var formattedText = formatDate(originalText);
      console.log('Formatted text:', formattedText);
      $field.text(formattedText);
    });
  }

  updateDateFormat();
}
