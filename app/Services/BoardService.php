<?php

namespace App\Services;

use App\Models\Board;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class BoardService
{
    public function find(User $user, array $data): array
    {
        if (! empty($data['board_id'])) {
            $board = $user->boards()->find($data['board_id']);

            return $board ? $board->toArray() : [];
        }

        return $user->boards()
            ->orderBy('position', 'asc')
            ->get()
            ->toArray();
    }

    public function create(array $data, User $user): Board
    {
        try {
            $board = Board::create([
                'title' => $data['name'],
                'position' => $data['position'],
                'user_id' => $user->id,
            ]);

            Log::info('Board created successfully', ['board_id' => $board->id, 'user_id' => $user->id]);

            return $board;
        } catch (Throwable $e) {
            Log::error('Failed to create board', [
                'user_id' => $user->id,
                'message' => $e->getMessage(),
            ]);
            throw new Exception('Could not create board. Please try again later.');
        }
    }

    public function move(array $data): void
    {
        $items = $data['data'] ?? [];
        if (empty($items)) {
            return;
        }

        $ids = collect($items)->pluck('board_id')->toArray();

        DB::transaction(function () use ($items, $ids) {
            $boards = Board::whereIn('id', $ids)->get()->keyBy('id');

            if ($boards->count() !== count($ids)) {
                Log::warning('Batch move failed: Some board IDs were not found', ['requested_ids' => $ids]);
                throw new Exception('One or more boards could not be found.');
            }

            foreach ($items as $index => $item) {
                $boards[$item['board_id']]->update(['position' => $index]);
            }
        });

        Log::info('Boards reordered successfully', ['count' => count($ids)]);
    }

    public function update(Board $board, array $data): bool
    {
        try {
            $updated = $board->update($data['data']);
            Log::info('Board updated', ['board_id' => $board->id]);

            return $updated;
        } catch (Throwable $e) {
            Log::error('Error updating board', ['board_id' => $board->id, 'error' => $e->getMessage()]);

            return false;
        }
    }

    public function delete(Board $board): ?bool
    {
        Log::info('Deleting board', ['board_id' => $board->id]);

        return $board->delete();
    }

    public function organize(array $data): void
    {
        $tasks = $data['tasks'] ?? [];
        if (empty($tasks)) {
            return;
        }

        try {
            DB::transaction(function () use ($tasks) {
                foreach ($tasks as $taskData) {
                    DB::table('tasks')
                        ->where('id', $taskData['id'])
                        ->update([
                            'board_id' => $taskData['board_id'] ?? $taskData['column_id'],
                            'position' => $taskData['position'],
                            'updated_at' => now(),
                        ]);
                }
            });
            Log::info('Tasks successfully reorganized', ['task_count' => count($tasks)]);
        } catch (Throwable $e) {
            Log::error('Failed to organize tasks', ['message' => $e->getMessage()]);
            throw new Exception('Synchronizing task positions failed.');
        }
    }
}
