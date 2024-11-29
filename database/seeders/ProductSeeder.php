<?php

namespace Database\Seeders;

use App\Models\Product\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $images = [
            'https://images.tcdn.com.br/img/img_prod/1165503/noticia_20317946706584bc1310128.png',
            'https://static.wixstatic.com/media/9ec495_eff07b3e6caa46d6990e31cf9010cfdd~mv2.jpg/v1/crop/x_0,y_11,w_1004,h_765/fill/w_364,h_268,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/Cupcakes%201.jpg',
            'https://www.mamacida.com.br/image/cache/data/dia-das-criancas/cupcake-dia-das-criancas-650x650.jpg',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQEzmrSPYMmRt0CeEScLSNoJo9jjj3xhJJmyw&s',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTwtPkf3W9euVc5nqsH_O4_6sQSz3sVgQ-G5Q&s',
            'https://media.istockphoto.com/id/177047298/pt/foto/cupcakes-colorido.jpg?s=612x612&w=0&k=20&c=GFkCOyCyWxQNB5lgZttp0H3UzmSslcTP1qabaveYJu0=',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTtw-ExzHnJaeHTLidhpqb5AsG0ZKVH27M2ZQ&s',
            'https://guiadacozinha.com.br/wp-content/uploads/2020/01/cupcake-destaque.jpg'
        ];

        foreach ($images as $image) {
            $fileContent = file_get_contents($image);

            $path = Storage::disk('public')->put('products', $fileContent);

            Product::factory()->create([
                'imagePath' => $path,
            ]);
        }
    }
}
