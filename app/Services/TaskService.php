<?php

namespace App\services;

use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class TaskService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function delete(Task $task): bool
    {
        try {
            return $task->delete();
        } catch (Exception $e) {
            Log::error('Error on delete task: '.$e->getMessage());

            return false;
        }
    }

    public function create(array $data, User $user): Task
    {
        try {
            $task = Task::create([
                'title' => $data['title'],
                'board_id' => $data['board_id'],
                'user_id' => $user->id,
                'position' => Task::where('board_id', $data['board_id'])->count() ?? 0,
                'priority' => 0,
                'description' => $data['description'],
            ]);

            return $task;
        } catch (Exception $e) {
            Log::error('Fail on create taks: '.$e->getMessage());
            throw $e;
        }
    }

    public function move(int $task_id, int $new_board_id): Task
    {
        try {
            $task = Task::find($task_id);
            $old_board = $task->board_id;

            $task->update(['board_id' => $new_board_id]);

            return $task;
        } catch (Exception $e) {
            Log::error('Errot to move task: '.$e->getMessage());
            throw $e;
        }
    }
}
