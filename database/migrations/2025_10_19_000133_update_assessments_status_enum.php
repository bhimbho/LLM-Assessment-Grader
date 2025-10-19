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
        // First, we need to drop the existing enum constraint
        DB::statement('ALTER TABLE assessments DROP CONSTRAINT IF EXISTS assessments_status_check');
        
        // Then alter the column to allow the new enum values
        DB::statement("ALTER TABLE assessments ALTER COLUMN status TYPE VARCHAR(20)");
        DB::statement("ALTER TABLE assessments ADD CONSTRAINT assessments_status_check CHECK (status IN ('pending', 'completed', 'failed'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement('ALTER TABLE assessments DROP CONSTRAINT IF EXISTS assessments_status_check');
        DB::statement("ALTER TABLE assessments ALTER COLUMN status TYPE VARCHAR(20)");
        DB::statement("ALTER TABLE assessments ADD CONSTRAINT assessments_status_check CHECK (status IN ('pending', 'completed'))");
    }
};