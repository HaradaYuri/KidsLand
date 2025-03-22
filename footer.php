<!-- footer starts here -->
<footer class="footer">
  <a href="<?php echo esc_url(home_url('/')); ?>" class="footer__logo-link">
    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.webp" alt="桜のこもれびキッズランド" class="footer__logo fadeUpTrigger" width="240" height="76.28">
  </a>

  <nav class="footer__nav">
    <ul class="footer__list">
      <li class="footer__item fadeUpTrigger">
        <a href="<?php echo esc_url(home_url('/about')); ?>" class="footer__link">
          <span class="footer__text">私たちのこと</span>
        </a>
      </li>
      <li class="footer__item fadeUpTrigger">
        <a href="<?php echo esc_url(home_url('/introduction')); ?>" class="footer__link">
          <span class="footer__text">各園のご紹介</span>
        </a>
      </li>
      <li class="footer__item fadeUpTrigger">
        <a href="<?php echo esc_url(home_url('/letter')); ?>" class="footer__link">
          <span class="footer__text">こもれびだより</span>
        </a>
      </li>
      <li class="footer__item fadeUpTrigger">
        <a href="<?php echo esc_url(home_url('/recruit')); ?>" class="footer__link">
          <span class="footer__text">採用情報</span>
        </a>
      </li>
      <li class="footer__item fadeUpTrigger">
        <a href="<?php echo esc_url(home_url('/info')); ?>" class="footer__link">
          <span class="footer__text">お知らせ</span>
        </a>
      </li>
      <li class="footer__item fadeUpTrigger">
        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="footer__link">
          <span class="footer__text">お問い合わせ</span>
        </a>
      </li>
      <li class="footer__item fadeUpTrigger">
        <a href="<?php echo esc_url(home_url('/sitemap')); ?>" class="footer__link">
          <span class="footer__text footer__text--small">サイトマップ</span>
        </a>
      </li>
      <li class="footer__item fadeUpTrigger">
        <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" class="footer__link">
          <span class="footer__text footer__text--small">プライバシーポリシー</span>
        </a>
      </li>
    </ul>
  </nav>

  <p class="footer__copyright fadeUpTrigger">
    <span>©</span>桜のこもれびキッズランド All Rights Reserved.
  </p>
</footer>
<!-- footer /ends here -->

<?php wp_footer(); ?>
</body>

</html>