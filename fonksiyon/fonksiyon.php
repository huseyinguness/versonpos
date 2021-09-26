<?php require_once 'baglan.php';

class sistem 
{
// baba sorgum
   private function benimsorgum($vt,$sorgu,$tercih) 
     {
        
        $a= $sorgu;
        $b=$vt->prepare ($a);
        $b->execute();
        if ($tercih==1):
        return $c=$b->get_result();
        endif;      
     }  
     function benimsorgum2($vt,$sorgu,$tercih) 
     {
        
        $a= $sorgu;
        $b=$vt->prepare ($a);
        $b->execute();
        if ($tercih==1):
        return $c=$b->get_result();
        endif;      
     }  
// masa cekme kodu start
       function masacek($dv) 
       {        
        $masalar = "select * from masalar";
        $sonuc=$this->benimsorgum($dv,$masalar,1);
        $bos=0;
        $dolu=0;
         while ($masason=$sonuc->fetch_assoc()):

            $siparisler='select * from anliksiparis where masaid='.$masason["id"].'';
            $this->benimsorgum($dv,$siparisler,1)->
            num_rows==0 ? 
            $renk="danger" : //boş masa
            $renk="success"; // dolu masa
            $this->benimsorgum($dv,$siparisler,1)->num_rows==0 ? $bos++ : $dolu++ ;
        

        echo '
        <div id="mas" class="col-md-2 col-md-2 mr-1 mx-auto p-2 text-center text-white" class="mx-auto text-center"> 
        <a href="masadetay.php?masaid='.$masason["id"].'">
        <div class="bg-'.$renk.' mx-auto p-1 text-center text-white" id="masa">'.$masason["ad"].'
        </div></a>
        </div>
        ';           
                
                 endwhile;

                $dol="update doluluk set bos=$bos,dolu=$dolu where id=1";
                $dolson=$dv->prepare($dol);
                $dolson->execute();

        }
// doluluk
               function doluluk($dv)
         {
            $son=$this->benimsorgum($dv,"select * from doluluk",1);
            $veriler=$son->fetch_assoc();

            $toplam = $veriler["bos"] + $veriler["dolu"];
            $oran=    ($veriler["dolu"] / $toplam) * 100 ;
            echo $oran=substr($oran, 0,5). " %";
         }
// masa toplam sayısı alma kodu start
          function masatoplam($dv) 
        {       
          echo $this->benimsorgum($dv,"select * from masalar",1)->num_rows;     
        }
// Sipariş toplam sayısı alma kodu start
            function siparistoplam($dv) 
        {       
          echo $this->benimsorgum($dv,"select * from anliksiparis",1)->num_rows;        
        }
// masa detay kodu start
         function masagetir($vt,$id) 
        {       
          $get="select * from masalar where id=$id";
        return $this->benimsorgum($vt,$get,1);  
        }   
// urun kategori 
        function urungrup ($db)
        {
            $se="select * from kategori";
            $gelen=$this->benimsorgum($db,$se,1);

            while ($son=$gelen->fetch_assoc()) :

                echo '<a class="btn btn-dark mt-2 text-white" sectionId="'.$son["id"].'">'.$son["ad"].' </a><br>';

            endwhile;
        }
  
  function garsonbak($db)
  {

    $gelen=$this->benimsorgum($db,"select * from garson where durum=1",1)->fetch_assoc();

      if ($gelen["ad"]!="") :

        echo $gelen["ad"];

        echo '<a href="islemler.php?islem=cikis" class"m-3"><kbd class="bg-info">Çıkış</kbd></a>';

      else:

        echo "Giriş Yapan GArson Yok";

      endif;

  }
}
?>
 <link rel="stylesheet" href="dosya/stil.css">