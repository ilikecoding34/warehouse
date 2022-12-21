<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uniquename',
        'serialnumber',
        'minimumlevel',
        'price',
        'type',
        'quantity',
        'company',
        'location',
        'description',
        'created_by_user',
        'updated_by_user',
        ];

    //protected $appends = ['quantity_value'];

    protected static function booted()
    {
        /*
        static::addGlobalScope('quantity_value', function ($query) {
            $query->withQuantityValue();
        });
        */

        static::updating(function ($item) {
            $details = $item->getDirty();

            foreach ($details as $key => $value) {
                $value = $value ?? 0;
                DB::insert('insert into item_changes (item_id, user_name, changedcolumn, changeddata, created_at, updated_at) values (?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)', [$item->id, auth()->user()->name, $key, $value]);
            }
        });

    }

    /**
     * The roles that belong to the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function customfields()
    {
        return $this->belongsToMany(Customfield::class)->withPivot('id', 'value')->withTimeStamps();
    }

    public function quantities()
    {
        return $this->hasMany(Quantity::class)->latest();
    }

    /**
     * The roles that belong to the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_category');
    }

    /**
     * The pictures that belong to the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pictures()
    {
        return $this->belongsToMany(Picture::class);
    }

    public function getLatestQuantity()
    {
        return $this->hasOne(Quantity::class)->latestOfMany();
    }
/*
    public function getQuantityValueAttribute()
    {
        return Quantity::where('item_id', $this->id)->orderBy('id', 'desc')->first()->value ?? 0;
    }
    */
/*
    public function scopeWithQuantityValue($query)
    {
        $query->addSelect(['quantity_value' => Quantity::select('value')
            ->whereColumn('item_id', 'items.id')
            ->latest()
            ->take(1)
        ]);
    }*/

}
