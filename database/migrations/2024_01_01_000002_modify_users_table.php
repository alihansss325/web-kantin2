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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'siswa'])->default('siswa')->after('id');
            $table->foreignId('school_id')->nullable()->after('role')->constrained()->onDelete('cascade');
            $table->string('nis', 20)->nullable()->unique()->after('email');
            $table->string('nisn', 20)->nullable()->unique()->after('nis');
            $table->string('class', 50)->nullable()->after('nisn');
            $table->string('phone', 20)->nullable()->after('class');
            $table->decimal('saldo', 12, 2)->default(0)->after('phone');
            $table->boolean('is_active')->default(true)->after('saldo');
            $table->timestamp('last_login_at')->nullable()->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'school_id', 'nis', 'nisn', 'class', 
                'phone', 'saldo', 'is_active', 'last_login_at'
            ]);
        });
    }
};
