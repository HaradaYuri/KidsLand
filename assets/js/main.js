import { initializeAnimation } from './components/animation.js';
import { initializeNavigation } from './components/navigation.js';
import { initializeSlider } from './components/slider.js';
import { initializeAccordion } from './components/accordion.js';
import { initializeCardLinks } from './components/card-links.js';

import { initializeForm } from './layout/form.js';
import { initializeHomePage } from './pages/home.js';
import { initializeIntroductionPage } from './pages/introduction.js';
import { initializeLetterPage } from './pages/letter.js';
import { initializeCommon } from './common.js';

jQuery(document).ready(function ($) {
  // Common
  initializeCommon($);
  initializeAnimation($);
  initializeNavigation($);
  initializeCardLinks($);

  // Pages
  if (document.body.classList.contains('home')) {
    initializeHomePage($);
  } else if (document.body.classList.contains('post-type-archive-letter')) {
    initializeLetterPage($);
  } else if (
    document.body.classList.contains('post-type-archive-introduction')
  ) {
    initializeIntroductionPage($);
  } else if (document.body.classList.contains('single-introduction')) {
    initializeSlider($);
  } else if (document.body.classList.contains('page-id-147')) {
    //recruit
    initializeAccordion($);
    initializeForm($);
  } else if (document.body.classList.contains('page-id-149')) {
    // recruit confirm
    initializeForm($);
  } else if (document.body.classList.contains('page-id-111')) {
    // contact
    initializeForm($);
  }
});
