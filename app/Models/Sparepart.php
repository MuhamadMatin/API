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

    // protected $keyType = 'string';

    // public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'price',
        'stock',
        'description',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
