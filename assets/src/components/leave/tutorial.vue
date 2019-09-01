<template>
	<div class="hrm-attendance">
		<hrm-leave-header></hrm-leave-header>

		<div>
			<!-- <iframe width="736" height="389" src="https://www.youtube.com/embed/quOCckX6-aI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
			<iframe width="560" height="315" src="https://www.youtube.com/embed/quOCckX6-aI?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
		</div>
		
	</div>

</template>



<script>
	import Header from '@components/leave/leave-header.vue';
	export default {
		components: {
			'hrm-leave-header': Header 
		}
	}
</script>