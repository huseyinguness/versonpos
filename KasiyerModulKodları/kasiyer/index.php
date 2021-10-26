<?php 
include_once("../fonksiyon/fonksiyon.php"); 
include_once("../yon/fonk/temaiki.php"); 
$sistem = new sistem;
$tema2 = new temadestek;

// Kasiyet modülü için özel sınıf oluşturduk.
include_once("fonksiyon/kasiyerfonksiyon.php"); 
$kasiyer = new kasiyer;
$tema2->cookcon($db,false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../dosya/jqu.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="stylesheet" href="../dosya/stil.css" >
<link rel="stylesheet" href="../dosya/kasiyerStil.css" >
<title>Verson Restaurant -KASİYER EKRANI</title>
<script>
$(document).ready(function() {
	$("#bekleyenler").hide();
	$("#rezerveformalan").hide();
	$("#rezervelistesi").hide();	
	setInterval(function() { 	
	window.location.reload();
	},60000);	
	$("#ac").click(function() { 
	$("#bekleyenler").load("islemler.php?islem=garsonbilgigetir");
	// burada bişe yapacağız
	$("#bekleyenler").animate({ 	
		opacity:'show',
		width:'show'},'fast','linear',function() {
	});	
	});
	
	$("#kapa").click(function() { 
	// burada bişe yapacağız
	$("#bekleyenler").animate({ 	
		opacity:'hide',
		width:'hide'},'fast','linear',function() {
	});	
	window.location.reload();
	});	
	$("#rezerveformac").click(function() { 
	$("#rezerveformalan").show();
	// burada bişe yapacağız
	$("#rezerveformalan").animate({ 	
		opacity:'show',
		width:'show'},'fast','linear',function() {
	});	
	$("#rezervelistesi").hide();	
	});	
	$("#rezerveformkapa").click(function() { 
	// burada bişe yapacağız
	$("#rezerveformalan").animate({ 	
		opacity:'hide',
		width:'hide'},'fast','linear',function() {
	});	
	$("#rezervelistesi").animate({ 	
		opacity:'hide',
		width:'hide'},'fast','linear',function() {
	});	
	window.location.reload();	
	});	
	$("#rezerveliste").click(function() { 
	$("#rezervelistesi").load("islemler.php?islem=rezervelistesi");
	// burada bişe yapacağız
	$("#rezervelistesi").animate({ 	
		opacity:'show',
		width:'show'},'fast','linear',function() {
	});	
	$("#rezerveformalan").hide();	
	});	
		$('#rezervebtn').click(function() {		
		$.ajax({			
			type : "POST",
			url :'islemler.php?islem=rezerveet',
			data :$('#rezerveform').serialize(),			
			success: function(donen_veri){
			$('#rezerveform').trigger("reset");				
			window.location.reload();				
			},			
		})		
	});
	});
</script>
</head>
<body>

<div class="container-fluid">
	<div class="row">
    <div class="col-lg-12 border-bottom bg-white">
    <h5 class="pt-2 ">KASİYER EKRANI</h5>
       </div>   
    
    			<?php $kasiyer->KasiyerMasalar($db); ?>
    </div>  
  <!-- ALT BÖLÜM BURADAN İTİBAREN BAŞLIYOR -->


<div class="row fixed-bottom kasiyerBar">
<div class="col-md-12  border-info font-weight-bold " >
				<div class="row">                    
               	 <div class="col-md-2   SagcizgiK SolcizgiK pl-5 pt-2" >
                 
                 <i class="fas fa-chart-bar mt-2 mb-2  icon3K"></i>
                 <span class="icon2K">Toplam sipariş <kbd class="bg-danger text-white"><?php $kasiyer->siparistoplam($db); ?></kbd></span></div>
                 
                <div class="col-md-2   SagcizgiK SolcizgiK pl-5 pt-2" >
                 <i class="fas fa-percent mt-2 mb-2  icon3K"></i>
                 <span class="icon2K">Doluluk oranı <kbd class="bg-danger text-white"><?php $kasiyer->doluluk($db); ?></kbd></span></div>
                 
               <div class="col-md-2   SagcizgiK SolcizgiK pl-5 pt-2" >  
                  <i class="fas fa-utensils mt-2 mb-2  icon3K"></i>
                 <span class="icon2K">Hesap Bekleyen Masa <kbd class="bg-danger text-white"><?php $kasiyer->masatoplam($db); ?></kbd></span></div>
                 
                  <div class="col-md-2   SagcizgiK SolcizgiK pl-5 pt-2" >  
                  <i class="fas fa-users mt-2 mb-2  icon3K"></i>
                 <span class="icon2K">Kasiyer : 00</span></div>
                 
         
          
                
                
                </div>

 



</div>



</div>

         





</div>

</body>
</html>