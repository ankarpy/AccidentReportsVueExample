<?php

namespace Database\Factories;

use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => rtrim($this->faker->sentence(rand(5,10)), "."),
            'body' => $this->faker->paragraphs(rand(3,7), true),
            'injured_count' =>rand(1,100),
            'happened_at' => $this->faker->dateTimeThisMonth(),
            'vehicle_id' => 'Vehicle '.rand(1,100),

        ];
    }
}
