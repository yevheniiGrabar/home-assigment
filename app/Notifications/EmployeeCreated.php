<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployeeCreated extends Notification implements ShouldQueue
{
    use Queueable;

    private $employee;

    /**
     * Create a new notification ins
     * tance.
     *
     * @param $employee
     */
    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to the Team!')
            ->greeting('Hello!')
            ->line('You have been successfully added as an employee.')
            ->line('Your login details:')
            ->line('Email: ' . $this->employee->email)
            ->line('Password: [Your Password Here]') // Можно отправить временный пароль
            ->action('Login', url('/login'))
            ->line('Thank you for joining us!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
