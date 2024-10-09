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

      </div></section>
      <!-- page-heading /ends here -->

      <!-- contact form starts here -->
      <section class="form__container contact__form-container">
        <form class="form contact-confirm__form bg-bgL">

          <div class="form__group">
            <label class="form__heading">
              お名前
              <span class="form__tag" data-type="required">必須</span>
            </label>
            <div class="form__fields">山田　太郎</div>
          </div>

          <div class="form__group">
            <label class="form__heading">
              お子様のご年齢
              <span class="form__tag" data-type="optional">任意</span>
            </label>
            <div class="form__fields">3歳</div>
          </div>

          <div class="form__group">
            <label class="form__heading">
              ご住所
              <span class="form__tag" data-type="optional">任意</span>
            </label>
            <div class="form__fields">
              <div class="form__field form__field--with-text">
                <label class="form__heading"> 郵便番号 </label>
                <span>000-0000</span>
              </div>
              <div class="form__field form__field--with-text">
                <label class="form__heading"> 都道府県 </label>
                <span>東京都</span>
              </div>
              <div class="form__field form__field--with-text">
                <label class="form__heading"> 市区町村 </label>
                <span>渋谷区○○市</span>
              </div>
              <div class="form__field form__field--with-text">
                <label class="form__heading"> 番地、建物名 </label>
                <span>0-0-0</span>
              </div>
            </div>
          </div>

          <div class="form__group">
            <label class="form__heading">
              電話番号
              <span class="form__tag" data-type="optional">任意</span>
            </label>
            <div class="form__fields">
              <div class="form__field">000-0000-0000</div>
            </div>
          </div>

          <div class="form__group">
            <label class="form__heading">
              メールアドレス
              <span class="form__tag" data-type="required">必須</span>
            </label>
            <div class="form__fields">
              <div class="form__field">example@gmail.com</div>
            </div>
          </div>

          <div class="form__group">
            <label class="form__heading">
              お問い合わせの保育園
              <span class="form__tag" data-type="required">必須</span>
            </label>
            <div class="form__fields">
              <div class="form__field">渋谷園</div>
            </div>
          </div>


          <div class="form__group">
            <label class="form__heading">
              お問い合わせ内容
              <span class="form__tag" data-type="required">必須</span>
            </label>
            <div class="form__fields">
              <div class="form__field">お問い合わせ内容が入ります。</div>
            </div>
          </div>

          <div class="form__submit">
            <a href="page-contact-thanks.html" type="submit" class="form__button btn-primary">
              送信
              <i class="fa-solid fa-chevron-right"></i>
            </a>
          </div>
        </form>
      </section>
      <!-- contact form /ends here -->
    </main>
    <!-- main /ends here -->

<?php get_footer(); ?>