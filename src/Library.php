<?php

namespace OnkaarGujarr\Library;

use OnkaarGujarr\Library\Services\Library\LibraryService;
use OnkaarGujarr\Library\Services\Library\LibraryValidator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class Library
{

    public function __construct()
    {
        $this->libraryService = resolve(LibraryService::class);
        $this->libraryValidator = resolve(LibraryValidator::class);
    }
    public function getAllLibrary($params)
    {
        $this->libraryValidator->validate($params, $this->libraryValidator::GET_BOOKMARK_REQUEST);
        $articles = $this->libraryService->setUserId($params['user_id'])->getBookmarks(Arr::only($params, ['count', 'offset','sort_by', 'order_by','version']));
        return response()->json(['totalHits'=>$this->libraryService->getCountBookmarksForUser($params['user_id'], $params['version']), 'data'=>$articles, 200],200);
    }

    public function saveToLibrary($params)
    {
        $this->libraryValidator->validate($params, $this->libraryValidator::STORE_BOOKMARK_REQUEST);
        $this->validateArticleId($params['article_id'], $params['version']);
        $this->libraryService->setUserId((int) $params['user_id'])->stored($params);
        return response()->json(['message'=>'Saved to library'],200);
    }

    public function removeFromLibrary($params)
    {
        $this->libraryValidator->validate($params, $this->libraryValidator::STORE_BOOKMARK_REQUEST);
        $this->validateArticleId($params['article_id'], $params['version']);
        $library = $this->libraryService->setUserId((int) $params['user_id'])->remove($params);
        if ($library == "Bookmark doesn't exist") {
            return response()->json(['message'=>"Bookmark doesn't exist"],422);
        } else {
            return response()->json(['message'=>'Removed from library'],200);
        }
    }
    
    private function validateArticleId($articleId, $version = 'old')
    {
        if ($version == 'new' && is_numeric($articleId)) {
            throw ValidationException::withMessages([
                'message' => 'Unable to process your request, please update your App to latest version'
            ]);
        }
        if ($version == 'old' && !is_numeric($articleId)) {
            throw ValidationException::withMessages([
                'message' => 'Unable to process your request, please update your App to latest version'
            ]);
        }
    }
}
