<?php 

	include_once("fonksiyon/tema3fonk.php");
	$tema3 = new vipTema; 
	$tema3->cookcon($db,true);
	$veri=$tema3->genelsorgu2($db,"select * from garson where durum=1",1)->num_rows;
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="dosya/tema3.css"></script>
 	<script src="dosya/jqu.js"></script>
	<script src="pad/js/easy-numpad.js"></script>
	<link rel="stylesheet" href="pad/css/easy-numpad.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="dosya/tema3.css" >
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<title>Restaurant Sipariş Sistemi</title>
	<script>
$(document).ready(function() {
	$('#pad').hide();
	
    var numara5=5;
    
	$(".diger").css("color","#fff");
	$(".diger").css("background-color","#2b66a0");
    
    $('#numarator'+numara5).on('click', function () {
        $(this).val("");
        show_easy_numpad(numara5);
         });

   $("#selectBolum").html('<?php $tema3->GirisYetkiDurum($db,"garson"); ?>');
	
	
	$('input[name="bolum"]').change(function() {
	$(".diger").css("color","#fff");
	$(".diger").css("background-color","#2b66a0");	
	var deger = $('input[name="bolum"]:checked').val();	
	$(".r"+deger).css("background-color","#ffde00");
	
    switch ($(this).val())	
    {
		case "1":		
		case "2":		
		case "3":		
		case "4":

     $("#selectBolum").html('<?php $tema3->GirisYetkiDurum($db,"garson"); ?>');
      $("#kriter").val("Garson");

		break;
		case "85":	
		 $("#selectBolum").html('<?php $tema3->GirisYetkiDurum($db,"kasiyer"); ?>');
 			$("#kriter").val("Kasiyer");
			break;
		case "90":
		 $("#selectBolum").html('<?php $tema3->GirisYetkiDurum($db,"mutfak"); ?>');
		 $("#kriter").val("Mutfak");
		break;
	}	

	});	
	});	
	</script>
</head>
<body style="background-color:#000;">
<div class="container text-center"><div class="row mx-auto"> 
        <div class="col-md-6 girisiskelet  mx-auto mt-3 text-center m-" style="background-color:#d3e9ff;">
        	<div class="row border border-bottom" style="background-color: #2b2c3d; color: #fff;">
                        <div class="col-md-12">                          
                         <?php 
		@$buton=$_POST["buton"];
		if (!$buton) :			
		?>       
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="col-md-12 border-bottom p-1">
        	<h3 id="yazi">Giriş Bilgileriniz</h3></div>
        <div class="col-md-12" id="selectBolum">
        	</div>
        <div class="col-md-12">       	
        	<input type="text" name="sifre" class="form-control mt-2" required="required" placeholder="Şifreniz" id="numarator4"/>
        	<input type="hidden" name="SorguTablo" value="Garson" id="kriter"/></div> 

  <div class="col-md-12">
  	<input type="submit" name="buton" class="btn btn-info mt-2" value="İÇERİ GİR" girisbuton /><br><br>
  <!--Numlock burda geliyor-->
<div id="pad">  
        <?php		
		// echo md5(sha1(md5("1234")));		
		else:
		
		@$kulad=htmlspecialchars(strip_tags($_POST["kulad"]));
		@$sifre=htmlspecialchars(strip_tags($_POST["sifre"]));
		@$SorguTablo=htmlspecialchars(strip_tags($_POST["SorguTablo"]));
		@$bolum=htmlspecialchars(strip_tags($_POST["bolum"]));
		
			if ($sifre=="" || $kulad=="" || $bolum=="") :		
				
			echo "Bilgiler boş olamaz";			
			header("refresh:1,url=masalar.php");			
			else:	
			$tema3->giriskont($db,$kulad,$sifre,$SorguTablo,$bolum);	
			endif;		
		endif;
        ?>
         </div>       
<div class="row">
                        
                        <div class="col-md-12">                        
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
       </div>                
      </div> 
     </div> 
    </form> 
   </div>
  </div>
 </body>
</html>