<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>桜のこもれびキッズランド｜日本全国の認証・認可保育園</title>
  <meta name="description" content="桜のこもれびキッズランドは関東、関西など日本全国各地で保育園を運営しています。子供たちが楽しく学び、成長するための保育環境を提供しています。さまざまな情報やイベント情報をお届けします。">

  <!-- favicon -->
  <link rel="shortcut icon" href="https://web.harapaca-craft.com/wordpress/wp-content/themes/KidsLandWP/assets/images/favicon.ico">
  <link rel="icon" href="https://web.harapaca-craft.com/wordpress/wp-content/themes/KidsLandWP/assets/images/favicon.ico">
  <link rel="icon" type="image/vnd.microsoft.icon" href="https://web.harapaca-craft.com/wordpress/wp-content/themes/KidsLandWP/assets/images/favicon.ico">
  <link rel="apple-touch-icon" href="https://web.harapaca-craft.com/wordpress/wp-content/themes/KidsLandWP/assets/images/apple-touch-icon.png" sizes="180x180">

  <!-- OGP設定(title, descriptionはfunctions.php) -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://web.harapaca-craft.com" />
  <meta property="og:image" content="https://web.harapaca-craft.com/wordpress/wp-content/themes/KidsLandWP/assets/images/ogp-img.jpg" />
  <meta property="og:image:type" content="image/jpeg" />
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">


  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <!-- top back btn -->
  <a href="#" class="btn-topback">
    <i class="fa-solid fa-chevron-up"></i>
  </a>

  <header class="header">
    <!-- header for PC -->
    <nav class="header__nav">
      <ul class="header__list">
        <li class="header__item">
          <span class="header__circle"></span>
          <span class="header__circle"></span>
          <a href="<?php echo esc_url(home_url('/about')); ?>" class="header__link">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-cherry-blossom.svg" alt="わたしたちのこと" class="header__icon">
            <span class="header__text">わたしたちのこと</span>
            <span class="header__text-en txts-en">About</span>
          </a>
        </li>
        <li class="header__item">
          <span class="header__circle"></span>
          <span class="header__circle"></span>
          <a href="<?php echo esc_url(home_url('/introduction')); ?>"
            class="header__link">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-tree.svg" alt="各園のご紹介" class="header__icon">
            <span class="header__text">各園のご紹介</span>
            <span class="header__text-en txts-en">Introduction</span>
          </a>
        </li>
        <li class="header__item">
          <span class="header__circle"></span>
          <span class="header__circle"></span>
          <a href="<?php echo esc_url(home_url('/letter')); ?>" class="header__link">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-letter.svg" alt="こもれびだより" class="header__icon">
            <span class="header__text">こもれびだより</span>
            <span class="header__text-en txts-en">Letter</span>
          </a>
        </li>
        <li class="header__item header__item--logo">
          <span class="header__circle"></span>
          <span class="header__circle"></span>
          <a href="<?php echo esc_url(home_url('/')); ?>" class="header__link header__link--logo">
            <h1>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.webp" alt="桜のこもれびキッズランド" class="header__logo">
            </h1>
          </a>
        </li>
        <li class="header__item">
          <span class="header__circle"></span>
          <span class="header__circle"></span>
          <a href="<?php echo esc_url(home_url('/info')); ?>" class="header__link">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-bell-ribbon.svg" alt="お知らせ" class="header__icon">
            <span class="header__text">お知らせ</span>
            <span class="header__text-en txts-en">Info</span>
          </a>
        </li>
        <li class="header__item">
          <span class="header__circle"></span>
          <span class="header__circle"></span>
          <a href="<?php echo esc_url(home_url('/recruit')); ?>" class="header__link">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-pen.svg" alt="採用情報" class="header__icon">
            <span class="header__text">採用情報</span>
            <span class="header__text-en txts-en">Recruit</span>
          </a>
        </li>
        <li class="header__item">
          <span class="header__circle"></span>
          <span class="header__circle"></span>
          <span class="header__circle--right"></span>
          <span class="header__circle--right"></span>
          <a href="<?php echo esc_url(home_url('/contact')); ?>" class="header__link">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-mail.svg" alt="お問い合わせ" class="header__icon">
            <span class="header__text">お問い合わせ</span>
            <span class="header__text-en txts-en">Contact</span>
          </a>
        </li>
      </ul>
    </nav>
    <!-- header for SP -->
    <h1>
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.webp" alt="桜のこもれびキッズランド" class="header__logo-sp">
    </h1>
    <button class="btn-menu">
      <div class="btn-menu__icon flex-col">
        <span class="btn-menu__line"></span>
        <span class="btn-menu__line"></span>
        <span class="btn-menu__line"></span>
        <span class="btn-menu__text txts-en"> menu </span>
        <span class="btn-menu__text btn-menu__text--closed txts-en">closed</span>
      </div>
    </button>
  </header>