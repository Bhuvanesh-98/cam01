<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['user_data' => 'array'];

    public function withdraw()
    {
        return $this->belongsTo(Withdraw::class,'withdraw_gateway_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
