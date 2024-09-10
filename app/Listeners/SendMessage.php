<?php

namespace App\Listeners;

use App\Events\ContentMessage;
use App\Mail\ContactSendMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMessage
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ContentMessage $event): void
    {
        $content = $event->content;

        Mail::to( $content->email)->send(new ContactSendMessage($content));
    }
}
