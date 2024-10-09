<?php get_header(); ?>

    <main>
      <div class="page-fv"></div>
      <!-- page-heading starts here -->
      <section class="page-heading">
        <div class="page-heading__container fadeUpTrigger">
          <div class="page-heading__text">
            <h2 class="page-heading__text-jp">こもれびだより</h2>
            <p class="page-heading__text-en txts-en">letter</p>
          </div>

          <!-- breadcrumbs -->
          <div class="breadcrumbs fadeUpTrigger">
            <p>
              TOP
              <i class="fa-solid fa-chevron-right"></i>
              こもれびだより
              <i class="fa-solid fa-chevron-right"></i>
              <span class="single-letter__brcr">
                なは園からのおたより『年長さんクラス、美ら海水族館に遠足に行きました！』
              </span>
            </p>
          </div>
        </div>
      </section>
      <!-- page-heading /ends here -->

      <!-- p-letter starts here -->
      <section class="p-letter">
        <div class="p-letter__container flex-rc">
          <!-- flex left -->
          <div class="p-letter__main">
            <!-- search -->

            <div class="single-letter">
              <div class="single-letter__top flex-rc">
                <p class="single-letter__top-heading">
                  <i class="fa-solid fa-pencil"></i>
                  なは園からのおたより
                </p>
                <p class="single-letter__top-day">2023ねん6がつ15にち</p>
              </div>
              <h2 class="single-letter__title">
                年長さんクラス、美ら海水族館に遠足に行きました！
              </h2>

              <img src="<?php echo get_template_directory_uri(); ?>/./assets/images/letter/erik-o990dFLgo1Q-unsplash.webp" alt="タイトルが入ります。" class="single-letter__img">

              <h3 class="single-letter__subtitle pink-vertical-line">
                巨大なジンベエザメに圧倒される
              </h3>
              <p class="single-letter__text">
                沖縄の美しい海に囲まれたなは園では、年長さんクラスの皆さんが、沖縄の自然を満喫できる美ら海水族館に遠足に行ってきました！
              </p>
              <p class="single-letter__text">
                特に人気を集めたのは、世界最大級の水槽「黒潮の海」で優雅に泳ぐジンベエザメです。子どもたちはその迫力に圧倒され、「すごーい！」「大きい！」と声を上げていました。中には、サメのぬいぐるみを持って水槽の前で記念撮影をする子もいました。
              </p>

              <h3 class="single-letter__subtitle pink-vertical-line">
                海の生き物たちとの出会い
              </h3>
              <p class="single-letter__text">
                色鮮やかな熱帯魚たちに大興奮！目を輝かせながら、水槽の前で熱心に観察していました。
              </p>
              <p class="single-letter__text">
                ジンベエザメ以外にも、サメやエイ、マンタ、ペンギンなど、様々な海の生き物たちが展示されていました。<br>
                今回の遠足を通して、子どもたちは沖縄の自然の素晴らしさを肌で感じ、海の生き物への興味を深めることができたようです。美しい海と海の生き物たちとの出会いは、子どもたちにとって忘れられない思い出となったことでしょう。
              </p>

              <a href="archive-letter.html" class="single-letter__btn btn-primary">
                こもれびだより一覧へ
                <i class="fa-solid fa-chevron-right"></i>
              </a>
            </div>
          </div>
          <!-- flex left /ends -->

          <!-- flex right -->
          <div class="p-letter__archive fadeUpTrigger">
            <h3 class="archive__title">アーカイブ</h3>
            <div class="archive__year pink-vertical-line">2023ねん</div>
            <div class="archive__month-wrapper">
              <a href="#" class="archive__month"> 4がつ </a>
              <a href="#" class="archive__month"> 5がつ </a>
              <a href="#" class="archive__month"> 6がつ </a>
              <a href="#" class="archive__month"> 7がつ </a>
              <a href="#" class="archive__month"> 8がつ </a>
              <a href="#" class="archive__month"> 9がつ </a>
              <a href="#" class="archive__month"> 10がつ </a>
              <a href="#" class="archive__month"> 11がつ </a>
              <a href="#" class="archive__month"> 12がつ </a>
              <a href="#" class="archive__month"> 1がつ </a>
              <a href="#" class="archive__month"> 2がつ </a>
              <a href="#" class="archive__month"> 3がつ </a>
            </div>
            <div class="archive__year pink-vertical-line">2024ねん</div>
            <div class="archive__month-wrapper">
              <a href="#" class="archive__month"> 4がつ </a>
            </div>
          </div>
          <!-- flex right /ends -->
        </div>
      </section>
      <!-- p-lettter /ends here -->
    </main>
    <!-- main /ends here -->

<?php get_footer(); ?>