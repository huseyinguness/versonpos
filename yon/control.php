<?php  ob_start();  
include_once("fonk/yonfok.php"); 
include_once("fonk/temaiki.php"); 
$yokclas = new yonetim; 
$tema2 = new temadestek;
$yokclas->cookcont($db,false);

 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<title>Verson Pos Restaurant Kontrol</title>
<style>
	body {
	height:100%;
	width:100%;
	position:absolute;	
	}
	#lk:link, #lk:visited {
		color:#fff;
		text-decoration:none;
		font-size:18px;
		background-color:#17a2b8;
		margin:5px;
		padding:10px;
		border-radius:20px;
		padding-left:30px;	
	}
	#lk:hover {
		background-color:#50b7c7;	
	}

	#kivirt {
		border-radius:0px 0px 10px 0px;	
	}
</style>
<script language="javascript">
var popupWindow=null;
function ortasayfa(url,winName,w,h,scroll) 
	{
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;	
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;	
	settings='height='+h+',	width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	popupWindow=window.open(url,winName,settings)	
	}
$(document).ready(function()
  {	
	$('#anac').hide();
	
	$('a[data-confirm]').click(function(ev) 
	{ 	
			var href=$(this).attr('href');			
			if (!$('#dataConfirmModal').length) {
				$('body').append('<div class="modal fade" id="dataConfirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLongTitle">ONAY</h5></div><div class="modal-body"></div>   <div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">VAZGEÇ</button><a class="btn btn-primary" id="dataConfirmOK">SİL</a></div></div></div></div></div>');				
				$('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
				$('#dataConfirmOK').attr('href',href);
				$('#dataConfirmModal').modal({show:true});
				return false;				
			}	
	})	
	$('#goster').click(function() 
	{				
    $('#anac').slideToggle();
	})	
});
</script>
</head>
<body>
<div class="container-fluid " >
<div class="row" style="height:550px;" id="kivirt" >
      	  <div class="col-md-2 bg-info text-white " style="font-size:20px;"  id="kivirt">        
        	<div class="row">
                       <div class="col-md-12 text-center " >
                        <span style="font-size:30px; color:#fff;">
                        <a href="control.php" style="color:#fff;"><i class="fas fa-user"></i></a>
                        </span>
                        <a href="control.php" class="btn btn-info"><?php echo  $yokclas->kulad($db); ?></a>                        
                        <a href="control.php?islem=cikis">
                        <span style="font-size:20px; color:#fff;" class="float-right mt-3">
                        <i class="fas fa-share-square"></i>
                        </span></a>
                        <hr class="bg-info" />
                </div> 
                   <a href="control.php?islem=masayon" id="lk" class="col-md-11"> <i class="fas fa-file-medical-alt"></i><span style="margin-left:10px;">Masalar</span></a>
                   <a href="control.php?islem=urunyon" id="lk" class="col-md-11"> <i class="fas fa-torah"></i><span style="margin-left:10px;">Ürünler</span></a>                 
                   <a href="control.php?islem=katyon" id="lk" class="col-md-11">  <i class="fas fa-receipt"></i> <span style="margin-left:10px;">Kategoriler</span></a>
                   <a href="control.php?islem=garsonyon" id="lk" class="col-md-11"> <i class="fas fa-street-view"></i><span style="margin-left:10px;">Garsonlar</span></a>
                   <a href="control.php?islem=garsonper" id="lk" class="col-md-11"> <i class="fas fa-chart-line"></i><span style="margin-left:10px;">Garson Rapor</span></a>
                   <a href="control.php?islem=raporyon"  id="lk" class="col-md-11"> <i class="fas fa-calculator" ></i> <span style="margin-left:10px;">Raporlar </span></a>
                   <a href="control.php?islem=sifdeg" id="lk" class="col-md-11">  <i class="fas fa-sync"></i><span style="margin-left:10px;">Şifre Değiştir</span></a>
                    <a href="control.php?islem=bakim" id="lk" class="col-md-11">  <i class="fas fa-hammer"></i><span style="margin-left:10px;">Bakım</span></a> 
                  <?php  $tema2->tas2linkkontrol($db);?>                
            </div> 
        </div>        
        <div class="col-md-10" >

        	<div class="row bg-info" style="min-height: 40px;">
			<div class="col-md-12 text-center"> <h3>VERSON RESTORANT  POS SİSTEM YÖNETİMİ</h3> </div>
		</div>
         <?php 
	
@$islem=$_GET["islem"];	
	switch ($islem) :	
	//-----------------------------	
	case "masayon":
	$yokclas->masayon($db);	
	break;	
	case "masasil":
	$yokclas->masasil($db);	
	break;	
	case "masaguncel":
	$yokclas->masaguncel($db);	
	break;
	case "masaekle":
	$yokclas->masaekle($db);	
	break;	
	//-----------------------------			
	case "urunyon":
	$yokclas->urunyon($db,0);	
	break;	
	case "urunsil":
	$yokclas->urunsil($db);	
	break;	
	case "urunguncel":
	$yokclas->urunguncel($db);	
	break;	
	case "urunekle":
	$yokclas->urunekle($db);	
	break;	
	case "katgore":
	$yokclas->urunyon($db,2);		
	break;
	case "aramasonuc":
	$yokclas->urunyon($db,1);	
	break;
	case "siralama":
	$yokclas->urunyon($db,3);	
	break;
	//-----------------------------
	case "katyon":
	$yokclas->kategoriyon($db);	
	break;
	case "katekle":
	$yokclas->katekle($db);	
	break;
	case "katsil":
	$yokclas->katsil($db);	
	break;
	case "katguncel":
	$yokclas->katguncel($db);	
	break;	
	//-----------------------------	
	case "raporyon":
	$yokclas->rapor($db);
	break;
	case "sifdeg":	
	$yokclas->sifredegis($db);	
	break;	
	case "cikis":		
	$yokclas->cikis($db,$yokclas->kulad($db));		
	break;
	//-----------------------------	
	case "garsonyon":
	$yokclas->garsonyon($db);	
	break;
	case "garsonekle":
	$yokclas->garsonekle($db);	
	break;
	case "garsonsil":
	$yokclas->garsonsil($db);	
	break;
	case "garsonguncel":
	$yokclas->garsonguncel($db);	
	break;
	case "garsonper":	
	$yokclas->garsonper($db);	
	break;
	//-----------------------------	
	case "yonayar":
	$yokclas->yoneticiayar($db);	
	break;
	case "yonekle":
	$yokclas->yonekle($db);	
	break;
	case "yonsil":
	$yokclas->yonsil($db);	
	break;
		case "yonguncel":
	$yokclas->yonguncel($db);	
	break;
	
	case "bakim":
	$yokclas->bakim($db);	
	break;
	default;	
  ?>

<!-- ANA SAYFADAKİ İSTATİSTİK ALT KISMI KAPATMA KODU -->

 <a class="text-white btn btn-success btn-sm" id="goster" >Tümünü Göster / Kapat</a> 

<!-- ANA SAYFADAKİ İSTATİSTİK AÇIK  TABLO --> 
<div class="row mt-4"> 
        
        <div class="col-md-3">
           <div class="card border-info p-2" >                   
          <div class="card-body text-info text-center">
          <i class="fas fa-chart-bar" style="font-size:30px;"></i>
          <HR />
            <h5 class="card-title">TOPLAM SİPARİŞ</h5>
            <p class="card-text" style="font-size:20px;"><kbd><?php $yokclas->topurunadet($db); ?></kbd></p> 
             </div>
  
			</div>          
        </div>

    <div class="col-md-3">
      <div class="card border-info p-2" >  
         <div class="card-body text-info text-center">
        	 <i class="fas fa-percent" style="font-size:30px;"></i>
        	 <HR />  
        	 <h5 class="card-title">DOLULUK ORANI</h5>
        	 <p class="card-text" style="font-size:20px;"><kbd><?php $yokclas->doluluk($db); ?></kbd></p>
  		</div>
  
	  </div>
    </div>  

        
    <div class="col-md-3">
         <div class="card border-info p-2" >  
         <div class="card-body text-info text-center">
         <i class="fas fa-utensils" style="font-size:30px;"></i>
         <HR />  
         <h5 class="card-title">TOPLAM MASA</h5>
         <p class="card-text" style="font-size:20px;"><kbd><?php $yokclas->toplammasa($db); ?></kbd></p>
        </div>  
       </div>
   </div>   


  <div class="col-md-3">
    <div class="card border-info p-2" >  
  			<div class="card-body text-info text-center">
   			<i class="fas fa-wine-bottle" style="font-size:30px;"></i>
   			<HR />
   			 <h5 class="card-title">TOPLAM ÜRÜN</h5>
   			 <p class="card-text" style="font-size:20px;"><kbd><?php $yokclas->toplamurun($db); ?></kbd></p>
  			</div>  
    </div>
   </div> 
</div>
<!-- ANA SAYFADAKİ İSTATİSTİK AÇIK  TABLO -->

<!-- ANA SAYFADAKİ İSTATİSTİK KAPANAN  TABLO -->
		<div id="anac">
        
		<div class="row mt-4">             
            <div class="col-md-3">
         <div class="card border-warning p-2" >  
  		<div class="card-body text-info text-center">
  		 <i class="fas fa-receipt" style="font-size:30px;"></i>
 		<HR />
   		 <h5 class="card-title">TOPLAM KATEGORİ</h5>
   		 <p class="card-text" style="font-size:20px;"><kbd><?php $yokclas->toplamkat($db); ?></kbd></p>
  		</div>
  
		</div>
        </div> 
        
          <div class="col-md-3">
         <div class="card border-warning p-2" >  
  		<div class="card-body text-info text-center">
  		 <i class="fas fa-street-view" style="font-size:30px;"></i>
 		<HR />
   		 <h5 class="card-title">TOPLAM GARSON</h5>
   		 <p class="card-text" style="font-size:20px;"><kbd><?php $yokclas->toplamgarson($db); ?></kbd></p>
  		</div>
  
		</div>
        </div>  
   <div class="col-md-3">
         <div class="card border-warning p-2" >  
  		<div class="card-body text-info text-center">
  		 <i class="far fa-money-bill-alt" style="font-size:30px;"></i>
 		<HR />
   		 <h5 class="card-title">MASA SİPARİŞ</h5>
   		 <p class="card-text" style="font-size:20px;"><kbd><?php $yokclas->toplamkasa($db); ?></kbd></p>
  		</div>  
		</div>
        </div> 


   <div class="col-md-3">
         <div class="card border-warning p-2" >  
  		<div class="card-body text-info text-center">
  		 <i class="fas fa-sign-out-alt" style="font-size:30px;"></i>
 		<HR />
   		 <h5 class="card-title">GÜNLÜK KASA</h5>
   		 <p class="card-text" style="font-size:20px;"><kbd><?php $yokclas->anlikkasa($db); ?></kbd></p>
  		</div>  
		</div>
        </div> 
 </div>

       </div>
<!-- ANA SAYFADAKİ İSTATİSTİK KAPANAN  TABLO -->

<!-- ANA SAYFADAKİ ALT KISIMDAKİ TABLO -->
    <div class="row mt-4"> 
                     <div class="col-md-6">                     
                     	<div class="card border-info p-2" >  
                        <div class="card-body text-dark">                         
                         <h5 class="card-title">Masa Yönetimi <a href="control.php?islem=masaekle" class="btn btn-sm text-white" style="background-color:#17a2b8;">Ekle</a> </h5>
                         <p class="card-text" style="font-size:20px;"><?php  $tema2->defmasayon($db);	 ?> </p>
                        </div>                  
                        </div>                      
                     </div>
                     
                       <div class="col-md-6">
                            <div class="card border-info p-2" >  
                            <div class="card-body text-dark">                             
                             <h5 class="card-title">Ürün Yönetimi <a href="control.php?islem=urunekle" class="btn btn-sm text-white" style="background-color:#17a2b8;">Ekle</a></h5>
                             <p class="card-text" style="font-size:20px;"><?php  $tema2->defurunyon($db,0);	 ?> </p>
                            </div>                      
                            </div>
                        </div>            
    </div>
<!-- ANA SAYFADAKİ ALT KISIMDAKİ TABLO -->

			
<?php
	endswitch;	
?>   
 </div>
</div>
</div>
</body>
</html>