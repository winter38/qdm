function getXmlHttp(){
	try {
		return new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			return new ActiveXObject("Microsoft.XMLHTTP");
		} catch (ee) {
		}
	}
	if (typeof XMLHttpRequest!='undefined') {
		return new XMLHttpRequest();
	}
}

card = '';

function get_card(){
    var xmlhttp = getXmlHttp()
    xmlhttp.open("GET", "/winterwolf/test/ajax.php", true);
    xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == 4) {
         if(xmlhttp.status == 200) {
           var card = xmlhttp.responseText;
           $(".ajax").attr("src", "http://warwolf.org/winterwolf/cards/"+card);
         }
      }
    };
    xmlhttp.send(null);

    return card;
}

$(document).ready(function() {
    $(".block").click(function(){
       get_card();
    })
});
