// IMPORTANT INFORMATION

explore = {

	init: function(params){

		explore.ajaxCall(params, true);

		// ORDER BY
		$("#" + params.tableId).on("click", '*[data-action="order"]', function(){
		  var neworderBy = $(this).attr("data-id");
		  if(neworderBy == params.orderBy) {
		  	if(params.sort == 'ASC') {
		  		params.sort = 'DESC';
		  	} else {
		  		params.sort = 'ASC';
		  	}
		  } else {
			  params.orderBy = neworderBy;
			  params.sort = 'ASC';
			}
			explore.ajaxCall(params, false);
		});

		$("#" + params.tableId).on("change", '*[data-action="changeresultPerPage"]', function(){
		  var newresultPerPage = $(this).val();
		  if(newresultPerPage < 0 || newresultPerPage == null) { newresultPerPage = 10; }
			params.resultPerPage = newresultPerPage;
			params.currentPage = 1; // Put back to 1 to avoid getting out of page range
			explore.ajaxCall(params, false);
		});

		$("#" + params.tableId).on("click", '*[data-action="previousPage"]', function(){
			if($(this).attr("data-state") != 'disabled') {
				params.currentPage = params.currentPage - 1;
				explore.ajaxCall(params, false);
			}
		});

		$("#" + params.tableId).on("click", '*[data-action="nextPage"]', function(){
			if($(this).attr("data-state") != 'disabled') {
				params.currentPage = params.currentPage + 1;
				explore.ajaxCall(params, false);
			}
		});

		$("#" + params.tableId).on("click", '*[data-action="changePage"]', function(){
		  var newPage = Number($(this).attr("data-id"));
		  params.currentPage = newPage;
			explore.ajaxCall(params, false);
		});

		$("#" + params.tableId).on("keyup", '*[data-action="globalSearch"]', function(){
		  var newResearch = $(this).val();
		  if((newResearch).length!=0) {
		  	$(".explore-search-icon").removeClass("fa-search").addClass("fa-times").addClass("explore-delete-search");
		  } else {
		  	$(".explore-search-icon").removeClass("fa-times").addClass("fa-search").removeClass("explore-delete-search");
		  }
		  params.search.globalSearch = newResearch;
			explore.ajaxCall(params, false);
		});

		$("#" + params.tableId).on("click", '.explore-delete-search', function(){
			$(".explore-search-input").val('');
			var newResearch = $(this).val();
		  if((newResearch).length!=0) {
		  	$(".explore-search-icon").removeClass("fa-search").addClass("fa-times").addClass("explore-delete-search");
		  } else {
		  	$(".explore-search-icon").removeClass("fa-times").addClass("fa-search").removeClass("explore-delete-search");
		  }
		  params.search.globalSearch = newResearch;
			explore.ajaxCall(params, false);
		});

		$("#" + params.tableId).on("keyup", '*[data-action="search-field"]', function(){
		  var searchFieldVal = $(this).val();
			var searchFieldId = $(this).attr("name");
		  params.search.searchFields['inputSearch_' + searchFieldId] = { searchId: searchFieldId, searchVal: searchFieldVal, searchTpl: "cn" };
			explore.ajaxCall(params, false);
		});

		$("#" + params.tableId).on("change", '*[data-action="select-field"]', function(){
		  var selectFieldVal = $(this).val();
			var selectFieldId = $(this).attr("name");
		  params.search.searchFields['selectSearch_' + selectFieldId] = { searchId: selectFieldId, searchVal: selectFieldVal, searchTpl: "eq" };
			explore.ajaxCall(params, false);
		});

		// EXPORTS
		$("#" + params.tableId).on("click", '*[data-action="export-results"]', function(){
			if(typeof params.exportAllowed != 'undefined' && params.exportAllowed == true) {
		  	explore.exportResults(params);
		  }
		});

	},

	// Ajax call at page load
	ajaxCall: function(params, primary) {

		// Loader
		if(primary) {
			$("#" + params.tableId).html(explore.createTopNavigation(params));
			$("#" + params.tableId).append('<div id="explore-loader" style="padding: 20px; text-align: center; background-color: #ececec;"><div class="preloader-wrapper big active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></div>');
		} else {
			$("#explore-search-loader").html('<div class="explore-loader-small preloader-wrapper small active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>');
		}

		// Construction of the array of fields to be passed to the controller
		var sql_fields = {};

		for(var field in params.fields){
			sql_fields[field] = params.fields[field].db_id;
		}

		// Controller method and parameters (see ax)
	  dataQuery = {
	    "action" : params.ajaxUrl,
	    "params" : {
	    	"fields" : sql_fields,
	    	"rowId" : params.rowId,
	    	"table" : params.tableName,
	    	"orderBy" : params.orderBy,
	    	"sort" : params.sort,
	    	"resultPerPage" : params.resultPerPage,
	    	"currentPage" : params.currentPage,
	    	"searchFields" : params.search.searchFields,
	    	"searchFilters" : params.search.searchFilters,
	    	"research" : params.search.globalSearch
	    }
	  }

	  // Ajax call
	  $.ajax({
	    type: "POST",
	    url: "index.php",
	    async: true,
	    data: dataQuery,
	    dataType: "json",
	    error: function(data) {
        alert("An error occured.");
      },
	    success: function(data) {
    		if(primary) {
    			function initTemp(removeLoaderTemp) {
    				$("#" + params.tableId).append(explore.initTable(params, data)); // Load the table
	    			removeLoaderTemp();
    			}
    			function removeLoaderTemp() {
    				$("#explore-loader").remove();
    			}
    			initTemp(removeLoaderTemp);
    		} else {
    			function refreshTemp(emptyLoaderTemp) {
	    			explore.refreshTable(params, data);
	    			emptyLoaderTemp();
    			}
    			function emptyLoaderTemp() {
    				$("#explore-search-loader").empty();
    			}
    			refreshTemp(emptyLoaderTemp);
    		}
      }
	  });

	},

	initTable: function(params, data) {

		html = "";
		html += "<table class='bordered responsive-table explore-table'>";
		html += "<thead>";
		html += explore.createTableHeaders(params);
		html += explore.createTableSearchFields(params);
		html += "</thead>";
		html += "<tbody id='explore-table-body'>";
		html += explore.createTableBody(data, params);
		html += "</tbody>";
		html += "</table>";
		html += "<div id='explore-bottom-navigation'>";
		html += explore.createBottomNavigation(data, params);
		html += "</div>";
		return html;

	},

	refreshTable: function(params, data) {

		$("#explore-table-head").replaceWith(explore.createTableHeaders(params))
		$("#explore-table-body").html(explore.createTableBody(data, params));
		$("#explore-bottom-navigation").html(explore.createBottomNavigation(data, params));

	},

	createTableHeaders: function(params) {

		var html = "";

		html = "<tr id='explore-table-head'>";

		var totalWidth = 0;

		for (var field in params.fields) {
			if(params.fields[field].visible != false) {
				totalWidth = totalWidth + Number(params.fields[field].columnWidth);
			}
		};

		for(var field in params.fields) {
			if(params.fields[field].visible != false) {
				var calculatedWidth = (Number(params.fields[field].columnWidth) * 100 / totalWidth);
				if(params.fields[field].sortable) {
					var dataAction = "data-action='order'";
					var cursor = "cursor: pointer; ";
	 			} else {
	 				var dataAction = "";
	 				var cursor = "";
	 			}

	 			if(params.fields[field].responsiveHeight == true) {
	 				var responsiveHeight = "class='responsive-Height' ";
	 			} else {
	 				var responsiveHeight = "";
	 			}

				html += "<th " + responsiveHeight + "data-id='" + params.fields[field].db_id + "'" + dataAction + " style='" + cursor + "white-space: nowrap; width: " + calculatedWidth + "%'>";
				if(params.fields[field].rotate) {
					html += "<span class='explore-vertical-label'>";
				} else {
					html += "<span>";
				}

				if(params.fields[field].sortable) {
					if(params.fields[field].db_id == params.orderBy) {
						html += "<div class='valign-wrapper blue-text'>";
					} else {
						html += "<div class='valign-wrapper'>"
					}
				}

				html += params.fields[field].label;

				if(params.fields[field].sortable) {
					if(params.fields[field].db_id == params.orderBy) {
						html += "&#0160&#0160 <i style='font-weight: 300;' class='fa ";
						if(params.sort == 'ASC') {
							html += "fa-chevron-down";
						} else {
							html += "fa-chevron-up";
						}
						html += "'></i>";
					} else {
						html += "&#0160&#0160 <i class='fa fa-chevron-down'></i>";
					}
				}

				if(params.fields[field].sortable) {
					html += "</div>";
				}

				html += "</span></th>";
			}
		}

		html += "</tr>";

		return html;

	},

	createTableSearchFields: function(params) {
		html = "";
		var hasSearch = false;
		for(var field in params.fields) {
			if(typeof params.fields[field].searchable != 'undefined') {
				hasSearch = true;
			}
		}
		if(hasSearch) {
			html += "<tr id='explore-table-search-fields' style='background-color: #f9f9f9;'>";
			for(var field in params.fields) {
				if(params.fields[field].visible != false) {
					html += "<td style='border-right: 1px solid #D0D0D0;'>";
					if(params.fields[field].searchable == true || params.fields[field].searchable == 'input') {
						html += "<input class='smaller-input' style='width: 100%;' data-action='search-field' name='" + params.fields[field].db_id + "' />"
					} else if (params.fields[field].searchable == 'select') {
						html += "<select class='smaller-select' style='width: 100%;' data-action='select-field' name='" + params.fields[field].db_id + "'>";
						for (var i = 0; i < params.fields[field].selectValues.length; i++) {
							html += "<option value='" + params.fields[field].selectValues[i]['value'] + "'>" + params.fields[field].selectValues[i]['label'][userLanguage] + "</option>";
						};
						html += "</select>";
					}
					html += "</td>"
				}
			}
			html += "</tr>";
		}
		return html;
	},

	createTableBody: function(data, params) {

		var html = "";

		if(typeof data == "undefined" || data == null || data.length == 0 || data['count']['nbr'] == 0) { // Is there data ?
			html += "<tr style='background-color: #ecf8ff; border-bottom: 0px;'><td colspan='100%'><div class='explore-no-results valign-wrapper'><i class='fa fa-info-circle'></i>&#0160;&#0160;Pas de résultat.</div></td></tr>";
		} else {
			for(var row in data['data']) {
				var prefix = (typeof params.rowPrefix == 'undefined') ? ("") : (params.rowPrefix + "_");
				var clickableRow = (params.clickableRow === false) ? ("") : ("cursor: pointer;");
				html += "<tr style='" + clickableRow + "' data-id='" + prefix + data['data'][row]['rowId'] + "' id='" + prefix + data['data'][row]['rowId'] + "'>";
				for(var field in params.fields) {
					if(params.fields[field].visible != false) {
						if(typeof params.fields[field].template != 'undefined') {
							displayedData = params.fields[field].template.replace(/\%data/g, data['data'][row][field]);
						} else {
							displayedData = data['data'][row][field];
						}

						if(typeof params.fields[field].tdId !== 'undefined') {
							tdId = " data-id='" + params.fields[field].tdId.replace("/%data/g", data['data'][row][params.rowId]) + "'";
						} else {
							tdId = "";
						}
						if(displayedData == null || displayedData === "") displayedData = ' ';
						var responsiveHeight = (params.fields[field].responsiveHeight == true) ? (" class='responsive-Height'") : ("");
						html += "<td" + tdId + responsiveHeight + ">" + displayedData + "</td>";
					}
				}
				html += "</tr>";
			}
		}
		return html;

	},

	createTopNavigation: function(params) {
		var html = "<div class='explore-topNavigation'><div class='row no-margin'>";
		html += "<div style='display: flex; width: 250px;'><input data-action='globalSearch' type='text' class='standard-input no-margin explore-search-input' placeholder='Votre recherche ...'/><i class='fa fa-search explore-search-icon'></i></div>";
		html += "<div id='explore-search-loader'></div>";
		html += "<div style='float: right;'><select data-action='changeresultPerPage' class='standard-select explore-result-per-page'><option value='10'>Résultats par page (10)</option><option value='20'>20</option><option value='50'>50</option><option value='100'>100</option><option value='9999999'>Tous les résultats</option></select></div></div></div>";
		return html;
	},

	createBottomNavigation: function(data, params) {
		var html = "";
		if(data['count']['nbr'] > 0) {
			html += "<div class='explore-bottomNavigation'><div class='row no-margin'>";
			var firstResult = ((params.currentPage - 1) * params.resultPerPage) + 1;
			var lastResult = params.currentPage * params.resultPerPage;
			var lastPage = Math.ceil(data['count']['nbr'] / params.resultPerPage);
			if(lastResult > data['count']['nbr']) { lastResult = data['count']['nbr']; }

			// EXPORTS AVAILABLE
			if(typeof params.exportAllowed != 'undefined' && params.exportAllowed == true) {
				html += "<div style='float: left; padding-right: 15px;'><button class='explore-export-btn' data-action='export-results' altbox='Exporter en CSV'><i class='fa fa-external-link' aria-hidden='true'></i>&#0160;&#0160;Exporter</button></div>";
			}

			html += "<div style='float: left; line-height: 31px;'>";
				html += "Affiche <b>";
				html += (data['count']['nbr'] == 0) ? ('0') : (firstResult);
				html += "</b> de <b>";
				html += lastResult;
				html += "</b> à <b>";
				html += data['count']['nbr'];
				html += "</b> entrées";
			html += "</div>";
			html += "<div class='valign-wrapper' style='float: right;'>";
				if(params.currentPage <= 1) {
					html += "<i data-action='previousPage' data-state='disabled' class='fa fa-chevron-left explore-disabled explore-navigation-chevron'></i>&#0160&#0160";
				} else {
					html += "<i data-action='previousPage' class='fa fa-chevron-left explore-navigation-chevron'></i>&#0160&#0160";
				}
				for (var page = 1; page <= lastPage; page++) {
					if(page == lastPage || page == '1' || (page < params.currentPage + 2 && page > params.currentPage - 2)) {
						if(page != '1' && page == params.currentPage - 1) html += " ... ";
						html += "<button class='explore-button";
						if(page == params.currentPage) {
							html += " explore-button-active";
						}
						html += "' data-id='" + page + "' data-action='changePage'>" + page + "</button>";
						if(page != lastPage && page == params.currentPage + 1) html += " ... ";
					}
				}
				if(params.currentPage >= lastPage) {
					html += "&#0160&#0160<i data-action='nextPage' data-state='disabled' class='fa fa-chevron-right explore-disabled explore-navigation-chevron'></i>";
				} else {
					html += "&#0160&#0160<i data-action='nextPage' class='fa fa-chevron-right explore-navigation-chevron'></i>";
				}
				html += "</div>";
			html += "</div></div>";
		}
		return html;
	},

	exportResults: function(params) {

		var sql_fields = [];
		for(var field in params.fields){
			sql_fields.push(params.fields[field].db_id);
		}

		var labels_fields = [];
		for(var field in params.fields){
			labels_fields.push(params.fields[field].label);
		}

		if(typeof params.exportUrl == 'undefined' || params.exportUrl == 'default') {
			exportUrl = 'explore.exportResults';
		} else {
			exportUrl = params.exportUrl;
		}

		// Controller method and parameters (see ax)
	  dataQuery = {
	    "action" : exportUrl,
	    "params" : {
	    	"fields" : sql_fields,
	    	"fieldsLabels" : labels_fields,
	    	"table" : params.tableName,
	    	"orderBy" : params.orderBy,
	    	"sort" : params.sort,
	    	"research" : params.search.globalSearch,
	    	"searchFields" : params.search.searchFields,
	    	"searchFilters" : params.search.searchFilters,
	    	"exportFileName" : params.exportFileName
	    }
	  }

	  jsonUrl = JSON.stringify(dataQuery['params']);
	  uri = tools.fixedEncodeURIComponent(jsonUrl);
		finalUrl = "index.php?action=" + exportUrl + "&params=" + uri;
	  location.href = finalUrl;

	}

}
