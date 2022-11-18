<?php

namespace OnkaarGujarr\Library\Listener;

use OnkaarGujarr\Library\Events\LibraryDeletedEvent;
use App\Services\UserHomeFeed\Jobs\CacheUserRecommendationsInspiredByActivity;
use App\Jobs\CalculateUserFingerprint;
use App\Jobs\UpdateUserPropertiesOnClevertap;
use App\Models\UserArticlesAction;
use App\Repository\UsersWeeklyRoundup\UsersWeeklyRoundupInterface;
use App\Services\FingerPrint\FingerPrintFactory;

class LibraryDeletedListener
{

    /**
     * @var UsersWeeklyRoundupInterface
     */
    private $usersWeeklyRoundup;

    // public function __construct(
    //     // UsersWeeklyRoundupInterface $usersWeeklyRoundup
    //     )
    // {
    //     // $this->usersWeeklyRoundup = $usersWeeklyRoundup;
    // }

    /**
     * Handle the event.
     *
     * @param LibraryDeletedEvent $event
     * @return void
     */
    public function handle(LibraryDeletedEvent $event)
    {
        $library = $event->library;
        $user = $library->user;
        $version = $user->version;

        return "Listener Works";

        /*
        CalculateUserFingerprint::dispatch(FingerPrintFactory::USER_BOOKMARK_DELETED, $library, ['version' => $version])
            ->onConnection('redis')
            ->onQueue('fingerprint');

        UpdateUserPropertiesOnClevertap::dispatch($user->sso_id, $version)->onQueue('clevertap');

        if ($version == 'new') {
            UserArticlesAction::where('user_id', $library->user_id)
                              ->where('new_article_id', $library->getOriginal('new_article_id'))
                              ->where('action_performed', 'book_marked')
                              ->delete();
            $this->usersWeeklyRoundup->deletePendingRoundup($library->user_id, $library->getOriginal('new_article_id'));
        } else {
            UserArticlesAction::where('user_id', $library->user_id)
                              ->where('article_id', $library->getOriginal('article_id'))
                              ->where('action_performed', 'book_marked')
                              ->delete();
        }

        CacheUserRecommendationsInspiredByActivity::dispatch($library->user_id,
            $version)->onConnection('redis')->onQueue('realtime_user_activity_recommendations');
            */
    }
}
