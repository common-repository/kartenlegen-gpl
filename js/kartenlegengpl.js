var cardids = "";
function kartenlegengpl_selectCard( id, lang ) { 
   if ( id == "" ) { return ""; }
   document.getElementById( "orakelhelper" ).style.display = "none";
   var selectedcard = document.getElementById( id );
   if ( cardids.length >= 6 ) { document.getElementById( "cselector" ).style.display = "none"; } 
   selectedcard.className = "selectedcard";
   if ( cardids.length <= 6 ) {
      cardids += id;
      if ( cardids.length > 6 ) { 
         document.getElementById("orakelspruch").innerHTML = '<p style="text-align:center">Too many cards</p>';
         return; 
      }
      kartenlegengpl_AjaxGetGPLCard( encodeURI( id ) );
      if ( cardids.length == 6 ) {
         document.getElementById("cselector").style.display = "none";
         document.getElementById("orakelwait").style.display = "block";
         document.getElementById("selectedcards").style.textAlign = "left";
         kartenlegengpl_AjaxGetOrakelseeGPLData( encodeURI( cardids ), encodeURI( lang ));
      }
   }
}
function kartenlegengpl_SpellGPLResponse( spell ) {
   document.getElementById( "orakelwait" ).style.display = "none";
   document.getElementById( "orakelspruch" ).innerHTML = spell;
   document.cookie = "kartenlegengpl=" + encodeURI( spell ) + "; max-age=10;"; // avoid server overload
}
function kartenlegengpl_CardGPLResponse( data ) {
   if ( data == "" ) { return ""; }
   var selectdiv = document.getElementById( "selectedcards" );
   selectdiv.innerHTML += '<img class="showselectedcard" src="' + encodeURI( data ) + '" alt="" />';
}

