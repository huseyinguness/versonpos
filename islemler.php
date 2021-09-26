<?php 
session_start();
include ("fonksiyon/fonksiyon.php");
require_once 'baglan.php';
$masam = new sistem;
@$masaid=$_GET["masaid"] ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
     <script src="dosya/jquer.js"></script>
    <!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--> 
    <link rel="stylesheet" href="dosya/boost.css">
    <link rel="stylesheet" href="dosya/stil.css">
<!-- Jawa Script-->
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
            window.location.reload();             
          
            },
        })
    })

    $('#urunsil a').click(function()
    {
       var sectionId =$(this).attr('sectionId');

        $.post("islemler.php?islem=sil",{"urunid":sectionId},function(post_veri)
        {
        $(".sonuc2").html(post_veri);
        window.location.reload();            
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
<title>sistem Pos Restorant sistemleri </title>
</head>
<body>
<?php
// benim sorgum
    function benimsorgum2($vt,$sorgu,$tercih) 
    {
        
        $a= $sorgu;
        $b=$vt->prepare ($a);
        $b->execute();
        if ($tercih==1):
        return $c=$b->get_result();
        endif;      
    }   
// uyarı mesajı
    function uyari($mesaj,$renk)
    {
         echo '<div class="alert alert-'.$renk.' mt-4 text-center">'.$mesaj.'</div>';
    }    
// işlem     
    @$islem=$_GET["islem"];
    switch ($islem) :
// hesap işlemi
    case "hesap":

    if (!$_POST):
    echo "Posttan Gelmiyorsun";
    else:

         $masaid=htmlspecialchars($_POST["masaid"]);
         $sorgu="select * from anliksiparis where masaid=$masaid";
         $verilericek=benimsorgum2($db,$sorgu,1);

    while ($don=$verilericek->fetch_assoc()):

           $a=$don["masaid"];
           $b=$don["urunid"];
           $c=$don["urunad"];
           $d=$don["urunfiyat"];
           $e=$don["adet"];
           $bugun = date("Y-m-d");


     $raporekle="insert into rapor (masaid,urunid,urunad,urunfiyat,adet,tarih) values($a,$b,'$c',$d,$e,'$bugun')";
            $raporekles=$db->prepare($raporekle);
            $raporekles->execute();            
    endwhile;    
    $sorgu="DELETE FROM anliksiparis WHERE masaid=$masaid";
    $silme=$db->prepare($sorgu);
    $silme->execute();
    header('refresh:2,url=index.php');

    echo '<div class="alert alert-danger mt-4 text-center">
     Ürün Silindi

        </div>';
        header('refresh:2,url=index.php');
    endif;
    break;

    case "sil":
    if (!$_POST):
    echo "Posttan Gelmiyorsun";
    else:

    $gelenid=htmlspecialchars($_POST["urunid"]);

    $sorgu="DELETE FROM anliksiparis WHERE urunid=$gelenid";
    $silme=$db->prepare($sorgu);
    $silme->execute();
    echo '<div class="alert alert-danger mt-4 text-center">
     Ürün Silindi
        </div>';
    endif; 

    break;
// masa göster
               case "goster":
                    $id=htmlspecialchars($_GET["id"]);

                     $a="select * from anliksiparis where masaid=$id";
                     $d=benimsorgum2($db,$a,1);              

                     if ($d->num_rows==0) :
                    uyari("Henüz Sipariş Yok !","danger");


                   
                     else:
                        echo '
                        <table class="table table table-bordered table-striped text-center">
                        <thead>
                            <tr class="bg-dark text-white">

                            <th scope="col">Ürün</th>
                            <th scope="col">Adet</th>
                            <th scope="col">Fiyat</th>
                            <th scope="col">Tutar</th>
                              <th scope="col">İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                       ';
                        $adet=0;
                         $sontutar=0;


        while ($gelenson=$d->fetch_assoc()) :

        $tutar = $gelenson["adet"] * $gelenson["urunfiyat"];

        $adet +=$gelenson["adet"];
        $sontutar +=$tutar;
        $masaid=$gelenson["masaid"];

        echo '
        <tr >         
        <td class="mx-auto text-center p-4">'.$gelenson["urunad"].'</td>
        <td class="mx-auto text-center p-4">'.$gelenson["adet"].'</td>
         <td class="mx-auto text-center p-4">'.number_format($gelenson["urunfiyat"],2,'.',',').' ₺</td>
        <td class="mx-auto text-center p-4">'.number_format($tutar,2,'.',',').' ₺</td>
        <td id="urunsil"><a class="btn btn-danger mt-2 text-white" sectionId="'.$gelenson["urunid"].'"> X </a></td>
        </tr>
     
        ';       

        endwhile;

        echo '
        <tr class="bg-dark text-white text-center">
        <td><b>Toplam:</b></td>

         <td><b>'. $adet.'</b></td>
         <td><b>Adet </b> </td>
         <td colspan="3"><b>'.number_format($sontutar,2,'.',',').' ₺</b></td>
        </tr>
        <div class="sonuc2"></div>
        </tbody></table>
        <div class="row">
        <div class="col-md-12">

        <form id="hesapform">
        <input type="hidden" name="masaid" value="'.$masaid.'"/>
        <input type="button" id="btnhesap" value="Hesap Kapat" class="btn btn-info btn-block mt-4"/> 

        
        </form>  

        <p><a href="fisbastir.php?masaid='.$masaid.'" onclick="popup(this.href,\'mywindow\',\'700\',\'400\',\'yes\');return false" class="btn btn-warning btn-block mt-4"> Yazdır </a></p> 


        </div>            
        </div>';
        endif;
    break;
// masa ekle 
     case "ekle":
    if ($_POST) :
     @$masaid=htmlspecialchars($_POST["masaid"]);
     @$urunid=htmlspecialchars($_POST["urunid"]);
     @$adet=htmlspecialchars($_POST["adet"]);

     if ($masaid=="" || $urunid=="" || $adet=="") :
     uyari("Kayıt Başarısız Boş alan Var !!!","danger");

       

     else :
        $varmi="select * from anliksiparis where urunid=$urunid and masaid=$masaid";
        $var=benimsorgum2($db,$varmi,1);

        if ($var->num_rows!=0):

            $urundizi=$var->fetch_assoc();
            $sonadet= $adet + $urundizi["adet"];
            $islemid=$urundizi["id"];

            $guncel="UPDATE anliksiparis set adet=$sonadet where id=$islemid";
            $guncelson=$db->prepare($guncel);
            $guncelson->execute();

            uyari("Adet Güncellendi !!","success");
            

        else:
       $a="select * from urunler where id=$urunid";
             $d=benimsorgum2($db,$a,1);
             $son=$d->fetch_assoc();        
             $urunad=$son["ad"];
             $urunfiyat=$son["fiyat"];

             $ekle="INSERT INTO anliksiparis (masaid,urunid,urunad,urunfiyat,adet) VALUES ($masaid,$urunid,'$urunad',$urunfiyat,$adet)";
     $ekleson=$db->prepare($ekle);
     $ekleson->execute();

        echo '<div class="alert alert-success mt-4 text-center">
     Kayıt Eklendi
        </div>';



     endif;

             
    endif;
     else:

     echo '<div class="alert alert-danger mt-4 text-center">
     Kayıt Başarısız oldu!
        </div>';
     endif;

    break;

    case "urun":
     $katid=htmlspecialchars($_GET["katid"]);
     $a="select * from urunler where katid=$katid";
     $d=benimsorgum2($db,$a,1); 

     while ($sonuc=$d->fetch_assoc()):

     echo '<label class="btn btn-success m-2">

     <input name="urunid" type="radio" value="'.$sonuc["id"].'"/>
   '.$sonuc["ad"].'<br>'.$sonuc["fiyat"].' ₺</label>';
                        
    endwhile;

    break;
// Garson kontrol
    case "kontrol":

    $ad=htmlspecialchars($_POST["ad"]);
    $sifre=htmlspecialchars($_POST["sifre"]);

    if (@$ad!="" && @$sifre!=""):

        $var=benimsorgum2($db,"select * from garson where ad='$ad' and sifre='$sifre',1");

        if ($var->num_rows==0):
            echo '<div class="alert alert-danger text-center"> Bilgiler uyuşmuyor </div>';

        else:
             $garson=$var->fetch_assoc();
             $garsonid=$garson["id"];
             $benimsorgum2($db,"update garson set durum=1 where id=$garsonid",1);
             ?>
             <script>
                 window.location.reload();
             </script>
             <?php 
        endif;


        else:
            echo '<div class="alert alert-danger text-center"> Boş Alan Bırakma </div>';
    endif;

    break;
// Garson Çıkış
    case "cikis":
    benimsorgum2($db,"update garson set durum=0",1);
    header("location:index.php");
    break;
endswitch;
?>
</body>
</html>