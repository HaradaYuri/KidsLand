<?php get_header(); ?>

<main>
  <div class="page-fv"></div>
  <!-- page-heading starts here -->
  <section class="page-heading">
    <div class="page-heading__container fadeUpTrigger">
      <div class="page-heading__text">
        <h2 class="page-heading__text-jp">お問い合わせ</h2>
        <p class="page-heading__text-en txts-en">contact</p>
      </div>

      <!-- breadcrumbs -->
      <div class="breadcrumbs fadeUpTrigger">
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
    <a href="page-privacy-policy.html" class="contact-desc__text contact-desc__text--underline">弊社への登録に際して、お預かりする個人情報の扱いについて</a>
  </section>
  <!-- contact-desc /ends here -->

  <!-- contact form starts here -->
  <section class="form__container contact__form-container">
    <form class="form contact__form bg-bgL">
      <div class="form__group">
        <label class="form__heading">
          お名前
          <span class="form__tag" data-type="required">必須</span>
        </label>
        <div class="form__fields">
          <div class="form__field">
            <input type="text" id="name" name="name" class="form__input" placeholder="" required="">
          </div>
        </div>
      </div>
      <div class="form__group">
        <label class="form__heading">
          お子様のご年齢
          <span class="form__tag" data-type="optional">任意</span>
        </label>
        <div class="form__fields">
          <div class="form__field">
            <input type="text" id="childage" name="childage" class="form__input" placeholder="">
          </div>
        </div>
      </div>

      <div class="form__group">
        <label class="form__heading">
          ご住所
          <span class="form__tag" data-type="optional">任意</span>
        </label>
        <div class="form__fields">
          <div class="form__field form__field--with-text">
            <label class="form__heading"> 郵便番号 </label>
            <input type="text" id="postal_code" name="postal_code" class="form__input" placeholder="">
          </div>
          <div class="form__field form__field--with-text">
            <label class="form__heading"> 都道府県 </label>
            <input type="text" id="prefecture" name="prefecture" class="form__input" placeholder="">
          </div>
          <div class="form__field form__field--with-text">
            <label class="form__heading"> 市区町村 </label>
            <input type="text" id="city" name="city" class="form__input" placeholder="">
          </div>
          <div class="form__field form__field--with-text">
            <label class="form__heading"> 番地、建物名 </label>
            <input type="text" id="address" name="address" class="form__input" placeholder="">
          </div>
        </div>
      </div>

      <div class="form__group">
        <label class="form__heading">
          電話番号
          <span class="form__tag" data-type="optional">任意</span>
        </label>
        <div class="form__fields">
          <div class="form__field">
            <input type="tel" id="phone" name="phone" class="form__input" placeholder="">
          </div>
        </div>
      </div>

      <div class="form__group">
        <label class="form__heading">
          メールアドレス
          <span class="form__tag" data-type="required">必須</span>
        </label>
        <div class="form__fields">
          <div class="form__field">
            <input type="email" id="email" name="email" class="form__input" placeholder="" required="">
          </div>
        </div>
      </div>

      <div class="form__group">
        <label class="form__heading">
          お問い合わせの保育園
          <span class="form__tag" data-type="required">必須</span>
        </label>
        <div class="form__fields">
          <div class="form__field">
            <input type="text" id="inquiry_school" name="inquiry_school" class="form__input" placeholder="" required="">
          </div>
        </div>
      </div>

      <div class="form__group">
        <label class="form__heading">
          お問い合わせ内容
          <span class="form__tag" data-type="required">必須</span>
        </label>
        <div class="form__fields">
          <div class="form__field">
            <textarea id="inquiry_type" name="inquiry_type" class="form__textarea form__textarea--large" required=""></textarea>
          </div>
        </div>
      </div>

      <div class="form__group">
        <div class="form__fields">
          <div class="form__field form__field-agreement">
            <input type="checkbox" name="agree_terms" class="form__checkbox" required="">
            <div class="agreement-content flex-rc">
              利用規約と個人情報の<br class="sp">取り扱いについて同意する
              <span class="form__tag" data-type="required">必須</span>
            </div>
          </div>
        </div>
      </div>

      <div class="form__submit">
        <a href="page-contact-confirm.html" type="" class="form__button btn-primary">
          内容確認
          <i class="fa-solid fa-chevron-right"></i>
        </a>
      </div>
    </form>
  </section>
  <!-- contact form /ends here -->
</main>
<!-- main /ends here -->

<?php get_footer(); ?>