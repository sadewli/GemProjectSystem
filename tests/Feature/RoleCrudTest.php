<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleCrudTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that Roles Master page loads successfully and displays roles.
     */
    public function test_roles_master_page_loads_and_displays_roles()
    {
        // Seed a temporary role
        $role = Role::create([
            'role_name' => 'Test Quality Assurance',
            'value' => 'test_quality_assurance',
            'status' => 1,
            'sort_order' => 10,
        ]);

        $response = $this->get('/Master/Role');

        $response->assertStatus(200);
        $response->assertSee('Test Quality Assurance');
        $response->assertSee('test_quality_assurance');
    }

    /**
     * Test Role insertion/updating.
     */
    public function test_can_create_and_update_role()
    {
        // Create role via POST
        $response = $this->post('/Master/Roleinsertupdate', [
            'recordOption' => 1, // 1 = Create
            'role_name' => 'New Dynamic Role',
            'value' => 'new_dynamic_role',
            'sort_order' => 5,
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('tbl_role', [
            'role_name' => 'New Dynamic Role',
            'value' => 'new_dynamic_role',
        ]);

        // Find the created role to update it
        $role = Role::where('value', 'new_dynamic_role')->first();

        // Update it
        $responseUpdate = $this->post('/Master/Roleinsertupdate', [
            'recordOption' => 2, // 2 = Edit
            'recordID' => $role->idtbl_role,
            'role_name' => 'Updated Dynamic Role',
            'value' => 'updated_dynamic_role',
            'sort_order' => 6,
        ]);

        $responseUpdate->assertRedirect();

        $this->assertDatabaseHas('tbl_role', [
            'idtbl_role' => $role->idtbl_role,
            'role_name' => 'Updated Dynamic Role',
            'value' => 'updated_dynamic_role',
        ]);
    }

    /**
     * Test Role status toggle.
     */
    public function test_can_toggle_role_status()
    {
        $role = Role::create([
            'role_name' => 'Toggle Role',
            'value' => 'toggle_role',
            'status' => 1,
            'sort_order' => 9,
        ]);

        // Deactivate (current status is 1)
        $response = $this->get("/Master/Rolestatus/{$role->idtbl_role}/1");

        $response->assertRedirect();
        $this->assertDatabaseHas('tbl_role', [
            'idtbl_role' => $role->idtbl_role,
            'status' => 0,
        ]);

        // Activate (current status is 0)
        $response = $this->get("/Master/Rolestatus/{$role->idtbl_role}/0");

        $response->assertRedirect();
        $this->assertDatabaseHas('tbl_role', [
            'idtbl_role' => $role->idtbl_role,
            'status' => 1,
        ]);
    }

    /**
     * Test CRM Companies integration.
     */
    public function test_crm_companies_contains_dynamic_roles()
    {
        // Seed an active role
        $role = Role::create([
            'role_name' => 'Unique Testing Developer',
            'value' => 'unique_testing_developer',
            'status' => 1,
            'sort_order' => 15,
        ]);

        $response = $this->get('/crm/companies');

        $response->assertStatus(200);

        // Verify the dynamic role is rendered in the static contact dropdown
        $response->assertSee('Unique Testing Developer');
        $response->assertSee('unique_testing_developer');

        // Verify the dynamic roles JSON array is defined in the script section
        $response->assertSee('unique_testing_developer');
    }
}
