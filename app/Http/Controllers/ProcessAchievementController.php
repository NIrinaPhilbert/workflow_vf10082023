<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper as Helper;
use Mail;
use App\Tool;
use App\Processing;
use App\Requestwf;
use App\Request_history;
use App\User;
use App\Process_achievement;
use App\validation_request;
use Illuminate\Support\Facades\DB;
use Session;

class ProcessAchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // /*DropzoneJS
    public function postDataProcess() {
        $user_id = Auth::id();
        $target_dir = public_path()."/target-files-process/".$user_id."/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        if (isset($_FILES['file']) && !empty($_FILES['file'])) {

            //$file = $request->file('file');
            //$filename = time().'.'.$file->getClientOriginalExtension();

            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $return = (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) ? array("success"=>true) : array("success"=>false);
            echo json_encode($return);
            exit();
        }
        if (isset($_POST) && count($_POST)) {
            $post = $_POST;
            if (isset($post['ext_action']) && $post['ext_action'] == "delete_files") {
                if (!empty($post['filenames'])) {
                    foreach ($post['filenames'] as $key => $file) {
                        $target_file = $target_dir . $file;
                        if (file_exists($target_file)) @unlink($target_file);
                    }
                }
                echo json_encode(array("success"=>true));
                exit();
            }
        }
    }
    // DropzoneJS*/
    public function finalizerequest(Request $request)
    {
        $user_id = Auth::id();
        //$id = $_POST['param_request'];
        $param_process = $_POST['param_process'];//idprocess+idrequest
        $tzParam_process = explode('_',$param_process);
        $idprocess = $tzParam_process[0];
        $idrequest = $tzParam_process[1];
        $process_status = $_POST['process_status'];
        $process_date = $_POST['process_date'];
        $comment_process = $_POST['comment_process'];
        //si status traitement == 1
        if($process_status == 1){//traitement fini immediat

            DB::table('processings')
            ->where('requestwf_id', $idrequest)
            ->update(['is_finished' => 1]);

               
            DB::table('requestwfs')
            ->where('id', $idrequest)
            ->update(['status_id' => 3]);
        }

        $toRequestwf = Requestwf::getRequestById($idrequest) ;
        $zRequestNom = $toRequestwf[0]->Objet ;
        $zUserOwnerEmail = $toRequestwf[0]->useremail ;

        $subject = "Notification demande traitée" ;
        $header = "Notification demande traité" ;
        $zMessageNotificationOtherDes = "La demande <b>" . $zRequestNom . "</b> a bien été traitée.";
        $zMessageNotificationOwner = "Votre demande <b>" . $zRequestNom . "</b> a bien été traitée.";

        $QueryListeMailDestinationNotification = DB::table('requestwf_email_addresses')
                    ->join('reply_email_addresses','reply_email_addresses.id','=','requestwf_email_addresses.reply_email_address_id')
                    ->select('reply_email_addresses.rea_email as mailaddress')
                    ->where('requestwf_email_addresses.requestwf_id','=',$idrequest)
                    ->get();
        // Send mail notification for other destination
        foreach ($QueryListeMailDestinationNotification as $omailaddress){
            //echo "adresse_mail=".$mailaddress;



            Helper::sendnotification($omailaddress->mailaddress,$subject,$header,$zMessageNotificationOtherDes, "contact@snis-sante.net");
            sleep(2) ; //A VOIR!!

        }
        Helper::sendnotification($zUserOwnerEmail,$subject,$header,$zMessageNotificationOwner, "contact@snis-sante.net") ;
    }
    public function store(Request $request)
    {
        $user_id = Auth::id();
        //$id = $_POST['param_request'];
        $param_process = $_POST['param_process'];//idprocess+idrequest
        $tzParam_process = explode('_',$param_process);
        $idprocess = $tzParam_process[0];
        $idrequest = $tzParam_process[1];
        $process_status = $_POST['process_status'];
        $process_date = $_POST['process_date'];
        $comment_process = $_POST['comment_process'];
        $bTraitementEncours = true ;
        //si status traitement == 1
        if($process_status == 1){//traitement fini immediat

            DB::table('processings')
            ->where('requestwf_id', $idrequest)
            ->update(['is_finished' => 1]);

               
            DB::table('requestwfs')
            ->where('id', $idrequest)
            ->update(['status_id' => 3]);
            $bTraitementEncours = false ;

        }else{

            DB::table('requestwfs')
            ->where('id',$idrequest)
            ->update(['status_id' => 5]);

            DB::table('processings')
            ->where('requestwf_id', $idrequest)
            ->update(['is_finished' => 2]);

           
        }
        //insert into process
        
            $idprocessachievement = DB::table('process_achievements')->insertGetId(
                ['process_id' => $idprocess,
                'user_id' => $user_id,
                'process_achievement_comment' => $comment_process,
                'process_achievement_date' => $process_date
                ]
            );
          

          //echo 'ici' ;
          //exit() ;  
            //$idprocessachievement = 100 ;
        //Création fichier
        $delete[] = "";
        $tzFichier = array() ;
        if(file_exists(public_path()."/target-files-process/".$user_id."/")){
            $target_dir_user = public_path()."/target-files-process/".$user_id."/";
            $target_process = public_path()."/docrequest/".$idrequest."/dossier_traitement/".$idprocessachievement."/";
            if (!file_exists($target_process)) mkdir($target_process, 0777, true);
            $files = scandir($target_dir_user);
            foreach($files as $file) {
        
                if (in_array($file, array(".",".."))) continue;
                // If we copied this successfully, mark it for deletion
                if (copy($target_dir_user.$file, $target_process.$file)) {
                    $delete[] = $target_dir_user.$file;
                    $tzFichier[] = $target_process.$file ;
                }
            }
            Helper::delTree($target_dir_user);
                    // Helper::sendnotification_with_pj("miorasemidsi@gmail.com","TEST ENVOI","TITRE DANS LE MESSAGE","Texte","contact@snis-sante.net", $tzFichier) ;

            $toRequestwf = Requestwf::getRequestById($idrequest) ;
            /*
            echo '<pre>';
            print_r($toRequestwf);
            echo '</pre>';
            exit();
            */
            $zRequestNom = $toRequestwf[0]->Objet ;
            $zUserOwnerEmail = $toRequestwf[0]->useremail ;

            $QueryListeMailDestinationNotification = DB::table('requestwf_email_addresses')
                    ->join('reply_email_addresses','reply_email_addresses.id','=','requestwf_email_addresses.reply_email_address_id')
                    ->select('reply_email_addresses.rea_email as mailaddress')
                    ->where('requestwf_email_addresses.requestwf_id','=',$idrequest)
                    ->get();
            if($bTraitementEncours)
            {
                $subject = "Notification de demande initiée et en cours de traitement" ;
                $header = "Notification de demande initiée et en cours de traitement" ;
                $zMessageNotificationOtherDes = "La demande <b>" . $zRequestNom . "</b> est déjà initiée et en cours de traitement. Veuillez consulter la pièce jointe";
                $zMessageNotificationOwner = "Votre demande <b>" . $zRequestNom . "</b> est déjà initiée et en cours de traitement. Veuillez consulter votre pièce jointe";
            }
            else
            {
                $subject = "Notification achevement traitement de demande" ;
                $header = "Notification achevement traitement de demande" ;
                $zMessageNotificationOtherDes = "La demande <b>" . $zRequestNom . "</b> a bien été traitée. Veuillez consulter la pièce jointe";
                $zMessageNotificationOwner = "Votre demande <b>" . $zRequestNom . "</b> a bien été traitée. Veuillez consulter votre pièce jointe";
            }
            
            

            
            // Send mail notification for other destination
            foreach ($QueryListeMailDestinationNotification as $omailaddress){
                //echo "adresse_mail=".$mailaddress;



                Helper::sendnotification_with_pj($omailaddress->mailaddress,$subject,$header,$zMessageNotificationOtherDes, "contact@snis-sante.net",  $tzFichier);
                sleep(2) ; //A VOIR!!

            }
            Helper::sendnotification_with_pj($zUserOwnerEmail,$subject,$header,$zMessageNotificationOwner, "contact@snis-sante.net", $tzFichier) ;
            //traitement suppression dossier
            //if(sizeof($delete) > 0){
            /*foreach ($delete as $file) {
                unlink($file);
            }
            //}*/

            //fin création fichier
        }

        echo "1";

        //===========================================================================================//
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
