
	let trackingOrders = [], trackingAction = "none", cpOrders = [], cpAction = "none", pqProducts = [], pqAction = "0";
	let BUPlist = [], BUUPlist = [], BAOlist = [], BAODelivery = 0;
	
const addClass = (elem,name) => {
	let el = document.querySelector(elem);
	
	if(el){
	 el.classList.add(name);
	}
	
}

const removeClass = (elem,name) => {
	let el = document.querySelector(elem);
	
	if(el){
	 el.classList.remove(name);
	}
	
}

const showElem = (name) => {
	let names = [];
	
	if(Array.isArray(name)){
	  names = name;
	}
	else{
		names.push(name);
	}
	
	for(let i = 0; i < names.length; i++){
		removeClass(names[i],"hidden");
	    addClass(names[i],"visible");
	}
}

const hideElem = (name) => {
	let names = [];
	
	if(Array.isArray(name)){
	  names = name;
	}
	else{
		names.push(name);
	}
	
	for(let i = 0; i < names.length; i++){
		removeClass(names[i],"visible");
    	addClass(names[i],"hidden");
	}
	
}


function updateTracking(){
	hideSelectErrors();
	
	if(trackingOrders.length < 1 || trackingAction == "none"){
		if(trackingOrders.length < 1){
			showSelectError('tracking','order');
		}
		if(trackingAction == "none"){
			showSelectError('tracking','status');
		}
	}
	else{
	
	let isAllUnselected = true;
	
	for(let i = 0; i < trackingOrders.length; i++){
		if(trackingOrders[i].selected) isAllUnselected = false;
	}
	
	if(isAllUnselected){
		showSelectError('tracking','order');
	}
	else{
		$('#dt').val(JSON.stringify(trackingOrders));
		$('#action').val(trackingAction);
		
		$('#but-form').submit();
	}
  }
}

function updateBankPayments(){
	hideSelectErrors();
	
	if(cpOrders.length < 1 || cpAction == "none"){
		if(cpOrders.length < 1){
			showSelectError('cp','order');
		}
		if(cpAction == "none"){
			showSelectError('cp','status');
		}
	}
	else{
	
	let cpIsAllUnselected = true;
	
	for(let i = 0; i < cpOrders.length; i++){
		if(cpOrders[i].selected) cpIsAllUnselected = false;
	}
	
	if(cpIsAllUnselected){
		showSelectError('cp','order');
	}
	else{
		$('#cp-dt').val(JSON.stringify(cpOrders));
		$('#cp-action').val(cpAction);
		
		$('#bcp-form').submit();
	}
  }
}

function updateProducts(){
	hideSelectErrors();
	pqAction = $('#pq-qty').val();
	if(pqProducts.length < 1 || (pqAction == "0" || pqAction == "")){
		if(pqProducts.length < 1){
			showSelectError('pq','product');
		}
		if(pqAction == "0" || pqAction == ""){
			showSelectError('pq','qty');
		}
	}
	else{
	
	let pqIsAllUnselected = true;
	
	for(let i = 0; i < pqProducts.length; i++){
		if(pqProducts[i].selected) pqIsAllUnselected = false;
	}
	
	if(pqIsAllUnselected){
		showSelectError('pq','product');
	}
	else{
		$('#pq-dt').val(JSON.stringify(pqProducts));
		$('#pq-action').val(pqAction);
		
		$('#bup-form').submit();
	}
  }
}

function showBulkSelectButton(type,op){
	switch(op){
		case "selectAll":
		  $(`#${type}-select-all`).hide();
		$(`#${type}-unselect-all`).fadeIn();
		break;
		case "unselectAll":
		  $(`#${type}-unselect-all`).hide();
		$(`#${type}-select-all`).fadeIn();
		break;
	}
}

function trackingSelectAllOrders(){
	console.log("selecting all orders");
    bs = $('button.r');
	
	if(bs){
		console.log(bs.length);
		for(let i = 0; i < bs.length; i++){
			b = bs[i];
			trackingSelectOrder({reference: b.id});
		}
	    showBulkSelectButton("tracking","selectAll");
	
	}
}

function trackingUnselectAllOrders(){
	console.log("unselecting all orders");
     bs = $('button.r');
	
	if(bs){
		console.log(bs.length);
		for(let i = 0; i < bs.length; i++){
			b = bs[i];
			trackingUnselectOrder({reference: b.id});
		}
		showBulkSelectButton("tracking","unselectAll");
	}
}

function trackingSelectOrder(o){
	if(o.reference){
	  console.log(`selecting order ${o.reference}`);
	  b = $(`button#${o.reference}`);
	  if(b){
		   b.attr('disabled',true);
		   
		   $(`#tracking-unselect_${o.reference}`).fadeIn();
		  let ss = trackingOrders.find(i => i.reference == o.reference);
		  //console.log('us: ',us);
		  if(ss){
			ss.selected = true;  
		  }
		  else{
			trackingOrders.push({reference: o.reference,selected: true});  
		  }
		  
		  
	  }
	  
	}
}

function trackingUnselectOrder(o){
	if(o.reference){
	  console.log(`unselecting order ${o.reference}`);
	  b = $(`button#${o.reference}`);
	  
	  if(b){
		  b.attr('disabled',false);
		  $(`#tracking-unselect_${o.reference}`).hide();
		  let us = trackingOrders.find(i => i.reference == o.reference);
		  //console.log('us: ',us);
		  if(us){
		    us.selected = false;
		  }
	  }
	  
	}
}

function cpSelectAllOrders(){
	console.log("selecting all orders");
    bs = $('button.cp');
	
	if(bs){
		console.log(bs.length);
		for(let i = 0; i < bs.length; i++){
			b = bs[i];
			cpSelectOrder({reference: b.id.substring(3)});
		}
	    showBulkSelectButton("cp","selectAll");
	
	}
}

function cpUnselectAllOrders(){
	console.log("unselecting all orders");
     bs = $('button.cp');
	
	if(bs){
		console.log(bs.length);
		for(let i = 0; i < bs.length; i++){
			b = bs[i];
			cpUnselectOrder({reference: b.id});
		}
		showBulkSelectButton("cp","unselectAll");
	}
}

