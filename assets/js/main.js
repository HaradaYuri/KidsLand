import { initializeAnimation } from './components/animation.js';
import { initializeNavigation } from './components/navigation.js';
import { initializeSlider } from './components/slider.js';
import { initializeAccordion } from './components/accordion.js';
import { initializeCardLinks } from './components/card-links.js';

import { initializeForm } from './layout/form.js';
import { initializeHomePage } from './pages/home.js';
import { initializeCommon } from './common.js';

jQuery(document).ready(function ($) {
  // Common
  initializeCommon($);
  initializeAnimation($);
  initializeNavigation($);
  initializeNavigation($);
  initializeCardLinks($);

  // Pages
  if (document.body.classList.contains('home')) {
    initializeHomePage($);
  } else if (document.body.classList.contains('single-introduction')) {
    initializeSlider($);
  } else if (document.body.classList.contains('page-id-147')) {
    //page-recruit
    initializeAccordion($);
    initializeForm($);
  }
});
