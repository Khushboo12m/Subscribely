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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('service_name'); // e.g. Netflix, Gym, etc.
            $table->string('category')->nullable(); // Entertainment, Utility, etc.
            $table->decimal('amount', 8, 2)->nullable(); // Subscription cost
            $table->string('billing_cycle'); // Monthly, Yearly, etc.
            $table->date('next_renewal_date'); // Next payment date
            $table->string('notification_email')->nullable(); // Where reminders go
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
