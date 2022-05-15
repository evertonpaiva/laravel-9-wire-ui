<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Password;


class AuthController extends ApiController
{
    /**
     * @OA\Post(
     *     path="/register",
     *     operationId="authRegister",
     *     tags={"auth","NaoAutenticado"},
     *     summary="Registro de novo usuário",
     *     description="Cadastro de um novo usuário",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"name", "email", "username", "password"},
     *               @OA\Property(property="name", type="text"),
     *               @OA\Property(property="email", type="email"),
     *               @OA\Property(property="username", type="text"),
     *               @OA\Property(property="password", type="password"),
     *            ),
     *        ),
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="Registrou novo usuário com sucesso",
     *        @OA\JsonContent()
     *    ),
     *    @OA\Response(
     *        response=409,
     *        description="Algum conflito de dados foi identificado.",
     *        @OA\JsonContent()
     *    ),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Recurso não encontrado"),
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),409);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     operationId="authLogin",
     *     tags={"auth","NaoAutenticado"},
     *     summary="Login do usuário",
     *     description="O usuário do sistema efetua login",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"email", "password"},
     *                 @OA\Property(property="email", type="email"),
     *                 @OA\Property(property="password", type="password")
     *            ),
     *        ),
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="Login com sucesso",
     *        @OA\JsonContent()
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="O usuário não conseguiu efetuar o login.",
     *        @OA\JsonContent()
     *    ),
     * )
     */
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['message' => 'Hi ' . $user->name . ', welcome to home', 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     operationId="authLogout",
     *     tags={"auth","Autenticado"},
     *     security={{ "Bearer":{} }},
     *     summary="Logout do usuário",
     *     description="O usuário do sistema efetua logout do sistema. O token do usuário é invalidado.",
     *     @OA\Response(
     *         response=200,
     *         description="Logout com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated. O token não foi enviado e não foi possível realizar o logout.",
     *         @OA\JsonContent()
     *     ),
     * )
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()
            ->json(['message' => 'Você deslogou com sucesso e o token de autenticação foi removido']);
    }

    /**
     * @OA\Get(
     *     path="/profile",
     *     operationId="authProfile",
     *     tags={"auth","Autenticado"},
     *     security={{ "Bearer":{} }},
     *     summary="Dados do usuários autenticado",
     *     description="Recupera as informações do usuário autenticado no sistema.",
     *     @OA\Response(
     *         response=200,
     *         description="Recuperou os dados de usuário com sucesso",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated. O token não foi enviado e não foi possível realizar o logout.",
     *         @OA\JsonContent()
     *     ),
     * )
     */
    public function profile()
    {
        $user = auth()->user();

        return response()
            ->json(['data' => $user]);
    }


    /**
     * @OA\Post(
     *     path="/login/recuperar",
     *     operationId="authForgotPassword",
     *     tags={"auth","NaoAutenticado"},
     *     summary="Recuperação de senha",
     *     description="Iniciar o processo de recuperação de senha por e-mail",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"email"},
     *                 @OA\Property(property="email", type="email"),
     *            ),
     *        ),
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="Processo de recuperação de senha iniciado",
     *        @OA\JsonContent()
     *    ),
     *    @OA\Response(
     *        response=404,
     *        description="Não encontrou usuário com email informado",
     *        @OA\JsonContent()
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Não foi possível solicitar a recuperação de senha",
     *        @OA\JsonContent()
     *    ),
     * )
     */
    public function forgotPassword(Request $request)
    {
        $credentials = $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request['email'])->first();

        if (!$credentials or !$user) {
            return response()
                ->json(['message' => 'Não existe usuário para o e-mail informado ou e-mail inválido.'], 404);
        }

        Password::sendResetLink($credentials);

        return response()->json(["message" => 'As instruções de recuperação de senha foram enviadas para o seu e-mail']);
    }
}
