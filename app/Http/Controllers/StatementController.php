<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatementRequest;
use App\Models\Statement;
use App\Services\StatementService;
use Illuminate\Http\JsonResponse;

class StatementController extends Controller
{
    protected $statementService;

    public function __construct(StatementService $statementService)
    {
        $this->statementService = $statementService;
    }

    /**
     * @OA\Get(
     *     path="/api/statements",
     *     summary="Get all statements",
     *     description="Returns a list of all statements",
     *     tags={"Statement"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="number", type="string"),
     *                 @OA\Property(property="date", type="string"),
     *                 @OA\Property(property="user_id", type="integer"),
     *                 @OA\Property(property="updated_at", type="string"),
     *                 @OA\Property(property="created_at", type="string"),
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(
     *                     property="files",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="file_name", type="string"),
     *                         @OA\Property(property="file_path", type="string"),
     *                         @OA\Property(property="statement_id", type="integer"),
     *                         @OA\Property(property="created_at", type="string"),
     *                         @OA\Property(property="updated_at", type="string")
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function index(): JsonResponse
    {
        $statements = $this->statementService->index();

        return response()->json($statements);
    }

    /**
     * @OA\Post(
     *     path="/api/statements",
     *     summary="Store a new statement",
     *     tags={"Statement"},
     *     description="Store a new statement and its related files.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="The data needed to create a new statement.",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="number", type="string"),
     *             @OA\Property(property="date", type="string", format="date"),
     *             @OA\Property(
     *                 property="statement_files",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="file", type="string"),
     *                     @OA\Property(property="filename", type="string"),
     *                     @OA\Property(property="statement_id", type="string")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="The new statement was created successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="number", type="string"),
     *             @OA\Property(property="date", type="string", format="date"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(
     *                 property="files",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="file_name", type="string"),
     *                     @OA\Property(property="file_path", type="string"),
     *                     @OA\Property(property="statement_id", type="integer"),
     *                     @OA\Property(property="created_at", type="string", format="date-time"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="The data provided is invalid or incomplete.",
     *         @OA\Property(property="message", type="string", example="Unprocessable Entity Response")
     *
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="An error occurred while processing the request.",
     *         @OA\Property(property="message", type="string", example="Internal Server Error")
     *     )
     * )
     */

    public function store(StatementRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $files = $validatedData['statement_files'];

        unset($validatedData['statement_files']);

        $statement = $this->statementService->store($validatedData, $files);
        $statement->load('files');

        return response()->json($statement, 201);
    }

    public function show(Statement $statement): JsonResponse
    {
        $statement = $this->statementService->show($statement);

        return response()->json($statement);
    }

    /**
     * @OA\Put(
     *     path="/api/statements/{id}",
     *     summary="Update an existing statement",
     *     tags={"Statement"},
     *     description="Update an existing statement and its related files.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the statement to update.",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="The data needed to update the statement.",
     *         @OA\Property(property="message", type="string", example="Unprocessable Entity Response")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="The statement was updated successfully.",
     *         @OA\Property(property="message", type="string", example="Unprocessable Entity Response")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="The statement with the provided ID was not found.",
     *         @OA\Property(property="message", type="string", example="Unprocessable Entity Response")
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="The data provided is invalid or incomplete.",
     *         @OA\Property(property="message", type="string", example="Unprocessable Entity Response")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="An error occurred while processing the request.",
     *         @OA\Property(property="message", type="string", example="Unprocessable Entity Response")
     *     )
     * )
     */

    public function update(StatementRequest $request, Statement $statement): JsonResponse
    {
        $statement = $this->statementService->update($statement, $request->validated());

        return response()->json($statement);
    }

    public function destroy(Statement $statement): JsonResponse
    {
        $this->statementService->destroy($statement);

        return response()->json(['message' => 'Statement deleted successfully.']);
    }
}
