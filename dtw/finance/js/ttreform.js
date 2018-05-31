			var coordinationAllowanceDEOVariance=document.getElementById("coordinationAllowanceDEOVariance");
			var coordinationAllowanceDEOAdvanced=document.getElementById("coordinationAllowanceDEOAdvanced");
			var coordinationAllowanceDEOSpent=document.getElementById("coordinationAllowanceDEOSpent");
			var transportDEOVariance=document.getElementById("transportDEOVariance");
			var transportDEOAdvanced=document.getElementById("transportDEOAdvanced");
			var transportDEOSpent=document.getElementById("transportDEOSpent");
			var airTimeDEOVariance=document.getElementById("airTimeDEOVariance");
			var airTimeDEOAdvanced=document.getElementById("airTimeDEOAdvanced");
			var airTimeDEOSpent=document.getElementById("airTimeDEOSpent");
			var transportTrainingMaterialsAllowanceVariance=document.getElementById("transportTrainingMaterialsAllowanceVariance");
			var transportTrainingMaterialsAllowanceAdvanced=document.getElementById("transportTrainingMaterialsAllowanceAdvanced");
			var transportTrainingMaterialsAllowanceSpent=document.getElementById("transportTrainingMaterialsAllowanceSpent");
			var driverLunchAllowanceVariance=document.getElementById("driverLunchAllowanceVariance");
			var driverLunchAllowanceAdvanced=document.getElementById("driverLunchAllowanceAdvanced");
			var driverLunchAllowanceSpent=document.getElementById("driverLunchAllowanceSpent");
			var coordinationAllowance2DistrictLevelVariance=document.getElementById("coordinationAllowance2DistrictLevelVariance");
			var coordinationAllowance2DistrictLevelAdvanced=document.getElementById("coordinationAllowance2DistrictLevelAdvanced");
			var coordinationAllowance2DistrictLevelSpent=document.getElementById("coordinationAllowance2DistrictLevelSpent");
			var transport2DistrictLevelAllowanceVariance=document.getElementById("transport2DistrictLevelAllowanceVariance");
			var transport2DistrictLevelAllowanceAdvanced=document.getElementById("transport2DistrictLevelAllowanceAdvanced");
			var transport2DistrictLevelAllowanceSpent=document.getElementById("transport2DistrictLevelAllowanceSpent");
			var airTime2DistrictLevelVariance=document.getElementById("airTime2DistrictLevelVariance");
			var airTime2DistrictLevelAdvanced=document.getElementById("airTime2DistrictLevelAdvanced");
			var airTime2DistrictLevelSpent=document.getElementById("airTime2DistrictLevelSpent");
			var facilitationFeeVariance=document.getElementById("facilitationFeeVariance");
			var facilitationFeeAdvanced=document.getElementById("facilitationFeeAdvanced");
			var facilitationFeeSpent=document.getElementById("facilitationFeeSpent");
			var lunchTeacherTrainingDivLevelVariance=document.getElementById("lunchTeacherTrainingDivLevelVariance");
			var lunchTeacherTrainingDivLevelAdvanced=document.getElementById("lunchTeacherTrainingDivLevelAdvanced");
			var lunchTeacherTrainingDivLevelSpent=document.getElementById("lunchTeacherTrainingDivLevelSpent");
			var transportTeacherTrainingVariance=document.getElementById("transportTeacherTrainingVariance");
			var transportTeacherTrainingAdvanced=document.getElementById("transportTeacherTrainingAdvanced");
			var transportTeacherTrainingSpent=document.getElementById("transportTeacherTrainingSpent");
			var airTimeDivLevelVariance=document.getElementById("airTimeDivLevelVariance");
			var airTimeDivLevelAdvanced=document.getElementById("airTimeDivLevelAdvanced");
			var airTimeDivLevelSpent=document.getElementById("airTimeDivLevelSpent");
			var teacherTransportVariance=document.getElementById("teacherTransportVariance");
			var teacherTransportAdvanced=document.getElementById("teacherTransportAdvanced");
			var teacherTransportSpent=document.getElementById("teacherTransportSpent");
			var hallRentalVariance=document.getElementById("hallRentalVariance");
			var hallRentalAdvanced=document.getElementById("hallRentalAdvanced");
			var hallRentalSpent=document.getElementById("hallRentalSpent");
			var teaVariance=document.getElementById("teaVariance");
			var teaAdvanced=document.getElementById("teaAdvanced");
			var teaSpent=document.getElementById("teaSpent");
			var stationeryVariance=document.getElementById("stationeryVariance");
			var stationeryAdvanced=document.getElementById("stationeryAdvanced");
			var stationerySpent=document.getElementById("stationerySpent");
			var airTimeHeadTeachersVariance=document.getElementById("airTimeHeadTeachersVariance");
			var airTimeHeadTeachersAdvanced=document.getElementById("airTimeHeadTeachersAdvanced");
			var totalAmountSpent=document.getElementById("airTimeHeadTeachersSpent");
			var bankChargesVariance=document.getElementById("bankChargesVariance");
			var bankChargesAdvanced=document.getElementById("bankChargesAdvanced");
			var bankChargesSpent=document.getElementById("bankChargesSpent");
			var courierAmountVariance=document.getElementById("courierAmountVariance");
			var courierAmountAdvanced=document.getElementById("courierAmountAdvanced");
			var courierAmountSpent=document.getElementById("courierAmountSpent");
			var otherAllowancesAmountVariance=document.getElementById("otherAllowancesAmountVariance");
			var otherAllowancesAmountAdvanced=document.getElementById("otherAllowancesAmountAdvanced");
			var otherAllowancesAmountSpent=document.getElementById("otherAllowancesAmountSpent");
			var totalAboveAmountVariance=document.getElementById("totalAboveAmountVariance");
			var totalAboveAmountAdvanced=document.getElementById("totalAboveAmountAdvanced");
			var totalAboveAmountSpent=document.getElementById("totalAboveAmountSpent");
			var totalAmountVariance=document.getElementById("totalAmountVariance");
			var totalAmountAdvanced=document.getElementById("totalAmountAdvanced");
			var totalAmountSpent=document.getElementById("totalAmountSpent");



