<?php  ob_start();  include_once("fonk/yonfok.php"); $yokclas = new yonetim;
$yokclas->cookcont($db,false);
	
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script src="../dosya/jqu.js"></script>
<link rel="stylesheet" href="../dosya/boost.css" >
<title>Restaurant Kontrol</title>

<script >

function cikart() {
	
	window.print();
	window.close();
	
}

</script>


</head>
<body onload="window.print()">

<div class="container-fluid bg-light">

<div class="row row-fluid">


        
    <?php 
	
	
	@$islem=$_GET["islem"];
	
	switch ($islem) :	
	
	
	case "ciktial":	
	
		@$tarih1=$_GET["tar1"];
		@$tarih2=$_GET["tar2"];
		
		$veri=$yokclas->ciktiicinSorgu($db,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
		$veri2=$yokclas->ciktiicinSorgu($db,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
		
		
		echo ' <table  class="table text-center table-light table-bordered mx-auto mt-4  col-md-8">
                <thead>
                <tr>
				<th colspan="7">     <div class="alert alert-info text-center mx-auto mt-4">
		
		Tarih Seçimi : '.$tarih1.' - '.$tarih2.'
		
		</div> </th> 
                 
                 
                       
                </tr>                
                </thead>
                
                <tbody>
                <tr>
                
                 <th colspan="4">
                 
                         <table class="table text-center table-bordered col-md-12 table-striped">
                         <thead>
                         <tr>
                         <th colspan="4" class="table-dark">Masa adet ve Hasılat</th>                         
                         </tr>                         
                         </thead>
                         <thead>
                         <tr class="table-danger">
                         <th colspan="2">Ad</th>   
                         <th colspan="1">Adet</th> 
                         <th colspan="1">Hasılat</th>                       
                         </tr>                         
                         </thead> <tbody>'; 
						 
						 $kilit=$yokclas->ciktiicinSorgu($db,"select * from gecicimasa");						 
						 if ($kilit->num_rows==0) :							 
						while ($gel=$veri->fetch_assoc()):
												
						// masa adını çekiyoruz
						$id=$gel["masaid"];
						$masaveri=$yokclas->ciktiicinSorgu($db,"select * from masalar where id=$id")->fetch_assoc();
						$masaad=$masaveri["ad"];
						// masa adını çekiyoruz
						
						$raporbak=$yokclas->ciktiicinSorgu($db,"select * from gecicimasa where masaid=$id");
						
						if ($raporbak->num_rows==0) :
						//ekleme
						
						$has=$gel["adet"] * $gel["urunfiyat"];
						$adet=$gel["adet"];
						
						$yokclas->ciktiicinSorgu($db,"insert into gecicimasa (masaid,masaad,hasilat,adet) VALUES($id,'$masaad',$has,$adet)");						
						else:					
						$raporson=$raporbak->fetch_assoc();
						$gelenadet=$raporson["adet"];
						$gelenhas=$raporson["hasilat"];
						
						$sonhasilat=$gelenhas + ($gel["adet"] * $gel["urunfiyat"]); 
						$sonadet=$gelenadet  + $gel["adet"];
						
	$yokclas->ciktiicinSorgu($db,"update gecicimasa set hasilat=$sonhasilat, adet=$sonadet where masaid=$id");
						
						//güncelleme
						
						endif;					
						
						
						endwhile;
						 
						 
						 endif;						 
						 
		$son=$yokclas->ciktiicinSorgu($db,"select * from gecicimasa order by hasilat desc;");			
		$toplamadet=0;
		$toplamhasilat=0;		
		
		while ($listele=$son->fetch_assoc()) :		
		
						echo '<tr>
                         <td colspan="2">'.$listele["masaad"].'</td>   
                         <td colspan="1">'.$listele["adet"].'</td> 
                         <td colspan="1">'.substr($listele["hasilat"],0,5).'</td>                       
                         </tr>   ';
						 $toplamadet += $listele["adet"];
						 $toplamhasilat +=$listele["hasilat"];
					
		endwhile;			 
						 
						 
						 
						 
						                  
                         
                        echo'
						
						<tr class="table-danger">
                         <td colspan="2">TOPLAM</td>   
                         <td colspan="1">'.$toplamadet.'</td> 
                         <td colspan="1">'.substr($toplamhasilat,0,6).'</td>                       
                         </tr>
								
						</tbody> </table> 
                 
                 
                 
                 
                 </th>  
                 
                 
                 
                 
                 
                         
                  <th colspan="4" >
                  
                   <table class="table text-center table-bordered col-md-12 table-striped">
                         <thead>
                         <tr>
                         <th colspan="4" class="table-dark">Ürün adet ve Hasılat</th>                         
                         </tr>                         
                         </thead>
                         <thead>
                         <tr class="table-danger">
                         <th colspan="2">Ad</th>   
                         <th colspan="1">Adet</th> 
                         <th colspan="1">Hasılat</th>                       
                         </tr>                         
                         </thead> <tbody>'; 
						 
						 $kilit2=$yokclas->ciktiicinSorgu($db,"select * from geciciurun");						 
						 if ($kilit2->num_rows==0) :							 
						while ($gel2=$veri2->fetch_assoc()):
												
						
						$id=$gel2["urunid"];
					
						$urunad=$gel2["urunad"];
						
						$raporbak=$yokclas->ciktiicinSorgu($db,"select * from geciciurun where urunid=$id");
						
						if ($raporbak->num_rows==0) :
						//ekleme
						
						$has=$gel2["adet"] * $gel2["urunfiyat"];
						$adet=$gel2["adet"];
						
						$yokclas->ciktiicinSorgu($db,"insert into geciciurun (urunid,urunad,hasilat,adet) VALUES($id,'$urunad',$has,$adet)");						
						else:					
						$raporson=$raporbak->fetch_assoc();
						$gelenadet=$raporson["adet"];
						$gelenhas=$raporson["hasilat"];
						
						$sonhasilat=$gelenhas + ($gel2["adet"] * $gel2["urunfiyat"]); 
						$sonadet=$gelenadet  + $gel2["adet"];
						
	$yokclas->ciktiicinSorgu($db,"update geciciurun set hasilat=$sonhasilat, adet=$sonadet where urunid=$id");
						
						//güncelleme
						
						endif;					
						
						
						endwhile;
						 
						 
						 endif;						 
						 
		$son2=$yokclas->ciktiicinSorgu($db,"select * from geciciurun order by hasilat desc;");			
			
		
		while ($listele2=$son2->fetch_assoc()) :		
		
						echo '<tr>
                         <td colspan="2">'.$listele2["urunad"].'</td>   
                         <td colspan="1">'.$listele2["adet"].'</td> 
                         <td colspan="1">'.substr($listele2["hasilat"],0,5).'</td>                       
                         </tr>   ';
					
					
		endwhile;			 
						 
						 
						 
						 
						                  
                         
                        echo'</tbody> </table> 
                 
                  
                  </th>          
                </tr>
                
                </tbody>
                </table>';
		
		
		
		
	
	break;
	
	case "garsoncikti":
	
	
		@$tarih1=$_GET["tar1"];
		@$tarih2=$_GET["tar2"];
		
		$veri=$yokclas->ciktiicinSorgu($db,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
		$veri2=$yokclas->ciktiicinSorgu($db,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
		
		
		
		
		echo '<table  class="table text-center table-light table-bordered mx-auto mt-4  col-md-8">
                <thead>
                <tr>
				<th colspan="7">     <div class="alert alert-info text-center mx-auto mt-4">
		
				Tarih Seçimi : '.$tarih1.' - '.$tarih2.'
		
				</div> </th> 
                 
                 
                       
                </tr>                
                </thead>
                
                <tbody>
                <tr>
				
				
				
                
                
                 <th colspan="4">
                 
                         <table class="table text-center table-bordered col-md-12 table-striped">
                       
                         <thead>
                         <tr class="bg-dark text-warning">
                         <th colspan="2">Garson Ad</th>   
                         <th colspan="2">Adet</th> 
                                             
                         </tr>                         
                         </thead> <tbody>'; 
						 
						 $kilit=$yokclas->ciktiicinSorgu($db,"select * from gecicigarson");						 
						 if ($kilit->num_rows==0) :							 
						while ($gel=$veri->fetch_assoc()):
												
						// garson adını çekiyoruz
						$garsonid=$gel["garsonid"];
						$masaveri=$yokclas->ciktiicinSorgu($db,"select * from garson where id=$garsonid")->fetch_assoc();
						$garsonad=$masaveri["ad"];
						// garson adını çekiyoruz
						
						$raporbak=$yokclas->ciktiicinSorgu($db,"select * from gecicigarson where garsonid=$garsonid");
						
						if ($raporbak->num_rows==0) :
						//ekleme
						
						
						$adet=$gel["adet"];
						
						$yokclas->ciktiicinSorgu($db,"insert into gecicigarson (garsonid,garsonad,adet) VALUES($garsonid,'$garsonad',$adet)");						
						else:					
						$raporson=$raporbak->fetch_assoc();
						$gelenadet=$raporson["adet"];
						
						
						$sonadet=$gelenadet  + $gel["adet"];
						
	$yokclas->ciktiicinSorgu($db,"update gecicigarson set adet=$sonadet where garsonid=$garsonid");
						
						//güncelleme
						
						endif;					
						
						
						endwhile;
						 
						 
						 endif;						 
						 
		$son=$yokclas->ciktiicinSorgu($db,"select * from gecicigarson order by adet desc;");			
		$toplamadet=0;
		
		
		while ($listele=$son->fetch_assoc()) :		
		
						echo '<tr>
                         <td colspan="2">'.$listele["garsonad"].'</td>   
                         <td colspan="2">'.$listele["adet"].'</td> 
                                              
                         </tr>   ';
						 $toplamadet += $listele["adet"];
						
					
		endwhile;			 
						 
						 
						 
						 
						                  
                         
                        echo'
						
						<tr class="bg-dark text-white">
                         <td colspan="2">TOPLAM</td>   
                         <td colspan="2">'.$toplamadet.'</td> 
                                               
                         </tr>
								
						</tbody> </table> 
                 
                 
                 
                 
                 </th>  
                 
                 
                 
                        
                </tr>
                
                </tbody>
                </table>';
	
	
	
	break;
	

	
	
	
	
		
	endswitch;
	
	
	?>
    
    
    





</div>
</div>
</body>
</html>