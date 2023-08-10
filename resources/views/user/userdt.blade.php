@extends('layouts.appnew')
@section('content')
<!-- Content Wrapper. Contains page content -->
<style type="text/css">
  #filtreUser{display:block;border:1px solid;padding:5px;border-radius:5px;margin-bottom:10px;}
  #legendFiltreUser{width:15%!important;padding:5px;}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-0">
          <div class="col">
           
            <a href="/client/create" class="btn btn-info">Liste utilisateur</a>
          </div>
          <div class="col">
          
          </div>
          <div class="col">
         
          </div>
          <div class="col">
          
          </div>
          <div class="col">
          
          </div>
          <div class="col">
          <a href="<?php $vSessionEntityUser=Session::get('s_entityid_user'); echo url("/createcompte");?>" class="btn btn-primary">Créer utilisateur</a>
          </div>
          
          <!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid pb-4">
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-12">
            <!-- TABLE: DATA -->
            @if(Session::has('message'))
              <div class="form-group row">
                    <div class="col-md-12">
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ 
                                    Session::get('message') }}</p>
                    </div>
              </div>
            @endif
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">All data</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  @if($message = Session::get('success'))
                  <div class="alert alert-success">
                    <p>{{$message}}</p>
                  </div>
                  @endif
                  <div class="container">
                    <div class="col-md-12">
                        <fieldset id="filtreUser">
                          <legend id="legendFiltreUser">Filtrer par:</legend>
                          <form method="get" id="frmFiltreUser" name="frmFiltreUser">
                              <label>Administrateur</label>&nbsp;
                              <select name="filtreAdministrateur" onchange="frmFiltreUser.submit();">
                                  <option value="-1" <?php if(isset($_GET['filtreAdministrateur']) && $_GET['filtreAdministrateur'] == '-1'){ ?>selected="selected"<?php } ?>>All</option>
                                  <option value="1" <?php if(isset($_GET['filtreAdministrateur']) && $_GET['filtreAdministrateur'] == 1){ ?>selected="selected"<?php } ?>>Oui</option>
                                  <option value="0" <?php if(isset($_GET['filtreAdministrateur']) && $_GET['filtreAdministrateur'] == 0){ ?>selected="selected"<?php } ?>>Non</option>
                                  
                              </select>&nbsp;
                              <label>Répondeur</label>&nbsp;
                              <select name="filtreRepondeur" onchange="frmFiltreUser.submit();">
                                  <option value="-1" <?php if(isset($_GET['filtreRepondeur']) && $_GET['filtreRepondeur'] == '-1'){ ?>selected="selected"<?php } ?>>All</option>
                                  <option value="1" <?php if(isset($_GET['filtreRepondeur']) && $_GET['filtreRepondeur'] == 1){ ?>selected="selected"<?php } ?>>Oui</option>
                                  <option value="0" <?php if(isset($_GET['filtreRepondeur']) && $_GET['filtreRepondeur'] == 0){ ?>selected="selected"<?php } ?>>Non</option>
                                  
                              </select>
                              <label>Valideur</label>&nbsp;
                              <select name="filtreValideur" onchange="frmFiltreUser.submit();">
                                  <option value="-1" <?php if(isset($_GET['filtreValideur']) && $_GET['filtreValideur'] == '-1'){ ?>selected="selected"<?php } ?>>All</option>
                                  <option value="1" <?php if(isset($_GET['filtreValideur']) && $_GET['filtreValideur'] == 1){ ?>selected="selected"<?php } ?>>Oui</option>
                                  <option value="0" <?php if(isset($_GET['filtreValideur']) && $_GET['filtreValideur'] == 0){ ?>selected="selected"<?php } ?>>Non</option>
                                  
                              </select>
                              <label>Activé</label>&nbsp;
                              <select name="filtreActive" onchange="frmFiltreUser.submit();">
                                  <option value="-1" <?php if(isset($_GET['filtreActive']) && $_GET['filtreActive'] == '-1'){ ?>selected="selected"<?php } ?>>All</option>
                                  <option value="1" <?php if(isset($_GET['filtreActive']) && $_GET['filtreActive'] == 1){ ?>selected="selected"<?php } ?>>Oui</option>
                                  <option value="0" <?php if(isset($_GET['filtreActive']) && $_GET['filtreActive'] == 0){ ?>selected="selected"<?php } ?>>Non</option>
                                  
                              </select>
                              <label>Compte temporaire</label>&nbsp;
                              <select name="filtreTemporaire" onchange="frmFiltreUser.submit();">
                                  <option value="-1" <?php if(isset($_GET['filtreTemporaire']) && $_GET['filtreTemporaire'] == '-1'){ ?>selected="selected"<?php } ?>>All</option>
                                  <option value="1" <?php if(isset($_GET['filtreTemporaire']) && $_GET['filtreTemporaire'] == 1){ ?>selected="selected"<?php } ?>>Oui</option>
                                  <option value="0" <?php if(isset($_GET['filtreTemporaire']) && $_GET['filtreTemporaire'] == 0){ ?>selected="selected"<?php } ?>>Non</option>
                                  
                              </select>
                          </form>
                        </fieldset>
                    </div>
                  </div>

                  <table id="tblrequestsend" class="table table-bordered table-striped m-0">
                    <thead>
                    <tr>

                      <th>ID</th>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Entite</th>
                      <th>Fonction</th>
                      <th>Activé</th>
                      <th>Compte temporaire</th>
                      <th>Administrateur</th>
                      <th>Repondeur</th>
                      <th>Valideur</th>
                      <th>Date de création</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php 
                        foreach($dataUser as $user) {
                          $zValActivation = Helper::setOuiNon($user->activated);
                          $zValCompteTemp = Helper::setOuiNon($user->istemp);
                          $zValAdministration = Helper::setOuiNon($user->administrator);
                          $zValRepondeur = Helper::setOuiNon($user->answering);
                          $zValValideur = Helper::setOuiNon($user->validator);
                          //==================================================//
                          //$zValActivation = $user->activated;
                          //$zValCompteTemp = 1;
                          //$zValAdministration = 1;
                          //$zValRepondeur = 1;
                          //$zValValideur = 1;
                          //==================================================//
                          //$dataid = $dataid.'data-id=\"'.$user->id.'\"';
                          //$zUsersDatatable .= '["'.$user->id.'","'.$user->name.'","'.$user->email.'","'.$user->entity->name.'","'.$zValActivation.'","'.$zValAdministration.'","'.$zValRepondeur.'","'.$zValValideur.'","'.$user->created_at.'","<button type=\"button\" class=\"btn btn-edit btn-info\"'.$dataid.'>Edit</button>  <button type=\"button\" class=\"btn btn-delete btn-danger\"'.$dataid.'>Delete</button>"],';
                         
                      
                      
                      ?>
                      <tr class="item-tr">
                        <td><a href="">{{$user->id}}</a></td>                      
                        <td><div class="image mt-2">
                            <?php
                                $zUserImage = (!$user->image) ? 'user-default.png' : $user->image ;
                            ?>
                              <img src="<?php echo asset('images').'/'.$zUserImage; ?>" class="img-thumbnail" alt="User Image">
                          </div></td>
                        <td id='td_td_info_{{$user->id}}'>
                          <?php echo $user->name;?>
                          <br/>
                          <span id='td_info_{{$user->id}}' class="spanInfos" style="display:none;background:white;color:black!important;font-weight:bolder;">Mise à jour effectué</span>
                        </td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->email}}</td>
                        <td><?php $zEntity = App\Entity::getNameEntityById($user->entity_id); echo $zEntity?></td>
                        <td>{{$user->function}}</td>
                        <td><span id='td_activation_{{$user->id}}'>{{$zValActivation}}</span></td>
                        <td>{{$zValCompteTemp}}</td>
                        <td><span id='td_administration_{{$user->id}}'>{{$zValAdministration}}</span></td>
                        <td><span id='td_repondeur_{{$user->id}}'>{{$zValRepondeur}}</span></td>
                        <td><span id='td_valideur_{{$user->id}}'>{{$zValValideur}}</span></td>
                        <td>{{$user->created_at}}</td>

                        <td>
                          <a href=""><i class="fas fa-eye text-primary"></i></a>
                          <a href="/user/edit/{{ $user->id }}"><i class="fas fa-edit ml-1 text-secondary"></i></a>
                          <?php if($user->activated == 0 ) {?>
                          <a href="javascript:void(0);"  onclick="show_modal_enable_user({{$user->id}});" class="btn btn-default btn-sm link_show_modal_{{$user->id}}">
                                Enable user <span class="glyphicon glyphicon-sort"></span>
                          </a>
                          <?php } ?>
                          <?php if($user->activated == 1 ) {?>
                          <a href="javascript:void(0);" onclick="show_modal_enable_user({{$user->id}});" class="btn btn-default btn-sm link_show_modal_{{$user->id}}">
                                Disable user <span class="glyphicon glyphicon-sort"></span>
                          </a>
                          <?php } ?>
                          
                          <?php
                              $bUserDonnee = App\User::verifexistencedatabyuserid($user->id) ;
                              
                          ?>
                          <?php if(!$bUserDonnee){ ?>
                            <a href="javascript:void(0);" class="btn-delete"  onclick="supprimer_user(<?php echo $user->id ; ?>);" ><i class="fas fa-trash ml-1 text-danger"></i></a>
                          <?php } ?>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!---------------------start modal enable user------- --------------> 
  <div class="modal fade" id="modal-send-comment" aria-hidden="true">
      <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title" id="sendCommentModal">Activation utilisateur</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">x</span>
                      </button>
                  </div>
                  <div class="modal-body" style="padding:0!important;">
                      Body Activation utilisateur
                  </div>
                  <div class="modal-footer">
                      
                  </div>
              </div>
      </div>
  </div>
<!-----------------end modal enable user----------- -------------->
<script type="text/javascript">
  
  function supprimer_user(_iUserId)
  {
    var urlnextpage = "<?php echo url("userdatatable");?>" ;
    Swal.fire({
          html: '<?php echo '<span class="text-lg">Etes vous sur de proceder à la suppression de cet utilisateur ?</span>'; ?>',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Yes',
          cancelButtonText: 'No'
      }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                type: "get",                        
                url:"<?php echo url("supprimeruser");?>" + '/' + _iUserId,
                context:document.body,
                async:false,
                success: function (data) {
                    window.location = urlnextpage;
                    
                    },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
          }
      })
  }
  function show_modal_enable_user(_iUserId)
  {
      $('#modal-send-comment').modal('show') ;
      $('.spanInfos').hide() ;
      $.ajax({
          type: "get",                        
          url:"<?php echo url("enableuser");?>" + '/' + _iUserId,
          //context:document.body,
          async:true,
          success: function (data) {
              $('#modal-send-comment .modal-body').html(data) ;
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
  }
 
</script>
@endsection


