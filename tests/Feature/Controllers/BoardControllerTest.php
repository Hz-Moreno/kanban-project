<?php

namespace Tests\Feature\Controllers;

use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BoardControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function unauthenticated_users_cannot_access_board_routes(): void
    {
        $this->getJson('/board')->assertStatus(Response::HTTP_UNAUTHORIZED);
        $this->postJson('/board', ['name' => 'Fail', 'position' => 0])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_can_list_boards_for_authenticated_user(): void
    {
        Board::factory()->count(2)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
            ->getJson('/board');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure(['status', 'data']);
    }

    /** @test */
    public function it_can_create_a_board(): void
    {
        $data = [
            'name' => 'Project Alpha',
            'position' => 1,
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/board', $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonPath('data.title', 'Project Alpha');

        $this->assertDatabaseHas('boards', ['title' => 'Project Alpha', 'user_id' => $this->user->id]);
    }

    /** @test */
    public function it_can_update_a_board(): void
    {
        $board = Board::factory()->create(['user_id' => $this->user->id, 'title' => 'Old Title']);

        $updateData = [
            'board_id' => $board->id,
            'data' => ['title' => 'New Title'],
        ];

        $response = $this->actingAs($this->user)
            ->putJson("/board/{$board->id}", $updateData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonPath('data.title', 'New Title');
    }

    /** @test */
    public function it_can_delete_a_board(): void
    {
        $board = Board::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
            ->deleteJson("/board/{$board->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('boards', ['id' => $board->id]);
    }

    /** @test */
    public function it_can_reorder_boards_via_move_route(): void
    {
        $board1 = Board::factory()->create(['position' => 0]);
        $board2 = Board::factory()->create(['position' => 1]);

        $payload = [
            'data' => [
                ['board_id' => $board2->id],
                ['board_id' => $board1->id],
            ],
        ];

        $response = $this->actingAs($this->user)
            ->putJson('/board/move', $payload);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals(0, $board2->fresh()->position);
        $this->assertEquals(1, $board1->fresh()->position);
    }

    /** @test */
    public function it_can_organize_tasks_on_board(): void
    {
        $board = Board::factory()->create();
        $task = Task::factory()->create(['board_id' => $board->id]);
        $newBoard = Board::factory()->create();

        $payload = [
            'tasks' => [
                [
                    'id' => $task->id,
                    'board_id' => $newBoard->id,
                    'position' => 10,
                ],
            ],
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/boards/organize', $payload);

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'board_id' => $newBoard->id,
            'position' => 10,
        ]);
    }
}
