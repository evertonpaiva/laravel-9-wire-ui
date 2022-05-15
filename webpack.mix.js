const mix = require('laravel-mix')
const tailwindcss = require('tailwindcss')

mix.js('resources/js/alpine.js', 'public/dist/alpine.js')
    .js('resources/js/app.js', 'public/dist/app.js')
    .sass('resources/scss/app.scss', 'public/dist/app.css')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('./tailwind.config.js')]
    })

if (mix.inProduction()) {
    mix.version()
}

mix.disableSuccessNotifications()
