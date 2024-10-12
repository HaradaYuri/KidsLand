<?php get_header(); ?>

<main>
  <div class="page-fv"></div>
  <!-- page-heading starts here -->
  <section class="page-heading">
    <div class="page-heading__container fadeUpTrigger fadeUpTriggerFV">
      <div class="page-heading__text">
        <h2 class="page-heading__text-jp">採用情報</h2>
        <p class="page-heading__text-en txts-en">recruit</p>
      </div>

      <!-- breadcrumbs -->
      <div class="breadcrumbs fadeUpTrigger fadeUpTriggerFV">
        <?php if (function_exists('yoast_breadcrumb')) : ?>
          <?php yoast_breadcrumb('<p id="breadcrumbs">', '</p>'); ?>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <!-- page-heading /ends here -->

  <!-- recruit form starts here -->
  <section class="form__container recruit__form-container">
    <div class="form recruit-confirm__form bg-bgL">
      <?php echo do_shortcode('[contact-form-7 id="c6bb9dc" title="KidsLand - 採用情報フォーム(確認画面)"]') ?>
    </div>
  </section>
  <!-- recruit form /ends here -->
</main>
<!-- main /ends here -->

<?php get_footer(); ?>