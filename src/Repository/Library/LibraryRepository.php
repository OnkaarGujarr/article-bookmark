<?php

namespace OnkaarGujarr\Library\Repository\Library;

use OnkaarGujarr\Library\Repository\Library\LibraryInterface;
use OnkaarGujarr\Library\Models\Library;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


class LibraryRepository implements LibraryInterface
{
    // Defining the Model
    public function __construct(Library $model) {
        $this->model = $model;
    }

    public function getByUserId(int $userId, array $params, $version='old')
    {
        $query = $this->model::where('user_id', $userId);
        if ($version == 'new') {
            // DB::connection()->enableQueryLog();
            $query = $query->whereNotNull('new_article_id')
                           ->where('new_article_id', '!=', 'missing_in_dynamodb')
                           ->whereNotNull('article_meta');

        } else {
            $query = $query->whereNotNull('article_id')
                           ->whereNotNull('article_meta');
        }
        return $query->take(Arr::get($params, 'count', 20))
        ->offset(Arr::get($params, 'offset', 0))
        ->orderBy(
            Arr::get($params, 'sort_by', 'created_at'),
            Arr::get($params, 'order_by', 'desc')
        )->get();
        // $queries = \DB::getQueryLog();
    }

    public function getBookmarkCountBasedOnUserVersionAndDateRange(
        int $userId,
        $version = 'old',
        $startDate = null,
        $endDate = null
        ) {
        $query = $this->model::where('user_id', $userId);
        if ($version == 'new') {
            $query = $query->whereNotNull('new_article_id')
                           ->where('new_article_id', '!=', 'missing_in_dynamodb')
                           ->whereNotNull('article_meta');
        } else {
            $query = $query->whereNotNull('article_id')
                           ->whereNotNull('article_meta');
        }

        if ($startDate != null && $endDate != null) {
            $query = $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        return $query->count();
    }

    public function updateOrCreated($searchAttributes, $updateAttributes = [])
    {
        return $this->model->updateOrCreate($searchAttributes, $updateAttributes);
    }

    public function findWhere($cols = [])
    {
        return $this->model
            ->where($cols)
            ->first();
    }
}
