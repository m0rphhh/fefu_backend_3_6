<?php

namespace App\OpenApi\Parameters;

use App\OpenApi\Schemas\ProductListSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
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
                ->schema(ProductListSchema::ref()),
        ];
    }
}
