<?php 

include_once("fonksiyon/tema3fonk.php");
$tema3 = new vipTema; 

$tema3->cookcon($db,false);

//$veri=$masam->benimsorgum2($db,"select * from garson where durum=1",1)->num_rows;
//if ($veri==0) :
//header("Location:index.php");
//endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script src="dosya/jqu.js"></script>


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<link rel="stylesheet" href="dosya/tema3.css" >
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<title>Restaurant Sipariş Sistemi</title>
<script>
$(document).ready(function() {
$("#bekleyenler").load("islemler.php?islem=garsonbilgigetir");
$("#rezervelistesi").load("islemler.php?islem=rezervelistesi");
$("#rezerveformalan").hide();	
	
	
	setInterval(function() { 
	
	window.location.reload();
	},60000);	
	$("#rezerveformac").click(function() { 
	$("#rezerveformalan").show();
	// burada bişe yapacağız
	$("#rezerveformalan").animate({ 	
		opacity:'show',
		width:'show'},'fast','linear',function() {
	});
			
	});	
	
	$("#rezerveformkapa").click(function() { 
	// burada bişe yapacağız
	$("#rezerveformalan").animate({ 	
		opacity:'hide',
		width:'hide'},'fast','linear',function() {
	});
			
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
<div class="container-fluid h-100">
				<div class="row justify-content-center h-100">
           <!--MASALAR -->
                
                <div class="col-lg-9">
                            <div class="row">                        
                            <?php  $tema3->vipTemaMasalar($db); ?>
                             </div>
                </div>                
                 <!--MASALAR -->                
                <!--SAĞ -->                
                <div class="col-lg-3 ">                
                			<div class="row justify-content-center h-100 sagiskelet">
                            	<div class="col-lg-12 masasagarkaplan ">
                                		<div class="row">                                        
                                        		<div class="col-lg-12  basliklar ">
                                        <h5 class="pt-2" ><kbd class="bg-danger"><?php  echo $tema3->bekleyensatir($db); ?>                                            
                                        </kbd>  MUTFAK SİPARİŞLERİ </h5>
                                        		</div>                                                
                                               	<div class="col-lg-12" id="bekleyenler">                                        
                                        <!-- MUTAFAĞIN BEKLEYEN ÜRÜNLERİ GELİYOR. -->                                        
                                        		</div>
                                        </div>                                
                                </div>                                
                                <div class="col-lg-12 masasagarkaplan">                                
                                				<div class="row">                                        
                                        		<div class="col-lg-12  basliklar ">                                        		                                                   
                                       <i class="fas fa-address-card  ml-1" id="rezerveformac" style="font-size:2em; border-radius:10px;"></i><b>  REZERVASYONLAR </b>
                                        		</div>                                       
                                                
                                                	<div class="col-lg-12" id="rezervelistesi">
                                        <!-- REZERVASYONLAR GELİYOR. -->
                                        		</div>                                                 
                                       		 </div>                                
                                </div>
                                
                                 <div class="col-lg-12 masasagarkaplan">                                
                                 
                                 		<div class="row">                                        
                                        		<div class="col-lg-12  basliklar ">
                                        <i class="fas fa-chart-bar  ml-1"style="font-size:2em; border-radius:10px;"></i><b>  İSTATİSTİKLER</b>
                                        		</div>
                                                
                                       	<div class="col-lg-12  basliklar ">
                                        
                                                        <div class="row istatistikbasliklar" >
                                                        		<div class="col-lg-5 istatistiksagcizgi">
                                                                <b>Toplam sipariş</b>
                                                        		</div>                                                                
                                                                <div class="col-lg-7 istatistikbasliklar">
                                                                <b><?php $tema3->siparistoplam($db); ?></b>
                                                        		</div>                                                        
                                                        </div>   
                                                                                                          
                                                         <div class="row istatistikbasliklar">
                                                        		<div class="col-lg-5 istatistiksagcizgi">
                                                               <b>Toplam Masa</b> 
                                                        		</div>
                                                                
                                                                <div class="col-lg-7 istatistikbasliklar">
                                                               <b><?php $tema3->masatoplam($db); ?></b>
                                                        		</div>
                                                        </div>
                                                        <div class="row istatistikbasliklar">
                                                        		<div class="col-lg-5 istatistiksagcizgi">
                                                               <b>Garson</b> 
                                                        		</div>
                                                                
                                                                <div class="col-lg-7 istatistikbasliklar">
                                                               <b><?php $tema3->garsonbak($db); ?></b>
                                                        		</div>
                                                        </div>
                                        		</div>
                                       		 </div>
                                
                                </div>
       						 </div>
                
                </div>
                <!--SAĞ -->                
                </div>
</div>
<!-- The Modal 
  <div class="modal fade" id="girismodal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
       
        <div class="modal-header text-center">
          <h4 class="modal-title">Garson Girişi</h4>
          
        </div>
        
    
        <div class="modal-body">
        
        
         <form id="garsonform">
         
         <div class="row mx-auto text-center">
         
         
         
         		<div class="col-md-12">Garson Ad</div>
        		 <div class="col-md-12"><select name="ad" class="form-control mt-2">
                  <option value="0">Seç</option>
                 
				  ----------php------------
				 // $b=$tema3->benimsorum2($db,"select * from garson",1);
				  
				 // while ($garsonlar=$b->fetch_assoc()) :
				  
				//  echo '<option value="'.$garsonlar["ad"].'">'.$garsonlar["ad"].'</option>';
				  
				 // endwhile;
				  
				// ---------php kodu--------------- 
              
                </select></div> 
        		 <div class="col-md-12">Şifre </div>         
                <div class="col-md-12">
                <input name="sifre" type="password" class="form-control  mt-2" />                
                </div>  
                <div class="col-md-12">
               <input type="button" id="girisbak" value="GİRİŞ YAP" class="btn btn-info mt-4"/>                
                </div>
         
         </div>
         </form>
        </div>       
        
         <div class="modalcevap">
          
        </div>   
        
      </div>
    </div>
  </div>-->
  
  

  
  
   <div class="row " id="rezerveformalan" >    
    <form id="rezerveform">        
         <div class="row mx-auto text-center">      
         
         		<div class="col-md-12 font-weight-bold p-1 text-white">
                    <font id="rezerveformkapa" class="float-left text-danger pl-2 pointer-event"> 
                        <b><i class="fas fa-angle-double-right text-info"></i></b> </font >Masa Ad</div>
        		 <div class="col-md-12 text-white"><select name="masaid" class="form-control mt-2">
                  <option value="0">Masa Seç</option>
                  <?php				  
				  $b=$tema3->benimsorum2($db,"select * from masalar where durum=0 and rezervedurum=0 and kategori=".$tema3->BolumTercihGetir($db),1);				  
				  while ($masalar=$b->fetch_assoc()) :				  
				  echo '<option value="'.$masalar["id"].'">'.$masalar["ad"].'</option>';				  
				  endwhile;				  
				  ?>              
                </select></div>         
        		 <div class="col-md-12 font-weight-bold p-1 text-white">Kişi Adı
        		 </div>         
                <div class="col-md-12">
                <input name="kisi" type="text" class="form-control  mt-2" />                
                </div>  
                 <div class="col-md-12 font-weight-bold p-1 text-white">Saat </div>         
                  <div class="col-md-12">
                	<select name="rezervesaat" class="form-control mt-2">
                  <option value="0">Saat Seç</option>
                  <option value="00:00">00:00</option>    
                  <option value="01:00">01:00</option>
                  <option value="01:00">01:00</option>
                  <option value="03:00">03:00</option>
                  <option value="04:00">04:00</option>
                  <option value="05:00">05:00</option>
                  <option value="06:00">06:00</option>
                  <option value="07:00">07:00</option>
                  <option value="08:00">08:00</option>
                  <option value="09:00">09:00</option>
                  <option value="10:00">10:00</option>
                  <option value="11:00">11:00</option>
                  <option value="13:00">13:00</option>    
                  <option value="14:00">14:00</option>
                  <option value="15:00">15:00</option>
                  <option value="16:00">16:00</option>
                  <option value="17:00">17:00</option>
                  <option value="18:00">18:00</option>
                  <option value="19:00">19:00</option>
                  <option value="20:00">20:00</option>
                  <option value="21:00">21:00</option>
                  <option value="22:00">22:00</option>
                  <option value="23:00">23:00</option>                  
                </select>                             
                </div>
                <div class="col-md-12">
               <input type="button" id="rezervebtn" value="REZERVE ET" class="btn btn-info mt-4 mb-2"/>                
                </div>         
         </div>          
         </form>  
  </div>
</body>
</html>