function cpSelectOrder(o){
	if(o.reference){
	  console.log(`cp selecting order ${o.reference}`);
	  b = $(`button#cp-${o.reference}`);
	  if(b){
		   b.attr('disabled',true);
		   
		   $(`#cp-unselect_${o.reference}`).fadeIn();
		  let ss = cpOrders.find(i => i.reference == o.reference);
		  //console.log('us: ',us);
		  if(ss){
			ss.selected = true;  
		  }
		  else{
			cpOrders.push({reference: o.reference,selected: true});  
		  }
		  
		  
	  }
	  
	}
}

function cpUnselectOrder(o){
	if(o.reference){
	  console.log(`unselecting order ${o.reference}`);
	  b = $(`button#cp-${o.reference}`);
	  
	  if(b){
		  b.attr('disabled',false);
		  $(`#cp-unselect_${o.reference}`).hide();
		  let us = cpOrders.find(i => i.reference == o.reference);
		  //console.log('us: ',us);
		  
		  if(us){
		    us.selected = false;
		  }
	  }
	  
	}
}

function pqSelectAllProducts(){
	console.log("selecting all products");
    bs = $('button.p');
	
	if(bs){
		console.log(bs.length);
		for(let i = 0; i < bs.length; i++){
			b = bs[i];
			pqSelectProduct({sku: b.id.substring(3)});
		}
	    showBulkSelectButton("pq","selectAll");
	
	}
}

function pqUnselectAllProducts(){
	console.log("unselecting all products");
     bs = $('button.p');
	
	if(bs){
		console.log(bs.length);
		for(let i = 0; i < bs.length; i++){
			b = bs[i];
			pqUnselectProduct({sku: b.id.substring(3)});
		}
		showBulkSelectButton("pq","unselectAll");
	}
}

function pqSelectProduct(prd){
	if(prd.sku){
	  console.log(`pq selecting product ${prd.sku}`);
	  p = $(`button#pq-${prd.sku}`);
	  if(p){
		   p.attr('disabled',true);
		   
		   $(`#pq-unselect_${prd.sku}`).fadeIn();
		  let pp = pqProducts.find(i => i.sku == prd.sku);
		  console.log('pp: ',pp);
		 
		  if(pp){
			pp.selected = true;  
		  }
		  else{
			pqProducts.push({sku: prd.sku,selected: true});  
		  }
	
		  
		  
	  }
	  
	}
}

function pqUnselectProduct(p){
	if(p.sku){
	  console.log(`pq unselecting product ${p.sku}`);
	  b = $(`button#pq-${p.sku}`);
	  
	  if(b){
		  b.attr('disabled',false);
		  $(`#pq-unselect_${p.sku}`).hide();
		  let us = pqProducts.find(i => i.sku == p.sku);
		  //console.log('us: ',us);
		   if(us){
		     us.selected = false;
		   }
	  }
	  
	}
}

function hideUnselects(){
	$('#tracking-unselect-all').hide();
	$('.tracking-unselect').hide();
	$('#cp-unselect-all').hide();
	$('.cp-unselect').hide();
	$('#pq-unselect-all').hide();
	$('.pq-unselect').hide();
	 $('.fca-unselect').hide();
}

function hideSelectErrors(){
	$('#tracking-select-order-error').hide();
	$('#tracking-select-status-error').hide();
	$('#cp-select-order-error').hide();
	$('#cp-select-status-error').hide();
	$('#pq-select-product-error').hide();
	$('#pq-select-qty-error').hide();
}

function showSelectError(type,err){
	$(`#${type}-select-${err}-error`).fadeIn();
}


function BUPEditStock(dt){
		console.log('dt: ',dt);
		let name = "";
		
	if(dt.origName){
				name = dt.origName;  
			  }
			  
	$(`#bup-${dt.sku}-side1`).hide();
	$(`#bup-${dt.sku}-side2`).fadeIn();
	let BUPitem = BUPlist.find(i => i.sku == dt.sku);
		  console.log('BUPitem: ',BUPitem);
		 
		  if(BUPitem){
			BUPitem.selected = true;  
			BUPitem.name = name;  
		  }
		  else{
			BUPlist.push({sku: dt.sku, name: name, selected: true});  
		  }
}

function BUPSaveEdit(edit,dt){
	let BUPitem = BUPlist.find(i => i.sku == dt.sku);
		  console.log('BUPitem: ',BUPitem);
		 
		  if(BUPitem){			  
			 if(edit == "qty") BUPitem.qty = dt.value;  
			 else if(edit == "name") BUPitem.name = dt.value;           			 
		  }
		  
}

function BUPCancelEditStock(dt){
	$(`#bup-${dt.sku}-side2`).hide();
	$(`#bup-${dt.sku}-side1`).fadeIn();
	let BUPitem = BUPlist.find(i => i.sku == dt.sku);
		  console.log('BUPitem: ',BUPitem);
		 
		  if(BUPitem){
			BUPitem.selected = false;  
		  }
}

function hideElems(cls){
	switch(cls){
		case 'bup':
		  $('#bup-select-product-error').hide();
		  $('#bup-select-qty-error').hide();
		break;
		
		case 'buup':
		  $('#buup-select-product-error').hide();
		  $('#buup-select-qty-error').hide();
		break;
	}
}

function BUP(){
	hideElems('bup');
	console.log("BUPlist length: ",BUPlist.length);
	if(BUPlist.length < 1){
		showSelectError('bup','product');
	}
	else{
	ret = [],  BUPIsAllUnselected = true, hasUnfilledQty = false;
	
	for(let i = 0; i < BUPlist.length; i++){
		let BUPitem = BUPlist[i];
		if(BUPitem.selected){
			let nn = BUPitem.name;
			if(!nn) nn = "";
			
			if(!BUPitem.qty || BUPitem.qty == "" || BUPitem.qty < 0){
				hasUnfilledQty = true;
			}
			ret.push({sku: BUPitem.sku,qty: BUPitem.qty,name: nn});
			
			BUPIsAllUnselected = false;
		}
	}
	   if(hasUnfilledQty){
		   showSelectError('bup','qty');
	   }
	   else if(BUPIsAllUnselected){
		showSelectError('bup','product');
	   }
	   else{
		 console.log("ret: ",ret);
		$('#bup-dt').val(JSON.stringify(ret));
		let  accessToken = localStorage.getItem('ace_fbp');
		if(accessToken){
			$('#bup-ftk').val(accessToken);
		}
		$('#bup-form').trigger('submit');
	   }
  }
}

