import './assets/scss/style.scss';
import { initializeHomePage } from './assets/js/pages/home.js';

if (document.body.classList.contains('home')) {
  initializeHomePage();
} else if (document.body.classList.contains('about')) {
  // initializeAboutPage();
}