window.addEventListener('input', function calculateAllVariances() {

console.log("function accessed");
		coordinationAllowanceDEOVariance.value=coordinationAllowanceDEOAdvanced.value-coordinationAllowanceDEOSpent.value;
				transportDEOVariance.value=transportDEOAdvanced.value-transportDEOSpent.value;
				airTimeDEOVariance.value=airTimeDEOAdvanced.value-airTimeDEOSpent.value;
				transportTrainingMaterialsAllowanceVariance.value=transportTrainingMaterialsAllowanceAdvanced.value-transportTrainingMaterialsAllowanceSpent.value;
				driverLunchAllowanceVariance.value=driverLunchAllowanceAdvanced.value-driverLunchAllowanceSpent.value;
				coordinationAllowance2DistrictLevelVariance.value=coordinationAllowance2DistrictLevelAdvanced.value-coordinationAllowance2DistrictLevelSpent.value;
				transport2DistrictLevelAllowanceVariance.value=transport2DistrictLevelAllowanceAdvanced.value-transport2DistrictLevelAllowanceSpent.value;
				airTime2DistrictLevelVariance.value=airTime2DistrictLevelAdvanced.value-airTime2DistrictLevelSpent.value;
				facilitationFeeVariance.value=facilitationFeeAdvanced.value-facilitationFeeSpent.value;
				lunchTeacherTrainingDivLevelVariance.value=lunchTeacherTrainingDivLevelAdvanced.value-lunchTeacherTrainingDivLevelSpent.value;
				transportTeacherTrainingVariance.value=transportTeacherTrainingAdvanced.value-transportTeacherTrainingSpent.value;
				airTimeDivLevelVariance.value=airTimeDivLevelAdvanced.value-airTimeDivLevelSpent.value;
				teacherTransportVariance.value=teacherTransportAdvanced.value-teacherTransportSpent.value;
				hallRentalVariance.value=hallRentalAdvanced.value-hallRentalSpent.value;
				teaVariance.value=teaAdvanced.value-teaSpent.value;
				stationeryVariance.value=stationeryAdvanced.value-stationerySpent.value;
				airTimeHeadTeachersVariance.value=airTimeHeadTeachersAdvanced.value-airTimeHeadTeachersSpent.value;
				bankChargesVariance.value=bankChargesAdvanced.value-bankChargesSpent.value;
				courierAmountVariance.value=courierAmountAdvanced.value-courierAmountSpent.value;
				otherAllowancesAmountVariance.value=otherAllowancesAmountAdvanced.value-otherAllowancesAmountSpent.value;
				totalAboveAmountVariance.value=totalAboveAmountAdvanced.value-totalAboveAmountSpent.value;
				totalAmountVariance.value=totalAmountAdvanced.value-totalAmountSpent.value;



	},false);



