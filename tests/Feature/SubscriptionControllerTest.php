<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SubscriptionControllerTest extends TestCase
{
    public function testSubscribeEmailConfirmedReturnsSuccess(): void
    {
        $response = $this->postJson('/api/subscribe', [
            'email' => 'flaksie228@gmail.com',
            'url' => 'https://www.olx.ua/d/uk/obyavlenie/opt-ta-rozdrb-schlniy-ta-myakiy-pled-pokrivalona-lzhko-IDUappv.html?reason=hp%7Cpromoted'
        ]);

        $response->assertStatus(200)
                ->assertJson(['success' => true, 'message' => 'Subscribed new product for user']);

        $this->assertDatabaseHas('subscriptions', [
            'email' => 'flaksie228@gmail.com',
        ]);

        $this->assertDatabaseHas('products', [
            'url' => 'https://www.olx.ua/d/uk/obyavlenie/opt-ta-rozdrb-schlniy-ta-myakiy-pled-pokrivalona-lzhko-IDUappv.html?reason=hp%7Cpromoted',
        ]);
    }

    public function testSubscribeEmailNotConfirmedReturnsSuccess(): void
    {
        $response = $this->postJson('/api/subscribe', [
            'email' => 'test@gmail.com',
            'url' => 'https://www.olx.ua/d/uk/obyavlenie/opt-ta-rozdrb-schlniy-ta-myakiy-pled-pokrivalona-lzhko-IDUappv.html?reason=hp%7Cpromoted'
        ]);

        $response->assertStatus(403)
            ->assertJson(['success' => true, 'message' => 'Confirm your email before receiving subscription messages']);

        $this->assertDatabaseHas('subscriptions', [
            'email' => 'test@gmail.com',
        ]);

        $this->assertDatabaseHas('products', [
            'url' => 'https://www.olx.ua/d/uk/obyavlenie/opt-ta-rozdrb-schlniy-ta-myakiy-pled-pokrivalona-lzhko-IDUappv.html?reason=hp%7Cpromoted',
        ]);
    }

    public function testSubscribeInvalidEmail(): void
    {
        $response = $this->postJson('/api/subscribe', [
            'email' => 'test',
            'url' => 'https://www.olx.ua/d/uk/obyavlenie/opt-ta-rozdrb-schlniy-ta-myakiy-pled-pokrivalona-lzhko-IDUappv.html?reason=hp%7Cpromoted'
        ]);

        $response
            ->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) =>
            $json->has('error')
            ->missing('message'));
    }

    public function testSubscribeInvalidUrl(): void
    {
        $response = $this->postJson('/api/subscribe', [
            'email' => 'test@test.com',
            'url' => 'https://www.olx.ua'
        ]);

        $response
            ->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) =>
            $json->has('error')
                ->missing('message'));
    }
}
