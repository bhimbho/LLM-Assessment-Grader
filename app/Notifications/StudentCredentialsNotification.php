<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StudentCredentialsNotification extends Notification
{
    use Queueable;

    protected $password;
    protected $loginUrl;

    /**
     * Create a new notification instance.
     */
    public function __construct($password, $loginUrl)
    {
        $this->password = $password;
        $this->loginUrl = $loginUrl;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Student Portal Access Credentials')
            ->greeting('Hello ' . $notifiable->full_name . '!')
            ->line('Your student account has been created successfully.')
            ->line('Here are your login credentials:')
            ->line('**Student ID:** ' . $notifiable->student_id)
            ->line('**Password:** ' . $this->password)
            ->line('**Login URL:** ' . $this->loginUrl)
            ->line('Please keep these credentials safe and do not share them with anyone.')
            ->line('You can now log in to the student portal to view your assessments and grades.')
            ->action('Login to Student Portal', $this->loginUrl)
            ->line('If you have any questions, please contact your instructor.')
            ->salutation('Best regards,<br>LLM Assessment Grading System');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'student_id' => $notifiable->student_id,
            'password' => $this->password,
            'login_url' => $this->loginUrl,
        ];
    }
}