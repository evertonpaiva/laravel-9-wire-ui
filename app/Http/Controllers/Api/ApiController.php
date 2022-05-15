<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

/**
 * @OA\OpenApi(
 *   @OA\Server(
 *      url="/api"
 *   ),
 *   @OA\Info(
 *      title="Flyapp Web API",
 *      version="1.0.0",
 *   ),
 * )
 *
 *
 * @OA\Tag(name="NaoAutenticado", description="Não é requerida a autenticação do usuário")
 * @OA\Tag(name="Autenticado", description="Autenticação de usuário requirida")
 * @OA\Tag(name="auth", description="Controles de autenticação de usuário")
 *
 * @OA\SecurityScheme(
 *       scheme="Bearer",
 *       securityScheme="Bearer",
 *       type="apiKey",
 *       in="header",
 *       name="Authorization",
 *       description="Adicione o token no seguinte formato no campo <i>Value</i>: <i>Bearer token</i>.<br />
                     <b>Exemplo:</b> Bearer 2|oNCOOdTDxFMCxiEKKH7ZFXWa7y3XlyRjjE2prlx4<br />"
 * )
 */
abstract class ApiController extends Controller
{

}
