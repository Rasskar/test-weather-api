<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Weather API",
 *     version="1.0.0",
 *     description="API для получения информации о погоде",
 *     @OA\Contact(
 *         email="alekscygankov20@gmail.com"
 *     )
 * )
 *
 * @OA\SecurityScheme(
 *      type="http",
 *      scheme="bearer",
 *      securityScheme="bearerAuth",
 * )
 *
 * @OA\Tag(
 *     name="Auth",
 *     description="Аутентификация"
 * )
 *
 * @OA\Tag(
 *     name="User",
 *     description="Пользователь"
 * )
 *
 * @OA\Tag(
 *     name="Weather",
 *     description="Получение погоды"
 * )
 */
abstract class Controller
{
    //
}
