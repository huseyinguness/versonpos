<?php
require_once 'baglan.php';
ob_start();
class vipTema {
private function genelsorgu($dv, $sorgu) {

        $sorgum = $dv->prepare($sorgu);
        $sorgum->execute();
        return $sorguson = $sorgum->get_result();
    }
    // genel sorgu// baba fonksiyon		
function genelsorgu2($vt,$sorgu,$tercih) {
				
					$a=$sorgu;
					$b=$vt->prepare($a);
					$b->execute();
					if ($tercih==1):
					return $c=$b->get_result();				
					endif;	
			}			
// case64 şifreleme   
function sifrele($veri)
   {
    return base64_encode(gzdeflate(gzcompress(serialize($veri))));

   }
   function coz($veri)
   {
    return unserialize(gzuncompress(gzinflate(base64_decode($veri))));

   } 
private function uyari ($tip,$metin,$sayfa)
     {
        echo '<div class="alert alert-'.$tip.'">'.$metin.'</div>';
        header('refresh:0,url='.$sayfa.'');
    }
function doluluk($db) {
			
			$son=$this->genelsorgu($db,"select * from doluluk",1);
			$veriler=$son->fetch_assoc();			
			$toplam = $veriler["bos"] + $veriler["dolu"];			
		 	$oran =  ($veriler["dolu"] / $toplam) * 100 ;		
			echo $oran=substr($oran,0,4). " %";			
			
		}		
function masatoplam($db) {
				echo $this->genelsorgu($db,"select * from masalar",1)->num_rows;						
		} // masa toplam sayı
function siparistoplam($db) {
				echo $this->genelsorgu($db,"select * from anliksiparis",1)->num_rows;						
		} // masa toplam sayı		
// MASA DETAY FONKSİYON
function masagetir ($vt,$id)
		 {			
				$get="select * from masalar where id=$id";			
				return $this->genelsorgu($vt,$get,1);
		}

