export function initializeForm($) {
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
}
