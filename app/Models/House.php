<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class House extends Model
{
    use HasFactory;
    use Searchable;
    // use SoftDeletes;
    protected $primaryKey ='id';
    protected $table = 'houses';
    public function searchableAs(){
        return 'houses_index';
    }
    
    protected $guarded =[];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',        
    ];


    public function images(){
    	return $this->hasMany('App\Models\Image');
    }

}
