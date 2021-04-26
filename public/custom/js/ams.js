var pregnancy_days = 284; //original 283 but we have added 1 days extra

jQuery(document).ready(function () {
		"use strict";
		if(jQuery( ".confirm" ).length > 0) {
			jQuery('.confirm').on('click', function (e) {
				if (confirm(jQuery(this).attr('confirm'))) {
					return true;
				} else {
					return false;
				}
			});
		}
		$('.decimal').on('keydown', function (event) {
			return isNumber(event, this);
		});
		function isNumber(evt, element) {
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if ((charCode != 190 || $(element).val().indexOf('.') != -1)  // “.” CHECK DOT, AND ONLY ONE.
					&& (charCode != 110 || $(element).val().indexOf('.') != -1)  // “.” CHECK DOT, AND ONLY ONE.
					&& ((charCode < 48 && charCode != 8)
							|| (charCode > 57 && charCode < 96)
							|| charCode > 105))
				return false;
			return true;
		}
		
		$("#calculator").Calculadora({
				EtiquetaBorrar:'Clear',
				ClaseBtns1: 'warning', /* Color Numbers*/
				ClaseBtns2: 'success', /* Color Operators*/
				ClaseBtns3: 'primary', /* Color Clear*/
				TituloHTML:'<h2>Develoteca.com</h2>',
				Botones:["+","-","*","/","0","1","2","3","4","5","6","7","8","9",".","="]
	
				
		 });
	
		if(jQuery('.sidebar-menu').length > 0){
			jQuery('.sidebar-menu').tree();
		}
		if(jQuery( ".text_editor" ).length > 0) {
			CKEDITOR.replace( jQuery( ".text_editor" ).attr('id') );
		}
		if(jQuery('.js-example-basic-single').length > 0){
			init_select_box();
		}
		setTimeout(function(){
	  		$(".alert").slideUp();
		}, 4000);
		
		if($("#confirmPass").length > 0) {
			$('#confirmPass').on('keyup', function () {
			  if ($('#newPass').val() == $('#confirmPass').val()) {
				$('#confirmMsg').html('Password Matched !').css('color', 'green');
			  } else 
				$('#confirmMsg').html('Password Do not Matched !').css('color', 'red');
			});
		}
		
		$('#btnSave').on('click',function(){
			if ($('#newPass').val() == $('#confirmPass').val()){
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				method: "POST",
				url: $(this).data('url'),
				data: {
				  'id': $('input[name=id]').val(),
				  'name': $('input[name=name]').val(),
				  'exist_password': $('input[name=exist_password]').val(),
				  'old_password': $('input[name=old_password]').val(),
				  'password': $('input[name=password]').val(),
				  'confirm_password': $('input[name=confirm_password]').val(),
				},
				dataType: "json",
				success: function(data){
					$('#notifyMsg').html(data[0]).css('color',data[1]);
				  	$('#notifyMsg').delay(500).fadeIn('normal', function() {
					$(this).delay(2000).fadeOut();
				 });
				},
				error: function(data){
				}
			  });
			} else {
			  $('#confirmMsg').html('Password Do not Matched!!').css('color', 'red');
			  return false;
			}
	 });
       	$("#image-select").change(function(){
            readURL(this);
        });
		
		//--------password validation section--------//
		$('#pass2').on('keyup', function () {
		  if ($('#pass1').val() == $('#pass2').val()) {
			$('#confirmMsg').html('Password Matched!!').css('color', 'green');
		  } else 
			$('#confirmMsg').html('Password Do not Matched!!').css('color', 'red');
		});
		$('#saveInfo').on('click',function(){
			if ($('#pass1').val() == $('#pass2').val()){
				return true;
			}else{
				 $('#confirmMsg').html('Password Do not Matched!!').css('color', 'red');
				return false;
			}
		})
		
		//staff list page
		$('.staffStatusUpdate').on('click',function(){
			if($(this).prop("checked") == true){
				  var dataId = $(this).data('id');
				  $.ajax({
					  headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
					  method: "POST",
					  url: $(this).data('url'),
					  data: {
						'status': 1,
						'id'    : dataId
					  },
					  dataType: "json",
					  success: function(data){
						
						$.notify(data[0],'success');    
					  },
					  error: function(data){
					   
					  }
				  });
			}else{
				  var dataId = $(this).data('id');
				  $.ajax({
					  headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
					  method: "POST",
					  url: $(this).data('url'),
					  data: {
						'status': 0,
						  'id' : dataId
					  },
					  dataType: "json",
					  success: function(data){
						$.notify(data[1],'warning');    
					  },
					  error: function(data){
					   
					  }
				  });
			}
  		})
		
		//salary create
		$('#employeeList').change(function(){
			var dataSalary = $('#employeeList option:selected').data('salary');
			if($('#employeeList').val() !=''){
				$('#salary').val(dataSalary);
			}
		});
		
		//slider
		if($("#health_score").length > 0){
			$("#health_score").ionRangeSlider({
				min: 0,
				max: 100,
				from: 0
			});
			var health_data = $("#health_data").val();
			var instance = $('#health_score').data("ionRangeSlider");
			instance.update({
			  from: health_data //your new value
			});
		}
		
		$("#profile-image-select").change(function(){
        	 readURLSupplier(this);
        });
		
		$(".checkAll").click(function(){
			var id = $(this).attr('id');
			$('#checkboxBlock_'+id+' input:checkbox').not(this).prop('checked', this.checked);
		  });
		
		$("#system-logo,#super_admin_logo").change(function(){
            readURLSettings(this);
        });
		
		jQuery(".printReports").on( "click", function() {
			var reportTablePrint=document.getElementById("printBox");
			var newWin= window.open("");
			newWin.document.write('<html><head><title></title>');
			newWin.document.write($("#print_url_1").val());
			newWin.document.write($("#print_url_2").val());
			newWin.document.write($("#print_url_3").val());
			newWin.document.write('</head><body >');
			newWin.document.write(reportTablePrint.innerHTML);
			newWin.document.write('</body></html>');
			newWin.document.close();
			//newWin.print();
			//newWin.close();
			setTimeout(function(){ newWin.print(); }, 2000);
		});
		jQuery(".printReport").on( "click", function() {
		   var reportTablePrint=document.getElementById("print-box");
		   var newWin = window.open('');
		   newWin.document.write('<html><head><title></title>');
		   newWin.document.write($("#print_url_1").val());
		   newWin.document.write($("#print_url_2").val());
		   newWin.document.write('</head><body >');
		   newWin.document.write(reportTablePrint.innerHTML);
		   newWin.document.write('</body></html>');
		   newWin.document.close();
		   newWin.focus();
		   //newWin.print();
		   //newWin.close();
		   setTimeout(function(){ newWin.print(); }, 2000);
		   return true;
		});
		
		var _select_lang = $("#select").val();
		
		jQuery(".loadCow").on( "change", function() { //loadCow
			var shed_no = $("#shed_no").val();
			var html = '<option value="0">'+_select_lang+'</option>';
			$("#cow_id").html(html);
			if(shed_no > 0){
				$.ajax({
					headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					method: "POST",
					url: $(this).data('url'),
					data: {
					  'shed_no': shed_no,
					},
					dataType: "json",
					success: function(data){
						$.each(data, function( index, value ) {
							html += '<option value="'+value.id+'">000'+value.id+'</option>';
						});
						$("#cow_id").html(html);
					},
					error: function(data){
						console.log('DFLog: reload Page');
					}
				});
			}
		});
		
		jQuery(".animal-details-by-stall-no").on( "change", function() { //getAnimalIdByAnimalId
			$("#animal-details").html('<i class="fa fa-spinner fa-2x fa-spin"></i>');
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				method: "POST",
				url: $(this).data('url'),
				data: {id:this.value},  
				dataType: 'html',    
				success: function(response){
					$('#animal-details').html(response);
					loadAjaxOwlCarosal();
					if(jQuery( ".confirm-ap" ).length > 0) {
						reloadDatePicker();
						jQuery('.confirm-ap').on('click', function (e) {
							if (confirm(jQuery(this).attr('confirm'))) {
								return true;
							} else {
								return false;
							}
						});
					}
				},
				error: function(data){
			}
		  });
	  });
		
		
	jQuery(".load-cow-vacine-page").on( "change", function() { //loadCowVaccinePage
		$('#animal-details').html('');
		var shed_no = $("#shed_no").val();
		var html = '<option value="0">'+$("#select").val()+'</option>';
		$("#cow_id").html(html);
		if(shed_no > 0){
			$.ajax({
				headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				  },
				method: "POST",
				url: $(this).data('url'),
				data: {
				  'shed_no': shed_no,
				},
				dataType: "json",
				success: function(data){
					$.each(data, function( index, value ) {
						html += '<option value="'+value.id+'">000'+value.id+'</option>';
					});
					$("#cow_id").html(html);
				},
				error: function(data){
				}
			});
		}
	 });
	
	jQuery(".load-cow-pregnancy-page").on( "change", function() { //loadCowPregnancyPage
		$('#animal-details').html('');
		var shed_no = $("#stall_no").val();
		var html = '<option value="0">'+$("#select").val()+'</option>';
		$("#cow_id").html(html);
		if(shed_no > 0){
			$.ajax({
				headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				  },
				method: "POST",
				url: $(this).data('url'),
				data: {
				  'shed_no': shed_no,
				},
				dataType: "json",
				success: function(data){
					$.each(data, function( index, value ) {
						html += '<option value="'+value.id+'">000'+value.id+'</option>';
					});
					$("#cow_id").html(html);
				},
				error: function(data){
				}
			});
		}
	});
	
	jQuery(".load-cow-statistics-page").on( "change", function() { //loadCowForAjaxStatistics
		$('#animal-details').html('');
		var shed_no = $("#shed_no").val();
		var html = '<option value="0">'+$("#select").val()+'</option>';
		$("#cow_id").html(html);
		if(shed_no > 0){
			$.ajax({
	            headers: {
	                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	              },
	            method: "POST",
	            url: $(this).data('url'),
	            data: {
	              'shed_no': shed_no,
	            },
	            dataType: "json",
	            success: function(data){
	              	$.each(data, function( index, value ) {
						html += '<option value="'+value.id+'">000'+value.id+'</option>';
					});
					$("#cow_id").html(html);
	            },
	            error: function(data){
	            }
	        });
		}
	});
	
	jQuery(".animal-ajax-statistics").on( "change", function() { //getAnimalIdByAnimalIdForAjaxStatistics
			$("#animal-details").html('<i class="fa fa-spinner fa-2x fa-spin"></i>');
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				method: "POST",
				url: $(this).data('url'),
				data: {id:this.value},  
				dataType: 'html',    
				success: function(response){
					$('#animal-details').html(response);
					loadAjaxOwlCarosal();
					
				},
				error: function(data){
			}
		  });
	});
	
	
	jQuery(".load-animal-milk-collect-page").on( "change", function() {  //getAnimalIdBYStallId
			var box_id = $(this).data('select');
			var _html = '<option value="">'+$("#select").val()+'</option>';
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				method: "POST",
				url: $(this).data('url'),
				data: {id:this.value},  
				dataType: 'json',    
				success: function(response){
					if(response['data'] != null){
						if(typeof response['data'] != 'undefined' && response['data'] != null){
							for(var i=0;i<response['data'].length;i++){
								if(typeof response['data'][i] != 'undefined'){
									_html += '<option value="'+response['data'][i]['id']+'">000'+response['data'][i]['id']+'</option>';
								}
							}
						}
					}
					jQuery('#'+box_id).html(_html);
				},
				error: function(data){
			}
	  	});
	});
	
	
		
});

