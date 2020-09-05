<?php

use Illuminate\Database\Seeder;

abstract class AbstractSeeder extends Seeder
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = app(Faker\Generator::class);
    }
}
