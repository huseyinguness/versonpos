<?php ob_start(); session_start(); 
	include("fonksiyon/tema3fonk.php");
	$tema3= new vipTema;
	@$masaid=$_GET["masaid"];
 	 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="pad/js/easy-numpad.js"></script>
	<script src="dosya/jqu.js"></script>
	<script src="dosya/islemler.js"></script>
	<link rel="stylesheet" href="dosya/boost.css" >
	<link rel="stylesheet" href="dosya/tema3.css" >
	<link rel="stylesheet" href="pad/css/easy-numpad.css">
<title>Restaurant Sipariş Sistemi</title>
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
function uyarimesaj($mesaj,$renk) {	
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
		echo '<table class="table table-bordered table-striped bg-white text-center  anasayfaTablo p-1" id="bildirimlink">
		
		<tbody>
		<tr class="font-weight-bold">		
		<td>MASA</td>
		<td>ÜRÜN</td>
		<td>ADET</td>
		<td>İŞLEM</td>
		</tr>';
		
		while ($geldiler=$siparisler->fetch_assoc()) :
		$masaid=$geldiler["masaid"];
		
						$masaad=benimsorum2($db,"select * from masalar where id=$masaid",1);
						$masabilgi=$masaad->fetch_assoc();
						
						
				echo '	<tr>
                    
						<td class="text-center border-0 mx-auto  p-0 m-0">
						'.$masabilgi["ad"].'
						</td>
						
						<td class="text-center border-0 mx-auto  p-0 m-0">
						'.$geldiler["urunad"].'
						</td>
						
						<td class="text-center border-0 mx-auto  p-0 m-0">
						'.$geldiler["adet"].'
						</td>
						
						<td class="text-center border-0 mx-auto  p-0 m-0">
						<a class="fas fa-check  m-1 text-danger" sectionId="'.$geldiler["id"].'" style="font-size:20px;" id="uy'.$geldiler["id"].'"></a>
						</td>
						
				
									
						</tr>';		
		
		
		
		
  
  
			endwhile;
  
  
  
  echo '</tbody></table>';	
		
	}	
function iskontogetir($masaid) {
	echo '<div class="card border-secondary m-3 mx-auto" style="max-width:18rem;">
	<div class="card-header"><b class="text-secondary">İSKONTO</b><span id="kapatma">
	<a class="text-danger float-right"  sectionId="iskonto"><b>X</b></a></span></div><div class="card-body text-success ">
	<form id="iskontoForm"> 					 
						 <input type="hidden" name="masaid" value="'.$masaid.'" />						 
						 <select name="iskontoOran" class="form-control">						 
						 <option value="2,5">5</option>
						 <option value="5">10</option>
						 <option value="7,5">15</option>
						 <option value="10">20</option>
						 <option value="12,5">25</option>						 
						 </select> <input type="button" id="iskontobtn" value="UYGULA"  class="btn btn-success btn-block mt-2" /> </form></div></div>';
  }
function parcagetir($masaid) {
	
	
	echo '<div class="card border-secondary m-3  mx-auto" style="max-width:18rem;">
	<div class="card-header"><b class="text-secondary">PARÇA HESAP</b><span id="kapatma">
	<a class="text-danger float-right"  sectionId="parca"><b>X</b></a></span></div><div class="card-body text-success text-center">	
	<form id="parcaForm">					 
						 <input type="hidden" name="masaid" value="'.$masaid.'" />						 
						 <input type="text" name="gtutar" id="numarator1" class="form-control" /> 
						 <input type="button" id="parcabtn" value="ÖDE"  class="btn btn-success btn-block mt-2" /> </form></div></div>';	
   }
 // parça hesap
@$islem=$_GET["islem"];
switch ($islem) :
case "iskontoUygula":
			$iskontoOran=$_POST["iskontoOran"];
			$masaid=$_POST["masaid"];
			$verilericek=benimsorum2($db,"select * from anliksiparis where masaid=$masaid",1);			
			while($don=$verilericek->fetch_assoc()):
		  	$urunid=$don["urunid"];
			$urunhesap=($don["urunfiyat"] / 100) * $iskontoOran; // 0.50
			$sonfiyat=$don["urunfiyat"]-$urunhesap;             // 4.50			
			benimsorum2($db,"update anliksiparis set urunfiyat=$sonfiyat where urunid=$urunid",1); 		
			endwhile;
			break;
