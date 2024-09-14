<?php

namespace App\Listeners;

use App\Events\SendDealSubmissionNotification;
use App\Mail\DealNotificationToAdmin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SendDealSubmissionNotification $event)
    {

        \Mail::to($event->data->email)->send(
            new DealNotificationToAdmin($event->data)
        );
    }
}
