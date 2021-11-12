<?php

namespace App\Notifications;

use App\Models\Person;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class PersonCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(private Person $person, private string $channel = '#testrun')
    {
    }

    public function via(mixed $notifiable): array
    {
        return ['slack'];
    }

    public function toSlack($notifiable): SlackMessage
    {
        return (new SlackMessage())
            ->from('Family Tree')
            ->to($this->channel)
            ->content("Someone new has been added to the family tree. Their name is: {$this->person->fullName}");
    }
}