case "parcaHesapOde":

				$gtutar=$_POST["gtutar"];
				$masaid=$_POST["masaid"];
				if (!empty($gtutar)) :
				$verilericek=benimsorum2($db,"select * from masabakiye where masaid=$masaid",1);

					if ($verilericek->num_rows==0) :
					//insert
					benimsorum2($db,"insert into masabakiye (masaid,tutar) VALUES ($masaid,$gtutar)",1);
					$mevcutdeger=$verilericek->fetch_assoc();	
					else:
					
					$sontutar=$mevcutdeger["tutar"] + $gtutar;
					benimsorum2($db,"update masabakiye set tutar=$sontutar where masaid=$masaid",1); 
				// 	
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
			
			$verilericek1=benimsorum2($db,"select * from anliksiparis where masaid=$masaid",1);
			
			while($don1=$verilericek1->fetch_assoc()):
			$a=$don1["masaid"];
			$b=$don1["urunid"];
			$c=$don1["urunad"];
			$d=$don1["urunfiyat"];
			$e=$don1["adet"];
			$garsonid=$don1["garsonid"];			
			$bugun = date("Y-m-d");
			
			$raporekle="insert into rapor (masaid,garsonid,urunid,urunad,urunfiyat,adet,odemesecenek,tarih) VALUES($a,$garsonid,$b,'$c',$d,$e,'$odemesecenek','$bugun')";
			
			$raporekles=$db->prepare($raporekle);		
			$raporekles->execute();
				header("location:masalar.php");
				$urunbak=benimsorum2($db,"select stok from urunler where id=$b",1);		
				$urunbilgi=$urunbak->fetch_assoc();
			    if ($urunbilgi["stok"]!="Yok"):
				$urunStokSon=$urunbilgi["stok"] - $e;
				$raporekles=$db->prepare("update urunler set stok='$urunStokSon' where id=$b");	
				$raporekles->execute();				
			     endif;

			endwhile;	
	
			// anlık sipariş siliniyor
			$silme=$db->prepare("delete from anliksiparis where masaid=$masaid");		
			$silme->execute();

			//masa bakiye siliniyor
			$silme2=$db->prepare("delete from masabakiye where masaid=$masaid");		
			$silme2->execute();

			//mutfak durum 1 yapılıyor
			$silme1=$db->prepare("update mutfaksiparis set durum=1 where urunid=$b and masaid=$a");
			$silme1->execute();
			
			 /* MASANIN DURUMUNU GÜNCELLEYECEĞİM*/				 
			 $ekleson2=$db->prepare("update masalar set durum=0 where id=$masaid");
			 $ekleson2->execute();
			  
			   /* MASANIN LOG KAYDI*/	    	 
			 $ekleson23=$db->prepare("update masalar set saat=0, dakika=0 where id=$masaid");
			 $ekleson23->execute();				 
			  /* MASANIN LOG KAYDI*/
				
				
		
		endif;

	break;
case "sil":

		if (!$_POST):		
		echo "Posttan gelmiyosun";		
		else:		
		$urunid=htmlspecialchars($_POST["urunid"]);
		$masaid=htmlspecialchars($_POST["masaid"]);
			
		$sorgu="delete from anliksiparis where urunid=$urunid and masaid=$masaid";
		$silme=$db->prepare($sorgu);		
		$silme->execute();	
		
		$sorgu2="delete from mutfaksiparis where urunid=$urunid and masaid=$masaid";
		$silme2=$db->prepare($sorgu2);		
		$silme2->execute();			
		endif;

  break; // SİLME
