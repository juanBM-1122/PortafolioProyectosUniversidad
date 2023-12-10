const { defineConfig } = require('@vue/cli-service')

const plugins = [];

if (process.env.NODE_ENV === 'production') {
  const { join } = require('path');
  const PrerenderPlugin = require('prerender-spa-plugin-next');

  plugins.unshift(
    new PrerenderPlugin({
      staticDir: join(__dirname, 'dist'),
      routes: ['/profileform', '/vercard', '/crear_publicacion', '/modificar_publicacion', '/panel_publicacion', "/login", "/register", '/home', '/'], //the page route you want to prerender
    })
  );
}


module.exports = defineConfig({
  transpileDependencies: [
    'vue-meta',
  ],
  configureWebpack(config) {
    config.plugins = [...config.plugins, ...plugins];
  },
  devServer: {
    headers: {
      "Access-Control-Allow-Origin": "*",
      "Access-Control-Allow-Credentials": "true",
      "Access-Control-Allow-Methods": "GET,HEAD,OPTIONS,POST,PUT",
      "Access-Control-Allow-Headers": "Origin, X-Requested-With, Content-Type, Accept, Authorization"
    }
  },
})
