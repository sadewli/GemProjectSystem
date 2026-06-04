<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Country;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CountryCrudTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that Countries Master page loads successfully and displays countries.
     */
    public function test_countries_master_page_loads_and_displays_countries()
    {
        // Seed a temporary country
        $country = Country::create([
            'idtbl_country' => 'FR',
            'country_name' => 'France',
            'value' => 'France',
            'status' => 1,
            'sort_order' => 10,
        ]);

        $response = $this->get('/Master/Country');

        $response->assertStatus(200);
        $response->assertSee('France');
    }

    /**
     * Test Country insertion/updating.
     */
    public function test_can_create_and_update_country()
    {
        // Create country via POST
        $response = $this->post('/Master/Countryinsertupdate', [
            'recordOption' => 1, // 1 = Create
            'idtbl_country' => 'JP',
            'country_name' => 'Japan',
            'value' => 'Japan',
            'sort_order' => 5,
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('tbl_country', [
            'idtbl_country' => 'JP',
            'country_name' => 'Japan',
            'value' => 'Japan',
        ]);

        // Find the created country to update it
        $country = Country::where('idtbl_country', 'JP')->first();

        // Update it
        $responseUpdate = $this->post('/Master/Countryinsertupdate', [
            'recordOption' => 2, // 2 = Edit
            'recordID' => $country->idtbl_country,
            'country_name' => 'Japan Updated',
            'value' => 'Japan Updated',
            'sort_order' => 6,
        ]);

        $responseUpdate->assertRedirect();

        $this->assertDatabaseHas('tbl_country', [
            'idtbl_country' => 'JP',
            'country_name' => 'Japan Updated',
            'value' => 'Japan Updated',
        ]);
    }

    /**
     * Test Country status toggle.
     */
    public function test_can_toggle_country_status()
    {
        $country = Country::create([
            'idtbl_country' => 'DE',
            'country_name' => 'Germany',
            'value' => 'Germany',
            'status' => 1,
            'sort_order' => 9,
        ]);

        // Deactivate (current status is 1)
        $response = $this->get("/Master/Countrystatus/{$country->idtbl_country}/1");

        $response->assertRedirect();
        $this->assertDatabaseHas('tbl_country', [
            'idtbl_country' => 'DE',
            'status' => 0,
        ]);

        // Activate (current status is 0)
        $response = $this->get("/Master/Countrystatus/{$country->idtbl_country}/0");

        $response->assertRedirect();
        $this->assertDatabaseHas('tbl_country', [
            'idtbl_country' => 'DE',
            'status' => 1,
        ]);
    }

    /**
     * Test CRM Companies integration.
     */
    public function test_crm_companies_contains_dynamic_countries()
    {
        // Seed an active country
        $country = Country::create([
            'idtbl_country' => 'CA',
            'country_name' => 'Canada',
            'value' => 'Canada',
            'status' => 1,
            'sort_order' => 15,
        ]);

        $response = $this->get('/crm/companies');

        $response->assertStatus(200);

        // Verify the dynamic country is rendered in the dropdown
        $response->assertSee('Canada');
    }
}
