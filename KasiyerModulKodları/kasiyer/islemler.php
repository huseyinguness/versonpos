<?php ob_start(); session_start(); include("../fonksiyon/fonksiyon.php"); $sistem= new sistem;
@$masaid=$_GET["masaid"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script src="../pad/js/easy-numpad.js"></script>
<script src="../dosya/islemler.js"></script>
<link rel="stylesheet" href="../dosya/boost.css" >
<link rel="stylesheet" href="../dosya/temaikistil.css" >
 <link rel="stylesheet" href="../pad/css/easy-numpad.css">
<link rel="stylesheet" href="../dosya/kasiyerStil.css" >
<title>Restaurant -KASİYER EKRANI</title>

</head>
<body>


<?php


function benimsorum2($vt,$sorgu,$tercih) {				
					$a=$sorgu;
					$b=$vt->prepare($a);
					$b->execute();
					if ($tercih==1):
					return $c=$b->get_result();				
					endif;	
					
}

function uyari($mesaj,$renk) {	
echo '<div class="alert alert-'.$renk.' mt-4 text-center">'.$mesaj.'</div>';	
}

function formgetir($masaid,$db,$baslik,$durum,$btnvalue,$btnid,$formvalue,$BolumTercih) {
	
	
	echo '<div class="card border-secondary m-3 mx-auto" style="max-width:18rem;">
	<div class="card-header">'.$baslik.'</div><div class="card-body text-success">
	
	<form id="'.$formvalue.'"> 
						 
						 <input type="hidden" name="mevcutmasaid" value="'.$masaid.'" />
						 
						 <select name="hedefmasa" class="form-control">'; 
						 
						
$masadeg=benimsorum2($db,"select * from masalar where durum=$durum and rezervedurum=0 and kategori=$BolumTercih",1); 
						
						while ($son = $masadeg->fetch_assoc()):
						
						if ($masaid!=$son["id"]) :
						echo '<option value="'.$son["id"].'">'.$son["ad"].'</option>';
						endif;
						
						
						
						endwhile;
						 
						 
						 
						    
                       echo'</select> <input type="button" id="'.$btnid.'" value="'.$btnvalue.'"  class="btn btn-success btn-block mt-2" /> </form></div></div>';	
	
}

function garsonbilgi($db) {
		
		$siparisler=benimsorum2($db,"select * from mutfaksiparis where durum=1 order by masaid desc",1);
		
		
			
		echo '<div class="col-md-12" id="bildirimlink">';
		
		while ($geldiler=$siparisler->fetch_assoc()) :
		$masaid=$geldiler["masaid"];
		
						$masaad=benimsorum2($db,"select * from masalar where id=$masaid",1);
						$masabilgi=$masaad->fetch_assoc();
		
		
		
		echo '<div class="alert alert-success" id="uy'.$geldiler["id"].'" >Masa : <strong>'.$masabilgi["ad"].'</strong> | Ürün : <strong>'.$geldiler["urunad"].'</strong> | Adet : <strong>'.$geldiler["adet"].'</strong> <a class="fas fa-check float-right m-1 text-danger" sectionId="'.$geldiler["id"].'" style="font-size:20px;"></a> </div>';
  
  
			endwhile;
  
  
  
 echo ' </div>';	
		
	}
	
function iskontogetir($masaid) {
	
	
	echo '<div class="card border-secondary m-3 mx-auto" style="max-width:18rem;">
	<div class="card-header"><b class="text-secondary">İSKONTO UYGULA </b><span id="kapatma"><a class="text-danger float-right"  sectionId="iskonto"><b>X</b></a></span></div><div class="card-body text-success ">
	
	<form id="iskontoForm"> 
						 
						 <input type="hidden" name="masaid" value="'.$masaid.'" />
						 
						 <select name="iskontoOran" class="form-control">
						 
						 <option value="5">5</option>
						 <option value="10">10</option>
						 <option value="15">15</option>
						 <option value="20">20</option>
						 <option value="25">25</option>
						 
						 </select> <input type="button" id="iskontobtn" value="UYGULA"  class="btn btn-success btn-block mt-2" /> </form></div></div>';	
	
}


function parcagetir($masaid) {
	
	
	echo '<div class="card border-secondary m-3  mx-auto" style="max-width:18rem;">
	<div class="card-header"><b class="text-secondary">PARÇA HESAP AL </b><span id="kapatma"><a class="text-danger float-right"  sectionId="parca"><b>X</b></a></span></div><div class="card-body text-success text-center">
	
	<form id="parcaForm"> 
						 
						 <input type="hidden" name="masaid" value="'.$masaid.'" />
						 
						 <input type="text" name="tutar" id="numarator3"  /> 
						 
									 
						 
						 <input type="button" id="parcabtn" value="ÖDE"  class="btn btn-success btn-block mt-2" /> </form></div></div>';	
	
} // parça hesap


function rezerveFonk($masaid,$db,$baslik,$durum,$btnvalue,$btnid,$formvalue) {
	
	
	echo '<div class="card border-secondary m-3 mx-auto" style="max-width:18rem;">
	<div class="card-header">'.$baslik.'</div><div class="card-body text-success">
	
	<form id="'.$formvalue.'"> ';
	
	
	if ($durum==0):
	echo '<input type="text" name="kisi" class="form-control mb-2" placeholder="Kişi Adı(Opsiyonel)">';
	
	endif;
	
	echo' <select name="hedefmasa" class="form-control">'; 
						 
						
$masadeg=benimsorum2($db,"select * from masalar where rezervedurum=$durum",1); 
						
						while ($son = $masadeg->fetch_assoc()):
						
						if ($masaid!=$son["id"]) :
						echo '<option value="'.$son["id"].'">'.$son["ad"].'</option>';
						endif;
						
						
						
						endwhile;
						 
						 
						 
						    
                       echo'</select> 
					   <input type="button" id="'.$btnid.'" value="'.$btnvalue.'"  class="btn btn-success btn-block mt-2" /> </form></div></div>';	
	
} // rezerve Temel fonks




@$islem=$_GET["islem"];

switch ($islem) :

case "iskontoUygula":

$iskontoOran=$_POST["iskontoOran"];
$masaid=$_POST["masaid"];


$verilericek=benimsorum2($db,"select * from anliksiparis where masaid=$masaid",1);
			
			while($don=$verilericek->fetch_assoc()):
		  	$urunid=$don["urunid"];
			$urunhesap=($don["urunfiyat"] / 100) * $iskontoOran; // 0.50
			$sonfiyat=$don["urunfiyat"]-$urunhesap;     // 4.50
			
	benimsorum2($db,"update anliksiparis set urunfiyat=$sonfiyat where urunid=$urunid",1); 		
			
		
			endwhile;	




break;


case "parcaHesapOde":

$tutar=$_POST["tutar"];
$masaid=$_POST["masaid"];

if (!empty($tutar)) :




$verilericek=benimsorum2($db,"select * from masabakiye where masaid=$masaid",1);

	if ($verilericek->num_rows==0) :
	//insert
	benimsorum2($db,"insert into masabakiye (masaid,tutar) VALUES($masaid,$tutar)",1);

	else:
	$mevcutdeger=$verilericek->fetch_assoc();	
	$sontutar=$mevcutdeger["tutar"] + $tutar;
	benimsorum2($db,"update masabakiye set tutar=$sontutar where masaid=$masaid",1); 
	// 
	
	echo $tutar; 
		
	
	endif;
	
	
	endif;
	
			
		


break;


case "masaislem":

$mevcutmasaid=$_POST["mevcutmasaid"];
$hedefmasa=$_POST["hedefmasa"];


benimsorum2($db,"update anliksiparis set masaid=$hedefmasa where masaid=$mevcutmasaid",1); 



				 /* MASANIN DURUMUNU GÜNCELLEYECEĞİM*/				 
				 $ekleson2=$db->prepare("update masalar set durum=0 where id=$mevcutmasaid");
				 $ekleson2->execute();				 
				  /* MASANIN DURUMUNU GÜNCELLEYECEĞİM*/
				  
				  	 /* MASANIN DURUMUNU GÜNCELLEYECEĞİM*/				 
				 $ekleson2=$db->prepare("update masalar set durum=1 where id=$hedefmasa");
				 $ekleson2->execute();				 
				  /* MASANIN DURUMUNU GÜNCELLEYECEĞİM*/



break; // MASA TAŞIMA

case "hesap":

		if (!$_POST):
		
		echo "Posttan gelmiyosun";
		
		else:
		
			$masaid=htmlspecialchars($_POST["masaid"]);
			$odemesecenek=htmlspecialchars($_POST["odemesecenek"]);
			
			
			$verilericek=benimsorum2($db,"select * from anliksiparis where masaid=$masaid",1);
			
			while($don=$verilericek->fetch_assoc()):
			$a=$don["masaid"];
			$b=$don["urunid"];
			$c=$don["urunad"];
			$d=$don["urunfiyat"];
			$e=$don["adet"];
			$garsonid=$don["garsonid"];			
			$bugun = date("Y-m-d");
			
			$raporekle="insert into rapor (masaid,garsonid,urunid,urunad,urunfiyat,adet,odemesecenek,tarih) VALUES($a,$garsonid,$b,'$c',$d,$e,'$odemesecenek','$bugun')";
			
			$raporekles=$db->prepare($raporekle);		
			$raporekles->execute();
			
			// önce ürüne ve stoğuna ulaşacağız
			
			$urunebak=benimsorum2($db,"select stok from urunler where id=$b",1);	
			$urunbilgi=$urunebak->fetch_assoc();
			
			if ($urunbilgi["stok"]!="Yok"):
			$urunStokSon=$urunbilgi["stok"] - $e;
			$raporekles=$db->prepare("update urunler set stok='$urunStokSon' where id=$b");		
			$raporekles->execute();
			
			endif;
			
			
			
			
			endwhile;	
	
			
			$silme=$db->prepare("delete from anliksiparis where masaid=$masaid");		
			$silme->execute();
			
			
			$silme2=$db->prepare("delete from masabakiye where masaid=$masaid");		
			$silme2->execute();
			
				 /* MASANIN DURUMUNU GÜNCELLEYECEĞİM*/				 
				 $ekleson2=$db->prepare("update masalar set durum=0 where id=$masaid");
				 $ekleson2->execute();				 
				  /* MASANIN DURUMUNU GÜNCELLEYECEĞİM*/
				  
				  
				   /* MASANIN LOG KAYDI*/		
				 	 
				 $ekleson23=$db->prepare("update masalar set saat=0, dakika=0 where id=$masaid");
				 $ekleson23->execute();				 
				  /* MASANIN LOG KAYDI*/
				
				
		
		endif;

break;



case "goster":					
					
 
 					$id=htmlspecialchars($_GET["id"]);
 
 					
				$d=benimsorum2($db,"select * from anliksiparis where masaid=$id",1);
				
	$verilericek=benimsorum2($db,"select * from masabakiye where masaid=$id",1);
		
					
					
					if ($d->num_rows==0) :					
					uyari("Henüz sipariş yok","danger");
					 /* MASANIN DURUMUNU GÜNCELLEYECEĞİM*/				 
				 $ekleson2=$db->prepare("update masalar set durum=0 where id=$id");
				 $ekleson2->execute();				 
				  /* MASANIN DURUMUNU GÜNCELLEYECEĞİM*/
					
					 /* MASANIN LOG KAYDI*/		
				 	 
				 $ekleson2=$db->prepare("update masalar set saat=0, dakika=0 where id=$id");
				 $ekleson2->execute();				 
				  /* MASANIN LOG KAYDI*/
					
					
					benimsorum2($db,"delete from masabakiye where masaid=$id",1);	
					
					
																	
					else:
					
					echo '<table class="table table-bordered  text-center mt-1">
					<tbody>
					<tr class="font-weight-bold">
					<td>Ürün Adı</td>
					<td>Adet</td>
					<td>Tutar</td>
					
					</tr>';
					$adet=0;
					$sontutar=0;
						while ($gelenson=$d->fetch_assoc()) :
						
						$tutar = $gelenson["adet"] * $gelenson["urunfiyat"];
						
						$adet +=$gelenson["adet"];
						$sontutar +=$tutar;
						$masaid=$gelenson["masaid"];
						
						
	$a1=benimsorum2($db,"select * from urunler where id=".$gelenson["urunid"],1)->fetch_assoc();					
	$a2=benimsorum2($db,"select * from kategori where id=".$a1["katid"],1)->fetch_assoc();						
						
						
						
						
						echo '<tr>
						<td class="mx-auto text-center p-4"><b>'.$a2["ad"].'</b><br>'.$gelenson["urunad"].'</td>
						<td class="mx-auto text-center p-4">'.$gelenson["adet"].'</td>
						<td class="mx-auto text-center p-4">'.number_format($tutar,2,'.',',').'</td>	
				
						</tr>';						
						endwhile;						
						echo '
						<tr class="bg-light text-dark text-center">
						<td class="font-weight-bold">TOPLAM</td>					
						<td class="font-weight-bold text-danger">'.$adet.'</td>
						<td colspan="2" class="font-weight-bold text-danger ">';
						
							if ($verilericek->num_rows!=0) :
		
							$masaninBakiyesi=$verilericek->fetch_assoc();
							
							$odenenTutar=$masaninBakiyesi["tutar"];
							$kalanTutar=$sontutar-$odenenTutar;
							
		echo '<p class="text-danger m-0 p-0"><del id="Toplamtut">'.number_format($sontutar,2,'.',','). " </del> | 
							
	<font class='text-success'>" . number_format($odenenTutar,2,'.',',')."</font><br>
	<font class='text-dark'>Ödenecek : ". number_format($kalanTutar,2,'.',',')."</font></p>" ;
							
							
							else:
							
							echo '<p class="text-danger m-0 p-0" ><b id="Toplamtut">'.number_format($sontutar,2,'.',','). "</b> TL</p> ";
		
							endif;
						
						
						
						
						 echo'</td></tr></tbody></table>';				
					
					endif;	 
 break; 
 
 	
		
		case "cikis":
		// buraya geleceğiz
				$kulad = $_COOKIE["kul"];
				$OturumTipi = $_COOKIE["OturumTipi"];
benimsorum2($db,"update $OturumTipi set durum=0,Aktifbolum=0 where ad='$kulad'",1);			
		
				setcookie("kul",$kulad, time() - 10 );
				setcookie("Oturumid","", time() - 10 );
				setcookie("OturumTipi",$OturumTipi, time() - 10 );
		
		header("Location:index.php");	
					
		break;
		
		case "garsonbilgigetir":
		
		garsonbilgi($db);
		
		break; // ÇIKIŞ
		
		
case "hazirurunsil":
		
		
		
		if (!$_POST):		
		echo "Posttan gelmiyosun";		
		else:		
		$id=htmlspecialchars($_POST["id"]);			
		
		$silme2=$db->prepare("delete from mutfaksiparis where id=$id");		
		$silme2->execute();			
		endif;
		
		break; // MUTFAK ÜRÜN SİL
		
		
case "rezerveet":
		
		if ($_POST):		
				
		$masaid=htmlspecialchars($_POST["hedefmasa"]);	
		$kisi=htmlspecialchars($_POST["kisi"]);	
		if ($kisi=="") :
		
		$kisi="Yok";
		endif;			
			
		
		$rezerveet=$db->prepare("update masalar set durum=1,rezervedurum=1,kisi='$kisi' where id=$masaid");		
		$rezerveet->execute();			
		endif;
		
		break; // REZERVE ET	
	
	
case "rezervelistesi":
		
		$siparisler=benimsorum2($db,"select * from masalar where rezervedurum=1",1);
		
		
			
		echo '<div class="col-md-12" id="rezervelistem">';
		
		while ($geldiler=$siparisler->fetch_assoc()) :	
		
		
		echo '<div class="alert alert-info" id="mas'.$geldiler["id"].'" >Masa : <strong>'.$geldiler["ad"].'</strong> Kisi : <strong>'.$geldiler["kisi"].'</strong> <a class="fas fa-check float-right m-1 text-danger" sectionId="'.$geldiler["id"].'" style="font-size:20px;"></a> </div>';
  
  
			endwhile;
  
  
  
 echo ' </div>';
		
		break;
		
case "rezervekaldir":
		
		if ($_POST):		
			
		$id=htmlspecialchars($_POST["hedefmasa"]);		
		
		$rezerveet=$db->prepare("update masalar set durum=0,rezervedurum=0,kisi='Yok' where id=$id");		
		$rezerveet->execute();				
				
		endif;
		
		break; // REZERVE LİSTESİ		
		
		

		
		case "butonlar":
		$masaid=htmlspecialchars($_GET["id"]);
		
	echo '<div class="row">
				<div class="col-lg-12 mt-2 table-info text-center pt-2 mb-2"><h4>MASA İŞLEM MENÜSÜ</h4>	</div>	
						
						
						 <div class="col-md-4">
						 
					
						
						<input type="button" id="btnn" value="HESAP AL" style="font-weight:bold; height:40px;" class="btn btn-dark col-lg-12  mt-1"   />
						
						
						
						
							  <div class="row text-center mt-2" id="odemeSecenek">
						 <div class="col-md-3  border border-secondary  m-1 mx-auto p-3 rounded" id="nakit">
								  	Nakit	   
								   
								   </div>
								   <div class="col-md-3 t border border-secondary m-1 mx-auto p-3 rounded" id="kredi">
								   K.Kartı
								   </div>
								   <div class="col-md-3  border border-secondary m-1 mx-auto p-3 rounded" id="ticket">
								   Ticket
								   </div>
								   
						</div>
						
						
						
						
						  <div class="row text-center mt-2 bg-light  border-top border-bottom" id="TercihNakit">
				  <div class="col-md-5  m-1 mx-auto">
								  	  
		  <input name="VerilenPara"  type="text" class="form-control" id="numarator2">
								   </div>
								   
		<div class="col-md-5 mt-1 mb-1 font-weight-bold rounded text-danger border border-danger  mx-auto p-2" id="ParaUstuSonuc"> Para üstü hesapla
								  	  
								  
								   </div>
								   
								   
								   
								   
						</div>';
						
						
						
						
					
						
						
							///---------------------------------
						
						echo '<div class="row text-center mt-2" id="OdemeFormu">
										   
								   
							 <div class="col-md-10  m-1 mx-auto">
								  	  
								<form id="hesapform"> 
						 <input type="hidden" name="odemesecenek" />    
						 <input type="hidden" name="masaid" value="'.$masaid.'" />    
                        <input type="button" id="odemeal" value="ÖDEME AL" style="font-weight:bold; height:40px;" class="btn btn-danger col-lg-12  mt-1"   />  </form>
								   </div>		   
								   
						</div>';
						
						 
							

				 
						 
						 
						echo'<p><a href="fisbastir.php?masaid='.$masaid.'" onclick="ortasayfa(this.href,\'mywindow\',\'350\',\'400\',\'yes\');return false" class="btn btn-dark btn-block mt-1" style="height:40px;" ><i class="fas fa-print mt-1"> FİŞ BASTIR</i></a></p> 
						 					 
						 </div>	
						 
						 
						 	 <div class="col-md-4">
										 <div class="row">
										 		<div class="col-md-12" id="islemlinkleri"><a  class="btn btn-dark btn-block mt-1 text-white" style="height:40px;" sectionId="degistir"><i class="fas fa-exchange-alt mt-1 float-left"> MASA DEĞİŞTİR</i></a> </div>
												
	 <div class="col-md-12" id="degistirform">'; formgetir($masaid,$db,"<b class='text-secondary'>MASA DEĞİŞTİR</b><span id='kapatma'><a class='text-danger float-right'  sectionId='degistir'><b>X</b></a></span>",0,"DEĞİŞTİR","degistirbtn","degistirformveri",$sistem->BolumTercihGetir($db)); echo'</div>
	 
	 												
												
												
												 <div class="col-md-12" id="islemlinkleri"><a  class="btn btn-dark text-white btn-block mt-1" style="height:40px;" sectionId="birlestir"><i class="fas fa-stream mt-1 float-left"> MASA BİRLEŞTİR</i></a>  </div>
												 
	 <div class="col-md-12" id="birlestirform">'; formgetir($masaid,$db,"<b class='text-secondary'>MASA BİRLEŞTİR</b><span id='kapatma'><a class='text-danger float-right' sectionId='birlestir'><b>X</b></a></span>",1,"BİRLEŞTİR","birlestirbtn","birlestirformveri",$sistem->BolumTercihGetir($db)); echo'</div>						 
												 
												 
										 </div>
										 
								 </div>
								 
								 
								 
								 
								 
								 	 <div class="col-md-4">
									 
										 <div class="row">
										 		<div class="col-md-12" id="islemlinkleri"><a  class="btn btn-dark text-white btn-block mt-1" style="height:40px;" sectionId="iskonto"><i class="fas fa-hand-holding-usd  mt-1 float-left"> İSKONTO</i></a> </div>
												
	<div class="col-md-12" id="iskontoform">'; iskontogetir($masaid); echo'</div>											
												
												
												 <div class="col-md-12" id="islemlinkleri"><a  class="btn btn-dark text-white btn-block mt-1" style="height:40px;" sectionId="parca"><i class="fas fa-cookie-bite mt-1 float-left"> PARÇA HESAP</i></a>  </div>
												 
	<div class="col-md-12" id="parcaform">'; parcagetir($masaid); echo'</div>											 
												 
												 
										 </div>
										 
									
									
										 
								 </div>
								 
								 
				<div class="col-lg-12 mt-2 table-info text-center pt-2 mb-2"><h4>GENEL İŞLEM MENÜSÜ</h4>	</div>					 
								 
								 
						
							 <div class="col-md-4">
									 
										 <div class="row">
							<div class="col-md-12" id="islemlinkleri"><a  class="btn btn-dark text-white btn-block mt-1" style="height:40px;" sectionId="rezerveyap"><i class="fas fa-address-book  mt-1 float-left"> REZEVASYON  YAP</i></a> </div>
												
	<div class="col-md-12" id="rezerveyapform">'; rezerveFonk($masaid,$db,"<b class='text-secondary'>REZEVASYON YAP</b><span id='kapatma'><a class='text-danger float-right' sectionId='rezerveyap'><b>X</b></a></span>",0,"REZERVE ET","rezerveetbtn","rezerveyapFormu"); echo'</div>											
												
											
												 <div class="col-md-12" id="islemlinkleri"><a  class="btn btn-dark text-white btn-block mt-1" style="height:40px;" sectionId="rezervekaldir"><i class="fas fa-angle-up mt-1 float-left"> REZEVASYON KALDIR</i></a>  </div>
												 
	<div class="col-md-12" id="rezervekaldirform">'; rezerveFonk($masaid,$db,"<b class='text-secondary'>REZEVASYON KALDIR</b><span id='kapatma'><a class='text-danger float-right' sectionId='rezervekaldir'><b>X</b></a></span>",1,"REZERVE KALDIR","rezervekaldirbtn","rezervekaldirFormu"); echo'</div>											 
												 
												 
										 </div>
										 
									
									
										 
								 </div>
						
								 
								 
								 
								 
								 
						 
						 					
						</div>';
		break;
		
		


		
		
		
endswitch;
?>

</body>
</html>