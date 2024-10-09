<?php get_header(); ?>

    <main>
      <div class="page-fv"></div>
      <!-- page-heading starts here -->
      <section class="page-heading">
        <div class="page-heading__container fadeUpTrigger">
          <div class="page-heading__text">
            <h2 class="page-heading__text-jp">採用情報</h2>
            <p class="page-heading__text-en txts-en">recruit</p>
          </div>

          <!-- breadcrumbs -->
          <div class="breadcrumbs fadeUpTrigger">
            <p>
              TOP
              <i class="fa-solid fa-chevron-right"></i>
              採用情報
            </p>
          </div>
        </div>
      </section>
      <!-- page-heading /ends here -->

      <!-- recruit form starts here -->
      <section class="form__container recruit__form-container">
        <form class="form recruit-confirm__form bg-bgL">
          <div class="form__group">
            <label class="form__heading">
              お問い合わせ内容
              <span class="form__tag" data-type="required">必須</span>
            </label>
            <div class="form__fields">園の見学をしたい</div>
          </div>

          <div class="form__group">
            <label class="form__heading">
              卒業予定年月
              <span class="form__tag" data-type="required">必須</span>
            </label>
            <div class="form__fields">2024年3月</div>
          </div>

          <div class="form__group">
            <label class="form__heading">
              お名前
              <span class="form__tag" data-type="required">必須</span>
            </label>
            <div class="form__fields">やまだ　たろう</div>
          </div>
          <div class="form__group">
            <label class="form__heading">
              生年月日
              <span class="form__tag" data-type="required">必須</span>
            </label>
            <div class="form__fields">2001年4月1日</div>
          </div>
          <div class="form__group">
            <label class="form__heading">
              性別
              <span class="form__tag" data-type="optional">任意</span>
            </label>
            <div class="form__fields">男性</div>
          </div>

          <div class="form__group">
            <label class="form__heading">
              ご住所
              <span class="form__tag" data-type="required">必須</span>
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
              <span class="form__tag" data-type="required">必須</span>
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
              学校名
              <span class="form__tag" data-type="optional">任意</span>
            </label>
            <div class="form__fields">
              <div class="form__field">○○大学</div>
            </div>
          </div>

          <div class="form__group">
            <label class="form__heading">
              学科名
              <span class="form__tag" data-type="optional">任意</span>
            </label>
            <div class="form__fields">
              <div class="form__field">○○学部</div>
            </div>
          </div>

          <div class="form__group">
            <label class="form__heading">
              希望職種
              <span class="form__tag" data-type="required">必須</span>
            </label>
            <div class="form__fields">
              <div class="form__field">保育士（保育免許あり）</div>
            </div>
          </div>

          <div class="form__group">
            <label class="form__heading">
              希望雇用形態
              <span class="form__tag" data-type="required">必須</span>
            </label>
            <div class="form__fields">
              <div class="form__field">正社員</div>
            </div>
          </div>

          <div class="form__group">
            <label class="form__heading">
              希望就業エリア
              <span class="form__tag" data-type="required">必須</span>
            </label>
            <div class="form__fields">都内</div>
          </div>

          <div class="form__group">
            <label class="form__heading">
              ご要望・ご質問
              <span class="form__tag" data-type="optional">任意</span>
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
      <!-- recruit form /ends here -->
    </main>
    <!-- main /ends here -->

<?php get_footer(); ?>