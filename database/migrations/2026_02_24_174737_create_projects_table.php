<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $projects = [
            ['name' => 'Website Redesign', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mobile App Development', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Database Migration', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'API Integration', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Security Audit', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('projects')->insert($projects);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
