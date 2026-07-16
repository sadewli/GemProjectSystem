<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Merges tbl_create_company_contacts into tbl_create_contact.
     */
    public function up()
    {
        // Guard check in case tables are missing
        if (!Schema::hasTable('tbl_create_contact') || !Schema::hasTable('tbl_create_company_contacts')) {
            return;
        }

        // Add 'is_primary' column if it doesn't exist
        if (!Schema::hasColumn('tbl_create_contact', 'is_primary')) {
            Schema::table('tbl_create_contact', function (Blueprint $table) {
                $table->boolean('is_primary')->default(0)->after('company_id');
            });
        }

        // Migrate rows from tbl_create_company_contacts to tbl_create_contact
        $companyContacts = DB::table('tbl_create_company_contacts')->get();

        foreach ($companyContacts as $contact) {
            // Check if matching contact already exists to ensure idempotency
            $exists = DB::table('tbl_create_contact')
                ->where('company_id', $contact->tbl_create_company_idtbl_create_company)
                ->where('first_name', $contact->first_name)
                ->where('last_name', $contact->last_name)
                ->where('email', $contact->email)
                ->exists();

            if ($exists) {
                continue;
            }

            // Calculate next reference format P-1xx
            $nextId = 1;
            $latestRef = DB::table('tbl_create_contact')
                ->where('reference', 'like', 'P-%')
                ->orderByRaw('CAST(SUBSTRING(reference, 3) AS UNSIGNED) DESC')
                ->value('reference');
            if ($latestRef) {
                $num = intval(substr($latestRef, 2));
                $nextId = ($num - 100) + 1;
            } else {
                $latest = DB::table('tbl_create_contact')->latest('idtbl_create_contact')->first();
                if ($latest) {
                    $nextId = $latest->idtbl_create_contact + 1;
                }
            }
            $reference = 'P-' . (100 + $nextId);

            DB::table('tbl_create_contact')->insert([
                'first_name' => $contact->first_name,
                'last_name' => $contact->last_name,
                'reference' => $reference,
                'email' => $contact->email,
                'role' => $contact->role,
                'company_id' => $contact->tbl_create_company_idtbl_create_company,
                'is_primary' => $contact->primary ?? 0,
                'status' => 1,
                'created_at' => $contact->created_at ?? now(),
                'updated_at' => $contact->updated_at ?? now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     * No-op as migrated contacts become indistinguishable from standalone ones.
     */
    public function down()
    {
        // No-op
    }
};
