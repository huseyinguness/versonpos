<?php require_once 'yonetim_fonksiyon/yonfonksiyon.php';
$yokclas= new yonetim;
$yokclas->cookcont($vt,false);
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
<script src="../Dosya/jquer.js"></script>
<link rel="stylesheet" href="../Dosya/boost.css">
<title>Verson Pos Restorant Kontrol </title>

<script>
	
	function cikart()
	{
		window.print();
		window.close();

	}
</script>

</head>
<body onload="window.print()" onafterprint="window.close()">
	<div class="container-fluid bg-light">
		<div class="row row-fluid">
			


<?php 
	
	@$islem=$_GET["islem"];
	switch ($islem) :

	case "ciktial":

	    @$tarih1=$_GET["tar1"];
        @$tarih2=$_GET["tar2"];
        
        $veri=$yokclas->ciktiicinsorgu($vt,"select * from rapor where DATE(Tarih) BETWEEN '$tarih1' AND ' $tarih2'");
        $veri2=$yokclas->ciktiicinsorgu($vt,"select * from rapor where DATE(Tarih) BETWEEN '$tarih1' AND ' $tarih2'");

               echo' <table class="table text-center table-light table-bordered mx-auto mt-4  col-md-8">
                    <thead>                 
                        <tr>
                         <th colspan="7"><div class="alert alert-info text-center mx-auto mt-4">Tarih Seçimi :<br> '.$tarih1.' & '.$tarih2.'</div></th>
                         <th colspan="2"><button onclick="cikart()" class="btn btn-info">Yazdır</button></th>
                        </tr>                   
                     </thead>
                                <tbody>
                                 <tr>
                                <th colspan="4"> 
                                    <table class="table text-center table-light table-bordered col-md-12 table-striped">
                                        <thead>                 
                                            <tr>                    
                                            <th colspan="6" class="table-dark"> Masa Adet Ve Hasılat </th>                         
                                            </tr>                   
                                        </thead>
                                            <thead>                 
                                            <tr class="table-warning">                    
                                            <th colspan="2"> Masa  </th>    
                                            <th colspan="1"> Adet </th> 
                                            <th colspan="1"> Tutar </th>                            
                                            </tr>                   
                                            </thead> 
                                            <tbody>';

                                            $kilit=$yokclas->ciktiicinsorgu($vt,"select * from gecicimasa");

                                            if ($kilit->num_rows==0) :

                                                while($gel=$veri->fetch_assoc()):
                                                    //masa adını çekiyoruz..
                                                    $id=$gel["masaid"];
                                                    $masaveri=$yokclas->ciktiicinsorgu($vt,"select * from masalar where id=$id")->fetch_assoc();
                                                    $masaad=$masaveri["ad"];

                                                    $raporbak=$yokclas->ciktiicinsorgu($vt,"select * from gecicimasa where masaid=$id");

                                                    if ($raporbak->num_rows==0) :
                                                        //ekleme
                                                        $has=$gel["adet"] * $gel["urunfiyat"];
                                                        $adet=$gel["adet"];

                                                        $yokclas->ciktiicinsorgu($vt,"insert into gecicimasa (masaid,masaad,hasilat,adet) VALUES ($id,'$masaad',$has,$adet)");
                                                    else :
                                                        //güncelleme
                                                        $raporson=$raporbak->fetch_assoc();
                                                        $gelenadet=$raporson["adet"];
                                                        $gelenhas=$raporson["hasilat"];

                                                        $sonhasilat=$gelenhas + ($gel["adet"] * $gel["urunfiyat"]);
                                                        $sonadet=$gelenadet + $gel["adet"];
                                                        
                                                        $yokclas->ciktiicinsorgu($vt,"update gecicimasa set hasilat=$sonhasilat, adet=$sonadet where masaid=$id");

                                                    endif;
                                                endwhile;
                                            endif;
                                            $toplamadet =0;
                                            $toplamhasilat =0;

                                            $son=$yokclas->ciktiicinsorgu($vt,"select * from gecicimasa order by hasilat desc");

                                            while ($listele=$son->fetch_assoc()):

                                            echo '
                                                <tr>                    
                                                <td colspan="2"> '.$listele["masaad"].'  </td>    
                                                <td colspan="1"> '.$listele["adet"].' </td> 
                                                <td colspan="1"> '.substr($listele["hasilat"],0,5). ' ₺ </td>                            
                                                </tr>';
                                                 $toplamadet +=$listele["adet"];
                                                 $toplamhasilat += $listele["hasilat"];

                                            endwhile;

                                             echo '
                                                <tr class="table-warning">                    
                                                <td colspan="2"> Toplam :  </td>    
                                                <td colspan="1"> '.$toplamadet.' </td> 
                                                <td colspan="1"> '.substr($toplamhasilat,0,6).' ₺ </td>                            
                                                </tr>';
