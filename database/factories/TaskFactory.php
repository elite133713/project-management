<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'project_id'  => Project::factory(),
            'title'       => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'assigned_to' => $this->faker->name,
            'due_date'    => $this->faker->date(),
            'status'      => $this->faker->randomElement(['to_do', 'in_progress', 'done']),
        ];
    }
}
