<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCredentialsNotification extends Notification
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
        $roleTitle = ucfirst($notifiable->role);
        
        return (new MailMessage)
            ->subject('Welcome to Ahmadu Bello University Assessment System - ' . $roleTitle . ' Account')
            ->greeting('Hello ' . $notifiable->full_name . '!')
            ->line('Your ' . strtolower($roleTitle) . ' account has been successfully created in the Ahmadu Bello University Assessment System.')
            ->line('---')
            ->line('**Your Account Details:**')
            ->line('**Full Name:** ' . $notifiable->full_name)
            ->line('**First Name:** ' . $notifiable->firstname)
            ->line('**Last Name:** ' . $notifiable->lastname)
            ->line('**Other Name:** ' . ($notifiable->othername ?? 'N/A'))
            ->line('**Staff ID:** ' . $notifiable->staff_id)
            ->line('**Email:** ' . $notifiable->email)
            ->line('**Role:** ' . $roleTitle)
            ->line('---')
            ->line('**Login Credentials:**')
            ->line('**Email/Staff ID:** ' . $notifiable->email)
            ->line('**Password:** ' . $this->password)
            ->line('---')
            ->line('**Important Security Notes:**')
            ->line('• Please keep these credentials safe and confidential')
            ->line('• Do not share your password with anyone')
            ->line('• We strongly recommend changing your password after your first login')
            ->line('• Use a strong password with a combination of letters, numbers, and symbols')
            ->line('')
            ->line('You can now log in to the system to:')
            ->line('• Manage questions and assessments')
            ->line('• Grade student submissions')
            ->line('• View analytics and reports')
            ->line('• ' . ($notifiable->role === 'admin' ? 'Manage users and system settings' : 'Access your assigned tasks'))
            ->action('Login to Dashboard', $this->loginUrl)
            ->line('If you have any questions or need assistance, please contact the system administrator.')
            ->line('')
            ->line('Best regards,')
            ->line('Assessment Team')
            ->line('Ahmadu Bello University');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'staff_id' => $notifiable->staff_id,
            'role' => $notifiable->role,
            'login_url' => $this->loginUrl,
        ];
    }
}
