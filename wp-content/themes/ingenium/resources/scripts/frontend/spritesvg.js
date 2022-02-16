/* eslint-disable */
const icons = require.context('@images/sprite-svg', true, /\.svg$/);

console.log('icons', icons);

// Automatically load all SVG files in the sprite-svg directory.
icons.keys().forEach(icons);
/* eslint-enable */