function readURLSettings(input) {
	if (input.files && input.files[0]) {
	var reader = new FileReader();
	reader.onload = function (e) {
		console.log('#'+input.id+'-img');
		$('#'+input.id+'-img').attr('src', e.target.result);
	}
		reader.readAsDataURL(input.files[0]);
	}
}


function readURLSupplier(input) {
	if (input.files && input.files[0]) {
	var reader = new FileReader();
	reader.onload = function (e) {
		$('#profile-image').attr('src', e.target.result);
	}
		reader.readAsDataURL(input.files[0]);
	}
}

function readURLManageCow(input){
	var fieldid = (input.id).split('_');
	if (input.files && input.files[0]) {
		var reader = new FileReader();
	reader.onload = function (e) {
	  $('#previewImage_'+fieldid[1]).attr('src', e.target.result);
	  $('#div_'+fieldid[1]).find('.imgHdn').remove();
	}
	reader.readAsDataURL(input.files[0]);
  }
}
  
function preview_Images_manage_cow(obj){ 
	readURLManageCow(obj);
}

function changeCow(row){
	var img = $('#cowid_'+row+' option:selected').data('image');
	$('#img_'+row).attr('src', $("#site_assets_url").val()+img);
	$("#shedno_"+row).val($('#cowid_'+row+' option:selected').data('shadeno'));
	$("#shedname_"+row).html($('#cowid_'+row+' option:selected').data('shedname'));
}

