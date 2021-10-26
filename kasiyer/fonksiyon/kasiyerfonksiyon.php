<?php

$db = new mysqli("localhost","root","","siparis")or die ("Bağlanamadı");
$db->set_charset("utf8");


class kasiyer {
	
		function BolumTercihGetir($dv) {
		
				$OturumTipi = $_COOKIE["OturumTipi"];							
				$id=$this->coz($_COOKIE["Oturumid"]);	
												
				
				$sor=$dv->prepare("select * from $OturumTipi where id=$id");
				$sor->execute();
				$sonbilgi=$sor->get_result();
				$veri=$sonbilgi->fetch_assoc();
				
				return $veri["AktifBolum"];
		
	}
	
	
		function sifrele($veri) {
		
		return base64_encode(gzdeflate(gzcompress(serialize($veri))));
		
	}
		function coz($veri) {
		
		return unserialize(gzuncompress(gzinflate(base64_decode($veri))));
		
	} // şifreleme
	

		
	    function kasiyersorgum($vt,$sorgu,$tercih) {
				
					
					$b=$vt->prepare($sorgu);
					$b->execute();
					if ($tercih==1):
					return $b->get_result();				
					endif;					
					
				
				
				
			}

		function KasiyerMasalar($dv) {				
					
	$sonuc=$this->kasiyersorgum($dv,"select * from masalar where durum=1",1);
									
	while ($masason=$sonuc->fetch_assoc()) :
	

	
	
				
echo '<div class="col-lg-2 col-md-2 col-sm-6 mr-2  p-2 text-center text-white" id="Kasiyermasa" >

<a href="masadetay.php?masaid='.$masason["id"].'" id="link">	
				
<div class="bg-warning mx-auto p-2 text-center text-white" >'.$masason["ad"].'</div></a>


</div>';					
					endwhile;
					
				
					
					
			
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
		
		
	

	
	
	

	
	
	
	



}



?>