<?php

use App\Models\Damage;
use App\Models\Phone;
use App\Models\Sparepart;
use App\Models\Technician;
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
        Schema::create('services', function (Blueprint $table) {
            $table->char('id')->primary();
            // $table->string('slug')->unique();
            $table->float('subtotal');
            $table->float('total');
            $table->text('address');
            $table->enum('status', ['Service', 'Waiting Service', 'Done', 'Waiting owner']);
            $table->text('description');
            $table->char('phone_id')->index();
            $table->char('user_id')->index();
            $table->char('technician_id')->index();
            $table->char('damage_id')->index();
            $table->char('sparepart_id')->index();
            $table->char('counter_id')->index();
            $table->foreign('phone_id')->references('id')->on('phones')->constrained();
            $table->foreign('user_id')->references('id')->on('users')->constrained();
            $table->foreign('technician_id')->references('id')->on('technicians')->constrained();
            $table->foreign('damage_id')->references('id')->on('damages')->constrained();
            $table->foreign('sparepart_id')->references('id')->on('spareparts')->constrained();
            $table->foreign('counter_id')->references('id')->on('counters')->constrained();
            // $table->foreignIdFor(Phone::class)->constrained();
            // $table->foreignIdFor(User::class)->constrained();
            // $table->foreignIdFor(Technician::class)->constrained();
            // $table->foreignIdFor(Damage::class)->nullable()->constrained();
            // $table->foreignIdFor(Sparepart::class)->constrained();
            $table->date('start_waranty');
            $table->date('end_waranty');
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
        Schema::dropIfExists('services');
    }
};
