<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TranslationRequest;
use App\Services\TranslationService;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="Translation Management API", version="1.0.0")
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Bearer token for authentication"
 * )
 */
class TranslationController extends Controller
{
    protected $service;

    /**
     * Constructor to inject the TranslationService dependency.
     *
     * @param TranslationService $service
     */
    public function __construct(TranslationService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/translations",
     *     summary="Get a list of translations",
     *     operationId="listTranslations",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="A list of translations",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Translation"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json($this->service->list());
    }

    /**
     * @OA\Post(
     *     path="/api/translations",
     *     summary="Store a new translation",
     *     operationId="storeTranslation",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TranslationRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Translation created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Translation")
     *     )
     * )
     */
    public function store(TranslationRequest $request)
    {
        return response()->json($this->service->create($request->validated()), 201);
    }

    /**
     * @OA\Put(
     *     path="/api/translations/{id}",
     *     summary="Update an existing translation",
     *     operationId="updateTranslation",
     *     security={{"bearerAuth": {}}},

     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the translation to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TranslationRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Translation updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Translation")
     *     )
     * )
     */
    public function update(TranslationRequest $request, $id)
    {
        return response()->json($this->service->update($id, $request->validated()));
    }

    /**
     * @OA\Get(
     *     path="/api/translations/{id}",
     *     summary="Get a single translation by ID",
     *     operationId="showTranslation",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the translation",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A single translation",
     *         @OA\JsonContent(ref="#/components/schemas/Translation")
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json($this->service->show($id));
    }

    /**
     * @OA\Get(
     *     path="/api/export/{locale}",
     *     summary="Export translations for a specific locale",
     *     operationId="exportTranslations",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="locale",
     *         in="path",
     *         required=true,
     *         description="Locale to export translations for",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Translations exported successfully",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Translation"))
     *     )
     * )
     */
    public function export($locale)
    {
        return response()->json($this->service->export($locale));
    }

    /**
     * @OA\Get(
     *     path="/api/search",
     *     summary="Search translations based on filters",
     *     operationId="searchTranslations",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="key",
     *         in="query",
     *         description="Translation key to search for",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="content",
     *         in="query",
     *         description="Translation content to search for",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="tag",
     *         in="query",
     *         description="Tag name to filter translations",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Filtered translations",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Translation"))
     *     )
     * )
     */
    public function search(Request $request)
    {
        return response()->json($this->service->search($request));
    }
}
