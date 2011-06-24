// Javascript code for the Joomla! ServiceProject component
// This JS file contains basics AJAX javascript functions to handle content updates and error messages
// Copyright (C) 2011 Greg Effland. All rights reserved.

// NOTE: This requires JQuery to be loaded and under the $j variable

function csp_AjaxURL(varTask, varParams) {
	result = 'index.php?option=com_serviceproject&task=' + varTask + '&format=raw';
	if (varParams!=undefined) {
		varParamsText = JSON.stringify(varParams);
		myParams = JSON.parse(varParamsText, function(key, value) {
			if (key!="params" & key!="") {
				result = result + "&" + key + "=" + value;
			}
		});
	}
	return result;
}

function csp_getJSONResponse(varTask, varParams, varData) {
	// data: {dirtype: varDirType, path: varPath},
	// add Joomla! Token to varData
	varToken = $j("#token :input").attr('name');
	var varTokenJSON = {};
	varTokenJSON[varToken]= 1;
	$j.extend(varData, varTokenJSON);
	$j.ajax({
		type: 'POST',
		url: csp_AjaxURL(varTask, varParams),
		dataType: 'json',
		data: varData,
		complete: function(jqXHR, textStatus) {
			var jsonReturn = $j.parseJSON(jqXHR.responseText);
			//update the html
			$j.each(jsonReturn.htmlcode, function(i, htmlclip) {
				//alert ('id=' + htmlclip.id + ' --> ' + htmlclip.html + ' ===>> ' + htmlclip);
				//$j('#' + htmlclip.id).html(htmlclip.html);
				$j('#' + htmlclip.id).replaceWith(htmlclip.html);
			});
			// show any messages
			if (jsonReturn.messages.length > 0) {
				alert (jsonReturn.messages);
			}
		}
	});
}