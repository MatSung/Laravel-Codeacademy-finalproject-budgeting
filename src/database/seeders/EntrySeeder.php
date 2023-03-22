<?php

namespace Database\Seeders;

use App\Models\Entry;
use App\Models\EntryCategory;
use App\Models\EntrySubcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class EntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = EntryCategory::factory(6)->create();
        $subcategories = EntrySubcategory::factory(9)->state(new Sequence(
            [
                'parent_id' => $categories[0]->id,
            ],
            [
                'parent_id' => $categories[1]->id,
            ],
            [
                'parent_id' => $categories[2]->id,
            ],
        ))->create();

        Entry::factory(12)->state(new Sequence(
            [
                'category_id' => $categories[0]->id,
                'subcategory_id' => $subcategories[0]->id,
            ],
            [
                'category_id' => $categories[1]->id,
                'subcategory_id' => $subcategories[1]->id,
            ],
            [
                'category_id' => $categories[2]->id,
                'subcategory_id' => $subcategories[2]->id,
            ],
            [
                'category_id' => $categories[0]->id,
                'subcategory_id' => $subcategories[3]->id,
            ],
            [
                'category_id' => $categories[1]->id,
                'subcategory_id' => $subcategories[4]->id,
            ],
            [
                'category_id' => $categories[2]->id,
                'subcategory_id' => $subcategories[5]->id,
            ],
        ))->create();

        Entry::factory(5)->create();
    }
}
