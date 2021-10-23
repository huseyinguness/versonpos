<?php 
include("../fonksiyon/tema3fonk.php"); 
$tema3 = new vipTema; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../dosya/jqu.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<title>Restaurant Mutfak Bölümü</title>
<script>
$(document).ready(function() 
  {		 
 setInterval(function() 
   { 	
	window.location.reload();
	},5000); // süreli sayfa yineleme
		
			$('#mutfaklink a').click(function() 
			{			
			var urunid =$(this).attr('sectionId');
			var masaid =$(this).attr('sectionId2');
						
		$.post("../islemler.php?islem=mutfaksip",{"urunid":urunid,"masaid":masaid},function(post_veri){		
			window.location.reload();			
		});			
    });	
	});
</script>
</head>
<body>
<div class="container-fluid">
	<div class="row bg-info" style="min-height: 40px;">
			<div class="col-md-12 text-center"> <h3>VERSONPOS MUTFAK YÖNETİMİ</h3> </div>
		</div>
<div class="row">
<?php   $tema3->mutfakbilgi($db); ?>
</div>  
</div>
</body>
</html>