window.addEventListener('input', function calculateTotalAdvanced() {

console.log("function for Total Amount Advanced accessed");

totalAmountAdvanced.value=(coordinationAllowanceDEOAdvanced.value * 1)+(transportDEOAdvanced.value * 1)+

(airTimeDEOAdvanced.value * 1)+(transportTrainingMaterialsAllowanceAdvanced.value * 1)+
(driverLunchAllowanceAdvanced.value * 1)+(coordinationAllowance2DistrictLevelAdvanced.value * 1)+
(transport2DistrictLevelAllowanceAdvanced.value * 1)+(airTime2DistrictLevelAdvanced.value * 1)+
(facilitationFeeAdvanced.value * 1)+(lunchTeacherTrainingDivLevelAdvanced.value *1)+(transportTeacherTrainingAdvanced.value *1)+
(airTimeDivLevelAdvanced.value *1)+(teacherTransportAdvanced.value *1)+(hallRentalAdvanced.value *1)+(teaAdvanced.value *1)
+(stationeryAdvanced.value *1)+(airTimeHeadTeachersAdvanced.value *1)+(bankChargesAdvanced.value *1)+(courierAmountAdvanced.value*1)+(otherAllowancesAmountAdvanced.value*1)
+(totalAboveAmountAdvanced.value*1);
	if(isNaN(totalAmountAdvanced.value)){

		totalAmountAdvanced.value=0;
	}			



	},false);


window.addEventListener('input', function calculateTotalSpent() {

console.log("function for Total Amount Spent accessed");

totalAmountSpent.value=(coordinationAllowanceDEOSpent.value * 1)+(transportDEOSpent.value * 1)+

(airTimeDEOSpent.value * 1)+(transportTrainingMaterialsAllowanceSpent.value * 1)+
(driverLunchAllowanceSpent.value * 1)+(coordinationAllowance2DistrictLevelSpent.value * 1)+
(transport2DistrictLevelAllowanceSpent.value * 1)+(airTime2DistrictLevelSpent.value * 1)+
(facilitationFeeSpent.value * 1)+(lunchTeacherTrainingDivLevelSpent.value *1)+(transportTeacherTrainingSpent.value *1)+
(airTimeDivLevelSpent.value *1)+(teacherTransportSpent.value *1)+(hallRentalSpent.value *1)+(teaSpent.value *1)
+(stationerySpent.value *1)+(airTimeHeadTeachersSpent.value *1)+(bankChargesSpent.value *1)+(courierAmountSpent.value*1)+(otherAllowancesAmountSpent.value*1)
+(totalAboveAmountSpent.value*1);
	if(isNaN(totalAmountSpent.value)){

		totalAmountSpent.value=0;
	}			



	},false);				


