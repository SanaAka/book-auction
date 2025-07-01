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
        Schema::table('auctions', function (Blueprint $table) {
            // This adds a new boolean column named 'ending_soon_notification_sent'
            // with a default value of 'false' after the 'winner_id' column.
            $table->boolean('ending_soon_notification_sent')->default(false)->after('winner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            // This will remove the column if the migration is ever rolled back.
            $table->dropColumn('ending_soon_notification_sent');
        });
    }
};