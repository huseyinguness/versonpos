<?php include_once("fonk/yonfok.php"); 
$clas= new yonetim;
//$clas->cookcon($db,true);
ob_start();
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script src="../dosya/jqu.js"></script>
<link rel="stylesheet" href="../dosya/boost.css" >
<title>Giriş</title>
<style>
#log {
margin-top:20%; 
min-height:250px;
background-color:#FEFEFE;	
border-radius:10px;
border:1px solid #B7B7B7;
}
</style>
</head>
<body style="background-color:#EEE;">
<div class="container text-center">
<div class="row mx-auto">

		<div class="col-md-4"></div>   
		     
        <div class="col-md-4  mx-auto text-center" id="log">        
        <?php 
		@$buton=$_POST["buton"];
		if (!$buton) :	
		
		?>       
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="col-md-12 border-bottom p-2"><h3>Yönetici Giriş</h3></div>
        <div class="col-md-12"><input type="text" name="kulad" class="form-control mt-2" required="required" placeholder="Yönetici Adınız" autofocus="autofocus" /></div>
        <div class="col-md-12"><input type="password" name="sifre" class="form-control mt-2" required="required" placeholder="Şifreniz" /></div>
        
  <div class="col-md-12"><input type="submit" name="buton" class="btn btn-success mt-2" value="GİRİŞ" /></div>
        </form>
        
        
        
        <?php
		
		echo md5(sha1(md5("1"))); 
		echo "<br> şifre 1";
		
		else:
		@$sifre=htmlspecialchars(strip_tags($_POST["sifre"]));
		@$kulad=htmlspecialchars(strip_tags($_POST["kulad"]));
		
			if ($sifre=="" ||  $kulad=="") :
			
			echo "Bilgiler boş olamaz";
			
			header("refresh:2,url=index.php");
			
			
			else:	
			$clas->giriskontrol($db,$kulad,$sifre);	
			
			
			endif;
		
		
		
		
		
		endif;
		
	
		
        
        ?>
        </div>
        
        
        
        
        
        
        
        
        <div class="col-md-4"></div>

</div>

</div>
</body>
</html>