window.addEventListener('input', function calculateTotalVariance() {

console.log("function for Total Amount Variance accessed");

totalAmountVariance.value=(coordinationAllowanceDEOVariance.value * 1)+(transportDEOVariance.value * 1)+

(airTimeDEOVariance.value * 1)+(transportTrainingMaterialsAllowanceVariance.value * 1)+
(driverLunchAllowanceVariance.value * 1)+(coordinationAllowance2DistrictLevelVariance.value * 1)+
(transport2DistrictLevelAllowanceVariance.value * 1)+(airTime2DistrictLevelVariance.value * 1)+
(facilitationFeeVariance.value * 1)+(lunchTeacherTrainingDivLevelVariance.value *1)+(transportTeacherTrainingVariance.value *1)+
(airTimeDivLevelVariance.value *1)+(teacherTransportVariance.value *1)+(hallRentalVariance.value *1)+(teaVariance.value *1)
+(stationeryVariance.value *1)+(airTimeHeadTeachersVariance.value *1)+(bankChargesVariance.value *1)+(courierAmountVariance.value*1)+(otherAllowancesAmountVariance.value*1)
+(totalAboveAmountVariance.value*1);
	if(isNaN(totalAmountVariance.value)){

		totalAmountVariance.value=0;
	}			



	},false);

