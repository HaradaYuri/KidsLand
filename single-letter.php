<?php

/**
 * Template Name: こもれびだより Single
 * Template Post Type: letter
 */

get_header();
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
        <p>
          <a href="<?php echo esc_url(home_url('/')); ?>">TOP</a>
          <i class="fa-solid fa-chevron-right"></i>
          <a href="<?php echo esc_url(get_post_type_archive_link('letter')); ?>">こもれびだより</a>
          <i class="fa-solid fa-chevron-right"></i>
          <span class="single-letter__brcr">
            <?php echo esc_html(get_the_title()); ?>
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
        <div class="single-letter fadeUpTrigger">
          <div class="single-letter__top flex-rc">
            <p class="single-letter__top-heading">
              <i class="fa-solid fa-pencil"></i>
              <?php echo esc_html(CFS()->get('letter_nursery_name')); ?>からのおたより
            </p>
            <p class="single-letter__top-day">
              <?php
              $date = CFS()->get('letter_date');
              if ($date) {
                $timestamp = strtotime($date);
                echo esc_html(date('Y', $timestamp) . 'ねん' . date('n', $timestamp) . 'がつ' . date('j', $timestamp) . 'にち');
              }
              ?>
            </p>
          </div>
          <h2 class="single-letter__title">
            <?php echo esc_html(get_the_title()); ?>
          </h2>

          <?php
          $thumbnail = CFS()->get('letter_thumbnail');
          if ($thumbnail) :
          ?>
            <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="single-letter__img">
          <?php endif; ?>

          <?php
          $letter_loop = CFS()->get('letter_loop');
          if (is_array($letter_loop)) :
            foreach ($letter_loop as $letter_item) :
          ?>
              <h3 class="single-letter__subtitle pink-vertical-line">
                <?php echo esc_html($letter_item['letter_subtitle']); ?>
              </h3>
              <p class="single-letter__text">
                <?php echo nl2br(esc_html($letter_item['letter_text'])); ?>
              </p>
          <?php
            endforeach;
          endif;
          ?>

          <a href="<?php echo esc_url(get_post_type_archive_link('letter')); ?>" class="single-letter__btn btn-primary">
            こもれびだより一覧へ
            <i class="fa-solid fa-chevron-right"></i>
          </a>
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

          krsort($years);
          foreach ($years as $year => $value) :
        ?>
            <div class="archive__year pink-vertical-line"><?php echo esc_html($year); ?>ねん</div>
            <div class="archive__month-wrapper">
              <?php
              krsort($months[$year]);
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