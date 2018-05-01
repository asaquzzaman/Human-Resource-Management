
import './salary/router';
import './formula/router';
import './group/router';
import './revision/router';
import Empty from './payroll.vue';


let menu = [
    {
        path: 'payroll', 
        name: 'payroll',
        component: Empty,
        children: HRMGetRegisterChildrenRoute('payroll'),
        meta: {
        	label: 'Payroll',
        	order: 2
        },
        redirect: {
            name: hrm_user_can('manage_payroll') ? 'salary' : 'revision'
        }
    }
];

HRMRegisterChildrenRoute ('hrm_root', menu);

export default menu;