//Modal Javascript from here --Difference with the front js is their ids have md infront but the 
//functionality is identical

			var mdcoordinationAllowanceDEOVariance=document.getElementById("mdcoordinationAllowanceDEOVariance");
			var mdcoordinationAllowanceDEOAdvanced=document.getElementById("mdcoordinationAllowanceDEOAdvanced");
			var mdcoordinationAllowanceDEOSpent=document.getElementById("mdcoordinationAllowanceDEOSpent");
			var mdtransportDEOVariance=document.getElementById("mdtransportDEOVariance");
			var mdtransportDEOAdvanced=document.getElementById("mdtransportDEOAdvanced");
			var mdtransportDEOSpent=document.getElementById("mdtransportDEOSpent");
			var mdairTimeDEOVariance=document.getElementById("mdairTimeDEOVariance");
			var mdairTimeDEOAdvanced=document.getElementById("mdairTimeDEOAdvanced");
			var mdairTimeDEOSpent=document.getElementById("mdairTimeDEOSpent");
			var mdtransportTrainingMaterialsAllowanceVariance=document.getElementById("mdtransportTrainingMaterialsAllowanceVariance");
			var mdtransportTrainingMaterialsAllowanceAdvanced=document.getElementById("mdtransportTrainingMaterialsAllowanceAdvanced");
			var mdtransportTrainingMaterialsAllowanceSpent=document.getElementById("mdtransportTrainingMaterialsAllowanceSpent");
			var mddriverLunchAllowanceVariance=document.getElementById("mddriverLunchAllowanceVariance");
			var mddriverLunchAllowanceAdvanced=document.getElementById("mddriverLunchAllowanceAdvanced");
			var mddriverLunchAllowanceSpent=document.getElementById("mddriverLunchAllowanceSpent");
			var mdcoordinationAllowance2DistrictLevelVariance=document.getElementById("mdcoordinationAllowance2DistrictLevelVariance");
			var mdcoordinationAllowance2DistrictLevelAdvanced=document.getElementById("mdcoordinationAllowance2DistrictLevelAdvanced");
			var mdcoordinationAllowance2DistrictLevelSpent=document.getElementById("mdcoordinationAllowance2DistrictLevelSpent");
			var mdtransport2DistrictLevelAllowanceVariance=document.getElementById("mdtransport2DistrictLevelAllowanceVariance");
			var mdtransport2DistrictLevelAllowanceAdvanced=document.getElementById("mdtransport2DistrictLevelAllowanceAdvanced");
			var mdtransport2DistrictLevelAllowanceSpent=document.getElementById("mdtransport2DistrictLevelAllowanceSpent");
			var mdairTime2DistrictLevelVariance=document.getElementById("mdairTime2DistrictLevelVariance");
			var mdairTime2DistrictLevelAdvanced=document.getElementById("mdairTime2DistrictLevelAdvanced");
			var mdairTime2DistrictLevelSpent=document.getElementById("mdairTime2DistrictLevelSpent");
			var mdfacilitationFeeVariance=document.getElementById("mdfacilitationFeeVariance");
			var mdfacilitationFeeAdvanced=document.getElementById("mdfacilitationFeeAdvanced");
			var mdfacilitationFeeSpent=document.getElementById("mdfacilitationFeeSpent");
			var mdlunchTeacherTrainingDivLevelVariance=document.getElementById("mdlunchTeacherTrainingDivLevelVariance");
			var mdlunchTeacherTrainingDivLevelAdvanced=document.getElementById("mdlunchTeacherTrainingDivLevelAdvanced");
			var mdlunchTeacherTrainingDivLevelSpent=document.getElementById("mdlunchTeacherTrainingDivLevelSpent");
			var mdtransportTeacherTrainingVariance=document.getElementById("mdtransportTeacherTrainingVariance");
			var mdtransportTeacherTrainingAdvanced=document.getElementById("mdtransportTeacherTrainingAdvanced");
			var mdtransportTeacherTrainingSpent=document.getElementById("mdtransportTeacherTrainingSpent");
			var mdairTimeDivLevelVariance=document.getElementById("mdairTimeDivLevelVariance");
			var mdairTimeDivLevelAdvanced=document.getElementById("mdairTimeDivLevelAdvanced");
			var mdairTimeDivLevelSpent=document.getElementById("mdairTimeDivLevelSpent");
			var mdteacherTransportVariance=document.getElementById("mdteacherTransportVariance");
			var mdteacherTransportAdvanced=document.getElementById("mdteacherTransportAdvanced");
			var mdteacherTransportSpent=document.getElementById("mdteacherTransportSpent");
			var mdhallRentalVariance=document.getElementById("mdhallRentalVariance");
			var mdhallRentalAdvanced=document.getElementById("mdhallRentalAdvanced");
			var mdhallRentalSpent=document.getElementById("mdhallRentalSpent");
			var mdteavariance=document.getElementById("mdteaVariance");
			var mdteaAdvanced=document.getElementById("mdteaAdvanced");
			var mdteaSpent=document.getElementById("mdteaSpent");
			var mdstationeryVariance=document.getElementById("mdstationeryVariance");
			var mdstationeryAdvanced=document.getElementById("mdstationeryAdvanced");
			var mdstationerySpent=document.getElementById("mdstationerySpent");
			var mdairTimeHeadTeachersVariance=document.getElementById("mdairTimeHeadTeachersVariance");
			var mdairTimeHeadTeachersAdvanced=document.getElementById("mdairTimeHeadTeachersAdvanced");
			var mdtotalAmountSpent=document.getElementById("mdairTimeHeadTeachersSpent");
			var mdbankChargesVariance=document.getElementById("mdbankChargesVariance");
			var mdbankChargesAdvanced=document.getElementById("mdbankChargesAdvanced");
			var mdbankChargesSpent=document.getElementById("mdbankChargesSpent");
			var mdcourierAmountVariance=document.getElementById("mdcourierAmountVariance");
			var mdcourierAmountAdvanced=document.getElementById("mdcourierAmountAdvanced");
			var mdcourierAmountSpent=document.getElementById("mdcourierAmountSpent");
			var mdotherAllowancesAmountVariance=document.getElementById("mdotherAllowancesAmountVariance");
			var mdotherAllowancesAmountAdvanced=document.getElementById("mdotherAllowancesAmountAdvanced");
			var mdotherAllowancesAmountSpent=document.getElementById("mdotherAllowancesAmountSpent");
			var mdtotalAboveAmountVariance=document.getElementById("mdtotalAboveAmountVariance");
			var mdtotalAboveAmountAdvanced=document.getElementById("mdtotalAboveAmountAdvanced");
			var mdtotalAboveAmountSpent=document.getElementById("mdtotalAboveAmountSpent");
			var mdtotalAmountVariance=document.getElementById("mdtotalAmountVariance");
			var mdtotalAmountAdvanced=document.getElementById("mdtotalAmountAdvanced");
			var mdtotalAmountSpent=document.getElementById("mdtotalAmountSpent");


