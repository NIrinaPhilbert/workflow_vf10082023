<?php
 namespace App\Helpers;

 class Helper
 {
     public static function setOuiNon(int $val)
     { $res = 'Oui';
         if($val == 0) {
             $res = 'Non';
         }
         return $res;
     }
     public static function getNameIcon(string $znamefile, string $typefile){
        $zNameIcon = "";
        
        switch($typefile)
            {
                case "xls" ://table 'etats' interpretée
                    $zNameIcon = 'icon-xlsx.png' ;
                break ;
                case "xls" :
                    $zNameIcon  = 'icon-xls.png' ;
                break ;
                case "doc" :
                    $zNameIcon  = 'icon-doc.png' ;
                break ;
                case "docx" :
                    $zNameIcon  = 'icon-docx.png'; 
                break ;
                case "pdf" :
                    $zNameIcon  = 'icon-pdf.png';
                break ;
                default:
                $zNameIcon =  $znamefile;
            }

        return $zNameIcon;
     }

     public static function getLibelleSituationProcessusValidation(int $val)
     { 
         $res = 'En attente de mon validation';
         if($val == 2) {
             $res = 'Validé à  mon niveau';
         }
         if($val == 3){
            $res = 'rejeté à mon niveau';
         }
         return $res;
     }
     public static function getLibelleSituationTraitement(int $idsituation){
        $zLibstyle = '';
        if($idsituation == 0){
           $zLibstyle = '<span class="badge badge-danger">En attente traitement</span>';
        }
        if($idsituation == 1){
           $zLibstyle = '<span class="badge badge-info">Traitement finalise</span>';
        }
        if($idsituation == 2){
            $zLibstyle = '<span class="badge badge-warning">En cours traitement</span>';
         }
       
        return $zLibstyle;
    }
     public static function setLibstatusStyle(int $idstatus, string $libelle){
         $zLibstyle = '';
         if($idstatus == 1){
            $zLibstyle = '<span class="badge badge-info">'.$libelle.'</span>';
         }
         if($idstatus == 2){
            $zLibstyle = '<span class="badge badge-warning">'.$libelle.'</span>';
         }
         if($idstatus ==3){
            $zLibstyle = '<span class="badge badge-danger">'.$libelle.'</span>';
         }
         return $zLibstyle;
     }
     public static function convertDateTimeToCurrentDate($zstr){
        //->format('g:i A');
        $zDateCurrent = date("d/m/Y h:i:s A", strtotime($zstr));
        return $zDateCurrent;
        
     }
     public static function delTree($dir) {
        $files = glob( $dir . '*', GLOB_MARK );
        foreach( $files as $file ){
            if( substr( $file, -1 ) == '/' )
                delTree( $file );
            else
                unlink( $file );
        }
        rmdir( $dir );
    }
    public static function sendnotification($maildestinataire,$subject,$header,$Message){
        $login = 'notify-me';
        $password = 'ae0c1f53-c1cb-43b1-8511-1d0cdfdcd1a3';
        //$subject = "Notification soumission demande workflow";
        //$header = "workflow notification soumission système";
        //$Message = "Votre demande est soumis dans le système workflow du ministère";
        $post = '{"recipient": "'.$maildestinataire.'", "subject": "'.$subject.'", "header": "'.$header.'", "message": "'.$Message.'", "sender": "workflow"}';
        $url = 'https://mx.snis-sante.net/mail';
        $ch = curl_init('https://mx.snis-sante.net/mail');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL,$url);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_ENCODING,"");

        header('Content-Type: application/json');
        $data = curl_exec($ch);
        //echo $data;
    }
    
    public static function getFileIcon($namefile){
        $zimgicon = "";
        $zextension = "";
        $path_info = pathinfo($namefile);
        /*
        echo '<pre>' ;
        print_r($path_info) ;
        echo '</pre>' ;
        */
        $zextension = $path_info['extension'];

        if($zextension == "pdf"){
            $zimgicon = '<span class="mailbox-attachment-icon"><img class="icon" src="assets_template/dist/img/icons/icon-pdf.png" alt="PDF"></span>';
        }
            
        if($zextension == "xlsx"){
            $zimgicon = '<span class="mailbox-attachment-icon"><img class="icon" src="assets_template/dist/img/icons/icon-xlsx.png" alt="XLSX"></span>';
        }   
        
        if($zextension == "doc"){
            $zimgicon = '<span class="mailbox-attachment-icon"><img class="icon" src="assets_template/dist/img/icons/icon-doc.png" alt="DOC"></span>';
        }  
        /*
        if($zextension == "jpg"){
            $zimgicon = '<span class="mailbox-attachment-icon"><img class="icon" src="assets_template/dist/pj/'.$namefile.'" alt="JPG"></span>';
        }
        if($zextension == "jpeg"){
            $zimgicon = '<span class="mailbox-attachment-icon"><img class="icon" src="assets_template/dist/pj/'.$namefile.'" alt="JPG"></span>';
        }
        if($zextension == "png"){
            $zimgicon = '<span class="mailbox-attachment-icon"><img class="icon" src="assets_template/dist/pj/'.$namefile.'" alt="JPG"></span>';
        }
        */
        
        return $zimgicon;

    }
    public static function formatBytes($size, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 

        return round($bytes, $precision) . ' ' . $units[$pow]; 
    }

    public static function filesize_formatted($file)
    {
        $bytes = filesize($file);
    
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return '1 byte';
        } else {
            return '0 bytes';
        }
        
    }


    
 }

 
?>