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
        Schema::create('short_schedules', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->comment('ユーザーID');
            $table->bigInteger('long_schedule_id')->comment('長期目標ID');
            $table->string('short_term_goal_name')->comment('短期目標名');
            $table->date('registration_date')->comment('登録日');
            $table->date('exipire_date')->comment('期限日');
            $table->date('finished_date')->comment('終了日');
            $table->integer('is_deleted')->comment('削除フラグ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('short_schedules');
    }
};
