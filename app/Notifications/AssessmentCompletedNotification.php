<?php

namespace App\Notifications;

use App\Models\Assessment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssessmentCompletedNotification extends Notification
{
    use Queueable;

    protected $assessment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Assessment $assessment)
    {
        $this->assessment = $assessment;
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
        $assessment = $this->assessment;
        $score = $assessment->score ?? 'N/A';
        $maxScore = $assessment->question->max_total ?? 'N/A';
        $courseCode = $assessment->question->course_code ?? 'N/A';
        $assessmentUrl = route('student.assessment.show', $assessment->id);
        
        // Determine grade status
        $scorePercentage = $maxScore > 0 ? ($score / $maxScore) * 100 : 0;
        $gradeStatus = $scorePercentage >= 70 ? 'Excellent' : ($scorePercentage >= 50 ? 'Good' : 'Needs Improvement');
        
        return (new MailMessage)
            ->subject('Assessment Graded - ' . $courseCode)
            ->greeting('Hello ' . $notifiable->full_name . '!')
            ->line('Your assessment has been successfully graded by our automated grading system.')
            ->line('---')
            ->line('**Assessment Details:**')
            ->line('**Course Code:** ' . $courseCode)
            ->line('**Assessment ID:** #' . substr($assessment->id, 0, 8))
            ->line('**Your Score:** ' . $score . ' / ' . $maxScore)
            ->line('**Performance:** ' . $gradeStatus)
            ->line('---')
            ->line('You can now view your detailed assessment results, including:')
            ->line('• Complete score breakdown')
            ->line('• AI analysis of your answer')
            ->line('• Areas for improvement')
            ->line('• Feedback and explanation')
            ->action('View Assessment Details', $assessmentUrl)
            ->line('Log in to your student portal to access your full assessment report.')
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
            'assessment_id' => $this->assessment->id,
            'score' => $this->assessment->score,
            'course_code' => $this->assessment->question->course_code ?? 'N/A',
        ];
    }
}
