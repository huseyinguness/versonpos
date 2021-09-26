<?php require_once 'fonksiyon/fonksiyon.php'; $sistem = new sistem;

$veri=$sistem->benimsorgum2($db,"select * from garson where durum=1",1)->num_rows;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="=text/html; charset=utf-8"/>

<script src="Dosya/jquer.js"></script>
<script src="Dosya/modal.js"></script>
<link rel="stylesheet" href="Dosya/boost.css">

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity=
    "sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<title>sistem Pos Restorant sistemleri </title>	
<style>
	
	#rows
		{			
			height: 40px;
		}
	#masa
		{			
			height: 100px;
			margin: 1px;
			font-size: 35px;
			border-radius: 8px;
		}
		
	#mas a:link, 
	#mas a:visited
		{
			
			text-decoration:none;
		
	    }	
 

 </style>

<script>
$(document).ready(function() {

	var deger = "<?php echo $veri; ?>";

	if (deger==0) {
		$('#girismodal').modal({

			backdrop: 'static',
			keyboard: false
		})

		$('body').on('hidden.bs.modal','.modal', function(){

		     $(this).removeData('bs.modal');

		});

				}
	else {
		('#girismodal').modal('hide');

		}		

		 $('#girisbak').click(function()  {
       	 
       	 $.ajax({   
            type : "POST",
            url :'islemler.php?islem=kontrol',
            data :$('#garsonform').serialize(),
            success : function(donen_veri) {               
            $('#garsonform').trigger("reset");
            
            $('.modalcevap').html(donen_veri); 
          
            },
        })
   	 })
});
</script>

</head>
<body>
	
	
	<div class="container-fluid">
		<div class="row table-dark" id="rows">
		<div class="col-md-3 border-right p-1 ">Atif Garson : <a class="text-warning"><?php $sistem->garsonbak($db) ;?> </a></div>
		<div class="col-md-2 border-right p-1">Toplam Sipariş : <a class="text-warning"><?php $sistem->siparistoplam($db) ;?></a> </div>
		<div class="col-md-2 border-right p-1">Doluluk Oranı : <a class="text-warning"><?php $sistem->doluluk($db) ;?></a></div>
	    <div class="col-md-3 border-right p-1 ">Toplam Masa : <a class="text-warning"><?php $sistem->masatoplam($db) ;?> </a></div>
		<div class="col-md-2 border-right p-1">Tarih : <a class="text-warning"><?php echo date('d.m.Y H:i:s'); ?></a></div>	

		
		</div>
		<div class="row">				
				<?php $sistem->masacek($db); ?>		
		</div>	
<!-- The Modal -->
  <div class="modal fade" id="girismodal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">  

        <!-- Modal Header -->
        <div class="modal-header text-center">
          <h4 class="modal-title">Garson Girişi</h4>          
        </div>        
        
        <!-- Modal body -->
        <div class="modal-body">  
         <form id="garsonform">         
         <div class="row mx-auto text-center">          
         		<div class="col-md-12">Garson Ad</div>
        		 <div class="col-md-12"><select name="ad" class="form-control mt-2">
                  <option value="0">Seç</option>

                  <?php 

                  	$b=$sistem->benimsorgum2($db,"select * from garson",1);
                  while ($garsonlar=$b->fetch_assoc()):
                 	 echo'<option value="'.$garsonlar["ad"].'">'.$garsonlar["ad"].'</option>';
            	  endwhile;
                   ?>      

                </select></div>   
           		 <div class="col-md-12">Şifre </div>         
                <div class="col-md-12">
                <input name="sifre" type="password" class="form-control  mt-2" />                
                </div> 
                <div class="col-md-12">
               <input type="button" id="girisbak" value="GİR" class="btn btn-info mt-4"/>                
                </div>
         </div>      
         </form>
        </div>    
         <div class="modalcevap">
        </div>    
        
      </div>
    </div>
  </div>


</div>
</body>
</html>