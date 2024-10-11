export function initializeCardLinks() {
  const cards = document.querySelectorAll('.cards-introduction');

  cards.forEach((card) => {
    const cardLink = card.querySelector('.card-link');

    card.addEventListener('click', function (e) {
      // カード内のリンク（.card-linkと.card__info）以外の場所がクリックされた場合
      if (!e.target.closest('.card-link') && !e.target.closest('.card__info')) {
        e.preventDefault(); // デフォルトの動作を防ぐ
        cardLink.click(); // カードのメインリンクをクリックしたことにする
      }
    });

    // カードのメインリンク（画像を含む）のクリックイベントの伝播を停止
    cardLink.addEventListener('click', function (e) {
      e.stopPropagation();
    });

    // カテゴリーリンクのクリックイベントの伝播を停止
    const categoryLinks = card.querySelectorAll('.card__info');
    categoryLinks.forEach((link) => {
      link.addEventListener('click', function (e) {
        e.stopPropagation();
      });
    });
  });
}