case "goster":
					
 
 			     $id=htmlspecialchars($_GET["id"]); 					
				 $d=benimsorum2($db,"select * from anliksiparis where masaid=$id",1);		
	             $verilericek=benimsorum2($db,"select * from masabakiye where masaid=$id",1);					
					if ($d->num_rows==0) :					
					uyarimesaj("Henüz sipariş yok","danger");


					 /* MASANIN DURUMUNU GÜNCELLEYECEĞİM*/				 
				 $ekleson2=$db->prepare("update masalar set durum=0 where id=$id");
				 $ekleson2->execute();				 
				  /* MASANIN DURUMUNU GÜNCELLEYECEĞİM*/
					
					 /* MASANIN LOG KAYDI*/		
				 	 
				 $ekleson2=$db->prepare("update masalar set saat=0, dakika=0 where id=$id");
				 $ekleson2->execute();		
				 benimsorum2($db,"delete from masabakiye where masaid=$id",1);		 
				  /* MASANIN LOG KAYDI*/											
					else:					
					echo '<table class=" table table-bordered table-striped bg-white text-center gostertablo ">
					<tbody>
					<tr class="font-weight-bold">
					<td  class="p-2" >Ürün Adı</td>
					<td  class="p-2">Adet</td>
					<td  class="p-2">Tutar</td>
					<td  class="p-2">İşlem</td>
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
						<td class="p-2">
						<b>'.$a2["ad"].'</b>
						<br>'.$gelenson["urunad"].'</td>						
						<td class="p-2">'.$gelenson["adet"].'</td>
						<td class="p-2">'.number_format($tutar,2,'.',',').'</td>	
	                    <td id="yakala" class="p-2">
	                    <a class="btn btn-danger mt-2 text-white" sectionId="'. $gelenson["urunid"].'" sectionId2="'.$masaid.'">
	                    <i class="fas fa-trash-alt"></i></a></td>				
						</tr>';						
						endwhile;	




						 echo'					
						</tbody></table>';
						echo'<div class="row">
						<div class="col-md-12" > 
						<table class=" table table-bordered table-striped bg-white text-center gostertoplam ">
					<tbody>



						<tr class="bg-light text-dark text-center">
						<td class="font-weight-bold">TOPLAM</td>					
						<td class="font-weight-bold text-danger">'.$adet.'</td>
						<td colspan="1" class="font-weight-bold text-danger ">';
						
							if ($verilericek->num_rows!=0) :		
							$masaninBakiyesi=$verilericek->fetch_assoc();

							$odenenTutar=$masaninBakiyesi["tutar"];
							$kalanTutar=$sontutar-$odenenTutar;	

								echo '<p class="text-danger m-0 p-0">
								<del id="Toplamtut">'.number_format($sontutar,2,'.',','). " </del> | 													
							<font class='text-success'>" . number_format($odenenTutar,2,'.',',')."</font>
							<font class='text-dark'><br>Ödenecek : ". number_format($kalanTutar,2,'.',',')."</font></p>" ;	
							else:							
							echo '<p class="text-danger m-0 p-0">
							<b id="Toplamtut">' .number_format($sontutar,2,'.',','). "</b> ₺ </p>";		
							endif;
						 echo'</td>	
				   		 <tr class="font-weight-bold">
						<td  colspan="5" >
						<a class="btn  btn-danger float-right mt-1 text-white btn-sm" id="tumunusil" sectionId="'.$id.'">Tümünü Sil</a></td>		
						</tr>	
						</div>							
						</div>';
					endif;	 
     break; 
case "mutfaksip":

		if (!$_POST):		
		echo "Posttan gelmiyosun";		
		else:		
		$urunid=htmlspecialchars($_POST["urunid"]);
		$masaid=htmlspecialchars($_POST["masaid"]);			
		
		$sorgu2="update mutfaksiparis set durum=1 where urunid=$urunid and masaid=$masaid";
		$silme2=$db->prepare($sorgu2);		
		$silme2->execute();			
		endif;

	break; // MUTFAK SİPARİŞ
