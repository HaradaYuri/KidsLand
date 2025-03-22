export function initializeAccordion($) {
  // // Initially close all items
  $('.faq__item-answer').hide();
  $('.faq__item-question').removeClass('active');
  // Initially open the first item's answer
  $('.faq__item--first .faq__item-answer').slideDown();
  $('.faq__item--first .faq__item-question').addClass('active');

  // Add click event for FAQ items
  $('.faq__item-question').on('click', function () {
    // Close all other answers and remove active class
    $('.faq__item-answer').not($(this).next('.faq__item-answer')).slideUp();
    $('.faq__item-question').not(this).removeClass('active');

    // Toggle the clicked item's answer and active class
    $(this).next('.faq__item-answer').slideToggle();
    $(this).toggleClass('active');
  });
}
