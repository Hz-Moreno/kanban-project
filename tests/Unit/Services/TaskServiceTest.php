<?php

namespace Tests\Feature\Services;

use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    private TaskService $service;

    private User $user;

    private Board $board;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new TaskService;
        $this->user = User::factory()->create();
        $this->board = Board::factory()->create([
            'user_id' => $this->user->id,
        ]);
    }

    /** @test */
    public function it_returns_a_task_instance_on_successful_creation(): void
    {
        $data = [
            'title' => 'Service Task',
            'board_id' => $this->board->id,
            'description' => 'Description test',
        ];

        $task = $this->service->create($data, $this->user);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals('Service Task', $task->title);
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function it_returns_true_when_task_is_deleted_successfully(): void
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'board_id' => $this->board->id,
        ]);

        $result = $this->service->delete($task);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function it_throws_a_type_error_if_user_is_missing_in_create(): void
    {
        $this->expectException(\TypeError::class);

        $data = ['title' => 'No User Task', 'board_id' => $this->board->id];

        $this->service->create($data, null);
    }

    /** @test */
    public function it_throws_custom_exception_when_data_is_invalid(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unable to create task. Please verify your board information.');

        $data = [
            'title' => 'Invalid Board',
            'board_id' => 999,
        ];

        $this->service->create($data, $this->user);
    }
}
