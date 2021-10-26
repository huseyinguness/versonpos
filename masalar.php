<?php 

include_once("fonksiyon/tema3fonk.php");
include_once("yon/fonk/temaiki.php"); 
$tema3 = new vipTema; 
$tema3->cookcon($db,false);
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
                                        <h5 class="pt-2" ><kbd class="bg-danger">
                                            <?php  echo $tema3->bekleyensatir($db); ?>                                            
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

  
   
</body>
</html>