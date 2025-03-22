export function initializeIntroductionPage($) {
  $('.search__tab').on('click', function () {
    const $this = $(this);
    const isActive = $this.hasClass('active');

    $('.search__tab').removeClass('active');

    if (!isActive) {
      $this.addClass('active');

      const baseUrl = 'https://web.harapaca-craft.com/introduction/';
      const taxonomy = $this.data('taxonomy');
      const term = $this.data('term');
      const newUrl = `${baseUrl}${taxonomy}/${term}/`;
      history.pushState(null, '', newUrl);

      location.reload();
    } else {
      history.pushState(
        null,
        '',
        'https://web.harapaca-craft.com/introduction/'
      );
      location.reload();
    }
  });
}
