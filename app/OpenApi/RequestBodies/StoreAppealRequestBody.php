<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\Schemas\AppealSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class StoreAppealRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('AppealCreate')
            ->description('Store new appeal into database')
            ->content(MediaType::json()->schema(AppealSchema::ref()));
    }
}
