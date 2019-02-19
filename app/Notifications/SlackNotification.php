<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SlackNotification extends Notification
{

    use Queueable;

    protected $link;

    protected $site;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($site, $link)
    {
        $this->link = $link;
        $this->site = $site;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }


    public function toSlack($notifiable)
    {
        return ( new SlackMessage )
            ->error()
            ->attachment(function ($attach) {
                $attach->title('Link for ' . $this->site . ' is Broken')
                       ->content($this->link->link . ' | ' . $this->link->creator . ' | ' . $this->link->created_at
                       );
            });
    }
}
