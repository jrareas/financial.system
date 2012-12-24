/*
 * this class requires a column called col_id to identify the row
 *

json expected:
{
    "Files": [
        {
            "File Name": "Personal budget",
            "default_file": "1",
            "id": "1"
        },
        {
            "File Name": "Company budget",
            "default_file": "0",
            "id": "2"
        }
    ],
    "Params": {
        "default": "default_file"
    },
    "fields": [
        "File Name",
        "id"
    ],
    "Actions": {
        "Edit": {
            "icon": "Action-document-edit-icon.png",
            "onclick": "/file/edit"
        }
    }
}

*/
var tables = {
		tableTotalDeleted:0,
		tableTotalToDelete:0,
		initializeTable:function(idTable){
			$(idTable).find("tr").remove();
			$(idTable).append("<tr><th>Loading table...</th></tr>");
		},
		getDivRenderId:function(table){
			return $("#" + table).children('.paneltables').attr('id');
		},
		getFiles : function(divRenderId){
			$(divRenderId + ' .ajaxLoadingTables').show();
			$.ajax({
				type:'POST',
				url:'/remote/processRequest/getFiles',
				
				dataType: "json"}).done
				(function(response){
					//alert(response);
					tables.assemblyTable(divRenderId,response,{"default": "default_file"});
					$(divRenderId + ' .ajaxLoadingTables').hide();
					
				}).fail(function(response,textStatus){
					//alert(textStatus);
					alert('Something goes wrong. Please try again.');
					$(divRenderId + ' .ajaxLoadingTables').hide();
				});
			inicializaSessionTime();
			
		},
		getModel:function(data){
			for(var m in data ){
				return m;
				break;
			}  			
		},
		assemblyTable : function(divRenderId,data,parameters){
			//taking the model to tablename
			var model = tables.getModel(data);
			
			tables.initializeTable("#" + model);
			j=0;
			//geting only the columns
			for(var field in data.fields){
				if(data.fields[field] != 'id' && data.fields[field] != 'user_id' && data.fields[field].substr(0,7) != 'default'){
					if(j == 0){
						$("#" + model + " tr th:first").html(data.fields[field]);
					}else{
						$("#" + model + " tr").append("<th>" + data.fields[field] + "</th>");
					}
				}
				j++;
			}
			//geting the values and parameters
			for(i=0;i<data[model].length;i++){
				if((i % 2) == 0){
					$("#" + model).append("<tr id="+ data[model][i]['id'] +" class='even' ondblclick=tables.setDefaultObjTr(this) onclick=tables.changeSelection(this)></tr>");
				}else{
					$("#" + model).append("<tr id="+ data[model][i]['id'] +" class='odd' ondblclick=tables.setDefaultObjTr(this," + divRenderId + ") onclick=tables.changeSelection(this)></tr>");
				}
				if(typeof(data['Params']) != undefined){
					if(typeof(data['Params']['default']) != undefined){
						if(data[model][i][data['Params']['default']] == '1'){
							$("#" + model + " tr:last").addClass('default');
						}
					}
				}
				for(var field in data.fields){
					if(data.fields[field] != 'id' && data.fields[field] != 'user_id' && data.fields[field].substr(0,7) != 'default'){
						$("#" + model + " tr:last").append("<td>" + data[model][i][data.fields[field]] + "</td>");
					}
					
				}
			}
			tables.assemblyFunctions(data,model);
		},
		cleanFunctions:function(model){
			$("#table" +model+ " .panelFunctions").find('img').remove();
		},
		assemblyFunctions:function(data,model){
			tables.cleanFunctions(model);
			if(typeof(data['Actions']) != undefined){
				if(typeof(data['Actions'].New) != "undefined"){
					$("#table"+model+ " .panelFunctions").append("<img title='Add new' class='imgAction' src=/img/" + data['Actions'].New['icon']+ " onclick=" + data['Actions'].New['onclick'] + " />");
				}
				if(typeof(data['Actions'].SetDefault) != "undefined"){
					$("#table"+model+ " .panelFunctions").append("<img title='Make default' class='imgAction' src=/img/" + data['Actions'].SetDefault['icon']+ " onclick=" + data['Actions'].SetDefault['onclick'] + " />");
				}
				if(typeof(data['Actions'].Delete) != "undefined"){
					$("#table"+model+ " .panelFunctions").append("<img title='Delete' class='imgAction' src=/img/" + data['Actions'].Delete['icon'] + " onclick=" + data['Actions'].Delete['onclick']+ " />");
				}
				if(typeof(data['Actions'].Edit) != "undefined"){
					$("#table"+model+ " .panelFunctions").append("<img title=Edit class='imgAction' src=/img/" + data['Actions'].Edit['icon'] + " onclick=" + data['Actions'].Edit['onclick'] + " />");
				}
			}
		},
		getSelectedLinesCount:function(table){
			var lst = $("#" + table).find("tr");
			j=0;
			for (i=0;i<lst.length;i++){
				if($(lst[i]).hasClass('selected')){
					j=j+1;
				}
			}
			return j;
		},
		getIdSelectedLine:function(table){
			return tables.getSelectedObjTr(table).attr('id');
			var lst = $("#" + table).find("tr");
			j=0;
			for (i=0;i<lst.length;i++){
				if($(lst[i]).hasClass('selected')){
					return $(lst[i]).attr('id'); 
				}
			}
		},
		editSelectedLine:function(table,url){
			if(tables.getSelectedLinesCount(table) != 1){
				alert('One, and only one, record should be selected for this operation.');
			}else{
				window.location = url + "/" + tables.getIdSelectedLine(table);
			}
		},
		//tables.addLine('Files','/file/add')
		addLine:function(table,url){
			window.location = url;
		},
		setDefaultAction:function(table){
			if(tables.getSelectedLinesCount(table) != 1){
				alert('One, and only one, record should be selected for this operation.');
			}else{
				tables.setDefaultObjTr(tables.getSelectedObjTr(table));
			}
		},
		getSelectedObjTr:function(table){
			var lst = $("#" + table).find("tr");
			j=0;
			for (i=0;i<lst.length;i++){
				if($(lst[i]).hasClass('selected')){
					return $(lst[i]); 
				}
			}
		},
		setDefaultObjTr:function(obj,divIdRender){
			var lst = $(' .default');
			//$(obj).removeClass('default');
			$(lst).removeClass('default');
			$.ajax({
				type:'POST',
				url:'/remote/processRequest/setFileDefault/' + $(obj).attr('id'),
				
				dataType: "json"}).done
				(function(response){
					if(response["result"] == 'ok'){
						$(obj).addClass('default');
						
						tables.getFiles(divIdRender);
					}else{
						alert('Something goes wrong. Please try again.');
						
					}
				}).fail(function(response,textStatus){
					alert('Something goes wrong. Please try again.');
				});
			
		},
		
		changeSelection:function(obj){
			//var color = tables.hexToRgb('2E2EFE');
			if($(obj).hasClass('selected')){
				$(obj).removeClass('selected');				
			}else{
				$(obj).addClass('selected');
			}
		},
		hexToRgb : function (hex) {
		    var bigint = parseInt(hex, 16);
		    var r = (bigint >> 16) & 255;
		    var g = (bigint >> 8) & 255;
		    var b = bigint & 255;

		    return r + "," + g + "," + b;
		},
		colorToHex: function (color) {
		    if (color.substr(0, 1) === '#') {
		        return color;
		    }
		    var digits = /(.*?)rgb\((\d+), (\d+), (\d+)\)/.exec(color);
		    
		    var red = parseInt(digits[2]);
		    var green = parseInt(digits[3]);
		    var blue = parseInt(digits[4]);
		    
		    var rgb = blue | (green << 8) | (red << 16);
		    return digits[1] + '#' + rgb.toString(16);
		},
		progress:function(table,data){
			$("#table" + table + " .panelFunctions img").hide();
			$("#table" + table + " .progressOut").show();
			$("#table" + table + " .progressOut .progressIn").css("width",Math.round((tables.tableTotalDeleted/tables.tableTotalToDelete)*100) + "%");
			if(Math.round((tables.tableTotalDeleted/tables.tableTotalToDelete)*100) == 100){
				$("#table" + table + " .panelFunctions img").show();
				$("#table" + table + " .progressOut").hide();
				//tables.getFiles("#tableFile");
				tables.getFiles(tables.getDivRenderId(table));
			}
		},
		deleteSelectedLines:function(table,url){
			var linesToDelete = tables.getSelectedLinesCount(table);
			if(linesToDelete == 0){
				alert('No lines selected.');
			}else{
				if(confirm(linesToDelete + ' line(s) selected to delete. You confirm the operartion?')){
					var qtd_selected_lines = tables.getSelectedLinesCount(table);
					var lst = $("#" + table).find("tr");
					var data = {"table":table,"id":"","qtd_total":qtd_selected_lines,"qtd_processado":0};
					tables.tableTotalToDelete = qtd_selected_lines;
					tables.tableTotalDeleted = 0;
					for(i=0;i<lst.length;i++){
						if($(lst[i]).hasClass('selected')){
							//data.id = $(lst[i]).attr("id");
							data['id'] = $(lst[i]).attr("id");
							tables.deleteSubmit(table,data);
						}
					}
				}
			}
		},
		deleteSubmit:function(table,data){
			tables.progress(table,data);
			url_str = '/remote/processRequest/deleteLine/' + table + "/" + data["id"];
			$.ajax({
				type:'POST',
				url:url_str,				
				dataType: "json"}).done
				(function(response){
					tables.tableTotalDeleted = tables.tableTotalDeleted +1;
					tables.progress(table);					
				}).fail(function(response,textStatus){
					alert('Something goes wrong. Please try again.');
					tables.tableTotalDeleted = tables.tablesTotalToDelete;
					tables.progress(table);
				});
		}
		
} 