<?php require_once 'baglan.php';
ob_start();

class yonetim {
// uyarı sorgusu
     private function uyari ($tip,$metin,$sayfa)
     {
        echo '<div class="alert alert-'.$tip.'">'.$metin.'</div>';
        header('refresh:1,url='.$sayfa.'');
    }
// Genel sorgu
     private function genelsorgu($dv,$sorgu)
     {
        $sorgum=$dv->prepare($sorgu);
        $sorgum->execute();
        return $sorguson=$sorgum->get_result(); 
     } 

     function ciktiicinsorgu($dv,$sorgu)
     {
        $sorgum=$dv->prepare($sorgu);
        $sorgum->execute();
        return $sorguson=$sorgum->get_result(); 
     } 
// kullanıcı cekme
      function kulad($db)
     {
        $sorgu="select * from yonetim";
        $gelensonuc=$this->genelsorgu($db,$sorgu);

       $b=$gelensonuc->fetch_assoc();
       return $b["kulad"];
    }
// Çıkış İşlemi
    function cikis ($deger)
    {
        $deger=$md5=md5(sha1(md5($deger)));
        setcookie("kul",$deger,time() -10);
        $this->uyari("warning","Çıkış Yapılıyor","index.php");
    }
// Toplam urun sayısı
    function topurunadet($vt)
    {
        $geldi=$this->genelsorgu($vt,"select SUM(adet) from anliksiparis")->fetch_assoc();
        echo $geldi['SUM(adet)'];
    }
// Toplam Masa sayısı
    function toplammasa($vt)
    {
        echo $this->genelsorgu($vt,"select * from masalar")->num_rows;
    }
       function toplamkategori($vt)
    {
        echo $this->genelsorgu($vt,"select * from kategori")->num_rows;
    }
         function toplamurun($vt)
    {
        echo $this->genelsorgu($vt,"select * from urunler")->num_rows;
    }
// Toplam doluluk
    function doluluk($dv)
     {           
     
       $veriler=$this->genelsorgu($dv,"select * from doluluk")->fetch_assoc();
       $toplam = $veriler["bos"] + $veriler["dolu"];
       $oran=    ($veriler["dolu"] / $toplam) * 100 ;
       echo $oran=substr($oran, 0,5). " %";    
    }
// masa yönetimi
    function masayonetimi ($vt)
    {
        $so=$this->genelsorgu($vt,"select * from masalar");

       echo ' <div class="col-md-12 text-left mr-auto mt-2" style="background-color: #5555 ;"> <h3> || Masa Yönetimi <a href="control.php?islem=masaekle" title=""> <input name="buton" type="submit" class="btn btn-success" value=" + Yeni Masa"></a></h3> </div>
       <table class="table text-center table-striped table-bordered mx-auto col-md-9 mt-4">
                    <thead>
                        <th scope="col"> Masa No </th>
                        <th scope="col"> Masa Adı </th>
                        <th scope="col"> Güncelle</th>
                        <th scope="col"> Sil </th>
                    </thead><tbody>';             

     while ($sonuc=$so->fetch_assoc()):

        echo '<tr>
                 <td>'.$sonuc["id"].'</td>
                 <td><input type="text" name="masaad" value="'.$sonuc["ad"].'" class="form-control m-1"></td>
                 <td><a href="control.php?islem=masaguncelle&masaid='.$sonuc["id"].'" class="btn btn-warning">Güncelle</a></td>
                 <td><a href="control.php?islem=masasil&masaid='.$sonuc["id"].'" class="btn btn-danger">Sil</a></td>
            </tr>';

     endwhile;
     echo ' </tbody> </table>';
    }
// masa sil
    function masasil ($vt)
    {        
        @$masaid=htmlspecialchars($_GET["masaid"]);
        if ($masaid!="" && is_numeric($masaid)) :

            @$this->genelsorgu($vt,"DELETE FROM masalar WHERE id=$masaid");
            @$this->uyari("success","Masa Başarı İle Silindi","control.php?islem=masayonetimi");
        else:
            @$this->uyari("danger","Masa silinmedi hata oluştu !!","control.php?islem=masayonetimi");
        endif;
    }
// masa Güncelle
    function masaguncelle ($vt)

