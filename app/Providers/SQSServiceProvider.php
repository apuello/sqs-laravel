<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Jobs\ProcessMessage;

class SQSServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//       $this->app->bindMethod(ProcessMessage::class.'@handle', function ($job, $app) {
//   return $job->handle($app->make(AudioProcessor::class));
// });
// ProcessMessage::dispatch();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
      // ProcessMessage::dispatch();

    }
}