function BUUPAddRow(){
	/**
	<th>SKU</th>
                                    <th width="40%">Description</th>
                                    <th width="10%">Price(&#8358;)</th>
                                    <th>Stock</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Actions</th>                                                                                                      
	**/
	
	let str = `
	 <tr id="buup-${buupCounter}" style="margin-bottom: 20px; border-bottom: 1px solid #fff;">
	 <td>Will be generated</td>
	 <td><input type="text" placeholder="Product name" class="form-control pname"></td>
	   <td width="40%"><input type="text" placeholder="Product description" class="form-control desc"></td>
	   <td><input type="number"  placeholder="Price in NGN" class="form-control price"></td>
	   <td><input type="number"  placeholder="Stock" class="form-control stock"></td>
	   <td>
	     <select class="category" >
		 <option value="none">Select category</option>
		  ${categories.map(k => "<option value='" + k + "'>" + k.toUpperCase() + "</option>").join("")}
		 </select>
	   </td>
	   <td>
	    <select class="status" >
		<option value="none">Select status</option>
		 <option value="in_stock">In stock</option>
		 <option value="new">New</option>
		 <option value="out_of_stock">Out of stock</option>
		</select>
	   </td>
	   <td style="margin-top: 20px;">
	    <div>
		  <div id="buup-${buupCounter}-images-div" class="row">
	        <div class="col-md-6">
	         <input type="file" placeholder="Upload image"  data-ic="0" class="form-control images" onchange="readURL(this,'${buupCounter}')" name="buup-${buupCounter}-images[]">
		    </div>
			<div class="col-md-6">
			    <div class="row">
			      <div class="col-md-7">
	                <img id="buup-${buupCounter}-preview-0" src="#" alt="preview" style="width: 50px; height: 50px;"/>
			      </div>
			      <div class="col-md-5">
			        <input type="radio" name="buup-${buupCounter}-cover" value="0">
			      </div>
			    </div>
			  </div>
		  </div>
	    </div>
	   </td>
	   <td>
	   <button onclick="BUUPAddImage('${buupCounter}'); return false;" class="btn btn-primary">Add image</button>
	   <button onclick="BUUPRemoveRow('${buupCounter}'); return false;" class="btn btn-danger">Cancel</button>
	  
	   </td>
	 </tr>
	`;
	++buupCounter;
	$('#buup-table').append(str);
}

function BUUPRemoveRow(ctr){
	let r = $(`#buup-${ctr}`);
	console.log(r);
	r.remove();
	--buupCounter;
}

function readURL(input,ctr) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
		let pv = input.getAttribute("data-ic");
      $(`#buup-${ctr}-preview-${pv}`).attr({
	      'src': e.target.result,
	      'width': "50",
	      'height': "50"
	  });
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}


function BUUPAddImage(ctr){
	let i = $(`#buup-${ctr}-images-div`), imgCount = $(`#buup-${ctr}-images-div input[type=file]`).length;
	console.log(imgCount);
	i.append(`<div class="col-md-6">
	          <input type="file" placeholder="Upload image" data-ic="${imgCount}" onchange="readURL(this,'${ctr}')" class="form-control images" name="buup-${ctr}-images[]">
			  </div>
			  <div class="col-md-6">
			    <div class="row">
			      <div class="col-md-7">
	                <img id="buup-${ctr}-preview-${imgCount}" src="#" alt="preview" style="width: 50px; height: 50px;"/>
			      </div>
			      <div class="col-md-5">
			        <input type="radio" name="buup-${ctr}-cover" value="${imgCount}">
			      </div>
			    </div>
			  </div>
	  `);
}

function BUUP(){
	hideElems('buup');
	console.log("BUUPlist length: ",buupCounter);
	
	
	if(buupCounter < 1){
		showSelectError('buup','product');
	}
	else{
	ret = [], hasUnfilledQty = false; err = [];

	for(let i = 0; i < buupCounter; i++){
		let BUPitem = `#buup-${i}`;
		pname = $(`${BUPitem} input.pname`).val();
		desc = $(`${BUPitem} input.desc`).val();
		price = $(`${BUPitem} input.price`).val();
		stock = $(`${BUPitem} input.stock`).val();
		category = $(`${BUPitem} select.category`).val();
		status = $(`${BUPitem} select.status`).val();
		
			if(pname != "" && desc != "" && parseInt(price) > 0 && parseInt(stock) > 0 && category != "none" && status != "none"){
				let temp = {
					id: BUPitem,
					data:{
					  name: pname,
					  desc: desc,
					  price: price,
					  stock: stock,
					  category: category,
					  status: status,
					}
				};
				BUUPlist.push(temp);
			}
			else{
				if(pname == "") err.push("pname");
				if(desc == "") err.push("desc");
				if( parseInt(price) < 1) err.push("price");
				if( parseInt(stock) < 1) err.push("stock");
				if(category == "none") err.push("category");
				if(status == "none") err.push("status");
				hasUnfilledQty = true;
			}		
	}
	
	   if(hasUnfilledQty){
		   showSelectError('buup','validation');
		   console.log("err: ",err);
	   }
	   else{
		 //console.log("ret: ",ret);
		 
		 /**
		 $('#buup-dt').val(JSON.stringify(ret));
		$('#buup-form').submit();
		
		 **/
		 $('#button-box').hide();
		 $('#result-box').fadeIn();
		 
		 buupFire();
		 console.log(localStorage);
	   }
  }
}

function buupFire(){
	 let bc = localStorage.getItem("buupCtr");
	     if(!bc) bc = "0";
		 
		 
		
		 let fd = new FormData();
		 fd.append("dt",JSON.stringify(BUUPlist[bc]));
		 imgs = []; covers = [];
		
		//imgs = $(`${BUPitem}-image`)[0].files;
		imgs = $(`${BUUPlist[bc].id}-images-div input[type=file]`);
		cover = $(`${BUUPlist[bc].id}-images-div input[type=radio]:checked`);
		console.log("imgs: ",imgs);
		console.log("cover: ",cover);
		
		for(let r = 0; r < imgs.length; r++)
		 {
		    let imgg = imgs[r];
			let imgName = imgg.getAttribute("name");
            console.log("imgg name: ",imgName);			
            console.log("cover: ",cover.val());
            fd.append(imgName,imgg.files[0]);   			   			
		 }
		 
		 fd.append(cover.attr("name"),cover.val());
		 
		 
		 fd.append("_token",$('#tk').val());
		 console.log("fd: ",fd);
         
	
	//create request
	const req = new Request("buup",{method: 'POST', body: fd});
	//console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error:", message: "Network error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to upload product: " + error);			
	   })
	   .then(res => {
		   console.log(res);
          bc = parseInt(bc) + 1;
			     localStorage.setItem("buupCtr",bc);
				 
		   if(res.status == "ok"){
                  $('#result-ctr').html(bc);
				  
				  setTimeout(function(){
			       if(bc >= buupCounter){
					  $('#result-box').hide();
					  $("#finish-box").fadeIn();
					  window.location = "buup";
				  }
                  else{
					 buupFire();
				  }				  
		         },4000);
		   }
		   else if(res.status == "error"){
				     alert("An unknown network error has occured. Please refresh the app or try again later");	
                     $('#result-box').hide();
					  $("#finish-box").fadeIn();					 
		   }
		   
		    
		   
		  
	   }).catch(error => {
		    alert("Failed to send message: " + error);			
	   });
}


