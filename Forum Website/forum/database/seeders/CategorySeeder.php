<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Genel'],
            ['name' => 'Teknoloji'],
            ['name' => 'Eğitim'],
            ['name' => 'Sağlık'],
            ['name' => 'Spor'],
            ['name' => 'Oyun'],
            ['name' => 'Bilim'],
            ['name' => 'Sanat'],
            ['name' => 'Müzik'],
            ['name' => 'Sinema'],
            ['name' => 'Edebiyat'],
            ['name' => 'Seyahat'],
            ['name' => 'Yemek'],
            ['name' => 'Hobi'],
            ['name' => 'İş Dünyası'],
            ['name' => 'Diğer'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
