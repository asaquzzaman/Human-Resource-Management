<template>
	<div>
		<div class="hrm-attendance" id="hrm-subtab-wrap">
			<hrm-attendance-header></hrm-attendance-header>
		</div>
	</div>

</template>

<script>
	import hrm_attendance_header from './attendance-header.vue';

	export default {
		mixins: [HRMMixin.attendance],
		
		data: function() {
			return {
				//punch_in_date: 'sdgfashjfdgsad',
				//punch_out_date: '',
				//search_user_id: ''
			}
		},

		components: {
			//'hrm-attendace-punch-in-out-btn': hrm_attendace_punch_in_out_btn,
	 	    //'hrm-attendace-records': hrm_attendace_records,
	 	    //'hrm-attendance-configuration': hrm_attendace_configuration,
	      	'hrm-attendance-header': hrm_attendance_header,
	      	//'hrm-attendace-user-search': hrm_attendace_user_search
		},

		computed: {

		},
		
		methods: {

		}	
	}
</script>

