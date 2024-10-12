<?php get_header(); ?>

<main>
  <div class="page-fv"></div>
  <!-- page-heading starts here -->
  <section class="page-heading">
    <div class="page-heading__container fadeUpTrigger fadeUpTriggerFV">
      <div class="page-heading__text">
        <h2 class="page-heading__text-jp">お問い合わせ</h2>
        <p class="page-heading__text-en txts-en">contact</p>
      </div>

    </div>
  </section>
  <!-- page-heading /ends here -->

  <!-- contact form starts here -->
  <section class="form__container contact__form-container">
    <div class="form contact-confirm__form bg-bgL">
      <?php echo do_shortcode('[contact-form-7 id="f61ef15" title="KidsLand - お問い合わせフォーム(確認画面)"]') ?>
    </div>
  </section>
  <!-- contact form /ends here -->
</main>
<!-- main /ends here -->

<?php get_footer(); ?>