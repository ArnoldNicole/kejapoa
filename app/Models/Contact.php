<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',        
    ];
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function followers()
        {
            return $this->belongsToMany('App\Models\User');
        }
}
