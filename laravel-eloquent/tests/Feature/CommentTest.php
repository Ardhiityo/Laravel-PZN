<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testTimestamps(): void
    {
        $comment = new Comment();
        $comment->email = "eko@.co";
        $comment->title = "testing";
        $comment->commentable_id = "p001";
        $comment->commentable_type = "product";
        $comment->save();

        self::assertNotNull($comment->created_at);
        self::assertNotNull($comment->updated_at);

        Log::info($comment);
    }

    public function testDefaultValue()
    {
        $comment = new Comment();
        $comment->title = "title";
        $comment->email = "eko@.co";
        $comment->commentable_id = "p001";
        $comment->commentable_type = "product";
        $comment->save();

        self::assertNotNull($comment->comment);

        Log::info($comment);
    }
}