function loadCowSell(row, _this){
	var cowtype = $('#cowtype_'+row).val();
	$("#cowid_"+row).html('<option value="">'+$("#select").val()+'</option>');
	$("#shedno_"+row).val('');
	$("#shedname_"+row).html('');
	$('#img_'+row).attr('src', $(_this).data('noimage'));
	if(cowtype){
		$.ajax({
			headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  },
			method: "POST",
			url: $(_this).data('url'),
			data: {
			  'cowtype': cowtype,
			},
			dataType: "json",
			success: function(data){
				//console.log(data);
				var html = '<option value="">'+$("#select").val()+'</option>';
				$.each(data, function( index, value ) {
					html += '<option value="000'+value.id+'" data-image="'+value.pictures+'" data-shedname="'+value.shed_number+'" data-shadeno="'+value.shade_no+'">000'+value.id+'</option>';
				});
				$("#cowid_"+row).html(html);
			},
			error: function(data){
			}
		});
	}
}

function calculateCowSell(){
	var total_price = total_paid = due = 0;
	if($("#total_price").val()){
		total_price = $("#total_price").val();
	}
	if($("#total_paid").val()){
		total_paid = $("#total_paid").val();
	}
	due = parseFloat(total_price) - parseFloat(total_paid);
	$("#due").val(due.toFixed(2));
}
function totalPriceCowSell(){
	if($(".cowprice").length > 0){
		var total = 0;
		$(".cowprice").each(function(){
			var _value = this.value != '' ? this.value : 0;
			total += parseFloat(_value);
		});
	}
	$("#total_price").val(total);
}