window.addEventListener('input', function calculateAllVariances() {

console.log("function accessed");
		mdcoordinationAllowanceDEOVariance.value=mdcoordinationAllowanceDEOAdvanced.value-mdcoordinationAllowanceDEOSpent.value;
				mdtransportDEOVariance.value=mdtransportDEOAdvanced.value-mdtransportDEOSpent.value;
				mdairTimeDEOVariance.value=mdairTimeDEOAdvanced.value-mdairTimeDEOSpent.value;
				mdtransportTrainingMaterialsAllowanceVariance.value=mdtransportTrainingMaterialsAllowanceAdvanced.value-mdtransportTrainingMaterialsAllowanceSpent.value;
				mddriverLunchAllowanceVariance.value=mddriverLunchAllowanceAdvanced.value-mddriverLunchAllowanceSpent.value;
				mdcoordinationAllowance2DistrictLevelVariance.value=mdcoordinationAllowance2DistrictLevelAdvanced.value-mdcoordinationAllowance2DistrictLevelSpent.value;
				mdtransport2DistrictLevelAllowanceVariance.value=mdtransport2DistrictLevelAllowanceAdvanced.value-mdtransport2DistrictLevelAllowanceSpent.value;
				mdairTime2DistrictLevelVariance.value=mdairTime2DistrictLevelAdvanced.value-mdairTime2DistrictLevelSpent.value;
				mdfacilitationFeeVariance.value=mdfacilitationFeeAdvanced.value-mdfacilitationFeeSpent.value;
				mdlunchTeacherTrainingDivLevelVariance.value=mdlunchTeacherTrainingDivLevelAdvanced.value-mdlunchTeacherTrainingDivLevelSpent.value;
				mdtransportTeacherTrainingVariance.value=mdtransportTeacherTrainingAdvanced.value-mdtransportTeacherTrainingSpent.value;
				mdairTimeDivLevelVariance.value=mdairTimeDivLevelAdvanced.value-mdairTimeDivLevelSpent.value;
				mdteacherTransportVariance.value=mdteacherTransportAdvanced.value-mdteacherTransportSpent.value;
				mdhallRentalVariance.value=mdhallRentalAdvanced.value-mdhallRentalSpent.value;
				mdteaVariance.value=mdteaAdvanced.value-mdteaSpent.value;
				mdstationeryVariance.value=mdstationeryAdvanced.value-mdstationerySpent.value;
				mdairTimeHeadTeachersVariance.value=mdairTimeHeadTeachersAdvanced.value-mdairTimeHeadTeachersSpent.value;
				mdbankChargesVariance.value=mdbankChargesAdvanced.value-mdbankChargesSpent.value;
				mdcourierAmountVariance.value=mdcourierAmountAdvanced.value-mdcourierAmountSpent.value;
				mdotherAllowancesAmountVariance.value=mdotherAllowancesAmountAdvanced.value-mdotherAllowancesAmountSpent.value;
				mdtotalAboveAmountVariance.value=mdtotalAboveAmountAdvanced.value-mdtotalAboveAmountSpent.value;
				mdtotalAmountVariance.value=mdtotalAmountAdvanced.value-mdtotalAmountSpent.value;



	},false);



