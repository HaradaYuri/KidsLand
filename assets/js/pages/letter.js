export function initializeLetterPage() {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupEventListeners);
  } else {
    setupEventListeners();
  }

  function setupEventListeners() {
    document.querySelectorAll('.archive__month').forEach(function (link) {
      link.addEventListener('click', function (event) {
        if (this.classList.contains('active')) {
          event.preventDefault();

          let url = new URL(window.location.href);
          let params = new URLSearchParams(url.search);

          let prefecture = params.get('prefecture');
          let nursery = params.get('nursery');

          let baseURL = window.location.origin + '/letter/';

          let newParams = new URLSearchParams();
          if (prefecture) newParams.set('prefecture', prefecture);
          if (nursery) newParams.set('nursery', nursery);

          let newURL =
            baseURL + (newParams.toString() ? '?' + newParams.toString() : '');

          window.location.href = newURL;
        }
      });
    });
  }
}