function calculateSaleMilk(id, obj) {
	var liter = 0;
	var price = 0;
	var total = 0;
	var paid = 0;
	var due = 0;
	
	var stock = 0;
	
	if($("#milk_account_number_"+id).val()){
	price = $("#milk_account_number_"+id+" option:selected").data('price');
	stock = $("#milk_account_number_"+id+" option:selected").data('stock');
	$('#liter_price_'+id).val(price);
	}else{
	alert('Please Select Account Number First');
	$("#view-stock-info").slideUp();
	}
	
	
	if($('#liter_'+id).val()){
	liter = $('#liter_'+id).val();
	}
	
	if($('#paid_'+id).val()){
	paid = $('#paid_'+id).val();
	}
	
	total = liter*price;
	due = total-paid;
	
	$('#total_'+id).val(total);
	$('#due_'+id).val(due);
	
	if(typeof obj != 'undefined' && obj.value != ''){
		getAccountStockStatus(obj.value, stock);
	}
}

function loadSupplierData(id){
	if($("#supplier_id_"+id).val()){
		var name = $("#supplier_id_"+id+" option:selected").data('name');
		var email = $("#supplier_id_"+id+" option:selected").data('email');
		var phn_number = $("#supplier_id_"+id+" option:selected").data('phn_number');
		var address = $("#supplier_id_"+id+" option:selected").data('address');
		$('#name_'+id).val(name);
		$('#email_'+id).val(email);
		$('#contact_'+id).val(phn_number);
		$('#address_'+id).val(address);
		}else{
		$('#name_'+id).val('');
		$('#contact_'+id).val('');
		$('#address_'+id).val('');
	}
}

