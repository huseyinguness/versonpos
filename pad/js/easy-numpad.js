$(document).ready(function () {
	 $('#pad').hide();
	var numara1=1; // Parça Hesap
	var numara2=2; // Hesap Alma
	var numara3=3;
    var numara3=4;
    $('#numarator'+numara1).on('click', function () {
		$(this).val("");
        show_easy_numpad(numara1);
    });	
	 $('#numarator'+numara2).on('click', function () {
		$(this).val("");
        show_easy_numpad(numara2);
		
    });
	$('#numarator'+numara3).on('click', function () {
		$(this).val("");
        show_easy_numpad(numara3);
		
    });
    $('#numarator'+numara4).on('click', function () {
        $(this).val("");
        show_easy_numpad(numara4);
        
    });

   });
function show_easy_numpad(deger) {
	
	
	
    var easy_numpad ='<p class="easy-numpad-output" id="easy-numpad-output"></p><div class="easy-numpad-number-container"><table><tr><td><a href="7" onclick="easynum()">7</a></td><td><a href="8" onclick="easynum()">8</a></td><td><a href="9" onclick="easynum()">9</a></td><td><a href="Del" class="del" id="del" onclick="easy_numpad_del()">Sil</a></td></tr><tr><td><a href="4" onclick="easynum()">4</a></td><td><a href="5" onclick="easynum()">5</a></td><td><a href="6" onclick="easynum()">6</a></td><td><a href="Clear" class="clear" id="clear" onclick="easy_numpad_clear()">Temizle</a></td></tr><tr><td><a href="1" onclick="easynum()">1</a></td><td><a href="2" onclick="easynum()">2</a></td><td><a href="3" onclick="easynum()">3</a></td><td><a href="Cancel" class="cancel" id="cancel" onclick="easy_numpad_cancel()">Kapat</a></td></tr><tr><td colspan="2" onclick="easynum()"><a href="0">0</a></td><td onclick="easynum()"><a href=".">.</a></td><td><a href="Done" class="done" id="done" onclick="easy_numpad_done('+deger+')">Onayla</a></td></tr></table></div>';
	$('#pad').show();
    $('#pad').html(easy_numpad);}
function easynum() {
    event.preventDefault();

    navigator.vibrate = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;
    if (navigator.vibrate) {
        navigator.vibrate(60);
    }

    var easy_num_button = $(event.target);
    var easy_num_value = easy_num_button.text();
    $('#easy-numpad-output').append(easy_num_value);	  
	 
    }
function easy_numpad_del() {
    event.preventDefault();
    var easy_numpad_output_val = $('#easy-numpad-output').text();
    var easy_numpad_output_val_deleted = easy_numpad_output_val.slice(0, -1);
    $('#easy-numpad-output').text(easy_numpad_output_val_deleted);
    }
function easy_numpad_clear() {
    event.preventDefault();
    $('#easy-numpad-output').text("");
    }

 function easy_numpad_cancel() {
    event.preventDefault();
    $('#pad').hide();
    }
function easy_numpad_done(gelendeger) {	

    event.preventDefault();
    var easy_numpad_output_val = $('#easy-numpad-output').text();	


 	 $("#numarator"+gelendeger).val(easy_numpad_output_val);


     if(gelendeger==2)
     {
         $('#ParaUstuSonuc').html($('#Toplamtut').html() - easy_numpad_output_val );

     }


	  $('#easy-numpad-output').text("");
	  $('#pad').html();
      $('#pad').hide();
 }	
   
