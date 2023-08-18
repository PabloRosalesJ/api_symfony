<?php
declare(strict_types=1);
namespace Crimsoncircle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;

use Crimsoncircle\Model\Blog\Post;
use Crimsoncircle\Http\Response;

class BlogController {

    public function store(Request $request) : JsonResponse {
        $jsonRequest = collect(json_decode($request->getContent(), true));

        if ($jsonRequest === null) {
            return new JsonResponse(['error' => 'Invalid JSON data'], 400);
        }

        $post = Post::newPost(
            title: $jsonRequest->get('title', ''),
            content: $jsonRequest->get('content', ''),
            author: $jsonRequest->get('author', ''),
            slug: $jsonRequest->get('slug', '')
        );

        return Response::wrap('post', $post, 200);
    }

    public function find(Request $request, string $slug) : JsonResponse {

        $post = Post::findPost($slug);

        return Response::wrap('post', $post ?? null, $post ? 200 : 404);
    }

    public function delete(Request $request, string $slug) : JsonResponse {

        $post = Post::deletePost($slug);

        return Response::success(sprintf('post %s', $post ? 'deleted' : 'not found'), $post ? 200 : 404);
    }

}