<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_tasks(): void
    {
        Task::factory()->count(100)->create();

        $page = 1;
        $limit = 15;
        $response = $this->getJson("/api/tasks?page={$page}&limit={$limit}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(15);
    }

    /** @test */
    public function it_can_list_tasks_for_a_specific_project(): void
    {
        $project = Project::factory()->create();
        Task::factory()->count(3)->create(['project_id' => $project->id]);
        Task::factory()->count(2)->create();

        $response = $this->getJson("/api/projects/{$project->id}/tasks");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(3);
    }

    /** @test */
    public function it_can_create_a_task_for_a_project(): void
    {
        $project = Project::factory()->create();
        $data = [
            'title'       => 'New Task',
            'description' => 'Task description',
            'assigned_to' => 'John Doe',
            'due_date'    => '2025-12-31',
            'status'      => 'to_do',
        ];

        $response = $this->postJson("/api/projects/{$project->id}/tasks", $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonPath('title', 'New Task')
            ->assertJsonPath('description', 'Task description')
            ->assertJsonPath('status', 'to_do');

        $this->assertDatabaseHas('tasks', [
            'title'      => 'New Task',
            'project_id' => $project->id,
        ]);
    }

    /** @test */
    public function it_requires_a_title_when_creating_a_task(): void
    {
        $project = Project::factory()->create();
        $data = [
            'description' => 'Task description',
            'assigned_to' => 'John Doe',
        ];

        $response = $this->postJson("/api/projects/{$project->id}/tasks", $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['title']);
    }

    /** @test */
    public function it_can_show_a_single_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonPath('id', $task->id);
    }

    /** @test */
    public function it_returns_404_if_task_not_found(): void
    {
        $response = $this->getJson('/api/tasks/999999');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_can_update_a_task(): void
    {
        $task = Task::factory()->create();
        $data = [
            'title'       => 'Updated Task Title',
            'assigned_to' => 'Jane Doe',
            'status'      => 'in_progress',
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $data);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonPath('title', 'Updated Task Title')
            ->assertJsonPath('assigned_to', 'Jane Doe')
            ->assertJsonPath('status', 'in_progress');

        $this->assertDatabaseHas('tasks', [
            'id'          => $task->id,
            'title'       => 'Updated Task Title',
            'assigned_to' => 'Jane Doe',
            'status'      => 'in_progress',
        ]);
    }

    /** @test */
    public function it_can_delete_a_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");
        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