	// MASA DETAY FONKSİYON
function urungrup($db) {	
	$se="select * from kategori";
	$gelen=$this->genelsorgu($db,$se,1);	
	while ($son=$gelen->fetch_assoc()) :	
	echo '<a class="btn btn-dark mt-2 text-white" sectionId="'.$son["id"].'">'.$son["ad"].'</a><br>';	
	endwhile;		
	}	
function garsonbak($db) {

		$oturumTipi =$_COOKIE["oturumTipi"];
		$id=$this->coz($_COOKIE["oturumid"]);       

        $gelen=$this->genelsorgu($db,"SELECT * FROM ".$oturumTipi." WHERE id=$id",1)->fetch_assoc();
       
		if ($gelen["ad"]!="") :		
		echo $gelen["ad"];	
		echo '<a href="islemler.php?islem=cikis" class="m-3">
		<kbd class="bg-danger">ÇIKIŞ YAP</kbd></a>';
		else:		
		echo "Kimse Yok";			
		endif;
	}
// masalar
function BolumTercihGetir($db) {
	       $oturumTipi =$_COOKIE["oturumTipi"];
	        $id=$this->coz($_COOKIE["oturumid"]);         
	        $sor=$db->prepare("SELECT * FROM $oturumTipi WHERE id=$id");
	        $sor->execute();
	        $sonbilgi=$sor->get_result();
	        $veri=$sonbilgi->fetch_assoc();	        
	        // ilgili bölüm adı geliyor
	       return $veri["AktifBolum"];
  }
function BolumAdGetir($db,$deger) {

        $sonuc = $this->genelsorgu($db, "select * from bolumler where id=" . $deger, 1);
        $masason = $sonuc->fetch_assoc();

        echo '<div class="col-md-12 bg-info pt-2"><h3>Bölüm Adı : ' . $masason["ad"] . '</h3></div>';
    }
function BolumleriGetir($db) {

        echo '<div class="row">';
        $bolumler = $this->genelsorgu($db, "select * from bolumler");
        while ($bolumlerson = $bolumler->fetch_assoc()):

            echo '		
		<div class="col-md-3 mx-auto text-center">
		<label class="btn m-1 p-2 btn-block diger r' . $bolumlerson["id"] . '" id="girisButon">
		<input name="bolum" type="radio" value="' . $bolumlerson["id"] . '"  />' . $bolumlerson["ad"] . '</label>
		
		</div>';

        endwhile;

        echo '</div>';
    }
function vipTemaMasalar($db) 
           {	      	        
	        // ilgili bölüm adı geliyor
	        $this->BolumAdGetir($db,$this->BolumTercihGetir($db));
			$sonuc=$this->genelsorgu($db,"select * from masalar where kategori=".$this->BolumTercihGetir($db),1);
					$bos=0;
					$dolu=0;				
					while ($masason=$sonuc->fetch_assoc()) :					
					$siparisler='select * from anliksiparis where masaid='.$masason["id"].'';
					$satir=$this->genelsorgu($db,$siparisler,1)->num_rows;					
					if ($satir==0):	
					$icon='ovalb';
					else:
					$icon='ovald';
					endif;	
					$this->genelsorgu($db,$siparisler,1)->num_rows==0 ? $bos++ : $dolu++ ;
					if ($masason["rezervedurum"]==0) :
					echo '<div class="col-lg-2 col-md-3 col-sm-12">  
					<a href="masadetay.php?masaid='.$masason["id"].'" id="lin"> 
								<div class="row  p-2">
										<div class="col-lg-12 p-2  genelCervece" id="anadiv">
											<div class="row">
						<div class="col-lg-3 col-md-3  col-sm-4 pr-2 pt-1 '.$icon.'">
						<span style="font-size: 25px;" class="fas fa-mug-hot"></span>
						</div>
						<div class="col-lg-7 col-md-6 pl-2 col-sm-4 masaad">'.$masason["ad"].'</div> ';			
					if ($satir!=0): echo '<div class="col-lg-1 col-md-6 pl-2 col-sm-4">
						<kbd class="sipsayi float-left">'.$satir.'</kbd></div>';			
					else:			
						echo '<div class="col-lg-1 col-md-3 pl-2 col-sm-4"></div>';
					endif; 
						echo'</div>			
						<div class="row">
						<div class="col-lg-12 pt-3">';		
					$this->dakikakontrolet($masason["saat"],$masason["dakika"]);
			     
    				echo '
					</div></div>
					
					</div></div>
					</a>
					</div>';					
		else:					
					echo '<div class="col-lg-2 col-md-3 col-sm-12"> 		
					<div class="row  p-2">					
					<div class="col-lg-12 p-2   genelCervece" id="anadiv">							
					<div class="row">							
					<div class="col-lg-3 col-md-3 col-sm-4 pl-2 pr-2 pt-1 ovalr">
					<span style="font-size: 25px;" class="fas fa-mug-hot"></span>
					</div>
					<div class="col-lg-7 col-md-6  col-sm-4 masaad">'.$masason["ad"].'</div> 			
					<div class="col-lg-1 col-md-3 pl-2 col-sm-4"></div></div>	
					<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 pt-3">
					<kbd class="mb-0 float-right bg-dark text-warning border border-warning" style="position:absolute;">Kişi: '.$masason["kisi"].'<br> Saat: '.$masason["rezervesaat"].' </kbd>
					</div></div>					
					</div></div>
					</a>
					</div>';
		
		endif;		
					endwhile;
					$dol="update doluluk set bos=$bos, dolu=$dolu where id=1";
					$dolson=$db->prepare($dol);
					$dolson->execute();
	}	 
function vipTemaUrunGrup($db) {	
	
	$gelen=$this->genelsorgu($db,"select * from kategori",1);	
	while ($son=$gelen->fetch_assoc()) :
		
	echo '<a class="btn m-1 text-center kategoributon" style="color:#68d3c8;" sectionId="'.$son["id"].'">'.$son["ad"].'</a>';	
	endwhile;	
		
	} // tema2 grup
// mutfak	
function mutfakdakika($saat,$dakika) {
		
		
		if ($saat!=0 && $dakika!=0) :
		
		
					if ($saat<date("H")) :
					$deger= (60 + date("i")) - $dakika;
					echo $deger;
					else:					
					$deger =  date("i") - $dakika;			
							
					echo $deger;
					endif;
		endif;
	}		
function mutfakbilgi($db) {
		$siparisler=$this->genelsorgu($db,"select * from mutfaksiparis where durum=0",1);		
		$idkontrol=array();		
		while ($geldiler=$siparisler->fetch_assoc()) :
		$masaid=$geldiler["masaid"];
		if (!in_array($masaid,$idkontrol)) :
		$idkontrol[]=$masaid;			
		$siparisler2=$this->genelsorgu($db,"select * from mutfaksiparis where masaid=$masaid and durum=0",1);	
		$masaad=$this->genelsorgu($db,"select * from masalar where id=$masaid",1);
		$masabilgi=$masaad->fetch_assoc();					
		echo '
		<div class="col-md-3 ">
		<div class="card mt-1 p-1 bg-white border-danger" style="width:20.5rem;">
		<div class="card-body">
		<h5 class="card-title text-center"><kbd class="bg-danger">'.$masabilgi["ad"].'</kbd></h5>
		<p class="card-text">
		<div class="row">
		<div class="col-md-2 mt-2 border-bottom bg-dark text-white">Dk</div>
		<div class="col-md-5 mt-2 border-bottom bg-dark text-white">Ürün</div>
		<div class="col-md-3 mt-2 border-bottom bg-dark text-white">Adet</div>
		<div class="col-md-2 mt-2 border-bottom bg-dark text-white">OK</div>
		</div>';						
		while ($geldiler2=$siparisler2->fetch_assoc()) :						
		echo '<div class="row">
		<div class="col-md-7 mt-2 border-bottom"><span class="text-danger">'; 
		$this->mutfakdakika($geldiler2["saat"],$geldiler2["dakika"]); echo'</span> '.$geldiler2["urunad"].' </div>
		<div class="col-md-3 mt-2 border-bottom ">'.$geldiler2["adet"].'</div>
		<div class="col-md-2 mt-2 border-bottom" id="mutfaklink">
		<a sectionId="'.$geldiler2["urunid"].'" sectionId2="'.$geldiler2["masaid"].'"><i class="fas fa-check " style="color:#6C6; font-size:30px;"></i></a></div>
		</div>';					
		endwhile;	
		echo '		
		</p></div></div></div>';		
		endif;		
		endwhile;		
	}	
function dakikakontrolet($saat,$dakika) 
	{	
		
		if ($saat!=0 && $dakika!=0) :		
					if ($saat<date("H")) :					
					$deger= (60 + date("i")) - $dakika;					
					echo '<kbd class="ml-2 mb-0 mt-2  bg-light text-danger" >'.$deger.'  Dakika Önce</kbd>';	
					else:					
					$deger =  date("i") - $dakika;					
								if ($deger==0):								
								echo '<kbd class="ml-2 mb-0 mt-2  bg-light text-danger" >Yeni Eklendi</kbd>';								
								else:								
									echo '<kbd class="ml-2 mb-0 mt-2  bg-light text-danger" >'.$deger.'  dakika önce </kbd>';									
								endif;
					endif;
		endif;
	}
function bekleyensatir($db) {
		
		return $this->genelsorgu($db,"select * from mutfaksiparis where durum=1",1)->num_rows;
		
	}
// Giriş Kontrol	
function GirisYetkiDurum ($db,$tabloTip)
	{
		echo '<select name="kulad" class="form-control mt-2">';
				 $b=$this->genelsorgu($db,"select * from ".$tabloTip,1);
				 while ($garsonlar=$b->fetch_assoc()) :
				echo '<option value="'.$garsonlar["ad"].'">'.$garsonlar["ad"].'</option>';
				 endwhile;              
                echo '</select>';
	}
public function giriskont($veritabani,$kulad,$sifre,$tablo,$bolum) {
    
   
    $sor=$veritabani->prepare("SELECT * FROM $tablo WHERE ad='$kulad' and sifre='$sifre'");
    $sor->execute();
    $sonbilgi=$sor->get_result();
    $veri=$sonbilgi->fetch_assoc();    
    if ($sonbilgi->num_rows==0) :  
    $this->uyari("danger","Bilgiler Hatalı Lüftfen Doğru Bilgi Giriniz !!","index.php");
    else:    
    $sor=$veritabani->prepare("update $tablo set durum=1,AktifBolum=$bolum WHERE ad='$kulad' and sifre='$sifre'");
    $sor->execute();


    $this->uyari("success","Bilgiler  Doğru Giriş Yapılıyor !!","masalar.php");
    
    //cookie oluşturulacak

     
    setcookie("kul",$kulad, time() + 60*60*24);
    $id=$this->sifrele($veri["id"]);
    setcookie("oturumid",$id, time() + 60*60*24);  
    setcookie("oturumTipi",$tablo, time() + 60*60*24);   
    endif;
    
    }
// cokkie Kontrol
public function cookcon ($d,$durum=false)
     {
      if (isset($_COOKIE["kul"])):
	        $kulad =$_COOKIE["kul"];
	        $oturumTipi =$_COOKIE["oturumTipi"];
	        $id=$this->coz($_COOKIE["oturumid"]);       

        
	        $sor=$d->prepare("SELECT * FROM ".$oturumTipi." WHERE id=$id");
	        $sor->execute();
	        $sonbilgi=$sor->get_result();
	        $veri=$sonbilgi->fetch_assoc();

	        
	        if ($kulad!=$_COOKIE["kul"]) :
	        setcookie("kul",$kulad, time() -10 );
	        setcookie("oturumid",$id, time() -10 );  
	        setcookie("oturumTipi",$oturumTipi, time() -10 );        
	        header("location:index.php");
	        else:
	        if ($durum==true) : 
	        	header("location:masalar.php"); endif;          
	        
	     endif;
	        else:

	        if ($durum==false) : 
	        	header("location:index.php"); endif;         
            
       endif;    
    }

}
?>