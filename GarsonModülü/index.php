<?php 
include("fonksiyon/fonksiyon.php"); 
include_once("yon/fonk/temaiki.php"); 
$sistem = new sistem;
$tema3 = new temadestek;

$tema3->cookcon($db,true);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="pad/js/easy-numpad.js"></script>
<script src="dosya/jqu.js"></script>
<link rel="stylesheet" href="dosya/boost.css" >
<link rel="stylesheet" href="dosya/temaikistil.css" >
 <link rel="stylesheet" href="pad/css/easy-numpad.css">
<title>GİRİŞ EKRANI</title>

<script>
$(document).ready(function() {	


 $('#pad').hide();
	var numara5=5;

	$('#numarator'+numara5).on('click', function () {
		$(this).val("");
        show_easy_numpad(numara5);
		
    });
		
	$("#SelectBolum").html('<?php $tema3->GirisYetkiDurum($db,"garson"); ?>');
	
	
	$('input[name="bolum"]').change(function() { 
	$(".diger").css("color","#fff");
	$(".diger").css("background-color","#162f3b");	
	var deger = $('input[name="bolum"]:checked').val();	
	$(".r"+deger).css("color","#ffde00");	
	switch ($(this).val()) {
		
		case "1":	
		case "2":
		case "3":
		case "4":
		case "5":
		case "6":	
		
		$("#SelectBolum").html('<?php $tema3->GirisYetkiDurum($db,"garson"); ?>');
		$("#kriter").val("Garson");	
		break;		
		case "85":
		$("#SelectBolum").html('<?php $tema3->GirisYetkiDurum($db,"kasiyer"); ?>');
		$("#kriter").val("Kasiyer");		
		break;
		case "90":
		$("#SelectBolum").html('<?php $tema3->GirisYetkiDurum($db,"mutfak"); ?>');
		
		$("#kriter").val("Mutfak");		
		break;		
	}	
	
	});	
	});	
	</script>
</head>
<body style="background-color:#EEE;">
<div class="container text-center">
<div class="row mx-auto">        
        <div class="col-md-8  mx-auto text-center" id="girisiskelet">        
        		<div class="row">
                		<div class="col-md-4 border-right">                      
                        
                         <?php 
		@$buton=$_POST["buton"];
		if (!$buton) :	
		
		?>       
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="col-md-12 border-bottom p-2"><h3 id="yazi">GİRİŞ FORMU</h3></div>
        <div class="col-md-12" id="SelectBolum">        
        </div>
        <div class="col-md-12"><input type="password" name="sifre" class="form-control mt-2" required="required" placeholder="Şifreniz" id="numarator5" />      
        
        <input type="hidden" name="SorguTablo" value="Garson" id="kriter"/>
        </div>        
  <div class="col-md-12"><input type="submit" name="buton"  class="btn btn-info btn-block mt-2" value="GİRİŞ" /></div>
        
        <?php
		
		// echo md5(sha1(md5("1234")));
		
		else:
		@$sifre=htmlspecialchars(strip_tags($_POST["sifre"]));
		@$kulad=htmlspecialchars(strip_tags($_POST["kulad"]));
		@$SorguTablo=htmlspecialchars(strip_tags($_POST["SorguTablo"]));
		@$bolum=htmlspecialchars(strip_tags($_POST["bolum"]));
		
			if ($sifre=="" ||  $kulad=="" ||  $bolum=="") :
			
			echo "Bilgiler boş olamaz";		
			header("refresh:2,url=index.php");			
			else:	
			$tema3->giriskont($vt,$kulad,$sifre,$SorguTablo,$bolum);	
			endif;	
		endif;
       
        ?> 
         </div>     
                        <div class="col-md-8">                        
                        <div id="pad">                        
                        </div>
                        	<div class="row text-center">                            
                            	<div class="col-md-12 border-bottom p-2"><h3 id="yazi">GİRİŞ BÖLÜMÜ</h3>
                            	</div>
                                <?php $tema3->BolumleriGetir($db); ?>                            
                         <div class="col-md-6 p-2"><label class="btn m-1 btn-block diger r85" id="girisButon"><input name="bolum" type="radio" value="85"  />KASİYER</label> </div>
                          <div class="col-md-6 p-2"> <label class="btn m-1 btn-block diger r90" id="girisButon"><input name="bolum" type="radio" value="90"  />MUTFAK</label></div>                            
                             </div>                    
                        
                        </div>                
                </div>       
        </div>          
        </form>
</div>
</div>
</body>
</html>