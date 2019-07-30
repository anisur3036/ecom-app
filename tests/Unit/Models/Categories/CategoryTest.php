<?php

namespace Tests\Unit\Models\Categories;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_many_children()
    {
    	$category = factory(Category::class)->create();

    	$category->children()->save(
    		factory(Category::class)->create()
    	);

    	$this->assertInstanceOf(Category::class, $category->children->first());
    }


    public function test_it_can_fetch_only_parents()
    {
    	$category = factory(Category::class)->create();

    	$category->children()->save(
    		factory(Category::class)->create()
    	);

    	$this->assertEquals(1, Category::parents()->count());
    }


    public function test_it_is_oderable_by_a_numbered_order()
    {
    	$category1 = factory(Category::class)->create([
    		'order' => 2
    	]);

    	$category2 = factory(Category::class)->create([
    		'order' => 1
    	]);

    	$this->assertEquals($category2->name, Category::ordered()->first()->name);
    }
}
