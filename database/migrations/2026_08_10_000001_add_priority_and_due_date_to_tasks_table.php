<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::table('tasks', function (Blueprint $table) {
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('status');
            $table->date('due_date')->nullable()->after('priority');
            $table->index('priority');
        });
    }

    public function down(): void {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex(['priority']);
            $table->dropColumn(['priority', 'due_date']);
        });
    }
};
