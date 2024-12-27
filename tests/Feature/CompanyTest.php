<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_index_with_paginated_response(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['view-tasks']
        );

        // Send GET request to index endpoint
        $response = $this->getJson('/api/companies');

        // Assert response status and structure
        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'data' => [
                'current_page',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'phone',
                        'address',
                    ],
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ],
            'message',
        ]);
    }
}
