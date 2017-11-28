$(document).ready(function(){
  $('#error').hide();
  $('#incomplete').hide();
  $('#register_incomplete').hide();
  $('#wrong_data').hide();
  $('#wait').hide();
  $('#credit_incomplete').hide();
  $('#credit_error').hide();

  $('#connect').click(function(){
    var username = document.getElementById("login").value;
    var password = document.getElementById("pwd").value;
    if(username != '' && password != ''){
      $('#incomplete').hide();
      $.ajax({
        type:'POST',
        url:'login.php',
        data:{'username':username, 'password':password},
        success:function(data){
          if(data == 'YES'){
            $('#connexionModal').hide();
            location.reload();

          }else{
            $('#error').show();
          }
        }
      });
    }else{
      $('#error').hide();
      $('#incomplete').show();
    }
  });

  $('#register').click(function(){
    var user = document.getElementById("user").value;
    var pass = document.getElementById("pass").value;
    var password2 = document.getElementById("pass2").value;
    var mail = document.getElementById("mail").value;
    var year = document.getElementById('year').value;
	  var month = document.getElementById('month').value;
	  var day	= document.getElementById('day').value;
    var adress = document.getElementById('adress').value;
    var city = document.getElementById('city').value;
    var work = document.getElementById('work').value;
    var terms = document.getElementById('terms').value;
	  //alert(user+""+pass+""+mail+""+year+""+month+""+day+""+adress+""+city+""+work+""+terms);
    if(user == '' || pass == '' || password2 == '' || mail == ''|| year == '' ||
    month == '' || day == '' || adress == '' || city == '' || work == '' || terms == '')
    {
      $('#register_incomplete').show();
    }else
    {
      $('#register_incomplete').hide();
      $.ajax({
        type:'POST',
        url:'register.php',
        data:{'user':user, 'pwd':pass,'pwd2':password2,'mail':mail,'year':year,'month':month,'day':day,'adress':adress,'city':city,'work':work},
        success:function(data){
  			if(data == 'yes'){
  				$('#wait').show();
  				$('#wrong_data').hide();
  				//alert('success');
  			}else{
  				document.getElementById('wrong_data').innerHTML = data;
  				$('#wrong_data').show();
  				//alert('fail');
  			}
			//alert(data);
        }
      });
    }

  });

  $('#charge').click(function(){
    var mail = document.getElementById('credit_mail').value;
    var pass = document.getElementById('credit_pass').value;
    var credit = document.getElementById('credit').value;

    if(mail == '' || pass == '' || credit == ''){
      $('#credit_incomplete').show();
    }else{
      $('#credit_incomplete').hide();
      $.ajax({
        type: 'POST',
        url:'addcredit.php',
        data:{'email':mail,'password':pass,'credit':credit},
        success:function(data){
          //alert(data);
          if(data == 'Credit rajouté'){
            $('#charge').before('<div id="success">Success!</div>');
            $('#success').delay(3000).fadeOut();
            //alert('Credit rajouté');
            location.reload();
          }else{
            document.getElementById('credit_error').innerHTML = data;
            $('#credit_error').show();
          }
        }
      });
    }
  });


  $('#close').click(function(){
    $('#error').hide();
    $('#incomplete').hide();
  });

  $('#close2').click(function(){
    $('#error').hide();
    $('#incomplete').hide();
    $('#register_incomplete').hide();
  });

change()
});

function change()
{
  var x;
  setTimeout(function(){
    $.ajax({
      type: 'POST',
      url:'simulation.php',
      success:function(data)
      {
		//alert(data);
		if(data == 'score' || data == 'scoreyes' || data =='yes')
		{
			if (confirm("Changement de score. Voulez-vous rafraichir la page?") == true) {
				location.reload();
			} else {
				
			}
		}
			
		//alert('fontionne');
      }
    });
    /*var MaxMatcheId = document.getElementById("MaxMatcheId").value;
    var rand=Math.floor((Math.random() * MaxMatcheId) + 1);
    $('#score'+1).fadeOut('slow').load('score1.php?matcheId='+rand).fadeIn('slow');
    change();*/
  },4000);
}
