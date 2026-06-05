<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds any missing columns to tbl_create_contact used by the CRUD.
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_create_contact')) {
            // If table does not exist, create minimal table with primary key.
            Schema::create('tbl_create_contact', function (Blueprint $table) {
                $table->bigIncrements('idtbl_create_contact');
                $table->timestamps();
            });
        }

        Schema::table('tbl_create_contact', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_create_contact', 'first_name')) {
                $table->string('first_name', 150)->nullable()->after('idtbl_create_contact');
            }
            if (!Schema::hasColumn('tbl_create_contact', 'last_name')) {
                $table->string('last_name', 150)->nullable()->after('first_name');
            }
            if (!Schema::hasColumn('tbl_create_contact', 'reference')) {
                $table->string('reference', 50)->nullable()->after('last_name');
            }
            if (!Schema::hasColumn('tbl_create_contact', 'contact_type')) {
                $table->string('contact_type', 50)->nullable()->after('reference');
            }
            if (!Schema::hasColumn('tbl_create_contact', 'email')) {
                $table->string('email', 255)->nullable()->after('contact_type');
            }
            if (!Schema::hasColumn('tbl_create_contact', 'phone_code')) {
                $table->string('phone_code', 20)->nullable()->after('email');
            }
            if (!Schema::hasColumn('tbl_create_contact', 'phone')) {
                $table->string('phone', 50)->nullable()->after('phone_code');
            }
            if (!Schema::hasColumn('tbl_create_contact', 'owned_by')) {
                $table->unsignedBigInteger('owned_by')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('tbl_create_contact', 'role')) {
                $table->string('role', 100)->nullable()->after('owned_by');
            }
            if (!Schema::hasColumn('tbl_create_contact', 'profile_image')) {
                $table->string('profile_image')->nullable()->after('role');
            }
            if (!Schema::hasColumn('tbl_create_contact', 'address_line1')) {
                $table->string('address_line1')->nullable()->after('profile_image');
            }
            if (!Schema::hasColumn('tbl_create_contact', 'address_line2')) {
                $table->string('address_line2')->nullable()->after('address_line1');
            }
            if (!Schema::hasColumn('tbl_create_contact', 'address_line3')) {
                $table->string('address_line3')->nullable()->after('address_line2');
            }
            if (!Schema::hasColumn('tbl_create_contact', 'country')) {
                $table->string('country', 100)->nullable()->after('address_line3');
            }
            if (!Schema::hasColumn('tbl_create_contact', 'state')) {
                $table->string('state', 100)->nullable()->after('country');
            }
            if (!Schema::hasColumn('tbl_create_contact', 'postal_code')) {
                $table->string('postal_code', 50)->nullable()->after('state');
            }
            if (!Schema::hasColumn('tbl_create_contact', 'company_id')) {
                $table->unsignedBigInteger('company_id')->nullable()->after('postal_code');
            }
            if (!Schema::hasColumn('tbl_create_contact', 'status')) {
                $table->string('status', 50)->nullable()->after('company_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     * This will only drop columns that were added by this migration if they exist.
     */
    public function down()
    {
        if (!Schema::hasTable('tbl_create_contact')) {
            return;
        }

        Schema::table('tbl_create_contact', function (Blueprint $table) {
            $cols = [
                'first_name','last_name','reference','contact_type','email','phone_code','phone',
                'owned_by','role','profile_image','address_line1','address_line2','address_line3',
                'country','state','postal_code','company_id','status'
            ];
            foreach ($cols as $c) {
                if (Schema::hasColumn('tbl_create_contact', $c)) {
                    $table->dropColumn($c);
                }
            }
        });
    }
};
