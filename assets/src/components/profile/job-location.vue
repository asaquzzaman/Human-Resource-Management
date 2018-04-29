<template>
	<div>
		<profile-menu></profile-menu>
		<div id="hrm-location-wrap" class="metabox-holder">
			<div v-if="isFetchRecord" id="hrm-hidden-form-warp" class="postbox">
		        <h2 class="hndle">Job Location</h2>

		  		
		        <div class="inside">
		        	<div  v-if="jobLocation">

						<div class="hrm-content-wrap">

							<label class="hrm-title">Name:</label> 
			        		<div class="hrm-content" v-html="filter(jobLocation.name, 'name')"></div>
			        		<div class="hrm-clear"></div>
			        	</div>

			        	<div class="hrm-content-wrap">
			        		<label class="hrm-title">Country:</label> 
			        		<div class="hrm-content" v-html="filter(jobLocation.country_code, 'country' )"></div>
			        		<div class="hrm-clear"></div>
			        	</div>
			        	<div class="hrm-content-wrap">
			        		<label class="hrm-title">Province:</label> 
			        		<div class="hrm-content" v-html="filter(jobLocation.province, 'province' )"></div>
			        		<div class="hrm-clear"></div>
			        	</div>
			        	<div class="hrm-content-wrap">
			        		<label class="hrm-title">City:</label> 
			        		<div class="hrm-content" v-html="filter(jobLocation.city, 'city' )"></div>
			        		<div class="hrm-clear"></div>
			        	</div>
			        	<div class="hrm-content-wrap">
			        		<label class="hrm-title">Address:</label> 
			        		<div class="hrm-content" v-html="filter(jobLocation.address, 'address' )"></div>
			        		<div class="hrm-clear"></div>
			        	</div>
			        	<div class="hrm-content-wrap">
			        		<label class="hrm-title">Zip Code:</label> 
			        		<div class="hrm-content" v-html="filter(jobLocation.zip_code, 'zip_code' )"></div>
			        		<div class="hrm-clear"></div>
			        	</div>
			        	<div class="hrm-content-wrap">
			        		<label class="hrm-title">Phone:</label> 
			        		<div class="hrm-content" v-html="filter(jobLocation.phone, 'phone' )"></div>
			        		<div class="hrm-clear"></div>
			        	</div>
			        	<div class="hrm-content-wrap">
			        		<label class="hrm-title">Fax:</label> 
			        		<div class="hrm-content" v-html="filter(jobLocation.fax, 'fax' )"></div>
			        		<div class="hrm-clear"></div>
			        	</div>
			        	<div class="hrm-content-wrap">
			        		<label class="hrm-title">Notes:</label> 
			        		<div class="hrm-content" v-html="filter(jobLocation.notes, 'notes' )"></div>
			        		<div class="hrm-clear"></div>

						</div>

					</div>

					<div v-else class="">
						No job location found
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import Countires from '@helpers/countries/countries'
	import Mixin from './mixin'

	export default {
		mixins: [Mixin],
		data () {
			return {
				isFetchRecord: false
			}
		},
		created () {

			this.getJobLocation({
				employee_id: this.$route.params.employeeId,
				callback (res) {

				}
			});
		},

		computed: {
			jobLocation () {
				var location = this.$store.state.profile.jobLocation;
				
				if (jQuery.isEmptyObject(location)) {
					return false;
				};

				return location ? location : false;
			}
		},

		methods: {
			filter (val, key) {
				
				if ( !val ) {
					return '&#8211 &#8211';
				}

				if ( key == 'country' ) {
					let index = this.getIndex( Countires, val, 'code' );

					if ( index ) {
						return Countires[index].name;
					}

					return '&#8211 &#8211';
				}

				return val;
			}
		}
	}
</script>

<style>
	.hrm-title,
	.hrm-content {
		float: left;
	}
	.hrm-title {
		width: 20%;
	}
	.hrm-content-wrap {
		margin-bottom: 10px;
	}
</style>







