<?php get_header(); ?>

<main>
  <div class="page-fv"></div>
  <!-- page-heading starts here -->
  <section class="page-heading">
    <div class="page-heading__container fadeUpTrigger fadeUpTriggerFV">
      <div class="page-heading__text">
        <h2 class="page-heading__text-jp">わたしたちのこと</h2>
        <p class="page-heading__text-en txts-en">about</p>
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

  <!-- philosophy starts here -->
  <section class="philosophy">
    <div class="philosophy__title title-primary">
      <div class="title-primary__icon fadeUpTrigger">
        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/./assets/images/icon-colored-cherry-blossom.webp" alt="わたしたちの想い" width="72" height="72">
      </div>
      <h2 class="fadeUpTrigger">わたしたちの想い</h2>
      <p class="fadeUpTrigger">philosophy</p>
    </div>

    <p class="philosophy__text txtm fadeUpTrigger">
      桜のこもれびキッズランドは、<br>子どもたち一人ひとりが独自の輝きを放つように、大切な個性を<br class="sp">伸ばす場所です。<br>風に揺れる木々の葉が織りなす光と影<span>の</span>美しい揺らめきのように、<br>子どもたちのそれぞれの魅力を見つけ出し、大切に育てます。<br>自然とのふれあいを通じて、<br>子どもたちの好奇心や想像力を育み、<br>明るく豊かな未来への一歩を<br class="sp">共に歩んでいきます。<br>温かく包み込むような雰囲気の中で、<br>安心して成長できる環境を提供し、<br>笑顔あふれる毎日をお約束します。
    </p>
  </section>
  <!-- philosophy /ends here -->

  <!-- yprogram starts here -->
  <section class="yprogram">
    <div class="yprogram__title title-primary">
      <div class="title-primary__icon fadeUpTrigger">
        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/./assets/images/icon-tree.svg" alt="年間行事" width="72" height="72">
      </div>
      <h2 class="fadeUpTrigger">年間行事予定</h2>
      <p class="fadeUpTrigger">yearly program</p>
    </div>

    <div class="yprogram__cards cards__container cards__container--bgL fadeUpTrigger">
      <article>
        <div class="cards-yprogram fadeUpTrigger">
          <img loading="lazy" width="296" height="180" src="<?php echo get_template_directory_uri(); ?>/./assets/images/yp4.webp" alt="綺麗で広い園内の様子">
          <div class="text__block">
            <h3 class="text__block-month">4がつ</h3>
            <p class="text__block-desc">進級・入園おめでとうの会</p>
          </div>
        </div>
      </article>
      <article>
        <div class="cards-yprogram fadeUpTrigger">
          <img loading="lazy" width="296" height="180" src="<?php echo get_template_directory_uri(); ?>/./assets/images/yp5.webp" alt="散歩する園児">
          <div class="text__block">
            <h3 class="text__block-month">5がつ</h3>
            <p class="text__block-desc">親子遠足</p>
          </div>
        </div>
      </article>
      <article>
        <div class="cards-yprogram fadeUpTrigger">
          <img loading="lazy" width="296" height="180" src="<?php echo get_template_directory_uri(); ?>/./assets/images/yp6.webp" alt="運動会の様子">
          <div class="text__block">
            <h3 class="text__block-month">6がつ</h3>
            <p class="text__block-desc">運動会</p>
          </div>
        </div>
      </article>
      <article>
        <div class="cards-yprogram fadeUpTrigger">
          <img loading="lazy" width="296" height="180" src="<?php echo get_template_directory_uri(); ?>/./assets/images/yp7.webp" alt="七夕の願い事">
          <div class="text__block">
            <h3 class="text__block-month">7がつ</h3>
            <p class="text__block-desc">たなばた会</p>
          </div>
        </div>
      </article>
      <article>
        <div class="cards-yprogram fadeUpTrigger">
          <img loading="lazy" width="296" height="180" src="<?php echo get_template_directory_uri(); ?>/./assets/images/yp8.webp" alt="水遊びする男の子">
          <div class="text__block">
            <h3 class="text__block-month">8がつ</h3>
            <p class="text__block-desc">夏のお楽しみ会</p>
          </div>
        </div>
      </article>
      <article>
        <div class="cards-yprogram fadeUpTrigger">
          <img loading="lazy" width="296" height="180" src="<?php echo get_template_directory_uri(); ?>/./assets/images/yp9.webp" alt="滑り台で遊ぶ男の子">
          <div class="text__block">
            <h3 class="text__block-month">9がつ</h3>
            <p class="text__block-desc">親子レクリエーション</p>
          </div>
        </div>
      </article>
      <article>
        <div class="cards-yprogram fadeUpTrigger">
          <img loading="lazy" width="296" height="180" src="<?php echo get_template_directory_uri(); ?>/./assets/images/yp10.webp" alt="ハロウィンで仮装する園児">
          <div class="text__block">
            <h3 class="text__block-month">10がつ</h3>
            <p class="text__block-desc">ハロウィン</p>
          </div>
        </div>
      </article>
      <article>
        <div class="cards-yprogram fadeUpTrigger">
          <img loading="lazy" width="296" height="180" src="<?php echo get_template_directory_uri(); ?>/./assets/images/yp11.webp" alt="自然の中を歩く園児">
          <div class="text__block">
            <h3 class="text__block-month">11がつ</h3>
            <p class="text__block-desc">秋の収穫体験遠足</p>
          </div>
        </div>
      </article>
      <article>
        <div class="cards-yprogram fadeUpTrigger">
          <img loading="lazy" width="296" height="180" src="<?php echo get_template_directory_uri(); ?>/./assets/images/yp12.webp" alt="クリスマス会の様子">
          <div class="text__block">
            <h3 class="text__block-month">12がつ</h3>
            <p class="text__block-desc">クリスマス会</p>
          </div>
        </div>
      </article>
      <article>
        <div class="cards-yprogram fadeUpTrigger">
          <img loading="lazy" width="296" height="180" src="<?php echo get_template_directory_uri(); ?>/./assets/images/yp1.webp" alt="新年お楽しみ会の様子">
          <div class="text__block">
            <h3 class="text__block-month">1がつ</h3>
            <p class="text__block-desc">新年お楽しみ会</p>
          </div>
        </div>
      </article>
      <article>
        <div class="cards-yprogram fadeUpTrigger">
          <img loading="lazy" width="296" height="180" src="<?php echo get_template_directory_uri(); ?>/./assets/images/yp2.webp" alt="おゆうぎ会の様子">
          <div class="text__block">
            <h3 class="text__block-month">2がつ</h3>
            <p class="text__block-desc">おゆうぎ会</p>
          </div>
        </div>
      </article>
      <article>
        <div class="cards-yprogram fadeUpTrigger">
          <img loading="lazy" width="296" height="180" src="<?php echo get_template_directory_uri(); ?>/./assets/images/yp3.webp" alt="親にお花を渡す子供">
          <div class="text__block">
            <h3 class="text__block-month">3がつ</h3>
            <p class="text__block-desc">ひな祭り会・巣立ちの会</p>
          </div>
        </div>
      </article>
      <p class="yprogram__desc fadeUpTrigger">
        ※上記予定は一例です。園や状況により内容は異なりますので、詳しくは園にお問い合わせください。
      </p>
    </div>
  </section>
  <!-- yprogram /ends here -->

  <!-- contact starts here -->
  <section class="contact flex-col">
    <div class="contact__container fadeUpTrigger">
      <div class="contact__title title-primary">
        <div class="title-primary__icon fadeUpTrigger">
          <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/./assets/images/icon-mail.svg" alt="お問い合わせ" width="72" height="72">
        </div>
        <h2 class="fadeUpTrigger">お問い合わせ</h2>
        <p class="fadeUpTrigger">contact</p>
      </div>

      <p class="contact__text txtm fadeUpTrigger">
        入園のお申込み、<br class="sp">見学のご相談はこちらから！
      </p>

      <a href="#" class="contact__btn btn-primary fadeUpTrigger">
        お問い合わせ
        <i class="fa-solid fa-chevron-right"></i>
      </a>
    </div>
  </section>
  <!-- contact /ends here -->
</main>
<!-- main /ends here -->

<?php get_footer(); ?>