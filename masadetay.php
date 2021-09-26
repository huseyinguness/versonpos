<?php 
session_start(); include ("fonksiyon/fonksiyon.php"); 
require_once 'baglan.php'; $masam = new sistem;

	$veri=$masam->benimsorgum2($db,"select * from garson where durum=1",1)->num_rows;
	if ($veri==0):
	 header("location:index.php");
	endif;

	@$masaid=$_GET["masaid"] ;
	?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="=text/html; charset=utf-8"/>
		
	 <script src="dosya/jquery.js"></script>
	 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" href="dosya/boost.css">
	<link rel="stylesheet" href="dosya/stil.css">
<script >
	$(document).ready(function()
	{	var id ="<?php echo $masaid; ?>"; 
	$("#veri").load("islemler.php?islem=goster&id="+id);
	$('#btnurunekle').click(function()	
	{
		$.ajax(
		{	
			type : "POST",
			url :'islemler.php?islem=ekle',
			data :$('#formum').serialize(),
			success : function(donen_veri){
			$("#veri").load("islemler.php?islem=goster&id="+id);
			$('#formum').trigger("reset");
			$("#cevap").html(donen_veri).slideUp(1400);
			
			},
		})
	})
	$('#urunler a').click(function()
	{
	var sectionId=$(this).attr('sectionId');
	$("#sonuc").load("islemler.php?islem=urun&katid=" + sectionId).fadeIn();
	})
	});
	</script>
<title>verson Pos Restorant sistemleri </title>	
<div class="container-fluid">

 </head>
    
     <body>
         <?php 
	if ($masaid!="") :
	$son=$masam->masagetir($db,$masaid);
	$dizi=$son->fetch_assoc();

	@$deger=$_GET["deger"];
	switch ($deger) 
	{
		case "1":

		$masam->siparisler($db,$dizi["id"]);

		break;	
	}
 ?>
<div class="row" id="stil1" >
<div class="col-md-2" id="urunler"	> 
	<p>Kategoriler	>></p>	
	<?php $masam->urungrup($db);?>			
</div>		
<!--orta bölüm-->
 <div class="col-md-6" >
	<div class="row" style="background-color:#FBFAF4">
		<!--Ürün gönderme bölümü-->
		<form id="formum">
			<!--Ürün gönderme bölümü-->
		<a>Ürünler >></a>
		<div class="col-md-12" id="sonuc" style="min-height: 550px;"></div>

	</div>
	<div class="row" id="stil4">
		<div class="col-md-12">
			<div class="row">
<!--Sayı bölümü-->
 <div class="col-md-6" id="stil4">
		       		<?php 
				 	for ($i=1; $i <=10 ; $i++) :
				 		echo '<label class="btn btn-success m-2"><input  name="adet" type="radio" value="'.$i.'">'.$i.'</label>	'; 	
				 	endfor;
				 	 ?>

 </div>		       
<!--ekle bölümü-->
		       <div class="col-md-6">

		       <input type="hidden" name="masaid" value="<?php echo $dizi["id"]; ?>"/>	
				<input type="button" class="btn btn-success btn-block mt-4" id="btnurunekle" value="EKLE" />
		       </div>
				 	</form>
		       
	         </div>
		</div>
	</div>
 </div>
<!--ürün listeleme bölüm-->

 <div class="col-md-4" id="stil2">
	<div class="row">

	
	<div class="col-md-12 border-bottom border-info bg-primary text-white text-center" id="stil3" ><br>
	<a href="index.php" class="btn btn-warning">Masalar</a>
	<br> <?php echo $dizi["ad"]; ?>  
	<br>
		 
	</div>
		<div class="col-md-12" id="veri"></div>		
		<div id="cevap"></div>
	</div>
 </div>
	
 </div>
<?php 
else:
	echo "hata var";
endif; 
?>
</div>
 </body>
 </html>