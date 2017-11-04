const Hrm_Settings = resolve => {

    require.ensure(['./settings.vue'], () => {
        resolve(require('./settings.vue'));
    });
}

//import Hrm_Leave_Records from './settings.vue';

export default { 
	path: '/settings', 
	components: { 
		'hrm-settings': Hrm_Settings 
	}, 
	name: 'hrm_settings',

}
