<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $content
 * @property int $user_id
 * @property int $post_id
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', 
        'user_id', 
        'post_id'
    ];

    /**
     * Relacja do autora komentarza.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacja do posta, pod którym jest komentarz.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}