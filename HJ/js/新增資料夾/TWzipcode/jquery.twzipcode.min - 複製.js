/*! jQuery tinyMap v1.7.9, Licensed MIT (c) essoduke.org | https://code.essoduke.org/twzipcode/ */
(function(f,n,p,q){function m(b,a){this.container=f(b);this.options=f.extend({},{countyName:"county",css:[],detect:!1,districtName:"district",googleMapsKey:"",hideCounty:[],hideDistrict:[],onCountySelect:null,onDistrictSelect:null,onZipcodeKeyUp:null,readonly:!1,zipcodeName:"zipcode",zipcodePlaceholder:"\u90f5\u905e\u5340\u865f",zipcodeIntoDistrict:!1},a);this.init()}var d={"\u57fa\u9686\u5e02":{"\u4ec1\u611b\u5340":"200","\u4fe1\u7fa9\u5340":"201","\u4e2d\u6b63\u5340":"202","\u4e2d\u5c71\u5340":"203",
"\u5b89\u6a02\u5340":"204","\u6696\u6696\u5340":"205","\u4e03\u5835\u5340":"206"},"\u53f0\u5317\u5e02":{"\u4e2d\u6b63\u5340":"100","\u5927\u540c\u5340":"103","\u4e2d\u5c71\u5340":"104","\u677e\u5c71\u5340":"105","\u5927\u5b89\u5340":"106","\u842c\u83ef\u5340":"108","\u4fe1\u7fa9\u5340":"110","\u58eb\u6797\u5340":"111","\u5317\u6295\u5340":"112","\u5167\u6e56\u5340":"114","\u5357\u6e2f\u5340":"115","\u6587\u5c71\u5340":"116"},"\u65b0\u5317\u5e02":{"\u842c\u91cc\u5340":"207","\u91d1\u5c71\u5340":"208",
"\u677f\u6a4b\u5340":"220","\u6c50\u6b62\u5340":"221","\u6df1\u5751\u5340":"222","\u77f3\u7887\u5340":"223","\u745e\u82b3\u5340":"224","\u5e73\u6eaa\u5340":"226","\u96d9\u6eaa\u5340":"227","\u8ca2\u5bee\u5340":"228","\u65b0\u5e97\u5340":"231","\u576a\u6797\u5340":"232","\u70cf\u4f86\u5340":"233","\u6c38\u548c\u5340":"234","\u4e2d\u548c\u5340":"235","\u571f\u57ce\u5340":"236","\u4e09\u5cfd\u5340":"237","\u6a39\u6797\u5340":"238","\u9daf\u6b4c\u5340":"239","\u4e09\u91cd\u5340":"241","\u65b0\u838a\u5340":"242",
"\u6cf0\u5c71\u5340":"243","\u6797\u53e3\u5340":"244","\u8606\u6d32\u5340":"247","\u4e94\u80a1\u5340":"248","\u516b\u91cc\u5340":"249","\u6de1\u6c34\u5340":"251","\u4e09\u829d\u5340":"252","\u77f3\u9580\u5340":"253"},"\u5b9c\u862d\u7e23":{"\u5b9c\u862d\u5e02":"260","\u982d\u57ce\u93ae":"261","\u7901\u6eaa\u9109":"262","\u58ef\u570d\u9109":"263","\u54e1\u5c71\u9109":"264","\u7f85\u6771\u93ae":"265","\u4e09\u661f\u9109":"266","\u5927\u540c\u9109":"267","\u4e94\u7d50\u9109":"268","\u51ac\u5c71\u9109":"269",
"\u8607\u6fb3\u93ae":"270","\u5357\u6fb3\u9109":"272","\u91e3\u9b5a\u53f0\u5217\u5dbc":"290"},"\u65b0\u7af9\u5e02":{"\u6771\u5340":"300","\u5317\u5340":"300","\u9999\u5c71\u5340":"300"},"\u65b0\u7af9\u7e23":{"\u7af9\u5317\u5e02":"302","\u6e56\u53e3\u9109":"303","\u65b0\u8c50\u9109":"304","\u65b0\u57d4\u93ae":"305","\u95dc\u897f\u93ae":"306","\u828e\u6797\u9109":"307","\u5bf6\u5c71\u9109":"308","\u7af9\u6771\u93ae":"310","\u4e94\u5cf0\u9109":"311","\u6a6b\u5c71\u9109":"312","\u5c16\u77f3\u9109":"313",
"\u5317\u57d4\u9109":"314","\u5ce8\u5d4b\u9109":"315"},"\u6843\u5712\u5e02":{"\u4e2d\u58e2\u5340":"320","\u5e73\u93ae\u5340":"324","\u9f8d\u6f6d\u5340":"325","\u694a\u6885\u5340":"326","\u65b0\u5c4b\u5340":"327","\u89c0\u97f3\u5340":"328","\u6843\u5712\u5340":"330","\u9f9c\u5c71\u5340":"333","\u516b\u5fb7\u5340":"334","\u5927\u6eaa\u5340":"335","\u5fa9\u8208\u5340":"336","\u5927\u5712\u5340":"337","\u8606\u7af9\u5340":"338"},"\u82d7\u6817\u7e23":{"\u7af9\u5357\u93ae":"350","\u982d\u4efd\u5e02":"351",
"\u4e09\u7063\u9109":"352","\u5357\u5e84\u9109":"353","\u7345\u6f6d\u9109":"354","\u5f8c\u9f8d\u93ae":"356","\u901a\u9704\u93ae":"357","\u82d1\u88e1\u93ae":"358","\u82d7\u6817\u5e02":"360","\u9020\u6a4b\u9109":"361","\u982d\u5c4b\u9109":"362","\u516c\u9928\u9109":"363","\u5927\u6e56\u9109":"364","\u6cf0\u5b89\u9109":"365","\u9285\u947c\u9109":"366","\u4e09\u7fa9\u9109":"367","\u897f\u6e56\u9109":"368","\u5353\u862d\u93ae":"369"},"\u53f0\u4e2d\u5e02":{"\u4e2d\u5340":"400","\u6771\u5340":"401","\u5357\u5340":"402",
"\u897f\u5340":"403","\u5317\u5340":"404","\u5317\u5c6f\u5340":"406","\u897f\u5c6f\u5340":"407","\u5357\u5c6f\u5340":"408","\u592a\u5e73\u5340":"411","\u5927\u91cc\u5340":"412","\u9727\u5cf0\u5340":"413","\u70cf\u65e5\u5340":"414","\u8c50\u539f\u5340":"420","\u540e\u91cc\u5340":"421","\u77f3\u5ca1\u5340":"422","\u6771\u52e2\u5340":"423","\u548c\u5e73\u5340":"424","\u65b0\u793e\u5340":"426","\u6f6d\u5b50\u5340":"427","\u5927\u96c5\u5340":"428","\u795e\u5ca1\u5340":"429","\u5927\u809a\u5340":"432",
"\u6c99\u9e7f\u5340":"433","\u9f8d\u4e95\u5340":"434","\u68a7\u68f2\u5340":"435","\u6e05\u6c34\u5340":"436","\u5927\u7532\u5340":"437","\u5916\u57d4\u5340":"438","\u5927\u5b89\u5340":"439"},"\u5f70\u5316\u7e23":{"\u5f70\u5316\u5e02":"500","\u82ac\u5712\u9109":"502","\u82b1\u58c7\u9109":"503","\u79c0\u6c34\u9109":"504","\u9e7f\u6e2f\u93ae":"505","\u798f\u8208\u9109":"506","\u7dda\u897f\u9109":"507","\u548c\u7f8e\u93ae":"508","\u4f38\u6e2f\u9109":"509","\u54e1\u6797\u5e02":"510","\u793e\u982d\u9109":"511",
"\u6c38\u9756\u9109":"512","\u57d4\u5fc3\u9109":"513","\u6eaa\u6e56\u93ae":"514","\u5927\u6751\u9109":"515","\u57d4\u9e7d\u9109":"516","\u7530\u4e2d\u93ae":"520","\u5317\u6597\u93ae":"521","\u7530\u5c3e\u9109":"522","\u57e4\u982d\u9109":"523","\u6eaa\u5dde\u9109":"524","\u7af9\u5858\u9109":"525","\u4e8c\u6797\u93ae":"526","\u5927\u57ce\u9109":"527","\u82b3\u82d1\u9109":"528","\u4e8c\u6c34\u9109":"530"},"\u5357\u6295\u7e23":{"\u5357\u6295\u5e02":"540","\u4e2d\u5bee\u9109":"541","\u8349\u5c6f\u93ae":"542",
"\u570b\u59d3\u9109":"544","\u57d4\u91cc\u93ae":"545","\u4ec1\u611b\u9109":"546","\u540d\u9593\u9109":"551","\u96c6\u96c6\u93ae":"552","\u6c34\u91cc\u9109":"553","\u9b5a\u6c60\u9109":"555","\u4fe1\u7fa9\u9109":"556","\u7af9\u5c71\u93ae":"557","\u9e7f\u8c37\u9109":"558"},"\u5609\u7fa9\u5e02":{"\u6771\u5340":"600","\u897f\u5340":"600"},"\u5609\u7fa9\u7e23":{"\u756a\u8def\u9109":"602","\u6885\u5c71\u9109":"603","\u7af9\u5d0e\u9109":"604","\u963f\u91cc\u5c71":"605","\u4e2d\u57d4\u9109":"606","\u5927\u57d4\u9109":"607",
"\u6c34\u4e0a\u9109":"608","\u9e7f\u8349\u9109":"611","\u592a\u4fdd\u5e02":"612","\u6734\u5b50\u5e02":"613","\u6771\u77f3\u9109":"614","\u516d\u8173\u9109":"615","\u65b0\u6e2f\u9109":"616","\u6c11\u96c4\u9109":"621","\u5927\u6797\u93ae":"622","\u6eaa\u53e3\u9109":"623","\u7fa9\u7af9\u9109":"624","\u5e03\u888b\u93ae":"625"},"\u96f2\u6797\u7e23":{"\u6597\u5357\u93ae":"630","\u5927\u57e4\u9109":"631","\u864e\u5c3e\u93ae":"632","\u571f\u5eab\u93ae":"633","\u8912\u5fe0\u9109":"634","\u6771\u52e2\u9109":"635",
"\u81fa\u897f\u9109":"636","\u5d19\u80cc\u9109":"637","\u9ea5\u5bee\u9109":"638","\u6597\u516d\u5e02":"640","\u6797\u5167\u9109":"643","\u53e4\u5751\u9109":"646","\u83bf\u6850\u9109":"647","\u897f\u87ba\u93ae":"648","\u4e8c\u5d19\u9109":"649","\u5317\u6e2f\u93ae":"651","\u6c34\u6797\u9109":"652","\u53e3\u6e56\u9109":"653","\u56db\u6e56\u9109":"654","\u5143\u9577\u9109":"655"},"\u53f0\u5357\u5e02":{"\u4e2d\u897f\u5340":"700","\u6771\u5340":"701","\u5357\u5340":"702","\u5317\u5340":"704","\u5b89\u5e73\u5340":"708",
"\u5b89\u5357\u5340":"709","\u6c38\u5eb7\u5340":"710","\u6b78\u4ec1\u5340":"711","\u65b0\u5316\u5340":"712","\u5de6\u93ae\u5340":"713","\u7389\u4e95\u5340":"714","\u6960\u897f\u5340":"715","\u5357\u5316\u5340":"716","\u4ec1\u5fb7\u5340":"717","\u95dc\u5edf\u5340":"718","\u9f8d\u5d0e\u5340":"719","\u5b98\u7530\u5340":"720","\u9ebb\u8c46\u5340":"721","\u4f73\u91cc\u5340":"722","\u897f\u6e2f\u5340":"723","\u4e03\u80a1\u5340":"724","\u5c07\u8ecd\u5340":"725","\u5b78\u7532\u5340":"726","\u5317\u9580\u5340":"727",
"\u65b0\u71df\u5340":"730","\u5f8c\u58c1\u5340":"731","\u767d\u6cb3\u5340":"732","\u6771\u5c71\u5340":"733","\u516d\u7532\u5340":"734","\u4e0b\u71df\u5340":"735","\u67f3\u71df\u5340":"736","\u9e7d\u6c34\u5340":"737","\u5584\u5316\u5340":"741","\u5927\u5167\u5340":"742","\u5c71\u4e0a\u5340":"743","\u65b0\u5e02\u5340":"744","\u5b89\u5b9a\u5340":"745"},"\u9ad8\u96c4\u5e02":{"\u65b0\u8208\u5340":"800","\u524d\u91d1\u5340":"801","\u82d3\u96c5\u5340":"802","\u9e7d\u57d5\u5340":"803","\u9f13\u5c71\u5340":"804",
"\u65d7\u6d25\u5340":"805","\u524d\u93ae\u5340":"806","\u4e09\u6c11\u5340":"807","\u6960\u6893\u5340":"811","\u5c0f\u6e2f\u5340":"812","\u5de6\u71df\u5340":"813","\u4ec1\u6b66\u5340":"814","\u5927\u793e\u5340":"815","\u6771\u6c99\u7fa4\u5cf6":"817","\u5357\u6c99\u7fa4\u5cf6":"819","\u5ca1\u5c71\u5340":"820","\u8def\u7af9\u5340":"821","\u963f\u84ee\u5340":"822","\u7530\u5bee\u5340":"823","\u71d5\u5de2\u5340":"824","\u6a4b\u982d\u5340":"825","\u6893\u5b98\u5340":"826","\u5f4c\u9640\u5340":"827","\u6c38\u5b89\u5340":"828",
"\u6e56\u5167\u5340":"829","\u9cf3\u5c71\u5340":"830","\u5927\u5bee\u5340":"831","\u6797\u5712\u5340":"832","\u9ce5\u677e\u5340":"833","\u5927\u6a39\u5340":"840","\u65d7\u5c71\u5340":"842","\u7f8e\u6fc3\u5340":"843","\u516d\u9f9c\u5340":"844","\u5167\u9580\u5340":"845","\u6749\u6797\u5340":"846","\u7532\u4ed9\u5340":"847","\u6843\u6e90\u5340":"848","\u90a3\u746a\u590f\u5340":"849","\u8302\u6797\u5340":"851","\u8304\u8423\u5340":"852"},"\u5c4f\u6771\u7e23":{"\u5c4f\u6771\u5e02":"900","\u4e09\u5730\u9580\u9109":"901",
"\u9727\u81fa\u9109":"902","\u746a\u5bb6\u9109":"903","\u4e5d\u5982\u9109":"904","\u91cc\u6e2f\u9109":"905","\u9ad8\u6a39\u9109":"906","\u9e7d\u57d4\u9109":"907","\u9577\u6cbb\u9109":"908","\u9e9f\u6d1b\u9109":"909","\u7af9\u7530\u9109":"911","\u5167\u57d4\u9109":"912","\u842c\u4e39\u9109":"913","\u6f6e\u5dde\u93ae":"920","\u6cf0\u6b66\u9109":"921","\u4f86\u7fa9\u9109":"922","\u842c\u5dd2\u9109":"923","\u5d01\u9802\u9109":"924","\u65b0\u57e4\u9109":"925","\u5357\u5dde\u9109":"926","\u6797\u908a\u9109":"927",
"\u6771\u6e2f\u93ae":"928","\u7409\u7403\u9109":"929","\u4f73\u51ac\u9109":"931","\u65b0\u5712\u9109":"932","\u678b\u5bee\u9109":"940","\u678b\u5c71\u9109":"941","\u6625\u65e5\u9109":"942","\u7345\u5b50\u9109":"943","\u8eca\u57ce\u9109":"944","\u7261\u4e39\u9109":"945","\u6046\u6625\u93ae":"946","\u6eff\u5dde\u9109":"947"},"\u53f0\u6771\u7e23":{"\u81fa\u6771\u5e02":"950","\u7da0\u5cf6\u9109":"951","\u862d\u5dbc\u9109":"952","\u5ef6\u5e73\u9109":"953","\u5351\u5357\u9109":"954","\u9e7f\u91ce\u9109":"955",
"\u95dc\u5c71\u93ae":"956","\u6d77\u7aef\u9109":"957","\u6c60\u4e0a\u9109":"958","\u6771\u6cb3\u9109":"959","\u6210\u529f\u93ae":"961","\u9577\u6ff1\u9109":"962","\u592a\u9ebb\u91cc\u9109":"963","\u91d1\u5cf0\u9109":"964","\u5927\u6b66\u9109":"965","\u9054\u4ec1\u9109":"966"},"\u82b1\u84ee\u7e23":{"\u82b1\u84ee\u5e02":"970","\u65b0\u57ce\u9109":"971","\u79c0\u6797\u9109":"972","\u5409\u5b89\u9109":"973","\u58fd\u8c50\u9109":"974","\u9cf3\u6797\u93ae":"975","\u5149\u5fa9\u9109":"976","\u8c50\u6ff1\u9109":"977",
"\u745e\u7a57\u9109":"978","\u842c\u69ae\u9109":"979","\u7389\u91cc\u93ae":"981","\u5353\u6eaa\u9109":"982","\u5bcc\u91cc\u9109":"983"},"\u91d1\u9580\u7e23":{"\u91d1\u6c99\u93ae":"890","\u91d1\u6e56\u93ae":"891","\u91d1\u5be7\u9109":"892","\u91d1\u57ce\u93ae":"893","\u70c8\u5dbc\u9109":"894","\u70cf\u5775\u9109":"896"},"\u9023\u6c5f\u7e23":{"\u5357\u7aff\u9109":"209","\u5317\u7aff\u9109":"210","\u8392\u5149\u9109":"211","\u6771\u5f15\u9109":"212"},"\u6f8e\u6e56\u7e23":{"\u99ac\u516c\u5e02":"880",
"\u897f\u5dbc\u9109":"881","\u671b\u5b89\u9109":"882","\u4e03\u7f8e\u9109":"883","\u767d\u6c99\u9109":"884","\u6e56\u897f\u9109":"885"}};m.prototype={VERSION:"1.7.9",data:function(){var b=this.wrap;return"undefined"!==typeof d[b.county.val()]?d[b.county.val()]:d},serialize:function(){var b=[],a={},c={},d={},a=this.container.find("select,input");a.length?a.each(function(){c=f(this);b.push(c.attr("name")+"="+c.val())}):f(this).children().each(function(){d=f(this);b.push(d.attr("name")+"="+d.val())});
return b.join("&")},destroy:function(){f.data(this.container.get(0),"twzipcode",null);if(this.container.length)return this.container.empty().off("change.twzipcode keyup.twzipcode blur.twzipcode")},get:function(b){if("function"===typeof b)b.call(this,this.wrap);else return this.wrap},set:function(b){var a=f.extend({},{county:"",district:"",zipcode:""},b);try{"string"===typeof b||"number"===typeof b?this.wrap.zipcode.val(b).trigger("blur.twzipcode"):(a.zipcode&&this.wrap.zipcode.val(a.zipcode).trigger("blur.twzipcode"),
a.county&&this.wrap.county.val(a.county).trigger("change.twzipcode"),a.district&&this.wrap.district.val(a.district).trigger("change.twzipcode"))}catch(c){console.warn(c.message)}finally{return this.container}},reset:function(b,a){var c=this.wrap,h=this.options,e="",l=[];switch(a){case "district":c.district.html('<option value="">\u9109\u93ae\u5e02\u5340</option>');break;default:c.county.html('<option value="">\u7e23\u5e02</option>');c.district.html('<option value="">\u9109\u93ae\u5e02\u5340</option>');
for(e in d)"undefined"!==typeof d[e]&&-1===h.hideCounty.indexOf(e)&&l.push('<option value="'+e+'">'+e+"</option>");f(l.join("")).appendTo(c.county)}c.zipcode.val("")},bindings:function(){var b=this,a=b.options,c=b.wrap,h="",e="",l="";c.county.on("change.twzipcode",function(){var k=f(this).val(),g="",e=[];c.district.empty();if(k){if(!0===a.zipcodeIntoDistrict)for(g in d[k])"undefined"!==typeof d[k][g]&&-1===a.hideDistrict.indexOf(g)&&-1===a.hideDistrict.indexOf(d[k][g])&&(e.push('<option value="'+
g+'">'),e.push(d[k][g]+" "+g),e.push("</option>"));else for(g in d[k])"undefined"!==typeof d[k][g]&&-1===a.hideDistrict.indexOf(g)&&-1===a.hideDistrict.indexOf(d[k][g])&&(e.push('<option value="'+g+'">'),e.push(g),e.push("</option>"));c.district.append(e.join("")).trigger("change.twzipcode")}else c.county.find("option:first").prop("selected",!0),b.reset("district");"function"===typeof a.onCountySelect&&a.onCountySelect.call(this)});c.district.on("change.twzipcode",function(){var b=f(this).val();c.county.val()&&
c.zipcode.val(d[c.county.val()][b]);"function"===typeof a.onDistrictSelect&&a.onDistrictSelect.call(this)});c.zipcode.on("keyup.twzipcode blur.twzipcode",function(){var b=f(this),e="",h="";b.val(b.val().replace(/[^0-9]/g,""));b=b.val().toString();if(3===b.length)for(e in d)if("undefined"!==typeof d[e])for(h in d[e])if("undefined"!==typeof d[e][h]&&b===d[e][h]){c.county.val(e).trigger("change.twzipcode");c.district.val(h).trigger("change.twzipcode");break}"function"===typeof a.onZipcodeKeyUp&&a.onZipcodeKeyUp.call(this)});
h="undefined"!==typeof a.zipcodeSel?a.zipcodeSel:"undefined"!==typeof b.role.zipcode.data("value")?b.role.zipcode.data("value"):a.zipcodeSel;e="undefined"!==typeof a.countySel?a.countySel:"undefined"!==typeof b.role.county.data("value")?b.role.county.data("value"):a.countySel;l="undefined"!==typeof a.districtSel?a.districtSel:"undefined"!==typeof b.role.district.data("value")?b.role.district.data("value"):a.districtSel;e&&(b.wrap.county.val(e).trigger("change.twzipcode"),"undefined"!==typeof d[e][l]&&
b.wrap.district.val(l).trigger("change.twzipcode"));h&&3===h.toString().length&&b.wrap.zipcode.val(h).trigger("blur.twzipcode")},geoLocation:function(){var b=this,a=navigator.geolocation,c={maximumAge:6E5,timeout:3E3,enableHighAccuracy:!1},d=b.options;a&&a.getCurrentPosition(function(a){var c={};"coords"in a&&"latitude"in a.coords&&"longitude"in a.coords&&(c=[a.coords.latitude,a.coords.longitude],f.getJSON("https://maps.googleapis.com/maps/api/geocode/json",{key:d.googleMapsKey,sensor:!1,latlng:c.join(",")},
function(a){a&&"undefined"!==typeof a.results&&"undefined"!==typeof a.results[0].address_components&&"undefined"!==typeof a.results[0].address_components[0]&&(a=a.results[0].address_components[a.results[0].address_components.length-1].long_name)&&b.wrap.zipcode.val(a.toString()).trigger("blur.twzipcode")}))},function(a){console.error(a)},c)},init:function(){var b=this.container,a=this.options,c={county:b.find("[data-role=county]:first"),district:b.find("[data-role=district]:first"),zipcode:b.find("[data-role=zipcode]:first")},
d=c.county.data("name")||a.countyName,e=c.district.data("name")||a.districtName,l=c.zipcode.data("name")||a.zipcodeName,k=c.zipcode.data("placeholder")||a.zipcodePlaceholder,g=c.zipcode.data("readonly")||a.readonly;f("<select/>").attr("name",d).addClass(c.county.data("style")||("undefined"!==typeof a.css[0]?a.css[0]:"")).appendTo(c.county.length?c.county:b);f("<select/>").attr("name",e).addClass(c.district.data("style")||("undefined"!==typeof a.css[1]?a.css[1]:"")).appendTo(c.district.length?c.district:
b);f("<input/>").attr({type:"text",name:l,placeholder:k}).prop("readonly",g).addClass(c.zipcode.data("style")||("undefined"!==typeof a.css[2]?a.css[2]:"")).appendTo(c.zipcode.length?c.zipcode:b);this.wrap={county:b.find('select[name="'+d+'"]:first'),district:b.find('select[name="'+e+'"]:first'),zipcode:b.find('input[type=text][name="'+l+'"]:first')};!0===a.zipcodeIntoDistrict&&this.wrap.zipcode.hide();this.role=c;this.reset();this.bindings();!0===a.detect&&this.geoLocation()}};f.fn.twzipcode=function(b){var a=
{},c=[],d=arguments;return"string"===typeof b?(this.each(function(){a=f.data(this,"twzipcode");a instanceof m&&"function"===typeof a[b]&&(c=a[b].apply(a,Array.prototype.slice.call(d,1)))}),"undefined"!==typeof c?c:this):this.each(function(){f.data(this,"twzipcode")||f.data(this,"twzipcode",new m(this,b))})}})(window.jQuery||{},window,document);
