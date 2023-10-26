<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Interfaces\DataSourceInterface;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUsersWithFilters()
    {
        $mockDataSource = $this->createMock(DataSourceInterface::class);
        $this->app->instance(DataSourceInterface::class, $mockDataSource);
        
        // Make a request to the endpoint with filter parameters
        $response = $this->json('GET', 'api/v1/users', [
            // 'provider' => 'DataProviderX',
            // 'statusCode' => 'test_status',
            'balanceMin' => 0,
            'balanceMax' => 200,
            'currency' => 'EGP',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ]);
        // ->assertJson([
        //     'status' => true,
        //     'message' => 'Data retrieved successfully',
        //     'data' => [
        //         [
        //             "parentEmail" => "parent2@parent.eu",
        //             "amount" => 100,
        //             "currency" => "EGP",
        //             "statusCode" => "decline",
        //             "created_at" => "2018-11-30",
        //             "id" => "d3d29d70-1d25-11e3-8591-034165a3a613",
        //             "provider" => "DataProviderX"
        //         ]
        //     ]
        // ]);
    }
}
