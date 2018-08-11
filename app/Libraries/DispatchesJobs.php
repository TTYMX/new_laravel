<?php

namespace App\Libraries;

use Laravel\Lumen\Routing\DispatchesJobs as Base;

trait DispatchesJobs
{
    /**
     * Dispatch a job to its appropriate handler.
     *
     * @param  mixed  $job
     * @return mixed
     */
    protected function dispatch($job)
    {
        if ($job instanceof Rabbiter\Job) {
            return app('fpay.rabbiter')->dispatch($job);
        }

        return app('Illuminate\Contracts\Bus\Dispatcher')->dispatch($job);
    }
}
