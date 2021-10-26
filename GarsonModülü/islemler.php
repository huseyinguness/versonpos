<?php ob_start(); session_start(); include("fonksiyon/fonksiyon.php"); $sistem= new sistem;
@$masaid=$_GET["masaid"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script src="pad/js/easy-numpad.js"></script>
<script src="dosya/islemler.js"></script>
<link rel="stylesheet" href="dosya/boost.css" >
<link rel="stylesheet" href="dosya/temaikistil.css" >
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
function uyari($mesaj,$renk) {	
	echo '<div class="alert alert-'.$renk.' mt-4 text-center">'.$mesaj.'</div>';	
	}
	@$islem=$_GET["islem"];

	switch ($islem) 
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
					<td>İşlem</td>
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
	<td id="yakala"><a class="btn btn-danger mt-2 text-white" sectionId="'. $gelenson["urunid"].'" sectionId2="'.$masaid.'"><i class="fas fa-trash-alt"></i></a></td>				
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
						
						 echo'</td>
											
						</tr>			
						
							
					<tr class="font-weight-bold">
					<td colspan="4">
					<a class="btn btn-danger float-right mt-1 text-white btn-sm" id="tumunusil" sectionId="'.$id.'">TÜMÜNÜ SİL</a></td>
					
					</tr>
										
						</tbody></table>';				
					
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
				uyari("Boş alan bırakma","danger");								
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
										   
					
					$durumba=benimsorum2($db,"select * from kategori where id=$katid",1);
				 	$durumbak=$durumba->fetch_assoc();
					
									
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
						uyari("ADET GÜNCELLENDİ","success");
						
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
							 
					uyari("EKLENDİ","success");					
						endif;
		endif;	


		else:
		uyari("HATA VAR","danger");			
 		endif;


	break;
case "urun":

					$katid=htmlspecialchars($_GET["katid"]);
					$a="select * from urunler where katid=$katid";
					$d=benimsorum2($db,$a,1);					
					while ($sonuc=$d->fetch_assoc()):					
					echo '<label class="btn  m-2 pt-4  text-center urunlab urunidlab'.$sonuc["id"].'" style="margin:2px; background-color:#fff; height:80px; min-width:100px; color:#193d49;">
					<input name="urunid" type="radio" value="'.$sonuc["id"].'" />
					'.$sonuc["ad"].'
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
case "tumunusil":
		
		
		if ($_POST):		
			
		$id=htmlspecialchars($_POST["id"]);		
		
		benimsorum2($db,"delete from anliksiparis where masaid=$id",1);			
		benimsorum2($db,"delete from masabakiye where masaid=$id",1);			
		endif;
		
		
		
		
		break;		
endswitch;
?>
</body>
</html>