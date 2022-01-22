// eslint-disable-next-line no-unused-vars
import $ from 'jquery';
import '@config';
import './vendor/*.js';
import '@styles/frontend';
import 'airbnb-browser-shims';
import './images';
import './spritesvg';

import App from './app';
import Example from './components/example';

// Your code goes here ...
$(document).on('ready', () => {
  const app = new App([
    new Example(),
  ]);

  app.bootstrap();
});
