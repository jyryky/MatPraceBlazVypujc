
function myFunction(){
  var checked = document.querySelector('.checkboxy:checked');
  //console.log(checked);
}
$(document).ready(function(){
    $('#typ').on('click', function() { // This event fires when a button is clicked
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
        var html = ' <form method="post" action="odebrat.php" id="formular_odebrat"> <table class="table table-hover" border=1><tr><th>ID</th><th>název</th><th>cena</th><th>PocetKusu</th><th>popis</th><th>smazat?</th></tr>';
        let fruits = [];
        $.each(data, function(key, value) 
       {
             //console.log("data",data);
          html += '<tr><div id='+value.ID+'>';  
          $.each(value, function(klic, obsah) {
            //alert(klic + ': ' + obsah);
            html += '<td> ' + obsah + '</td>';
          });
          html += '<td><input type="checkbox" id='+value.ID+' name="check_list[]" class="checkboxy" value='+value.ID+'  onChange="set_check(this,'+value.ID+')" onclick="myFunction()"form="formular_odebrat" >smazat?</input></td></div></tr>';     
        console.log(value.ID);
      
 
        });
        
        html += '</table><input type="submit" value="Odeslat" name="odeslat_typ" class="btn btn-danger btn-lg" id="nastred" form="formular_odebrat">  </form>';
        $('#produkty').html(html); 
            
      });
      return false; // keeps the page from not refreshing 
    });
  });