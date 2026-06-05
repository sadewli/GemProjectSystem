<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CompanyType;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyTypeContactFilterTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that active company types are rendered dynamically in CRM contacts filter dropdown.
     */
    public function test_crm_contacts_contains_dynamic_company_types()
    {
        // Seed an active company type
        $companyType = CompanyType::create([
            'company_type' => 'Custom Laboratory Type',
            'value' => 'custom_laboratory_type',
            'status' => 1,
            'sort_order' => 8888,
        ]);

        $response = $this->get('/crm/contacts');

        $response->assertStatus(200);

        // Verify the dynamic company type option is rendered in the dropdown
        $response->assertSee('Custom Laboratory Type');
        $response->assertSee('custom_laboratory_type');
    }
}