case "ekle":

			 	if ($_POST) :
					 @$masaid=htmlspecialchars($_POST["masaid"]);
					 @$urunid=htmlspecialchars($_POST["urunid"]);
					 @$iskonto=htmlspecialchars($_POST["iskonto"]);
					 @$adet=htmlspecialchars($_POST["adet"]);
					 
	 				if ($masaid=="" || $urunid=="" || $adet=="" ) :			
					uyarimesaj("Boş alan bırakma","danger");								
					else:
					$d=benimsorum2($db,"select * from urunler where id=$urunid",1);
					$son=$d->fetch_assoc();				
					$urunad=$son["ad"];	
					$katid=$son["katid"];
					$urunfiyat=$son["fiyat"];
					
						$saat=date("H");	
						$dakika=date("i");				
						 /* MUTFAĞA BİLGİ GÖNDERİLİYOR*/	
						$mutfak="select * from mutfaksiparis where urunid=$urunid and masaid=$masaid";
						$var2=benimsorum2($db,$mutfak,1);
					if ($var2->num_rows!=0) :						
						$urundizi=$var2->fetch_assoc();
						$sonadet=$adet + $urundizi["adet"];
						$islemid=$urundizi["id"];
						$guncel2="UPDATE mutfaksiparis set adet=$sonadet where id=$islemid";
						$guncelson2=$db->prepare($guncel2);
						$guncelson2->execute();	
					else:										   
						$durumbak=benimsorum2($db,"select * from kategori where id=$katid",1);
				 	    $durumbak=$durumbak->fetch_assoc();
					if ($durumbak["mutfakdurum"]==0) :
									
						benimsorum2($db,"insert into mutfaksiparis (masaid,urunid,urunad,adet,saat,dakika) VALUES ($masaid,$urunid,'$urunad',$adet,$saat,$dakika)",0);
												
						endif;							
					endif;

					 /* MUTFAĞA BİLGİ GÖNDERİLİYOR*/
						
						$var=benimsorum2($db,"select * from anliksiparis where urunid=$urunid and masaid=$masaid",1);				
						
						if ($var->num_rows!=0) :
						
						$urundizi=$var->fetch_assoc();
						$sonadet=$adet + $urundizi["adet"];					
						$islemid=$urundizi["id"];
				 		$guncelson=$db->prepare("UPDATE anliksiparis set adet=$sonadet where id=$islemid");
						$guncelson->execute();				
						uyarimesaj("ÜRÜN ADEDİ GÜNCELLENDİ","success");
						
					     /* MASANIN LOG KAYDI*/		
				 	 
						$ekleson2=$db->prepare("update masalar set saat=$saat, dakika=$dakika where id=$masaid");
						$ekleson2->execute();				 
				        /* MASANIN LOG KAYDI*/				  					
						else:
						if ($iskonto!=""):
						 //    sayi / 100 * indirim oranı
						$sonuc= ($urunfiyat / 100) * $iskonto; // 0.5
						$urunfiyat=$urunfiyat-$sonuc;						
						endif;

						// garsonun idsini alıyorum
					
						$gelen=benimsorum2($db,"select * from garson where durum=1",1)->fetch_assoc();
	
						$garsonidyaz=$gelen["id"];
						// garsonun idsini alıyorum	
				 
						 /* MASANIN DURUMUNU GÜNCELLEYECEĞİM*/				 
						 $ekleson2=$db->prepare("update masalar set durum=1 where id=$masaid");
						 $ekleson2->execute();				 
						  /* MASANIN DURUMUNU GÜNCELLEYECEĞİM*/						  
				  
						  /* MASANIN LOG KAYDI*/		
						 $saat=date("H");	
						 $dakika=date("i");	 
						 $ekleson2=$db->prepare("update masalar set saat=$saat, dakika=$dakika where id=$masaid");
						 $ekleson2->execute();				 
						  /* MASANIN LOG KAYDI*/							
								
						 $ekle="insert into anliksiparis (masaid,garsonid,urunid,urunad,urunfiyat,adet) VALUES ($masaid,$garsonidyaz,$urunid,'$urunad',$urunfiyat,$adet)"; 
						 $ekleson=$db->prepare($ekle);
						 $ekleson->execute();
							 
						uyarimesaj("ÜRÜN EKLENDİ","success");					
						endif;
						endif;	
						else:
						uyarimesaj("HATA VAR","danger");			
				 		endif;
		break;
case "urun":
					$katid=htmlspecialchars($_GET["katid"]);
					$a="select * from urunler where katid=$katid";
					$d=benimsorum2($db,$a,1);					
					while ($sonuc=$d->fetch_assoc()):
					$fiyat=$sonuc["fiyat"];					
					echo '<label class="btn  m-2 pt-4 text-center urunbuton  urunidlab'.$sonuc["id"].'" >
					<input name="urunid" type="radio" value="'.$sonuc["id"].'" />
					'.$sonuc["ad"].' <br>'. number_format($fiyat,2,'.',',').' ₺
					</label>';
					endwhile;					
		break; // URUN GETİR		
