<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_should_return_all_tasks_when_index_is_called(): void {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertOk()->assertJsonCount(3, 'data');
    }

    #[Test]
    public function it_should_create_a_task_when_valid_data_is_submitted(): void {
        $payload = [
            'title' => 'Deploy the VPS',
            'description' => 'Set up Docker and Laravel on the new server',
        ];

        $response = $this->postJson('/api/tasks', $payload);

        $response->assertCreated()->assertJsonFragment(['title' => 'Deploy the VPS']);
        $this->assertDatabaseHas('tasks', ['title' => 'Deploy the VPS']);
    }

    #[Test]
    public function it_should_return_a_validation_error_when_title_is_missing(): void {
        $response = $this->postJson('/api/tasks', ['description' => 'No title here']);

        $response->assertUnprocessable()->assertJsonValidationErrors(['title']);
    }

    #[Test]
    public function it_should_create_a_task_with_priority_and_due_date_when_provided(): void {
        $payload = [
            'title' => 'Renew SSL certificate',
            'priority' => 'high',
            'due_date' => '2026-09-01',
        ];

        $response = $this->postJson('/api/tasks', $payload);

        $response->assertCreated()->assertJsonFragment(['priority' => 'high', 'due_date' => '2026-09-01']);
        $this->assertDatabaseHas('tasks', ['title' => 'Renew SSL certificate', 'priority' => 'high']);
    }

    #[Test]
    public function it_should_default_priority_to_medium_when_not_provided(): void {
        $response = $this->postJson('/api/tasks', ['title' => 'No priority given']);

        $response->assertCreated()->assertJsonFragment(['priority' => 'medium']);
    }

    #[Test]
    public function it_should_return_a_validation_error_when_priority_is_invalid(): void {
        $response = $this->postJson('/api/tasks', ['title' => 'Bad priority', 'priority' => 'urgent']);

        $response->assertUnprocessable()->assertJsonValidationErrors(['priority']);
    }

    #[Test]
    public function it_should_return_a_single_task_when_show_is_called_with_a_valid_id(): void {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertOk()->assertJsonFragment(['id' => $task->id]);
    }

    #[Test]
    public function it_should_return_404_when_show_is_called_with_an_unknown_id(): void {
        $response = $this->getJson('/api/tasks/99999');

        $response->assertNotFound();
    }

    #[Test]
    public function it_should_update_a_task_when_valid_data_is_submitted(): void {
        $task = Task::factory()->create(['title' => 'Old title']);

        $response = $this->putJson("/api/tasks/{$task->id}", ['title' => 'New title']);

        $response->assertOk()->assertJsonFragment(['title' => 'New title']);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'New title']);
    }

    #[Test]
    public function it_should_delete_a_task_when_destroy_is_called(): void {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertNoContent();
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
