let mix = require("laravel-mix");
let path = require("path");
let postCss = require("@tailwindcss/postcss");

mix.setResourceRoot("../");
mix.setPublicPath(path.resolve("./"));

mix.webpackConfig({
  watchOptions: {
    ignored: [
      path.posix.resolve(__dirname, "./node_modules"),
      path.posix.resolve(__dirname, "./css"),
      path.posix.resolve(__dirname, "./js"),
    ],
  },
});

mix.js("resources/js/app.js", "assets/js");
mix.postCss("resources/css/app.css", "assets/css", postCss);
mix.postCss("resources/css/editor-style.css", "assets/css", postCss);

mix.browserSync({
  proxy: "http://unityclaims-wp.local",
  host: "localhost",
  open: "local",
  port: 3000,
  files: ["**/*"],
  injectChanges: false,
});

// mix.browserSync({
//     proxy: 'http://tailpress.test',
//     host: 'tailpress.test',
//     open: 'external',
//     port: 8000,
//     files: ["*.php", "**/*.php"]
// });

if (mix.inProduction()) {
  mix.version();
} else {
  mix.options({ manifest: false });
}
