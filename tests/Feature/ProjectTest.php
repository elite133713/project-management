<?php

namespace Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_projects(): void
    {
        Project::factory()->count(100)->create();

        $page = 1;
        $limit = 15;
        $response = $this->getJson("/api/projects?page={$page}&limit={$limit}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(15);
    }

    /** @test */
    public function it_can_create_a_project(): void
    {
        $data = [
            'title'       => 'New Project',
            'description' => 'Project description',
            'status'      => 'open',
        ];

        $response = $this->postJson('/api/projects', $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonPath('title', 'New Project')
            ->assertJsonPath('description', 'Project description');

        $this->assertDatabaseHas('projects', [
            'title' => 'New Project',
        ]);
    }

    /** @test */
    public function it_requires_a_title_when_creating_a_project(): void
    {
        $data = [
            'description' => 'Project description',
            'status'      => 'open',
        ];

        $response = $this->postJson('/api/projects', $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['title']);
    }

    /** @test */
    public function it_can_show_a_project(): void
    {
        $project = Project::factory()->create();

        $response = $this->getJson("/api/projects/$project->id");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonPath('id', $project->id);
    }

    /** @test */
    public function it_returns_404_if_project_not_found(): void
    {
        $response = $this->getJson('/api/projects/999999');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_can_update_a_project(): void
    {
        $project = Project::factory()->create();
        $updateData = [
            'title'  => 'Updated Title',
            'status' => 'completed'
        ];

        $response = $this->putJson("/api/projects/{$project->id}", $updateData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonPath('title', 'Updated Title')
            ->assertJsonPath('status', 'completed');

        $this->assertDatabaseHas('projects', [
            'id'     => $project->id,
            'title'  => 'Updated Title',
            'status' => 'completed'
        ]);
    }

    /** @test */
    public function it_can_delete_a_project(): void
    {
        $project = Project::factory()->create();

        $response = $this->deleteJson("/api/projects/{$project->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);
    }
}
