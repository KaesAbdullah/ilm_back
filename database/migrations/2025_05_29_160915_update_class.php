<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('class_user', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            $table->dropForeign(['clase_id']);

            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('clase_id')->references('id')->on('classes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('class_user', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            $table->dropForeign(['clase_id']);

            $table->foreign('usuario_id')->references('id')->on('users');
            $table->foreign('clase_id')->references('id')->on('classes');
        });
    }
};
