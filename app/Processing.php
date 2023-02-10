<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Processing extends Model
{
    protected $fillable = [
        'requestwf_id ', 'etat_id', 'owner_request_user_id', 'sender_request_user_id' , 'process_comment', 'is_finished',
    ];
    public static function getListProcessingByUserId($user_id)
    {
        $toListProcessing = DB::table('processings')
        ->join('requestwfs','requestwfs.id','=','processings.requestwf_id')
        ->join('type_requests','type_requests.id', '=', 'requestwfs.type_request_id')
        ->join('tools','tools.id', '=', 'requestwfs.tool_id')
        ->join('process_users','process_users.process_id','=','processings.id')
        ->select('requestwfs.id as idrequest','processings.id as idprocessings','processings.is_finished as is_finished','requestwfs.subject as Objetwf',
        'requestwfs.user_id as usersourceid','tools.name as toolname','tools.id as idtool','type_requests.id as idtyperequest',
        'type_requests.name as type_requestname',
        'requestwfs.created_at as created_at')
        ->where('processings.is_finished',0)
        ->where('process_users.user_id',$user_id)
        ->orWhere('processings.is_finished',2)
        ->orderBy('processings.id','DESC')
        ->get(); 
        return $toListProcessing ;       
    }
}
