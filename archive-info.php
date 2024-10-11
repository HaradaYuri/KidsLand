<?php get_header(); ?>

<main>
  <div class="page-fv"></div>
  <!-- page-heading starts here -->
  <section class="page-heading">
    <div class="page-heading__container fadeUpTrigger">
      <div class="page-heading__text">
        <h2 class="page-heading__text-jp">お知らせ</h2>
        <p class="page-heading__text-en txts-en">info</p>
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

  <!-- a-info starts here -->
  <section class="a-info">
    <div class="a-info__container flex-col">
      <div class="a-info__cats search__filters search__filters--cats fadeUpTrigger">
        <a href="<?php echo esc_url(remove_query_arg('category')); ?>" class="search__filter search__filter--cats <?php echo !isset($_GET['category']) ? 'active' : ''; ?> txts">
          すべて
        </a>
        <?php
        $categories = get_terms('info_category');
        foreach ($categories as $category) {
          $category_link = add_query_arg('category', $category->slug);
          $is_active = isset($_GET['category']) && $_GET['category'] === $category->slug ? 'active' : '';
          echo '<a href="' . esc_url($category_link) . '" class="search__filter search__filter--cats ' . $is_active . ' txts">' . $category->name . '</a>';
        }
        ?>
      </div>
      <div class="a-info__infos">
        <?php
        if (have_posts()) :
          while (have_posts()) : the_post();
            $categories = wp_get_post_terms(get_the_ID(), 'info_category');
            $category_name = !empty($categories) ? $categories[0]->name : 'お知らせ';
            $category_slug = !empty($categories) ? $categories[0]->slug : 'info';
        ?>
            <article class="info-item">
              <a href="<?php the_permalink(); ?>" class="a-info__item fadeUpTrigger">
                <!-- icon -->
                <div class="a-info__item-icon flex-col" data-type="<?php echo $category_slug; ?>">
                  <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-white-bell-ribbon.svg" alt="">
                  <span><?php echo $category_name; ?></span>
                </div>

                <!-- text -->
                <p class="a-info__item-day">
                  <?php
                  $date_string = CFS()->get('info_date');
                  $date = DateTime::createFromFormat('Y-m-d', $date_string);
                  $formatted_date = $date ? $date->format('Y.m.d') : '';

                  echo esc_html($formatted_date);
                  ?>
                </p>
                <p class="a-info__item-title">
                  <?php echo CFS()->get('info_title'); ?>
                </p>
                <p class="a-info__item-text">
                  <?php echo wp_trim_words(CFS()->get('info_text'), 60, '...'); ?>
                </p>
              </a>
            </article>
        <?php
          endwhile;
        else:
          echo '<p>該当する記事がありません。</p>';
        endif;
        ?>
      </div>

      <!-- pagination -->
      <div class="pagination fadeUpTrigger">
        <?php
        global $wp_query;
        $total_pages = $wp_query->max_num_pages;
        if ($total_pages > 1) :
          echo paginate_links(array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => 'page/%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $total_pages,
            'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
            'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
          ));
        endif;
        ?>
      </div>
    </div>
  </section>
  <!-- a-info /ends here -->
</main>
<!-- main /ends here -->

<?php get_footer(); ?>