function displayProductSelect(product){
	return `
	<option value="${product.sku}">
	<div class="row">
	  <div class="col-md-5">
	     <img src="${product.img}" alt="preview" style="width: 50px; height: 50px;"/>
	  </div>
	  <div class="col-md-7">
		<p>${product.name} (N${product.amount}) | ${product.qty} pcs left</p>
	  </div>
	</div>
	</option>
	`;
}

function BOAAddOrderItem(o,dt){
	let dtt = dt[0], qty = dt[1];
	let itemsJSON = localStorage.getItem(`items_${o}`);
            	if(!itemsJSON){
		           itemsJSON = "[]";
	             }
			 let items = JSON.parse(itemsJSON);
			 let BOAItem = items.find(i => i.sku == dtt.value);
			 
			 if(BOAItem){
				 BOAItem.qty = qty;
			 }
			 else{
				 ctr = localStorage.getItem(`ctr_${o}`);
				 if(!ctr){
					 ctr = 0;
				 }
				
			   items.push({
				  ctr: ctr,
				 sku: dtt.value,
				 qty: qty
			   });
               localStorage.setItem(`ctr_${o}`, parseInt(ctr) + 1);			   
			 }
			 
   localStorage.setItem(`items_${o}`,JSON.stringify(items));
			 
}

function computeTotal(i){
	let ret = {
		id: i,
		displays: [],
		subtotal: 0, 
		delivery: 0 
	};
	
	
	let itemsJSON = localStorage.getItem(`items_${i}`);
    if(!itemsJSON){
	   itemsJSON = "[]";
	}
	let items = JSON.parse(itemsJSON);
	
	if(items.length > 0){
		for(let ii = 0; ii < items.length; ii++){
			let item = items[ii];
			let p = products.find(pp => pp.sku == item.sku);
			if(p){
				ret.displays.push({
					sku: p.sku,
					ctr: item.ctr,
					qty: item.qty,
					amount: parseInt(p.amount)
				});
				ret.subtotal += (parseInt(item.qty) * parseInt(p.amount));
			}
		}
		console.log("displays",ret);
	}
	
	return ret;
			 
}

function displayTotal(dt){
	/**
	delivery: 0
displays: Array(3)
0: {sku: "ACE3676LX685", qty: "3", amount: 3500}
1: {sku: "ACE9151LX254", qty: "2", amount: 1400}
2: {sku: "ACE6870LX226", qty: "3", amount: 1000}
length: 3
__proto__: Array(0)
subtotal: 16300
	**/
	
	if(dt){
	  if(parseInt(dt.subtotal) > 0 && dt.displays.length > 0){
		 str = ``;
		 for(let x = 0; x < dt.displays.length; x++){
			 let item = dt.displays[x];
			 str += `<p id="bao-${dt.id}-totals-${item.ctr}">${item.sku} <b>(x${item.qty})</b>: <em>N${parseInt(item.qty) * item.amount}</em>
  			 <a href="javascript:void(0)" class="btn btn-warning" onclick="cancelProduct({b: ${dt.id},ctr: ${item.ctr}})">Cancel</a>
			 </p> `;
		 }
		 if(BAODelivery.length > 0){
			  str += `<p id="bao-${dt.id}-delivery"><b>Delivery</b>: <em>N${BAODelivery[1]}</em></p> `;
		 }
		 document.querySelector(`#bao-${dt.id} .total`).innerHTML = str;
	  }
	}
}

function BAOAddProductQty(o,dt){
	
	if(dt.selectedData){
		let dtt = dt.selectedData;
		Swal.fire({
         title: `<strong>${dtt.value} selected! Enter quantity:</strong>`,
         input: 'text',
         inputAttributes: {
           autocapitalize: 'off'
         },
         showCancelButton: true,
         confirmButtonText: 'Add to order',
         showLoaderOnConfirm: true,
         preConfirm: (qty) => {
			 //console.log([qty,dt]);
          if(isNaN(qty) || parseInt(qty) > parseInt(dtt.qty)){
			  msg = ``;
			  if(isNaN(qty)) msg = `Please enter a valid number`;
			  if(parseInt(qty) > parseInt(dtt.qty)) msg = `Only ${dtt.qty} pieces left`;
			  return {status: "error",message:msg};
		  }
		  else{
			 // console.log([qty,dtt]);
			  BOAAddOrderItem(o,[dtt,qty]);
			  
			  //Add to total <tr>
			  let totals = computeTotal(o);
			  displayTotal(totals);
			  return {status: "ok",value:[qty,dtt]};
		  }
        },
        allowOutsideClick: () => !Swal.isLoading()
       }).then((result) => {
		   //console.log(result);
         if (result.value.status == "ok") {
			 
           Swal.fire({
			   icon: 'success',
             title: `Product added`
           })
        }
		else if (result.value.status == "error") {
           Swal.fire({
			 icon: 'error',
             title: result.value.message
           })
        }
      })
   }
}

function changeCustomerType(event){
	let ct = event.value, ctr = event.getAttribute("data-ctr");
	//console.log([ct,ctr]);	
   
    if(ct == "user"){
		hideElem(`#bao-${ctr}-anon`);
		showElem(`#bao-${ctr}-user`);
	}   
	else if(ct == "anon"){
		hideElem(`#bao-${ctr}-user`);
		showElem(`#bao-${ctr}-anon`);
	}
	else{
		hideElem(`#bao-${ctr}-anon`);
		hideElem(`#bao-${ctr}-user`);
	}
}




