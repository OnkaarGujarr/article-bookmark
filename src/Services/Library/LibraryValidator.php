<?php
namespace OnkaarGujarr\Library\Services\Library;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LibraryValidator
{

    public const STORE_BOOKMARK = 'storeBookmark';
    public const STORE_BOOKMARK_REQUEST = 'storeBookmarkRequest';
    public const STORE_BOOKMARK_SOURCE = 'storeBookmarkSource';
    public const GET_BOOKMARK = 'getBookmark';
    public const GET_BOOKMARK_REQUEST = 'getBookmarkRequest';

    protected $rules = [];
    protected $messages = [];

    public function __construct()
    {
        $this->rules = [
            self::STORE_BOOKMARK        => [
                'user_id'    => ['required', 'integer'],
                'article_id' => [],
            ],
            self::STORE_BOOKMARK_REQUEST        => [
                'user_id'    => ['required', 'integer'],
                'article_id' => 'required',
                'version' => 'required',
                'source' => 'required',
            ],
            self::STORE_BOOKMARK_SOURCE => [
                'source'     => ['required', 'string'],
                'user_id'    => ['required', 'integer'],
                'article_id' => [],
            ],
            self::GET_BOOKMARK          => [
                'count'    => 'integer',
                'offset'   => 'integer',
                'sort_by'  => 'string|in:created_at',
                'order_by' => 'string|in:asc,desc'
            ],
            self::GET_BOOKMARK_REQUEST          => [
                'user_id' => 'required|numeric',
                'version' => 'required'
            ],
        ];

        $this->messages = [
            self::STORE_BOOKMARK        => [
                'user_id.required'    => 'User not found, please login',
                'user_id.integer'     => 'User id must be an integer',
                'article_id.required' => 'Article id is required',
            ],
            self::STORE_BOOKMARK_REQUEST        => [
                'user_id.required'    => 'User not found, please login',
                'user_id.integer'     => 'User id must be an integer',
                'article_id.required' => 'Article id is required',
                'version.required' => 'Version is required',
                'source.required' => 'Source is required',
            ],
            self::STORE_BOOKMARK_REQUEST       => [
                'user_id.required'    => 'User not found, please login',
                'user_id.integer'     => 'User id must be an integer',
                'article_id.required' => 'Article id is required',
            ],
            self::STORE_BOOKMARK_SOURCE => [
                'source.required'    => "'source' is required.",
                'source.string'      => "'source' must be a string",
            ],
            self::GET_BOOKMARK          => [
                'count.integer'   => 'count must be an integer',
                'offset.integer'  => 'offset must be an integer',
                'sort_by.string'  => 'sort by must be string',
                'sort_by.in'      => "sort by should be 'created_at'",
                'order_by.string' => 'order by must be string',
                'order_by.in'     => "order by should be 'asc' or 'desc'"
            ],
            self::GET_BOOKMARK_REQUEST          => [
                'user_id.required' => 'user_id is required',
                'version.required' => 'version isrequired'
            ],
        ];
    }
    
    public function validate($data, $ruleset = 'create')
    {
        
        // Load the correct ruleset.
        $rules = $this->rules[ $ruleset ];

        // Load the correct message set.
        $messages = $this->messages[ $ruleset ];

        // Validate the Data with ruleset and send proper message
        return Validator::make($data, $rules, $messages)->validate();
    }
}
