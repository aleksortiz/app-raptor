<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('qty', function ($amount) {
            return "<?php echo number_format($amount); ?>";
        });

        Blade::directive('float', function ($amount) {
            return "<?php echo number_format($amount, 2); ?>";
        });

        Blade::directive('money', function ($amount) {
            return "<?php echo '$' . number_format($amount, 2); ?>";
        });

        Blade::directive('paddy', function ($number) {
            return "<?php echo str_pad($number, 4, '0', STR_PAD_LEFT); ?>";
        });

        Blade::directive('jsonEncode', function ($value) {
            return "<?php echo json_encode($value); ?>";
        });
    }
}
