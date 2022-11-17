<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['uniquename', 'serialnumber', 'quantity_id', 'minimumlevel', 'price', 'picture_id'];

    /**
     * The roles that belong to the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function types()
    {
        return $this->belongsToMany(Type::class, 'item_type')->withPivot('id', 'value')->withTimeStamps();
    }

    public function getUsedTypeIds()
    {
        return $this->belongsToMany(Type::class, 'item_type');
    }

    /**
     * Get the picture that owns the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function picture()
    {
        return $this->belongsTo(Picture::class, 'picture_id');
    }

    public function quantity()
    {
        return $this->hasMany(Quantity::class);
    }

    public function getLatestQuantity()
    {
        return $this->hasMany(Quantity::class)->latest();
    }

}
