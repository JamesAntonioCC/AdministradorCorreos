<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VirusScan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'email_id',
        'sender_email',
        'recipient_email',
        'subject',
        'message_content',
        'attachment_name',
        'attachment_content',
        'scan_result',
        'threat_type',
        'threat_name',
        'file_name',
        'file_hash',
        'scan_engine',
        'quarantined',
        'scanned_at',
    ];

    protected $casts = [
        'quarantined' => 'boolean',
        'scanned_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    // Scopes
    public function scopeClean($query)
    {
        return $query->where('scan_result', 'clean');
    }

    public function scopeThreats($query)
    {
        return $query->where('scan_result', '!=', 'clean');
    }

    public function scopeQuarantined($query)
    {
        return $query->where('quarantined', true);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('scanned_at', today());
    }

    // Accessors
    public function getResultTextAttribute()
    {
        return match($this->scan_result) {
            'clean' => 'Limpio',
            'threat_detected' => 'Amenaza Detectada',
            'suspicious' => 'Sospechoso',
            'error' => 'Error',
            default => 'Desconocido'
        };
    }

    public function getThreatTypeTextAttribute()
    {
        return match($this->threat_type) {
            'virus' => 'Virus',
            'malware' => 'Malware',
            'spam' => 'Spam',
            'phishing' => 'Phishing',
            'suspicious' => 'Sospechoso',
            default => $this->threat_type ? ucfirst($this->threat_type) : 'No especificado'
        };
    }

    public function getThreatTypeIconAttribute()
    {
        $icons = [
            'spam' => 'fas fa-envelope-open-text',
            'virus' => 'fas fa-bug',
            'malware' => 'fas fa-skull-crossbones',
            'phishing' => 'fas fa-fish',
            'suspicious' => 'fas fa-exclamation-triangle',
            'threat_detected' => 'fas fa-exclamation-triangle',
        ];

        return $icons[$this->threat_type] ?? $icons[$this->scan_result] ?? 'fas fa-exclamation-triangle';
    }

    public function getScanResultBadgeAttribute()
    {
        $badges = [
            'clean' => 'bg-green-100 text-green-800',
            'spam' => 'bg-yellow-100 text-yellow-800',
            'virus' => 'bg-red-100 text-red-800',
            'malware' => 'bg-red-100 text-red-800',
            'phishing' => 'bg-orange-100 text-orange-800',
            'suspicious' => 'bg-yellow-100 text-yellow-800',
            'threat_detected' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->threat_type] ?? $badges[$this->scan_result] ?? 'bg-gray-100 text-gray-800';
    }

    public function getThreatDisplayNameAttribute()
    {
        return $this->threat_name ?? $this->threat_type_text ?? 'Amenaza no especificada';
    }

    public function getFileNameDisplayAttribute()
    {
        return $this->attachment_name ?? $this->file_name ?? 'Sin archivo adjunto';
    }

    public function getFileExtensionAttribute()
    {
        $fileName = $this->attachment_name ?? $this->file_name;
        return $fileName ? strtolower(pathinfo($fileName, PATHINFO_EXTENSION)) : null;
    }

    public function getFileTypeDescriptionAttribute()
    {
        $extension = $this->file_extension;
        
        return match($extension) {
            'exe' => 'Archivo Ejecutable',
            'pdf' => 'Documento PDF',
            'doc', 'docx' => 'Documento Word',
            'xls', 'xlsx' => 'Hoja de Cálculo Excel',
            'txt' => 'Archivo de Texto',
            'zip', 'rar', '7z' => 'Archivo Comprimido',
            'jpg', 'jpeg', 'png', 'gif', 'bmp' => 'Imagen',
            'mp3', 'wav', 'ogg' => 'Archivo de Audio',
            'mp4', 'avi', 'mkv' => 'Archivo de Video',
            'html', 'htm' => 'Página Web',
            'js' => 'Script JavaScript',
            'php' => 'Script PHP',
            'bat', 'cmd' => 'Script de Lotes',
            'scr' => 'Protector de Pantalla',
            'pif' => 'Archivo de Información de Programa',
            default => $extension ? 'Archivo .' . strtoupper($extension) : 'Tipo Desconocido'
        };
    }
}
