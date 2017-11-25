 $(function () {
	var lat="24.747510";
	var lng="121.164850";
	var map = new GMaps({
	  div: '#map_canvas',
	  lat: 24.747510,
	  lng: 121.164850,
	  zoom:12,
	  zoomControl : true,
	});	
	//map.setCenter(lat, lng);
	
		//景點
		$("#button1id").click(function(){
			$.getJSON( '../data/SSCF.php',"Type=all"
				, function(data) {  						
				$.each( data.markers, function(i, marker) {//設定時會影響到中心點				
					var C=map.addMarker({
							  lat: marker.lat,
							  lng: marker.lng,
							  title: marker.title,
							  icon:marker.icon ,
							  infoWindow: {
									content: '<p><b>'+marker.title+'</b><br>'+marker.addr+"<br> lat"+ marker.lat+" lng:"+marker.lng+'</p>'
									}
							});
					});
				});
		});
		//活動
		$("#button2id").click(function(){
			$.getJSON( '../data/SSAF.php',"Type=all"
				, function(data) {  						
				if (data.markers != null) {
				$.each( data.markers, function(i, marker) {//設定時會影響到中心點					
					var A=map.addMarker({
							  lat: marker.lat,
							  lng: marker.lng,
							  title: marker.title,
							  icon:marker.icon ,
							  infoWindow: {
									content: '<p><b>'+marker.title+'</b><br>'+marker.addr+"<br> lat"+ marker.lat+" lng:"+marker.lng+'</p>'
									}
							});
					});
				}
				});
		});
		//餐廳
		$("#button3id").click(function(){
			$.getJSON( '../data/SSRF.php',"Type=all"
				, function(data) {  						
				if (data.markers != null) {
				$.each( data.markers, function(i, marker) {//設定時會影響到中心點					
					var R= map.addMarker({
							  lat: marker.lat,
							  lng: marker.lng,
							  title: marker.title,
							  icon:marker.icon ,
							  infoWindow: {
									content: '<p><b>'+marker.title+'</b><br>'+marker.addr+"<br> lat"+ marker.lat+" lng:"+marker.lng+'</p>'
									}
							});
					});
				}
				});
		});		
		
		//旅館
		$("#button4id").click(function(){
			$.getJSON( '../data/SSHT.php',"Type=all"
				, function(data) {  						
				if (data.markers != null) {
				$.each( data.markers, function(i, marker) {//設定時會影響到中心點					
					var H=map.addMarker({
							  lat: marker.lat,
							  lng: marker.lng,
							  title: marker.title,
							  icon:marker.icon ,
							  infoWindow: {
									content: '<p><b>'+marker.title+'</b><br>'+marker.addr+"<br> lat"+ marker.lat+" lng:"+marker.lng+'</p>'
									}
							});
					});
				}
				});
		});
		
		//wifi
		$("#button6id").click(function(){
			$.getJSON( '../data/WIFI.php',"Type=all"
				, function(data) {  						
				if (data.markers != null) {
				$.each( data.markers, function(i, marker) {					
					var W=map.addMarker({
							  lat: marker.lat,
							  lng: marker.lng,
							  title: marker.title,
							  icon:marker.icon ,
							  infoWindow: {
									content: '<p><b>'+marker.title+'</b><br>'+marker.addr+"<br> lat"+ marker.lat+" lng:"+marker.lng+'<br>'+marker.content+'</p>'
									}
							});
					});
				}
				});
		});
		//交通事故
		$("#button7id").click(function(){
			$.getJSON( '../data/DG.php',"Type=all"
				, function(data) {  						
				if (data.markers != null) {
				$.each( data.markers, function(i, marker) {					
					var W=map.addMarker({
							  lat: marker.lat,
							  lng: marker.lng,
							  title: marker.title,
							  icon:marker.icon ,
							  infoWindow: {
									content: '<p><b>'+marker.title+'</b><br>'+marker.addr+"<br> lat"+ marker.lat+" lng:"+marker.lng+'<br>'+marker.content+'</p>'
									}
							});
					});
				}
				});
		});
$("#button0id").click(function(){
		//站牌
		$.getJSON('../data/BUSSTOP.php',"Type=all"
				, function(data) {  						
					$.each( data.markers, function(i, marker) {//設定時會影響到中心點				
					var S=map.addMarker({
							  lat: marker.lat,
							  lng: marker.lng,
							  title: marker.title,
							  icon:marker.icon ,
								 /* click: function(e) {
									  alert('click:'+marker.addr+" lat"+ marker.lat+" lng:"+marker.lng);
									//$('#map_canvas').gmap('openInfoWindow', {'content': marker.title}, this);
								  },*/
							 infoWindow: {
									content: '<p>路線:<B>'+marker.rname+'</B><BR>站牌:<b>'+marker.title+'</b><br>'+marker.addr+"<br> lat"+ marker.lat+" lng:"+marker.lng+'</p>'
									}	  
							
						});
					var SC=map.drawCircle({
							lat:marker.lat,
							lng:marker.lng,
							radius:1000, //1公里
							fillColor:'#ffccff',
							fillOpacity:0.3,
							strokeColor:'#b300b3',
							strokeOpacity:0.7,
						});
					$("#button5id").click(function(){
						map.removeMarkers();
						SC.setMap(null);		
					})
					});
					
;	
				});
});

	
	});
	
	
