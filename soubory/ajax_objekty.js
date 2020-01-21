
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
      alert(data);
      data = data.data;
      produkt = new produkt({
        ID: data.ID,
        Jmeno: data.Nazev,
        Kategorie: data.Kategorie,
        Cena: data.Cena })
      $.each(data, function(key, value) {
        html += '<tr>';
        $.each(value, function(klic, obsah) {
          //alert(klic + ': ' + obsah);
          html += '<td>' + obsah + '</td>';
        });
        html += '<td><button id=button name= '+value.ID+' onclick="pridatDoKosikuCookie('+value.ID+')" text="pridat do kosiku" >Přidat do košíku</button></td></tr>';     
      });
      html += '</table>';
      $('#produkty').html(html); 
          
    });
    return false; // keeps the page from not refreshing 
  });
});