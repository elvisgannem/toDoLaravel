<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_todolist_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');
        $response->assertOk();
    }

    public function test_if_task_can_be_created(): void
    {
        $user = User::factory()->create();

        $taskName = Str::random();
        $response = $this->actingAs($user)->post('/tasks/create', ['taskName' => $taskName]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertDatabaseHas('tasks', [
            'name' => $taskName,
        ]);
    }

    public function test_if_task_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->delete("/tasks/{$task->id}");

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    public function test_if_task_can_be_updated(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $taskName = Str::random();
        $taskDescription = Str::random();

        $response = $this->actingAs($user)->put('/tasks/update', [
            'id' => $task->id,
            'taskName' => $taskName,
            'taskDescription' => $taskDescription,
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $task->refresh();

        $this->assertEquals($taskName, $task->name);
        $this->assertEquals($taskDescription, $task->description);
    }

    public function test_if_task_status_can_be_updated()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['finished' => 0]);

        $response = $this->actingAs($user)->put('/tasks/update', [
            'id' => $task->id,
            'finished' => 1,
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $task->refresh();

        $this->assertEquals('1', $task->finished);
    }

    public function test_update_route_without_data_should_return_error()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->put('/tasks/update', [
            'id' => $task->id,
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_user_removal_to_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        TaskUser::factory()->create([
            'task_id' => $task->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->delete("/tasks/{$task->id}/{$user->id}");

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('task_user', [
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);
    }

    public function test_user_assignment_to_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->post('/tasks/add-user', [
            'task_id' => $task->id,
            'user_id' => $user->id,
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('task_user', [
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);
    }
}
