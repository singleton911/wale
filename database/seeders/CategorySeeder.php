<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Solitary Treasures'],
            ['name' => 'CyberSecurity'],
            ['name' => 'Educational Resources'],
            ['name' => 'Web Development & Design'],
            ['name' => 'Precious Commodities'],
            ['name' => 'Substances'],
            ['name' => 'Goods & Services'],
            ['name' => 'Other Listings'],
            ['name' => 'Hacking & Spam', 'parent_category_id' => 2, 'category' => 'CyberSecurity'],
            ['name' => 'Fraud', 'parent_category_id' => 2, 'category' => 'CyberSecurity'],
            ['name' => 'Malware', 'parent_category_id' => 2, 'category' => 'CyberSecurity'],
            ['name' => 'Carded Items', 'parent_category_id' => 2, 'category' => 'CyberSecurity'],
            ['name' => 'Counterfeit Items', 'parent_category_id' => 2, 'category' => 'CyberSecurity'],
            ['name' => 'Security', 'parent_category_id' => 2, 'category' => 'CyberSecurity'],
            ['name' => 'Guides & Tutorials', 'parent_category_id' => 3, 'category' => 'Educational Resources'],
            ['name' => 'Software', 'parent_category_id' => 3, 'category' => 'Educational Resources'],
            ['name' => 'Hosting', 'parent_category_id' => 4, 'category' => 'Web Development & Design'],
            ['name' => 'Websites', 'parent_category_id' => 4, 'category' => 'Web Development & Design'],
            ['name' => 'Graphics Design', 'parent_category_id' => 4, 'category' => 'Web Development & Design'],
            ['name' => 'Jewels', 'parent_category_id' => 5, 'category' => 'Precious Commodities'],
            ['name' => 'Gold & Precious Metals', 'parent_category_id' => 5, 'category' => 'Precious Commodities'],
            ['name' => 'Drugs', 'parent_category_id' => 6, 'category' => 'Substances'],
            ['name' => 'Chemicals', 'parent_category_id' => 6, 'category' => 'Substances'],
            ['name' => 'Legitimate Items', 'parent_category_id' => 7, 'category' => 'Goods & Services'],
            ['name' => 'Automotive Items', 'parent_category_id' => 7, 'category' => 'Goods & Services'],
            ['name' => 'Digital Products', 'parent_category_id' => 7, 'category' => 'Goods & Services'],
            ['name' => 'Services', 'parent_category_id' => 7, 'category' => 'Goods & Services'],
        ];
        
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}