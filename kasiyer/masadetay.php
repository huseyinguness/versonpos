<?php session_start(); 
include("fonksiyon/kasiyerfonksiyon.php"); 
$masam = new kasiyer;
include("../yon/fonk/temaiki.php"); 
$tema2 = new temadestek;

//$tema2->cookcon($db,false);


@$masaid=$_GET["masaid"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../dosya/jqu.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="stylesheet" href="../dosya/temaikistil.css" >
<link rel="stylesheet" href="../dosya/kasiyerStil.css" >
<link rel="stylesheet" href="dosya/tema3.css" >

<script>
$(document).ready(function() {	
	var id="<?php echo $masaid; ?>";	
	$("#veri").load("islemler.php?islem=goster&id="+id);
	$("#ButonlarAna").load("islemler.php?islem=butonlar&id="+id);
	
	$('input[name="iskonto"]').change(function() { 
	$(".diger").css("color","#58d0f8");
	var deger = $('input[name="iskonto"]:checked').val();	
	
	$(".lab"+deger).css("color","#FF6");
	
	});	
});
</script>
<title>Restaurant - KASİYER EKRANI</title>
</head>
<body>
<div class="container-fluid h-100">
<?php 
if ($masaid!="") :
$son=$masam->masagetir($db,$masaid);
$dizi=$son->fetch_assoc();
?> 
<div class="row justify-content-center h-100 ">
<!-- butonlar bölümü-->
                 <div class="col-md-8 " >
                  <div class="row h-100 "> 
                      <div class="col-md-12 mx-auto bg-white" id="ButonlarAna"></div> 
                      <div id="pad">
                      </div>                            
                      </div>   
                     </div> 
    <!-- butonlar bölümü-->
                <div class="col-md-4" >
                     <div class="row "> 
<!-- masa göster böülümü-->
      <div class="col-md-12 bg-dark border border-light " >                            
                          		 <div class="row">
                          		<div class="col-md-4 border-right border-light " id="a1">
                                 <a href="index.php" class="btn btn-success" style="margin-top:20px; margin-left:15px;	" >
                                 <i class="fas fa-arrow-left" style="font-size:38px;"></i></a></div>
                               <div class="col-md-8 text-center mx-auto p-3"  id="masaad"><?php echo $dizi["ad"]; ?>
                                  
                               </div>	
                              </div> 
                            </div>  
    <!-- masa göster böülümü-->                                                                                                   
<!-- göster böülümü-->
                            <div class="col-md-12" >                          
                            <div class="row">                           
                           <div class="col-md-12 mx-auto  bg-white  border-bottom border-right border-light" id="veri" ></div> 
    						</div>                
                        </div>
    <!-- göster böülümü-->

                        </div>                 
                </div>
</div>
<?php 
else:
	echo "hata var";
	header("refresh:1,url=index.php");
 endif; ?> 
</div>
</body>
</html>