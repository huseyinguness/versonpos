<?php 
include("fonksiyon/fonksiyon.php"); 
include_once("yon/fonk/temaiki.php"); 
$sistem = new sistem;
$tema2 = new temadestek;
// buraya giriş kontrol yapılacak

$tema2->cookcon($db,false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="dosya/jqu.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="stylesheet" href="dosya/stil.css" >
<title>Restaurant Sipariş Sistemi</title>
</head>
<body>
<div class="container-fluid">
	<div class="row">    
    			<?php $tema2->temaikimasalar($db); ?>
    </div>
<div class="row fixed-bottom altrow">
<div class="col-md-12  border-info font-weight-bold " >
				<div class="row">                
               	 <div class="col-md-2   Sagcizgi Solcizgi pl-5 pt-2" >                 
                 <i class="fas fa-chart-bar mt-4 icon3"></i>
                 <span class="icon2">Toplam sipariş <kbd class="bg-danger text-white"><?php $sistem->siparistoplam($db); ?></kbd></span></div>                   
                <div class="col-md-2  Sagcizgi pl-5 pt-2" > <i class="fas fa-percent mt-4 icon3">                    
                </i><span class="icon2">Doluluk oranı <kbd class="bg-danger text-white"><?php $sistem->doluluk($db); ?></kbd></span></div>                
               	 <div class="col-md-2  Sagcizgi pl-5 pt-2" ><i class="fas fa-utensils mt-4 icon3">                     
                 </i><span class="icon2">Toplam Masa <kbd class="bg-danger text-white"><?php $sistem->masatoplam($db); ?></kbd></span></div>                 
                <div class="col-md-2  Sagcizgi pl-5 pt-2" > <i class="fas fa-street-view mt-4 icon3">                    
                </i><span class="icon2">Garson <span class="text-danger"><?php $sistem->garsonbak($db); ?></span></span></div>                
                </div>
</div>
</div>
</div>
</body>
</html>