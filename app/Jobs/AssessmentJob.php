<?php

namespace App\Jobs;

use App\Models\Assessment;
use App\Service\ChatGptService;
use App\Service\GeminiService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AssessmentJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private Assessment $assessment, private string $llmModel)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $llmService = match ($this->llmModel) {
            'gemini-pro' => new GeminiService(),
            'gpt-4o', 'openai', 'chatgpt' => new ChatGptService(),
            default => new GeminiService(),
        };
        
        $llmService->generateResponse($this->assessment);
    }
}
