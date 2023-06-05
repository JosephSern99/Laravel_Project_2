<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

use DB;
use Log;
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
        DB::listen(function($query){
            if(!empty($query)){
                $sql = $query->sql;
                $para = $query->bindings;
                $time = $query->time;

                $message = (new \DateTime())->format('Y-m-d H:i:s.v') . ": Execute SQL: ". Str::replaceArray('?', $para, $sql);
                $message .= "; Execute Time: " . $time. "ms";

                Log::channel("querylog")->debug($message);
            }
        });
    }
}
