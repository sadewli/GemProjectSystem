<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\State;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StateCrudTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that States Master page loads successfully and displays states.
     */
    public function test_states_master_page_loads_and_displays_states()
    {
        // Seed a temporary state
        $state = State::create([
            'idtbl_state' => 'SAB-TEST-1',
            'state_name' => 'Sabara Province Test',
            'value' => 'sabara_province_test',
            'status' => 1,
            'sort_order' => 10,
        ]);

        $response = $this->get('/Master/State');

        $response->assertStatus(200);
        $response->assertSee('Sabara Province Test');
        $response->assertSee('sabara_province_test');
    }

    /**
     * Test State insertion/updating.
     */
    public function test_can_create_and_update_state()
    {
        // Create state via POST
        $response = $this->post('/Master/Stateinsertupdate', [
            'recordOption' => 1, // 1 = Create
            'idtbl_state' => 'SAB-PROV',
            'state_name' => 'New Dynamic Province',
            'value' => 'new_dynamic_province',
            'sort_order' => 5,
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('tbl_state', [
            'state_name' => 'New Dynamic Province',
            'value' => 'new_dynamic_province',
        ]);

        // Find the created state to update it
        $state = State::where('value', 'new_dynamic_province')->first();

        // Update it
        $responseUpdate = $this->post('/Master/Stateinsertupdate', [
            'recordOption' => 2, // 2 = Edit
            'recordID' => $state->idtbl_state,
            'state_name' => 'Updated Dynamic Province',
            'value' => 'updated_dynamic_province',
            'sort_order' => 6,
        ]);

        $responseUpdate->assertRedirect();

        $this->assertDatabaseHas('tbl_state', [
            'idtbl_state' => $state->idtbl_state,
            'state_name' => 'Updated Dynamic Province',
            'value' => 'updated_dynamic_province',
        ]);
    }

    /**
     * Test State status toggle.
     */
    public function test_can_toggle_state_status()
    {
        $state = State::create([
            'idtbl_state' => 'TOGGLE-TEST',
            'state_name' => 'Toggle Province',
            'value' => 'toggle_province',
            'status' => 1,
            'sort_order' => 9,
        ]);

        // Deactivate (current status is 1)
        $response = $this->get("/Master/Statestatus/{$state->idtbl_state}/1");

        $response->assertRedirect();
        $this->assertDatabaseHas('tbl_state', [
            'idtbl_state' => $state->idtbl_state,
            'status' => 0,
        ]);

        // Activate (current status is 0)
        $response = $this->get("/Master/Statestatus/{$state->idtbl_state}/0");

        $response->assertRedirect();
        $this->assertDatabaseHas('tbl_state', [
            'idtbl_state' => $state->idtbl_state,
            'status' => 1,
        ]);
    }

    /**
     * Test CRM Companies integration.
     */
    public function test_crm_companies_contains_dynamic_states()
    {
        // Seed an active state
        $state = State::create([
            'idtbl_state' => 'CRM-TEST',
            'state_name' => 'Unique Testing Province',
            'value' => 'unique_testing_province',
            'status' => 1,
            'sort_order' => 15,
        ]);

        $response = $this->get('/crm/companies');

        $response->assertStatus(200);

        // Verify the dynamic state is rendered in the dropdown
        $response->assertSee('Unique Testing Province');
        $response->assertSee('unique_testing_province');
    }
}
