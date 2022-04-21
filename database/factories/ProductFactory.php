<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'kode_barang' => $this->faker->unique()->randomNumber(6),
            'nama_barang' => $this->faker->word,
            'berat_barang' => $this->faker->randomFloat(2, 0, 100),
            'merek' => $this->faker->word,
            'stok' => $this->faker->numberBetween(0, 100),
            'harga_beli' => $this->faker->numberBetween(10000, 1000000),
            'harga_jual' => $this->faker->numberBetween(10000, 1000000),
            'diskon' => $this->faker->numberBetween(0, 100),
        ];
    }
}
