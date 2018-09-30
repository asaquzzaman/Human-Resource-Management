<template>
	<div class="hrm-attendance-customize">
		<payroll-menu></payroll-menu>
		<div class="metabox-holder">
			<div class="hrm-addon-block">
				<div class="hrm-block-content">
					<div class="title">
						<h1>Loan</h1>
					</div>
					<div class="hrm-block-description">
						<span class="text">HRM loan extension lets you manage the loan that your employees request for.</span>
						<a href="http://wpspear.com/hrm/payroll-loan/" target="_blank" class="button button-primary hrm-link">
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
	import menu from './menu.vue';

	hrm.Vue.component('payroll-menu', menu);
	
	export default {

	}
</script>