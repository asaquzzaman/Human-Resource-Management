<template>
	<div class="hrm-attendance">
		<hrm-attendance-header></hrm-attendance-header>

		<div>
			<iframe width="560" height="315" src="https://www.youtube.com/embed/oOAKppAN1o4?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
		</div>
		
	</div>

</template>



<script>
	import hrm_attendance_header from '@components/attendance/attendance-header.vue';
	export default {
		components: {
			'hrm-attendance-header': hrm_attendance_header 
		}
	}
</script>