/**YOU ARE HERE **/

function getDeliveryFee(dt){
    console.log(dt);
	//create request
	const req = `gdf?s=${dt}`;
	//console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error:", message: "Network error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to get delivery fee: " + error);			
	   })
	   .then(res => {
		   console.log(res);
		   
		   if(res.status == "ok"){
			      BAODelivery = res.message;				  
				}
		  
	   }).catch(error => {
		    alert("Failed to get delivery fee: " + error);			
	   });
}

function BOASelectUser(dt,type){
   let fu = {};
    if(type == "user"){
		let idd = dt.value;
		let u = users.find(uu => uu.id == idd);
		
		if(u){
			fu.id = u.id;
			fu.name = u.name;
			fu.email = u.email;
			fu.state = u.state;
		}
		saveName = `user_${dt.getAttribute('data-ctr')}`;
	}   
	else if(type == "anon"){
		fu = {
			id: "anon",
			name: document.querySelector(`#bao-${dt}-name`).value,
			email: document.querySelector(`#bao-${dt}-email`).value,
			phone: document.querySelector(`#bao-${dt}-phone`).value,
			address: document.querySelector(`#bao-${dt}-address`).value,
			city: document.querySelector(`#bao-${dt}-city`).value,
			state: document.querySelector(`#bao-${dt}-state`).value,
		};
		saveName = `user_${dt}`;
	}
	//console.log("fu: ",fu);
	localStorage.setItem(saveName,JSON.stringify(fu));
	
	getDeliveryFee(fu.state);  
	
	 Swal.fire({
			   icon: 'success',
             title: `User added to order`
           });
}

function BAOAddProduct(b){
	let ctr = localStorage.getItem(`ctr_${b}`);
	if(!ctr){
		ctr = 0;
	}
	let newProductDiv = `<div id="bao-${b}-products-${ctr}"></div><br>`;
	$(`#bao-${b}-products-div`).append(newProductDiv);
	$(`#bao-${b}-products-${ctr}`).ddslick({
      data: ddData,
      width: 300,
      imagePosition: "left",
      selectText: "Select product",
      onSelected: function (data) {
        //console.log(data);
		BAOAddProductQty(b,data);
      }
    });
	
	
}

function BAOAddRow(){
	/**
	<th>SKU</th>
                                    <th>Reference</th>
                                    <th width="30%">Customer</th>
                                    <th>Products</th>
                                    <th>Notes</th>
                                    <th>Total(&#8358;)</th>
                                    <th>Actions</th>                                                                                                  
	**/
	
	let str = `
	 <tr id="bao-${baoCounter}" style="margin-bottom: 20px; border-bottom: 1px solid #fff;">
	 <td>Will be generated</td>
	   <td width="30%">
	     <select class="customer-type" data-ctr="${baoCounter}" onchange="changeCustomerType(this)">
		 <option value="none">Select customer type</option>
		  ${customerTypes.map(k => "<option value='" + k.key + "'>" + k.value + "</option>").join("")}
		 </select>
		  <div class="row hidden" id="bao-${baoCounter}-user" style="margin-top: 10px;">
		    <div class="col-md-2"></div>
		     <div class="col-md-8">
		       <select class="" data-ctr="${baoCounter}" onchange="BOASelectUser(this,'user')">
		        <option value="none">Select user</option>
		         ${users.map(u => "<option value='" + u.id + "'>" + u.name + " (" + u.email + ") | " + u.state + "</option>").join("")}
		       </select>
		     </div>
		     <div class="col-md-2"></div>
		   </div>
		   <div class="row hidden" id="bao-${baoCounter}-anon" style="margin-top: 10px;">
		     <div class="col-md-2"></div>
		     <div class="col-md-8">
		       <form>
			   <div class="row">
			   <div class="col-md-6">
			     <div class="form-group">
			       <span class="control-label">Name</span>
				   <input type="text" id="bao-${baoCounter}-name" class="form-control">
			     </div>
			   </div>
			   <div class="col-md-6">
				 <div class="form-group">
			       <span class="control-label">Email address</span>
				   <input type="text" id="bao-${baoCounter}-email" class="form-control">
			     </div>
			   </div>
			   </div>
			   <div class="row">
			   <div class="col-md-6">
				 <div class="form-group">
			       <span class="control-label">Phone number</span>
				   <input type="text" id="bao-${baoCounter}-phone" class="form-control">
			     </div>
			   </div>
			   <div class="col-md-6">
				 <div class="form-group">
			       <span class="control-label">Address</span>
				   <input type="text" id="bao-${baoCounter}-address" class="form-control">
			     </div>
			   </div>
			  </div>
			  <div class="row">
			    <div class="col-md-6">
				 <div class="form-group">
			       <span class="control-label">City</span>
				   <input type="text" id="bao-${baoCounter}-city" class="form-control">
			     </div>
			   </div>
			   <div class="col-md-6">
				 <div class="form-group">
			       <span class="control-label">State</span>
				   <select id="bao-${baoCounter}-state" class="form-control">
				     <option value="none">Select state</option>
					 ${states.map(s => "<option value='" + s.key + "'>" + s.name + "</option>")}
				   </select>
			     </div>
			   </div>
			   </div>
				 <br>
				 <button onclick="BOASelectUser(${baoCounter},'anon'); return false;" class="btn btn-primary">Add to order</button>
			   </form>
		     </div>
			 <div class="col-md-2"></div>
		   </div>
	   </td>
	   <td>
		  <div id="bao-${baoCounter}-products-div">
		    
		  </div>
	   </td>
	   <td><textarea class="form-control notes"></textarea></td>
	   <td>
	    <div class="total"></div>
	   </td>
	   <td>
	   <input type="hidden" class="sku" value="1">
	   <input type="hidden" class="qty" value="1">
	   <button onclick="BAORemoveRow('${baoCounter}'); return false;" class="btn btn-danger">Remove</button>
	  
	   </td>
	 </tr>
	`;
	
	$('#bao-table').append(str);
	 document.querySelector(`#bao-${baoCounter} select.customer-type`).dispatchEvent(new CustomEvent("change"),{random: true});
	
	BAOAddProduct(baoCounter);
	
	++baoCounter;
	++orderCount;
}

