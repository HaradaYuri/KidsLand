export function initializeAccordion($) {
  $('.title').on('click', function () {
    $('.box').not($(this).next('.box')).slideUp();
    // $('.title').not(this).removeClass('active');
    $(this).next('.box').slideToggle();
    // $(this).toggleClass('active');
  });
  $('.accordion__item:first-of-type .box').slideDown(); 
}
