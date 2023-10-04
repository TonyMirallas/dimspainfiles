let mix = require('laravel-mix');

class Example {
    webpackRules() {
        return [
            {
               test: /\.m?js/,
               resolve: {
                  fullySpecified: false,
               },
            },
        ]
    }
}

mix.extend('webpackconfig', new Example());