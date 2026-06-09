<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Web Developer',
            'Business Analyst',
            'Data Analyst',
            'Software Engineer',
            'HR Executive',
            'Digital Marketing Executive',
            'Internship Opportunities',
            'Full-Time Opportunities',
        ];

        foreach ($categories as $index => $name) {
            JobCategory::withoutGlobalScopes()->updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                    'organization_id' => null,
                ]
            );
        }
    }
}
