<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Notification as AppNotification;

class AdminRegistrationNotification extends Notification
{
    use Queueable;
    protected $admin_notfy;
    
    public function __construct($admin_notfy)
    {
        $this->admin_notfy = $admin_notfy;
    }
    
    public function via($notifiable)
    {
        $notificationData = [
            'message_notify' => $this->admin_notfy['message'],
            'user_id' =>$notifiable->id,
            'sender' => $this->admin_notfy['sender'],
            'redirect_url' =>$this->admin_notfy['url'],
            'message_title' =>$this->admin_notfy['title'],
            'created_at' => now(),
            'updated_at' => now(),
            
        ];
       AppNotification::insert($notificationData);
    
    // Insert the notification data into the database
   // AppNotification::create($notificationData);
    
    //return ['database'];
        
       // return ['database'];
    }
    
    public function toArray($notifiable)
    {
        //dd($this->admin_notfy);
       $notificationData = [
            'message_notify' => $this->admin_notfy['message'],
            'user_id' => $this->admin_notfy['user_id'],
            'sender' => $this->admin_notfy['sender']
        ];
       AppNotification::insert($notificationData);
        return $notificationData;
    }
        /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
   
}
