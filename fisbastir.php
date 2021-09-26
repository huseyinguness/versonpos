<?php 
session_start();
include ("fonksiyonlar/fonksiyon.php");$masam = new verson;
@$masaid=$_GET["masaid"] ;
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
 <script src="dosya/jquery.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
<link rel="stylesheet" href="dosya/boost.css">
<link rel="stylesheet" href="dosya/stil.css">

<script >
$(document).ready(function()
 {	
 $('#btnhesap').click(function()  
    {
        $.ajax(
        {   
            type : "POST",
            url :'islemler.php?islem=hesap',
            data :$('#hesapform').serialize(),
            success : function(donen_veri)
            {     
               
            $('#hesapform').trigger("reset");
            window.opener.location.reload(true);
            window.close();                      
          
            },
        })
    })    	
});

var popupWindow=null;
	function popup(url,winName,w,h,scroll)
	{
		LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
		ToptPosition = (screen.height) ? (screen.height-h)/2 : 0;
		settings='height='+h+', width='+w+',top='+ToptPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'

		popupWindow=window.open(url,winName,settings)
	}
</script>

<title>Fiş Bastır </title>	
</head>    
<body  onload="window.print()">

<div class="container-fluid">
	<div class="row">		
		<div class="col-md-2 mx-auto">

<?php 
	if ($masaid!="") :

	$son=$masam->masagetir($db,$masaid);
	$dizi=$son->fetch_assoc();
	$dizi["ad"];

					$id=htmlspecialchars($_GET["masaid"]);

                     $a="select * from anliksiparis where masaid=$id";
                     $d=$masam->benimsorgum2($db,$a,1);              

                     if ($d->num_rows==0) :
                    uyari("Henüz Sipariş Yok !","danger");


                   
                     else:
                        echo '
                    <table class="table">
				<tbody>                   	
                    <tr>
					<td colspan="3" class="border-top-0 text-center"><strong>Masa :</strong>'.$dizi["ad"].'</td>						
					</tr>
					<tr>
					<td colspan="3" class="border-top-0 text-left"><strong>Tarih :</strong>'.date("d.m.Y").'</td>						
					</tr>
					<tr>
					<td colspan="3" class="border-top-0 text-left"><strong>Saat :</strong>'.date("h:i:s").'</td>						
					</tr>  ';

                      
                         $sontutar=0;


        while ($gelenson=$d->fetch_assoc()) :

        $tutar = $gelenson["adet"] * $gelenson["urunfiyat"];

        
        $sontutar +=$tutar;
        $masaid=$gelenson["masaid"];

          echo '<tr>
					<td colspan="1" class="border-top-0 text-center">'.$gelenson["urunad"].'</td>
					<td colspan="1" class="border-top-0 text-center">'.$gelenson["adet"].'</td>
					<td colspan="1" class="border-top-0 text-center">'.number_format($tutar,2,'.',',').' ₺</td>						
					</tr>';      

        endwhile;

        echo '

        <tr>
					<td colspan="2" class="border-top-0 font-weight-bold">Genel toplam :</td>
					<td colspan="1" class="border-top-0 text-center">'.number_format($sontutar,2,'.',',').' ₺</td>
											
					</tr>


        
        </tbody>
        </table>

        <form id="hesapform">

        <input type="hidden" name="masaid" value="'.$id.'"/>
        <input type="button" id="btnhesap" value="Hesap Kapat" class="btn btn-info btn-block mt-4"/>    
        </form>
       ';
        endif;
	
?>				
	</div>
</div>
<?php 
else:
	echo "hata var";
	header ("refresh:1,url=index.php");
endif; 
?>
</div>
 </body>
 </html>