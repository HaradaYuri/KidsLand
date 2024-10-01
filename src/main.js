import './assets/scss/style.scss';
import { initializeHomePage } from './assets/js/pages/home.js';
import { initializeAnimation } from './assets/js/components/animation.js';
import { initializeNavigation } from './assets/js/components/navigation.js';
import { initializeSlider } from './assets/js/components/slider.js';
import { initializeCommon } from './assets/js/common.js';
import { initializeAccordion } from './assets/js/components/accordion.js';

$(document).ready(function () {
  // Common
  initializeCommon($);
  initializeAnimation($);
  initializeNavigation($);

  // Pages
  if (document.body.classList.contains('home')) {
    initializeHomePage($);
  } else if (document.body.classList.contains('single-introduction')) {
    initializeSlider($);
  } else if (document.body.classList.contains('recruit')) {
    initializeAccordion($);
  }
});
