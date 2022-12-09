<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;

    protected $table = 'withdraw_gateways';

    protected $guarded = [];

    protected $casts = [
        'user_data' => 'array'
    ];

    public function withdrawLogs()
    {
        return $this->hasMany(WithdrawLog::class,'withdraw_gateway_id');
    }
    
}
