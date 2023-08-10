<?php

namespace Tests\Feature;

use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CustomerControllerTest extends TestCase {

    use DatabaseMigrations;

    private Generator $faker;

    /** @before */
    public function init(): void {
        $this->faker = $this->getFaker();
    }

    public function testController_ShouldSaveCustomer(): void {
        $customerData = [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'birth_date' => $this->faker->date(),
            'email' => $this->faker->email(),
        ];

        $response = $this->postJson('/api/customers', $customerData);
        $response
            ->assertSuccessful()
            ->assertJson([
                'status' => 'created',
                'customer' => $customerData
            ]);

        $this->assertDatabaseCount('customers', 1);
    }

    public function testController_ShouldRetrieveCustomer(): void {
        $customerData = [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'birth_date' => $this->faker->date(),
            'email' => $this->faker->email(),
        ];

        $response = $this->postJson('/api/customers', $customerData);

        $this->assertDatabaseCount('customers', 1);

        $customerId = $response->json('customer')['id'];

        $response = $this->getJson("/api/customers/$customerId");
        $response
            ->assertStatus(200)
            ->assertJson(array_merge(['id' => $customerId], $customerData));
    }

    public function testController_ShouldRetrieveAllCustomers(): void {
        $firstCustomer = [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'birth_date' => $this->faker->date(),
            'email' => $this->faker->email(),
        ];

        $secondCustomer = [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'birth_date' => $this->faker->date(),
            'email' => $this->faker->email(),
        ];

        $this->postJson('/api/customers', $firstCustomer);
        $this->postJson('/api/customers', $secondCustomer);

        $response = $this->getJson('/api/customers');

        $this->assertCount(2, $response->json());
    }

    public function testController_ShouldUpdateCustomer(): void {
        $customerData = [
            'first_name' => 'Fulano',
            'last_name' => 'de Tal',
            'birth_date' => $this->faker->date(),
            'email' => $this->faker->email(),
        ];

        $response = $this->postJson('/api/customers', $customerData);
        $customerResponseData = $response->json('customer');

//        $this->assertEquals('Fulano', $customerResponseData['first_name']);
//        $this->assertEquals('de Tal', $customerResponseData['last_name']);

        $this->assertDatabaseHas('customers', $customerResponseData);

        $customerId = $customerResponseData['id'];

        $customerUpdatingData = [
            'first_name' => 'Cicrano',
            'last_name' => 'Sei La das Quantas'
        ];

        $response = $this->putJson("/api/customers/$customerId", $customerUpdatingData);
        $customerResponseData = $response->json('customer');

//        $this->assertEquals('Cicrano', $customerResponseData['first_name']);
//        $this->assertEquals('Sei La das Quantas', $customerResponseData['last_name']);

        $this->assertDatabaseHas('customers', $customerResponseData);
    }

    public function testController_ShouldDeleteCustomer(): void {
        $customerData = [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'birth_date' => $this->faker->date(),
            'email' => $this->faker->email(),
        ];

        $response = $this->postJson('/api/customers', $customerData);

        $this->assertDatabaseCount('customers', 1);

        $customerId = $response->json('customer')['id'];

        $this->deleteJson("/api/customers/$customerId");

        $this->assertDatabaseCount('customers', 0);
    }
}
