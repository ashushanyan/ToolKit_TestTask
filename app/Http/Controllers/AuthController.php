<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Test Task",
 *      description="Auth with JWT, and users can create Statements",
 *      @OA\Contact(
 *          email="ashotshushanyan14@gmail.com"
 *      )
 * )
 */

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @OA\Post(
     *      path="/api/register",
     *      operationId="registerUser",
     *      tags={"Auth"},
     *      summary="Register a new user",
     *      description="Register a new user with the provided data",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Provide the necessary fields to create a new user",
     *          @OA\JsonContent(
     *              required={"name", "email", "password", "birthdate"},
     *              @OA\Property(property="name", type="string", example="John Doe"),
     *              @OA\Property(property="email", type="string", example="email"),
     *              @OA\Property(property="password", type="string", example="password"),
     *              @OA\Property(property="birthdate", type="string", format="date", example="1990-01-01")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="User created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="user", type="object",
     *                  @OA\Property(property="name", type="string", example="John Doe"),
     *                  @OA\Property(property="email", type="string", example="email"),
     *                  @OA\Property(property="birthdate", type="string", format="date", example="1990-01-01"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time", example="{updated_at}"),
     *                  @OA\Property(property="created_at", type="string", format="date-time", example="{created_at}"),
     *                  @OA\Property(property="id", type="integer", example="{id}")
     *              ),
     *              @OA\Property(property="token", type="string", example="token")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation errors",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object", example={"name": {"The name field is required."}})
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Server error occurred while registering the user.")
     *          )
     *      )
     * )
     */


    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());
        $token = $this->authService->login($user->email, $request->password);

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * @OA\Post(
     *      path="/api/login",
     *      operationId="loginUser",
     *      tags={"Auth"},
     *      summary="Authenticate user credentials and retrieve an access token",
     *      description="Authenticate the user credentials and return a token for subsequent API calls",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Provide the user credentials to authenticate",
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *              @OA\Property(property="password", type="string", format="password", example="secret123")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Authentication successful",
     *          @OA\JsonContent(
     *              @OA\Property(property="user", type="object",
     *                  @OA\Property(property="name", type="string", example="John Doe"),
     *                  @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *                  @OA\Property(property="birthdate", type="string", format="date", example="1990-01-01"),
     *                  @OA\Property(property="created_at", type="string", format="date-time", example="2023-05-02T18:27:51.000000Z"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time", example="2023-05-02T18:27:51.000000Z"),
     *                  @OA\Property(property="id", type="integer", example="1")
     *              ),
     *              @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoxLCJlbWFpbCI6ImNvbUBleGFtcGxlLmNvbSIsImlhdCI6MTYyMjEwOTc1OCwiZXhwIjoxNjIyMTA5ODc4fQ.OQuzLg5_M5Jo5IjHfuahz7YgqwlyXU6ZkU6xzeU6iSw")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized access",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Invalid credentials")
     *          )
     *      )
     * )
     */

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->authService->getUserByEmail($request->email);
        $token = $this->authService->login($request->email, $request->password);

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }
}
