<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('forwarders', function (Blueprint $table) {
            $table->id();
            $table->string('source_email');
            $table->string('destination_email');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique('source_email');
            $table->index(['source_email', 'active']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('forwarders');
    }
};
