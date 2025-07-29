<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('email_aliases', function (Blueprint $table) {
            $table->id();
            $table->string('alias_email');
            $table->foreignId('mailbox_id')->constrained()->onDelete('cascade');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique('alias_email');
            $table->index(['alias_email', 'active']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_aliases');
    }
};
