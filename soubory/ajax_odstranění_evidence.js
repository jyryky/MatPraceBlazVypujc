
function myFunction(){
    var checked = document.querySelector('.checkboxy:checked');
    //console.log(checked);
  }
  $(document).ready(function(){
      $('#kategorie').on('click', function() { // This event fires when a button is clicked
        var button = $(this).val();
        var checked = document.querySelector('.checkboxy:checked');
        console.log(checked);
        $.ajax({ // ajax call starts
          url: 'nacist_vsechny_produkty_evidence.php', // JQuery loads serverside.php
          data: 'button=' + $(this).val(), // Send value of the clicked button
          dataType: 'json', // Choosing a JSON datatype
        })
        .done(function(data) { // Variable data contains the data we get from serverside
          //alert(data);
          var html = '<form method="post" action="odebrat.php" id="formular_odebrat"> <table border=1><tr><th>Evidenční číslo produktu</th><th>název</th><th>popis</th><th>smazat?</th></tr>';
          let fruits = [];
          $.each(data, function(key, value) 
         {
               //console.log("data",data);
            html += '<tr><div id='+value.id+'>';  
            $.each(value, function(klic, obsah) {
              //alert(klic + ': ' + obsah);
              html += '<td> ' + obsah + '</td>';
            });
            html += '<td><input type="checkbox" id='+value.id+' name="check_list[]" class="checkboxy" value='+value.id+'  onChange="set_check(this,'+value.id+')" onclick="myFunction()"form="formular_odebrat" >smazat?</input></td></div></tr>';     
          console.log(value.id);
           
          });
          
          html += '</table><input type="submit" value="odeslat" name="odeslat_evidence" id="odeslat" form="formular_odebrat">  </form>';
          $('#produkty').html(html); 
              
        });
        return false; // keeps the page from not refreshing 
      });
    });