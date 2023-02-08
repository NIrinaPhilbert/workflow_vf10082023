<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tool extends Model
{
    protected $table = 'tools';
    protected $fillable = [
        'name', 'description','status',
    ];

    public function type_requests()
    {
        return $this->belongsToMany('App\type_request')->withTimestamps();
        
    }
    public function Requestwfs(){
        return $this->hasMany('App\Requestwf');
    }
    public static function getLibelleToolbyId($toolId){
        $zRes = "";
        $result = DB::table('tools')
                    ->select('tools.name as tool_name')
                    ->where('tools.id','=',$toolId)
                    ->get();
        foreach($result as $tool)
        {
            $zRes = $tool->tool_name;
        }
        return $zRes;

    }
}
