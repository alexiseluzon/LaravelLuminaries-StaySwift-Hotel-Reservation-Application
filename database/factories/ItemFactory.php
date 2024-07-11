<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /** 
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_name' => $this->faker->word,
            'item_quantity' => $this->faker->numberBetween(1, 100),
            'category' => $this->faker->randomElement(['Classroom Items', 'Office Items', 'Library Items',
             'Science Lab Items', 'Art Room Items', 'Music Room Items', 'Gymnasium and Sports Items',
              'Cafeteria Items', 'Maintenance Items', 'Playground Items', 'Miscellaneous Items']),
            'unit_of_measure' => $this->faker->randomElement(['Sets', 'Pieces', 'Packs', 'Kits']),
            'room_number' => $this->faker->randomDigitNotNull,
            'school_level' => $this->faker->randomElement(['Junior High School', 'Senior High School']),
            'adviser' => $this->faker->name,
        ];
    }
}
