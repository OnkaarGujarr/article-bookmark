<?php

namespace Tests\Unit;
 
use PHPUnit\Framework\TestCase;
use OnkaarGujarr\Library\Models\Library;

class LibraryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_delete_bookmark_test()
    {
        $bookmark = Library::first();
        if($bookmark){
            $bookmark->delete();
        }
        $this->assertTrue(true);
    }

    // /api/v4/users/articles/:article_id/library

    public function it_stores_bookmark()
    {
        $response = $this->post('/api/v4/users/articles/11f96d5d7ada37bb9419de81d943ad7f/library',[
                'user_id'=>2,
                'version'=>'new',
                "source"=>"feed",
                "article_id"=>'11f96d5d7ada37bb9419de81d943ad7f'
        ]);
        $response->assertEquals(['message'=>'Saved to library'],$response)
    }

    public function it_stores_bookmark()
    {
        $response = $this->delete('/api/v4/users/articles/11f96d5d7ada37bb9419de81d943ad7f/library',[
                'user_id'=>2,
                'version'=>'new',
                "source"=>"feed",
                "article_id"=>'11f96d5d7ada37bb9419de81d943ad7f'
        ]);
        $response->assertEquals(['message'=>'Removed from library'],$response)
    }
}