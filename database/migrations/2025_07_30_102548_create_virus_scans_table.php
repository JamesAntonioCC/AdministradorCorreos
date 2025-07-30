<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('virus_scans', function (Blueprint $table) {
            $table->id();
            $table->string('email_id')->nullable(); // ID del email en el sistema de correo
            $table->string('sender_email');
            $table->string('recipient_email');
            $table->string('subject')->nullable();
            $table->enum('scan_result', ['clean', 'threat_detected', 'suspicious', 'error'])->default('clean');
            $table->string('threat_type')->nullable(); // virus, malware, phishing, spam, etc.
            $table->string('threat_name')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_hash')->nullable();
            $table->string('scan_engine')->default('ClamAV');
            $table->boolean('quarantined')->default(false);
            $table->timestamp('scanned_at');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['scan_result', 'scanned_at']);
            $table->index(['sender_email', 'scanned_at']);
            $table->index(['quarantined', 'scanned_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('virus_scans');
    }
};
