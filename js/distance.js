function calculate(lat1, lat2, lng1, lng2) {
	var R = 6371;

	var l1 = lat1*Math.PI/180;									//to radians
	var l2 = lat2*Math.PI/180;									//to radians
	var d1 = (lat2-lat1)*Math.PI/180;							//to radians
	var d2 = (lng1-lng2)*Math.PI/180;							//to radians

	var a = Math.sin(d1/2) * Math.sin(d1/2) +
	        Math.cos(l1) * Math.cos(l2) *
	        Math.sin(d2/2) * Math.sin(d2/2);
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

	var d = R * c;

	return d;
}