function cancelProduct(dt){
	
	//update items
	let itemsJSON = localStorage.getItem(`items_${dt.b}`);
    if(!itemsJSON){
	   itemsJSON = "[]";
	}
	let items = JSON.parse(itemsJSON);
	
	if(items.length > 0){
		temp = [];
		x = items.find(pp => pp.ctr == dt.ctr);
		if(x){
		  for(let ii = 0; ii < items.length; ii++){
			if(items[ii] != x) temp.push(items[ii]);
		  }	
		}
		 localStorage.setItem(`items_${dt.b}`,JSON.stringify(temp));
		 let t = $(`#bao-${dt.b}-totals-${dt.ctr}`);
		 console.log(t);
		 t.remove();
		 
		 //Refresh total <tr>
	     let totals = computeTotal(dt.b);
		 displayTotal(totals);
	}
}

function BAORemoveRow(ctr){
	let r = $(`#bao-${ctr}`);
	//console.log(r);
	r.remove();
	--baoCounter;
	--orderCount;
	localStorage.removeItem(`ctr_${ctr}`);
	localStorage.removeItem(`items_${ctr}`);
	localStorage.removeItem(`user_${ctr}`);
}

function BAO(){
	hideElems('bao');
	console.log("order count: ",orderCount);
	
	
	//let user = localStorage.getItem("");
	
	if(orderCount < 1){
		showSelectError('bao','order');
	}
	
	else{
	ret = [], hasUnfilledVals = false;

	for(let i = 0; i < orderCount; i++){
		let BAOitem = `#bao-${i}`;
		hasUnfilledVals = false;
		notes = $(`${BAOitem} textarea.notes`).val();
		user = localStorage.getItem(`user_${i}`);
		items = localStorage.getItem(`items_${i}`);
		console.log("notes :",notes);
			if(notes != "" && user && items){
				let temp = {
					id: i,
					data:{
					  notes: notes,
					  user: user,
					  items: items
					}
				};
				BAOlist.push(temp);
			}
			else{
				hasUnfilledVals = true;
			}		
	}
	
	   if(hasUnfilledVals){
		   showSelectError('bao','validation');
	   }
	   else{
		 //console.log("ret: ",ret);
		 
		 /**
		 $('#buup-dt').val(JSON.stringify(ret));
		$('#buup-form').submit();
		
		 **/
		 $('#button-box').hide();
		 $('#result-box').fadeIn();
		console.log("BAOlist: ",BAOlist);
		 baoFire();
	   }
  }
   
}

function baoFire(){
	 let bac = localStorage.getItem("baoCtr");
	     if(!bac) bac = "0";
		 
		 
		
		 let fd = new FormData();
		 fd.append("dt",JSON.stringify(BAOlist[bac]));
		 fd.append("_token",$('#tk').val());
		 
	
	//create request
	const req = new Request("new-order",{method: 'POST', body: fd});
	//console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   txt = response.text();
		   if(response.status === 200){
			  // console.log(response);
			   console.log("xs success: ",txt);
			   return txt;
		   }
		   else{
			    console.log("xs error: ", txt);
			   return {status: "error", message: "Network error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to add order: " + error);			
			$('#result-box').hide();
			$("#button-box").fadeIn();
			BAOlist = [];
	   })
	   .then(res => {
		   console.log(res);
		   let rr = JSON.parse(res);
		   let bac2 = bac;
          bac = parseInt(bac) + 1;
			     localStorage.setItem("baoCtr",bac);
				 
		   if(rr.status == "ok"){
                  $('#result-ctr').html(bac);
				  	localStorage.removeItem(`ctr_${bac2}`);
	               localStorage.removeItem(`items_${bac2}`);
	                localStorage.removeItem(`user_${bac2}`);
				  
				   setTimeout(function(){
			       if(bac >= orderCount){
					  $('#result-box').hide();
					  $("#finish-box").fadeIn();
					  
					  window.location = "orders";
				  }
                  else{
					 baoFire();
				  }				  
		    },4000);
		   }
		   else if(rr.status == "error"){
				     alert("An unknown error has occured. Please try again");
                   $('#result-box').hide();
			$("#button-box").fadeIn();	
            BAOlist = [];			
		   }
		   
		  
	   }).catch(error => {
		    alert("Failed to add order: " + error);			
	   });
}

function updateDeliveryFees(dt){
		
		 let fd = new FormData();
		 fd.append("dt",JSON.stringify(dt));
		 fd.append("_token",$('#tk').val());
		 
	
	//create request
	const req = new Request("settings-delivery",{method: 'POST', body: fd});
	//console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to update delivery: " + error);			
			$('#settings-delivery-loading').hide();
		     $('#settings-delivery-submit').fadeIn();
	   })
	   .then(res => {
		   console.log(res);
          
				 
		   if(res.status == "ok"){
                  $('#settings-d1').html(res.data['delivery1']);
                  $('#settings-d2').html(res.data['delivery2']);
				  $('#settings-delivery-side2').hide();
				  $('#settings-delivery-loading').hide();
		     $('#settings-delivery-submit').fadeIn();		
              $('#settings-delivery-side1').fadeIn();
		   }
		   else if(res.status == "error"){
				     alert("An unknown error has occured. Please refresh the app or try again later");
                   $('#settings-delivery-loading').hide();
		     $('#settings-delivery-submit').fadeIn();					 
		   }
		   
		  
		   
		  
	   }).catch(error => {
		    alert("Failed to update delivery: " + error);	
            $('#settings-delivery-loading').hide();
		     $('#settings-delivery-submit').fadeIn();			
	   });
}

function updateBank(dt){
		
		 let fd = new FormData();
		 fd.append("dt",JSON.stringify(dt));
		 fd.append("_token",$('#tk-bank').val());
		 
	
	//create request
	const req = new Request("settings-bank",{method: 'POST', body: fd});
	//console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to update bank: " + error);			
			$('#settings-bank-loading').hide();
		     $('#settings-bank-submit').fadeIn();
	   })
	   .then(res => {
		   console.log(res);
          
				 
		   if(res.status == "ok"){
                  $('#settings-bname').html(dt.bname);
                  $('#settings-acname').html(dt.acname);
                  $('#settings-acnum').html(dt.acnum);
				  $('#settings-bank-side2').hide();
				  $('#settings-bank-loading').hide();
		     $('#settings-bank-submit').fadeIn();		
              $('#settings-bank-side1').fadeIn();
		   }
		   else if(res.status == "error"){
				     alert("An unknown error has occured. Please refresh the app or try again later");
                   $('#settings-bank-loading').hide();
		     $('#settings-bank-submit').fadeIn();					 
		   }
		   
		  
		   
		  
	   }).catch(error => {
		    alert("Failed to update bank: " + error);	
            $('#settings-bank-loading').hide();
		     $('#settings-bank-submit').fadeIn();			
	   });
}

