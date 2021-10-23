$(document).ready(function() {	
$('#degistirform').hide();
$('#birlestirform').hide();
$('#iskontoform').hide();
$('#parcaform').hide();
$('#odemesecenek').hide();
$('#TercihNakit').hide();
$('#OdemeFormu').hide();

$("#kredi,#ykarti,#nakit").each(function()	{
  $(this).css("cursor","pointer");
   });


$('#btnn').click(function() 
{
  $('#odemesecenek').show();
  $('#OdemeFormu').show();

$('#nakit').click(function() 
   {
  	$("#nakit").css("background-color","#19d108");
		$("#kredi").css("background-color","#fff");
		$("#ykarti").css("background-color","#fff");
  	$('#TercihNakit').show();  
  	$('input[name="odemesecenek"]').val("Nakit");
   });

$('#kredi').click(function() 
   {
   	$("#kredi").css("background-color","#19d108");
		$("#ykarti").css("background-color","#fff");
  	$("#nakit").css("background-color","#fff");

   	$('#TercihNakit').hide(); 
  	$('input[name="odemesecenek"]').val("Kredi Kartı");
   });

$('#ykarti').click(function() 
    {
    	$("#ykarti").css("background-color","#19d108");
    	$("#kredi").css("background-color","#fff");		
  	  $("#nakit").css("background-color","#fff");
  	
    	$('#TercihNakit').hide();  	
  	  $('input[name="odemesecenek"]').val("Y.Kartı");
   });

	});

$('#odemeal').click(function() {
  $.ajax({			
					type : "POST",
					url :'islemler.php?islem=hesap',
					data :$('#hesapform').serialize(),			
					success: function(donen_veri){
					$('#hesapform').trigger("reset");
						window.location.reload();
					},			
				});
			});
$('#yakala a').click(function() {
			var sectionId =$(this).attr('sectionId');
			var sectionId2 =$(this).attr('sectionId2');				
		$.post("islemler.php?islem=sil",{"urunid":sectionId,"masaid":sectionId2},function(post_veri){		
			window.location.reload();
			
		});			
		});	
$('#islemlinkleri a').click(function() { 
  	var sectionId =$(this).attr('sectionId');
		$.each(["degistir","birlestir","iskonto","parca"], function( index , value){
		$('#'+value+'form').hide();
  	});

	$('#'+sectionId+'form').show();	
	});	
$('#kapatma a').click(function() { 
  	var sectionId =$(this).attr('sectionId');

		$('#'+sectionId+'form').hide();
  	
	});			
$('#degistirbtn').click(function() {		
		$.ajax({			
			type : "POST",
			url :'islemler.php?islem=masaislem',
			data :$('#degistirformveri').serialize(),			
			success: function(donen_veri){
			$('#degistirformveri').trigger("reset");
				window.location.reload();
			},			
		})		
	});	
$('#birlestirbtn').click(function() {
		$.ajax({			
			type : "POST",
			url :'islemler.php?islem=masaislem',
			data :$('#birlestirformveri').serialize(),			
			success: function(donen_veri){
			$('#birlestirformveri').trigger("reset");
				window.location.reload();
			},			
		})		
	});	
$('#bildirimlink a').click(function() {	
					
			var sectionId =$(this).attr('sectionId');		
			
				
		$.post("islemler.php?islem=hazirurunsil",{"id":sectionId},function(){	
			window.location.reload();	
			$('#uy'+sectionId).hide();
			
			$("#bekleyenler").load("islemler.php?islem=garsonbilgigetir");
			
		 });			
		});		
$('#rezervelistem a').click(function() {
			var sectionId =$(this).attr('sectionId');				
		$.post("islemler.php?islem=rezervekaldir",{"id":sectionId},function(){	
			window.location.reload();	
			$('#mas'+sectionId).hide();			
			$("#rezervelistesi").load("islemler.php?islem=rezervelistesi");			
		 });			
		});	
$('#iskontobtn').click(function() {
				
		$.ajax({			
			type : "POST",
			url :'islemler.php?islem=iskontoUygula',
			data :$('#iskontoForm').serialize(),			
			success: function(donen_veri){
			$('#iskontoForm').trigger("reset");
				window.location.reload();
			},			
		})		
	});			
$('#parcabtn').click(function() {
				
		$.ajax({			
			type : "POST",
			url :'islemler.php?islem=parcaHesapOde',
			data :$('#parcaForm').serialize(),			
			success: function(donen_veri){
			$('#parcaForm').trigger("reset");
				window.location.reload();
			},			
		})		
	});	   
$('input[name="urunid"]').change(function(){
  $(".urunlab").css("background-color","#fff");
  var deger = $('input[name="urunid"]:checked').val();
   $(".urunidlab"+deger).css("background-color","#00bf00");

  });
$('#tumunusil').click(function() {
					
		var sectionId =$(this).attr('sectionId');
				
		$.post("islemler.php?islem=tumunusil",{"id":sectionId},function(){
			window.location.reload();		
			
     });			
  });
  });
  var popupWindow=null;
function ortasayfa(url,winName,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;	
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;	
	settings='height='+h+',	width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	popupWindow=window.open(url,winName,settings)}