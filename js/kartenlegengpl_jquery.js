function kartenlegengpl_AjaxGetOrakelseeGPLData(cardids,lang) {
   cardids = encodeURI( cardids );
   lang = encodeURI( lang );
   jQuery.ajax({
		type: "POST",   
      dataType: "html",             
		url: kartenlegengplAjax.ajax_url,      
		data: {
			action: 'kartenlegengpl_handler', 
			cards : cardids,    
			lang  : lang,    
			nonce : kartenlegengplAjax.security,     
		},
		success: function( data ) {
         kartenlegengpl_SpellGPLResponse(data); // back in kartenlegengpl.js
		},
		error: function(errorThrown) {
			console.log(errorThrown); 
		}
	});
}
function kartenlegengpl_AjaxGetGPLCard(id) {
   id = encodeURI( id );
   jQuery.ajax({
		type: "POST",   
      dataType: "html",             
		url: kartenlegengplAjax.ajax_url,      
		data: {
			action: 'kartenlegengpl_handler', 
			card : id,       
			nonce : kartenlegengplAjax.security,     
		},
      success: function( data ) {
         kartenlegengpl_CardGPLResponse(data); // back in kartenlegengpl.js
		},
		error: function(errorThrown) {
			// not in prod
		}
	});
}