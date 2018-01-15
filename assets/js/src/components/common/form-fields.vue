<template>
	<div>
        <div v-for="(field, field_index) in fields" class="hrm-form-field ">
        	
        	<div v-if="field.type == 'text'">
	            <label for="title">
	                {{ field.label }}<em>*</em>
	            </label>
	            <input type="text" v-model="field.model">
	            <span class="hrm-clear"></span>
	            <span class="description"></span>
        	</div>

        	<div v-if="field.type == 'date-picker-from'">
        		<label for="title">
	                {{ field.label }}
	            </label>
	        	<hrm-date-picker placeholder="From" v-model="field.model"  class="pm-datepickter-to" dependency="pm-datepickter-from"></hrm-date-picker>
	          	<span class="hrm-clear"></span>
            	<span class="description"></span>
        	</div>

        	<div v-if="field.type == 'date-picker-to'">
        		<label for="title">
	                {{ field.label }}
	            </label>
	        	<hrm-date-picker placeholder="To" v-model="field.model"  class="pm-datepickter-to" dependency="pm-datepickter-from"></hrm-date-picker>
	          	<span class="hrm-clear"></span>
            	<span class="description"></span>
        	</div>

        	<div v-if="field.type == 'textarea'">

        		<label for="description">
					{{ field.label }}
				</label>
				<textarea name="description" v-model="field.model" class="hrm-des-field" id="description"></textarea>
				<span class="hrm-clear"></span>
				<span class="description"></span>
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
		}
	}
</script>