<?php
require_once 'baglan.php';
class kasiyer {	
function sifrele($veri) {
		
		return base64_encode(gzdeflate(gzcompress(serialize($veri))));
		
	}
function coz($veri) {
		
		return unserialize(gzuncompress(gzinflate(base64_decode($veri))));
		
	} // şifreleme		
function kasiyersorgum($db,$sorgu,$tercih) {
					$b=$db->prepare($sorgu);
					$b->execute();
					if ($tercih==1):
					return $b->get_result();				
					endif;
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
function vipTemaMasalar($db) 
           {	      	        
	        // ilgili bölüm adı geliyor
	$sonuc=$this->kasiyersorgum($db,"select * from masalar",1);									
					$bos=0;
					$dolu=0;				
					while ($masason=$sonuc->fetch_assoc()) :					
					$siparisler='select * from anliksiparis where masaid='.$masason["id"].'';
					$satir=$this->kasiyersorgum($db,$siparisler,1)->num_rows;					
					if ($satir==0):	
					$icon='ovalb';
					else:
					$icon='ovald';
					endif;	
					$this->kasiyersorgum($db,$siparisler,1)->num_rows==0 ? $bos++ : $dolu++ ;
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
function doluluk($dv) {
			
					$sonuc=$this->kasiyersorgum($dv,"select * from masalar",1);
					$bos=0;
					$dolu=0;				
					
					while ($masason=$sonuc->fetch_assoc()) :			
					$masason["durum"]==0 ? $bos++ : $dolu++ ;
					endwhile;
			$toplam = $bos + $dolu;			
		 	$oran =  ($dolu / $toplam) * 100 ;		
			echo $oran=substr($oran,0,4). " %";	
		}	
function masatoplam($dv) {
						echo $this->kasiyersorgum($dv,"select * from masalar where durum=1",1)->num_rows;						
		} // masa toplam sayı		
function siparistoplam($dv) {
				echo $this->kasiyersorgum($dv,"select * from anliksiparis",1)->num_rows;						
		} // masa toplam sayı
function bekleyensatir($db) {
		
		return $this->kasiyersorgum($db,"select * from mutfaksiparis where durum=1",1)->num_rows;
		
	}
function garsonbak($db) {

		$oturumTipi =$_COOKIE["oturumTipi"];
		$id=$this->coz($_COOKIE["oturumid"]);       

        $gelen=$this->kasiyersorgum($db,"SELECT * FROM ".$oturumTipi." WHERE id=$id",1)->fetch_assoc();
       
		if ($gelen["ad"]!="") :		
		echo $gelen["ad"];	
		echo '<a href="islemler.php?islem=cikis" class="m-3">
		<btn btn-danger class="bg-danger">ÇIKIŞ YAP</a>';
		else:		
		echo "Kimse Yok";			
		endif;
	}
function masagetir ($vt,$id)
		 {			
				$get="select * from masalar where id=$id";			
				return $this->kasiyersorgum($vt,$get,1);
		}
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
function cookcon ($d,$durum=false)
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