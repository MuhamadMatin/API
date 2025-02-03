<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sparepart extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    public $timestamps = true;

    // protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        // 'slug',
        'price',
        'stock',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
