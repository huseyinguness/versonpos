<?php require_once 'yonetim_fonksiyon/yonfonksiyon.php';
$yonetimclass= new yonetim;
$yonetimclass->cookcont($vt,false);
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
<script src="../Dosya/jquer.js"></script>
<link rel="stylesheet" href="../Dosya/boost.css">
<title>Verson Pos Restorant Kontrol </title>
<style>
	body
	{
		height: 100%;
		width: 100%;
		position: absolute;
	}
	.container-fluid,
	.row-fluid
	{
		height: inherit;
	}
	#lk:link, #lk:visited
	{
		color: #888;
		text-decoration: none;
	}
	#lk:hover
	{
		color: #000;
	}

 </style>
<script language="javascript">
	var popupWindow=null;

	function ortasayfa(url,winName,w,h,scroll)
	{
		LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
		ToptPosition = (screen.height) ? (screen.height-h)/2 : 0;
		settings='height='+h+', width='+w+',top='+ToptPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'

		popupWindow=window.open(url,winName,settings)
	}
</script>


</head>
<body>
	<div class="container-fluid bg-light">
		<div class="row row-fluid">
			<div class="col-md-2 border-right bg-primary" style="min-height: 500px;">

			<div class="row">
				<div class="col-md-12 bg-light p-4 mx-auto text-center font-weight-bold">
					<h4>Hoşgeldin : <?php echo $yonetimclass->kulad($vt); ?> </h4>
				</div>
</div> 
<!-- MENÜLER -->	
			<div class="row">
				<div class="col-md-12 bg-light p-2 pl-3 border-bottom border-top text-white">
					<a href="control.php?islem=anasayfa" id="lk"> Ana Sayfa </a>
				</div> 
				<div class="col-md-12 bg-light p-2 pl-3 border-bottom border-top text-white">
					<a href="control.php?islem=masayonetimi" id="lk"> Masalar </a>
				</div> 			
				<div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
					<a href="control.php?islem=urunyonetimi" id="lk"> Ürünler </a>
				</div> 			
				<div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
					<a href="control.php?islem=kategoriyonetimi" id="lk"> Kategoriler </a>
				</div> 	
				<div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
					<a href="control.php?islem=garsonyonetimi" id="lk"> Garsonlar </a>
				</div> 

				<div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
					<a href="control.php?islem=raporyon&tar=bugun" id="lk"> Raporlar </a>
				</div> 			
				<div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
					<a href="control.php?islem=sifredegis" id="lk"> Şifre Değiştir </a>
				</div> 
			 
			
				<div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
					<a href="control.php?islem=cikis" id="lk"> Çıkış </a>
				</div> 
<!--MENÜ ALTI TABLO	-->	
 <table class="table text-center table-light table-bordered mt-2 table-striped">
					<thead>					
						<tr class="table-warning">
							<th scope="col" colspan="4"> ANLIK DURUM</th>
						</tr>					
					</thead>
						<tbody>
							<tr>
								<th scope="col" colspan="3"> T.Sipariş :</th>
								<th scope="col" colspan="1" class="text-danger"> <?php $yonetimclass->topurunadet($vt); ?></th>
							</tr>
							<tr>
								<th scope="col" colspan="3"> Doluluk  :</th>
								<th scope="col" colspan="1" class="text-danger"><?php $yonetimclass->doluluk($vt); ?></th>
							</tr>
							<tr>
								<th scope="col" colspan="3"> T. Masa :</th>
								<th scope="col" colspan="1" class="text-danger"> <?php $yonetimclass->toplammasa($vt); ?></th>
							</tr>
							<tr>
								<th scope="col" colspan="3"> T. Kategori :</th>
								<th scope="col" colspan="1" class="text-danger"> <?php $yonetimclass->toplamkategori($vt); ?></th>
							</tr>
							<tr>
								<th scope="col" colspan="3"> T. Ürün :</th>
								<th scope="col" colspan="1" class="text-danger"> <?php $yonetimclass->toplamurun($vt); ?></th>
							</tr>
						</tbody>
				</table>
			</div> 
  </div>
<!--ÜST KISIM -->

	<div class="col-md-10">
			<div class="row bg-warning" style="min-height: 40px;">
			<div class="col-md-12 text-center"> <h3>VERSON RESTORANT  POS SİSTEM YÖNETİMİ</h3> </div>
		</div>
		<div class="row" style="min-height: 700px; background-color: #EEE;">
 <div class="col-md-12 mt-2 bg-white border-dark " style="border-radius: 15px;">

 
               



<?php 
//case işlemler
				@$islem=$_GET["islem"];

				switch ($islem) :
//Masa Yönetimi	
				case "masayonetimi":
				$yonetimclass->masayonetimi($vt);
				break;

				case "masasil":
				$yonetimclass->masasil($vt);
				break;

				case "masaguncelle":
				$yonetimclass->masaguncelle($vt);
				break;

				case "masaekle":
				$yonetimclass->masaekle($vt);
				break;
				//--------------------------------------------
//Ürün Yönetimi	
				case "urunyonetimi":
				$yonetimclass->urunyonetimi($vt,0);
				break;

				case "urunsil":
				$yonetimclass->urunsil($vt);
				break;

				case "urunguncelle":
				$yonetimclass->urunguncelle($vt);
				break;

				case "urunekle":
				$yonetimclass->urunekle($vt);
				break;				
				case "aramasonuc":
				$yonetimclass->urunyonetimi($vt,1);
				break;
				case "katagoriyegore":
				$yonetimclass->urunyonetimi($vt,2);
				break;
//Kategori Yönetimi

				case "kategoriyonetimi":
				$yonetimclass->kategoriyonetimi($vt);
				break;

				case "kategorisil":
				$yonetimclass->kategorisil($vt);
				break;

				case "kategoriguncelle":
				$yonetimclass->kategoriguncelle($vt);
				break;

				case "kategoriekle":
				$yonetimclass->kategoriekle($vt);
				break;
//garson Yönetimi

				case "garsonyonetimi":
				$yonetimclass->garsonyonetimi($vt);
				break;

				case "garsonsil":
				$yonetimclass->garsonsil($vt);
				break;

				case "garsonguncelle":
				$yonetimclass->garsonguncelle($vt);
				break;

				case "garsonekle":
				$yonetimclass->garsonekle($vt);
				break;				
//rapor Yönetimi
				case "raporyon":
				$yonetimclass->rapor($vt);
				break;
//şifre Yönetimi
				case "sifredegis":
				$yonetimclass->sifredegis($vt);
				break;
//çıkış Yönetimi

				case "cikis":

				$yonetimclass->cikis($yonetimclass->kulad($vt));

				break;

			endswitch;	
?>
			</div>
		</div>
	</div>
</div>
</div>
</body>
</html>