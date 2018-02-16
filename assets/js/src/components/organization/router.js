import general from './general/router';
import location from './location/router';
import notice from './notice/router';
import Empty from './organization.vue';

let menu = [
    {
        path: 'organization', 
        component: Empty, 
        name: 'organization',
        children: HRMGetRegisterChildrenRoute('organization')
    }
];

HRMRegisterChildrenRoute ('hrm_root', menu);

export default menu;