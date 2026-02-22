<?php

namespace Tests\Feature\Controllers;

use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Board $board;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->board = Board::factory()->create(['user_id' => $this->user->id]);
    }

    /** @test */
    public function it_can_create_a_task_for_authenticated_user(): void
    {
        $data = [
            'title' => 'New Task',
            'board_id' => $this->board->id,
            'description' => 'Testing controller create',
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/task', $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonPath('data.title', 'New Task');

        $this->assertDatabaseHas('tasks', [
            'title' => 'New Task',
            'user_id' => $this->user->id,
        ]);
    }

    /** @test */
    public function it_can_delete_a_task(): void
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
            ->deleteJson("/task/{$task->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function it_returns_422_when_task_data_is_invalid(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson('/task', []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['title', 'board_id']);
    }
}
