<?php session_start(); 

include("fonksiyon/tema3fonk.php"); 
$tema3 = new vipTema;
$tema3->cookcon($db,false);
$veri=$tema3->genelsorgu2($db,"select * from garson where durum=1",1)->num_rows;
if ($veri==0) :
header("Location:index.php");
endif;
@$masaid=$_GET["masaid"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="pad/css/easy-numpad.css">
<script src="dosya/jqu.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="stylesheet" href="dosya/tema3.css" >
<script>
$(document).ready(function() {	
	var id="<?php echo $masaid; ?>";	
$("#veri").load("islemler.php?islem=goster&id="+id);

	

$('input[name="adet"]').change(function()
   {
        $.ajax(
        {      
          type : "POST",
          url :'islemler.php?islem=ekle',
          data :$('#formum').serialize(),     
          success: function(donen_veri)     {
          $("#veri").load("islemler.php?islem=goster&id="+id);
          $('#formum').trigger("reset");  
          $("#cevap").html(donen_veri).fadeOut(1400); 
           window.location.reload();
          },      
        })  

    })
$('#urunler a').click(function(){		
	var sectionId=$(this).attr('sectionId');
	$("#sonuc").load("islemler.php?islem=urun&katid=" + sectionId);	
	})
  });
</script>
<style>
 html,body 
 {
  height: 100%;
  }
</style>
<title>Restaurant Sipari?? Sistemi</title>
</head>
<body>
<div class="container-fluid h-100">
<?php 
  if ($masaid!="") :
  $son=$tema3->masagetir($db,$masaid);
  $dizi=$son->fetch_assoc();
  ?>
  <div class="row   justify-content-center h-100 ">                 
<!-- orta b??l??m -->
                  <div class="col-md-8" >                
                  		<div class="row pt-2">
                           	 <form id="formum">
                              <!-- Kategori b??l??m -->
                              <div class="col-md-12" id="urunler">
                             <?php $tema3->vipTemaUrunGrup($db); ?>
                             <!-- Kategori b??l??m -->

                              </div>
                              <!-- ??r??nler b??l??m -->
                              <div class="col-md-12  text-center" style="min-height:300px;; background-color:#dde1e1;" id="sonuc">
                              <i class="fas fa-arrow-up" style="font-size:180px; color:#F8F8F8; margin-top:10%;"></i>
                              </div>
                              <!-- ??r??nler b??l??m -->
  <!-- orta b??l??m -->
                  <div class="col-md-12" style="min-height:170px;"> 
                     <div class="row">

                      <!-- iskonto b??l??m -->
                        
                        <!-- iskonto b??l??m -->

                        <!-- adet b??l??m -->
                         <div class="col-md-12 border-right text-center">
                         <h4>??R??N ADET</h4><hr />
                         <input type="hidden" name="masaid" value="<?php echo $dizi["id"]; ?>" />  
                         <?php
                          for ($i=1; $i<=10; $i++):   
                          echo '<label class="btn m-2 adetbuton" >
                          <input name="adet" type="radio" value="'.$i.'"  /> '.$i.'</label>'; endfor;
                          ?>
                          </div>
                          <!-- adet b??l??m -->
                         </div>
                         </div>
                        </div>
                      </form>
                    </div>

<!-- orta buton b??l??m -->
  
<!-- orta buton b??l??m -->

<!-- MASA ADI EKLENEN b??l??m -->
   <div class="col-md-4 sagiskelet" >                
    <div class="row "> 
  
      <div class="col-md-12 bg-dark border border-light " >                            
         <div class="row">
         <div class="col-md-4 masadetaysagcizgi " id="a1">
         <a href="masalar.php" class="btn anasayfabuton" >
         <i class="fas fa-arrow-left" style="font-size:38px;"></i></a>
         </div>
         <div class="col-md-8 text-center mx-auto p-3"  id="masaad"><?php echo $dizi["ad"]; ?>   
         </div>              
         </div>         
    </div> 
<!-- ??R??N EKLENEN b??l??m -->
      <div class="col-md-12" > 
         <div class="row">                           
          <div class="col-md-12 mx-auto " id="veri" ></div>
          <div class="col-md-12" id="cevap"></div>      
         </div>
     </div>

    </div>                
  </div>
</div>
  <?php 
  else:
	echo "hata var";
	header("refresh:1,url=masalar.php");
 endif; ?>
</div>
<script src="pad/js/easy-numpad.js"></script>
</body>
</html>