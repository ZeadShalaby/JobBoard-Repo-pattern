<?php

namespace Database\Factories;

use App\Models\Job;
use App\Enums\JobTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'salary' => $this->faker->numberBetween(30000, 150000),
            'type' => JobTypeEnum::cases()[array_rand(JobTypeEnum::cases())]->value, // اختيار عشوائي لنوع الوظيفة
        ];
    }
}
