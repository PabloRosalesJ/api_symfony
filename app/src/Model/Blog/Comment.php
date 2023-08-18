<?php
declare(strict_types=1);
namespace Crimsoncircle\Model\Blog;
use Crimsoncircle\Exceptions\EmptyValueException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class Comment extends Model {

    protected $table = 'comments';

    protected $guarded = [];

    protected $hidden = ['updated_at'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function post(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Post::class);
    }


    public static function newComment(
        string $content, string $author, int $post_id
    ) : self {

        /* TODO: More validation logic ... */
        if ('' === trim($content)) throw new EmptyValueException('content', 422);
        if ($post_id <= 0) throw new EmptyValueException('post_id', 422);
        if ('' === trim($author)) throw new EmptyValueException('author', 422);

        $comment = Post::query()->
            findOrFail($post_id)->
            comments()->
            create([
                'content' => $content,
                'author' => $author,
            ]);

        // dd($comment);

        return $comment;
    }

    public static function findComment(int $commentId) : ?self {

        return self::query()->findOrFail($commentId);

    }

    public static function deleteComment(int $commentId) : bool {

        $deleted = self::query()->findOrFail($commentId)->delete();
        return (bool) $deleted;
    }


    public static function getByPost(int $post_id, int $page) {

        Post::query()->findOrFail($post_id);

        $comments = Comment::query()->
            where('post_id', $post_id)->
            paginate(10, '*', 'page', $page)
        ;

        return $comments->getCollection();
    }

}