<?php

namespace OnkaarGujarr\Library\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use OnkaarGujarr\Library\Events\LibraryCreatedEvent;
use OnkaarGujarr\Library\Events\LibraryDeletedEvent;
class Library extends Model
{

    protected $table = 'library';

    protected $fillable = [
        'user_id',
        'article_id',
        'active',
        'new_article_id'
    ];

    protected $dispatchesEvents = [
        'created' => LibraryCreatedEvent::class,
        'deleted' => LibraryDeletedEvent::class,
    ];

    protected $casts = [
        'article_meta' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}