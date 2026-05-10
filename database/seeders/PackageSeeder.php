<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run(): void
    {
        $packages = [
            [
                'name' => 'Starter Package',
                'price' => 5,
                'description' => 'Basic starter package suitable for beginners.',
            ],
            [
                'name' => 'Bronze Package',
                'price' => 10,
                'description' => 'Affordable package with essential features.',
            ],
            [
                'name' => 'Silver Package',
                'price' => 25,
                'description' => 'Mid-level package with added benefits.',
            ],
            [
                'name' => 'Gold Package',
                'price' => 50,
                'description' => 'Premium package designed for growing users.',
            ],
            [
                'name' => 'Platinum Package',
                'price' => 100,
                'description' => 'Advanced package with premium support.',
            ],
            [
                'name' => 'Business Package',
                'price' => 150,
                'description' => 'Business-focused package with extra tools.',
            ],
            [
                'name' => 'Enterprise Package',
                'price' => 250,
                'description' => 'Enterprise-grade package for large organizations.',
            ],
            [
                'name' => 'Ultimate Package',
                'price' => 500,
                'description' => 'Complete package with all premium features.',
            ],
            [
                'name' => 'VIP Package',
                'price' => 750,
                'description' => 'Exclusive VIP package with dedicated support.',
            ],
            [
                'name' => 'Diamond Package',
                'price' => 1000,
                'description' => 'Top-tier package offering maximum value.',
            ],
        ];

        foreach ($packages as $package) {
            Package::firstOrCreate(['name'=>$package['name']],$package);
        }
    }
}
