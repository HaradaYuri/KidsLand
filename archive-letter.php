<?php
$current_prefecture = get_query_var('term');
$current_nursery = isset($_GET['nursery']) ? sanitize_text_field($_GET['nursery']) : '';

get_header();
?>

<main>
  <div class="page-fv"></div>
  <!-- page-heading starts here -->
  <section class="page-heading">
    <div class="page-heading__container fadeUpTrigger fadeUpTriggerFV">
      <div class="page-heading__text">
        <h2 class="page-heading__text-jp">こもれびだより</h2>
        <p class="page-heading__text-en txts-en">letter</p>
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
                    $nursery_args = array(
                      'post_type' => 'letter',
                      'posts_per_page' => -1,
                      'fields' => 'ids',
                    );

                    // If prefecture is selected, filter nurseries by prefecture
                    if (!empty($current_prefecture)) {
                      $nursery_args['tax_query'] = array(
                        array(
                          'taxonomy' => 'prefecture',
                          'field' => 'slug',
                          'terms' => $current_prefecture,
                        )
                      );
                    }

                    $nurseries = get_posts($nursery_args);
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
          $letter_year = get_query_var('letter_year');
          $letter_month = get_query_var('letter_month');

          if ($letter_year && $letter_month) {
            $start_date = $letter_year . '-' . $letter_month . '-01';
            $end_date = date('Y-m-t', strtotime($start_date));

            $args['meta_query'] = array(
              array(
                'key' => 'letter_date',
                'value' => array($start_date, $end_date),
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
                  $no_img = get_template_directory_uri() . '/assets/images/no-image.webp';
                  $img_src = $thumbnail ? esc_url($thumbnail) : esc_url($no_img);
                  $img_alt = $thumbnail ? esc_attr(CFS()->get('letter_title')) : "桜のこもれびキッズランド";
                  ?>
                  <img loading="lazy" src="<?php echo $img_src; ?>" alt="<?php echo $img_alt; ?>" width="300" height="135">
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
          $total_pages = $query->max_num_pages;
          if ($total_pages > 1) :
            echo paginate_links(array(
              'total' => $total_pages,
              'current' => max(1, get_query_var('paged')),
              'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
              'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
            ));
          endif;
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
                $archive_link = home_url('/letter/date/' . $year . '/' . sprintf('%02d', $month) . '/');

                // Add current filters to the archive link
                $query_args = array();
                if (!empty($current_prefecture)) {
                  $query_args['prefecture'] = $current_prefecture;
                }
                if (!empty($current_nursery)) {
                  $query_args['nursery'] = $current_nursery;
                }

                if (!empty($query_args)) {
                  $archive_link = add_query_arg($query_args, $archive_link);
                }

                $is_active = ($letter_year == $year && $letter_month == $month) ? 'active' : '';
              ?>
                <a href="<?php echo esc_url($archive_link); ?>" class="archive__month <?php echo $is_active; ?>"><?php echo esc_html($month); ?>がつ</a>
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