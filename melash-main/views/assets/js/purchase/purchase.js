$(document).on("change","#utility_purchase",function(){

	priceSale($(this).val(), $("#cost_purchase").val() );

})

$(document).on("change","#cost_purchase",function(){

	priceSale($("#utility_purchase").val() , $(this).val() );
	totalInvest($("#qty_purchase").val() , $(this).val());

})

function priceSale(utility,cost){

	var utility = Number(utility.slice(0,-1));
	var cost = Number(cost);
	var price = Number(cost/((100-utility)/100));
	  // Redondear al múltiplo de 1000 más cercano
	  price = Math.ceil(price / 1000) * 1000;
    $("#price_purchase").val(price);

}

$(document).on("change","#qty_purchase",function(){

	totalInvest($(this).val(),$("#cost_purchase").val());

})

function totalInvest(qty,cost){

	var qty = Number(qty);
	var cost = Number(cost);

	$("#invest_purchase").val(cost*qty);
}