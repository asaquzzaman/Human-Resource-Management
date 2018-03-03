<template>
	<div>
		<profile-menu></profile-menu>
		<div id="hrm-hidden-form-warp" class="postbox">
	        <div class="hrm-search-head">
	            <h3>Job Location</h3>
	        </div>
	  		
	        <div class="inside" id="hrm-visible-form">
	        	<div class="main">

					<div v-if="jobLocation" class="hrm-content-wrap">

						<label class="hrm-title">Name:</label> 
		        		<div class="hrm-content" v-html="filter(jobLocation.name, 'name')"></div>
		        		<div class="hrm-clear"></div>

		        		<label class="hrm-title">Country:</label> 
		        		<div class="hrm-content" v-html="filter(jobLocation.country_code, 'country' )"></div>
		        		<div class="hrm-clear"></div>

		        		<label class="hrm-title">Province:</label> 
		        		<div class="hrm-content" v-html="filter(jobLocation.state, 'province' )"></div>
		        		<div class="hrm-clear"></div>

		        		<label class="hrm-title">City:</label> 
		        		<div class="hrm-content" v-html="filter(jobLocation.city, 'city' )"></div>
		        		<div class="hrm-clear"></div>

		        		<label class="hrm-title">Address:</label> 
		        		<div class="hrm-content" v-html="filter(jobLocation.address, 'address' )"></div>
		        		<div class="hrm-clear"></div>

		        		<label class="hrm-title">Zip Code:</label> 
		        		<div class="hrm-content" v-html="filter(jobLocation.zipcode, 'zipcode' )"></div>
		        		<div class="hrm-clear"></div>

		        		<label class="hrm-title">Phone:</label> 
		        		<div class="hrm-content" v-html="filter(jobLocation.phone, 'phone' )"></div>
		        		<div class="hrm-clear"></div>

		        		<label class="hrm-title">Fax:</label> 
		        		<div class="hrm-content" v-html="filter(jobLocation.fax, 'fax' )"></div>
		        		<div class="hrm-clear"></div>

		        		<label class="hrm-title">Notes:</label> 
		        		<div class="hrm-content" v-html="filter(jobLocation.note, 'note' )"></div>
		        		<div class="hrm-clear"></div>

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

	export default {
		mixins: [HRMMixin.profile],
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







