function pridatDoKosikuCookie(cname) { //přídává cookcies vybranžých souborů
    var stringg = cname.toString();
    var pocetkusu = document.getElementById('pocetkusu'+cname).value
    var res = pocetkusu.concat(stringg);
   //var  p=document.getElementById(res).value;  
    console.log(res);
    //console.log(p);
    console.log(pocetkusu);
    console.log("jeto tam ");
    var date = new Date();
    // Default at 365 days.
    days = 365;
    date.setTime(+ date + (days * 86400000))
  var x = document.cookie = +cname+"="+pocetkusu+"; expires="+ date.toGMTString() +"; path=/;";
console.log(x);
return (cname)
}


function get_cookies_array() {

  var cookies = { };
  console.log("spustila se funkce get_cookies_array ")
  if (document.cookie && document.cookie != '') {
      var split = document.cookie.split(';');
      for (var i = 0; i < split.length; i++) {
          var name_value = split[i].split("=");
          name_value[0] = name_value[0].replace(/^ /, '');
          cookies[decodeURIComponent(name_value[0])] = decodeURIComponent(name_value[1]);
      }
  }
  console.log(cookies);
  return cookies;
 
}