case "kontrol":
		$ad=htmlspecialchars($_POST["ad"]);
		$sifre=htmlspecialchars($_POST["sifre"]);		
		if (@$ad!="" && @$sifre!="") :
				$var=benimsorum2($db,"select * from garson where ad='$ad'  and sifre='$sifre'",1);				
					if ($var->num_rows==0) :
						echo '<div class="alert alert-danger text-center">Bilgiler uyuşmuyor</div>';
					
					else:
					
					$garson=$var->fetch_assoc();
					$garsonid=$garson["id"];
					benimsorum2($db,"update garson set durum=1 where id=$garsonid",1);
					?>
                    <script>
					window.location.reload();
					
					</script>                    
                    <?php
					endif;
		else:		
		echo '<div class="alert alert-danger text-center">Boş bölüm bırakma</div>';		
		endif;		
	break; // KONTROL
case "cikis":
  //buraya geleceğiz
  		$kulad =$_COOKIE["kul"];
        $oturumTipi =$_COOKIE["oturumTipi"]; 


	  benimsorum2($db,"update $oturumTipi set durum=0,AktifBolum=0 where ad='$kulad'",1);
	  
		setcookie("kul",$kulad, time() -10 );
        setcookie("oturumid","", time() -10 );  
        setcookie("oturumTipi",$oturumTipi, time() -10 );
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
		$sorgu2="delete from mutfaksiparis where id=$id";
		$silme2=$db->prepare($sorgu2);		
		$silme2->execute();			
		endif;
		
		break; // MUTFAK ÜRÜN SİL
case "rezerveet":
		
		if ($_POST):		
				
		$masaid=htmlspecialchars($_POST["masaid"]);	
		$kisi=htmlspecialchars($_POST["kisi"]);
		$rezervesaat=htmlspecialchars($_POST["rezervesaat"]);		
		if ($kisi=="") :
		
		$kisi="Yok";
		endif;	
		$rezerveet=$db->prepare("update masalar set durum=1,rezervedurum=1,kisi='$kisi',rezervesaat='$rezervesaat' where id=$masaid");		
		$rezerveet->execute();			
		endif;		
		break; // REZERVE ET
case "rezervelistesi":
		$siparisler=benimsorum2($db,"select * from masalar where rezervedurum=1",1);
		echo '<table class="table table-bordered table-striped bg-white table-responsive-lg border-0 text-center mt-1 anasayfaTablo p-0" id="rezervelistem">
		<tbody>
		<tr class="font-weight-bold">		
		<td>MASA</td>
		<td>KİŞİ</td>
		<td>SAAT</td>
		<td>İŞLEM</td>		
		</tr>		
		';		
		while ($geldiler=$siparisler->fetch_assoc()) :
				echo '	<tr>                    
						<td class="text-center  mx-auto  p-0 m-0">
						 '.$geldiler["ad"].'
						</td>						
						<td class="text-center  mx-auto  p-0 m-0">
						'.$geldiler["kisi"].'
						</td>
						<td class="text-center  mx-auto  p-0 m-0">
						'.$geldiler["rezervesaat"].'
						</td>										
						<td class="text-center  mx-auto  p-0 m-0">
						<a class="fas fa-ban  m-1 text-danger" sectionId="'.$geldiler["id"].'" style="font-size:20px;" id="mas'.$geldiler["id"].'"></a>
						</td>							
						</tr>';	
				endwhile;
 			echo '</tbody></table>';		
		break;
case "rezervekaldir":
		
		if ($_POST):			
		$id=htmlspecialchars($_POST["id"]);		
		$rezerveet=$db->prepare("update masalar set durum=0,rezervedurum=0,kisi='Yok' where id=$id");		
		$rezerveet->execute();				
		endif;		
		break; // REZERVE LİSTESİ		
case "tumunusil":

		if ($_POST):			
		$id=htmlspecialchars($_POST["id"]);
		benimsorum2($db,"delete from anliksiparis where masaid=$id",1);
		benimsorum2($db,"delete from masabakiye where masaid=$id",1);
		endif;	
  
  break;