    {
        @$buton=$_POST["buton"];

        echo '
       <div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> <h3> || Masa Yönetimi - Güncelleme </h3> </div>


        <div class="col-md-3 text-center mx-auto mt-5 table-bordered">';

        if ($buton) :

             @$masaad=htmlspecialchars($_POST["masaad"]);
             @$masaid=htmlspecialchars($_POST["masaid"]);

             if ($masaad=="" && $masaid=="") :
                @$this->uyari("danger","Bilgiler Boş Olamaz!!","control.php?islem=masayonetimi");

            else :

                $this->genelsorgu($vt,"update masalar set ad='$masaad' where id=$masaid");
                @$this->uyari("success","Masa Güncellendi!!","control.php?islem=masayonetimi");  
            endif;          
            
         else:

        $masaid=$_GET["masaid"];

        $aktar=$this->genelsorgu($vt,"select * from masalar where id=$masaid")->fetch_assoc();  

            echo '<form action="" method="post">
                        <div class="col-md-12 table-light"> <h4> Masa Güncelle</h4></div>
                        <div class="col-md-12 table-light"><input type="text" name="masaad" value="'.$aktar["ad"].'" class="form-control m-2"></div>
                        <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success" value="Kaydet"></div>
                        <input type="hidden" name="masaid" value="'.$aktar["id"].'">
                    </form>';
         endif; 
         echo ' </div>';


    }
// masa Ekleme
    function masaekle ($vt)
    {
        @$buton=$_POST["buton"];
        echo '<div class="col-md-3 text-center mx-auto mt-5 table-bordered">';
        if ($buton) :
             @$masaad=htmlspecialchars($_POST["masaad"]);
             if ($masaad=="") :
                @$this->uyari("danger","Bilgiler Boş Olamaz!!","control.php?islem=masayonetimi");
            else :
                @$this->genelsorgu($vt,"insert into masalar (ad) values ('$masaad')");
                @$this->uyari("success","Masa Eklendi !!","control.php?islem=masayonetimi");  
            endif;            
         else:
            ?>

            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <?php 
                    echo '
                        <div class="col-md-12 table-light"> <h4> Masa Ekle</h4></div>
                        <div class="col-md-12 table-light"><input type="text" name="masaad" class="form-control m-2"></div>
                        <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success" value="Kaydet"></div>
                </form>';
         endif; 
         echo ' </div>';
    }
// urun yönetimi
    function urunyonetimi ($vt,$tercih)
    {
      if ($tercih==1):
// arama kodları
        $aramabuton=$_POST["aramabuton"];
        $urun=$_POST["urun"];
             if ($aramabuton):
            $so=$this->genelsorgu($vt,"select * from urunler where ad LIKE '%$urun%'");
             endif;
        elseif ($tercih==2) :
// kategori arama kodları
            $arama=$_POST["arama"];
             $katid=$_POST["katid"];
             if ($arama):
            $so=$this->genelsorgu($vt,"select * from urunler where katid=$katid");
             endif;
        elseif ($tercih==0) :
        $so=$this->genelsorgu($vt,"select * from urunler");
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
                      <form action="control.php?islem=katagoriyegore" method="post">
                      <select name="katid" class="form-control">';

                      $d=$this->genelsorgu($vt,"select * from kategori");
                      while($katson=$d->fetch_assoc()) :
                        echo '
                        <option value="'.$katson["id"].'">'.$katson["ad"].'</option>';
                      endwhile;
                      echo'</select></th>
                      <th> <input type="submit" name="arama" value="Getir" class="btn btn-success">  
                      </form></th> 
                   </tr>                   
                </thead>              
               </table>';
       echo '<table class="table text-center table-striped table-bordered mx-auto col-md-10 mt-4">
                    <thead>
                        <th scope="col"> Ürün No </th>
                        <th scope="col"> Ürün Adı </th>
                        <th scope="col"> kategori Adı </th>
                        <th scope="col"> Fiyatı </th>
                        <th scope="col"> Güncelle</th>
                        <th scope="col"> Sil </th>
                    </thead><tbody>';
     while ($sonuc=$so->fetch_assoc()):
        echo '<tr>
                 <td>'.$sonuc["id"].'</td>
                 <td><input type="text" name="urunad" value="'.$sonuc["ad"].'" class="form-control m-1"></td>
                 <td>';
                        $katid=$sonuc["katid"];
                        $katcek=$this->genelsorgu($vt,"select * from kategori");
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
                 <td><a href="control.php?islem=urunguncelle&urunid='.$sonuc["id"].'" class="btn btn-warning">Güncelle</a></td>
                 <td><a href="control.php?islem=urunsil&urunid='.$sonuc["id"].'" class="btn btn-danger">Sil</a></td>
            </tr>';
     endwhile;
     echo ' </tbody> </table>';
      }
// urun sil
    function urunsil ($vt)
    {        
        @$urunid=htmlspecialchars($_GET["urunid"]);

        if ($urunid!="" && is_numeric($urunid)) :
              
             $satir=$this->genelsorgu($vt,"select * FROM anliksiparis WHERE urunid=$urunid");

              if ($satir->num_rows!=0):
                echo '<div class="alert-danger mt-4">
                Bu ürün aşağıdaki Masalarda Mevcut olduğu için Silinmedi !! <br>';
                 header('refresh:3,url=control.php?islem=urunyonetimi');

                
                while($masabilgi=$satir->fetch_assoc()):
                $masaid=$masabilgi["masaid"];
                $masasonuc=$this->genelsorgu($vt,"select * from masalar where id=$masaid")->fetch_assoc();



                echo "-".$masasonuc["ad"]."<br>";

                endwhile;                   
               
                echo ' </div>';                  

              else:
                 @$this->genelsorgu($vt,"DELETE FROM urunler WHERE id=$urunid");
                @$this->uyari("success","Ürün Başarı İle Silindi","control.php?islem=urunyonetimi");

              endif;           
        else:
            @$this->uyari("danger","Ürün silinmedi hata oluştu !!","control.php?islem=urunyonetimi");
        endif;
    }    
// urun Güncelle
    function urunguncelle ($vt)

