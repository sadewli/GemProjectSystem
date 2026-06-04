<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\Country;
use App\Models\State;
use App\Models\PhoneCode;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactsMasterDataIntegrationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that active Roles, Countries, States, and PhoneCodes are rendered dynamically in CRM contacts page.
     */
    public function test_crm_contacts_contains_dynamic_master_data()
    {
        // 1. Seed dynamic master data
        $role = Role::create([
            'role_name' => 'Lead Gemologist',
            'value' => 'lead_gemologist',
            'status' => 1,
            'sort_order' => 100,
        ]);

        $country = Country::create([
            'idtbl_country' => 'TST',
            'country_name' => 'Testistan Country',
            'value' => 'testistan_country',
            'status' => 1,
            'sort_order' => 100,
        ]);

        $state = State::create([
            'idtbl_state' => 'TSS',
            'state_name' => 'Test State Province',
            'idtbl_country' => 'TST',
            'value' => 'test_state_province',
            'status' => 1,
            'sort_order' => 100,
        ]);

        $phoneCode = PhoneCode::create([
            'idtbl_phone_code' => 'ZZ',
            'country_name' => 'Testistan Phone',
            'phone_code' => '+999',
            'status' => 1,
        ]);

        $response = $this->get('/crm/contacts');

        $response->assertStatus(200);

        // Verify the dynamic options are rendered in the HTML
        $response->assertSee('Lead Gemologist');
        $response->assertSee('lead_gemologist');

        $response->assertSee('Testistan Country');
        $response->assertSee('testistan_country');

        $response->assertSee('Test State Province');
        $response->assertSee('test_state_province');

        $response->assertSee('+999');
        $response->assertSee('Testistan Phone');
    }
}
