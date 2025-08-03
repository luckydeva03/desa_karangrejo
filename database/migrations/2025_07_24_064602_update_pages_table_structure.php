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
        Schema::table('pages', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('pages', 'type')) {
                $table->string('type')->after('content'); // 'history', 'vision_mission', 'organization_structure'
            }
            if (!Schema::hasColumn('pages', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('status');
            }
            if (!Schema::hasColumn('pages', 'featured_image')) {
                $table->string('featured_image')->nullable()->after('meta_description');
            }
            if (!Schema::hasColumn('pages', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('featured_image');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            }
            
            // Modify existing columns
            if (Schema::hasColumn('pages', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->change();
            }
            
            // Add indexes
            $table->index(['type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropIndex(['type', 'status']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['type', 'meta_title', 'featured_image', 'user_id']);
        });
    }
};
