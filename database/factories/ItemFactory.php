<?php

namespace Database\Factories;

use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'event_id'      => 1,
            'item_name'     => fake()->word(5),
            'price'         => fake()->numberBetween(1, 1000),
            'payer'         => fake()->numberBetween(1, 10),
            'share_member'  => fake()->numberBetween(1, 10),
            'created_at'    => now(),
            'updated_at'    => now(),
            'item_id'       => fake()->numberBetween(1, 10),
        ];
    }
}
