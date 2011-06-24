// Javascript code for the Joomla! ServiceProject component
// This JS file contains AJAX javascript functions for Project Roles
// Copyright (C) 2011 Greg Effland. All rights reserved.

// NOTE: This requires JQuery to be loaded and under the $j variable and ajaxbas.js to be loaded

function csp_updateCanModifyProject(cids) {
	var varTask = "toggleCanModifyProject";
	var varParams = null;
	var varData = {prefix: "cmp", jstask: "csp_updateCanModifyProject", cid: cids};
	csp_getJSONResponse(varTask, varParams, varData);
}

function csp_updateCanModifyVolunteers(cids) {
	var varTask = "toggleCanModifyVolunteers";
	var varParams = null;
	var varData = {prefix: "cmv", jstask: "csp_updateCanModifyVolunteers", cid: cids};
	csp_getJSONResponse(varTask, varParams, varData);
}

function csp_updateCanViewContactInfo(cids) {
	var varTask = "toggleCanViewContactInfo";
	var varParams = null;
	var varData = {prefix: "cvc", jstask: "csp_updateCanViewContactInfo", cid: cids};
	csp_getJSONResponse(varTask, varParams, varData);
}