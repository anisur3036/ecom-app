<?php

namespace Tests\Feature\Categories;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryIndexText extends TestCase
{
    
    public function test_it_return_collection_of_categories()
    {
        $categories = factory(Category::class, 2)->create();

        $response = $this->json('GET', 'api/categories');

        $categories->each(function($category) use ($response) {
            $response->assertJsonFragment([
                'slug' => $category->slug,
            ]);
        });
    }

    public function test_it_return_only_parents()
    {
        $category = factory(Category::class)->create();
        
        $category->children()->save(
            factory(Category::class)->create()
        );

        $this->json('GET', 'api/categories')
            ->assertJsonCount(1, 'data');
    }

    public function test_it_return_order_by_given_order()
    {
        $category1 = factory(Category::class)->create([
            'order' => 2
        ]);

        $category2 = factory(Category::class)->create([
            'order' => 1
        ]);

        $this->json('GET', 'api/categories')
            ->assertSeeInOrder([
                $category2->slug, $category1->slug
            ]);
    }
}
