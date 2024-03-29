<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'business';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the Business currency.
     */
    public function currency()
    {
        return $this->belongsTo('App\Currency');
    }

    /**
     * Get the Business currency.
     */
    public function locations()
    {
        return $this->hasMany('App\BusinessLocation');
    }

    /**
     * Get the Business printers.
     */
    public function printers()
    {
        return $this->hasMany('App\Printer');
    }

    /**
     * Creates a new business based on the input provided.
     *
     * @return object
     */
    public static function create_business($details)
    {
        $business = Business::create($details);
        return $business;
    }

    /**
     * Updates a business based on the input provided.
     * @param int $business_id
     * @param array $details
     *
     * @return object
     */
    public static function update_business($business_id, $details)
    {
        if(!empty($details)){
            Business::where('id', $business_id)
                ->update($details);
        }
    }
}
