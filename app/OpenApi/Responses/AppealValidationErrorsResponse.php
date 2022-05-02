<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class AppealValidationErrorsResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::unprocessableEntity()->content(
            MediaType::json()->schema(
                Schema::object()->properties(
                    Schema::string('message')->example('The email must be a valid email address.'),
                    Schema::array('errors')->example([
                        'email' => 'The email must be a valid email address.',
                        'name' => 'Name field is required'
                    ])
                )
            )
        );
    }
}
