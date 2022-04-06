<?php

namespace App\Http\Controllers;

use App\Http\Resources\PageResource;
use App\Models\Page;
use App\OpenApi\Responses\ListPagesResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\ShowPagesResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class PageApiController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return Responsable
     */
    #[OpenApi\Operation(tags: ['pages'])]
    #[OpenApi\Response(factory: ListPagesResponse::class, statusCode: 200)]

    public function index()
    {
        return PageResource::collection(Page::orderBy('title')->paginate(5));
    }

    /**
     * Display the specified resource
     *
     * @return Responsable
     * @param string $slug
     */
    #[OpenApi\Operation(tags: ['pages'])]
    #[OpenApi\Response(factory: ShowPagesResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function show(string $slug)
    {
        return PageResource::make(Page::where('slug', $slug)->firstOrFail());
    }
}
