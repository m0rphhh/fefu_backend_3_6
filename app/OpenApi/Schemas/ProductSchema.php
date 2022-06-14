<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class ProductSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('Product')
            ->properties(
                Schema::string('name'),
                Schema::string('slug'),
                Schema::string('price'),
                Schema::string('description'),
                Schema::array('category')->properties(
                    Schema::string('name'),
                    Schema::string('slug'),
                    Schema::integer('parent_id')->nullable(),
                ),
                Schema::array('attributes')->properties(
                    Schema::string('name'),
                    Schema::string('value'),
                ),
            );
    }
}
