export function initializeAccordion($) {
  // Initially close all items
  $('.faq__item-answer').hide();
  $('.faq__item-question').removeClass('active');

  // Open only the first item
  $('.faq__item--first .faq__item-answer').show();
  $('.faq__item--first .faq__item-question').addClass('active');

  $('.faq__item-question').on('click', function () {
    const $currentItem = $(this);
    const $currentAnswer = $currentItem.next('.faq__item-answer');

    // Close all other items
    $('.faq__item-answer').not($currentAnswer).slideUp();
    $('.faq__item-question').not($currentItem).removeClass('active');

    // Toggle the clicked item
    $currentAnswer.slideToggle();
    $currentItem.toggleClass('active');
  });
}
