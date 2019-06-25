<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OurPatient
 *
 * @package App
 * @property string $huduma_no
 * @property string $f_no
 * @property string $m_no
 * @property string $l_name
 * @property string $dob
 * @property string $email
 * @property string $photo
 * @property string $telephone
 * @property string $address
 * @property text $diagnostic
 * @property text $prescription
*/
class OurPatient extends Model
{
    use SoftDeletes;

    protected $fillable = ['huduma_no', 'f_no', 'm_no', 'l_name', 'dob', 'email', 'photo', 'telephone', 'address', 'diagnostic', 'prescription'];
    protected $hidden = [];
    
    
    public static function boot()
    {
        parent::boot();

        OurPatient::observe(new \App\Observers\UserActionsObserver);
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setDobAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['dob'] = Carbon::createFromFormat(config('app.date_format') . ' H:i:s', $input)->format('Y-m-d H:i:s');
        } else {
            $this->attributes['dob'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getDobAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format') . ' H:i:s');

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $input)->format(config('app.date_format') . ' H:i:s');
        } else {
            return '';
        }
    }
    
}
