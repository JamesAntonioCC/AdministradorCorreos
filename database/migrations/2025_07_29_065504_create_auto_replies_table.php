<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('auto_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mailbox_id')->constrained()->onDelete('cascade');
            $table->string('subject');
            $table->text('message');
            $table->boolean('active')->default(true);
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['mailbox_id', 'active']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('auto_replies');
    }
};
