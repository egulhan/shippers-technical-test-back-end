<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'company_name',
        'address',
    ];

    /**
     * Define contacts relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Define primary contact relationship.
     *
     * @return mixed
     */
    public function primaryContact()
    {
        return $this->hasOne(Contact::class)->primary();
    }
}
