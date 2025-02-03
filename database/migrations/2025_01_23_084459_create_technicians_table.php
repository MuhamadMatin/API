<?php

use App\Models\Counter;
use App\Models\User;
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
        Schema::create('technicians', function (Blueprint $table) {
            $table->char('id')->primary();
            $table->char('user_id')->index();
            $table->char('counter_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->constrained();
            $table->foreign('counter_id')->references('id')->on('counters')->constrained();
            // $table->foreignIdFor(User::class)->constrained();
            // $table->foreignIdFor(Counter::class)->constrained();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->softDeletes();
            $table->string('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technicians');
    }
};
