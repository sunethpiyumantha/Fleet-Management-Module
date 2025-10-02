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
        Schema::create('request_processes', function (Blueprint $table) {
            $table->id();
            $table->string('req_id'); // e.g., 'AB021' - foreign key reference to VehicleRequestApproval serial_number (index it if needed)
            $table->foreignId('from_user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->integer('from_establishment_id'); // Signed int to match e_id
            $table->foreign('from_establishment_id')->references('e_id')->on('establishments')->onDelete('cascade');
            $table->foreignId('to_user_id')->nullable()->constrained('users', 'id');
            $table->integer('to_establishment_id')->nullable(); // Signed int to match e_id
            $table->foreign('to_establishment_id')->references('e_id')->on('establishments')->onDelete('cascade');
            $table->text('remark')->nullable(); // e.g., 'Sir, pls', 'Appd pls', 'Approved', 'Action pls'
            $table->enum('status', ['pending', 'approved', 'rejected', 'forwarded'])->default('pending');
            $table->timestamp('processed_at')->nullable(); // Renamed from 'date' for clarity; use for the step's date
            $table->timestamps();

            // Indexes for performance on queries by req_id and status
            $table->index(['req_id', 'status']);
            $table->index('processed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_processes');
    }
};