case "butonlar":
		$masaid=htmlspecialchars($_GET["id"]);
		
	echo '<div class="row">
						
						
						
						 <div class="col-md-12">	
						
						<input type="button" id="btnn" value="ÖDEME AL" style="font-weight:bold; height:40px;" class="btn btn-dark col-lg-12  mt-1"   />
				 
						 <div class="row text-center mt-2" id="odemesecenek">
						 	<div class="col-md-3 border border-warning m-1 mx-auto p-3 rounded" id="nakit">Nakit</div>
						 	<div class="col-md-3 border border-warning m-1 mx-auto p-3 rounded" id="kredi">K.Kredi</div>
						 	<div class="col-md-3 border border-warning m-1 mx-auto p-3 rounded" id="ykarti">Y.Kartı</div>
						 </div>


						 <div class="row text-center mt-2 bg-danger rounded border-top border-bottom" id="TercihNakit">
						 	<div class="col-md-6 m-1 mx-auto">

						 	<input type="text" name="VerilenPara" placeholder="Verilen Para" class="form-control" id="numarator2">
						 	</div>
						 	
						 	<div class="col-md-6 mt-1 mb-1 m-1 font-weight-bold  bg-success text-white rounded p-2 mx-auto" id="ParaUstuSonuc">

						 	</div>
						 	</div> ';
						  ///----------------------------------------------------------------------
						 echo'  <div class="row text-center mt-2" id="TercihKredi"></div> ';
						  ///----------------------------------------------------------------------
						  echo'  <div class="row text-center mt-2" id="OdemeFormu">

										 <div class="col-md-10 m-1 mx-auto">
				                   <form id="hesapform"> 
										 <input type="hidden" name="odemesecenek"/> 
										 <input type="hidden" name="masaid" value="'.$masaid.'" />    
				                        <input type="button" id="odemeal" value="ÖDEME YAP" style="font-weight:bold; height:60px;" class="btn btn-success col-lg-10  mt-1" />
				                        </form>
							 			</div>	
						 		 </div> ';
						 
							echo'<p><a href="fisbastir.php?masaid='.$masaid.'" onclick="ortasayfa(this.href,\'mywindow\',\'350\',\'400\',\'yes\');return false" 
							class="btn btn-dark btn-block mt-1" style="height:40px;" ><i class="fas fa-print mt-1"> YAZDIR </i></a></p> 						 					 
						 </div>	
						 
						 	 <div class="col-md-12">
										 <div class="row">
										 		<div class="col-md-12" id="islemlinkleri">
										 		<a  class="btn btn-dark btn-block mt-1 text-white" style="height:40px;" sectionId="degistir">
										 		<i class="fas fa-exchange-alt mt-1 float-left">DEĞİŞTİR</i></a> </div>
												
	 <div class="col-md-12" id="degistirform">'; formgetir($masaid,$db,"<b class='text-secondary'>DEĞİŞTİR</b><span id='kapatma'>
	 	<a class='text-danger float-right'  sectionId='degistir'><b>X</b></a></span>",0,"DEĞİŞTİR","degistirbtn","degistirformveri",$tema3->BolumTercihGetir($db)); echo'</div>
												
												 <div class="col-md-12" id="islemlinkleri">
												 <a  class="btn btn-dark text-white btn-block mt-1" style="height:40px;" sectionId="birlestir">
												 <i class="fas fa-stream mt-1 float-left">BİRLEŞTİR</i></a>  </div>
												 
	 <div class="col-md-12" id="birlestirform">'; formgetir($masaid,$db,"<b class='text-secondary'>BİRLEŞTİR</b><span id='kapatma'>
	 	<a class='text-danger float-right' sectionId='birlestir'><b>X</b></a></span>",1,"BİRLEŞTİR","birlestirbtn","birlestirformveri",$tema3->BolumTercihGetir($db)); echo'</div>
												 
										 </div>										 
								 </div>
								 	 <div class="col-md-12">
									 
										 <div class="row">
										 		<div class="col-md-12" id="islemlinkleri">
										 		<a  class="btn btn-dark text-white btn-block mt-1" style="height:40px;" sectionId="iskonto">
										 		<i class="fas fa-hand-holding-usd  mt-1 float-left"> İSKONTO</i></a> </div>
												
	<div class="col-md-12" id="iskontoform">'; iskontogetir($masaid); echo'</div>
												
												 <div class="col-md-12" id="islemlinkleri">
												 <a  class="btn btn-dark text-white btn-block mt-1" style="height:40px;" sectionId="parca">
												 <i class="fas fa-cookie-bite mt-1 float-left"> PARÇA HESAP</i></a>  </div>
												 
	<div class="col-md-12" id="parcaform">'; parcagetir($masaid); echo'</div>
												 
										 </div>
								 </div>
						</div>';
		break;
endswitch;
?>

</body>
</html>