window.addEventListener('input', function calculateTotalAdvanced() {

console.log("function for Total Amount Advanced accessed");

mdtotalAmountAdvanced.value=(mdcoordinationAllowanceDEOAdvanced.value * 1)+(mdtransportDEOAdvanced.value * 1)+

(mdairTimeDEOAdvanced.value * 1)+(mdtransportTrainingMaterialsAllowanceAdvanced.value * 1)+
(mddriverLunchAllowanceAdvanced.value * 1)+(mdcoordinationAllowance2DistrictLevelAdvanced.value * 1)+
(mdtransport2DistrictLevelAllowanceAdvanced.value * 1)+(mdairTime2DistrictLevelAdvanced.value * 1)+
(mdfacilitationFeeAdvanced.value * 1)+(mdlunchTeacherTrainingDivLevelAdvanced.value *1)+(mdtransportTeacherTrainingAdvanced.value *1)+
(mdairTimeDivLevelAdvanced.value *1)+(mdteacherTransportAdvanced.value *1)+(mdhallRentalAdvanced.value *1)+(mdteaAdvanced.value *1)
+(mdstationeryAdvanced.value *1)+(mdairTimeHeadTeachersAdvanced.value *1)+(mdbankChargesAdvanced.value *1)+(mdcourierAmountAdvanced.value*1)+(mdotherAllowancesAmountAdvanced.value*1)
+(mdtotalAboveAmountAdvanced.value*1);
	if(isNaN(mdtotalAmountAdvanced.value)){

		mdtotalAmountAdvanced.value=0;
	}			



	},false);


window.addEventListener('input', function calculateTotalSpent() {

console.log("function for Total Amount Spent accessed");

mdtotalAmountSpent.value=(mdcoordinationAllowanceDEOSpent.value * 1)+(mdtransportDEOSpent.value * 1)+

(mdairTimeDEOSpent.value * 1)+(mdtransportTrainingMaterialsAllowanceSpent.value * 1)+
(mddriverLunchAllowanceSpent.value * 1)+(mdcoordinationAllowance2DistrictLevelSpent.value * 1)+
(mdtransport2DistrictLevelAllowanceSpent.value * 1)+(mdairTime2DistrictLevelSpent.value * 1)+
(mdfacilitationFeeSpent.value * 1)+(mdlunchTeacherTrainingDivLevelSpent.value *1)+(mdtransportTeacherTrainingSpent.value *1)+
(mdairTimeDivLevelSpent.value *1)+(mdteacherTransportSpent.value *1)+(mdhallRentalSpent.value *1)+(mdteaSpent.value *1)
+(mdstationerySpent.value *1)+(mdairTimeHeadTeachersSpent.value *1)+(mdbankChargesSpent.value *1)+(mdcourierAmountSpent.value*1)+(mdotherAllowancesAmountSpent.value*1)
+(mdtotalAboveAmountSpent.value*1);
	if(isNaN(mdtotalAmountSpent.value)){

		mdtotalAmountSpent.value=0;
	}			



	},false);				


window.addEventListener('input', function calculateTotalVariance() {

console.log("function for Total Amount Variance accessed");

mdtotalAmountVariance.value=(mdcoordinationAllowanceDEOVariance.value * 1)+(mdtransportDEOVariance.value * 1)+

(mdairTimeDEOVariance.value * 1)+(mdtransportTrainingMaterialsAllowanceVariance.value * 1)+
(mddriverLunchAllowanceVariance.value * 1)+(mdcoordinationAllowance2DistrictLevelVariance.value * 1)+
(mdtransport2DistrictLevelAllowanceVariance.value * 1)+(mdairTime2DistrictLevelVariance.value * 1)+
(mdfacilitationFeeVariance.value * 1)+(mdlunchTeacherTrainingDivLevelVariance.value *1)+(mdtransportTeacherTrainingVariance.value *1)+
(mdairTimeDivLevelVariance.value *1)+(mdteacherTransportVariance.value *1)+(mdhallRentalVariance.value *1)+(mdteaVariance.value *1)
+(mdstationeryVariance.value *1)+(mdairTimeHeadTeachersVariance.value *1)+(mdbankChargesVariance.value *1)+(mdcourierAmountVariance.value*1)+(mdotherAllowancesAmountVariance.value*1)
+(mdtotalAboveAmountVariance.value*1);
	if(isNaN(mdtotalAmountVariance.value)){

		mdtotalAmountVariance.value=0;
	}			



	},false);