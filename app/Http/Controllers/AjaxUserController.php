<?php

namespace App\Http\Controllers;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Entity;
use App\User;
use App\Helpers\Helper as Helper;
//use Helper;
use Redirect,Response;

use Illuminate\Http\Request;

class AjaxUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        
            
            
            

            $dataid = ' ';
            $data = Entity::with('entity')->orderBy('name', 'ASC')->get();

            
            if(isset($_GET['filtreAdministrateur']))
            {
                $toWhere = array() ;
                if($_GET['filtreAdministrateur'] != '-1')
                {
                    $toWhere[] = ['administrator', '=', $_GET['filtreAdministrateur']] ;
                }
                if($_GET['filtreRepondeur'] != '-1')
                {
                    $toWhere[] = ['answering', '=', $_GET['filtreRepondeur']] ;
                }
                if($_GET['filtreValideur'] != '-1')
                {
                    $toWhere[] = ['validator', '=', $_GET['filtreValideur']] ;
                }
                if($_GET['filtreTemporaire'] != '-1')
                {
                    $toWhere[] = ['isTemp', '=', $_GET['filtreTemporaire']] ;
                }
                if($_GET['filtreActive'] != '-1')
                {
                    $toWhere[] = ['activated', '=', $_GET['filtreActive']] ;
                }
                if(sizeof($toWhere) > 0)
                {
                    $dataUser = User::with('entity')
                    ->where($toWhere)
                    ->orderBy('id', 'DESC')->get();
                }
                else
                {
                    $dataUser = User::with('entity')->orderBy('id', 'DESC')->get();
                }
            }
            else
            {
                $dataUser = User::with('entity')->orderBy('id', 'DESC')->get();
            }
            
            /*
            $dataUser = User::with('entity')
            ->where('administrator','=',1)
            ->orderBy('id', 'DESC')->get();
            */
            
            //remove the ',' at the end of the variable;
            /*
            echo '<pre>';
            print_r($dataUser);
            echo '</pre>';
            */
            //exit();
            
            return view('user.userdt', compact('dataUser','data'));
        
    }
    
}
