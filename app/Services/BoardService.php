<?php

namespace App\Services;

use App\Models\Board;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BoardService
{
    public function find(User $user, array $data): array
    {
        if (! empty($data['board_id'])) {
            $board = Board::where('user_id', $user->id)
                ->find($data['board_id']);

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
            return Board::create([
                'title' => $data['name'],
                'position' => $data['position'],
                'user_id' => $user->id,
            ]);
        } catch (Exception $e) {
            Log::error('Error on create board: '.$e->getMessage());
            throw $e;
        }
    }

    public function move(array $data): void
    {
        $items = $data['data'] ?? [];
        $ids = collect($items)->pluck('board_id')->toArray();

        DB::transaction(function () use ($items, $ids) {
            $boards = Board::whereIn('id', $ids)->get()->keyBy('id');

            if ($boards->count() !== count($ids)) {
                throw new Exception('Board not find!');
            }

            foreach ($items as $index => $item) {
                $boards[$item['board_id']]->update(['position' => $index]);
            }
        });
    }

    public function update(Board $board, array $data): bool
    {
        return $board->update($data['data']);
    }

    public function delete(Board $board): ?bool
    {
        return $board->delete();
    }
}
