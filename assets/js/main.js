import { initializeHomePage } from './pages/home.js';
import { initializeAnimation } from './components/animation.js';
import { initializeNavigation } from './components/navigation.js';
import { initializeSlider } from './components/slider.js';
import { initializeCommon } from './common.js';
import { initializeAccordion } from './components/accordion.js';
import { initializeForm } from './layout/form.js';

jQuery(document).ready(function ($) {
  // Common
  initializeCommon($);
  initializeAnimation($);
  initializeNavigation($);

  // Pages
  if (document.body.classList.contains('home')) {
    initializeHomePage($);
  } else if (document.body.classList.contains('single-introduction')) {
    initializeSlider($);
  } else if (document.body.classList.contains('p-recruit')) {
    initializeAccordion($);
    initializeForm($);
  }
});
