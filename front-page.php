<?php get_header(); ?>

<!-- main starts here -->
<main class="main">
  <!-- fv starts here -->
  <section class="fv">
    <div class="fv__image"></div>

    <div class="fv__title">
      <h2 class="fv__title-text fadeUpTrigger">
        一人ひとり<span>の</span>輝きが、<br>未来<span>を</span>彩る
      </h2>
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Vector.svg" alt="" class="fv__title-image fadeUpTrigger">
    </div>

    <?php
    $args = array(
      'post_type' => 'info',
      'posts_per_page' => 1,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
      while ($query->have_posts()) : $query->the_post();
        $categories = get_the_category();
        $category_name = !empty($categories) ? $categories[0]->name : 'お知らせ';
        $category_slug = !empty($categories) ? $categories[0]->slug : 'info';
    ?>
        <article>
          <a href="<?php the_permalink(); ?>" class="fv__news fadeUpTrigger">
            <h2 class="fv__news-header"><?php echo esc_html($category_name); ?></h2>
            <p class="fv__news-title"><?php the_title(); ?></p>
            <p class="fv__news-date">

              <?php
              $date_string = CFS()->get('info_date');
              $date = DateTime::createFromFormat('Y-m-d', $date_string);
              $formatted_date = $date ? $date->format('Yがつnにちj') : '';

              echo esc_html($formatted_date);
              ?>
            </p>
          </a>
        </article>
    <?php
      endwhile;
      wp_reset_postdata();
    else:
      echo '<p>お知らせはありません。</p>';
    endif;
    ?>
  </section>
  <!-- fv /ends here -->

  <!-- welcome starts here -->
  <section class="welcome">
    <div class="welcome__title title-primary">
      <div class="title-primary__icon fadeUpTrigger">
        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-colored-cherry-blossom.webp" alt="桜のこもれびキッズランドへようこそ">
      </div>
      <h2 class="fadeUpTrigger">
        桜のこもれびキッズランドへ<br>ようこそ
      </h2>
      <p class="fadeUpTrigger">welcome</p>
    </div>

    <p class="welcome__text txtm fadeUpTrigger">
      「こもれび」とは<br>
      風に揺れる木の葉によって生み出される<br class="pc">光と影の揺らめきを表すことばです。<br>それはその瞬間に一度だけ存在します。
    </p>
    <p class="welcome__text txtm fadeUpTrigger">
      桜のこもれびキッズランドは、<br>子どもたち一人ひとりが<br class="pc">独自の輝きを放つように、<br>大切な個性を伸ばす場所です。<br>温かく包み込むような雰囲気の中で、<br class="pc">安心して成長できる環境を提供し、<br>笑顔あふれる毎日をお約束します。<br>
    </p>
  </section>
  <!-- welcome /ends here -->

  <!-- introduction starts here -->
  <section class="introduction">
    <div class="introduction__title title-primary">
      <div class="title-primary__icon fadeUpTrigger">
        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-tree.svg" alt="各園のご紹介">
      </div>
      <h2 class="fadeUpTrigger">各園のご紹介</h2>
      <p class="fadeUpTrigger">introduction</p>
    </div>

    <div class="introduction__prefectures">
      <?php
      $prefecture_slugs = ['tokyo', 'kanagawa', 'saitama', 'chiba', 'osaka', 'kyoto'];
      $prefecture_names = ['東京都', '神奈川県', '埼玉県', '千葉県', '大阪府', '京都府'];

      foreach ($prefecture_slugs as $index => $slug) {
        $term = get_term_by('slug', $slug, 'prefecture');
        if ($term) {
          $link = home_url("/introduction/?taxonomy=prefecture&term={$slug}");
      ?>
          <a href="<?php echo esc_url($link); ?>" class="introduction__block fadeUpTrigger">
            <?php echo esc_html($prefecture_names[$index]); ?>
          </a>
      <?php
        }
      }
      ?>
    </div>

    <a href="<?php echo esc_url('/introduction'); ?>" class="btn-primary fadeUpTrigger">
      一覧ページへ
      <i class="fa-solid fa-chevron-right"></i>
    </a>
  </section>
  <!-- introduction /ends here -->

  <!-- letter starts here -->
  <section class="letter bg-pink-dash">
    <div class="letter__title title-primary">
      <div class="title-primary__icon fadeUpTrigger">
        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-letter.svg" alt="こもれびだより">
      </div>
      <h2 class="fadeUpTrigger">こもれびだより</h2>
      <p class="fadeUpTrigger">letter</p>
    </div>

    <div class="letter__cards cards__container">
      <?php
      $args = array(
        'post_type' => 'letter',
        'posts_per_page' => 6,
        'orderby' => 'meta_value',
        'meta_key' => 'letter_date',
        'order' => 'DESC'
      );
      $letter_query = new WP_Query($args);

      if ($letter_query->have_posts()) :
        while ($letter_query->have_posts()) : $letter_query->the_post();
          $letter_thumbnail = CFS()->get('letter_thumbnail');
          $letter_nursery_name = CFS()->get('letter_nursery_name');
          $letter_title = CFS()->get('letter_title');
          $letter_date = CFS()->get('letter_date');
      ?>
          <article>
            <a href="<?php the_permalink(); ?>" class="cards-letter fadeUpTrigger">
              <?php if ($letter_thumbnail) : ?>
                <img loading="lazy" src="<?php echo esc_url($letter_thumbnail); ?>" alt="<?php echo esc_attr($letter_title); ?>">
              <?php endif; ?>
              <div class="text__block">
                <h3 class="text__block-title"><?php echo esc_html($letter_nursery_name); ?>からのおたより</h3>
                <p class="text__block-desc">
                  <?php echo esc_html($letter_title); ?>
                </p>
                <p class="text__block-date">
                  <?php
                  if ($letter_date) {
                    $timestamp = strtotime($letter_date);
                    echo esc_html(date('Y', $timestamp) . 'ねん' . date('n', $timestamp) . 'がつ' . date('j', $timestamp) . 'にち');
                  }
                  ?>
                </p>
              </div>
            </a>
          </article>
      <?php
        endwhile;
        wp_reset_postdata();
      else :
        echo '<p>まだおたよりがありません。</p>';
      endif;
      ?>
    </div>

    <a href="<?php echo esc_url('/letter'); ?>" class="letter__btn btn-primary fadeUpTrigger">
      もっと見る
      <i class="fa-solid fa-chevron-right"></i>
    </a>
  </section>
  <!-- letter /ends here -->

  <!-- recruit starts here -->
  <section class="recruit flex-col">
    <div class="recruit__container fadeUpTrigger">
      <div class="recruit__title title-primary">
        <div class="title-primary__icon fadeUpTrigger">
          <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-pen.svg" alt="採用情報">
        </div>
        <h2 class="fadeUpTrigger">採用情報</h2>
        <p class="fadeUpTrigger">recruit</p>
      </div>

      <p class="recruit__text txtm fadeUpTrigger">
        桜のこもれびキッズランドで<br class="sp">
        働いてみませんか？
      </p>

      <div class="recruit__btn-wrapper flex-rc">
        <a href="<?php echo esc_url('/recruit'); ?>" class="recruit__btn btn-primary fadeUpTrigger">
          採用情報
          <i class="fa-solid fa-chevron-right"></i>
        </a>

        <a href="<?php echo esc_url('/recruit#recruitForm'); ?>" class="recruit__btn btn-primary fadeUpTrigger">
          エントリー
          <i class="fa-solid fa-chevron-right"></i>
        </a>
      </div>
    </div>
  </section>
  <!-- recruit /ends here -->

</main>
<!-- main /ends here -->

<?php get_footer(); ?>