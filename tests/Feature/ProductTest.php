<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function status_ok()
    {
        $response = $this->get('/api/product');

        $response->assertStatus(200);
    }


    public function test_original_price_equals_to_discount_price_when_discount_is_null()
    {
        $response = $this->get('/api/product');

        $content = $response->getContent();

        $responses = json_decode($content, true);

        foreach ($responses['results'] as $item) {
            if ($item['price']['discount_percentage'] == null) {
                self::assertEquals($item['price']['original'], $item['price']['final']);
            }
        }
    }


    public function test_if_category_is_boots_discount_is_30()
    {
        $response = $this->get('/api/product');

        $content = $response->getContent();

        $responses = json_decode($content, true);

        foreach ($responses['results'] as $item) {
            if ($item['category'] == ProductController::BOOT_CATEGORY) {
                self::assertEquals("30%", $item['price']['discount_percentage']);
            }
        }
    }

    public function test_if_sku_Is_0003_discount_is_15()
    {
        $response = $this->get('/api/product');

        $content = $response->getContent();

        $responses = json_decode($content, true);

        foreach ($responses['results'] as $item) {

            if ($item['sku'] == ProductController::SKU and $item['category'] !== ProductController::BOOT_CATEGORY) {
                self::assertEquals("15%", $item['price']['discount_percentage']);
            }
        }
    }
}
