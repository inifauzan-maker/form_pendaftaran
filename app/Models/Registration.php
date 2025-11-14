<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    public const STATUS_REGISTERED = 'Daftar';
    public const STATUS_PRESENT = 'Hadir';

    protected $fillable = [
        'full_name',
        'school',
        'phone',
        'study_location',
        'program',
        'class_level',
        'permission_letter_path',
        'permission_letter_original_name',
        'sequence_number',
        'unique_code',
        'qr_payload',
        'status',
        'attended_at',
    ];

    protected $casts = [
        'attended_at' => 'datetime',
    ];

    public function markAsPresent(): void
    {
        $this->forceFill([
            'status' => self::STATUS_PRESENT,
            'attended_at' => now(),
        ])->save();
    }
}
