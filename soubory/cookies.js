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

function getCookie() {
    var getting = browser.cookies.getAll(
        details                // object
      )
    for (i = 0; i < 100; i++){
        var v = document.cookie.test('(^|;) ?' + i + '=([^;]*)(;|$)');
        if (v==true){
            console.log(i);
            return(i);
        }
    }
    
}

