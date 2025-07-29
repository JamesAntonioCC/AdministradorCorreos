<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mailboxes', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('quota')->nullable(); // MB, null = unlimited
            $table->bigInteger('storage_used')->default(0); // bytes
            $table->boolean('active')->default(true);
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['email', 'active']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('mailboxes');
    }
};
