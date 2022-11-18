<?php

namespace OnkaarGujarr\Library\Repository\Library;

interface LibraryInterface
{
    public function getByUserId(int $userId, array $params, $version = 'old');

    public function getBookmarkCountBasedOnUserVersionAndDateRange(
        int $userId,
        $version = 'old',
        $startDate = null,
        $endDate = null
    );

    public function updateOrCreated($searchAttributes, $updateAttributes = []);

    public function findWhere($cols = []);

}