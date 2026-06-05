<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CreateCompany;
use App\Models\CreateCompanyContact;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;

class CompaniesCrudTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        // Mock a logged-in user in session
        Session::put('userid', 1);
        Session::put('loggedin', true);
    }

    /**
     * Test CRM Companies list page loads and displays companies.
     */
    public function test_companies_page_loads_and_displays_companies()
    {
        $company = CreateCompany::create([
            'name' => 'Acme Corporation',
            'reference' => 'Comp-999',
            'status' => 'active',
        ]);

        $response = $this->get('/crm/companies');

        $response->assertStatus(200);
        $response->assertSee('Acme Corporation');
        $response->assertSee('Comp-999');
    }

    /**
     * Test company and contacts creation.
     */
    public function test_can_create_company_with_contacts()
    {
        $response = $this->post('/crm/companies', [
            'name' => 'Tech Solutions Ltd',
            'company_type' => 'customer',
            'email' => 'contact@techsolutions.com',
            'phone' => '1234567890',
            'status' => 'active',
            'contacts' => [
                [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'email' => 'john@techsolutions.com',
                    'role' => 'Manager',
                    'primary' => '1',
                ]
            ]
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('tbl_create_company', [
            'name' => 'Tech Solutions Ltd',
            'email' => 'contact@techsolutions.com',
        ]);

        $company = CreateCompany::where('name', 'Tech Solutions Ltd')->first();
        $this->assertNotNull($company);

        $this->assertDatabaseHas('tbl_create_company_contacts', [
            'tbl_create_company_idtbl_create_company' => $company->idtbl_create_company,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@techsolutions.com',
        ]);
    }

    /**
     * Test fetching company details as JSON for editing.
     */
    public function test_can_fetch_company_details_for_edit()
    {
        $company = CreateCompany::create([
            'name' => 'Fetch test',
            'reference' => 'Comp-998',
        ]);

        $contact = CreateCompanyContact::create([
            'tbl_create_company_idtbl_create_company' => $company->idtbl_create_company,
            'first_name' => 'Alice',
            'email' => 'alice@fetch.com',
        ]);

        $response = $this->get("/crm/companies/{$company->idtbl_create_company}");

        $response->assertStatus(200);
        $response->assertJsonPath('name', 'Fetch test');
        $response->assertJsonPath('contacts.0.first_name', 'Alice');
    }

    /**
     * Test updating company details and contacts.
     */
    public function test_can_update_company_and_contacts()
    {
        $company = CreateCompany::create([
            'name' => 'Old Tech Corp',
            'reference' => 'Comp-997',
            'status' => 'active',
        ]);

        CreateCompanyContact::create([
            'tbl_create_company_idtbl_create_company' => $company->idtbl_create_company,
            'first_name' => 'Old Contact',
            'email' => 'old@tech.com',
        ]);

        $response = $this->put("/crm/companies/{$company->idtbl_create_company}", [
            'name' => 'New Tech Corp',
            'company_type' => 'partner',
            'email' => 'new@tech.com',
            'contacts' => [
                [
                    'first_name' => 'New Contact',
                    'last_name' => 'Person',
                    'email' => 'newcontact@tech.com',
                    'role' => 'CEO',
                    'primary' => '1',
                ]
            ]
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('tbl_create_company', [
            'idtbl_create_company' => $company->idtbl_create_company,
            'name' => 'New Tech Corp',
            'company_type' => 'partner',
        ]);

        // Old contact should be deleted
        $this->assertDatabaseMissing('tbl_create_company_contacts', [
            'first_name' => 'Old Contact',
        ]);

        // New contact should be inserted
        $this->assertDatabaseHas('tbl_create_company_contacts', [
            'tbl_create_company_idtbl_create_company' => $company->idtbl_create_company,
            'first_name' => 'New Contact',
            'role' => 'CEO',
        ]);
    }

    /**
     * Test deleting a company.
     */
    public function test_can_delete_company_and_relations()
    {
        $company = CreateCompany::create([
            'name' => 'Delete Me Ltd',
            'reference' => 'Comp-996',
        ]);

        CreateCompanyContact::create([
            'tbl_create_company_idtbl_create_company' => $company->idtbl_create_company,
            'first_name' => 'Bob',
        ]);

        $response = $this->delete("/crm/companies/{$company->idtbl_create_company}");

        $response->assertRedirect();

        $this->assertDatabaseMissing('tbl_create_company', [
            'idtbl_create_company' => $company->idtbl_create_company,
        ]);

        $this->assertDatabaseMissing('tbl_create_company_contacts', [
            'tbl_create_company_idtbl_create_company' => $company->idtbl_create_company,
        ]);
    }
}
