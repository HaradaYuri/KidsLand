<?php get_header(); ?>

<main>
  <div class="page-fv"></div>
  <!-- page-heading starts here -->
  <section class="page-heading">
    <div class="page-heading__container fadeUpTrigger fadeUpTriggerFV">
      <div class="page-heading__text">
        <h2 class="page-heading__text-jp">お知らせ</h2>
        <p class="page-heading__text-en txts-en">info</p>
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

  <!-- s-info (s-letter) starts here -->
  <section class="s-info">
    <div class="s-letter s-info__container">
      <?php
      if (have_posts()) :
        while (have_posts()) : the_post();
          $category = wp_get_post_terms(get_the_ID(), 'info_category');
          $category_name = !empty($category) ? $category[0]->name : 'お知らせ';

          // 日付の取得と整形
          $date_string = CFS()->get('info_date');
          $date = DateTime::createFromFormat('Y-m-d', $date_string);
          $formatted_date = $date ? $date->format('Y.m.d') : '';
      ?>
          <div class="s-letter__top fadeUpTrigger">
            <p class="s-letter__top-day"><?php echo esc_html($formatted_date); ?></p>
          </div>
          <h2 class="s-letter__title fadeUpTrigger">
            <?php echo CFS()->get('info_title'); ?>
          </h2>

          <?php
          $thumbnail = CFS()->get('info_thumbnail');
          $no_img = get_template_directory_uri() . '/assets/images/no-image.webp';
          $img_src = $thumbnail ? esc_url($thumbnail) : esc_url($no_img);
          $img_alt = esc_attr(CFS()->get('info_title'));
          ?>
          <img loading="lazy" src="<?php echo $img_src; ?>" alt="<?php echo $img_alt; ?>" class="s-letter__img fadeUpTrigger">

          <?php
          $content_loop = CFS()->get('info_loop');
          if (!empty($content_loop)) :
            foreach ($content_loop as $content) :
          ?>
              <?php if (!empty($content['info_subtitle'])) : ?>
                <h3 class="s-letter__subtitle pink-vertical-line fadeUpTrigger">
                  <?php echo $content['info_subtitle']; ?>
                </h3>
              <?php endif; ?>
              <?php if (!empty($content['info_text'])) : ?>
                <p class="s-letter__text fadeUpTrigger">
                  <?php echo nl2br($content['info_text']); ?>
                </p>
              <?php endif; ?>
          <?php
            endforeach;
          endif;
          ?>

          <a href="<?php echo get_post_type_archive_link('info'); ?>" class="s-letter__btn btn-primary fadeUpTrigger">
            お知らせ一覧へ
            <i class="fa-solid fa-chevron-right"></i>
          </a>
      <?php
        endwhile;
      endif;
      ?>
    </div>
  </section>
  <!-- s-letter /ends here -->
</main>
<!-- main /ends here -->

<?php get_footer(); ?>