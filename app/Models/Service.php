<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    public $timestamps = true;

    // protected $keyType = 'string';

    protected $fillable = [
        'id',
        'slug',
        'subtotal',
        'total',
        'status',
        'address',
        'description',
        'phone_id',
        'user_id',
        'technician_id',
        'damage_id',
        'service_id',
        'sparepart_id',
        'start_waranty',
        'end_waranty',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function phone(): BelongsTo
    {
        return $this->BelongsTo(Phone::class);
    }

    public function damage(): BelongsTo
    {
        return $this->BelongsTo(Damage::class);
    }

    public function technician(): BelongsTo
    {
        return $this->BelongsTo(Technician::class);
    }

    public function sparepart(): BelongsTo
    {
        return $this->BelongsTo(Sparepart::class);
    }

    public function counter(): BelongsTo
    {
        return $this->BelongsTo(Counter::class);
    }
}
