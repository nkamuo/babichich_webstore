const path = require('path');
const Encore = require('@symfony/webpack-encore');
const fs = require('fs');


// const fileList = fs.readdirSync('./');
// console.log('>>>>>>>>>>>>>>>>>>>>fileList start');
// fileList.forEach(file => {
//   console.log(file);
// });
// console.log('<<<<<<<<<<<<<<<<<<<fileList start');

const syliusBundles = path.resolve(__dirname, 'vendor/sylius/sylius/src/Sylius/Bundle/');
const uiBundleScripts = path.resolve(syliusBundles, 'UiBundle/Resources/private/js/');
const uiBundleResources = path.resolve(syliusBundles, 'UiBundle/Resources/private/');

// Shop config
Encore
  .setOutputPath('public/build/shop/')
  .setPublicPath('/build/shop')
  .addEntry('shop-entry', './vendor/sylius/sylius/src/Sylius/Bundle/ShopBundle/Resources/private/entry.js')
  .disableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableSassLoader();

const shopConfig = Encore.getWebpackConfig();

shopConfig.resolve.alias['sylius/ui'] = uiBundleScripts;
shopConfig.resolve.alias['sylius/ui-resources'] = uiBundleResources;
shopConfig.resolve.alias['sylius/bundle'] = syliusBundles;
shopConfig.name = 'shop';

Encore.reset();

// Admin config
Encore
  .setOutputPath('public/build/admin/')
  .setPublicPath('/build/admin')
  .addEntry('admin-entry', './vendor/sylius/sylius/src/Sylius/Bundle/AdminBundle/Resources/private/entry.js')
  .disableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableSassLoader();

const adminConfig = Encore.getWebpackConfig();

adminConfig.resolve.alias['sylius/ui'] = uiBundleScripts;
adminConfig.resolve.alias['sylius/ui-resources'] = uiBundleResources;
adminConfig.resolve.alias['sylius/bundle'] = syliusBundles;
adminConfig.externals = Object.assign({}, adminConfig.externals, { window: 'window', document: 'document' });
adminConfig.name = 'admin';


Encore.reset();

// App shop config
Encore
  .setOutputPath('public/build/app/shop')
  .setPublicPath('/build/app/shop')
  .addEntry('app-shop-entry', './assets/shop/entry.js')
  .disableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableSassLoader();

const appShopConfig = Encore.getWebpackConfig();

appShopConfig.resolve.alias['sylius/ui'] = uiBundleScripts;
appShopConfig.resolve.alias['sylius/ui-resources'] = uiBundleResources;
appShopConfig.resolve.alias['sylius/bundle'] = syliusBundles;
appShopConfig.externals = Object.assign({}, appShopConfig.externals, { window: 'window', document: 'document' });
appShopConfig.name = 'app.shop';

Encore.reset();

// App admin config
Encore
  .setOutputPath('public/build/app/admin')
  .setPublicPath('/build/app/admin')
  .addEntry('app-admin-entry', './assets/admin/entry.js')
  .disableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableSassLoader();

const appAdminConfig = Encore.getWebpackConfig();

appAdminConfig.resolve.alias['sylius/ui'] = uiBundleScripts;
appAdminConfig.resolve.alias['sylius/ui-resources'] = uiBundleResources;
appAdminConfig.resolve.alias['sylius/bundle'] = syliusBundles;
appAdminConfig.externals = Object.assign({}, appAdminConfig.externals, { window: 'window', document: 'document' });
appAdminConfig.name = 'app.admin';


//

Encore.reset();
Encore
  .setOutputPath('public/bisum-theme')
  .setPublicPath('/bisum-theme')
  .addEntry('app', './themes/bisum-theme/assets/entry.js')
  .disableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableSassLoader()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction());

const bisumThemeConfig = Encore.getWebpackConfig();
bisumThemeConfig.name = 'Bisum Theme';



// >> WISHLIST

// webpack.config.js
const [bitbagWishlistShop, bitbagWishlistAdmin] = require('./vendor/bitbag/wishlist-plugin/webpack.config.js');
const [ bitbagElasticSearchShop ] = require('./vendor/bitbag/elasticsearch-plugin/webpack.config.js')

// << WISHLIST

module.exports = [shopConfig, adminConfig, appShopConfig, appAdminConfig, bisumThemeConfig,
  // >> WISHLIST
  bitbagWishlistShop, bitbagWishlistAdmin,
  // << WISHLIST
  // >> ELASTICSEARCH
  bitbagElasticSearchShop
  // << ELASTICSEARCH

];
