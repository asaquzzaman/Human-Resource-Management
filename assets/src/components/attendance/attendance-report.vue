<template>
	<div class="hrm-attendance-report">
		<hrm-attendance-header></hrm-attendance-header>
		<div class="metabox-holder">
			<div class="hrm-addon-block">

				<div class="hrm-block-content">
					<div class="title">
						<h1>Attendance report & customize punch in/out</h1>
					</div>
					<div class="hrm-block-description">
						<span class="text">Generate attendance reports for all employee or individual employee. You can also customize punch-in and punch-out</span>
						<a href="http://wpspear.com/hrm/attendance-report/" target="_blank" class="button button-primary hrm-link">
							Get it now!
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>


<style>
	.text {
		display: block;
		margin: 10px 0;
	}
	.title h1 {
		margin: 0;
		padding: 0;
	}
	.metabox-holder {
		width: 100%
	}
	.hrm-addon-block {
		display: grid;
    	grid-template-columns: 50% 50%;
		
	}
	.hrm-block-content {
		padding: 10px;
		margin: 10px;
		background: #fff;
		border: 1px solid #e5e5e5;
	}
</style>


<script type="text/javascript">
	import hrm_attendance_header from './attendance-header.vue';
	
	export default {
		components: {
			'hrm-attendance-header': hrm_attendance_header
		}
	}
</script>

