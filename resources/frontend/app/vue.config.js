const webpack = require('webpack')

module.exports = {
    devServer: {
        proxy: 'http://laravel.test'
    },

    outputDir: '../../../public/assets/app',

    publicPath: process.env.NODE_ENV === 'production'
        ? '/assets/app/'
        : '/',

    // modify the location of the generated HTML file.
    indexPath: process.env.NODE_ENV === 'production'
        ? '../../../resources/views/app.blade.php'
        : 'index.html',

    lintOnSave: false,

    productionSourceMap: false,
    configureWebpack: {
        module: {
            // Fix for flot resize
            rules: [{
                test: /jquery\.flot\.resize\.js$/,
                use: 'imports-loader?this=>window'
            }]
        },
        plugins: [
            new webpack.ProvidePlugin({
                $: 'jquery',
                jquery: 'jquery',
                'window.jQuery': 'jquery',
                jQuery: 'jquery'
            })
        ]
    },
    transpileDependencies: [
        'resize-detector' // vue-echarts
    ],
}
