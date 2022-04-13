<?php

namespace App\Observers;

use App\Models\Application;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class ApplicationObserver
{
    /**
     * Handle the Application "created" event.
     *
     * @param \App\Models\Application $application
     * @return void
     */
    public function created(Application $application)
    {
        //
    }

    /**
     * Handle the Application "updated" event.
     *
     * @param \App\Models\Application $application
     * @return void
     */
    public function updated(Application $application)
    {
        if($application->performer_leader_comment == null && $application->performer_status != null)
        {
            $application->performer_user_id = auth()->user()->id;
            $application->save();
        }
    }

    /**
     * Handle the Application "deleted" event.
     *
     * @param \App\Models\Application $application
     * @return void
     */
    public function deleted(Application $application)
    {
        //
    }

    /**
     * Handle the Application "restored" event.
     *
     * @param \App\Models\Application $application
     * @return void
     */
    public function restored(Application $application)
    {
        //
    }

    /**
     * Handle the Application "force deleted" event.
     *
     * @param \App\Models\Application $application
     * @return void
     */
    public function forceDeleted(Application $application)
    {
        //
    }
}