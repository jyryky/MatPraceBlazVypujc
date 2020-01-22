function pridatDoKosikuCookie(cname) {
    var stringg = cname.toString();
    var pocetkusu = "pocetkusu"
    var res = pocetkusu.concat(stringg);
   var  p=document.getElementById(res).value;  
    console.log(res);
    console.log(p);
    console.log("jeto tam ");
    var date = new Date();
    // Default at 365 days.
    days = 365;
    date.setTime(+ date + (days * 86400000))
  var x = document.cookie = +cname+"="+res+"; expires="+ date.toGMTString() +"; path=/;";
console.log(x);
return (cname)
}


function get_cookies_array() {

  var cookies = { };

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

