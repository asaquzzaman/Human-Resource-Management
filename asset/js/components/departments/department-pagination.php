<!-- <div class="dataTables_paginate paging_simple_numbers" id="hrm-data-table_paginate">
	<a class="paginate_button previous disabled" aria-controls="hrm-data-table" data-dt-idx="0" tabindex="0" id="hrm-data-table_previous">Previous</a>
		<span>
			<a class="paginate_button current" aria-controls="hrm-data-table" data-dt-idx="1" tabindex="0">1</a>
		</span>
		<a class="paginate_button next disabled" aria-controls="hrm-data-table" data-dt-idx="2" tabindex="0" id="hrm-data-table_next">Next</a>
</div> -->

<div v-if="total > 1">
	<div class="cpm-pagination-wrap">

		<router-link 
			v-if="page_number > 1" 
			class="cpm-pagination-btn prev page-numbers" 
			:to="{ 
				name: 'department_pagination', 
				params: { 
					page_number: ( page_number - 1 ) 
				}
			}">
			&laquo;
		</router-link>

		<router-link 
			v-for="page in total" 
			key="page" 
			:class="pageClass(page) + ' cpm-pagination-btn'" 
			:to="{ 
				name: 'department_pagination', 
				params: { 
					page_number: page 
				}
			}">
			{{ page }}
		</router-link>

		<router-link 
			v-if="page_number < total" 
			class="cpm-pagination-btn next page-numbers" 
			:to="{ 
				name: 'department_pagination', 
				params: { 
					page_number: ( page_number + 1 ) 
				}
			}">
			&raquo;
		</router-link> 

	</div>
	<div class="cpm-clearfix"></div>
</div>
