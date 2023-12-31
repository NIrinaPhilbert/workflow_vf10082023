@extends('layouts.appnew')
@section('content')
<!-- Content Wrapper. Contains page content -->
<style type="text/css">
        .content-wrapper
        {
            /*width:700px;
            margin-left:300px;
            margin-right:300px;*/
            background-color:#FFFFFF;
            overflow: auto;
        }
		/*table.inTable {
			border-padding: 2px !important;
		}
		table.inTable tr:nth-child(1) td {
			border-top: none !important;
		}
		table.inTable tr td:nth-child(2) {
			border-right: none !important;
		}
		table thead th, table thead td {
			vertical-align: middle !important;
		}
		table thead {
			background: #f6f6f6;
		}
		.valtitle {
			background: #FFFFFF !important;
		}
		table thead th {
			font-weight: bold;
			font-size: 10px !important;
		}
		
		table td, th {
			border: 1px solid black !important;
			font-size: 12px !important;
		}
		table {
			width: 100%;
			//table-layout: fixed !important;
			border-collapse: collapse !important;
			border: 1px solid black !important;
		}
		th {
			//background: #FFFFFF !important;
			background: ##f6f6f6 !important;
			font-weight: bold !important;
			border-collapse: collapse !important;
			border: 1px solid black !important;
		}
		th.titlefusion {
			background: #FFFFFF !important;
		}
		.TableColumnSameWidth{
    		width: 100%;
    		table-layout: fixed !important;
		}
		td.sansValeur{
			background: #d6d4d4 !important;
		}
		*/
    </style>
<div class="content-wrapper">
    
        <section class="content">
        <div class="container-fluid pb-4">
            <div class="row mt-3">
            <button type="button" class="btn btn-primary" id="btn-pdf">Exporter format PDF</button>
            	<!--<button id="btn-print" class="btn btn-warning">Imprimer</button>-->
            </div>
			<table id="tabEntete" class="table .TableColumnSameWidth table-bordered" style="width:100%; margin-top: 25px !important;">
			<thead>				
				<tr class="text-left">
					<th colspan="2"></strong>INFORMATION DEMANDE </strong></th>
				</tr>			
			</thead>
			<tbody>
      <?php foreach ($RequestDetail as $oDetailRequest) { ?>
				<tr>
					<td class="text-left"><label>Date d'envoie</label></td>
					<td class="text-left"><span><?php echo $oDetailRequest->created_at ;?></span></td>
					
				</tr>
				<tr>
					<td class="text-left"><label>Utilisateur source</label></td>
					<td class="text-left"><span><?php echo $oDetailRequest->username.' ['.$oDetailRequest->entityuser.']' ;?></span></td>
					
				</tr>
				<tr>
					<td class="text-left"><label>Objet demande</label></td>
					<td class="text-left"><span><?php echo $oDetailRequest->Objet ;?></span></td>
					
				</tr>
				<tr>
					<td class="text-left"><label>Type demande</label></td>
					<td class="text-left"><span><?php echo $oDetailRequest->type_requestname." ".$oDetailRequest->toolname ;?></span></td>
					
				</tr>
				<tr>
					<td class="text-left"><label>Description demande</label></td>
					<td class="text-left"><span><?php echo strip_tags($oDetailRequest->Content) ;?></span></td>
					
				</tr>
				<tr>
					<td class="text-left"><label>Situation actuel demande</label></td>
					<td class="text-left"><span><span><?php echo $oDetailRequest->status ;?></span></td>
					
				</tr>
			
			<?php } ?>
				
			</tbody>
		</table>
            <!-- Main row -->
            <table id="tab3" class="table .TableColumnSameWidth table-bordered" style="width:100%; margin-top: 25px !important;">
			<thead>				
				<tr class="text-left">
					<th colspan="6"></strong>HISTORIQUE TRAITEMENT DEMANDE </strong></th>
				</tr>			
				<tr>
					<th class="text-left"><label>N°</label></th>
					<th class="text-left"><label>Etat</label></th>
					<th class="text-left"><label>Action  effectuée par</label></th>
					<th class="text-left"><label>Date</label></th>
					<th class="text-left"><label>Commentaire</label></th>
					<th class="text-left"><label>Entite responsable action</label></th>
				</tr>
			</thead>
			<tbody>
				<?php //echo $iNombreEnreg ; ?>
        <?php 
            for($ind = 1; $ind < $iNombreEnreg; $ind++) {
        ?>
			<tr>
					<td class="text-left"><?php echo $ind;?></td>
					<td class="text-left"><?php echo $toRequestHistory[$ind]['etat'];?></td>
					<td class="text-left"><?php echo $toRequestHistory[$ind]['acteur'];?></td>
					<td class="text-left"><?php echo $toRequestHistory[$ind]['dateaction'];?></td>
					<td class="text-left"><?php echo $toRequestHistory[$ind]['commentaire'];?></td>
					<td class="text-left"><?php echo $toRequestHistory[$ind]['entite'];?></td>
				</tr>
				<?php } ?>
				<?php if($iNombreEnreg == 1){ ?>
					<tr>
						<td class="text-left" colspan="6">Traitement non encore commencé pour cette demande</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
            
            <!-- /.row -->
        </div><!--/. container-fluid -->
        </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->
<script type="text/javascript">
    $(window).on("load" , function () {
		$("#btn-print").on("click", function(){
			try {
				$(this).addClass("d-none")
				$("#btn-pdf").addClass("d-none")
				window.print()
			} catch (e) {
				alert(e)
			}
		})

		$('#idloader').hide();
        $('#btn-pdf').click(function () {
                // $('#testhtml').html('essai');
                downPDF();
            });
        })
    function downPDF() {
		//$('#idloader').show();
		var doc = new jsPDF('l', 'pt', 'A4');
		//var doc = new jsPDF('p','mm',[297, 210]);
    doc.autoTable({
	    	html: '#tabEntete',
	    	theme: "striped", // plain or striped
	    	//tableLineColor: [204, 204, 204],
            tableLineColor: [255, 255, 255],
	    	tableLineWidth: 4,
	    	useCss: true, // true or false
	    });
		doc.autoTable({
	    	html: '#tab3',
	    	theme: "striped", // plain or striped
	    	//tableLineColor: [204, 204, 204],
            tableLineColor: [255, 255, 255],
	    	tableLineWidth: 4,
	    	useCss: true, // true or false
	    });
        $('#idloader').hide();
		doc.save('Etat.pdf');
    }
</script> 

@endsection

