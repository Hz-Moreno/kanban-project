<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBoardRequest;
use App\Http\Requests\FindBoardRequest;
use App\Http\Requests\MoveBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Models\Board;
use App\Services\BoardService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BoardController extends Controller
{
    public function __construct(
        private readonly BoardService $boardService
    ) {}

    public function find(FindBoardRequest $request): JsonResponse
    {
        $user = $request->user();
        $boards = $this->boardService->find($user, $request->validated());

        return response()->json([
            'status' => 'success',
            'data' => $boards,
        ]);
    }

    public function create(CreateBoardRequest $request): JsonResponse
    {
        $board = $this->boardService->create($request->validated(), $request->user());

        return response()->json([
            'status' => 'success',
            'data' => $board,
        ], Response::HTTP_CREATED);
    }

    public function move(MoveBoardRequest $request): JsonResponse
    {
        $this->boardService->move($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Boards reordered successfully',
        ]);
    }

    public function update(UpdateBoardRequest $request, Board $board): JsonResponse
    {
        $this->boardService->update($board, $request->validated());

        return response()->json([
            'status' => 'success',
            'data' => $board->fresh(),
        ]);
    }

    public function delete(Request $request, Board $board): JsonResponse
    {
        $this->boardService->delete($board);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
