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

    /**
     * Returns the given seeder file as an path.
     *
     * @param string $fileName
     *
     * @return string
     */
    protected function getSeedFilePath(string $fileName): string
    {
        $path = __DIR__.'/data';

        return "{$path}/{$fileName}.json";
    }

    /**
     * Returns the given file contents as an array.
     *
     * @param string $fileName
     *
     * @return array
     */
    protected function getSeedFileContents(string $fileName)
    {
        $filePath = $this->getSeedFilePath($fileName);

        return json_decode(file_get_contents($filePath), true);
    }
}
