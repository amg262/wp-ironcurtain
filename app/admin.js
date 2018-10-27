/* global window, document */
if (! window._babelPolyfill) {
  require('@babel/polyfill');
}

import React from 'react';
import ReactDOM from 'react-dom';
import Admin from './containers/Admin.jsx';


console.log(window.bom_object);
document.addEventListener('DOMContentLoaded', function() {
  ReactDOM.render(<Admin wpObject={window.bom_object} />, document.getElementById('wp-bomsuite-admin'));
});
