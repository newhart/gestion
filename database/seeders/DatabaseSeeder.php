<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Company;
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
        // \App\Models\User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@shop.com',
        //     // password => 'password'
        // ]);  migraion laravel vue js comment faire une pagination ==> haritiana randria
        $this->migrateProduct();
    }

    private function migrateProduct()
    {
        $products =  CsvService::readCSV('app/producs.csv');

        foreach ($products as $product) {
            $category = $this->findOrCreateCategory($product['ItemGroup']);
            $company = $this->findOrCreateCompany($product['ItemCompany']);
            Product::create([
                'name' => $product['ItemName'],
                'category_id' => $category->id,
                'company_id' => $company->id,
                'code' => $product['ItemCode'],
                'price' => $product['ItemPPrice'] !== 'NULL' ? $product['ItemPPrice'] :  0.00,
                'stock_quantity' => 1,
                'stock_alert' => $product['ItemReqLimit'],
                'notes' => $product['ItemNote']
            ]);
        }
    }

    private function findOrCreateCategory(string $category_name)
    {
        $category  = Category::where('name', $category_name)->first();
        if (!$category) {
            $category = Category::create(['name' => $category_name]);
        }
        return $category;
    }

    private function findOrCreateCompany(string $company_name)
    {
        $company  = Company::where('name', $company_name)->first();
        if (!$company) {
            $company = Company::create(['name' => $company_name]);
        }
        return $company;
    }
}
