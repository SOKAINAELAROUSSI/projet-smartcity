<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('technician_profiles', function (Blueprint $table) {
            $table->string('availability_status')->default('disponible');
            $table->boolean('notif_new_mission')->default(true);
            $table->boolean('notif_admin_messages')->default(true);
            $table->boolean('notif_urgent_missions')->default(true);
            $table->string('theme')->default('light');
            $table->string('language')->default('fr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('technician_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'availability_status',
                'notif_new_mission',
                'notif_admin_messages',
                'notif_urgent_missions',
                'theme',
                'language'
            ]);
        });
    }
};