function getAccountStockStatus(accNo, stock){
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		method: "POST",
		url: $("#hdnStockUrl").val(),
		data: {id:accNo},  
		dataType: 'json',    
		success: function(response){
			if(response.data != null){
				$("#milk-in-stock span").html(milkAvailavleStock(stock, response.data['total_sold']));
				$("#stock-paid span").html(dairyFarm.currency(response.data['total_paid']));
				$("#stock-due span").html(dairyFarm.currency(response.data['total_due']));
			} else {
				$("#milk-in-stock span").html(milkAvailavleStock(stock, 0));
				$("#stock-paid span").html(dairyFarm.currency(0));
				$("#stock-due span").html(dairyFarm.currency(0));
			}
			$("#view-stock-info").slideDown();
		},
		error: function(data){
	}
  });
}

function loadAjaxOwlCarosal(){
	$('.cm-slider').owlCarousel({
		loop:false,
		margin:10,
		nav:true,
		dots: false,
		autoplay: true,
		responsiveClass:true,
		navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
		responsive:{
			0:{
				items:1,
				nav:true
			},
			600:{
				items:1,
				nav:false
			},
			1000:{
				items:1,
				nav:true,
				loop:false
			}
		}
	})
}

function submitDeliveryForm(){
	if($("#pregnant_progress").val()=="1"){
		alert("This cow pragnant already processing, so after complete this you can create next one.");
		return false;
	} else {
		return true;
	}
}

function calculate(id) {
	var liter = 0;
	var price = 0;
	var total = 0;
	if($('#liter_'+id).val()){
	liter = $('#liter_'+id).val();
	}
	if($('#liter_price_'+id).val()){
	price = $('#liter_price_'+id).val();
	}
	
	total = liter*price;
	$('#total_'+id).val(total);
}

function readURLMonitor(input){
	var fieldid = (input.id).split('_');
	if (input.files && input.files[0]) {
		var reader = new FileReader();
	reader.onload = function (e) {
	  $('#previewImage_'+fieldid[1]).attr('src', e.target.result);
	  $('#div_'+fieldid[1]).find('.imgHdn').remove();
	}
	reader.readAsDataURL(input.files[0]);
  }
}
function monitor_preview_Images(obj){ 
	readURLMonitor(obj);
}

function readURL(input) {
	if (input.files && input.files[0]) {
	var reader = new FileReader();
	reader.onload = function (e) {
		$('#image').attr('src', e.target.result);
	}
		reader.readAsDataURL(input.files[0]);
	}
}

function reloadDatePicker(){
	if(jQuery( ".wsit_datepicker" ).length > 0) {
		jQuery( ".wsit_datepicker" ).datepicker({format: 'mm/dd/yyyy', autoclose: true, todayHighlight: true});
	}	
}

