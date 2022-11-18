<?php

namespace OnkaarGujarr\Library\Repository\UserReadHistory;

class UserReadHistoryRepository implements UserReadHistoryInterface
{
    public function getHistoryBasedOnUserVersionForProvideArticleIds(int $userId, array $articleIds, $version = 'old')
    {
        if ($version == 'new') {
            return $this->model::where('user_id', $userId)
                               ->whereIn('new_article_id', $articleIds)
                               ->get();
        }

        return $this->model::where('user_id', $userId)
                           ->whereIn('article_id', $articleIds)
                           ->get();
    }
}