<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class ProductParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::query()
                ->name('category_slug')
                ->description('Slug of needed category')
                ->required(false)
                ->schema(Schema::string()),

            Parameter::query()
                ->name('search_query')
                ->description('Search query')
                ->required(false)
                ->schema(Schema::string()),

            Parameter::query()
                ->name('sort_mode')
                ->description('Sort mode')
                ->example('price_asc')
                ->example('price_desc')
                ->required(false)
                ->schema(Schema::string()),

            Parameter::query()
                ->name('filters')
                ->required(false)
                ->schema(Schema::array()->items(
                    Schema::array()->items(
                        Schema::string()
                    )
                ))
        ];
    }
}
