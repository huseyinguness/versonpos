<?php session_start(); 
include("fonksiyon/tema3fonk.php"); 
$tema3 = new vipTema;
@$masaid=$_GET["masaid"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script src="dosya/jqu.js"></script>
<link rel="stylesheet" href="dosya/boost.css" >
<link rel="stylesheet" href="dosya/temaikistil.css" >

<script>
$(document).ready(function() {	
			$('#btnn').click(function() {		
		$.ajax({			
			type : "POST",
			url :'islemler.php?islem=hesap',
			data :$('#hesapform').serialize(),			
			success: function(donen_veri){
			$('#hesapform').trigger("reset");
				window.opener.location.reload(true);
				window.close();
			},			
		})		
	})
	

	
});
</script>
<title>FİŞ BASTIR</title>



</head>
<body onload="window.print()">

<div class="container-fluid">

<div class="row">

<div class="col-md-2 mx-auto">

<?php 


if ($masaid!="") :

$son=$tema3->masagetir($db,$masaid);
$dizi=$son->fetch_assoc();
$dizi["ad"];

					$id=htmlspecialchars($_GET["masaid"]);
 
 					$a="select * from anliksiparis where masaid=$id";
					$d=$tema3->benimsorum2($db,$a,1);
					
					
					if ($d->num_rows==0) :					
					echo "Henüz sipariş yok";										
					else:
					
					echo '<table class="table">
					<tr>
<td colspan="3" class="border-top-0 text-center"><strong>MASA :</strong> '.$dizi["ad"].'</td>
</tr>

<tr>
<td colspan="3" class="border-top-0 text-left"><strong>Tarih :</strong> '.date("d.m.Y").'</td>
</tr>
<tr>
<td colspan="3" class="border-top-0 text-left"><strong>Saat :</strong> '.date("h:i:s").'</td>
</tr>';


					
					$sontutar=0;
						while ($gelenson=$d->fetch_assoc()) :
						
						$tutar = $gelenson["adet"] * $gelenson["urunfiyat"];
						
						
						$sontutar +=$tutar;
						$masaid=$gelenson["masaid"];
						
						
						echo'<tr>
					<td colspan="1" class="border-top-0 text-center">'.$gelenson["urunad"].'</td>
					<td colspan="1" class="border-top-0 text-center">'.$gelenson["adet"].'</td>
					<td colspan="1" class="border-top-0 text-center">'.number_format($tutar,2,'.',',').'</td>
					</tr>';						
						endwhile;	
											
						echo '
						
						<tr>
		<td colspan="2" class="border-top-0 font-weight-bold"><strong>GENEL TOPLAM :</strong> </td>
		<td colspan="2" class="border-top-0 text-center">'.number_format($sontutar,2,'.',',').' TL </td>
		</tr>
						
											
						</tbody></table>
						
					
					
						 <form id="hesapform"> 					 
					
						 <input type="hidden" name="masaid" value="'.$id.'" />    
                     <input type="button" id="btnn" value="HESABI KAPAT" class="btn btn-danger btn-block mt-4"   />
						 
						 </form>			 					 
						
						';				
					
					endif;	 


?>




</div>
</div>






<?php 


else:

	echo "hata var";
	header("refresh:1,url=index.php");
 endif; ?>
</div>


</body>
</html>