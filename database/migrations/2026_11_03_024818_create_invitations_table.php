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
       Schema::create('invitations', function (Blueprint $table) {
            $table->id();

            // Company the invited user will join
            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            // User who sent the invitation
            $table->foreignId('invited_by')
                ->constrained('users')
                ->cascadeOnDelete();

            // Email address of the invited user
            $table->string('email');

            // Intended role: Admin or Member
            $table->string('role');

            // Store a secure hash of the invitation token
            $table->string('token_hash', 64)->unique();

            // Invitation expiry and acceptance status
            $table->timestamp('expires_at');
            $table->timestamp('accepted_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
