
$(document).ready(function() {
	start();
});



function start(){
	document.body.style.width = "100%";
	document.body.style.width = document.body.clientWidth - 220 + "px";
	
	// $('#navside a').hover(function() {
		// $(this).css({
				// 'color': '#FFF',
			// });
		// },
		// function() {
			// $(this).css({
				// 'color': '#666',
			// });
	// });
	
	$('.nav').click(function() {
		$('#navside ul li a').toggleClass(".activeMenu",false);
		
		$(this).toggleClass(".activeMenu",true);
		setData($(this).attr("id"));
	});
	
	$('#btnP').click(function() {
		setGraphicData("a2g");
	});	
	
	$('#btnD').click(function() {
		setGraphicData("getAllSale");
	});	
	
	$('#exit').click(function() {
		$.ajax({
			url:"exit.php",
			success: function (){}
		});
	});	
	
	
}



function setData(id){
	var urlphp = "/getItem/" + id + ".php";
	
	$("#content").empty();
	
	/*
	switch(id){
		case "a1":
			content = "Продажи";
			break;
		case "a2":
			content = "План";
			break;
		case "a3":
			content = "Писка товаров";
			break;
		case "a4":
			content = "Письмецо в конверте";
			break;
		case "a5":
			content = "Выйти";
			break;
	}
	*/
	
	//192.168.137.1:3306
	//
	var txt="";
	
	var dataTbl = document.createElement("table");
	dataTbl.setAttribute("id","dataTbl");
	var k = document.getElementById("content").appendChild(dataTbl);
	var divPage = document.createElement("div");
	divPage.setAttribute("id","divPage");
	var k = document.getElementById("content").appendChild(divPage);
	//$("#content").append($("#dataTbl"));
	
	// $('#dataTbl').append( $('<tr/>'));
	// $('#dataTbl').append( $('<th/>', {text :1}) );
	// $('#dataTbl').append( $('<th/>', {text :2}) );
	// $('#dataTbl').append( $('<th/>', {text :3}) );
	// $('#dataTbl').append( $('<tr/>'));
	// $('#dataTbl').append( $('<td/>', {text : "dfgfdgfdg"}) );
	// $('#dataTbl').append( $('<td/>', {text : "fdgfdg"}) );
	// $('#dataTbl').append( $('<td/>', {text :"dsdfgfd"}) );
	// var row = "<tr><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th><th>sfdsf</th></tr>"
	// $('#dataTbl').append(row);
	
	$.ajax({
       type: "POST",
       url: urlphp,
	   async:false,
       dataType: "json",
       success: function(data)
       {
		   
		   
		   // $.each(data, function(arrayID,group) {
						// console.log('<a href="'+group.GROUP_ID+'">');
				// $.each(group.EVENTS, function(eventID,eventData) {
						// console.log('<p>'+eventData.SHORT_DESC+'</p>');
				 // });
			// });
			

			
		    var forTh = data[0];
		   	   
		   //$('#dataTbl').append( $('<tr/>'));
		    var row = "<tr>"
		    for (var key in forTh) {
				  if (forTh.hasOwnProperty(key)) {
					row += "<th>" + key + "</th>"
					//$('#dataTbl').append( $('<th/>', {text : key}) );
				  }
			}
			row += "</tr>"
			$('#dataTbl').append(row);
			
		    jQuery.each(data, function(obj) {
			    var p = data[obj];
				var row = "<tr>"
				//$('#dataTbl').append( $('<tr/>'));
				for (var key in p) {
				  if (p.hasOwnProperty(key)) {
					  row += "<td>" + p[key] + "</td>"
					//$('#dataTbl').append( $('<td/>', {text : p[key]}) );
					txt += key + " -> " + p[key];
				  }
				}
				row += "</tr>"
				$('#dataTbl').append(row);
				txt += "\n";
			});
			
			
			//$("#content").text(txt);
		   
       }
     });

	
	
	/*
	jQuery("#dataTbl").jqGrid({
		url:urlphp,
		datatype: "json",
		colNames:['Номер продажи','Дата продажи','Что продал','Количество','На сумму'],
		colModel:[
			{name:'Sale_Number',index:'id', width:55},
			{name:'Sale_date',index:'invdate', width:90},
			{name:'What did you sale',index:'name asc, invdate', width:100},
			{name:'Count',index:'amount', width:80, align:"right"},
			{name:'How_much_money',index:'tax', width:80, align:"right"}		
		],
		rowNum:10,
		rowList:[10,20,30],
		pager: '#divPage',
		sortname: 'Sale_Number',
		viewrecords: true,
		sortorder: "desc",
		caption:"JSON Example"
	});
	jQuery("#dataTbl").jqGrid('navGrid','#divPage',{edit:false,add:false,del:false});
	*/
}

function setGraphicData(id){
	
	// switch(id){
		// case "btnSC":
			// content = "Продажи";
			// break;
		// case "btnSC":
			// content = "";
			// break;
		// case "btnD":
			// content = "План";
			// break;
		// case "btnA":
			// content = "";
			// break;
		
	// }
	setData(id);
	
	$(function () {
		$('#content').highcharts({
			data: {
				table: 'dataTbl'
			},
			chart: {
				type: 'column'
			},
			title: {
				text: ''
			},
			yAxis: {
				allowDecimals: false,
				title: {
					text: 'Rubles'
				}
			},
			tooltip: {
				formatter: function () {
					return '<b>' + this.series.name + '</b><br/>' +
						this.point.y + ' ' + this.point.name.toLowerCase();
				}
			}
		});
	
	});
	
}

