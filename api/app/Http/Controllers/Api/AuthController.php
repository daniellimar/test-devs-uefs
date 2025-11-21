<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Endpoints de autenticação"
 * )
 *
 *
 * @OA\Info(
 *      title="API Test Devs UEFS",
 *      version="1.0.0",
 *      description="Documentação da API"
 *  )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Autenticação do usuário",
     *     tags={"Auth"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="usuario@email.com"),
     *             @OA\Property(property="password", type="string", example="123456")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Token gerado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="1|Xsdf98df9sdf09df90sdf9sdf")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Credenciais inválidas")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Efetua logout do usuário autenticado",
     *     tags={"Auth"},
     *     security={{ "sanctum": {} }},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Logout realizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logout realizado com sucesso")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Não autenticado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso'
        ]);
    }
}
