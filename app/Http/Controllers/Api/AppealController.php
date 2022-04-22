<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppealFormRequest;
use App\Models\Appeal;
use App\OpenApi\RequestBodies\StoreAppealRequestBody;
use App\OpenApi\Responses\AppealOkResponse;
use App\OpenApi\Responses\AppealValidationErrorsResponse;
use App\Sanitizers\PhoneSanitizer;
use Illuminate\Http\JsonResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class AppealController extends Controller
{
    /**
     * Send appeal
     *
     * @return JsonResponse
     *
     * @method POST
     */
    #[OpenApi\Operation(tags: ['appeals'])]
    #[OpenApi\RequestBody(factory: StoreAppealRequestBody::class)]
    #[OpenApi\Response(factory: AppealOkResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AppealValidationErrorsResponse::class, statusCode: 422)]
    public function send(AppealFormRequest $request)
    {
        $data = $request->only(['name', 'email', 'message']);
        $data['phone'] = PhoneSanitizer::sanitize($request->input('phone'));
        Appeal::create($data);

        return new JsonResponse('Appeal created', 200);
    }
}
