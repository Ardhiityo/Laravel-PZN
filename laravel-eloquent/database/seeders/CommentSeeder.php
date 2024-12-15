<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Products;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comment = new Comment();
        $comment->email = "pzn@gmail.com";
        $comment->title = "Lama pengiriman";
        $comment->comment = "Cepat";
        $comment->commentable_id = "p001";
        $comment->commentable_type = "product";
        $comment->save();

        $comment2 = new Comment();
        $comment2->email = "pzn@gmail.com";
        $comment2->title = "Lama pengiriman";
        $comment2->comment = "Lumayan";
        $comment2->commentable_id = "p001";
        $comment2->commentable_type = "product";
        $comment2->save();

        $comment3 = new Comment();
        $comment3->email = "pzn@gmail.com";
        $comment3->title = "Voucher Belanja";
        $comment3->comment = "Gratis ongkir";
        $comment3->commentable_id = "v001";
        $comment3->commentable_type = "voucher";
        $comment3->save();
    }
}
