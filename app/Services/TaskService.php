<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class TaskService
{
    public function delete(Task $task): bool
    {
        try {
            $deleted = $task->delete();
            Log::info('Task deleted successfully', ['task_id' => $task->id]);

            return $deleted;
        } catch (Throwable $e) {
            Log::error('Failed to delete task', [
                'task_id' => $task->id,
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function create(array $data, User $user): Task
    {
        return DB::transaction(function () use ($data, $user) {
            try {
                $nextPosition = Task::where('board_id', $data['board_id'])->count();

                $task = Task::create([
                    'title' => $data['title'],
                    'board_id' => $data['board_id'],
                    'user_id' => $user->id,
                    'position' => $nextPosition,
                    'priority' => 0, // Default priority
                    'description' => $data['description'] ?? null,
                ]);

                Log::info('Task created successfully', [
                    'task_id' => $task->id,
                    'board_id' => $data['board_id'],
                    'user_id' => $user->id,
                ]);

                return $task;
            } catch (Throwable $e) {
                Log::error('Task creation failed', [
                    'user_id' => $user->id,
                    'board_id' => $data['board_id'] ?? 'N/A',
                    'message' => $e->getMessage(),
                ]);

                throw new Exception('Unable to create task. Please verify your board information.');
            }
        });
    }
}