    {
        @$buton=$_POST["buton"];
        echo '
       <div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> <h3> || urun Yönetimi - Güncelleme </h3> </div>
        <div class="col-md-5 text-center mx-auto mt-5 table-bordered">';
        if ($buton) :
             @$urunad=htmlspecialchars($_POST["urunad"]);
             @$katid=htmlspecialchars($_POST["katid"]);
             @$fiyat=htmlspecialchars($_POST["fiyat"]);
             @$urunid=htmlspecialchars($_POST["urunid"]);

             if ($urunad=="" && $urunid=="") :
                @$this->uyari("danger","Bilgiler Boş Olamaz!!","control.php?islem=urunyonetimi");

            else :
                $this->genelsorgu($vt,"update urunler set ad='$urunad',fiyat=$fiyat,katid=$katid where id=$urunid");
                @$this->uyari("success","urun Güncellendi!!","control.php?islem=urunyonetimi");  
            endif;
         else:
        $urunid=$_GET["urunid"];
        $aktar=$this->genelsorgu($vt,"select * from urunler where id=$urunid")->fetch_assoc();  
            echo '<form action="" method="post">                       
                        <div class="col-md-12 table-light">Ürün adı :    <input type="text" name="urunad" value="'.$aktar["ad"].'" class="form-control m-2"></div>                     
                        <div class="col-md-12 table-light">Fiyatı :      <input type="text" name="fiyat" value="'.$aktar["fiyat"].'" class="form-control m-2"></div>
                        <div class="col-md-12 table-light" class="form-control">';
                        $katid=$aktar["katid"];
                        $katcek=$this->genelsorgu($vt,"select * from kategori");
                        echo 'Kategori : <select name="katid" class="selected m-2 form-control">';
                        while($katson=$katcek->fetch_assoc()):
                            if ($katson["id"]==$katid):
                                echo'<option value="'.$katson["id"].'" selected="selected" class="form-control>'.$katson["ad"].' </option>';
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
         echo ' </div>';    }
// urun Ekleme
    function urunekle ($vt)