jQuery(function() {
	if(jQuery( ".wsit_datepicker" ).length > 0) {
		jQuery( ".wsit_datepicker" ).datepicker({format: 'mm/dd/yyyy', autoclose: true, todayHighlight: true});
	}
	if(jQuery( ".age_datepicker" ).length > 0) {
		jQuery( ".age_datepicker" ).datepicker({format: 'mm/dd/yyyy', autoclose: true, todayHighlight: true});
		$('.age_datepicker').datepicker().on('changeDate', function (ev) {
			var date1 = new Date($('.age_datepicker').val()); 
			var date2 = new Date(todayDate()); 
			var Difference_In_Time = date2.getTime() - date1.getTime(); 
			var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 
			$("#age").val(Difference_In_Days);
			//month conversion 
			var _month = parseInt(Difference_In_Days) / 30;
			$(".animal-month").html(_month.toFixed(2) + ' Month');
			
		});
	}
	
	if(jQuery( ".wsit_datepicker_calc_p_date" ).length > 0) {
		jQuery( ".wsit_datepicker_calc_p_date" ).datepicker({format: 'mm/dd/yyyy', autoclose: true, todayHighlight: true});
		$('.wsit_datepicker_calc_p_date').datepicker().on('changeDate', function (ev) {
			var _date = new Date($('.wsit_datepicker_calc_p_date').val());
			var add = addDays(_date, pregnancy_days);
			$("#app-date-box").html(moment(add).format('MM/DD/YYYY'));
			
			//progress days
			var today_date = new Date(todayDate());
			var pregnancy_start_date = _date;
			var Difference_In_Time = today_date.getTime() - pregnancy_start_date.getTime(); 
			var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24); 
			var diff_value = parseFloat(parseFloat(Difference_In_Days) / parseInt(pregnancy_days)) * 100;
			var percent_done = diff_value.toFixed(2);
			$("#appox-delivery-days").css('width', percent_done+'%');
			if(parseInt(Difference_In_Days) > 0) {
				$("#appox-progress-box .progress-number").html('<b>'+Difference_In_Days+ '</b> / '+(pregnancy_days-1));
			} else {
				$("#appox-progress-box .progress-number").html('<b>0 </b>/'+(pregnancy_days-1));
			}
		});
	}
	
});

function addDays(date, days) {
  var result = new Date(date);
  result.setDate(result.getDate() + days);
  return result;
}

function todayDate(){
	var today = new Date();
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
	var yyyy = today.getFullYear();
	today = mm + '/' + dd + '/' + yyyy;
	return today;
}

function init_select_box() {
	jQuery('.js-example-basic-single').select2();
}


var dairyFarm = {
		currency: function (price){
			if(price != '' && typeof jQuery("#system").val() != "undefined"){
				var config = JSON.parse(jQuery("#system").val());
				if(config != ''){
					if(config.hasOwnProperty('currencyDisable')){
						return price;
					} else {
						if(config.hasOwnProperty('currencySymbol')){
							price = number_format(price,2,config.currencySeparator,",");
							if(config.currencyPosition=='left'){
								if(config.hasOwnProperty('currencySpace')){
									price = config.currencySymbol+' '+price; //with space
								} else {
									price = config.currencySymbol+price; //without space
								}
							} else {
								if(config.hasOwnProperty('currencySpace')){
									price = price+' '+config.currencySymbol; //with space
								} else {
									price = price+config.currencySymbol; //without space
								}
							}
						}
					}
				}
			}
			return price;
		}
};



//format helper
function number_format(number, decimals, dec_point, thousands_point) {
    if (number == null || !isFinite(number)) {
        throw new TypeError("number is not valid");
    }

    if (!decimals) {
        var len = number.toString().split('.').length;
        decimals = len > 1 ? len : 0;
    }

    if (!dec_point) {
        dec_point = '.';
    }

    if (!thousands_point) {
        thousands_point = ',';
    }

    number = parseFloat(number).toFixed(decimals);

    number = number.replace(".", dec_point);

    var splitNum = number.split(dec_point);
    splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
    number = splitNum.join(dec_point);

    return number;
}

