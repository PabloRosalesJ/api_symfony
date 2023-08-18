<?php
declare(strict_types=1);
namespace Crimsoncircle\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\JsonResponse;

class Response {

    public static function success($content, int $statusCode = 200) : JsonResponse {

        return new JsonResponse(json_encode([
            'message' => $content
        ]), $statusCode, [], true);
    }

    public static function error($content, int $statusCode = 500) : JsonResponse {

        return new JsonResponse(json_encode([
            'error' => $content
        ]), $statusCode, [], true);
    }

    public static function wrap(string $wrap, $content, int $statusCode = 200) : JsonResponse {

        // if($content instanceof Collection) $content->toArray();
        // if($content instanceof Model) $content->toArray();

        return new JsonResponse(json_encode([
            $wrap => $content
        ]), $statusCode, [], true);
    }

}