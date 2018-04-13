<template>
	<span>
		
        <div v-if="field.type == 'template'" class="hrm-descriptive-wrap">
	        <div  class="hrm-descriptive-content" v-html="record[field.name]"></div>
	    </div>
	
	

        <input :required="field.required" v-if="field.type == 'text'" type="text" v-model="record[field.name]">



    	<hrm-date-picker :required="field.required" v-if="field.type == 'datePickerFrom'" placeholder="From" v-model="record[field.name]"  class="pm-datepickter-to" dependency="pm-datepickter-from"></hrm-date-picker>
    


    	<hrm-date-picker :required="field.required" v-if="field.type == 'datePickerTo'" placeholder="To" v-model="record[field.name]"  class="pm-datepickter-to" dependency="pm-datepickter-from"></hrm-date-picker>
  

	
		<textarea :required="field.required" v-if="field.type == 'textarea'" name="description" v-model="record[field.name]" class="hrm-des-field" id="description"></textarea>
	

	
		<hrm-file-uploader v-if="field.type == 'file'" :files="record[field.name]" :multiple="field.multiple" :attr="field.attr" :delete="field.deleted_files"></hrm-file-uploader>
	


		<span v-if="field.type == 'radio'" class="hrm-radio-wrap" v-for="(option, optKey) in field.options" :key="optKey">
			<input :required="field.required" type="radio" :value="option.value" v-model="record[field.name]" :id="option.name">
			<label class="hrm-radio" :for="option.name">{{ option.label }}</label>
		</span>
	


		<span v-if="field.type == 'checkbox'" class="hrm-checkbox-wrap" v-for="(option, optKey) in field.options" :key="optKey">
			<input :required="field.required" type="checkbox" :value="option.value"  v-model="record[field.name]" :id="option.name">
			<label class="hrm-checkbox" :for="option.name">{{ option.label }}</label>
		</span>
	


		<div v-if="field.type == 'multiSelect'" class="hrm-multiselect">

	        <hrm-multiselect 
	            v-model="selected" 
	            :options="field.options" 
	            :multiple="true" 
	            :close-on-select="true"
	            :clear-on-select="true"
	            :hide-selected="false"
	            :show-labels="true"
	            :placeholder="field.placeholder"
	            select-label=""
	            selected-label="selected"
	            deselect-label=""
	            :taggable="false"
	            :label="field.optionLabel"
	            :track-by="field.trackBy"
	            :allow-empty="true">

	        </hrm-multiselect>               
	    </div>



		<div v-if="field.type == 'select'" class="hrm-multiselect">
	        <hrm-multiselect 
	            v-model="selected" 
	            :options="field.options" 
	            :multiple="false" 
	            :close-on-select="true"
	            :clear-on-select="true"
	            :hide-selected="false"
	            :show-labels="true"
	            :placeholder="field.placeholder"
	            select-label=""
	            selected-label="selected"
	            deselect-label=""
	            :taggable="false"
	            :label="field.optionLabel"
	            :allow-empty="true">

	        </hrm-multiselect>               
	    </div>
	    
	</span>
</template>

<script>
	
	export default {
		props: {
			field: {
				type: [Object],
				default () {
					return {};
				}
			},
			record: {
				type: [Object],
				description () {
					return {};
				}
			},
		},



		data () {
			return {
				files: [],
        		deleted_files: [],
			}
		},

		components: {
			'hrm-multiselect': hrm.Multiselect
		},

		computed: {
			selected: {
				get () {
					var field = this.field;
					var record = this.record;

					if (typeof field.filterComputedGet != 'undefined') {
						return field.filterComputedGet(record[field.name], this);
					} else {
						return record[field.name];
					}
				},

				set (select_val) {
					var field = this.field;
					var record = this.record;
					
					if (typeof field.filterComputedSet != 'undefined') {
						this.record[this.field.name] = field.filterComputedSet(select_val);
					} else {
						
						this.record[this.field.name] = select_val;
					}
					
				}
			}
		},

		created () {
		
		},

		methods: {

			filter (record, field) {
				// if(typeof field.filterEditFieldData === 'undefined') {
				// 	return record[field.name];
				// }

				//return field.filterEditFieldData(record[field.name]);
			}
		},
		filters: {
			filterEditValue (val) {
				console.log(val);
			}
		}
	}
</script>




