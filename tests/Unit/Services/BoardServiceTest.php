<?php

namespace Tests\Feature\Services;

use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use App\Services\BoardService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TypeError;

class BoardServiceTest extends TestCase
{
    use RefreshDatabase;

    private BoardService $service;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new BoardService;
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_denies_access_to_find_if_no_user_is_provided(): void
    {
        $this->expectException(TypeError::class);
        // @phpstan-ignore-next-line
        $this->service->find(null, []);
    }

    /** @test */
    public function it_denies_access_to_create_if_no_user_is_provided(): void
    {
        $this->expectException(TypeError::class);
        // @phpstan-ignore-next-line
        $this->service->create(['name' => 'Test', 'position' => 0], null);
    }

    /** @test */
    public function it_can_list_all_boards_for_a_user(): void
    {
        Board::factory()->count(3)->create(['user_id' => $this->user->id]);

        $results = $this->service->find($this->user, []);

        $this->assertIsArray($results);
        $this->assertCount(3, $results);
    }

    /** @test */
    public function it_can_find_a_specific_board_by_id(): void
    {
        $board = Board::factory()->create(['user_id' => $this->user->id]);

        $result = $this->service->find($this->user, ['board_id' => $board->id]);

        $this->assertIsArray($result);
        $this->assertEquals($board->id, $result['id']);
    }

    /** @test */
    public function it_returns_a_board_instance_on_creation(): void
    {
        $data = ['name' => 'New Board', 'position' => 1];
        $board = $this->service->create($data, $this->user);

        $this->assertInstanceOf(Board::class, $board);
        $this->assertDatabaseHas('boards', ['title' => 'New Board', 'user_id' => $this->user->id]);
    }

    /** @test */
    public function it_can_update_a_board_and_returns_true(): void
    {
        $board = Board::factory()->create(['user_id' => $this->user->id]);
        $data = ['data' => ['title' => 'Updated Title']];

        $result = $this->service->update($board, $data);

        $this->assertTrue($result);
        $this->assertDatabaseHas('boards', ['id' => $board->id, 'title' => 'Updated Title']);
    }

    /** @test */
    public function it_can_delete_a_board(): void
    {
        $board = Board::factory()->create(['user_id' => $this->user->id]);

        $result = $this->service->delete($board);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('boards', ['id' => $board->id]);
    }

    /** @test */
    public function it_can_reorder_multiple_boards_position(): void
    {
        $board1 = Board::factory()->create(['position' => 0]);
        $board2 = Board::factory()->create(['position' => 1]);

        $data = [
            'data' => [
                ['board_id' => $board2->id],
                ['board_id' => $board1->id],
            ],
        ];

        $this->service->move($data);

        $this->assertEquals(0, $board2->fresh()->position);
        $this->assertEquals(1, $board1->fresh()->position);
    }

    /** @test */
    public function it_throws_exception_if_moving_non_existent_boards(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('One or more boards could not be found.');
        $fakeID = (string) \Illuminate\Support\Str::uuid();

        $this->service->move([
            'data' => [
                ['board_id' => $fakeID],
            ],
        ]);
    }

    /** @test */
    public function it_can_organize_tasks_between_boards(): void
    {
        $board = Board::factory()->create();
        $task = Task::factory()->create(['board_id' => $board->id, 'position' => 0]);

        $newBoard = Board::factory()->create();

        $data = [
            'tasks' => [
                [
                    'id' => $task->id,
                    'board_id' => $newBoard->id,
                    'position' => 5,
                ],
            ],
        ];

        $this->service->organize($data);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'board_id' => $newBoard->id,
            'position' => 5,
        ]);
    }
}
