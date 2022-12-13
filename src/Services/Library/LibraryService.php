<?php

namespace  OnkaarGujarr\Library\Services\Library;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;
use OnkaarGujarr\Library\Repository\Library\LibraryInterface;
use App\Exceptions\DiscoveryApiException;


class  LibraryService
{
    public const BOOKMARK_SOURCE_FEED = 'feed';

    public function __construct(
        LibraryInterface $libraryInterface,
        LibraryValidator $libraryValidator
        )
    {
        $this->libraryInterface = $libraryInterface;
        $this->libraryValidator = $libraryValidator;
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function getBookmarks(array $params = [], $version = 'old'): array
    {
        // Validate the Request
        $this->libraryValidator->validate($params, LibraryValidator::GET_BOOKMARK);
        
        $library = $this->libraryInterface->getByUserId($this->userId, $params, $version);
        if ($library->isEmpty()) {
            return [];
        }
        return $library;
    }

    public function getCountBookmarksForUser(int $userId, $version = 'old'): int
    {
        return $this->libraryInterface->getBookmarkCountBasedOnUserVersionAndDateRange($userId, $version);
    }

    public function stored($params,$version = 'old')
    {
        if ($params['version'] == 'new') {
            $params[ 'new_article_id' ] = $params['article_id'];
            unset($params[ 'article_id' ]);
        }
        $this->libraryValidator->validate($params, LibraryValidator::STORE_BOOKMARK_SOURCE);
        if ($params['version'] == 'new') {
            return $this->libraryInterface->updateOrCreated(Arr::only($params, ['user_id', 'new_article_id']),
                $params);
        }
        return $this->libraryInterface->updateOrCreate(Arr::only($params, ['user_id', 'article_id']), $params);
    }

    public function remove($params, $version = 'old')
    {
        if ($params['version'] == 'new') {
            $params = [
                'user_id' => $this->userId,
                'new_article_id' => $params['article_id'],
            ];
        }

        $this->libraryValidator->validate($params, LibraryValidator::STORE_BOOKMARK);
        if ($library = $this->libraryInterface->findWhere($params)) {
            return $library->delete();
        }else{
            return "Bookmark doesn't exist";
        }
    }
    
}