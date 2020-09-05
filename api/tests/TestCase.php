<?php

namespace Tests;

use DatabaseSeeder;
use Faker\Generator;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Throwable;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * The Faker Generator instance.
     *
     * @var Generator
     */
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = app(Generator::class);

        $this->seed(DatabaseSeeder::class);
    }

    /**
     * @throws Throwable
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }
}
