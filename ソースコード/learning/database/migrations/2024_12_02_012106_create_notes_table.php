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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->comment('ユーザーID');
            $table->bigInteger('category_id')->comment('カテゴリーID');
            $table->string('title')->comment('タイトル');
            $table->text('content')->comment('本文');
            $table->text('keyword')->comment('キーワード');
            $table->date('registration_date')->comment('登録日');
            $table->integer('is_deleted')->comment('削除フラグ');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
