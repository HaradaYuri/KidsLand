<?php get_header(); ?>

    <main>
      <div class="page-fv"></div>
      <!-- page-heading starts here -->
      <section class="page-heading">
        <div class="page-heading__container fadeUpTrigger">
          <div class="page-heading__text">
            <h2 class="page-heading__text-jp">サイトマップ</h2>
            <p class="page-heading__text-en txts-en">sitemap</p>
          </div>

          <!-- breadcrumbs -->
          <div class="breadcrumbs fadeUpTrigger">
            <p>
              TOP
              <i class="fa-solid fa-chevron-right"></i>
              サイトマップ
            </p>
          </div>
        </div>
      </section>
      <!-- page-heading /ends here -->

      <!-- sitemap starts here -->
      <section class="sitemap bg-pink-dash">
        <div class="sitemap__title title-primary">
          <div class="title-primary__icon fadeUpTrigger">
            <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/./assets/images/icon-chart.svg" alt="サイトマップ">
          </div>
        </div>
        
        <!-- container -->
        <div class="sitemap__container bg-bgL">
          <ul class="sitemap__list flex-col">
            <li class="sitemap__item fadeUpTrigger">
              <a href="index.html" class="sitemap__link">
                <div class="sitemap__circle"></div>
                <span class="sitemap__text">TOP</span>
                <i class="fa-solid fa-chevron-right"></i>
              </a>
            </li>
            <li class="sitemap__item fadeUpTrigger">
              <a href="page-about.html" class="sitemap__link">
                <div class="sitemap__circle"></div>
                <span class="sitemap__text">わたしたちのこと</span>
                <i class="fa-solid fa-chevron-right"></i>
              </a>
            </li>
            <li class="sitemap__item fadeUpTrigger">
              <a href="taxonomy-introduction_type.html" class="sitemap__link">
                <div class="sitemap__circle"></div>
                <span class="sitemap__text">各園のご紹介</span>
                <i class="fa-solid fa-chevron-right"></i>
              </a>
            </li>
            <li class="sitemap__item fadeUpTrigger">
              <a href="archive-letter.html" class="sitemap__link">
                <div class="sitemap__circle"></div>
                <span class="sitemap__text">こもれびだより</span>
                <i class="fa-solid fa-chevron-right"></i>
              </a>
            </li>
            <li class="sitemap__item fadeUpTrigger">
              <a href="archive-info.html" class="sitemap__link">
                <div class="sitemap__circle"></div>
                <span class="sitemap__text">お知らせ</span>
                <i class="fa-solid fa-chevron-right"></i>
              </a>
            </li>
            <li class="sitemap__item fadeUpTrigger">
              <a href="page-recruit.html" class="sitemap__link">
                <div class="sitemap__circle"></div>
                <span class="sitemap__text">採用情報</span>
                <i class="fa-solid fa-chevron-right"></i>
              </a>
            </li>
            <li class="sitemap__item fadeUpTrigger">
              <a href="page-contact.html" class="sitemap__link">
                <div class="sitemap__circle"></div>
                <span class="sitemap__text">お問い合わせ</span>
                <i class="fa-solid fa-chevron-right"></i>
              </a>
            </li>
            <li class="sitemap__item fadeUpTrigger">
              <a href="page-sitemap.html" class="sitemap__link">
                <div class="sitemap__circle"></div>
                <span class="sitemap__text">サイトマップ</span>
                <i class="fa-solid fa-chevron-right"></i>
              </a>
            </li>
            <li class="sitemap__item fadeUpTrigger">
              <a href="page-privacy-policy.html" class="sitemap__link">
                <div class="sitemap__circle"></div>
                <span class="sitemap__text">プライバシーポリシー</span>
                <i class="fa-solid fa-chevron-right"></i>
              </a>
            </li>
          </ul>
        </div>
      </section>
      <!-- sitemap /ends here -->
    </main>
    <!-- main /ends here -->

<?php get_footer(); ?>