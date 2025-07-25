<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Nasi Goreng',
                'description' => 'Nasi goreng spesial dengan telur dan ayam',
                'price' => 15000,
                'stock' => 100,
                'category_id' => 1,
            ],
            [
                'name' => 'Es Teh Manis',
                'description' => 'Teh manis dingin',
                'price' => 5000,
                'stock' => 200,
                'category_id' => 2,
            ],
            [
                'name' => 'Keripik Kentang',
                'description' => 'Keripik kentang renyah',
                'price' => 10000,
                'stock' => 150,
                'category_id' => 3,
            ],
            [
                'name' => 'Mie Ayam',
                'description' => 'Mie ayam dengan topping ayam cincang',
                'price' => 12000,
                'stock' => 80,
                'category_id' => 1,
            ],
            [
                'name' => 'Ayam Geprek',
                'description' => 'Ayam goreng dengan sambal geprek',
                'price' => 17000,
                'stock' => 70,
                'category_id' => 1,
            ],
            [
                'name' => 'Bakso Urat',
                'description' => 'Bakso urat dengan kuah gurih',
                'price' => 16000,
                'stock' => 90,
                'category_id' => 1,
            ],
            [
                'name' => 'Es Jeruk',
                'description' => 'Jeruk segar dingin',
                'price' => 6000,
                'stock' => 120,
                'category_id' => 2,
            ],
            [
                'name' => 'Teh Tarik',
                'description' => 'Teh dengan susu khas Malaysia',
                'price' => 8000,
                'stock' => 100,
                'category_id' => 2,
            ],
            [
                'name' => 'Kopi Hitam',
                'description' => 'Kopi robusta tanpa gula',
                'price' => 7000,
                'stock' => 100,
                'category_id' => 2,
            ],
            [
                'name' => 'Kopi Susu',
                'description' => 'Kopi dengan susu kental manis',
                'price' => 9000,
                'stock' => 100,
                'category_id' => 2,
            ],
            [
                'name' => 'Donat Cokelat',
                'description' => 'Donat dengan taburan cokelat meleleh',
                'price' => 5000,
                'stock' => 100,
                'category_id' => 3,
            ],
            [
                'name' => 'Roti Bakar Keju',
                'description' => 'Roti bakar isi keju dan susu',
                'price' => 10000,
                'stock' => 90,
                'category_id' => 3,
            ],
            [
                'name' => 'Tahu Crispy',
                'description' => 'Tahu goreng renyah dengan bumbu pedas',
                'price' => 7000,
                'stock' => 150,
                'category_id' => 3,
            ],
            [
                'name' => 'Sosis Bakar',
                'description' => 'Sosis bakar dengan saus BBQ',
                'price' => 8000,
                'stock' => 120,
                'category_id' => 3,
            ],
            [
                'name' => 'Seblak Kuah',
                'description' => 'Seblak pedas isi kerupuk dan sosis',
                'price' => 13000,
                'stock' => 60,
                'category_id' => 1,
            ],
            [
                'name' => 'Spaghetti Bolognese',
                'description' => 'Spaghetti dengan saus daging tomat',
                'price' => 18000,
                'stock' => 50,
                'category_id' => 1,
            ],
            [
                'name' => 'Jus Alpukat',
                'description' => 'Alpukat segar dengan cokelat',
                'price' => 12000,
                'stock' => 70,
                'category_id' => 2,
            ],
            [
                'name' => 'Jus Mangga',
                'description' => 'Jus mangga segar tanpa gula',
                'price' => 10000,
                'stock' => 80,
                'category_id' => 2,
            ],
            [
                'name' => 'Cireng Bumbu Rujak',
                'description' => 'Cireng goreng dengan sambal rujak',
                'price' => 8000,
                'stock' => 100,
                'category_id' => 3,
            ],
            [
                'name' => 'Martabak Mini',
                'description' => 'Martabak isi cokelat atau keju',
                'price' => 10000,
                'stock' => 100,
                'category_id' => 3,
            ],
            [
                'name' => 'Nasi Ayam Teriyaki',
                'description' => 'Nasi dengan ayam bumbu teriyaki',
                'price' => 19000,
                'stock' => 60,
                'category_id' => 1,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
