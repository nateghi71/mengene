<?php

namespace Tests\Feature\contractRealState\Rent;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RentContractTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreatePage(): void
    {
        $response = $this->get('/contract_rent/create');

        $response->assertStatus(200);
    }
}
