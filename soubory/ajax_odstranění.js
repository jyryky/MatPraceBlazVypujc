
function myFunction(){
  var checked = document.querySelector('.checkboxy:checked');
  //console.log(checked);
}
function setCookie(c_name,value,exdays){    
  var exdate=new Date();
  exdate.setDate(exdate.getDate() + exdays);
  var c_value=escape(value) + ((exdays==null) ?
      "" : "; expires="+exdate.toUTCString());
  document.cookie=c_name + "=" + c_value;
}

function set_check(me,id){
  setCookie(me.value+id, id, 60*60*1);
  console.log(me.value);
  console.log(id);
  console.log(me.checked);
  console.log(document.cookie)
}
$(document).ready(function(){
    $(':submit').on('click', function() { // This event fires when a button is clicked
      var button = $(this).val();
      var checked = document.querySelector('.checkboxy:checked');
      console.log(checked);
      $.ajax({ // ajax call starts
        url: 'nacist_vsechny_produkty.php', // JQuery loads serverside.php
        data: 'button=' + $(this).val(), // Send value of the clicked button
        dataType: 'json', // Choosing a JSON datatype
      })
      .done(function(data) { // Variable data contains the data we get from serverside
        //alert(data);
        var html = '<table border=1><tr><th>ID</th><th>název</th><th>cena</th><th>kategorie</th><th>popis</th><th>smazat?</th></tr>';
        let fruits = [];
        $.each(data, function(key, value) {
             console.log("data",data);
          html += '<tr><div id='+value.ID+'>';  
          $.each(value, function(klic, obsah) {
            //alert(klic + ': ' + obsah);
            html += '<td> ' + obsah + '</td>';
          });
          html += '<td><input type="checkbox" id='+value.ID+' name='+value.ID+' class="checkboxy"  onChange="set_check(this,'+value.ID+')" onclick="myFunction()"form="formular_odebrat" >smazat?</input></td></div></tr>';     
        
 
        });
        
        html += '</table>';
        $('#produkty').html(html); 
            
      });
      return false; // keeps the page from not refreshing 
    });
  });