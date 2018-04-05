
import './formula/router';
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
            name: 'salary_components'
        }
    }
];

HRMRegisterChildrenRoute ('hrm_root', menu);

export default menu;