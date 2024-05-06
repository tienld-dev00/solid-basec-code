<?php

namespace App\Jobs\Task;

use App\Mail\Task\RemindTaskDueEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Mail;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendRemindDueTaskEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job. Auto send mail to user for due task
     *
     * @return void
     */
    public function handle()
    {
        try {
            $currentDateTime = Carbon::now();
            $currentTime = $currentDateTime->format('H:i');

            $tasks = Task::whereDate('due_date', $currentDateTime)
                ->whereTime('due_date', $currentTime)
                ->where('is_completed', 0)
                ->get();

            if ($tasks->count() > 0) {
                foreach ($tasks as $task) {
                    Mail::to($task->user->email)->send(new RemindTaskDueEmail($task->user, $task));
                }
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }
}
