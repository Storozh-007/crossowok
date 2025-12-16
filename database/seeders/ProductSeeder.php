<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Створюємо категорії, якщо їх ще нема
        $categories = [
            'Nike' => 'nike',
            'Adidas' => 'adidas',
            'New Balance' => 'new-balance',
            'Puma' => 'puma'
        ];

        foreach ($categories as $name => $slug) {
            Category::firstOrCreate([
                'slug' => $slug
            ], [
                'name' => $name,
                'description' => $name . ' sneakers'
            ]);
        }

        // Масив тестових товарів
        $products = [
            [
                'name' => 'Nike Air Max 270',
                'slug' => 'nike-air-max-270',
                'description' => 'Легка та стильна модель з максимальним комфортом.',
                'price' => 4800,
                'image' => 'products/test1.svg',
                'category_slug' => 'nike'
            ],
            [
                'name' => 'Nike Dunk Low Panda',
                'slug' => 'nike-dunk-low-panda',
                'description' => 'Одна з найпопулярніших моделей у світі.',
                'price' => 5200,
                'image' => 'products/test2.svg',
                'category_slug' => 'nike'
            ],
            [
                'name' => 'Nike Air Force 1 White',
                'slug' => 'air-force-1-white',
                'description' => 'Культова класика, яка пасує до всього.',
                'price' => 4500,
                'image' => 'products/test3.svg',
                'category_slug' => 'nike'
            ],
            [
                'name' => 'Adidas Yeezy 350 V2 Zebra',
                'slug' => 'yeezy-350-v2-zebra',
                'description' => 'Легендарна модель Yeezy з унікальним дизайном.',
                'price' => 8200,
                'image' => 'products/test4.svg',
                'category_slug' => 'adidas'
            ],
            [
                'name' => 'Adidas Superstar Classic',
                'slug' => 'adidas-superstar',
                'description' => 'Невичерпна класика бренду Adidas.',
                'price' => 3900,
                'image' => 'products/test5.svg',
                'category_slug' => 'adidas'
            ],
            [
                'name' => 'New Balance 550 White Green',
                'slug' => 'nb-550-white-green',
                'description' => 'Одна з наймодніших моделей 2024 року.',
                'price' => 5400,
                'image' => 'products/test6.svg',
                'category_slug' => 'new-balance'
            ],
            [
                'name' => 'New Balance 530 Silver',
                'slug' => 'nb-530-silver',
                'description' => 'Комфорт та стиль у кожному кроці.',
                'price' => 5100,
                'image' => 'products/test7.svg',
                'category_slug' => 'new-balance'
            ],
            [
                'name' => 'Puma RS-X Bold',
                'slug' => 'puma-rsx-bold',
                'description' => 'Яскравий дизайн та сучасні технології.',
                'price' => 3800,
                'image' => 'products/test8.svg',
                'category_slug' => 'puma'
            ]
        ];

        // Повторимо товари до 20
        for ($i = 1; $i <= 20; $i++) {
            $p = $products[array_rand($products)];

            Product::create([
                'name' => $p['name'] . ' #' . $i,
                'slug' => $p['slug'] . '-' . $i,
                'description' => $p['description'],
                'price' => $p['price'],
                'image' => $p['image'],
                'category_id' => Category::where('slug', $p['category_slug'])->first()->id,
            ]);
        }
    }
}
