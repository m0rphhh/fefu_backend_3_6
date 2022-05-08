<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\Schemas\UserSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class AuthRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('Login')
            ->description('Login')
            ->content(MediaType::json()->schema(UserSchema::ref()));
    }
}
