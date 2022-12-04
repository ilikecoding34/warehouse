<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uniquename',
        'serialnumber',
        'quantity',
        'minimumlevel',
        'price',
        'picture_id',
        'type_id'
        ];

    /**
     * The roles that belong to the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function customfields()
    {
        return $this->belongsToMany(Customfield::class, 'item_customfields')->withPivot('id', 'value')->withTimeStamps();
    }

    public function getUsedCustomfieldIds()
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

    /**
     * The roles that belong to the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_categories');
    }

    /**
     * Get the user that owns the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function getLatestQuantity()
    {
        return $this->hasMany(Quantity::class)->latest();
    }

}