function fetchAnalytics(dt){
		
		 let fd = new FormData();
		 fd.append("dt",JSON.stringify(dt));
		 fd.append("_token",$('#tk-analytics-1').val());
		 
	
	//create request
	const req = new Request("analytics",{method: 'POST', body: fd});
	//console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to update bank: " + error);			
			$('#analytics-1-loading').hide();
		     $('#analytics-1-submit').fadeIn();
	   })
	   .then(res => {
		   console.log("res:",res);
          
				 
		   if(res.status == "ok"){
                let dt = JSON.parse(res.data);
				
				console.log("data:",dt);
				
				if(dt || dt.length > 0){
					$('#analytics-1-table').hide();
					let newData = ``;
					
					for(let i = 0; i < dt.length; i++){
						let item = dt[i];
						newData += `
						 <tr>
						   <td>${item.url}</td>
						   <td>${item.pageViews}</td>
						 </tr>
						`;
					}
					$('#analytics-1-table tbody').html(newData);
					$('#analytics-1-table').fadeIn();
				}
				
				
		      $('#analytics-1-loading').hide();
		     $('#analytics-1-submit').fadeIn();		
		   }
		   else if(res.status == "error"){
				     alert("An unknown error has occured. Please refresh the app or try again later");
                   $('#analytics-1-loading').hide();
		     $('#analytics-1-submit').fadeIn();					 
		   }
		   
		  
		   
		  
	   }).catch(error => {
		    alert("Failed to fetch data: " + error);	
            $('#analytics-1-loading').hide();
		     $('#analytics-1-submit').fadeIn();		
	   });
}


function updateDiscounts(dt){
		
		 let fd = new FormData();
		 fd.append("dt",JSON.stringify(dt));
		 fd.append("_token",$('#tk-discount').val());
		 
	
	//create request
	const req = new Request("settings-discount",{method: 'POST', body: fd});
	//console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		   if(response.status === 200){
			   //console.log(response);
			   
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to update discount: " + error);			
			$('#settings-discount-loading').hide();
		     $('#settings-discount-submit').fadeIn();
	   })
	   .then(res => {
		   console.log(res);
          
				 
		   if(res.status == "ok"){
                  $('#settings-nud').html(res.data);
				  $('#settings-discount-side2').hide();
				  $('#settings-discount-loading').hide();
		     $('#settings-discount-submit').fadeIn();		
              $('#settings-discount-side1').fadeIn();
		   }
		   else if(res.status == "error"){
				     alert("An unknown error has occured. Please refresh the app or try again later");
                   $('#settings-discount-loading').hide();
		     $('#settings-discount-submit').fadeIn();					 
		   }
		   
		  
		   
		  
	   }).catch(error => {
		    alert("Failed to update bank: " + error);	
            $('#settings-discount-loading').hide();
		     $('#settings-discount-submit').fadeIn();			
	   });
}

function FCASelectAllProducts(){
	console.log("selecting all products");
    bs = $('button.fca');
	
	if(bs){
		for(let i = 0; i < bs.length; i++){
			b = bs[i];
			console.log(b);  bid = b.id.substring(4);
			console.log("bid",bid);
			FCASelectProduct({id:bid,sku: b.getAttribute('data-sku')});
			//$(`#fca-unselect_${b.id.substring(3)}`).fadeIn();
		}
	    showBulkSelectButton("fca","selectAll");
	
	}
}

function FCAUnselectAllProducts(){
	console.log("unselecting all products");
     bs = $('button.fca');
	
	if(bs){
		for(let i = 0; i < bs.length; i++){
			b = bs[i]; bid = b.id.substring(4);
			console.log("bid",bid);
			FCAUnselectProduct({id: bid,sku: b.getAttribute('data-sku')});
			//$(`#fca-unselect_${bid}`).hide();
		}
		showBulkSelectButton("fca","unselectAll");
	}
}

function FCASelectProduct(dt){
	if(dt.sku){
	  console.log(`fca selecting product ${dt.sku}`);
	  p = $(`button#fca-${dt.id}`);
	  if(p){
		   p.attr('disabled',true);
		   
		   $(`#fca-unselect_${dt.id}`).fadeIn();
		  let pp = fcaList.find(i => i.sku == dt.sku);
		  console.log('pp: ',pp);
		 
		  if(pp){
			pp.selected = true;  
		  }
		  else{
			fcaList.push({sku: dt.sku,selected: true});  
		  } 
	  }
	  
	}
}

function FCAUnselectProduct(dt){
	if(dt.sku){
	  console.log(`unselecting product ${dt.sku}`);
	  p = $(`button#fca-${dt.id}`);
	  
	  if(p){
		  p.attr('disabled',false);
		  $(`#fca-unselect_${dt.id}`).hide();
		  let us = fcaList.find(i => i.sku == dt.sku);
		  //console.log('us: ',us);
		  
		  if(us){
		    us.selected = false;
		  }
	  }
	  
	}
}

function FCA(dt){
	hideElems('fca');
	console.log("fcaList length: ",fcaList.length);
	let fcAction = $('#fca-action').val();
	if(fcaList.length < 1 || fcAction == "none"){
		if(fcaList.length < 1) showSelectError('fca','product');
		if(fcAction == "none") showSelectError('fca','action');
	}
	else{
		//get fb permission
		let  fbp = localStorage.getItem('ace_fbp'), uu = "https://admin.aceluxurystore.com/facebook-catalog";
		let fbPermRequired = true;
		if(fbp){
			 $('#fca-ftk').val(fbp);
			 fbPermRequired = false;
		}
		else{
			 console.log("Invalid token");
		}
                /**
		Swal.fire({
			showCloseButton: true,
             html: `
               <ul>
                  <li>fbPermRequired: ${fbPermRequired}</li>
                  <li>fbp: ${fbp}</li>
               </ul>
              `
		});**/
		
		if(fbPermRequired){
			//invoke dialog to get code
			
			Swal.fire({
             title: `Your permission is required`,
             imageUrl: "img/facebook.png",
             imageWidth: 64,
             imageHeight: 64,
             imageAlt: `Grant the app catalog permissions`,
             showCloseButton: true,
             html:
             "<h4 class='text-warning'>Facebook <b>requires your permission</b> to make any changes to your Catalog.</h4><p class='text-primary'>Click OK below to redirect to Facebook to grant this app access.</p>"
           }).then((result) => {
               if (result.value) {
                 let cid = dt.cid;
			     window.location = `https://www.facebook.com/v8.0/dialog/oauth?client_id=${cid}&redirect_uri=${uu}&state=${dt.ss}&scope=catalog_management`;
                }
              });
		}
		else{
			$('#fca-dt').val(JSON.stringify(fcaList));
			 $('#fca-form').submit();
		}
		
	}
}

