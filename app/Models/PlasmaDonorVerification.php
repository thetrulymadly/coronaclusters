<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PlasmaDonorVerification extends Model
{
    protected $table = 'plasma_donor_verifications';
    public $timestamps = true;

    protected $fillable = [
        'donor_id',
        'phone_number',
        'otp',
        'gateway_name',
        'gateway_response',
        'verified_at'
    ];

    public function donorData()
    {
        return $this->belongsTo(PlasmaDonor::class, 'donor_id', 'id');
    }

}