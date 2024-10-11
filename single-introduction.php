<?php get_header(); ?>

<main>
  <div class="page-fv"></div>
  <!-- page-heading starts here -->
  <section class="page-heading">
    <div class="page-heading__container fadeUpTrigger">
      <div class="page-heading__text">
        <h2 class="page-heading__text-jp">桜のこもれびキッズランド</h2>
        <h3 class="page-heading__text-jp-sub">
          <?php
          $terms = get_the_terms(get_the_ID(), 'nursery_type');
          if ($terms && !is_wp_error($terms)) {
            $nursery_type = $terms[0]->name;
          } else {
            $nursery_type = '';
          }
          ?>
          <span><?php echo esc_html($nursery_type); ?></span>

          <span><?php echo esc_html(CFS()->get('nursery_name')); ?></span>
        </h3>
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

  <!-- introduction-content starts here -->
  <section class="introduction-content">
    <?php if ($thumbnail = CFS()->get('thumbnail')) : ?>
      <img loading="lazy" src="<?php echo esc_url($thumbnail); ?>" alt="保育所の立地" class="fadeUpTrigger">
    <?php endif; ?>
    <h4 class="introduction-content__heading fadeUpTrigger">
      <?php echo nl2br(esc_html(CFS()->get('introduction_heading'))); ?>
    </h4>
    <p class="introduction-content__text txtm fadeUpTrigger">
      <?php echo nl2br(esc_html(CFS()->get('introduction_text'))); ?>
    </p>
  </section>
  <!-- introduction-content /ends here -->

  <!-- inside starts here -->
  <section class="inside bg-pink-dash">
    <div class="inside__title title-primary">
      <div class="title-primary__icon fadeUpTrigger">
        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-camera.svg" alt="園の様子">
      </div>
      <h2 class="fadeUpTrigger">園の様子</h2>
      <p class="fadeUpTrigger">inside</p>
    </div>

    <!-- slider -->
    <div class="slider fadeUpTrigger">
      <?php for ($i = 1; $i <= 6; $i++) : ?>
        <?php if ($slider_image = CFS()->get('slider_image_' . $i)) : ?>
          <div class="slider__item">
            <img loading="lazy" src="<?php echo esc_url($slider_image); ?>" alt="園の様子 <?php echo $i; ?>">
          </div>
        <?php endif; ?>
      <?php endfor; ?>
    </div>
  </section>
  <!-- inside /ends here -->

  <!-- message starts here -->
  <section class="message">
    <div class="message__title title-primary">
      <div class="title-primary__icon fadeUpTrigger">
        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-message.svg" alt="園長からのメッセージ">
      </div>
      <h2 class="fadeUpTrigger">園長からのメッセージ</h2>
      <p class="fadeUpTrigger">message</p>
    </div>

    <div class="message__container flex-rc">
      <?php if ($president_image = CFS()->get('president_image')) : ?>
        <img loading="lazy" src="<?php echo esc_url($president_image); ?>" alt="笑顔の保育園の先生" class="message__img fadeUpTrigger">
      <?php endif; ?>
      <p class="message__text fadeUpTrigger">
        <?php echo nl2br(esc_html(CFS()->get('president_message'))); ?>
      </p>
    </div>
  </section>
  <!-- message /ends here -->

  <!-- about-nursery starts here -->
  <section class="about-nursery">
    <div class="about-nursery__title title-primary">
      <div class="title-primary__icon fadeUpTrigger">
        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-bell.svg" alt="園の概要">
      </div>
      <h2 class="fadeUpTrigger">園の概要</h2>
      <p class="fadeUpTrigger">about nursery</p>
    </div>

    <!-- nursery -->
    <div class="nursery__container">
      <table class="fadeUpTrigger">
        <tbody>
          <tr class="tr-sp-flex">
            <th>所在地</th>
            <td><?php echo esc_html(CFS()->get('adress')); ?></td>
          </tr>
          <tr class="tr-sp-flex">
            <th>TEL / FAX</th>
            <td class="sp-16"><?php echo esc_html(CFS()->get('tel')); ?> / <?php echo esc_html(CFS()->get('fax')); ?></td>
          </tr>
          <tr class="tr-sp-flex">
            <th>対象</th>
            <td><?php echo nl2br(esc_html(CFS()->get('target'))); ?></td>
          </tr>
          <tr class="tr-sp-flex">
            <th>入園日</th>
            <td class="wide"><?php echo nl2br(esc_html(CFS()->get('entrance_date'))); ?></td>
          </tr>
          <tr class="tr-sp-flex">
            <th>開園日</th>
            <td class="small sp-16">
              <div class="days flex-row">
                <?php
                $days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                $day_names = ['月', '火', '水', '木', '金', '土', '日'];
                foreach ($days as $index => $day) :
                ?>
                  <div>
                    <?php echo $day_names[$index]; ?><br>
                    <?php echo CFS()->get('opening_date_' . $day) ? '〇' : 'ー'; ?>
                  </div>
                <?php endforeach; ?>
              </div>
              <p class="days__desc">
                月曜日～土曜日〔日曜日、祝日・休日、年末年始（12/29～1/3）はお休み〕
              </p>
            </td>
          </tr>
          <tr class="tr-sp-flex">
            <th>保育時間</th>
            <td>
              <p>保育標準時間認定の方</p>
              <table class="inner-table nursery-time">
                <tbody>
                  <tr>
                    <th>保育標準時間</th>
                    <td><?php echo esc_html(CFS()->get('standard_regular')); ?></td>
                  </tr>
                  <tr>
                    <th>延長保育</th>
                    <td><?php echo esc_html(CFS()->get('standard_extended')); ?></td>
                  </tr>
                </tbody>
              </table>
              <p>保育短時間認定の方</p>
              <table class="inner-table nursery-time">
                <tbody>
                  <tr>
                    <th>保育標準時間</th>
                    <td><?php echo esc_html(CFS()->get('short_regular')); ?></td>
                  </tr>
                  <tr>
                    <th>延長保育</th>
                    <td><?php echo nl2br(esc_html(CFS()->get('short_extended'))); ?></td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
          <tr class="tr-sp-flex">
            <th>定員</th>
            <td class="td-limit txts">
              <table class="inner-table limit">
                <tbody>
                  <tr>
                    <th class="th-heading txts">定員<br><?php echo esc_html(CFS()->get('student_capacity')); ?></th>
                    <td>
                      <table class="limit__group limit__group--student">
                        <tbody>
                          <tr>
                            <th>1歳児</th>
                            <th>2歳児</th>
                            <th>3歳児</th>
                            <th>4歳児</th>
                            <th>5歳児</th>
                          </tr>
                          <tr>
                            <td><?php echo esc_html(CFS()->get('student_capacity1')); ?></td>
                            <td><?php echo esc_html(CFS()->get('student_capacity2')); ?></td>
                            <td><?php echo esc_html(CFS()->get('student_capacity3')); ?></td>
                            <td><?php echo esc_html(CFS()->get('student_capacity4')); ?></td>
                            <td><?php echo esc_html(CFS()->get('student_capacity5')); ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
              <?php echo nl2br(esc_html(CFS()->get('student_capacity_comment'))); ?>
            </td>
          </tr>
          <tr class="tr-sp-flex">
            <th>職員</th>
            <td class="td-limit txts">
              <table class="inner-table limit">
                <tbody>
                  <tr>
                    <th class="th-heading txts">定員<br><?php echo esc_html(CFS()->get('teacher_capacity')); ?></th>
                    <td>
                      <table class="limit__group limit__group--teacher">
                        <tbody>
                          <tr>
                            <th>園長</th>
                            <th>保育士</th>
                            <th>調理師</th>
                            <th>看護師</th>
                            <th>事務員</th>
                          </tr>
                          <tr>
                            <td><?php echo esc_html(CFS()->get('teacher_capacity_president')); ?></td>
                            <td><?php echo esc_html(CFS()->get('teacher_capacity_teacher')); ?></td>
                            <td><?php echo esc_html(CFS()->get('teacher_capacity_cook')); ?></td>
                            <td><?php echo esc_html(CFS()->get('teacher_capacity_nurse')); ?></td>
                            <td><?php echo esc_html(CFS()->get('teacher_capacity_cleark')); ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
              <?php echo nl2br(esc_html(CFS()->get('teacher_capacity_comment'))); ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
  <!-- about-nursery /ends here -->

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
        'posts_per_page' => 3,
        'meta_key' => 'letter_date',
        'orderby' => 'meta_value',
        'order' => 'DESC',
      );
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
              <img loading="lazy" src="<?php echo $img_src; ?>" alt="<?php echo $img_alt; ?>">
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

    <a href="<?php echo get_post_type_archive_link('letter'); ?>" class="letter__btn btn-primary fadeUpTrigger">
      もっと見る
      <i class="fa-solid fa-chevron-right"></i>
    </a>
  </section>
  <!-- letter /ends here -->

  <!-- contact starts here -->
  <section class="contact flex-col">
    <div class="contact__container fadeUpTrigger">
      <div class="contact__title title-primary">
        <div class="title-primary__icon fadeUpTrigger">
          <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-mail.svg" alt="お問い合わせ">
        </div>
        <h2 class="fadeUpTrigger">お問い合わせ</h2>
        <p class="fadeUpTrigger">contact</p>
      </div>

      <p class="contact__text txtm fadeUpTrigger">
        入園のお申込み、<br class="sp">見学のご相談はこちらから！
      </p>

      <a href="<?php echo home_url('/contact'); ?>" class="contact__btn btn-primary fadeUpTrigger">
        お問い合わせ
        <i class="fa-solid fa-chevron-right"></i>
      </a>
    </div>
  </section>
  <!-- contact /ends here -->
</main>
<!-- main /ends here -->

<?php get_footer(); ?>