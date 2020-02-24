
function pridatDoKosikuCokie(cname, cvalue, exdays) {
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
$(document).ready(function(){
  $(':submit').on('click', function() { // This event fires when a button is clicked
    var button = $(this).val();
    $.ajax({ // ajax call starts
      url: 'produkty-ze-serveru.php', // JQuery loads serverside.php
      data: 'button=' + $(this).val(), // Send value of the clicked button
      dataType: 'json', // Choosing a JSON datatype
    })
    .done(function(data) { // Variable data contains the data we get from serverside
      //alert(data);
      var html = '<table border=1><tr><th>název</th><th>kategorie</th><th>cena</th><th>dostupnost</th> <th>pridat do kosiku</th></tr>';
      
      $.each(data, function(key, value) {
        html += '<tr>';
        $.each(value, function(klic, obsah) {
          //alert(klic + ': ' + obsah);
          console.log(klic + ': ' + obsah);
          html += '<td>' + obsah + '</td>';
        });
        html += '<td><form method="post" action="index2.php?action=add&id=<?php echo $row["id"]; ?>">\
        <input type="number" name="pocet" id="pocetkusu'+value.ID+'">\
        <button id=button1 name='+value.ID+' onclick="pridatDoKosikuCookie('+value.ID+')" text="pridat do kosiku" >Přidat do košíku</button></td></tr>';     
      });
      html += '</table>';
      $('#produkty').html(html); 
          
    });
    return false; // keeps the page from not refreshing 
  });
});