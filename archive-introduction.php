<?php
$current_taxonomy = isset($_GET['taxonomy']) ? $_GET['taxonomy'] : 'nursery_type';
$current_term = isset($_GET['term']) ? $_GET['term'] : '';
$is_nursery_type = ($current_taxonomy === 'nursery_type');
$is_prefecture = ($current_taxonomy === 'prefecture');

if (empty($current_term)) {
  $current_term = $is_nursery_type ? 'licensed-nursery' : 'tokyo';
}

// カスタムクエリの設定
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
  'post_type' => 'introduction',
  'tax_query' => array(
    array(
      'taxonomy' => $current_taxonomy,
      'field'    => 'slug',
      'terms'    => $current_term,
    ),
  ),
  'posts_per_page' => 9,
  'paged' => $paged,
);
$custom_query = new WP_Query($args);

get_header();
?>

<main>
  <div class="page-fv"></div>
  <!-- page-heading starts here -->
  <section class="page-heading">
    <div class="page-heading__container fadeUpTrigger">
      <div class="page-heading__text">
        <h2 class="page-heading__text-jp">各園のご紹介</h2>
        <p class="page-heading__text-en txts-en">introduction</p>
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

  <!-- introduction starts here -->
  <section class="p-introduction bg-pink-dash">
    <div class="p-introduction__title title-primary">
      <div class="title-primary__icon fadeUpTrigger">
        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-tree.svg" alt="各園のご紹介">
      </div>
    </div>

    <div class="search__tabs fadeUpTrigger">
      <a href="<?php echo add_query_arg(['taxonomy' => 'nursery_type'], get_post_type_archive_link('introduction')); ?>" class="search__tab txts <?php echo $is_nursery_type ? 'active' : ''; ?>">
        園の種類<br>
        <span>から探す</span>
      </a>
      <a href="<?php echo add_query_arg(['taxonomy' => 'prefecture'], get_post_type_archive_link('introduction')); ?>" class="search__tab txts <?php echo $is_prefecture ? 'active' : ''; ?>">
        都道府県<br>
        <span>から探す</span>
      </a>
    </div>
    <div class="introduction__cards cards__container cards__container--bgL fadeUpTrigger">

      <!-- filters -->
      <div class="search__filters <?php echo $current_taxonomy === 'prefecture' ? 'search__filters--prefecture' : ''; ?>">
        <?php
        $terms = get_terms([
          'taxonomy' => $current_taxonomy,
          'hide_empty' => false,
        ]);
        if (!is_wp_error($terms) && !empty($terms)) {
          $sorted_terms = array();

          foreach ($terms as $term) {
            $order = trim(substr($term->description, 0, 2));
            if ($current_taxonomy === 'prefecture' && empty($order)) {
              continue; // 番号が空の場合はスキップ
            }
            $sorted_terms[] = array(
              'term' => $term,
              'order' => is_numeric($order) ? intval($order) : PHP_INT_MAX // 数字でない場合は最後にソート
            );
          }

          // ソート実行
          usort($sorted_terms, function ($a, $b) {
            return $a['order'] - $b['order'];
          });

          foreach ($sorted_terms as $sorted_term) :
            $term = $sorted_term['term'];
            $active = ($current_term === $term->slug) ? 'active' : '';
            $link = add_query_arg(['taxonomy' => $current_taxonomy, 'term' => $term->slug], get_post_type_archive_link('introduction'));
        ?>
            <a href="<?php echo esc_url($link); ?>" class="search__filter txts <?php echo $active; ?>"><?php echo $term->name; ?></a>
        <?php
          endforeach;
        } else {
          echo '<p>タームが見つかりませんでした。</p>';
        }
        ?>
      </div>

      <!-- cards -->
      <?php
      if ($custom_query->have_posts()) :
        while ($custom_query->have_posts()) : $custom_query->the_post();
      ?>
          <article class="cards-introduction fadeUpTrigger" data-type="<?php echo get_the_terms(get_the_ID(), 'nursery_type')[0]->slug; ?>">
            <a href="<?php the_permalink(); ?>" class="card-link">
              <?php
              $thumbnail = CFS()->get('thumbnail');
              $no_img = get_template_directory_uri() . '/assets/images/no-image.webp';
              $img_src = $thumbnail ? esc_url($thumbnail) : esc_url($no_img);
              $img_alt = $thumbnail ? esc_attr(CFS()->get('nursery_name')) : "桜のこもれびキッズランド";
              ?>
              <img loading="lazy" src="<?php echo $img_src; ?>" alt="<?php echo $img_alt; ?>">
            </a>

            <!-- content -->
            <div class="card__content">
              <div class="card__infos">
                <a href="<?php echo add_query_arg(['taxonomy' => 'nursery_type', 'term' => get_the_terms(get_the_ID(), 'nursery_type')[0]->slug], get_post_type_archive_link('introduction')); ?>" class="card__info card__info--type">
                  <?php echo get_the_terms(get_the_ID(), 'nursery_type')[0]->name; ?>
                </a>
                <a href="<?php echo add_query_arg(['taxonomy' => 'prefecture', 'term' => get_the_terms(get_the_ID(), 'prefecture')[0]->slug], get_post_type_archive_link('introduction')); ?>" class="card__info card__info--prefecture">
                  <?php echo get_the_terms(get_the_ID(), 'prefecture')[0]->name; ?>
                </a>
              </div>
              <h3 class="card__content-title"><?php the_title(); ?></h3>
            </div>

          </article>
      <?php
        endwhile;
        wp_reset_postdata();
      else :
        echo '<p>該当する園が見つかりませんでした。</p>';
      endif;
      ?>


      <div class="pagination fadeUpTrigger">
        <?php
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $taxonomy = get_query_var('taxonomy');
        $term = get_query_var('term');

        // ベースURLを設定
        if ($taxonomy && $term) {
          $base = home_url("/introduction/{$taxonomy}/{$term}/page/%#%/");
        } else {
          $base = home_url("/introduction/page/%#%/");
        }

        echo paginate_links(array(
          'base' => $base,
          'format' => '',
          'current' => $paged,
          'total' => $custom_query->max_num_pages,
          'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
          'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
          'add_fragment' => ''
        ));
        ?>
      </div>
    </div>
  </section>
  <!-- introduction /ends here -->

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
        <a href="<?php echo home_url('/recruit'); ?>" class="recruit__btn btn-primary fadeUpTrigger">
          採用情報
          <i class="fa-solid fa-chevron-right"></i>
        </a>

        <a href="<?php echo home_url('/recruit'); ?>" class="recruit__btn btn-primary fadeUpTrigger">
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