function milkAvailavleStock(collect, sell){
	if(collect != '' && parseFloat(collect) > 0){
		var available = parseFloat(collect) - parseFloat(sell);
		return available.toFixed(2);
	} else {
		return '0.00';
	}
}

var ImgRowNumber = $("#num_row").val();
function addMoreImage() {
	var no_image = $("#no_image").val();
	var upload_image_lang = $("#upload_image").val();
	
	ImgRowNumber++; 
	html = '<div class="col-md-3 upload-builder-1" id="div_'+ImgRowNumber+'">';
	html  += '<div class="upload-builder-2">';
	html  += '<div class="upload-builder-3"><a onclick="$(\'#div_'+ImgRowNumber+'\').remove();" class="fa fa-times upload-builder-3a"></a> &nbsp; </div>';
	html  += '<img src="'+no_image+'" class="upload-builder-img" id="previewImage_'+ImgRowNumber+'">';
	html  += '<div class="upload-builder-4">';
	html  += '<label class="btn btn-success btn-xs btn-file upload-builder-5">';
	html  += '<i class="fa fa-folder-open"></i>&nbsp;&nbsp; '+upload_image_lang+' <input class="hideme" type="file" name="animal_image[]" id="inputImage_'+ImgRowNumber+'" onchange="monitor_preview_Images(this);">';
	html  += '</label>';
	html  += '</div>';
	html  += '</div>';
	html  += '</div>';
	jQuery('#imageBlock').append(html);  
}

var RowNumber = $("#num_row_cs").val();
function addMoreImageForSellCow() {
	var no_image = $("#no_image").val();
	var ddl_lang_select = $("#ddl_select_lang").val();
	var ddl_cow_lang = $("#ddl_cow_lang").val();
	var ddl_calf_lang = $("#ddl_calf_lang").val();
	var _data_url = $("#ddl_data_url").val();
	
	RowNumber++; 
	html = '<tr id="tr_'+RowNumber+'">';
	html += '<td>';
	html += '<img src="'+no_image+'" id="img_'+RowNumber+'" class="img-thumbnail img-width-150">';
	html += '</td>';
	html += '<td class="verticalAlign">';
	html += '<select class="form-control" id="cowtype_'+RowNumber+'" name="cowdtls['+RowNumber+'][cow_type]" data-noimage="'+no_image+'" data-url="'+_data_url+'" onchange="loadCowSell('+RowNumber+', this);">';
	html += '<option value="">'+ddl_lang_select+'</option>';
	html += '<option value="1">'+ddl_cow_lang+'</option>';
	html += '<option value="2">'+ddl_calf_lang+'</option>';
	html += '</select>';
	html += '</td>';
	html += '<td class="verticalAlign">';
	html += '<select class="form-control" id="cowid_'+RowNumber+'" name="cowdtls['+RowNumber+'][cow_id]" onchange="changeCow('+RowNumber+');">';
	html += '<option value="">'+ddl_lang_select+'</option>';
	html += '</select>';
	html += '</td>';
	html += '<td class="verticalAlign">';
	html += '<input type="hidden" id="shedno_'+RowNumber+'" name="cowdtls['+RowNumber+'][shed_no]" class="form-control">';
	html += '<span class="stall_box_style" id="shedname_'+RowNumber+'"></span>';
	html += '</td>';
	html += '<td class="verticalAlign">';
	html += '<input type="text" id="sellprice_'+RowNumber+'" name="cowdtls['+RowNumber+'][price]" class="form-control cowprice"  onkeyup="totalPriceCowSell();" value="0.00">';
	html += '</td>';
	html += '<td class="verticalAlign">';
	html += '<a href="javascript:;" onclick="$(\'#tr_'+RowNumber+'\').remove();" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></a>';
	html += '</td>';
	html += '</tr>';

	jQuery('#cow_list').append(html);  
}

