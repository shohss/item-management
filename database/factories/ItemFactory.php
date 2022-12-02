<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
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
        $types = ['1', '2', '3', '4', '5', '6', '7'];
        // $details = ['new','old'];
        // fakerを使って適当なデータ作成
        return [
            //
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'name' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'type' => $this->faker->randomElement($types),
            // 'deatails' => $this->faker->randomElement($details),
        ];
    }
}
