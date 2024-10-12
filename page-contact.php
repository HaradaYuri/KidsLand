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

      <!-- breadcrumbs -->
      <div class="breadcrumbs fadeUpTrigger fadeUpTriggerFV">
        <?php if (function_exists('yoast_breadcrumb')) : ?>
          <?php yoast_breadcrumb('<p id="breadcrumbs">', '</p>'); ?>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <!-- page-heading /ends here -->

  <!-- contact-desc starts here -->
  <section class="contact-desc">
    <p class="contact-desc__text">
      下記フォームにご記入の上、送信してください。折り返し、
      弊社担当よりご連絡させて頂きます。<br>
      また、ご入力頂きました個人に関する情報につきましては、弊社で責任をもって管理し、お問い合わせへのご回答及び弊社のサービス向上のために利用させて頂き、第三者への開示や他の目的で利用は致しません。詳しくは個人情報保護方針をご覧ください。
    </p>
    <a href="<?php echo esc_url('/privacy-policy'); ?>" class="contact-desc__text contact-desc__text--underline">弊社への登録に際して、お預かりする個人情報の扱いについて</a>
  </section>
  <!-- contact-desc /ends here -->

  <!-- contact form starts here -->
  <section class="form__container contact__form-container">
    <div class="form contact__form bg-bgL">
      <?php echo do_shortcode('[contact-form-7 id="ad122da" title="KidsLand - お問い合わせフォーム"]') ?>
    </div>
  </section>
  <!-- contact form /ends here -->
</main>
<!-- main /ends here -->

<?php get_footer(); ?>