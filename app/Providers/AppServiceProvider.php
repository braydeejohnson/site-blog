<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Blade::directive('icon', function($arguments){
	        list($path, $class) = array_pad(explode(',', trim($arguments, "() ")), 2, '');
	        $path = trim($path, "' ");
	        $class = trim($class, "' ");

	        // Create the dom document as per the other answers
	        $svg = new \DOMDocument();
	        $svg->load(public_path("svg/" . $path));
	        $svg->documentElement->setAttribute("class", $class);
	        $output = $svg->saveXML($svg->documentElement);

	        return $output;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