// ürün rapor kodları
                        echo' 
                            </tbody> 
                            </table>
                                </th>
                               
                                  <th  colspan="4">
                                    <table class="table text-center table-light table-bordered col-md-12 table-striped">
                                        <thead>                 
                                            <tr>                    
                                            <th colspan="6" class="table-dark"> Ürün Adet Ve Hasılat </th>                         
                                            </tr>                   
                                        </thead>
                                            <thead>                 
                                            <tr class="table-warning">                    
                                            <th colspan="2"> Masa  </th>    
                                            <th colspan="1"> Adet </th> 
                                            <th colspan="1"> Tutar </th>                            
                                            </tr>                   
                                            </thead> 
                                            <tbody>';

                                            $kilit2=$yokclas->ciktiicinsorgu($vt,"select * from geciciurun");

                                            if ($kilit2->num_rows==0) :

                                                while($gel2=$veri2->fetch_assoc()):
                                                    //ürün adını çekiyoruz..
                                                    $id=$gel2["urunid"];
                                                     $urunad=$gel2["urunad"];                                                   

                                                    $raporbak2=$yokclas->ciktiicinsorgu($vt,"select * from geciciurun where urunid=$id");

                                                    if ($raporbak2->num_rows==0) :
                                                        //ekleme
                                                        $has=$gel2["adet"] * $gel2["urunfiyat"];
                                                        $adet=$gel2["adet"];

                                                        $yokclas->ciktiicinsorgu($vt,"insert into geciciurun (urunid,urunad,hasilat,adet) VALUES ($id,'$urunad',$has,$adet)");
                                                    else :
                                                        //güncelleme
                                                        $raporson2=$raporbak2->fetch_assoc();
                                                        $gelenadet2=$raporson2["adet"];
                                                        $gelenhas=$raporson2["hasilat"];

                                                        $sonhasilat=$gelenhas + ($gel2["adet"] * $gel2["urunfiyat"]);
                                                        $sonadet=$gelenadet2 + $gel2["adet"];                                                        
                                                        $yokclas->ciktiicinsorgu($vt,"update geciciurun set hasilat=$sonhasilat, adet=$sonadet where urunid=$id");

                                                    endif;
                                                endwhile;
                                            endif;
                                            $toplamadet =0;
                                            $toplamhasilat =0;

                                            $son=$yokclas->ciktiicinsorgu($vt,"select * from geciciurun order by hasilat desc");

                                            while ($listele=$son->fetch_assoc()):

                                            echo '
                                                <tr>                    
                                                <td colspan="2"> '.$listele["urunad"].'  </td>    
                                                <td colspan="1"> '.$listele["adet"].' </td> 
                                                <td colspan="1"> '.substr($listele["hasilat"],0,5). ' ₺ </td>                            
                                                </tr>';
                                                 $toplamadet +=$listele["adet"];
                                                 $toplamhasilat += $listele["hasilat"];

                                            endwhile;

                                             echo '
                                                <tr class="table-warning">                    
                                                <td colspan="2"> Toplam :  </td>    
                                                <td colspan="1"> '.$toplamadet.' </td> 
                                                <td colspan="1"> '.substr($toplamhasilat,0,6).' ₺ </td>                            
                                                </tr>';
                                  echo' 
                            </tbody> 
                            </table> ';	



	break;				

	endswitch;	
?>
			
		</div>
	</div>

</body>
</html>