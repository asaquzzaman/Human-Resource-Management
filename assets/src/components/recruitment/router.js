
import recruitment from './recruitment.vue'


if(typeof HRM_ER_Vars == 'undefined') {
	HRMRegisterChildrenRoute ('hrm_root', 
	    [

	        {
	            path: 'recruitment', 
	            component: recruitment, 
	            name: 'recruitment',
	        }
	    ]
	);
}
 



