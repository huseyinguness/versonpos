<?php 
require_once 'yonetim_fonksiyon/yonfonksiyon.php';
require_once 'yonetim_fonksiyon/baglan.php';
$class= new yonetim;
$class->cookcont($vt,true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
<script src="../Dosya/jquer.js"></script>
<link rel="stylesheet" href="../Dosya/boost.css">

<title>Verson Pos Restorant Kontrol </title>
<style>
#log
{
margin-top: 15%; 
min-height: 300px;
background-color: #fEfEfE;
border-radius: 10px;
border: 1px solid #b7b7b7;
}
</style>
</head>
<body style="background-color: #EEE;">
	<div class="row mx-auto">

		<div class="col-md-4"></div>
		<div class="col-md-4 mx-auto text-center" id="log">
			<?php 
			@$buton=$_POST["buton"];
			if (!$buton) :

			 ?>


			<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

			<div class="col-md-12 border-bottom p-2"><h3>Verson Restorant Pos Sistem <br><- Yönetici Giriş -></h3></div><br>
			<div class="col-md-12"><input type="text" class="form-control" name="kulad" required="required" placeholder="Yönetici Adı" autofocus="autofocus"></div><br>
			<div class="col-md-12"><input type="password" class="form-control" name="sifre" required="required" placeholder="Şifre"></div><br>
			<div class="col-md-12"><input type="submit" class="btn btn-success" name="buton" value="GiRİŞ"></div>
			</form>

			<?php 
			// echo md5(sha1(md5("huseyin")));

		else :
		@$sifre=htmlspecialchars(strip_tags($_POST["sifre"]));
	    @$kulad=htmlspecialchars(strip_tags($_POST["kulad"]));
		

		if ($sifre=="" || $kulad=="") :

			echo "bilgiler boş olamaz";

			header("refresh:2,url=index.php");

		else:
			$class->giriskontrol($vt,$kulad,$sifre);
		
		endif;

endif;
			 ?>





















		</div>
		<div class="col-md-4"></div>
	</div>

</body>
</html>