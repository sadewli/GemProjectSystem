<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\PhoneCode;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PhoneCodeIntegrationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that active phone codes are rendered dynamically in CRM companies dropdown.
     */
    public function test_crm_companies_contains_dynamic_phone_codes()
    {
        // Seed an active phone code
        $phoneCode = PhoneCode::create([
            'idtbl_phone_code' => 'ZZ',
            'country_name' => 'ZzCountry',
            'phone_code' => '+999',
            'status' => 1,
            'sort_order' => 9999,
        ]);

        // Accessor checks
        $this->assertEquals('🇿🇿', $phoneCode->flag_emoji);

        $response = $this->get('/crm/companies');

        $response->assertStatus(200);

        // Verify the dynamic phone code option is rendered in the dropdown
        $response->assertSee('🇿🇿');
        $response->assertSee('+999');
        $response->assertSee('ZzCountry');
    }
}
