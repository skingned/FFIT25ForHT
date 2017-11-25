 $(function () {
		var opok=0;
		var	myvill;//地圖資料載入//目前位置
		var myzipcode;		
		var map;
		var zoom;		
	
				//左鍵
		var clickfun=function(title,content,marker){
			menucontent='<div><b>【'+title+'】</b><hr><p>'+content+'</p></div>';			
			$('#map_canvas').gmap('openInfoWindow', {'content': menucontent},marker);			
		};
				//右鍵出選單
		var rightMenu=function(id,obj,latx,lngx){
			//var mapa = new google.maps.Map($('#map_canvas'));
			//menucontent='<div><b>【選項】</b><hr><ul><li><a href="#">導航</a></li><li><a href="#">回報</a></li></ul></div>';
			
			var mapa; //要設定目前所在位置做為起點,不然圖上不會顯示<==請查問題
			
			if (confirm("導航?"+$("#localx").val())) {
			//$('#map_canvas').gmap('openInfoWindow', {'content': menucontent},obj);
			//導航
								var directionsService = new google.maps.DirectionsService;
								var directionsDisplay = new google.maps.DirectionsRenderer;								
								directionsDisplay.setMap(mapa);
								
								var calculateAndDisplayRoute=function(directionsService, directionsDisplay,lat,lng) {			  
								  var end = lat +", "+ lng;
								  directionsService.route({
									origin: $("#localx").val(), //開始位置
									destination: end ,// marker.addr,//使用座標才不會跑掉
									travelMode: google.maps.TravelMode.DRIVING
								  }, function(response, status) {
									if (status === google.maps.DirectionsStatus.OK) {
										//directionsDisplay.setMap(null);
										//console.log(response);
									  directionsDisplay.setDirections(response);//導航
									  
										var eleV= $('#panel_f').lightbox_me({//路徑
											centered: true, 
											onLoad: function() { 
											directionsDisplay.setPanel(document.getElementById('panel'));//顯示路徑
												//close
												 $("#BTNP_NG").click(function(){
													eleV.trigger('close');
												 });
												 $(".close").click(function(){
													eleV.trigger('close');
												 });
											}
										});
									} else {
									 // console.log('Directions request failed due to ' + status);
									}
								  });
								}								
								calculateAndDisplayRoute(directionsService, directionsDisplay,latx,lngx);/**/	
			}else{
				//回報
				alert("回報");
			}								
		};
		
		
	
		//查消防隊
		if ($("#cb_fire").prop("checked")){
			$.getJSON("../data/fire.php","zipcode="+$('[name="zipcode"]').val()+'&k='+k,function(data){
				if(data.fire === null) { 
				}else{ // skip nulls
					$("#myfire").html("【消防隊】<br>");					
					$.each(data.fire,function(i,c){					
						$("#myfire").append('<button class="btn btn-success" style="float:right">導航</button>'+c.name+" 電話："+c.tel +"<br>地址："+c.address+"<hr>");
						$('#map_canvas').gmap('addMarker', { 
										'position': new google.maps.LatLng(c.lat, c.lng), 
										'bounds': false,//true ,							
										'mapTypeId': google.maps.MapTypeId.ROADMAP, 								
										'center': new google.maps.LatLng(c.lat, c.lng),
										'title': c.name ,//$("#villname option:selected").text(),
										'icon': "../images/icon/firemen_1.png",
								}).click(function() {
									clickfun(c.name,"電話："+c.tel +"<br>地址："+c.address,this);									 
								}).rightclick(function(){									
									rightMenu(c.id,this,c.lat,c.lng);									
								});		
					});
				}
			});		
		}		
		//查應變中心
		if ($("#cb_center").prop("checked")){
		$.getJSON("../data/center.php","zipcode="+$('[name="zipcode"]').val()+'&k='+k,function(data){
			if(data.center === null) { // skip nulls
			}else{
				$("#mycenter").html("【應變中心】<br>");
				$.each(data.center,function(i,c){
					//if(c === null) { return; } // skip nulls
					$("#mycenter").append('<button class="btn btn-success" style="float:right">導航</button>'+c.name+" 電話："+c.tel +"<br>地址："+c.address+"<hr>");
					$('#map_canvas').gmap('addMarker', { 
									'position': new google.maps.LatLng(c.lat, c.lng), 
									'bounds': false,//true ,							
									'mapTypeId': google.maps.MapTypeId.ROADMAP, 								
									'center': new google.maps.LatLng(c.lat, c.lng),
									'title': c.name ,//$("#villname option:selected").text(),
									'icon': "../images/icon/firemen_2.png",
								}).click(function() {
									clickfun(c.name,"電話："+c.tel +"<br>地址："+c.address,this);									 
								}).rightclick(function(){									
									rightMenu(c.id,this,c.lat,c.lng);									
								});					
				});
			} 
			});
		}	
		//查公園
		if ($("#cb_park").prop("checked")){
		$.getJSON("../data/park.php","zipcode="+$('[name="zipcode"]').val()+'&k='+k,function(data){
			if(data.park === null) { // skip nulls
			}else{
				//$("#mycenter").html("【應變中心】<br>");
				$.each(data.park,function(i,c){
					//if(c === null) { return; } // skip nulls
					//$("#mycenter").append('<button class="btn btn-success" style="float:right">導航</button>'+c.name+" 電話："+c.tel +"<br>地址："+c.address+"<hr>");
					$('#map_canvas').gmap('addMarker', { 
									'position': new google.maps.LatLng(c.lat, c.lng), 
									'bounds': false,//true ,							
									'mapTypeId': google.maps.MapTypeId.ROADMAP, 								
									'center': new google.maps.LatLng(c.lat, c.lng),
									'title': c.name ,//$("#villname option:selected").text(),
									'icon': "../images/icon/quadrifoglio.png",
								}).click(function() {
									clickfun(c.name,"電話："+c.tel +"<br>地址："+c.address,this);									 
								}).rightclick(function(){									
									rightMenu(c.id,this,c.lat,c.lng);
								});					
				});
			} 
			});
		}				
		//查店家
		if ($("#cb_store").prop("checked")){
		$.getJSON("../data/store.php","zipcode="+$('[name="zipcode"]').val()+'&k='+k,function(data){
			if(data.store === null) { // skip nulls
			}else{
				//$("#mycenter").html("【店家】<br>");
				$.each(data.store,function(i,c){
					//if(c === null) { return; } // skip nulls
					//$("#mycenter").append('<button class="btn btn-success" style="float:right">導航</button>'+c.name+" 電話："+c.tel +"<br>地址："+c.address+"<hr>");
					$('#map_canvas').gmap('addMarker', { 
									'position': new google.maps.LatLng(c.lat, c.lng), 
									'bounds': false,//true ,							
									'mapTypeId': google.maps.MapTypeId.ROADMAP, 								
									'center': new google.maps.LatLng(c.lat, c.lng),
									'title': "【"+ c.stname+"】"+c.sname  ,//$("#villname option:selected").text(),
									'icon': c.icon,
								}).click(function() {
									clickfun(c.sname,c.sname+"<br>電話："+c.tel +"<br>地址："+c.address,this);									 
								}).rightclick(function(){									
									rightMenu(c.id,this,c.lat,c.lng);									
								});					
				});
			} 
			});
		}		
		//查醫院診所
		if ($("#cb_hspt").prop("checked")){
		$.getJSON("../data/hspt.php","zipcode="+$('[name="zipcode"]').val()+'&k='+k,function(data){
			if(data.hspt === null) { // skip nulls
			}else{
				//$("#mycenter").html("【店家】<br>");
				$.each(data.hspt,function(i,c){
					//if(c === null) { return; } // skip nulls
					//$("#mycenter").append('<button class="btn btn-success" style="float:right">導航</button>'+c.name+" 電話："+c.tel +"<br>地址："+c.address+"<hr>");
					$('#map_canvas').gmap('addMarker', { 
									'position': new google.maps.LatLng(c.lat, c.lng), 
									'bounds': false,//true ,							
									'mapTypeId': google.maps.MapTypeId.ROADMAP, 								
									'center': new google.maps.LatLng(c.lat, c.lng),
									'title': "【"+ c.name+"】"  ,//$("#villname option:selected").text(),
									'icon': c.icon,
								}).click(function() {
									clickfun(c.name,"地址："+c.address,this);									 
								}).rightclick(function(){									
									rightMenu(c.id,this,c.lat,c.lng);									
								});						
				});
			} 
			});
		}
		//查學校
		if ($("#cb_school").prop("checked")){
		$.getJSON("../data/school.php","zipcode="+$('[name="zipcode"]').val()+'&k='+k,function(data){
			if(data.school === null) { // skip nulls
			}else{
				//$("#mycenter").html("【學校】<br>");
				$.each(data.school,function(i,c){
					//if(c === null) { return; } // skip nulls
					//$("#mycenter").append('<button class="btn btn-success" style="float:right">導航</button>'+c.name+" 電話："+c.tel +"<br>地址："+c.address+"<hr>");
					$('#map_canvas').gmap('addMarker', { 
									'position': new google.maps.LatLng(c.lat, c.lng), 
									'bounds': false,//true ,							
									'mapTypeId': google.maps.MapTypeId.ROADMAP, 								
									'center': new google.maps.LatLng(c.lat, c.lng),
									'title': "【"+ c.name+"】"  ,//$("#villname option:selected").text(),
									'icon': c.icon,
								}).click(function() {
									clickfun(c.name,"電話："+c.tel +"<br>地址："+c.address,this);									 
								}).rightclick(function(){									
									rightMenu(c.id,this,c.lat,c.lng);									
								});					
				});
			} 
			});
		}

			

//========================		
	
			
		
		
		//重新查詢
		$("#findit").click(function(){				
			findcand();
		});
	var loadMAP = function(){            
			/*var k=$("#keypoint").val();
			var addr=$("#addr").val();			
			var county=$('[name="county"]').val();			var zipcode=$('[name="zipcode"]').val();			var district=$('[name="district"]').val(); //取值
			//==========
			var type1=$('input[name="checkboxes_0"]:checked').val();
			if (typeof type1 === "undefined") {
				type1=0;
			}
			var type2=$('input[name="checkboxes_1"]:checked').val();
			if (typeof type2 === "undefined") {
				type2=0;
			}*/			
				map=$('#map_canvas').gmap({"zoom":12, "center": new google.maps.LatLng(24.8000863,121.1760001)}).bind('init', function(ev, mapa) { 
			//default load 的kml(暫無)
		/*	var kmlArray={//一次太多會慢
				"foo": "https://sites.google.com/site/kmlsharing/taiwan-kml/taiwan.kml?attredirects=0&d=1",//台灣防災地圖
				"foo1": "https://alerts.ncdr.nat.gov.tw/DownLoadNewAssistData.ashx/1", //中央氣象局颱風路徑及預報
				"flb": "http://gic.wra.gov.tw/gic/API/Google/DownLoad.aspx?fname=FLOBLOCK",	//防汛備料地點	
				"trv": "http://sites.google.com/site/wei1234c/home/gps/01Waypoints.kmz", //tw 景點		
			};
			$.each(kmlArray,function (i,urlv){
				KMLLoad(i,urlv,mapa);
			});
			*/

	//===========================

		//天文氣像
		$("#cwp_btn").change(function() {	
		if($(this).is(":checked")) {
			//套圖	(把圖貼在地圖上的方法)		
			 var imageBounds = new google.maps.LatLngBounds(
					new google.maps.LatLng(19.7,117.30),//從其西南角和東北角的點構造一個矩形。
					new google.maps.LatLng(27.2,124.8)
			);
			var overlayOpts = {
				opacity:0.5   //圖的透明度
			};
			//雷達回波圖 http://opendata.cwb.gov.tw/opendata/DIV4/O-A0011-001.xml
			historicalOverlay = new google.maps.GroundOverlay('http://opendata.cwb.gov.tw/opendata/DIV4/O-A0011-001.jpg',
				imageBounds, overlayOpts).setMap(mapa);
			//中文彩色合成地面天氣圖 http://opendata.cwb.gov.tw/opendata/MFC/F-C0035-001.xml
			//historicalOverlay2 = new google.maps.GroundOverlay('http://opendata.cwb.gov.tw/opendata/MFC/F-C0035-001.jpg',			
			//	imageBounds, overlayOpts).setMap(mapa);
			}else{
			}
		});	
	
//=====================action=================================		
						//zoom 變更時的動作						
						mapa.addListener('zoom_changed', function() {
							//zoom= mapa.getZoom();
							//console.log(mapa.getZoom());
							//get it 
						});
//======================================================================						
			
			$("#button2id").click(function(){
				var eleV= $('#online_rep').lightbox_me({
					centered: true, 
					onLoad: function() { 
					//close
						$("#ol_close").click(function(){
							eleV.trigger('close');
						});
					//save
						$("#ol_save").click(function(){
							//存檔
							//xajax_SaveOL(xajax.getFormValues('ol')); //無法抓到xajax??
							eleV.trigger('close');
						});
					}
					});
			});

		

				
				
				$.getJSON( '../data/SSCF.php',
							"Type=all"
						, function(data) {  
						
				$.each( data.markers, function(i, marker) {//設定時會影響到中心點
						$('#map_canvas').gmap('addMarker', { 
							'position': new google.maps.LatLng(marker.lat, marker.lng), 
							'bounds':false,// true ,						
							'mapTypeId': google.maps.MapTypeId.ROADMAP, 						
							'center': new google.maps.LatLng(lat, lng),
							'title': marker.title,
							'icon': marker.icon ,		
						}).click(function(e) {
							//週邊座標的也要開?
							  $('#map_canvas').gmap('openInfoWindow', {'content': marker.title}, this); 
						   });
					});
				});
				
				$.getJSON( '../data/BUSSTOP.php',
							"Type=all"
						, function(data) {  
						
				$.each( data.markers, function(i, marker) {//設定時會影響到中心點
				
					map.addMarker({
					  lat: -12.043333,
					  lng: -77.028333,
					  title: 'Lima',
					  click: function(e) {
						alert('You clicked in this marker');
					  }
					});
				
						$('#map_canvas').gmap('addMarker', { 
							'position': new google.maps.LatLng(marker.lat, marker.lng), 
							'bounds':false,// true ,						
							'mapTypeId': google.maps.MapTypeId.ROADMAP, 						
							'center': new google.maps.LatLng(lat, lng),
							'title': marker.title,
							'icon': marker.icon ,		
						}).click(function(e) {
							//週邊座標的也要開?
							  $('#map_canvas').gmap('openInfoWindow', {'content': marker.title}, this); 
						   }).rightclick(function(){
								//右鍵要做什麼?
									rightMenu(marker.title,this,marker.lat,marker.lng);									
								});
					});
				});
				 // Drawing polyline on map
				/*	$('#map_canvas').gmap('addShape', 'Polyline', {
						'path':[
								  {'latitude':37.772323,'longitude':-122.214897},
								  {'latitude':21.291982,'longitude':-157.821856},
								  {'latitude':-18.142599,'longitude':178.431000},
								  {'latitude':-27.467580,'longitude':153.027892}
								],
						'strokeColor': '#c00',
						'strokeThickness': 5
					});*/
					
					
					/*$('#map_canvas').gmap("Polyline",{
					'strokeColor': "#FF0000",
					'strokeOpacity': 1.0,
					'strokeWeight': 2,
					'path': [
					  {'latitude':37.772323,'longitude':-122.214897},
					  {'latitude':21.291982,'longitude':-157.821856},
					  {'latitude':-18.142599,'longitude':178.431000},
					  {'latitude':-27.467580,'longitude':153.027892}
					]
				  });*/
				/*
				var map = new google.maps.Map(document.getElementById('map_canvas'), {
				  zoom: 3,
				  center: {lat: 0, lng: -180},
				  mapTypeId: 'terrain'
				});

				var flightPlanCoordinates = [
				  {lat: 37.772, lng: -122.214},
				  {lat: 21.291, lng: -157.821},
				  {lat: -18.142, lng: 178.431},
				  {lat: -27.467, lng: 153.027}
				];
				var flightPath = new google.maps.Polyline({
				  path: flightPlanCoordinates,
				  geodesic: true,
				  strokeColor: '#FF0000',
				  strokeOpacity: 1.0,
				  strokeWeight: 2
				});

				flightPath.setMap(map);
				*/
				
				
			}).gmap('addMarker',{'position': lat+','+lng, 'bounds': false,"zoom":10});//加上所在地點標計
					
			}
		

		
		 //預設座標yt
            var lat = "24.9840712";
            var lng = "121.53967729999998";
        
            window.addEventListener("DOMContentLoaded", contentLoaded, false);
           
			loadMAP();//載入地圖
			
            function successCallback(position) {
               // var result = document.getElementById('result');
                lat = position.coords.latitude;
                lng = position.coords.longitude;
				 // 將經緯度透過 Google map Geocoder API 反查地址
					geocoder = new google.maps.Geocoder();
					geocoder.geocode({
					  'latLng': {"lat": lat, "lng": lng},
					}, function(results, status) {
						if (status === google.maps.GeocoderStatus.OK) {
							if (results) {								
								results=results[0];
								$.each(results.address_components,function(k,v){
									$.each(v,function(kv,vv){//查出型態 //存下來,並設定村里,zipcode=>設定目前位置用
									if (vv=='administrative_area_level_4,political'){
											myvill=v["short_name"].trim();//取得里
										}
									if (vv=='postal_code'){
											myzipcode=v["short_name"].trim();//取得zipcode
										}
									});
									
								});	
								$("#localx").val(results.formatted_address);
								var html= '<i class="fa fa-map-marker"> </i> '+"目前所在位置   " +
								"緯度：" + position.coords.latitude +
								", 經度：" + position.coords.longitude +
								", 精確度：" + position.coords.accuracy +
								", 時間戳記：" + position.timestamp +"<BR>【地址："+ results.formatted_address+"("+myvill+")】";//+results[0].address_components.short_name+")";
								
							//	result.innerHTML =html;
								$("#mylocal").html(html);
							}
						} else {
							alert("Reverse Geocoding failed because: " + status);
						}
					});
            }
			
            function errorCallback(error) {
                if (error.code != 1)
                    alert('執行發生錯誤! 錯誤代碼 :' + error.code + ', 錯誤訊息 :' + error.message);
            }
            function contentLoaded() {
				if (navigator.geolocation) { 
                    navigator.geolocation.getCurrentPosition(successCallback, errorCallback); //只抓取當下一次
					//navigator.geolocation.watchPosition(successCallback, errorCallback);//會一直偵測是否有移動(與上二選一)
					//navigator.geolocation.clearWatch();//叫用停止偵測
                } else {
                    alert("你的瀏覽器不支援 geolocation!!");
                }
            }	

	////////目前位置 帶入
	/*$("#location").click(function(){
		//alert(myvill);
		$('#twzipcode').twzipcode('set', myzipcode);
		 villop();		 
		//因為選項是空的.....
		//for(i=0;i<50000;i++){//少村里的處理
			if (myvill.length > 0 && opok==1){//設定成為選項				
				$('#villname option[text="'+ myvill +'"]').attr('selected','selected');	//要再找問題					
			}
		//}	
	});	
	
	
		
	 //設定定時更新防災資訊
	 setInterval( function () {
		alertnews.ajax.reload();
	 }, 300000 );//5 min => /60000 取得資料的掃瞄程式請連動 =>2017/data/index.php*/
	//==================================
	
	$("#clearMap").click(function(){		
		$('#map_canvas').gmap('clear', 'markers'); //清標點
		$('#map_canvas').gmap('get','overlays>WRAWarm').setMap(null);//清空
	});
	
	
	});
	
	
