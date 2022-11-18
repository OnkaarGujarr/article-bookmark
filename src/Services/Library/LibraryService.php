<?php

namespace  OnkaarGujarr\Library\Services\Library;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;
use OnkaarGujarr\Library\Repository\Library\LibraryInterface;
use OnkaarGujarr\Library\Repository\UserReadHistory\UserReadHistoryInterface;
use App\Exceptions\DiscoveryApiException;


class  LibraryService
{
    public const BOOKMARK_SOURCE_FEED = 'feed';

    public function __construct(
        LibraryInterface $libraryInterface,
        LibraryValidator $libraryValidator,
        UserReadHistoryInterface $userReadHistoryRepo
        )
    {
        $this->libraryInterface = $libraryInterface;
        $this->libraryValidator = $libraryValidator;
        $this->userReadHistoryRepo = $userReadHistoryRepo;
    }

    public function setUserId(int $userId): LibraryService
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

        $articleColumn = 'article_id';
        if ($version == 'new') {
            $articleColumn = 'new_article_id';
        }

        $articleIds = $library->pluck($articleColumn)->toArray();
        
        // TODO:: UserReadHistory is an another repository (It will not be included in this package)

        $readHistory = $this->userReadHistoryRepo->getHistoryBasedOnUserVersionForProvideArticleIds(
            $this->userId, $articleIds, $version)->pluck('id', $articleColumn)->toArray();

        return $library->transform(function ($item) use ($readHistory, $articleColumn) {
            $articleId = $item->$articleColumn;
            $articleMeta = $item->article_meta;
            $articleMeta[ 'id' ] = $articleId;
            $item[ 'article' ] = new Article($articleMeta);
            $item[ 'is_read' ] = Arr::has($readHistory, $articleId);

            return $item;
        })->toArray();
    }

    public function getCountBookmarksForUser(int $userId, $version = 'old'): int
    {
        return $this->libraryInterface->getBookmarkCountBasedOnUserVersionAndDateRange($userId, $version);
    }

    public function storedd($articleId, array $source, $version = 'old')
    {
        $parameters = [
            'user_id' => $this->userId,
            'article_id' => $articleId,
            'source' => Arr::get($source, 'source', self::BOOKMARK_SOURCE_FEED)
        ];

        if ($version == 'new') {
            $parameters[ 'new_article_id' ] = $articleId;
            unset($parameters[ 'article_id' ]);
        }

        $this->libraryValidator->validate($parameters, LibraryValidator::STORE_BOOKMARK_SOURCE);
        if ($version == 'new') {
            return $this->libraryInterface->updateOrCreated(Arr::only($parameters, ['user_id', 'new_article_id']),
                $parameters);
        }
        return $this->libraryInterface->updateOrCreate(Arr::only($parameters, ['user_id', 'article_id']), $parameters);
    }

    public function remove($articleId, $version = 'old'): bool
    {
        $parameters = [
            'user_id' => $this->userId,
            'article_id' => $articleId,
        ];

        if ($version == 'new') {
            $parameters = [
                'user_id' => $this->userId,
                'new_article_id' => $articleId,
            ];
        }

        $this->libraryValidator->validate($parameters, LibraryValidator::STORE_BOOKMARK);
        if ($library = $this->libraryInterface->findWhere($parameters)) {
            return $library->delete();
        }
        logger()->warning('POSSIBLE BUG: User tried to remove a non-existing bookmark', $parameters);
        throw new DiscoveryApiException("Bookmark doesn't exist", 422);
    }
    
}