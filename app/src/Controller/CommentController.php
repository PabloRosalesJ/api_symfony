<?php
declare(strict_types=1);
namespace Crimsoncircle\Controller;

use Crimsoncircle\Model\Blog\Comment;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Crimsoncircle\Model\Blog\Post;
use Crimsoncircle\Http\Response;

class CommentController {

    public function store(Request $request) : JsonResponse {
        $jsonRequest = collect(json_decode($request->getContent(), true));

        if ($jsonRequest === null) {
            return new JsonResponse(['error' => 'Invalid JSON data'], 400);
        }

        $comment = Comment::newComment(
            content: $jsonRequest->get('content', ''),
            author: $jsonRequest->get('author', ''),
            post_id: $jsonRequest->get('post_id', 0)
        );

        return Response::wrap('commet', $comment, 200);
    }

    public function find(Request $request, string $comment_id) : JsonResponse {

        $post = Comment::findComment((int) $comment_id);

        return Response::wrap('comment', $post ?? null, $post ? 200 : 404);
    }

    public function delete(Request $request, string $comment_id) : JsonResponse {

        $comment = Comment::deleteComment((int) $comment_id);

        return Response::success(sprintf('comment %s', $comment ? 'deleted' : 'not found'), $comment ? 200 : 404);
    }

    public function listByPost(Request $request, int $post_id) {
        $page = $request->query->get('page');
        $post = Comment::getByPost($post_id, (int) $page);

        return Response::wrap('comments', $post ?? null, 200);

    }

}