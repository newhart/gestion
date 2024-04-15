<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use App\Services\CsvService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@shop.com',
            // 'password' => 'password'
        ]);
        // $this->migrateProduct();
    }

    private function migrateProduct()
    {
        $products =  CsvService::readCSV('app/products.csv');

        foreach ($products as $product) {
            $category = $this->findOrCreateCategory($product['Nom Famille Père du Produit'], $product['Nom Famille Produit']);
            Product::create([
                'name' => $product['Nom du Produit'],
                'category_id' => $category->id,
                'code' => $product['IDproduit'],
                'price' => $product['Prix de Vente'] && $product['Prix de Vente'] !== 'NULL' ? $this->formatPrice($product['Prix de Vente']) :  0.00,
                'stock_quantity' =>  (int)preg_replace('/[^0-9.]/', '', $product['Stock']),
                'stock_alert' => 5,
            ]);
        }
    }

    private function formatPrice($price)
    {
        return (float)preg_replace('/[^0-9.]/', '', $price);
    }

    private function findOrCreateCategory(string $category_name, string $sub_category_name)
    {
        $category  = Category::where('name', $category_name)->first();
        $sub_category = null;
        if (!$category) {
            $category = Category::create(['name' => $category_name]);
            $sub_category = Category::where('name', $sub_category_name)->where('category_id', $category->id)->first();
            if (!$sub_category) {
                $sub_category = Category::create([
                    'name' => $sub_category_name,
                    'category_id' => $category->id
                ]);
            }
        }
        return $category;
    }
}
