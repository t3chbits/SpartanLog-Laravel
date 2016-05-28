var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
	mix.copy('bower_components/jquery/dist',
		'public/jquery')

	mix.copy('bower_components/bootstrap/dist', 
		'public/bootstrap');

	mix.copy('bower_components/select2/dist', 
		'public/select2');

	mix.copy('bower_components/Chart.js/dist', 
		'public/chartjs');

    mix.styles([
        'app.css'
    ]);
    
    mix.browserify('app.js', 'public/js/app.js');
    mix.browserify('exerciseCharts.js', 'public/js/exerciseCharts.js');
    mix.browserify('initSelect2.js', 'public/js/initSelect2.js');
});
