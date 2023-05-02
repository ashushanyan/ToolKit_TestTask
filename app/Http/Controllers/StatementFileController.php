<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatementFileRequest;
use App\Models\StatementFile;
use App\Services\StatementFileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;


class StatementFileController extends Controller
{
    private $statementFileService;

    public function __construct(StatementFileService $statementFileService)
    {
        $this->statementFileService = $statementFileService;
    }

    /**
     * @OA\Post(
     *      path="/api/statement-files",
     *      operationId="storeStatementFile",
     *      tags={"StatementFile"},
     *      summary="Store a new StatementFile",
     *      description="Store a new StatementFile with the provided data",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Provide the necessary fields to create a new StatementFile",
     *          @OA\JsonContent(
     *              required={"file", "filename", "statement_id"},
     *              @OA\Property(property="file", type="string", format="base64", example="base54"),
     *              @OA\Property(property="filename", type="string", example="file.pdf"),
     *              @OA\Property(property="statement_id", type="integer", example="{statement_id}")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="StatementFile created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="filename", type="string", example="{filename}"),
     *              @OA\Property(property="file_path", type="string", example="storage/app/statements/{filename}"),
     *              @OA\Property(property="statement_id", type="integer", example="{statement_id}"),
     *              @OA\Property(property="created_at", type="string", format="date-time", example="{created_at}"),
     *              @OA\Property(property="updated_at", type="string", format="date-time", example="{updated_at}")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation errors",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object", example={"file": {"The file field is required."}})
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Server error occurred while storing the StatementFile.")
     *          )
     *      )
     * )
     */
    public function store(StatementFileRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $statementFile = $this->statementFileService->store($validatedData);

        return response()->json(['statement_file' => $statementFile], 201);
    }

    /**
     * @OA\Put(
     *      path="/api/statement-files/{id}",
     *      operationId="updateStatementFile",
     *      tags={"StatementFile"},
     *      summary="Update an existing StatementFile",
     *      description="Update an existing StatementFile with the provided data",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the StatementFile to update",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Provide the fields to update a StatementFile",
     *          @OA\JsonContent(
     *              @OA\Property(property="file_name", type="string", example="updated_file.pdf"),
     *              @OA\Property(property="file_path", type="string", example="updated_file_path"),
     *              @OA\Property(property="statement_id", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="StatementFile updated successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="file_name", type="string", example="updated_file.pdf"),
     *              @OA\Property(property="file_path", type="string", example="updated_file_path"),
     *              @OA\Property(property="statement_id", type="integer", example=1),
     *              @OA\Property(property="created_at", type="string", format="date-time", example="{created_at}"),
     *              @OA\Property(property="updated_at", type="string", format="date-time", example="{updated_at}")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="StatementFile not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The specified StatementFile could not be found")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation errors",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object", example={"file_name": {"The file name field is required."}})
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Server error occurred while updating the StatementFile.")
     *          )
     *      )
     * )
     */

    public function update(StatementFileRequest $request, StatementFile $statementFile): JsonResponse
    {
        $validatedData = $request->validated();
        $statementFile = $this->statementFileService->update($statementFile, $validatedData);

        return response()->json(['statement_file' => $statementFile], 200);
    }

    /**
     * @OA\Delete(
     *      path="/api/statement-files/{id}",
     *      operationId="deleteStatementFile",
     *      tags={"StatementFile"},
     *      summary="Delete a StatementFile",
     *      description="Delete a StatementFile with the specified ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the StatementFile to delete",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="StatementFile deleted successfully",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="StatementFile not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The specified StatementFile could not be found.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Server error occurred while deleting the StatementFile.")
     *          )
     *      )
     * )
     */

    public function delete(StatementFile $statementFile): JsonResponse
    {
        $this->statementFileService->delete($statementFile);
        Storage::delete($statementFile->file_path);

        return response()->json(['message' => 'Statement file deleted successfully'], 200);
    }
}