var mcRowNumber = $("#num_row_cs").val();
function manageCowImageRow(){
	var no_image = $("#no_image").val();
	mcRowNumber++; 
	html = '<div class="col-md-2 animal-box-height" id="div_'+mcRowNumber+'">';
    html  += '<div class="upload-builder-2">';
    html  += '<div class="upload-builder-3"><a onclick="$(\'#div_'+mcRowNumber+'\').remove();" class="fa fa-times upload-builder-3a"></a> &nbsp; </div>';
	html  += '<img src="'+no_image+'" class="manage-animal-upload" id="previewImage_'+mcRowNumber+'">';
	html  += '<div class="manage-animal-upload-2">';
	html  += '<label class="btn btn-success btn-xs btn-file upload-builder-5">';
	html  += '<i class="fa fa-folder-open"></i>&nbsp;&nbsp; Upload Image <input type="file" name="animal_image[]" id="inputImage_'+mcRowNumber+'" onchange="preview_Images_manage_cow(this);" class="hideme">';
	html  += '</label>';
	html  += '</div>';
	html  += '</div>';
    html  += '</div>';
	jQuery('#imageBlock').append(html);  
}

function printReport() {
   var reportTablePrint=document.getElementById("print-box");
   var newWin = window.open('');
   newWin.document.write('<html><head><title></title>');
   newWin.document.write($("#print_url_1").val());
   newWin.document.write($("#print_url_2").val());
   newWin.document.write('</head><body >');
   newWin.document.write(reportTablePrint.innerHTML);
   newWin.document.write('</body></html>');
   newWin.document.close();
   newWin.focus();
   //newWin.print();
   //newWin.close();
   setTimeout(function(){ newWin.print(); }, 2000);
   return true;
}

jQuery(document).ready(function () {
	if(jQuery('#_pkey').length > 0){
		if(jQuery('#_pkey').val()=='0'){
			jQuery("#verifyApplication").modal('show');
		} else {
			jQuery.ajaxSetup({
			   headers: {
				   'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
			   }
		    })
			jQuery.ajax({
				method: 'POST',
				url: jQuery('#btnAction').data('aurl'),
				dataType: 'json',
				success: function (data) {
					if(data.hasError){
						console.log(data.MSG);
						window.location.reload();
					} else {
						console.log(data.MSG);
					}
				},
				error: function (data) {
					console.log(data.MSG);
				}
			});
		}
	}
	jQuery(".access-key-action").click(function (e) {
		jQuery("#verifyApplication input").removeClass('validate_box');
		var beContinue = true;
		if(jQuery("#pk_email").val()==''){
			jQuery("#pk_email").addClass('validate_box');
			jQuery("#pk_email").focus();
			beContinue = false;
		} else if(jQuery("#pk_website_url").val()==''){
			jQuery("#pk_website_url").addClass('validate_box');
			jQuery("#pk_website_url").focus();
			beContinue = false;
		} else if(jQuery("#pk_purchase_key").val()==''){
			jQuery("#pk_purchase_key").addClass('validate_box');
			jQuery("#pk_purchase_key").focus();
			beContinue = false;
		}
		if(beContinue){
			jQuery(".myloader").show();
			jQuery.ajaxSetup({
			   headers: {
				   'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
			   }
		   })
		   e.preventDefault();
		   var formData = {
				email: jQuery('#pk_email').val(),
				website_url: jQuery('#pk_website_url').val(),
				purchase_key: jQuery('#pk_purchase_key').val()
		   }
		   jQuery.ajax({
				method: 'POST',
				url: jQuery(this).data('url'),
				data: formData,
				dataType: 'json',
				success: function (data) {
					if(!data.hasError){
						alert(data.MSG);
						window.location.reload();
					} else {
						alert(data.MSG);
					}
					jQuery(".myloader").hide();
				},
				error: function (data) {
					jQuery(".myloader").hide();
					alert(data.MSG);
				}
			});	
		}
	});   
});