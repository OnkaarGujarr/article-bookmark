<?php

namespace OnkaarGujarr\Library\Listener;

use OnkaarGujarr\Library\Events\LibraryCreatedEvent;
use App\Services\UserHomeFeed\Jobs\CacheUserRecommendationsInspiredByActivity;
use App\Jobs\GenerateUserRoundupHeadlineSynopsis;
use App\Jobs\RemoveArticleFromHomePageCache;
use App\Jobs\UpdateNewArticleId;
use App\Jobs\UpdateUserPropertiesOnClevertap;
use App\Models\UserArticlesAction;
use App\Services\FingerPrint\FingerPrintFactory;
use App\Jobs\CalculateUserFingerprint;
use App\Jobs\AddArticleMetaToLibraryAndUserArticleActionTable;

class LibraryCreatedListener
{

    /**
     * Handle the event.
     *
     * @param LibraryCreatedEvent $event
     * @return void
     */
    public function handle(LibraryCreatedEvent $event)
    {
        $library = $event->library;
        $user = $library->user;
        $version = $user->version;
        return "Listerner works";
        /* 
        // CalculateUserFingerprint Job has dispatched over here (FingerPrintFactory Services are being used)
         
        CalculateUserFingerprint::dispatch(FingerPrintFactory::USER_BOOKMARK_CREATED, $library, ['version' => $version])
                                ->onConnection('redis')
                                ->onQueue('fingerprint');
        


        if ($version == 'new') {
            $articleId = $library->new_article_id;
            UserArticlesAction::firstOrCreate([
                'user_id'          => $library->user_id,
                'new_article_id'   => $articleId,
                'action_performed' => 'book_marked'
            ]);
            AddArticleMetaToLibraryAndUserArticleActionTable::withChain([
                (new GenerateUserRoundupHeadlineSynopsis($library->user_id))
                    ->onConnection('redis')
                    ->onQueue('user_roundups')
            ])->dispatch($library->user_id, $articleId, $version)
                                       ->onConnection('redis')
                                       ->onQueue('update_article_meta_in_db');
        } else {
            $articleId = $library->article_id;
            UpdateNewArticleId::dispatch($articleId, 'Library')
                              ->onConnection('redis')
                              ->onQueue('update_new_article_id');
            UserArticlesAction::firstOrCreate([
                'user_id'          => $library->user_id,
                'article_id'       => $articleId,
                'action_performed' => 'book_marked'
            ]);
        }

        RemoveArticleFromHomePageCache::dispatchNow($library->user_id, $articleId, $version);

        UpdateUserPropertiesOnClevertap::dispatch($user->sso_id, $version)->onQueue('clevertap');
        CacheUserRecommendationsInspiredByActivity::dispatch($library->user_id,
            $version)->onConnection('redis')->onQueue('realtime_user_activity_recommendations');
            */
    }
}
