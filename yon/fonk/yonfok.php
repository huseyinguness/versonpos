<?php require_once 'baglan.php';
ob_start();

class yonetim {
protected $tablolar=array("gecicimasa","geciciurun","geciciodeme");
protected $select=array(
        "1"=> "SALON",
        "2"=> "BAHÇE",
        "3"=> "BALKON",
        "4"=> "TERAS"
     );
// uyarı sorgusu $aktar
    protected $aktar1,$aktar2,$veri1,$veri2,$veri3;
  private function uyari ($tip,$metin,$sayfa)
     {
        echo '<div class="alert alert-'.$tip.'">'.$metin.'</div>';
        header('refresh:1,url='.$sayfa.'');
    }
// Genel sorgu
     private function genelsorgu($db,$sorgu)
     {
        $sorgum=$db->prepare($sorgu);
        $sorgum->execute();
        return $sorguson=$sorgum->get_result(); 
     } 

     function ciktiicinsorgu($db,$sorgu)
     {
        $sorgum=$db->prepare($sorgu);
        $sorgum->execute();
        return $sorguson=$sorgum->get_result(); 
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
// kullanıcı cekme
    function kulad($db)
     {
        $id=$this->coz($_COOKIE["id"]);  

        $sorgu="select * from yonetim where id=$id";
        $gelensonuc=$this->genelsorgu($db,$sorgu);
        $b=$gelensonuc->fetch_assoc();
        return $b["adsoyad"];
     }
// Giriş Kontrol 
 public function giriskontrol($db,$k,$s) {
    $sonhal=md5(sha1(md5($s)));
    
    $sorgu="SELECT * FROM yonetim WHERE kulad='$k' and sifre='$sonhal'";
    $sor=$db->prepare($sorgu);
    $sor->execute();
    $sonbilgi=$sor->get_result();
    $veri=$sonbilgi->fetch_assoc();    
    if ($sonbilgi->num_rows==0) :  
    $this->uyari("danger","Bilgiler Hatalı Lüftfen Doğru Bilgi Giriniz !!","index.php");
    else:

    $sorgu="update yonetim set aktif=1 WHERE kulad='$k' and sifre='$sonhal'";
    $sor=$db->prepare($sorgu);
    $sor->execute();


    $this->uyari("success","Bilgiler  Doğru Giriş Yapılıyor !!","control.php");
    
    //cookie oluşturulacak    
    $kulson=md5(sha1(md5($k)));    
    setcookie("kul",$kulson, time() + 60*60*24);
    $id=$this->sifrele($veri["id"]);
    setcookie("id",$id, time() + 60*60*24);    
    endif;
    
    }
// cokkie Kontrol
      public function cookcont ($db,$durum=false)
     {
      if (isset($_COOKIE["kul"])):

        $deger =$_COOKIE["kul"];

        $id=$this->coz($_COOKIE["id"]);       

        $sorgu="SELECT * FROM yonetim WHERE id=$id";
        $sor=$db->prepare($sorgu);
        $sor->execute();
        $sonbilgi=$sor->get_result();
        $veri=$sonbilgi->fetch_assoc();
        $sonhal=md5(sha1(md5($veri["kulad"])));
        if ($sonhal!=$_COOKIE["kul"]) :
        setcookie("kul",$deger, time() -10 );          
        header("location:index.php");
        else:
        if ($durum==true) : header("location:control.php"); 
        endif;          
        
     endif;
        else:

        if ($durum==false) : header("location:index.php"); 
    endif;         
            
       endif;    
    }     
// Çıkış İşlemi
    function cikis ($r,$deger)
    {
        $id=$this->coz($_COOKIE["id"]); 

        $sorgu="update yonetim set aktif=0 where id=$id";
        $sor=$r->prepare($sorgu);
        $sor->execute();

        $deger=$md5=md5(sha1(md5($deger)));
        setcookie("kul",$deger,time() -10);
        setcookie("id",$_COOKIE["id"],time() -10);
        $this->uyari("warning","Çıkış Yapılıyor","index.php");
    }
// istatistikler
     function toplamgarson($db)
    {
       echo $this->genelsorgu($db,"select * from garson")->num_rows;
    }
    function topurunadet($db)
    {
        $geldi=$this->genelsorgu($db,"select SUM(adet) from anliksiparis")->fetch_assoc();
        echo $geldi['SUM(adet)'];
    }

    function toplammasa($db)
    {
        echo $this->genelsorgu($db,"select * from masalar")->num_rows;
    }
    function toplamkat($db)
    {
        echo $this->genelsorgu($db,"select * from kategoriler")->num_rows;
    }
    function toplamurun($db)
    {
        echo $this->genelsorgu($db,"select * from urunler")->num_rows;
    }


     function toplamkasa($db)
    {
        echo "00.00";
    }   
       function anlikkasa($db)
    {

              echo "00.00";

         
      
    }



    function doluluk($db)
     {           
     
       $veriler=$this->genelsorgu($db,"select * from doluluk")->fetch_assoc();
       $toplam = $veriler["bos"] + $veriler["dolu"];
       $oran=    ($veriler["dolu"] / $toplam) * 100 ;
       echo $oran=substr($oran, 0,5). " %";    
    }
// Bölüm Adı Geliyor
   function BolumBilgiVer($tercih)  {

    switch ($tercih) :
    

    case "1":
        echo '<td><input type="text" name="masaad" value="SALON" class="form-control m-1 text-info bg-dark"></td>';
        break;
    case "2":
     echo '<td><input type="text" name="masaad" value="BAHÇE" class="form-control m-1 text-white bg-dark"></td>';
        break;
    case "3":
     echo '<td><input type="text" name="masaad" value="BALKON" class="form-control m-1 text-success bg-dark"></td>';
        break;
    case "4":
     echo '<td><input type="text" name="masaad" value="TERAS" class="form-control m-1 text-warning bg-dark"></td>';
        break;
    endswitch;
   } 
// masa yönetimi
    function masayon ($db)
    {
    if ($_POST):           
        @$kategori=htmlspecialchars($_POST["kategori"]);
        $so=$this->genelsorgu($db,"select * from masalar where kategori=$kategori");
    else :
        $so=$this->genelsorgu($db,"select * from masalar");
    endif;

       echo ' <div class="col-md-12 text-left mr-auto mt-2" style="background-color: #5555 ;"> <h3> || Masa Yönetimi <a href="control.php?islem=masaekle" title=""> <input name="buton" type="submit" class="btn btn-success" value=" + Yeni Masa"></a></h3> </div>

       <table class="table text-center table-striped table-bordered mx-auto col-md-9 mt-4 table-dark">
              <thead>';
              //    <tr>
//      <th> 

                   //   <form action="control.php?islem=masayon" method="post">
                   //   <input type="search" name="urun" class="form-control" placeholder="Aranacak Kelimeyi Yazın"/></th>
                   //   <th> <input type="submit" name="aramabuton" value="Ara" class="btn btn-success"/>
                   //   </form>
                  //    </th>
                     echo' <th> 
                      <form action="control.php?islem=masayon" method="post">
                      <select name="kategori" class="form-control">
                            <option value="1"> SALON</option>
                            <option value="2"> BAHÇE</option>
                            <option value="3"> BALKON</option>
                            <option value="4"> TERAS</option>

                            
                        </select>
                        </th>
                      <th> <input type="submit" name="arama" value="Getir" class="btn btn-success">  
                      </form>
                      </th> 
                   </tr>                   
                </thead>              
               </table>';


      echo' <table class="table text-center table-striped table-bordered mx-auto col-md-9 mt-4">
                    <thead>
                        <th scope="col"> Masa No </th>
                        <th scope="col"> Masa Adı </th>
                         <th scope="col"> Bölüm Adı </th>
                        <th scope="col"> Güncelle</th>
                        <th scope="col"> Sil </th>
                    </thead><tbody>';             

     while ($sonuc=$so->fetch_assoc()):

        echo '<tr>
                 <td>'.$sonuc["id"].'</td>
                 <td><input type="text" name="masaad" value="'.$sonuc["ad"].'" class="form-control m-1"></td>';
                 $this->BolumBilgiVer($sonuc["kategori"]);

                echo ' <td><a href="control.php?islem=masaguncel&masaid='.$sonuc["id"].'" class="btn btn-warning">Güncelle</a></td>
                 <td><a href="control.php?islem=masasil&masaid='.$sonuc["id"].'" class="btn btn-danger" data-confirm="Silmek istediğinizden Eminmisiniz ?">Sil</a></td>
            </tr>';

     endwhile;
     echo ' </tbody> </table>';
    }
// masa sil
    function masasil ($db)
    {        
        @$masaid=htmlspecialchars($_GET["masaid"]);
        if ($masaid!="" && is_numeric($masaid)) :

            @$this->genelsorgu($db,"DELETE FROM masalar WHERE id=$masaid");
            @$this->uyari("success","Masa Başarı İle Silindi","control.php?islem=masayon");
        else:
            @$this->uyari("danger","Masa silinmedi hata oluştu !!","control.php?islem=masayon");
        endif;
    }
// masa Güncelle
    function masaguncel ($db)

    {
        @$buton=$_POST["buton"];

        echo '
       <div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> <h3> || Masa Yönetimi - Güncelleme </h3> </div>


        <div class="col-md-3 text-center mx-auto mt-5 table-bordered">';

        if ($buton) :

             @$masaad=htmlspecialchars($_POST["masaad"]);
              @$kategori=htmlspecialchars($_POST["kategori"]);
             @$masaid=htmlspecialchars($_POST["masaid"]);

             if ($masaad=="" && $masaid=="") :
                @$this->uyari("danger","Bilgiler Boş Olamaz!!","control.php?islem=masayon");

            else :

                $this->genelsorgu($db,"update masalar set ad='$masaad',kategori='$kategori' where id=$masaid");
                @$this->uyari("success","Masa Güncellendi!!","control.php?islem=masayon");  
            endif;          
            
         else:

        $masaid=$_GET["masaid"];

        $aktar=$this->genelsorgu($db,"select * from masalar where id=$masaid")->fetch_assoc(); 

        

            echo '<form action="" method="post">
                        <div class="col-md-12 table-light"> <h4> Masa Güncelle</h4></div>
                        <div class="col-md-12 table-light">
                        <input type="text" name="masaad" value="'.$aktar["ad"].'" class="form-control m-2"></div>
                        
                        <div class="col-md-12 table-light class="form-control m-2" >
                        <select name="kategori" class="form-control m-2">';

                        foreach ($this->select as $key => $value):
                            if ($key==$aktar["kategori"]):
                            echo '<option value="'.$key.'" selected="selected" > '.$value.'</option>';
                        else :
                             echo '<option value="'.$key.'"> '.$value.'</option>';
                         endif;
                             endforeach;                                                  
                        echo '</select>
                </div>
                        <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success" value="Kaydet"></div>
                        <input type="hidden" name="masaid" value="'.$aktar["id"].'">
                    </form>';
         endif; 
         echo ' </div>';


    }
// masa Ekleme
    function masaekle ($db)
    {
        @$buton=$_POST["buton"];
        echo '<div class="col-md-3 text-center mx-auto mt-5 table-bordered">';
        if ($buton) :
             @$masaad=htmlspecialchars($_POST["masaad"]);
             @$kategori=htmlspecialchars($_POST["kategori"]);
             if ($masaad=="") :
                @$this->uyari("danger","Bilgiler Boş Olamaz!!","control.php?islem=masayonetimi");
            else :
                @$this->genelsorgu($db,"insert into masalar (ad,kategori) values ('$masaad','$kategori')");
                @$this->uyari("success","Masa Eklendi !!","control.php?islem=masayon");  
            endif;            
         else:
            ?>

            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post"> 
                <?php  
                    echo '
                        <div class="col-md-12 table-light"> <h4> Masa Ekle</h4></div>
                        <div class="col-md-12 table-light">
                        <input type="text" name="masaad" class="form-control m-2"></div>
                        <div class="col-md-12 table-light class="form-control m-2">

                        <select name="kategori" class="form-control m-2">
                            <option value="1" selected="selected"> SALON</option>
                            <option value="2"> BAHÇE</option>
                            <option value="3"> BALKON</option>
                            <option value="4"> TERAS</option>

                            
                        </select>
                </div>
                        <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success" value="Kaydet"></div>
                </form>';
         endif; 
         echo ' </div>';
    }
// urun yönetimi
    function urunyon ($db,$tercih)
    {
      if ($tercih==1):
 // arama kodları
        $aramabuton=$_POST["aramabuton"];
        $urun=$_POST["urun"];
             if ($aramabuton):
            $so=$this->genelsorgu($db,"select * from urunler where ad LIKE '%$urun%'");
             endif;
        elseif ($tercih==2) :
 // kategori arama kodları
            $arama=$_POST["arama"];
             $katid=$_POST["katid"];

             if ($arama):
            $so=$this->genelsorgu($db,"select * from urunler where katid=$katid");
             endif;

    elseif ($tercih==3) :

    

     $olcu=$_GET["olcu"];
  

       $so=$this->genelsorgu($db,"select * from urunler where stok<>0 order by stok $olcu;");


        elseif ($tercih==0) :
        $so=$this->genelsorgu($db,"select * from urunler");
      endif;



       echo ' <div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> 
       <h3> || Ürün Yönetimi <a href="control.php?islem=urunekle" title=""> 
       <input name="buton" type="submit" class="btn btn-success" value=" + Yeni Ürün"></a></h3> </div>

       <table class="table text-center table-striped table-bordered mx-auto col-md-10 mt-4 table-dark">
                  <thead>
                  <tr>
                      <th> 

                      <form action="control.php?islem=aramasonuc" method="post">
                      <input type="search" name="urun" class="form-control" placeholder="Aranacak Kelimeyi Yazın"/></th>
                      <th> <input type="submit" name="aramabuton" value="Ara" class="btn btn-success"/>
                      </form>
                      </th>
                      <th> 
                      <form action="control.php?islem=katgore" method="post">
                      <select name="katid" class="form-control">';

                      $d=$this->genelsorgu($db,"select * from kategoriler");
                      while($katson=$d->fetch_assoc()) :
                        echo '
                        <option value="'.$katson["id"].'">'.$katson["ad"].'</option>';
                      endwhile;
                      echo'</select></th>
                      <th> <input type="submit" name="arama" value="Getir" class="btn btn-success">  
                      </form>
                      </th> 
                   </tr>                   
                </thead>              
               </table>';
       echo '<table class="table text-center table-striped table-bordered mx-auto col-md-10 mt-4">
                    <thead>
                        <th scope="col"> Ürün No </th>
                        <th scope="col"> Ürün Adı </th>
                        <th scope="col"> kategori Adı </th>
                        <th scope="col"> Fiyatı </th>
                         <th scope="col"><a href="control.php?islem=siralama&olcu=desc" title=""><i class="fas fa-arrow-up"></i>
                         </a> Ürün Stok  <a href="control.php?islem=siralama&olcu=asc" title=""><i class="fas fa-arrow-down"></i></a></th>
                        <th scope="col"> Güncelle</th>
                        <th scope="col"> Sil </th>
                    </thead><tbody>';
     while ($sonuc=$so->fetch_assoc()):
        echo '<tr>
                 <td>'.$sonuc["id"].'</td>
                 <td><input type="text" name="urunad" value="'.$sonuc["ad"].'" class="form-control m-1"></td>
                 <td>';
                        $katid=$sonuc["katid"];
                        $katcek=$this->genelsorgu($db,"select * from kategoriler");
                        echo '<select name="katid" class="selected m-2 form-control">';
                        while($katson=$katcek->fetch_assoc()):
                            if ($katson["id"]==$katid):
                                echo'<option value="'.$katson["id"].'" selected="selected">'.$katson["ad"].' </option>';
                               else :
                                echo'<option value="'.$katson["id"].'">'.$katson["ad"].' </option>';
                            endif;                                    
                        endwhile;
                        echo ' </select>';
                 echo' </td>
                 <td><input type="text" name="fiyat" value="'.$sonuc["fiyat"].' ₺" class="form-control m-1"></td>
                   <td>';

                if($sonuc["stok"]=="Yok"):
                    echo '<input type="text" name="stok" value="Yok" class="form-control m-1 text-danger">';
                else:
                    echo'<input type="text" name="stok" value="'.$sonuc["stok"].'" class="form-control m-1 text-success">';
                endif;

               echo'</td>
                 <td><a href="control.php?islem=urunguncel&urunid='.$sonuc["id"].'" class="btn btn-warning">Güncelle</a></td>
                 <td><a href="control.php?islem=urunsil&urunid='.$sonuc["id"].'" class="btn btn-danger" data-confirm="Silmek istediğinizden Eminmisiniz ?">Sil</a></td>
            </tr>';
     endwhile;
     echo ' </tbody> </table>';
      }
// urun sil
    function urunsil ($db)
    {        
        @$urunid=htmlspecialchars($_GET["urunid"]);

        if ($urunid!="" && is_numeric($urunid)) :
              
             $satir=$this->genelsorgu($db,"select * FROM anliksiparis WHERE urunid=$urunid");

              if ($satir->num_rows!=0):
                echo '<div class="alert-danger mt-4">
                Bu ürün aşağıdaki Masalarda Mevcut olduğu için Silinmedi !! <br>';
                 header('refresh:3,url=control.php?islem=urunyonetimi');

                
                while($masabilgi=$satir->fetch_assoc()):
                $masaid=$masabilgi["masaid"];
                $masasonuc=$this->genelsorgu($db,"select * from masalar where id=$masaid")->fetch_assoc();



                echo "-".$masasonuc["ad"]."<br>";

                endwhile;                   
               
                echo ' </div>';                  

              else:
                 @$this->genelsorgu($db,"DELETE FROM urunler WHERE id=$urunid");
                @$this->uyari("success","Ürün Başarı İle Silindi","control.php?islem=urunyonetimi");

              endif;           
        else:
            @$this->uyari("danger","Ürün silinmedi hata oluştu !!","control.php?islem=urunyonetimi");
        endif;
    }    
// urun Güncelle
    function urunguncel ($db)

    {
        @$buton=$_POST["buton"];
        echo '
       <div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> <h3> || Ürün Yönetimi - Güncelleme </h3> </div>
        <div class="col-md-5 text-center mx-auto mt-5 table-bordered">';
       
        $urunid=$_GET["urunid"];
        $aktar=$this->genelsorgu($db,"select * from urunler where id=$urunid")->fetch_assoc(); 


        if ($buton) :
             @$urunad=htmlspecialchars($_POST["urunad"]);
             @$katid=htmlspecialchars($_POST["katid"]);
             @$fiyat=htmlspecialchars($_POST["fiyat"]);
             @$stok=htmlspecialchars($_POST["stok"]);
             @$tercih=htmlspecialchars($_POST["tercih"]);
             @$urunid=htmlspecialchars($_POST["urunid"]);

             if ($urunad=="" || $urunid=="" || $katid=="" || $fiyat=="") :
                @$this->uyari("danger","Bilgiler Boş Olamaz!!","control.php?islem=urunyon");

            else :

                if ($stok!=""):

                    if ($tercih=="ekle"):
                         $sonstok=$stok + $aktar["stok"];

                    elseif ($tercih=="cikart"):
                         $sonstok=$aktar["stok"] - $stok;

                    endif;

                   
                else :
                    $sonstok=$aktar["stok"];

                endif;

                @$this->genelsorgu($db,"update urunler set ad='$urunad',fiyat=$fiyat,katid=$katid, stok='$sonstok' where id=$urunid");
                @$this->uyari("success","Ürün Güncellendi!!","control.php?islem=urunyon");  
            endif;
         else:
         
            echo '<form action="" method="post">                       
                        <div class="col-md-12 table-light text-danger mt-2">Ürün adı :    <input type="text" name="urunad" value="'.$aktar["ad"].'" class="form-control m-2"></div>                     
                        <div class="col-md-12 table-light text-danger mt-2">Fiyatı :      <input type="text" name="fiyat" value="'.$aktar["fiyat"].'" class="form-control m-2"></div>
                        
                         <div class="col-md-12 table-light text-danger mt-1">Ürün Stok :  </div>                        

                         <div class="col-md-12 text-danger">
                         Ekle <input type="radio" name="tercih" value="ekle" checked="checked" class="mr-5"/>
                         Azalt <input type="radio" name="tercih" value="cikart" p-2 />

                         <div class="col-md-12 text-danger">
                         <input type="text" name="stok" value="" class="form-control">
                         <div class="text-success"> Mevcut Stok : ('.$aktar["stok"].') Adet </b> </div> 
                        <hr>
                         
                        <div class="col-md-12 table-light text-danger" class="form-control">';

                        $katid=$aktar["katid"];
                        $katcek=$this->genelsorgu($db,"select * from kategoriler");
                         echo 'Kategori<select name="katid" class="mt-3 form-control">';
                        while($katson=$katcek->fetch_assoc()):
                            if ($katson["id"]==$katid):
                                echo'<option value="'.$katson["id"].'" selected="selected" class="form-control">'.$katson["ad"].' </option>';
                               else :
                                echo'<option value="'.$katson["id"].'">'.$katson["ad"].' </option>';
                            endif;                                    
                        endwhile;
                        echo ' </select>';


                       echo ' </div>
                        <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success" value="Kaydet"></div>
                        <input type="hidden" name="urunid" value="'.$aktar["id"].'">
                    </form>';
         endif; 
         echo ' </div></div>';    }
// urun Ekleme
    function urunekle ($db)

    {
        @$buton=$_POST["buton"];
         echo '
       <div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> <h3> || urun Yönetimi - Ekleme </h3> </div>
        <div class="col-md-5 text-center mx-auto mt-5 table-bordered">';
        if ($buton) :
             @$urunad=htmlspecialchars($_POST["urunad"]);
             @$katid=htmlspecialchars($_POST["katid"]);
             @$fiyat=htmlspecialchars($_POST["fiyat"]); 
              @$stok=htmlspecialchars($_POST["stok"]);
             @$tercih=htmlspecialchars($_POST["tercih"]);           

             if ($urunad=="" && $katid=="" && $fiyat=="") :
                @$this->uyari("danger","Bilgiler Boş Olamaz!!","control.php?islem=urunyonetimi");
            else :

                if ($stok!=""):

                    if ($tercih=="var"):
                         $sonstok=$stok;

                    elseif($tercih=="yok"):
                         $sonstok="Yok";

                    endif;                   
                else :
                    $sonstok="Yok";
                endif;

                @$this->genelsorgu($db,"insert into urunler (ad,katid,fiyat,stok) values ('$urunad',$katid,$fiyat,'$sonstok')");
                @$this->uyari("success","urun Eklendi !!","control.php?islem=urunyon");  
            endif;
         else:
                        echo '<form action="" method="post">                        
                        <div class="col-md-12 table-light">ürün adı : <input type="text" name="urunad" class="form-control m-2"></div>
                        
                        <div class="col-md-12 table-light">Fiyatı :<input type="text" name="fiyat" class="form-control m-2"></div>

                         <div class="col-md-12 table-light text-danger mt-2">Ürün Stok :  </div>

                         

                         <div class="col-md-12 text-danger mt-2">
                         Var <input type="radio" name="tercih" value="var"  class="mr-5"/>
                         Yok <input type="radio" name="tercih" value="yok" checked="checked"  p-2 />
                             
                         </div>


                         <div class="col-md-12 text-danger mt-2"><input type="text" name="stok" value="" class="form-control m-2">
        <hr>';

                        $katcek=$this->genelsorgu($db,"select * from kategoriler");
                        echo '
                        Kategori : <select name="katid" class="selected m-2 form-control">';
                        while($katson=$katcek->fetch_assoc()):                            
                                echo'<option value="'.$katson["id"].'">'.$katson["ad"].' </option>';                  
                        endwhile;
                        echo ' </select>';
                       echo ' </div>                        
                        <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success" value="Kaydet"></div>
                </form>';
         endif; 
         echo ' </div>';
    }
// kategori yönetimi
    function kategoriyon ($db)
    {

        $so=$this->genelsorgu($db,"select * from kategoriler");

       echo ' <div class="col-md-12 text-left mr-auto mt-3" style="background-color: #5555 ;"> <h3> || kategori Yönetimi <a href="control.php?islem=kategoriekle" title=""> <input name="buton" type="submit" class="btn btn-success" value=" + Yeni Kategori"></a></h3> </div>

       <table class="table text-center table-striped table-bordered mx-auto col-md-10 mt-4">
                    <thead>
                        <th scope="col"> Kategori No </th>                        
                        <th scope="col"> Kategori Adı </th>                      
                        <th scope="col"> Güncelle</th>
                        <th scope="col"> Sil </th>
                    </thead><tbody>';                                         

     while ($sonuc=$so->fetch_assoc()):

        echo '<tr>
                 <td>'.$sonuc["id"].'</td>
                
                 <td><input type="text" name="kategoriad" value="'.$sonuc["ad"].'" class="form-control m-1"></td>                                
                 <td><a href="control.php?islem=katguncel&kategoriid='.$sonuc["id"].'" name="buton" class="btn btn-warning">Güncelle</a></td>
                 <td><a href="control.php?islem=kategorisil&kategoriid='.$sonuc["id"].'" class="btn btn-danger" data-confirm="Silmek istediğinizden Eminmisiniz ?">Sil</a></td>
            </tr>';

     endwhile;
     echo ' </tbody> </table>';
    }
// kategori sil
    function kategorisil ($db)
    {        
        @$kategoriid=htmlspecialchars($_GET["kategoriid"]);
         @$kategoriad=htmlspecialchars($_GET["kategoriad"]);
        if ($kategoriid!="" && is_numeric($kategoriid)) :

            @$this->genelsorgu($db,"DELETE FROM kategori WHERE id=$kategoriid");
            @$this->uyari("success","Ürün Başarı İle Silindi","control.php?islem=kategoriyonetimi");
        else:
            @$this->uyari("danger","Ürün silinmedi hata oluştu !!","control.php?islem=kategoriyonetimi");
        endif;
    }    
// kategori Güncelle
    function katguncel ($db)

    {
        @$buton=$_POST["buton"];

        echo '
       <div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> <h3> || kategori Yönetimi - Güncelleme </h3> </div>
        <div class="col-md-5 text-center mx-auto mt-5 table-bordered">';

        if ($buton) :

             @$kategoriad=htmlspecialchars($_POST["kategoriad"]);
             @$kategoriid=htmlspecialchars($_POST["kategoriid"]); 

             if ($kategoriad=="" && $kategoriid=="") :
                @$this->uyari("danger","Bilgiler Boş Olamaz!!","control.php?islem=kategoriyonetimi");
            else :
                $this->genelsorgu($db,"update kategori set ad='$kategoriad' where id=$kategoriid");
                @$this->uyari("success","kategori Güncellendi!!","control.php?islem=kategoriyonetimi");  
            endif;          
            
         else:

        $kategoriid=$_GET["kategoriid"];

        $aktar=$this->genelsorgu($db,"select * from kategoriler where id=$kategoriid")->fetch_assoc();  

            echo '<form action="" method="post">                       
                       
                        <div class="col-md-12 table-light">Kategori adı :<input type="text" name="kategoriad" value="'.$aktar["ad"].'" class="form-control m-2"></div>
                      
                        <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success" value="Kaydet"></div>
                        <input type="hidden" name="kategoriid" value="'.$aktar["id"].'">
                    </form>';
         endif; 
         echo ' </div>';


    }
// kategori Ekleme 
    function kategoriekle ($db)

    {
        @$buton=$_POST["buton"];
         echo '
       <div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> <h3> || kategori Yönetimi - Ekleme </h3> </div>
        <div class="col-md-5 text-center mx-auto mt-5 table-bordered">';

        if ($buton) :

             @$kategoriad=htmlspecialchars($_POST["kategoriad"]);
             @$katid=htmlspecialchars($_POST["katid"]);
           
             

             if ($kategoriad=="" && $katid=="") :

                @$this->uyari("danger","Bilgiler Boş Olamaz!!","control.php?islem=kategoriyonetimi");

            else :

                @$this->genelsorgu($db,"insert into kategori (ad) values ('$kategoriad')");

                @$this->uyari("success","kategori Eklendi !!","control.php?islem=kategoriyonetimi");  


            endif;          
            
         else:
            ?>

            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <?php 
                    echo '
                        
                        <div class="col-md-12 table-light">ürün adı : <input type="text" name="kategoriad" class="form-control m-2"></div>
                    
                        <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success" value="Kaydet"></div>
                </form>';
         endif; 
         echo ' </div>';
    } 
// garson yönetimi
    function garsonyon($db)
    {

        $so=$this->genelsorgu($db,"select * from garson");

       echo ' <div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> <h3> || Garson Yönetimi <a href="control.php?islem=garsonekle" title=""> <input name="buton" type="submit" class="btn btn-success" value=" + Yeni garson"></a></h3> </div>
       <table class="table text-center table-striped table-bordered mx-auto col-md-10 mt-4">
                    <thead>
                        <th scope="col"> Garson No </th>                        
                        <th scope="col"> Garson Adı </th> 
                        <th scope="col"> Garson Şifre </th>                       
                        <th scope="col"> Güncelle</th>
                        <th scope="col"> Sil </th>
                    </thead><tbody>';                                         

     while ($sonuc=$so->fetch_assoc()):

        echo '<tr>
                 <td>'.$sonuc["id"].'</td>
                
                 <td><input type="text" name="garsonad" value="'.$sonuc["ad"].'" class="form-control m-1"></td>    
                 <td>
                 <input type="text" name="garsonsifre" value="'.$sonuc["sifre"].'" class="form-control m-1">
                 </td>   

                 <td><a href="control.php?islem=garsonguncel&garsonid='.$sonuc["id"].'" name="buton" class="btn btn-warning">Güncelle</a></td>
                 <td><a href="control.php?islem=garsonsil&garsonid='.$sonuc["id"].'" class="btn btn-danger" data-confirm="Silmek istediğinizden Eminmisiniz ?">Sil</a></td>
            </tr>';

     endwhile;
     echo ' </tbody> </table>';
    }
// garson sil
    function garsonsil ($db)
    {        
        @$garsonid=htmlspecialchars($_GET["garsonid"]);
         @$garsonad=htmlspecialchars($_GET["garsonad"]);
        if ($garsonid!="" && is_numeric($garsonid)) :

            @$this->genelsorgu($db,"DELETE FROM garson WHERE id=$garsonid");
            @$this->uyari("success","garson Başarı İle Silindi","control.php?islem=garsonyonetimi");
        else:
            @$this->uyari("danger","garson silinmedi hata oluştu !!","control.php?islem=garsonyonetimi");
        endif;
    }    
// garson Güncelle
    function garsonguncel ($db)

    {
        @$buton=$_POST["buton"];

        echo '
       <div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> <h3> || Garson Yönetimi - Güncelleme </h3> </div>
        <div class="col-md-5 text-center mx-auto mt-5 table-bordered">';

        if ($buton) :

             @$garsonad=htmlspecialchars($_POST["garsonad"]);
             @$garsonsifre=htmlspecialchars($_POST["garsonsifre"]);
             @$garsonid=htmlspecialchars($_POST["garsonid"]); 

             if ($garsonad=="" && $garsonid=="" && $garsonsifre=="") :
                @$this->uyari("danger","Bilgiler Boş Olamaz!!","control.php?islem=garsonyonetimi");
            else :
                $this->genelsorgu($db,"update garson set ad='$garsonad',sifre='$garsonsifre' where id=$garsonid");
                @$this->uyari("success","Garson Güncellendi!!","control.php?islem=garsonyonetimi");  
            endif;          
            
         else:

        $garsonid=$_GET["garsonid"];

        $aktar=$this->genelsorgu($db,"select * from garson where id=$garsonid")->fetch_assoc();  

            echo '

            <form action="" method="post">  

                        <div class="col-md-12 table-light">garson adı :<input type="text" name="garsonad" value="'.$aktar["ad"].'" class="form-control m-2"></div>
                        <div class="col-md-12 table-light">garson adı :<input type="text" name="garsonsifre" value="'.$aktar["sifre"].'" class="form-control m-2"></div>
                      
                        <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success" value="Kaydet"></div>
                        <input type="hidden" name="garsonid" value="'.$aktar["id"].'">
                        </form>
                    ';
         endif; 
         echo ' </div>';
    }
// garson Ekleme  
    function garsonekle ($db)

    {
        @$buton=$_POST["buton"];
         echo '
       <div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> <h3> || Garson Yönetimi - Ekleme </h3> </div>
        <div class="col-md-5 text-center mx-auto mt-5 table-bordered">';

        if ($buton) :

             @$garsonad=htmlspecialchars($_POST["garsonad"]);
              @$garsonsifre=htmlspecialchars($_POST["garsonsifre"]);         
           
              if ($garsonad=="" && $garsonsifre=="") :
                @$this->uyari("danger","Bilgiler Boş Olamaz!!","control.php?islem=garsonyonetimi");
            else :

                @$this->genelsorgu($db,"insert into garson (ad,sifre) values ('$garsonad','$garsonsifre')");

                @$this->uyari("success","garson Eklendi !!","control.php?islem=garsonyonetimi");  
            endif;          
            
         else:
            ?>

            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <?php 
                    echo '
                        
                        <div class="col-md-12 table-light">Garson Adı : <input type="text" name="garsonad" class="form-control m-2"></div>
                        <div class="col-md-12 table-light">Garson Şifre : <input type="text" name="garsonsifre" class="form-control m-2"></div>
                    
                        <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success" value="Kaydet"></div>
                </form>';
         endif; 
         echo ' </div>';
    }     
// şifre değişim
    function sifredegis ($db)

    {
        @$buton=$_POST["buton"];
         echo '
                <div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> <h3> || Şifre İşlemleri - Değiştirme </h3> </div>
                <div class="col-md-5 text-center mx-auto mt-5 table-bordered">';

        if ($buton) :

             @$eskisif=htmlspecialchars($_POST["eskisif"]);
             @$yen1=htmlspecialchars($_POST["yen1"]);
             @$yen2=htmlspecialchars($_POST["yen2"]);        
             

             if ($eskisif=="" || $yen1=="" || $yen2=="") :
                @$this->uyari("danger","Bilgiler Boş Olamaz!!","control.php?islem=sifredegis");

            else :
                 $eskisfson=md5(sha1(md5($eskisif)));

                if ($this->genelsorgu($db,"select * from yonetim where sifre='$eskisfson'")->num_rows==0) :
                    @$this->uyari("danger","Eski Şifre Hatalı !!","control.php?islem=sifredegis");

                elseif ($yen1!=$yen2) :
                     @$this->uyari("danger","Şifreler Uyumsuz Lütfen şifreleri Aynı Giriniz !!","control.php?islem=sifredegis");
                else :
                    $yenisifre=md5(sha1(md5($yen1)));

                    $id=$this->coz($_COOKIE["id"]); 
                    $this->genelsorgu($db,"update yonetim set sifre='$yenisifre' where id=$id");
                    @$this->uyari("success","Tebrikler ! Şifreniz Değişti ;)","control.php"); 

                  endif;                
            endif;                  
            
         else:
            ?>

            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <?php 
                    echo '                        
                        <div class="col-md-12 table-light"> <input type="text" name="eskisif" class="form-control m-2" placeholder="Eski Şifrenizi Girin"></div>

                         <div class="col-md-12 table-light"><input type="text" name="yen1" class="form-control m-2" placeholder="Yeni Şifrenizi Girin"></div>

                          <div class="col-md-12 table-light"> <input type="text" name="yen2" class="form-control m-2" placeholder="Yeni Şifrenizi Tekrar Girin"></div>
                    

                        <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success" value="Değiştir" ></div>
                </form>';
         endif; 
         echo ' </div>';
    }
// Rapor masa ürün ayar  kodları
    function raporayar ($db,$sorgu)
    {
       foreach ($this->tablolar as $ad):
           $this->genelsorgu($db,"Truncate ".$ad); 
        endforeach;

       // $this->genelsorgu($db,"Truncate gecicimasa");
       // $this->genelsorgu($db,"Truncate geciciurun");
       // $this->genelsorgu($db,"Truncate geciciodeme");
        $this->veri1=$this->genelsorgu($db,$sorgu);
        $this->veri2=$this->genelsorgu($db,$sorgu);
        $this->veri3=$this->genelsorgu($db,$sorgu);
    }
// Rapor masa ürün  kodları
  function rapor ($db) {        
        
        
        @$tercih=$_GET["tar"];
        
        switch ($tercih) :
        
        case "bugun":
        $this->raporayar($db,"select * from rapor where tarih=CURDATE()");    
        break;


        case "dun":
        $this->raporayar($db,"select * from rapor where tarih = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
        break;


        case "hafta":

        $this->raporayar($db,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
        break;
        case "ay":  
        $this->raporayar($db,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");     
        
        break;
        case "tum":

         $this->raporayar($db,"select * from rapor"); 
        break;
        
        case "tarih":

        $tarih1=$_POST["tarih1"];
        $tarih2=$_POST["tarih2"];
        echo '<div class="alert alert-info text-center mx-auto mt-4">
        
        '.$tarih1.' - '.$tarih2.'
        
        </div>';
         $this->raporayar($db,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");        
        break;
        
        
        default;
        $this->raporayar($db,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)"); 
    
        endswitch;
        
        
        
        
        
        
        echo '<table class="table text-center table-light table-bordered mx-auto mt-4  col-md-12">';
                
                
                if (@$tarih1!="" || @$tarih2!="") :
                
                echo '
                <thead>
                <tr>
                <th colspan="12"><a href="cikti.php?islem=ciktial&tar1='.$tarih1.'&tar2='.$tarih2.'" onclick="ortasayfa(this.href,\'mywindow\',\'900\',\'800\',\'yes\');return false" class="btn btn-warning m-2">ÇIKTI</a><a href="excel.php?tar1='.$tarih1.'&tar2='.$tarih2.'" class="btn btn-info">EXCEL AKTAR</a></th></tr></thead>';
                
                endif;
                
                
                
                
                
                echo '<thead>
                <tr class="text-center">
                <th><a href="control.php?islem=raporyon&tar=bugun">Bugün</a></th> 
                <th><a href="control.php?islem=raporyon&tar=dun">Dün</a></th> 
                <th><a href="control.php?islem=raporyon&tar=hafta">Bu hafta</a></th> 
                <th><a href="control.php?islem=raporyon&tar=ay">Bu Ay</a></th> 
                <th><a href="control.php?islem=raporyon&tar=tum">Tüm Zamanlar</a></th> 
                <th colspan="2" class="mx-auto"><form action="control.php?islem=raporyon&tar=tarih" method="post">
                <input type="date" name="tarih1" class="form-control col-md-12">
                
                </th>  
                <th colspan="2">
                <input type="date" name="tarih2" class="form-control col-md-12">
                </th>  
                
                <th><input name="buton" type="submit" class="btn btn-danger" value="GÖSTER"></form></th>  
                             
                </tr>                
                </thead>
                
                
                
                <tbody>
                <tr>
                
                 <td colspan="4">
                 
                         <table class="table text-center table-bordered col-md-12 table-striped">
                         <thead>
                         <tr>
                         <th colspan="4" class="bg-light text-dark">MASA ADET VE HASILAT</th>                         
                         </tr>                         
                         </thead>
                         <thead>
                         <tr class="text-dark">
                         <th colspan="2">Ad</th>   
                         <th colspan="1">Adet</th> 
                         <th colspan="1">Hasılat</th>                       
                         </tr>                         
                         </thead> <tbody>'; 
                         
                         $kilit=$this->genelsorgu($db,"select * from gecicimasa");                       
                         if ($kilit->num_rows==0) :                          
                        while ($gel=$this->veri1->fetch_assoc()):
                                                
                        // masa adını çekiyoruz
                        $id=$gel["masaid"];
                        $masaveri=$this->genelsorgu($db,"select * from masalar where id=$id")->fetch_assoc();
                        $masaad=$masaveri["ad"];
                        // masa adını çekiyoruz
                        
                        $raporbak=$this->genelsorgu($db,"select * from gecicimasa where masaid=$id");
                        
                        if ($raporbak->num_rows==0) :
                        //ekleme
                        
                        $has=$gel["adet"] * $gel["urunfiyat"];
                        $adet=$gel["adet"];
                        
                        $this->genelsorgu($db,"insert into gecicimasa (masaid,masaad,hasilat,adet) VALUES($id,'$masaad',$has,$adet)");                      
                        else:                   
                        $raporson=$raporbak->fetch_assoc();
                        $gelenadet=$raporson["adet"];
                        $gelenhas=$raporson["hasilat"];
                        
                        $sonhasilat=$gelenhas + ($gel["adet"] * $gel["urunfiyat"]); 
                        $sonadet=$gelenadet  + $gel["adet"];
                        
    $this->genelsorgu($db,"update gecicimasa set hasilat=$sonhasilat, adet=$sonadet where masaid=$id");
                        
                        //güncelleme
                        
                        endif;                  
                        
                        
                        endwhile;
                         
                         
                         endif;                      
                         
        $son=$this->genelsorgu($db,"select * from gecicimasa order by hasilat desc;");          
        $toplamadet=0;
        $toplamhasilat=0;       
        
        while ($listele=$son->fetch_assoc()) :      
        
                        echo '<tr>
                         <td colspan="2">'.$listele["masaad"].'</td>   
                         <td colspan="1">'.$listele["adet"].'</td> 
                         <td colspan="1">'.number_format($listele["hasilat"],2,'.','.').'</td>                       
                         </tr>   ';
                         $toplamadet += $listele["adet"];
                         $toplamhasilat +=$listele["hasilat"];
                    
        endwhile;            
                         
                         
                         
                         
                                          
                         
                        echo'<tr class="font-weight-bold table-secondary text-info">
                         <td colspan="2">TOPLAM</td>   
                         <td colspan="1">'.$toplamadet.'</td> 
                         <td colspan="1">'.number_format($toplamhasilat,2,'.','.').'</td>                       
                         </tr>
                                
                        </tbody> </table> 
                 
                 
                 
                 
                 </td>  
                 
                 
                 
                 
                 
                         
                  <td colspan="3" >
                  
                   <table class="table text-center table-bordered col-md-12 table-striped">
                         <thead>
                         <tr>
                         <th colspan="4" class="bg-light text-dark">ÜRÜN ADET VE HASILAT</th>                         
                         </tr>                         
                         </thead>
                         <thead>
                         <tr class="text-dark">
                         <th colspan="2">Ad</th>   
                         <th colspan="1">Adet</th> 
                         <th colspan="1">Hasılat</th>                       
                         </tr>                         
                         </thead> <tbody>'; 
                         
                         $kilit2=$this->genelsorgu($db,"select * from geciciurun");                      
                         if ($kilit2->num_rows==0) :                             
                        while ($gel2=$this->veri2->fetch_assoc()):
                                                
                        
                        $id=$gel2["urunid"];
                    
                        $urunad=$gel2["urunad"];
                        
                        $raporbak=$this->genelsorgu($db,"select * from geciciurun where urunid=$id");
                        
                        if ($raporbak->num_rows==0) :
                        //ekleme
                        
                        $has=$gel2["adet"] * $gel2["urunfiyat"];
                        $adet=$gel2["adet"];
                        
                        $this->genelsorgu($db,"insert into geciciurun (urunid,urunad,hasilat,adet) VALUES($id,'$urunad',$has,$adet)");                      
                        else:                   
                        $raporson=$raporbak->fetch_assoc();
                        $gelenadet=$raporson["adet"];
                        $gelenhas=$raporson["hasilat"];
                        
                        $sonhasilat=$gelenhas + ($gel2["adet"] * $gel2["urunfiyat"]); 
                        $sonadet=$gelenadet  + $gel2["adet"];
                        
    $this->genelsorgu($db,"update geciciurun set hasilat=$sonhasilat, adet=$sonadet where urunid=$id");
                        
                        //güncelleme
                        
                        endif;                  
                        
                        
                        endwhile;
                         
                         
                         endif;                      
                         
        $son2=$this->genelsorgu($db,"select * from geciciurun order by hasilat desc;");         
            
        
        while ($listele2=$son2->fetch_assoc()) :        
        
                        echo '<tr >
                         <td colspan="2">'.$listele2["urunad"].'</td>   
                         <td colspan="1">'.$listele2["adet"].'</td> 
                         <td colspan="1">'.number_format($listele2["hasilat"],2,'.','.').'</td>                       
                         </tr>   ';
                    
                    
        endwhile;         
                         
                echo'</tbody> </table>
                  
                  </td>  
                  
                  <td colspan="3" >
                  
                   <table class="table text-center table-bordered col-md-12 table-striped">
                         <thead>
                         <tr>
                         <th colspan="4" class="bg-light text-dark">ÖDEME SEÇENEKLERİ</th>                         
                         </tr>                         
                         </thead>
                         <thead>
                         <tr class="text-dark">
                         <th colspan="2">Ad</th>   
                        
                         <th colspan="2">Hasılat</th>                       
                         </tr>                         
                         </thead> <tbody>'; 
                         
                         $kilit3=$this->genelsorgu($db,"select * from geciciodeme");                      
                         if ($kilit3->num_rows==0) :                             
                        while ($gel3=$this->veri3->fetch_assoc()):
                                                
                        
                        $odemesecenek=$gel3["odemesecenek"];
                    
                       
                        
                        $raporbak=$this->genelsorgu($db,"select * from geciciodeme where secenek='$odemesecenek'");
                        
                        if ($raporbak->num_rows==0) :
                        //ekleme
                        
                        $has=$gel3["adet"] * $gel3["urunfiyat"];                        
                        $this->genelsorgu($db,"insert into geciciodeme (secenek,hasilat) VALUES('$odemesecenek',$has)");                      
                        else:                   
                        $raporson=$raporbak->fetch_assoc();                       
                        $gelenhas=$raporson["hasilat"];
                        $sonhasilat=$gelenhas + ($gel3["adet"] * $gel3["urunfiyat"]);                    
                        
    $this->genelsorgu($db,"update geciciodeme set hasilat=$sonhasilat where secenek='$odemesecenek'");
                        
                        //güncelleme
                        
                        endif;                  
                        
                        
                        endwhile;
                         
                         
                         endif;                      
                         
        $son3=$this->genelsorgu($db,"select * from geciciodeme order by hasilat desc;");        
            
        
        while ($listele3=$son3->fetch_assoc()) :        
        
                        echo '<tr>
                         <td colspan="2">'.$listele3["secenek"].'</td>   
                        
                         <td colspan="2">'.number_format($listele3["hasilat"],2,'.','.').'</td>                       
                         </tr>   ';
                    
                    
        endwhile;            
                         
                         
                         
                         
                                          
                         
                        echo'</tbody> </table> 
                 
                  
                  </td>          
                  
                  
                  
                         
                </tr>
                
                
                </tbody>
                </table>';
        
        
    }  // RAPORLAMA BÖLÜMÜ
// Rapor garson kodları
    function garsonper ($db)
     {
    echo '<div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> <h3> || Rapoarlar - Garson Rapor </h3> </div>';

    @$tercih=$_GET["tar"];
        
        switch ($tercih) :
        
    
        
        case "bugun":
        $this->genelsorgu($db,"Truncate gecicimasa");
        $this->genelsorgu($db,"Truncate geciciurun");
        $veri=$this->genelsorgu($db,"select * from rapor where tarih=CURDATE()");
        $veri2=$this->genelsorgu($db,"select * from rapor where tarih=CURDATE()");
    
        break;
        case "dun":
        $this->genelsorgu($db,"Truncate gecicimasa");
        $this->genelsorgu($db,"Truncate geciciurun");
        $veri=$this->genelsorgu($db,"select * from rapor where tarih = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
        $veri2=$this->genelsorgu($db,"select * from rapor where tarih = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
    
        break;
        case "hafta":
        $this->genelsorgu($db,"Truncate gecicimasa");
        $this->genelsorgu($db,"Truncate geciciurun");
        $veri=$this->genelsorgu($db,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
        $veri2=$this->genelsorgu($db,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
    
        break;
        case "ay":  
        $this->genelsorgu($db,"Truncate gecicimasa");
        $this->genelsorgu($db,"Truncate geciciurun");   
        $veri=$this->genelsorgu($db,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");        
        $veri2=$this->genelsorgu($db,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");       
        
        break;
        case "tum":
        $this->genelsorgu($db,"Truncate gecicimasa");
        $this->genelsorgu($db,"Truncate geciciurun");
        $veri=$this->genelsorgu($db,"select * from rapor");
        $veri2=$this->genelsorgu($db,"select * from rapor");
    
        break;
        
        case "tarih":
        $this->genelsorgu($db,"Truncate gecicimasa");
        $this->genelsorgu($db,"Truncate geciciurun");
        $tarih1=$_POST["tarih1"];
        $tarih2=$_POST["tarih2"];
        echo '<div class="alert alert-info text-center mx-auto mt-4">
        
        '.$tarih1.' - '.$tarih2.'
        
        </div>';
        $veri=$this->genelsorgu($db,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
        $veri2=$this->genelsorgu($db,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
        
        break;
        
        default;
        $this->genelsorgu($db,"Truncate gecicigarson"); 
        $veri=$this->genelsorgu($db,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");        
        $veri2=$this->genelsorgu($db,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
    
        endswitch; 
     // garson rapor kodları
    echo'
    

    <table class="table text-center table-light table-bordered mx-auto mt-4  col-md-8">';
                    if (@$tarih1!="" || @$tarih2!="") :
                    echo '
                    <thead> 
                    <tr>
                    <th colspan="8">
                    <a href="cikti.php?islem=garsoncikti&ilktarih='.$tarih1.'&sontarih='.$tarih2.'" 
                    onclick="ortasayfa(this.href,\'mywindow\',\'950\',\'800\',\'yes\');return false" class="btn btn-warning m-2"> Yazdır </a> ';
                    echo '
                    <a href="garsonexcel.php?ilktarih='.$tarih1.'&sontarih='.$tarih2.'" class="btn btn-info"> Excel aktar </a>
                    </th>
                    </tr>';
                    endif;
                        echo'                                    
                        <tr>
                            <th><a href="control.php?islem=garsonper&tar=bugun" class="btn btn-info">Bu Gün</a></th>
                            <th><a href="control.php?islem=garsonper&tar=dun" class="btn btn-info"> Dün </a> </th>
                            <th><a href="control.php?islem=garsonper&tar=hafta" class="btn btn-info">Bu Hafta </a> </th>
                            <th><a href="control.php?islem=garsonper&tar=ay" class="btn btn-info">Bu ay </a></th>
                            <th><a href="control.php?islem=garsonper&tar=tum" class="btn btn-info">Tüm Rapor </a></th>
                            <th colspan="2"><form action="control.php?islem=garsonper&tar=tarih" method="post" >
                            <input type="date" name="tarih1" value="tarih" class="form-control col-md-12">  
                            <input type="date" name="tarih2" value="tarih" class="form-control col-md-12"> 
                            </th>
                            <th>  <input name="buton" type="submit"  class="btn btn-success" value="Getir" ></form></th>
                        </tr>                   
                    </thead>

                        <tbody>
                            <tr>
                                <th colspan="8"> 
                                    <table class="table text-center table-light table-bordered col-md-12 table-striped">
                                        <thead>                 
                                            <tr>                    
                                            <th colspan="8" class="table-dark"> Garson Adet Ve Hasılat Raporu </th>                         
                                            </tr>                   
                                        </thead>
                                            <thead>                 
                                            <tr class="table-danger">                    
                                            <th colspan="2"> Garson adı  </th>    
                                            <th colspan="1"> Adet </th> 
                                            <th colspan="1"> Tutar </th>                            
                                            </tr>                   
                                            </thead> 
                                            <tbody>';

                                            $kilit=$this->genelsorgu($db,"select * from gecicigarson");

                                            if ($kilit->num_rows==0) :

                                                while($gel=$veri->fetch_assoc()):

                                                //garson adını çekiyoruz..
                                                    $garsonid=$gel["garsonid"];
                                                    $garsonveri=$this->genelsorgu($db,"select * from garson where id=$garsonid")->fetch_assoc();
                                                    $garsonad=$garsonveri["ad"];

                                                    $raporbak=$this->genelsorgu($db,"select * from gecicigarson where garsonid=$garsonid");

                                                    if ($raporbak->num_rows==0) :
                                                        //ekleme
                                                        $has=$gel["adet"] * $gel["urunfiyat"];
                                                        $adet=$gel["adet"];

                                                        $this->genelsorgu($db,"insert into gecicigarson (garsonid,garsonad,hasilat,adet) VALUES ($garsonid,'$garsonad',$has,$adet)");
                                                    else :
                                                        //güncelleme
                                                        $raporson=$raporbak->fetch_assoc();
                                                        $gelenadet=$raporson["adet"];
                                                        $gelenhas=$raporson["hasilat"];

                                                        $sonhasilat=$gelenhas + ($gel["adet"] * $gel["urunfiyat"]);
                                                        $sonadet=$gelenadet + $gel["adet"];
                                                        
                                                        $this->genelsorgu($db,"update gecicigarson set hasilat=$sonhasilat, adet=$sonadet where garsonid=$garsonid");

                                                    endif;
                                                endwhile;
                                            endif;
                                            $toplamadet =0;
                                            $toplamhasilat =0;

                                            $son=$this->genelsorgu($db,"select * from gecicigarson order by hasilat desc");

                                            while ($listele=$son->fetch_assoc()):

                                            echo '
                                                <tr>                    
                                                <td colspan="2"> '.$listele["garsonad"].'  </td>    
                                                <td colspan="1"> '.$listele["adet"].' </td> 
                                                <td colspan="1"> '.number_format($listele["hasilat"],2,'.','.'). ' ₺ </td>                            
                                                </tr>';
                                                 $toplamadet +=$listele["adet"];
                                                 $toplamhasilat += $listele["hasilat"];

                                            endwhile; 

                                             echo '
                                                <tr class="table-warning">                    
                                                <td colspan="2"> Toplam :  </td>    
                                                <td colspan="1"> '.$toplamadet.' </td> 
                                                <td colspan="1"> '.number_format($toplamhasilat,2,'.','.').' ₺ </td>                            
                                                </tr>';

                                  echo' 
                            </tbody> 
                            </table> ';
    }
// ayar yönetimi
    function yoneticiayar ($db)
    {
        $this->yetkikontrol($db);

        $so=$this->genelsorgu($db,"select * from yonetim");

       echo ' <div class="col-md-12 text-left mr-auto mt-3" style="background-color: #5555 ;"> <h3> || Ayarlar Yönetimi <a href="control.php?islem=yonekle" title=""> <input name="buton" type="submit" class="btn btn-success" value=" + Yeni Yönetici"></a></h3> </div>

       <table class="table text-center table-striped table-bordered mx-auto col-md-10 mt-4">
                    <thead>
                        <th scope="col"> No </th>  
                        <th scope="col">Kullanıcı Adı </th>                       
                        <th scope="col">Adı Soyadı</th>  
                        
                        <th scope="col">Durum </th>   
                                         
                        <th scope="col">Güncelle</th>
                        <th scope="col">Sil </th>
                    </thead><tbody>';                                         

     while ($sonuc=$so->fetch_assoc()):

        echo '<tr>
                 <td>'.$sonuc["id"].'</td>              
                 <td><input type="text" name="yoneticiad" value="'.$sonuc["kulad"].'" class="form-control m-1"></td> 
                 <td><input type="text" name="yoneticiad" value="'.$sonuc["adsoyad"].'" class="form-control m-1"></td>   
                  <td><input type="text" name="yoneticidurum" value="'.$sonuc["durum"].'" class="form-control m-1"></td>  
                   '; 

                  $sonuc["yetki"]==1 ? 
                  $durum="disabled" : 
                  $durum=""; 

                 echo '<td><a href="control.php?islem=yonguncelle&yonid='.$sonuc["id"].'" name="buton" class="btn btn-warning '. $durum.'">Güncelle</a></td>            


                  <td><a href="control.php?islem=yonsil&yonid='.$sonuc["id"].'" class="btn btn-danger '. $durum.'" data-confirm="Silmek istediğinizden Eminmisiniz ?">Sil</a></td>
            </tr>';

     endwhile;
     echo ' </tbody> </table>';
    }
// Ayar sil
    function yonsil ($db)
    {        
         $this->yetkikontrol($db);
        @$yonid=htmlspecialchars($_GET["yonid"]);

        if ($yonid!="" && is_numeric($yonid)) :

            @$this->genelsorgu($db,"DELETE FROM yonetim WHERE id=$yonid");
            @$this->uyari("success","Ürün Başarı İle Silindi","control.php?islem=yoneticiayar");
        else:
            @$this->uyari("danger","Ürün silinmedi hata oluştu !!","control.php?islem=yoneticiayar");
        endif;
    }    
// ayar Güncelle
    function yonguncelle ($db)

    {
         $this->yetkikontrol($db);
        @$buton=$_POST["buton"];

        echo '
       <div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> <h3> || Ayar Yönetimi - Güncelleme </h3> </div>
        <div class="col-md-5 text-center mx-auto mt-5 table-bordered">';

        if ($buton) :

             @$yonid=htmlspecialchars($_POST["yonid"]);
             @$kulad=htmlspecialchars($_POST["yonkulad"]);
             @$adsoyad=htmlspecialchars($_POST["yonad"]);
             @$sifre=htmlspecialchars($_POST["yonsifre"]);
             @$durum=htmlspecialchars($_POST["yondurum"]);
             

             $yonsifre=md5(sha1(md5($sifre)));

             if ($yonid=="" || $kulad=="" || $adsoyad=="" || $yonsifre=="" || $yetki=="") :
                @$this->uyari("danger","Bilgiler Boş Olamaz!!","control.php?islem=yoneticiayar");
            else :
                $this->genelsorgu($db,"update yonetim set  kulad='$kulad', adsoyad='$adsoyad', sifre='$yonsifre', durum=$durum, where id=$yonid");
                @$this->uyari("success","Ayar Güncellendi!!","control.php?islem=yoneticiayar");  
            endif;          
            
         else:

        $yonid=$_GET["yonid"];

        $aktar=$this->genelsorgu($db,"select * from yonetim where id=$yonid")->fetch_assoc();  

            echo '<form action="" method="post">                       
                       <div class="col-md-12 table-light"><input type="text" name="yonkulad" value="'.$aktar["kulad"].'" class="form-control m-2" placeholder="Kulanıcı Adı"></div>

                        <div class="col-md-12 table-light"><input type="text" name="yonad" value="'.$aktar["adsoyad"].'" class="form-control m-2" placeholder="Adı Soyadı"></div>  

                         <div class="col-md-12 table-light"><input type="text" name="yonsifre" value="" class="form-control m-2" placeholder="Yeni Şifre Girin"></div>                       

                        <div class="col-md-12 table-light"><input type="text" name="yondurum" value="'.$aktar["durum"].'" class="form-control m-2" placeholder="Durum = Aktif-1 Pasif- 0"></div>

                        
                      
                        <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success" value="Kaydet"></div>
                        <input type="hidden" name="yonid" value="'.$aktar["id"].'">
                    </form>';
         endif; 
         echo ' </div>';


    }
// yonetici Ekleme  
    function yonekle ($db)

    {
         $this->yetkikontrol($db);

        @$buton=$_POST["buton"];
         echo '
       <div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> <h3> || Ayar Yönetimi - Ekleme </h3> </div>
        <div class="col-md-5 text-center mx-auto mt-5 table-bordered">';

        if ($buton) :

             @$yonid=htmlspecialchars($_POST["yonid"]);
             @$kulad=htmlspecialchars($_POST["yonkulad"]);
             @$adsoyad=htmlspecialchars($_POST["yonad"]);
             @$yonsifre=htmlspecialchars($_POST["yonsifre"]);
             @$durum=htmlspecialchars($_POST["yondurum"]);
             @$yetki=htmlspecialchars($_POST["yonyetki"]);
             
              $yonsifre=md5(sha1(md5($yonsifre)));
             
             if ($kulad=="" && $adsoyad=="" && $durum=="" && $yetki=="" ) :

                @$this->uyari("danger","Bilgiler Boş Olamaz!!","control.php?islem=yoneticiayar");

            else :

                @$this->genelsorgu($db,"insert into yonetim (kulad,adsoyad,sifre,durum,yetki) values ('$kulad','$adsoyad','$yonsifre',$durum,$yetki)");

                @$this->uyari("success","Yönetici Eklendi !!","control.php?islem=yoneticiayar");  


            endif;          
            
         else:
            ?>

            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <?php 
                    echo '
                        
                        <div class="col-md-12 table-light"><input type="text" name="yonkulad" class="form-control m-2" placeholder="Kulanıcı Adı"></div>
                        <div class="col-md-12 table-light"><input type="text" name="yonad" class="form-control m-2" placeholder="Adı Soyadı"></div>
                         <div class="col-md-12 table-light"><input type="text" name="yonsifre" class="form-control m-2" placeholder="Şifre"></div>
                        <div class="col-md-12 table-light"><input type="text" name="yondurum" class="form-control m-2" placeholder="Durum = Aktif-1 Pasif- 0"></div>
                        <div class="col-md-12 table-light"><input type="text" name="yonyetki" class="form-control m-2" placeholder="Yetki"></div>
                    
                        <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success" value="Kaydet"></div>
                </form>';
         endif; 
         echo ' </div>';
    }     
// ayarlar link kontrol
    function linkkontrol($db)
    {
        $id=$this->coz($_COOKIE["id"]);  

        $sorgu="select * from yonetim where id=$id";
        $gelensonuc=$this->genelsorgu($db,$sorgu);
        $b=$gelensonuc->fetch_assoc();

        if ($b["yetki"]==1) :

            echo '<div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
                    <a href="control.php?islem=yoneticiayar" id="lk"> Ayarlar </a>
                </div> ';
        endif;
    }
// ayarlar yetki kontrol
     function yetkikontrol($db)
    {
        $id=$this->coz($_COOKIE["id"]);
        $sorgu="select * from yonetim where id=$id";
        $gelensonuc=$this->genelsorgu($db,$sorgu);
        $b=$gelensonuc->fetch_assoc();
        if ($b["yetki"]==0) :
         header("Location:control.php");
        endif;
    }
// Bakımcı elaman
  function bakimcielaman($db,$tabload)
    {
    $db->query('CHECK TABLE'.$tabload);     
     $db->query("ANALYZE TABLE".$tabload);    
     $db->query("REPAIR TABLE".$tabload);   
     $db->query("OPTIMIZE TABLE".$tabload);  

     }

    function bakim($db)
    {
    @$buton=$_POST["buton"];

        echo '
       <div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> <h3> || Veri Tabanı Bakım  </h3> </div>
        <div class="col-md-5 text-center mx-auto mt-5 table-bordered">';

        if ($buton) :
    $tablo=$this->genelsorgu($db,"SHOW TABLES");
     echo '<h4 class="mt-2 text-danger"> Bakım Sonucu</h4>';

     while ($tablolar=$tablo->fetch_array()) :
     self::bakimcielaman($db,$tablolar[0]);
     echo '<div class="alert alert-info mt-2 text-left pl-2"><b>* '.$tablolar[0].'</b> Tamamlandı
         
     </div>';

     endwhile;  
            
         else:

        ?>

            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post"> 
            <?php                      
                      echo ' <div class="col-md-12 border-bottom"><h4 class="mt-2">VERİ TABANI BAKIM</h4></div>

                        

                        
                      
                        <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success" value="BAKIMI BAŞLAT"></div>
                        
                    </form>';
         endif; 
         echo ' </div>';




     
     }
 }  
?>