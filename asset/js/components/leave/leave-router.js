const Hrm_Leave_Records = resolve => {

    require.ensure(['./leave-records.vue'], () => {
        resolve(require('./leave-records.vue'));
    });
}

//import Hrm_Leave_Records from './leave-records.vue';

HRM_Routes.push (
	{ 
    	path: '/leave', 
    	components: { 
    		'hrm-leave-records': Hrm_Leave_Records 
    	}, 
    	name: 'leave_records',

	}

);
const Hrm_Leave_Configuration = resolve => {

    require.ensure(['./leave-configuration.vue'], () => {
        resolve(require('./leave-configuration.vue'));
    });
}
const Hrm_Leave_Type = resolve => {

    require.ensure(['./leave-type.vue'], () => {
        resolve(require('./leave-type.vue'));
    });
}
const Hrm_Leave_Work_Week = resolve => {

    require.ensure(['./leave-work-week.vue'], () => {
        resolve(require('./leave-work-week.vue'));
    });
}
const Hrm_Leave_Holidays = resolve => {

    require.ensure(['./leave-holidays.vue'], () => {
        resolve(require('./leave-holidays.vue'));
    });
}

HRM_Routes.push(
    {
        path: '/leave-configuration', 
        components: { 'hrm-leave-configuration': Hrm_Leave_Configuration }, 
        name: 'leave_configuration',

        children: [
            {
                path: '/leave-configuration/type', 
                components: { 'hrm-leave-type': Hrm_Leave_Type }, 
                name: 'leave_type',
            },

            {
                path: '/leave-configuration/work-week', 
                components: { 'hrm-leave-work-week': Hrm_Leave_Work_Week }, 
                name: 'leave_week',
            },

            {
                path: '/leave-configuration/holidays', 
                components: { 'hrm-leave-holidays': Hrm_Leave_Holidays }, 
                name: 'leave_holidays',
            }
        ]
    }
);

export default HRM_Routes;