function getFBToken(dt){
		 //let uuu = "https://admin.aceluxurystore.com/facebook-catalog";
		 let uuu = dt.redirect_uri;
		 let uu = `https://graph.facebook.com/v12.0/oauth/access_token?client_id=${dt.cid}&client_secret=${dt.edf}&redirect_uri=${uuu}&code=${dt.code}`;
		 
	
	//create request
	const req = new Request(uu,{method: 'GET'});
	//console.log(req);
	
	
	//fetch request
	fetch(req)
	   .then(response => {
		  if(response.status === 200){  
			   return response.json();
		  }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    alert("Failed to get token: " + error);			
			$('#settings-discount-loading').hide();
		     $('#settings-discount-submit').fadeIn();
	   })
	   .then(ret => {
		   console.log("ret: ",ret);
		  /** Swal.fire({
			showCloseButton: true,
             html: `
               <ul>
                  <li>ret: ${JSON.stringify(ret)}</li>
               </ul>
              `
		});**/
		   if(ret){
         
		     if(ret.accessToken){
                  let ace_fbp = ret.accessToken;
				  localStorage.setItem("ace_fbp",JSON.stringify(ace_fbp));
		     }
		   }
		   
		  
	   }).catch(error => {
		    alert("Failed to get token: " + error);				
	   });
}

function saveFBToken(dt){
	let uu = `save-fb-token?dt=${dt}`
    const req = new Request(uu,{method: 'GET'})

//fetch request
fetch(req)
  .then(response => {
	 if(response.status === 200){  
		  return response.json();
	 }
	  else{
		  return {status: "error", message: "Technical error"};
	  }
  })
  .catch(error => {
	   alert("Failed to save token: " + error)
  })
  .then(ret => {
	  console.log("ret: ",ret)
	 
	  if(ret?.status == 'ok'){
			 localStorage.setItem("ace_fbp",dt)
	  }
	  
	 
  }).catch(error => {
	   alert("Failed finally to save token: " + error);				
  });
}

function getFBToken2(callback){
	let uu = `get-fb-token`
    const req = new Request(uu,{method: 'GET'})

//fetch request
fetch(req)
  .then(response => {
	 if(response.status === 200){  
		  return response.json();
	 }
	  else{
		  return {status: "error", message: "Technical error"};
	  }
  })
  .catch(error => {
	   alert("Failed to get fb token: " + error)
  })
  .then(ret => {
	  console.log("ret: ",ret)
	  
	  let value = ret?.value ? ret : {}
	  callback(value)
	  
	 
  }).catch(error => {
	   alert("Failed finally to get fb token: " + error);				
  });
}

function fetchReport(dt){
		 
	let error_handle = "reports";
	if(dt.type == "best-selling-products") error_handle = "reports-2";
	//create request
	let url = `report?type=${dt.type}&from=${dt.from}&to=${dt.to}&range=${dt.range}`, s1 = "An unknown error has occured. Please try again later.";
	const req = new Request(url,{method: 'GET'});
	
	//fetch request
	fetch(req)
	   .then(response => {
		   
		   if(response.status === 200){   
			   return response.json();
		   }
		   else{
			   return {status: "error", message: "Technical error"};
		   }
	   })
	   .catch(error => {
		    Swal.fire({
			 icon: "error",
             title: error
           });
		   $(`#${error_handle}-loading`).hide();
		   $(`#${error_handle}-btn`).fadeIn();
				    
	   })
	   .then(res => {
		   console.log(res);
				 
		   if(res.status == "ok"){
               let d = res.data;  
			   
			   
			   if(dt.type == "total-revenue"){
				   //{x: '{{$date->format("d M")}}',y: {{$item['amount']}}}
				   $('#reports-bar').hide();
				      $('#reports-bar').html("");
					  
				   if(d.length > 0){
				     Morris.Bar({
                      element: 'reports-bar',
                      data: d,
                      xkey: 'x',
                      ykeys: ['y'],
                      labels: ['Revenue(N)'],
                      barColors: ['#5969ff'],
                       resize: true,
                          gridTextSize: '14px'
                     });   
				   }
				   else{
					   $('#reports-bar').html("<h3>No data could be found.</h3>");
				   }
				   
				   $('#reports-bar').fadeIn();
			   }
			   else if(dt.type == "best-selling-products"){
				   //{ value: 70, label: 'foo' },
				   $('#reports-2-donut').hide();
				      $('#reports-2-donut').html("");
					  
				   if(d.length > 0){
				     Morris.Donut({
                element: 'reports-2-donut',
                data: d,
             
                labelColor: '#fff',
                   gridTextSize: '14px',
                colors: [
                     "#5969ff",
                                "#ff407b",
                                "#25d5f2",
                                "#ffc750"
                               
                ],

                formatter: function(x) { return "N" + x },
                  resize: true
            });   
				   }
				   else{
					   $('#reports-2-donut').html("<h3>No data could be found.</h3>");
				   }
				   
				   $('#reports-2-donut').fadeIn();
			   }
			   
			   
			   
		   }
		   else if(res.status == "error"){
			   let msg = ``;
			   
			   if(res.message == "duplicate"){
				   msg = `The email address has been used before.`;
			   }
			   else if(res.message == "validation"){
				   msg = `All fields are required.`;
			   }
			   else{
				   msg = `An unknown error has occured, please try again.`;
			   }

               Swal.fire({
			 icon: "error",
             title: msg
           });			   
			   
		   }
		   $(`#${error_handle}-loading`).hide();
		   $(`#${error_handle}-btn`).fadeIn();	
			
	   }).catch(error => {
		    Swal.fire({
			 icon: "error",
             title: error
           });
		   $(`#${error_handle}-loading`).hide();
		   $(`#${error_handle}-btn`).fadeIn();
	   });
}
