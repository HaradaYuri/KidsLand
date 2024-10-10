<?php

/**
 * Template Name: こもれびだより Archive
 * Template Post Type: archive
 */

get_header();

// 現在の都道府県を取得
$current_prefecture = get_query_var('prefecture');
// 現在の園を取得
$current_nursery = isset($_GET['nursery']) ? sanitize_text_field($_GET['nursery']) : '';
?>

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
        <?php if (function_exists('yoast_breadcrumb')) : ?>
          <?php yoast_breadcrumb('<p id="breadcrumbs">', '</p>'); ?>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <!-- page-heading /ends here -->

  <!-- p-letter starts here -->
  <section class="p-letter">
    <div class="p-letter__container flex-rc">
      <!-- flex left -->
      <div class="p-letter__main fadeUpTrigger">
        <!-- search -->
        <div class="p-letter__search fadeUpTrigger">
          <div class="search__title">
            <i class="fa-solid fa-magnifying-glass"></i>
            園をさがす
          </div>
          <form method="get" action="<?php echo esc_url(home_url('/letter/')); ?>">
            <div class="search__chose flex-rc">
              <div class="search__chose-btn search__chose-btn--prefecture">
                <select name="prefecture" class="txts">
                  <option value="">都道府県をえらぶ</option>
                  <?php
                  $prefectures = get_terms(array(
                    'taxonomy' => 'prefecture',
                    'hide_empty' => false,
                  ));
                  foreach ($prefectures as $prefecture) {
                    $selected = ($current_prefecture === $prefecture->slug) ? 'selected' : '';
                    echo '<option value="' . esc_attr($prefecture->slug) . '" ' . $selected . '>' . esc_html($prefecture->name) . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="search__chose-inner flex-row">
                <div class="search__chose-btn search__chose-btn--nursery">

                  <select name="nursery" class="txts">
                    <option value="">園をえらぶ</option>
                    <?php
                    $nurseries = get_posts(array(
                      'post_type' => 'letter',
                      'posts_per_page' => -1,
                      'fields' => 'ids',
                    ));
                    $nursery_names = array();
                    foreach ($nurseries as $nursery_id) {
                      $nursery_name = CFS()->get('letter_nursery_name', $nursery_id);
                      if (!in_array($nursery_name, $nursery_names)) {
                        $nursery_names[] = $nursery_name;
                        $selected = ($current_nursery === $nursery_name) ? 'selected' : '';
                        echo '<option value="' . esc_attr($nursery_name) . '" ' . $selected . '>' . esc_html($nursery_name) . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
                <button type="submit" class="search__chose-btn search__chose-btn--search">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
        <!-- cards -->
        <div class="p-letter__cards cards__container">
          <?php
          $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
          $args = array(
            'post_type' => 'letter',
            'posts_per_page' => 9,
            'paged' => $paged,
            'meta_key' => 'letter_date',
            'orderby' => 'meta_value',
            'order' => 'DESC'
          );

          // アーカイブ
          $year = get_query_var('year');
          $monthnum = get_query_var('monthnum');
          if ($year && $monthnum) {
            $args['meta_query'] = array(
              array(
                'key' => 'letter_date',
                'value' => array($year . '-' . sprintf('%02d', $monthnum) . '-01', $year . '-' . sprintf('%02d', $monthnum) . '-31'),
                'compare' => 'BETWEEN',
                'type' => 'DATE'
              )
            );
          }

          // 都道府県の絞り込み
          if (!empty($current_prefecture)) {
            $args['tax_query'][] = array(
              'taxonomy' => 'prefecture',
              'field' => 'slug',
              'terms' => $current_prefecture,
            );
          }

          // 園の絞り込み
          if (!empty($current_nursery)) {
            $args['meta_query'][] = array(
              'key' => 'letter_nursery_name',
              'value' => $current_nursery,
              'compare' => '='
            );
          }

          $query = new WP_Query($args);

          if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
          ?>
              <article>
                <a href="<?php the_permalink(); ?>" class="cards-letter fadeUpTrigger">
                  <?php
                  $thumbnail = CFS()->get('letter_thumbnail');
                  if ($thumbnail) :
                  ?>
                    <img loading="lazy" src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr(CFS()->get('letter_title')); ?>">
                  <?php endif; ?>
                  <div class="text__block">
                    <h3 class="text__block-title"><?php echo esc_html(CFS()->get('letter_nursery_name')); ?>からのおたより</h3>
                    <p class="text__block-desc">
                      <?php echo esc_html(CFS()->get('letter_title')); ?>
                    </p>
                    <p class="text__block-date">
                      <?php
                      $date = CFS()->get('letter_date');
                      if ($date) {
                        $timestamp = strtotime($date);
                        $year = date('Y', $timestamp);
                        $month = date('n', $timestamp);
                        $day = date('j', $timestamp);
                        echo esc_html($year . 'ねん' . $month . 'がつ' . $day . 'にち');
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
        <!-- pagination -->
        <div class="pagination fadeUpTrigger">
          <?php
          $big = 999999999; // need an unlikely integer
          echo paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $query->max_num_pages,
            'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
            'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
          ));
          ?>
        </div>
      </div>
      <!-- flex left /ends -->

      <!-- flex right -->
      <div class="p-letter__archive fadeUpTrigger">
        <h3 class="archive__title">アーカイブ</h3>
        <?php
        $args = array(
          'post_type' => 'letter',
          'posts_per_page' => -1,
        );
        $letters = new WP_Query($args);
        $years = array();
        $months = array();

        if ($letters->have_posts()) :
          while ($letters->have_posts()) : $letters->the_post();
            $date = CFS()->get('letter_date');
            if ($date) {
              $year = date('Y', strtotime($date));
              $month = date('n', strtotime($date));
              $years[$year] = true;
              $months[$year][$month] = true;
            }
          endwhile;
          wp_reset_postdata();

          ksort($years);
          foreach ($years as $year => $value) :
        ?>
            <div class="archive__year pink-vertical-line"><?php echo esc_html($year); ?>ねん</div>
            <div class="archive__month-wrapper">
              <?php
              ksort($months[$year]);
              foreach ($months[$year] as $month => $value) :
                $archive_link = add_query_arg(array(
                  'post_type' => 'letter',
                  'year' => $year,
                  'monthnum' => $month
                ), home_url('/'));
              ?>
                <a href="<?php echo esc_url($archive_link); ?>" class="archive__month"><?php echo esc_html($month); ?>がつ</a>
              <?php endforeach; ?>
            </div>
        <?php
          endforeach;
        endif;
        ?>
      </div>
      <!-- flex right /ends -->
    </div>
  </section>
  <!-- p-lettter /ends here -->
</main>
<!-- main /ends here -->

<?php get_footer(); ?>