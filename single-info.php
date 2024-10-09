<?php get_header(); ?>

    <main>
      <div class="page-fv"></div>
      <!-- page-heading starts here -->
      <section class="page-heading">
        <div class="page-heading__container fadeUpTrigger">
          <div class="page-heading__text">
            <h2 class="page-heading__text-jp">お知らせ</h2>
            <p class="page-heading__text-en txts-en">info</p>
          </div>

          <!-- breadcrumbs -->
          <div class="breadcrumbs fadeUpTrigger">
            <p>
              TOP
              <i class="fa-solid fa-chevron-right"></i>
              お知らせ
              <i class="fa-solid fa-chevron-right"></i>
              <span class="single-letter__brcr">
                タイトルが入ります。タイトルが入ります。
              </span>
            </p>
          </div>
        </div>
      </section>
      <!-- page-heading /ends here -->

      <!-- single-info (p-letter) starts here -->
      <section class="single-info">
        <div class="single-letter single-info__container">
          <div class="single-letter__top">
            <p class="single-letter__top-day">2023.08.07</p>
          </div>
          <h2 class="single-letter__title">
            タイトルが入ります。タイトルが入ります。
          </h2>

          <img src="<?php echo get_template_directory_uri(); ?>/./assets/images/no-image.webp" alt="タイトルが入ります。" class="single-letter__img">

          <h3 class="single-letter__subtitle pink-vertical-line">
            小見出しが入ります。
          </h3>
          <p class="single-letter__text">
            テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト
          </p>
          <p class="single-letter__text">
            テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト
          </p>

          <h3 class="single-letter__subtitle pink-vertical-line">
            小見出しが入ります。
          </h3>
          <p class="single-letter__text">
            テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト
          </p>
          <p class="single-letter__text">
            テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト
          </p>

          <a href="archive-info.html" class="single-letter__btn btn-primary">
            お知らせ一覧へ
            <i class="fa-solid fa-chevron-right"></i>
          </a>
        </div>
      </section>
      <!-- p-lettter /ends here -->
    </main>
    <!-- main /ends here -->

<?php get_footer(); ?>