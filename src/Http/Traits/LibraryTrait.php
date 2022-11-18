<?php
namespace onkaargujarr\library\Http\Traits;

use OnkaarGujarr\Library\Services\Library\LibraryService;

// use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

trait LibraryTrait
{
    public function getAllLibrary(Request $request, LibraryService $libraryService)
    {
        $user = $request->user();
        $version = $user->version;

        $articles = $libraryService
            ->setUserId($user->id)
            ->getBookmarks($request->only('count', 'offset', 'sort_by', 'order_by'), $version);
        return [
            'totalHits' => $libraryService->getCountBookmarksForUser($user->id, $version),
            'data'      => $articles
        ];
    }
    
    public function saveToLibrary(Request $request, LibraryService $libraryService, $articleId)
    {
        $user = $request->user();
        $version = $user->version;
        $this->validateArticleId($articleId, $version);
        $source = json_decode($request->getContent(), true);
        $libraryService->setUserId((int) $user->id)->storedd($articleId, $source, $version);
        return response()->json('Saved to library');
    }

    public function removeFromLibrary(Request $request, LibraryService $libraryService, $articleId)
    {
        $user = $request->user();
        $version = $user->version;
        $this->validateArticleId($articleId, $version);
        $libraryService->setUserId((int) $user->id)->remove($articleId, $version);
        return response()->json('Removed from library');
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