    {
        @$buton=$_POST["buton"];
         echo '
       <div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> <h3> || urun Yönetimi - Ekleme </h3> </div>
        <div class="col-md-5 text-center mx-auto mt-5 table-bordered">';
        if ($buton) :
             @$urunad=htmlspecialchars($_POST["urunad"]);
             @$katid=htmlspecialchars($_POST["katid"]);
             @$fiyat=htmlspecialchars($_POST["fiyat"]);            

             if ($urunad=="" && $katid=="" && $fiyat=="") :
                @$this->uyari("danger","Bilgiler Boş Olamaz!!","control.php?islem=urunyonetimi");
            else :
                @$this->genelsorgu($vt,"insert into urunler (ad,katid,fiyat) values ('$urunad',$katid,$fiyat)");
                @$this->uyari("success","urun Eklendi !!","control.php?islem=urunyonetimi");  
            endif;
         else:
                        echo '<form action="" method="post">                        
                        <div class="col-md-12 table-light">ürün adı : <input type="text" name="urunad" class="form-control m-2"></div>
                        
                        <div class="col-md-12 table-light">Fiyatı :<input type="text" name="fiyat" class="form-control m-2"></div>';

                        $katcek=$this->genelsorgu($vt,"select * from kategori");
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
    function kategoriyonetimi ($vt)
    {

        $so=$this->genelsorgu($vt,"select * from kategori");

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
                 <td><a href="control.php?islem=kategoriguncelle&kategoriid='.$sonuc["id"].'" name="buton" class="btn btn-warning">Güncelle</a></td>
                 <td><a href="control.php?islem=kategorisil&kategoriid='.$sonuc["id"].'" class="btn btn-danger">Sil</a></td>
            </tr>';

     endwhile;
     echo ' </tbody> </table>';
    }
// kategori sil
    function kategorisil ($vt)
    {        
        @$kategoriid=htmlspecialchars($_GET["kategoriid"]);
         @$kategoriad=htmlspecialchars($_GET["kategoriad"]);
        if ($kategoriid!="" && is_numeric($kategoriid)) :

            @$this->genelsorgu($vt,"DELETE FROM kategori WHERE id=$kategoriid");
            @$this->uyari("success","Ürün Başarı İle Silindi","control.php?islem=kategoriyonetimi");
        else:
            @$this->uyari("danger","Ürün silinmedi hata oluştu !!","control.php?islem=kategoriyonetimi");
        endif;
    }    
// kategori Güncelle
    function kategoriguncelle ($vt)

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
                $this->genelsorgu($vt,"update kategori set ad='$kategoriad' where id=$kategoriid");
                @$this->uyari("success","kategori Güncellendi!!","control.php?islem=kategoriyonetimi");  
            endif;          
            
         else:

        $kategoriid=$_GET["kategoriid"];

        $aktar=$this->genelsorgu($vt,"select * from kategori where id=$kategoriid")->fetch_assoc();  

            echo '<form action="" method="post">                       
                       
                        <div class="col-md-12 table-light">Kategori adı :<input type="text" name="kategoriad" value="'.$aktar["ad"].'" class="form-control m-2"></div>
                      
                        <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success" value="Kaydet"></div>
                        <input type="hidden" name="kategoriid" value="'.$aktar["id"].'">
                    </form>';
         endif; 
         echo ' </div>';


    }
// kategori Ekleme  
    function kategoriekle ($vt)

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

