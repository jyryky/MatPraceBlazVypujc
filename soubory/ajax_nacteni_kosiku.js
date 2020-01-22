
$(document).ready(function(){
    $(':submit').on('click', function() { // This event fires when a button is clicked
      console.log("ajax");
      var pole = cookies;
      console.log(pole);
      $.ajax({ // ajax call starts
        url: 'kosik-produkty-ze-serveru.php', // JQuery loads serverside.php
        data: 'pole=' + pole, // Send value of the clicked button
        dataType: 'json', // Choosing a JSON datatype
      })
      .done(function(data) { // Variable data contains the data we get from serverside
        //alert(data);
        var html = '<table border=1><tr><th>ID</th><th>název</th><th>cena</th><th>kategorie</th><th>dostupnost</th><th>popis</th><th>smazat?</th></tr>';
        let fruits = [];
        $.each(data, function(key, value) {
             console.log("data",data);
          html += '<tr><div id='+value.ID+'>';  
          $.each(value, function(klic, obsah) {
            //alert(klic + ': ' + obsah);
            html += '<td> ' + obsah + '</td>';
          });
          html += '<td><input type="checkbox",id='+value.ID+' name='+value.ID+',onclick="myFunction()"form="formular_odebrat" >smazat?</input></td></div></tr>';     
        console.log("value",value)
        fruits.push(value.ID)
        console.log(fruits)
 
        });
        
        html += '</table>';
        $('#produkty').html(html); 
            
      });
      return false; // keeps the page from not refreshing 
    });
  });