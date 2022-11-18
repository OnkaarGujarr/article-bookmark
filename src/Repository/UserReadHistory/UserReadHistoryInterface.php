<?php

namespace OnkaarGujarr\Library\Repository\UserReadHistory;

interface UserReadHistoryInterface
{
    public function getHistoryBasedOnUserVersionForProvideArticleIds(int $userId, array $params, $version = 'old');

}