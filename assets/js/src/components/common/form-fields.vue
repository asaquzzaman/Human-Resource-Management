<template>
	<div>
        <div v-for="(field, field_index) in fields" class="hrm-form-field ">

        	<div v-if="field.type == 'template'">
	            <label for="title">
	                {{ field.label }}<em v-if="field.required">*</em>
	            </label>
	            <div class="hrm-descriptive-wrap">
			        <div class="hrm-descriptive-content" v-html="field.model"></div>
			    </div>
        	</div>
        	
        	<div v-if="field.type == 'text'">
	            <label for="title">
	                {{ field.label }}<em v-if="field.required">*</em>
	            </label>
	            <input type="text" v-model="field.model">
	            <span class="hrm-clear"></span>
	            <span class="description"></span>
        	</div>

        	<div v-if="field.type == 'datePickerFrom'">
        		<label for="title">
	                {{ field.label }} <em v-if="field.required">*</em>
	            </label>
	        	<hrm-date-picker placeholder="From" v-model="field.model"  class="pm-datepickter-to" dependency="pm-datepickter-from"></hrm-date-picker>
	          	<span class="hrm-clear"></span>
            	<span class="description"></span>
        	</div>

        	<div v-if="field.type == 'datePickerTo'">
        		<label for="title">
	                {{ field.label }}<em v-if="field.required">*</em>
	            </label>
	        	<hrm-date-picker placeholder="To" v-model="field.model"  class="pm-datepickter-to" dependency="pm-datepickter-from"></hrm-date-picker>
	          	<span class="hrm-clear"></span>
            	<span class="description"></span>
        	</div>

        	<div v-if="field.type == 'textarea'">

        		<label for="description">
					{{ field.label }} <em v-if="field.required">*</em>
				</label>
				<textarea name="description" v-model="field.model" class="hrm-des-field" id="description"></textarea>
				<span class="hrm-clear"></span>
				<span class="description"></span>
        	</div>

        	<div v-if="field.type == 'file'">

        		<label for="description">
					{{ field.label }} <em v-if="field.required">*</em>
				</label>
				<hrm-file-uploader :files="field.model" :multiple="field.multiple" :attr="field.attr" :delete="field.deleted_files"></hrm-file-uploader>
				<span class="hrm-clear"></span>
				<span class="description"></span>
        	</div>

        	<div v-if="field.type == 'radio'">

        		<label for="description">
					{{ field.label }} <em v-if="field.required">*</em>
				</label>
				<span class="hrm-radio-wrap" v-for="(option, optKey) in field.options" :key="optKey">
					<input type="radio" :value="option.value" v-model="field.model" :id="option.name">
					<label class="hrm-radio" :for="option.name">{{ option.label }}</label>
				</span>
				<span class="hrm-clear"></span>
				<span class="description"></span>
        	</div>

        	<div v-if="field.type == 'checkbox'">

        		<label for="description">
					{{ field.label }} <em v-if="field.required">*</em>
				</label>
				<span class="hrm-checkbox-wrap" v-for="(option, optKey) in field.options" :key="optKey">
					<input type="checkbox" :value="option.value"  v-model="field.model" :id="option.name">
					<label class="hrm-checkbox" :for="option.name">{{ option.label }}</label>
				</span>
				<span class="hrm-clear"></span>
				<span class="description"></span>
        	</div>

        	<div v-if="field.type == 'multiSelect'" class="hrm-form-field hrm-leave-type-wrap">
				<label>
					{{ field.label }}
					<em v-if="field.required">*</em>
				</label>
				<div class="hrm-multiselect">

			        <hrm-multiselect 
			            v-model="field.model" 
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
			    <div class="hrm-clear"></div>
			</div>

			<div v-if="field.type == 'select'" class="hrm-form-field hrm-leave-type-wrap">
				<label>
					{{ field.label }}
					<em v-if="field.required">*</em>
				</label>
				<div class="hrm-multiselect">

			        <hrm-multiselect 
			            v-model="field.model" 
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
			    <div class="hrm-clear"></div>
			</div>
        </div>
	</div>
</template>

<script>
	
	export default {
		props: {
			fields: {
				type: [Array],
				default () {
					return [];
				}
			}
		},

		data () {
			return {
				files: [],
        		deleted_files: [],
			}
		},

		components: {
			'hrm-multiselect': hrm.Multiselect.Multiselect
		}
	}
</script>




