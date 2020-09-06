<?php

use App\Models\Currency;

class CurrenciesTableSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = $this->getSeedFileContents('currencies');

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
