jQuery(document).ready(function () {
	//CKEDITOR.replace( 'editor1' );
	jQuery('.confirm').on('click', function (e) {
		if (confirm(jQuery(this).data('confirm'))) {
			return true;
		} else {
			return false;
		}
	});
});
//
if(jQuery('.sidebar-menu').length > 0){
	jQuery(document).ready(function () {
		jQuery('.sidebar-menu').tree()
	})
}

jQuery(function() {
	if(jQuery( ".datepicker" ).length > 0) {
		jQuery( ".datepicker" ).datepicker({format: 'dd-mm-yyyy', autoclose: true});
	}
});

jQuery(document).ready(function() {
    if(jQuery('.js-example-basic-single').length > 0){
		init_select_box();
	}
});

function init_select_box() {
	jQuery('.js-example-basic-single').select2();
}


jQuery(document).ready(function () {
	jQuery("#btn-save").click(function (e) {
	   jQuery.ajaxSetup({
		   headers: {
			   'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
		   }
	   })
	   e.preventDefault();
	   var formData = {
			name: jQuery('#name').val(),
			email: jQuery('#email').val(),
			phone: jQuery('#phone').val(),
			password: jQuery('#password').val(),
			doctor_type: jQuery('#doctor_type').val(),
			doctor_id: jQuery(this).attr('doctor-id'),
	   }
	   jQuery.ajax({
			method: 'PUT', //update
			url: jQuery(this).attr('data-update-url'),
			data: formData,
			dataType: 'json',
			success: function (data) {
				if(data.success){
					alert(data.msg);
					window.location.href = jQuery('#__logout_system').attr('href');
				} else {
					alert(data.msg);
				}
			},
			error: function (data) {
				console.log('Error:', data);
			}
		});
	});
	// chamber save or create event
	jQuery("#btn-chamber").click(function (e) {
	   if(validateChamberForm()){
		   jQuery.ajaxSetup({
			   headers: {
				   'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
			   }
		   })
		   e.preventDefault();
		   var formData = {
				chamber_name: jQuery('#chamber_name').val(),
				chamber_time: jQuery('#chamber_time').val(),
				status: jQuery('#status').val(),
		   }
		   jQuery.ajax({
				method: jQuery(this).attr('post-method'),
				url: jQuery(this).attr('post-url'),
				data: formData,
				dataType: 'json',
				success: function (data) {
					if(data.success){
						window.location.reload();
					} else {
						alert('opps error occured refresh your page and try again.');
					}
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		}
	});
	// chamber update event
	jQuery(".chamber_update").click(function (e) {
	   var chamber_id = jQuery(this).attr('chamber-id');
	   var bContinue = true;
	   if($("#chamber_name_"+chamber_id).val() == ''){
			alert('Chamber name required !!');
			$("#chamber_name_"+chamber_id).focus();
			bContinue = false;
		} else if($("#chamber_time_"+chamber_id).val() == ''){
			alert('Chamber time required !!');
			$("#chamber_time_"+chamber_id).focus();
			bContinue = false;
		}
	   	if(bContinue){
		   jQuery.ajaxSetup({
			   headers: {
				   'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
			   }
		   })
		   e.preventDefault();
		   var formData = {
				chamber_name: jQuery('#chamber_name_'+chamber_id).val(),
				chamber_time: jQuery('#chamber_time_'+chamber_id).val(),
				status: jQuery('#status_'+chamber_id).val(),
		   }
		   jQuery.ajax({
				method: jQuery(this).attr('post-method'),
				url: jQuery(this).attr('post-url'),
				data: formData,
				dataType: 'json',
				success: function (data) {
					if(data.success){
						window.location.reload();
					} else {
						alert('opps error occured refresh your page and try again.');
					}
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		}
	});
	
	// schedule save or create event
	jQuery("#btn-schedule").click(function (e) {
	   if(validateScheduleForm()){
		   jQuery.ajaxSetup({
			   headers: {
				   'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
			   }
		   })
		   e.preventDefault();
		   var formData = {
				schedule_name: jQuery('#schedule_name').val(),
				sort_order: jQuery('#sort_order').val()
		   }
		   jQuery.ajax({
				method: jQuery(this).attr('post-method'),
				url: jQuery(this).attr('post-url'),
				data: formData,
				dataType: 'json',
				success: function (data) {
					if(data.success){
						window.location.reload();
					} else {
						alert('opps error occured refresh your page and try again.');
					}
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		}
	});
	//schedule update
	jQuery(".schedule_update").click(function (e) {
	   var schedule_id = jQuery(this).attr('schedule-id');
	   var bContinue = true;
	   if($("#schedule_name_"+schedule_id).val() == ''){
			alert('Schedule name required !!');
			$("#schedule_name_"+schedule_id).focus();
			bContinue = false;
		}
	   	if(bContinue){
		   jQuery.ajaxSetup({
			   headers: {
				   'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
			   }
		   })
		   e.preventDefault();
		   var formData = {
				schedule_name: jQuery('#schedule_name_'+schedule_id).val(),
				sort_order: jQuery('#sort_order_'+schedule_id).val()
		   }
		   jQuery.ajax({
				method: jQuery(this).attr('post-method'),
				url: jQuery(this).attr('post-url'),
				data: formData,
				dataType: 'json',
				success: function (data) {
					if(data.success){
						window.location.reload();
					} else {
						alert('opps error occured refresh your page and try again.');
					}
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		}
	});
	
	
	// timeline save or create event
	jQuery("#btn-timeline").click(function (e) {
	   if(validateTimelineForm()){
		   jQuery.ajaxSetup({
			   headers: {
				   'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
			   }
		   })
		   e.preventDefault();
		   var formData = {
				timeline_name: jQuery('#timeline_name').val(),
				sort_order: jQuery('#sort_order').val()
		   }
		   jQuery.ajax({
				method: jQuery(this).attr('post-method'),
				url: jQuery(this).attr('post-url'),
				data: formData,
				dataType: 'json',
				success: function (data) {
					if(data.success){
						window.location.reload();
					} else {
						alert('opps error occured refresh your page and try again.');
					}
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		}
	});
	//timeline update
	jQuery(".timeline_update").click(function (e) {
	   var timeline_id = jQuery(this).attr('timeline-id');
	   var bContinue = true;
	   if($("#timeline_name_"+timeline_id).val() == ''){
			alert('Timeline name required !!');
			$("#timeline_name_"+timeline_id).focus();
			bContinue = false;
		}
	   	if(bContinue){
		   jQuery.ajaxSetup({
			   headers: {
				   'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
			   }
		   })
		   e.preventDefault();
		   var formData = {
				timeline_name: jQuery('#timeline_name_'+timeline_id).val(),
				sort_order: jQuery('#sort_order_'+timeline_id).val()
		   }
		   jQuery.ajax({
				method: jQuery(this).attr('post-method'),
				url: jQuery(this).attr('post-url'),
				data: formData,
				dataType: 'json',
				success: function (data) {
					if(data.success){
						window.location.reload();
					} else {
						alert('opps error occured refresh your page and try again.');
					}
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		}
	});
	
	//alert gone
	setTimeout(function(){
	  $(".alert").slideUp();
	}, 4000);
});

//chamber validation
function loadChamberPopup() {
	jQuery("#chamber_modal").modal('show');
}
function validateChamberForm() {
	if($("#chamber_name").val() == ''){
		alert('Chamber name required !!');
		$("#chamber_name").focus();
		return false;
	} else if($("#chamber_time").val() == ''){
		alert('Chamber time required !!');
		$("#chamber_time").focus();
		return false;
	} else {
		return true;
	}
}
//schedule validation
function validateScheduleForm() {
	if($("#schedule_name").val() == ''){
		alert('Schedule name required !!');
		$("#schedule_name").focus();
		return false;
	} else {
		return true;
	}
}

//timeline validation
function validateTimelineForm() {
	if($("#timeline_name").val() == ''){
		alert('Timeline name required !!');
		$("#timeline_name").focus();
		return false;
	} else {
		return true;
	}
}