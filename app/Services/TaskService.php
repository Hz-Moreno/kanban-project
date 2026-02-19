<?php

namespace App\services;

use App\Models\Task;
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

    public function delete(int $task_id): bool
    {
        try {
            $task = Task::find($task_id);

            return $task->delete();
        } catch (Exception $e) {
            Log::error('Error on delete task: '.$e->getMessage());

            return false;
        }
    }

    public function create(array $data): Task
    {
        try {
            $task = Task::create([
                'title' => $data['title'],
                'board_id' => $data['bodard_id'],
                'user_id' => $data['user_id'],
                'positon' => Task::where('board_id', $data['board_id'])->count(),
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