                @$this->genelsorgu($vt,"insert into kategori (ad) values ('$kategoriad')");

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
    function garsonyonetimi ($vt)
    {

        $so=$this->genelsorgu($vt,"select * from garson");

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
                 <td><input type="text" name="garsonsifre" value="'.$sonuc["sifre"].'" class="form-control m-1"></td>                               
                 <td><a href="control.php?islem=garsonguncelle&garsonid='.$sonuc["id"].'" name="buton" class="btn btn-warning">Güncelle</a></td>
                 <td><a href="control.php?islem=garsonsil&garsonid='.$sonuc["id"].'" class="btn btn-danger">Sil</a></td>
            </tr>';

     endwhile;
     echo ' </tbody> </table>';
    }
// garson sil
    function garsonsil ($vt)
    {        
        @$garsonid=htmlspecialchars($_GET["garsonid"]);
         @$garsonad=htmlspecialchars($_GET["garsonad"]);
        if ($garsonid!="" && is_numeric($garsonid)) :

            @$this->genelsorgu($vt,"DELETE FROM garson WHERE id=$garsonid");
            @$this->uyari("success","garson Başarı İle Silindi","control.php?islem=garsonyonetimi");
        else:
            @$this->uyari("danger","garson silinmedi hata oluştu !!","control.php?islem=garsonyonetimi");
        endif;
    }    
// garson Güncelle
    function garsonguncelle ($vt)

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
                $this->genelsorgu($vt,"update garson set ad='$garsonad',sifre='$garsonsifre' where id=$garsonid");
                @$this->uyari("success","Garson Güncellendi!!","control.php?islem=garsonyonetimi");  
            endif;          
            
         else:

        $garsonid=$_GET["garsonid"];

        $aktar=$this->genelsorgu($vt,"select * from garson where id=$garsonid")->fetch_assoc();  

            echo '<form action="" method="post">                       
                       
                        <div class="col-md-12 table-light">garson adı :<input type="text" name="garsonad" value="'.$aktar["ad"].'" class="form-control m-2"></div>
                        <div class="col-md-12 table-light">garson adı :<input type="text" name="garsonsifre" value="'.$aktar["sifre"].'" class="form-control m-2"></div>
                      
                        <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success" value="Kaydet"></div>
                        <input type="hidden" name="garsonid" value="'.$aktar["id"].'">
                    </form>';
         endif; 
         echo ' </div>';


    }
// garson Ekleme  
    function garsonekle ($vt)

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

                @$this->genelsorgu($vt,"insert into garson (ad,sifre) values ('$garsonad','$garsonsifre')");

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
    function sifredegis ($vt)

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

                if ($this->genelsorgu($vt,"select * from yonetim where sifre='$eskisfson'")->num_rows==0) :
                    @$this->uyari("danger","Eski Şifre Hatalı !!","control.php?islem=sifredegis");

                elseif ($yen1!=$yen2) :
                     @$this->uyari("danger","Şifreler Uyumsuz Lütfen şifreleri Aynı Giriniz !!","control.php?islem=sifredegis");
                else :
                    $yenisifre=md5(sha1(md5($yen1)));
                    $this->genelsorgu($vt,"update yonetim set sifre='$yenisifre'");
                    @$this->uyari("success","Tebrikler ! Şifreniz Değişti ;)","control.php"); 

                  endif;                
            endif;                  
            
         else:
            ?>

            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <?php 
                    echo '                        
                        <div class="col-md-12 table-light">Eski şifre : <input type="text" name="eskisif" class="form-control m-2"></div>
                         <div class="col-md-12 table-light">Yeni Şİfre : <input type="text" name="yen1" class="form-control m-2"></div>
                          <div class="col-md-12 table-light">Yeni Şİfre Tekrar : <input type="text" name="yen2" class="form-control m-2"></div>
                    
                        <div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success" value="Değiştir"></div>
                </form>';
         endif; 
         echo ' </div>';
    }
