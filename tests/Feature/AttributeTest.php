<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AttributeTest extends TestCase
{
  /**
   * A basic feature test example.
   *
   * @return void
   */
  public function test_add_group()
  {
    $user = User::query()->find(1);
    $response = $this->actingAs($user, 'web')->post(route('store.product.group'), [
      'type' => 'select', // select, radio, image
      'name' => 'test',
      'is_color' => false
    ]);

    $response->assertStatus(200);
  }
}
