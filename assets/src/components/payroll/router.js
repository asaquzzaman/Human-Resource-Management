
import './salary/router';
import './formula/router';
import './group/router';
import './revision/router';
import './tutorial/router';
import Empty from './payroll.vue';
import Loan from './loan.vue';


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

if(typeof HRM_Loan_Vars == 'undefined') {

    menu[0].children.push(
        {
            path: 'loan', 
            name: 'loan',
            component: Loan,
            meta: {
                label: 'Loan',
                order: 4
            }
        }
    );
}

HRMRegisterChildrenRoute ('hrm_root', menu);

export default menu;