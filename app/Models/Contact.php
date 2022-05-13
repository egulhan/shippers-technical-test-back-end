<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'is_primary',
        'name',
        'contact_number',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    public $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Shipper relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shipper()
    {
        return $this->belongsTo(Shipper::class);
    }

    /**
     * Filter by primary contacts.
     *
     * @param $query
     * @return mixed
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Pick the contact as primary.
     *
     * @return bool
     */
    public function pickAsPrimary()
    {
        $this->is_primary = true;
        return $this->save();
    }
}
