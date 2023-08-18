<?php
declare(strict_types=1);
namespace Crimsoncircle\Model\Blog;
use Crimsoncircle\Exceptions\EmptyValueException;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {

    protected $table = 'posts';

    protected $guarded = [];

    protected $hidden = ['updated_at'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public static function newPost(
        string $title, string $content, string $author, string $slug
    ) : self {

        /* TODO: More validation logic ... */
        if ('' === trim($title)) throw new EmptyValueException('title', 422);
        if ('' === trim($content)) throw new EmptyValueException('content', 422);
        if ('' === trim($author)) throw new EmptyValueException('author', 422);
        if ('' === trim($slug)) throw new EmptyValueException('slug', 422);

        $slug = str_replace([' ', '-'], '_', $slug);

        if (!str_starts_with('/', $slug)) {
            $slug = sprintf('/%s', $slug);
        }

        $content = [
            'title' => $title,
            'content' => $content,
            'author' => $author,
            'slug' => $slug,
        ];

        return self::create($content);
    }

    public static function findPost(string $slug) : ?self {

        return self::query()->where('slug', sprintf('/%s', $slug))->first();

    }

    public static function deletePost(string $slug) : bool {

        $deleted = self::query()->where('slug', sprintf('/%s', $slug))->delete();
        return (bool) $deleted;
    }

}