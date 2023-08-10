<div id="mymaincontent">
    <div class="container">
        <div class="rounded bg-white mt-1">
            <div class="row">
               <?php $action = ($user->activated == '0') ? route('setenable',$user->id) : route('setdisable',$user->id) ;?>
               <?php $prochainetat = ($user->activated == '0') ? 1 : 0 ;?>
                @csrf
                <input type="hidden" id="iProchainEtat" value="<?php echo $prochainetat ; ?>"/>
                <input type="hidden" id="iUserId" value="<?php echo $user->id ; ?>"/>
                <input type="hidden" id="zUrlEnableDisable" value="<?php echo $action ; ?>"/>
                <input type="hidden" id="_token" value="{{ csrf_token() }}">
                <div class="col-md-4 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-1 py-1"><img class="rounded-circle mt-5" width="150px" src="<?php echo asset('images').'/'.$user->image; ?>"></div>
                </div>
            
                <div class="col-md-8 border-right">
                    <div class="p-1 py-1">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profil utilisateur</h4>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12"><label class="labels">Nom</label><input type="text" class="form-control" placeholder="first name" value="{{$user->name}}" disabled></div>
                            
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">Entite</label><input type="text" class="form-control" placeholder="" value="<?php $zentite = App\Entity::getNameEntityById($user->entity_id); echo $zentite;?>" disabled></div>
                            <div class="col-md-12"><label class="labels">Fonction</label><input type="text" class="form-control" placeholder="" value="{{$user->function}}" disabled></div>
                            <div class="col-md-12"><label class="labels">Telephone</label><input type="text" class="form-control" placeholder="" value="{{$user->phone}}" disabled></div>

                            <div class="col-md-12"><label class="labels">Email</label><input type="text" class="form-control" placeholder="" value="{{$user->email}}" disabled></div>
                            
                        </div>
                        
                        
                        
                    </div>
                </div>
            </div>
            <div class="row">
                
                <div class="col-md-12">
                    <div class="p-1 py-1">
                        <div class="d-flex justify-content-between align-items-center experience"><h4 class="text-right">Rôles utilisateur</h4></div>
                        <div class="row">
                            <div class="col-md-3"><label class="labels">Activé</label>
                                <span><?php echo Helper::setOuiNon($user->activated) ?></span>
                                
                            </div>
                        
                            <div class="col-md-3"><label class="labels">Administrateur</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="useradministrator" id="useradminyes" value="1" <?php if($user->administrator == '1') echo 'checked'?>>
                                        <label class="form-check-label" for="inlineRadio1">Oui</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="useradministrator" id="useradminno" value="0" <?php if($user->administrator == '0') echo 'checked'?>>
                                        <label class="form-check-label" for="inlineRadio2">Non</label>
                                    </div>
                            </div>
                            <div class="col-md-3"><label class="labels">Valideur</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="uservalidator" id="uservalidyes" value="1" <?php if($user->validator == '1') echo 'checked'?>>
                                        <label class="form-check-label" for="inlineRadio1">Oui</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="uservalidator" id="uservalidno" value="0" <?php if($user->validator == '0') echo 'checked'?>>
                                        <label class="form-check-label" for="inlineRadio2">Non</label>
                                    </div>
                            
                            </div>
                            <div class="col-md-3"><label class="labels">Repondeur</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="useranswering" id="useransweryes" value="1" <?php if($user->answering == '1') echo 'checked'?>>
                                    <label class="form-check-label" for="inlineRadio1">Oui</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="useranswering" id="useranswerno" value="0" <?php if($user->answering == '0') echo 'checked'?>>
                                    <label class="form-check-label" for="inlineRadio2">Non</label>
                                </div>
                        
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-6 text-center">
                                <img id="loader-sauve" src="assets_template/dist/img/loader.gif" style="width:50px;display:none;"/>
                                <button class="btn btn-primary profile-button" id="btnEnableUser" type="button"><?php if($user->activated == '0') { echo 'Activater utilisateur'; } else echo 'Desactivater utilisateur';?></button>
                                
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery("#btnEnableUser").on('click', function (event) {
        Swal.fire({
            html: '<?php if($user->activated == '0') echo '<span class="text-lg">Etes vous sur de proceder à l activation de cet utilisateur ?</span>'; else {echo '<span class="text-lg">Etes vous sur de proceder à la desactivation de cet utilisateur ?</span>';} ?><br/>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                $('img#loader-sauve').css('display', 'block') ;
                $('button#btnEnableUser').css('display', 'none') ;
                var zUrlEnableDisable = $("#zUrlEnableDisable").val() ;
                var useranswering       = 1 ;
                var uservalidator       = 1 ;
                var useradministrator   = 1 ;
                if($("#useranswerno").is(':checked'))
                {
                    useranswering = 0 ;
                }
                if($("#useradminno").is(':checked'))
                {
                    useradministrator = 0 ;
                }
                if($("#uservalidno").is(':checked'))
                {
                    uservalidator = 0 ;
                }
               
                $.ajax({
                    type: "post",                        
                    url: zUrlEnableDisable ,
                    //context:document.body,
                    data:{useranswering:useranswering, uservalidator:uservalidator, useradministrator:useradministrator},
                    async:true,
                    headers: {
                        'X-CSRF-TOKEN': $('#_token').val()
                    },
                    success: function (data) {
                        //alert("mise à jour effectué") ;
                        
                        $('#modal-send-comment').modal('hide');
                        var iUserId = $('#iUserId').val() ;
                        $('#td_td_info_' + iUserId).css('background', 'green') ;
                        $('#td_td_info_' + iUserId).css('color', 'white') ;
                        if(useranswering == 1)
                        {
                            $("span#td_repondeur_" + iUserId).html('Oui') ;
                        }
                        if(useranswering == 0)
                        {
                            $("span#td_repondeur_" + iUserId).html('Non') ;
                        }
                        if(useradministrator == 1)
                        {
                            $("span#td_administration_" + iUserId).html('Oui') ;
                        }
                        if(useradministrator == 0)
                        {
                            $("span#td_administration_" + iUserId).html('Non') ;
                        }
                        if(uservalidator == 1)
                        {
                            $("span#td_valideur_" + iUserId).html('Oui') ;
                        }
                        if(uservalidator == 0)
                        {
                            $("span#td_valideur_" + iUserId).html('Non') ;
                        }
                        if($('#iProchainEtat').val() == 1)
                        {
                            $("#td_activation_" + iUserId).html('Oui') ;
                            $(".link_show_modal_" + iUserId).html('Disable User') ;
                            $("#td_activation_" + iUserId).css('background-color', 'green') ;
                            $("#td_activation_" + iUserId).css('color', 'white') ;
                            $("#td_activation_" + iUserId).css('font-weight', 'bolder') ;
                        }
                        if($('#iProchainEtat').val() == 0)
                        {
                            $("#td_activation_" + iUserId).html('Non') ;
                            $(".link_show_modal_" + iUserId).html('Enable User') ;
                            $("#td_activation_" + iUserId).css('background-color', 'red') ;
                            $("#td_activation_" + iUserId).css('color', 'white') ;
                            $("#td_activation_" + iUserId).css('font-weight', 'bolder') ;
                        }
                        $("span#td_info_" + iUserId).show() ;
                        return false ;
                        
                        //location.reload(); 
                        
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        })

    })
</script>