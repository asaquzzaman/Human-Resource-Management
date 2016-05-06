;(function($){
	function hrmDefaultdata() {
		return {
			ID: 0,
			data_satatus: null,
			user_name:null,
			email: null,
			first_name: null,
			last_name: null,
			job_title: '-1',
			job_category: '-1',
			job_location: '-1',
			status: null,
			mobile: null,
			joined_date: null,
			job_desc: null
		}
	}

	new Vue({
		el: '#hrm',
		data: {
			employee: hrmDefaultdata(),
		},
		
		methods: {
			hrmSubmit: function(elemt) {
				if( elemt.target.dataset.submit == 'hrm_new_job_title_submit' ) {
					wp.ajax.send( {
                        data: {
                            form_data: $(elemt.target).closest('form').serialize(),
                            action: 'hrm_new_job_title',
                            _wpnonce : hrm_ajax_data._wpnonce 
                        },
                        success: function(res) {
                        	
                            if ( res.id ) {
                            	$('.hrm-job-title-dropdown').append($('<option>', {
								    value: res.id,
								    text: res.data.job_title
								}));

								$('.hrm-job-title-dropdown').val(res.id);
								$('#hrm-eployee-list').slideDown(100);
								$('#hrm-job-title-form-wrap').slideUp(500);
                            }
                        },
                        error: function() {

                        }
                    });
				}

				if( elemt.target.dataset.submit == 'hrm_new_job_location_form_submit' ) {
					wp.ajax.send( {
                        data: {
                            form_data: $(elemt.target).closest('form').serialize(),
                            action: 'hrm_new_job_location',
                            _wpnonce : hrm_ajax_data._wpnonce 
                        },
                        success: function(res) {
                        	
                            if ( res.id ) {
                            	$('.hrm-job-location-dropdown').append($('<option>', {
								    value: res.id,
								    text: res.data.name
								}));

								$('.hrm-job-location-dropdown').val(res.id);
								$('#hrm-job-location-form-wrap').slideUp(500);
								$('#hrm-eployee-list').slideDown(100);
                            }
                        },
                        error: function() {

                        }
                    });
				}

			},

			hrmAddNew: function() {
				$('#hrm-job-title-form-wrap').slideUp(100);
				$('#hrm-job-category-form-wrap').slideUp(100);
				$('#hrm-job-location-form-wrap').slideUp(100);

				this.employee = hrmDefaultdata();

				$('#hrm-eployee-list').slideDown(500);
			},

			hrmCancel: function( ele ) {
				if ( ele.target.dataset.cancel == 'hrm_new_employee_cancel' ) {
					$('#hrm-eployee-list').slideUp(500);
				}

				if ( ele.target.dataset.cancel == 'hrm_new_job_title_cancel' ) {
					$('#hrm-job-title-form-wrap').slideUp(100);
					$('#hrm-eployee-list').slideDown(500);
				}

				if ( ele.target.dataset.cancel == 'hrm_new_job_category_form_cancel' ) {
					$('#hrm-job-category-form-wrap').slideUp(100);
					$('#hrm-eployee-list').slideDown(500);
				}

				if ( ele.target.dataset.cancel == 'hrm_new_job_location_form_cancel' ) {
					$('#hrm-job-location-form-wrap').slideUp(100);
					$('#hrm-eployee-list').slideDown(500);
				}

			},
			hrmEdit: function(element) {
				this.employee = hrmDefaultdata();
				
				var employee_id = element.target.dataset.id,
					employee    = [],
					employee_info = hrm_employee_info[employee_id];

				$.each( hrm_employee, function( key, index ) {
					if ( index.ID == employee_id ) {
						employee = index;
					}
				}); 
				
				this.employee.user_name    = employee.data.user_login;
				this.employee.data_satatus = 'disabled';
				this.employee.email        = employee.data.user_email;
				this.employee.job_title    = employee_info.job_title;
				this.employee.job_category = employee_info.job_category;
				this.employee.job_location = employee_info.job_location;
				this.employee.first_name   = employee_info.first_name;
				this.employee.last_name    = employee_info.last_name;
				this.employee.joined_date  = employee_info.joined_date;
				this.employee.job_desc     = employee_info.job_desc;
				this.employee.mobile       = employee_info.mobile;
				this.employee.status       = employee_info.status;
				this.employee.ID           = employee_id;

				$('#hrm-eployee-list').slideUp(100);
				$('#hrm-eployee-list').slideDown(500);
			},

			showJobTitleForm: function() {
				$('#hrm-eployee-list').slideUp(100);
				$('#hrm-job-title-form-wrap').slideDown(500);
			},

			showJobCategoryForm: function() {
				$('#hrm-eployee-list').slideUp(100);
				$('#hrm-job-category-form-wrap').slideDown(500);
			},

			showJobLocationForm: function() {
				$('#hrm-eployee-list').slideUp(100);
				$('#hrm-job-location-form-wrap').slideDown(500);
			}
		}
	});

})(jQuery);