// rapor sorgulama kodları
  function rapor ($vt)
  {
    echo '<div class="col-md-12 text-left mr-auto mt-4" style="background-color: #5555 ;"> <h3> || Rapoarlar - Ürün rapor </h3> </div>';

    $tercih=$_GET["tar"];

    switch ($tercih):

        case "bugun":
        $this->genelsorgu($vt,"Truncate geciciurun");
        $this->genelsorgu($vt,"Truncate gecicimasa");
        $veri=$this->genelsorgu($vt,"select * from rapor where tarih=CURDATE()");
        $veri2=$this->genelsorgu($vt,"select * from rapor where tarih=CURDATE()");
        break;
        case "dun":
        $this->genelsorgu($vt,"Truncate geciciurun");
        $this->genelsorgu($vt,"Truncate gecicimasa");
        $veri=$this->genelsorgu($vt,"select * from rapor where tarih = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
        $veri2=$this->genelsorgu($vt,"select * from rapor where tarih = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
        break;
        case "hafta":
        $this->genelsorgu($vt,"Truncate geciciurun");
        $this->genelsorgu($vt,"Truncate gecicimasa");
        $veri=$this->genelsorgu($vt,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
        $veri2=$this->genelsorgu($vt,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
        break;
        case "ay":
        $this->genelsorgu($vt,"Truncate geciciurun");
        $this->genelsorgu($vt,"Truncate gecicimasa");
        $veri=$this->genelsorgu($vt,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
        $veri2=$this->genelsorgu($vt,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
        break;
        case "tum":
        $this->genelsorgu($vt,"Truncate geciciurun");
        $this->genelsorgu($vt,"Truncate gecicimasa");
        $veri=$this->genelsorgu($vt,"select * from rapor");
        $veri2=$this->genelsorgu($vt,"select * from rapor");  
        break;

        case "tarih":
        $this->genelsorgu($vt,"Truncate geciciurun");
        $this->genelsorgu($vt,"Truncate gecicimasa");
        $tarih1=$_POST["tarih1"];
        $tarih2=$_POST["tarih2"];
        echo '
        <div class="alert alert-info text-center mx-auto mt-4"> Seçilen Tarih Aralığı :'.$tarih1.' - '.$tarih2.'</div>';
        $veri=$this->genelsorgu($vt,"select * from rapor where DATE(Tarih) BETWEEN '$tarih1' AND ' $tarih2'");
        $veri2=$this->genelsorgu($vt,"select * from rapor where DATE(Tarih) BETWEEN '$tarih1' AND ' $tarih2'");
        break;



        default;
        $this->genelsorgu($vt,"Truncate geciciurun");
        $this->genelsorgu($vt,"Truncate gecicimasa");
        $veri=$this->genelsorgu($vt,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
        $veri2=$this->genelsorgu($vt,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");

    endswitch;  
// masa rapor kodları
    echo'
    

    <table class="table text-center table-light table-bordered mx-auto mt-4  col-md-8">
                    <thead>                 
                        <tr>
                            <th><a href="control.php?islem=raporyon&tar=bugun">Bu gün </a></th>
                            <th><a href="control.php?islem=raporyon&tar=dun"> Dün </a> </th>
                            <th><a href="control.php?islem=raporyon&tar=hafta">Bu Hafta </a> </th>
                            <th><a href="control.php?islem=raporyon&tar=ay">Bu ay </a></th>
                            <th><a href="control.php?islem=raporyon&tar=tum">tüm zamanlar </a></th>
                            <th colspan="2"><form action="control.php?islem=raporyon&tar=tarih" method="post" >
                            <input type="date" name="tarih1" value="tarih" class="form-control col-md-12">  
                            <input type="date" name="tarih2" value="tarih" class="form-control col-md-12"> 
                            </th>
                            <th>';

                            if (@$tarih1!="" || @$tarih2!="") :

                                echo '<p><a href="cikti.php?islem=ciktial&tar1='.$tarih1.'&tar2='.$tarih2.'" 
                            onclick="ortasayfa(this.href,\'mywindow\',\'950\',\'800\',\'yes\');return false"> Yazdır </a></p>'; 

                            endif;
                          echo'  <input name="buton" type="submit"  class="btn btn-success" value="Getir" ></form></th>
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

                                            $kilit=$this->genelsorgu($vt,"select * from gecicimasa");

                                            if ($kilit->num_rows==0) :

                                                while($gel=$veri->fetch_assoc()):
                                                    //masa adını çekiyoruz..
                                                    $id=$gel["masaid"];
                                                    $masaveri=$this->genelsorgu($vt,"select * from masalar where id=$id")->fetch_assoc();
                                                    $masaad=$masaveri["ad"];

                                                    $raporbak=$this->genelsorgu($vt,"select * from gecicimasa where masaid=$id");

                                                    if ($raporbak->num_rows==0) :
                                                        //ekleme
                                                        $has=$gel["adet"] * $gel["urunfiyat"];
                                                        $adet=$gel["adet"];

                                                        $this->genelsorgu($vt,"insert into gecicimasa (masaid,masaad,hasilat,adet) VALUES ($id,'$masaad',$has,$adet)");
                                                    else :
                                                        //güncelleme
                                                        $raporson=$raporbak->fetch_assoc();
                                                        $gelenadet=$raporson["adet"];
                                                        $gelenhas=$raporson["hasilat"];

                                                        $sonhasilat=$gelenhas + ($gel["adet"] * $gel["urunfiyat"]);
                                                        $sonadet=$gelenadet + $gel["adet"];
                                                        
                                                        $this->genelsorgu($vt,"update gecicimasa set hasilat=$sonhasilat, adet=$sonadet where masaid=$id");

                                                    endif;
                                                endwhile;
                                            endif;
                                            $toplamadet =0;
                                            $toplamhasilat =0;

                                            $son=$this->genelsorgu($vt,"select * from gecicimasa order by hasilat desc");

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

                                            $kilit2=$this->genelsorgu($vt,"select * from geciciurun");

                                            if ($kilit2->num_rows==0) :

                                                while($gel2=$veri2->fetch_assoc()):
                                                    //ürün adını çekiyoruz..
                                                    $id=$gel2["urunid"];
                                                     $urunad=$gel2["urunad"];                                                   

                                                    $raporbak2=$this->genelsorgu($vt,"select * from geciciurun where urunid=$id");

                                                    if ($raporbak2->num_rows==0) :
                                                        //ekleme
                                                        $has=$gel2["adet"] * $gel2["urunfiyat"];
                                                        $adet=$gel2["adet"];

                                                        $this->genelsorgu($vt,"insert into geciciurun (urunid,urunad,hasilat,adet) VALUES ($id,'$urunad',$has,$adet)");
                                                    else :
                                                        //güncelleme
                                                        $raporson2=$raporbak2->fetch_assoc();
                                                        $gelenadet2=$raporson2["adet"];
                                                        $gelenhas=$raporson2["hasilat"];

                                                        $sonhasilat=$gelenhas + ($gel2["adet"] * $gel2["urunfiyat"]);
                                                        $sonadet=$gelenadet2 + $gel2["adet"];                                                        
                                                        $this->genelsorgu($vt,"update geciciurun set hasilat=$sonhasilat, adet=$sonadet where urunid=$id");

                                                    endif;
                                                endwhile;
                                            endif;
                                            $toplamadet =0;
                                            $toplamhasilat =0;

                                            $son=$this->genelsorgu($vt,"select * from geciciurun order by hasilat desc");

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
    }
// Giriş Kontrol
 public function giriskontrol($ver,$kul,$sif) {
    $sifremd5=md5(sha1(md5($sif)));
    
    $sorgu="SELECT * FROM yonetim WHERE kulad='$kul' and sifre='$sifremd5'";
    $sor=$ver->prepare($sorgu);
    $sor->execute();
    $sonbilgi=$sor->get_result();
    
    if ($sonbilgi->num_rows==0) :  
    $this->uyari("danger","Bilgiler Hatalı Lüftfen Doğru Bilgi Giriniz !!","index.php");
    
    else:
    $this->uyari("success","Bilgiler  Doğru Giriş Yapılıyor !!","control.php");
    //cookie oluşturulacak
    
    $sonhal=md5(sha1(md5($kul)));
    
    setcookie("kul",$sonhal, time() + 60*60*24);
    
    endif;
    
    }
// cokkie Kontrol
      public function cookcont ($d,$durum=false)
     {
      if (isset($_COOKIE["kul"])):

        $deger =$_COOKIE["kul"];
        $sorgu="SELECT * FROM yonetim";
        $sor=$d->prepare($sorgu);
        $sor->execute();
        $sonbilgi=$sor->get_result();
        $veri=$sonbilgi->fetch_assoc();
        $kullmd5=md5(sha1(md5($veri["kulad"])));

        if ($kullmd5!=$_COOKIE["kul"]) :
        setcookie("kul",$deger, time() -10 );          
        header("location:index.php");

        else:

        if ($durum==true) : header("location:control.php"); endif;          
        
     endif;
        else:

        if ($durum==false) : header("location:index.php"); endif;         
            
       endif;    
    }
    }  
?>