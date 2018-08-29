HRMRegisterModule('settings', 'settings');

import mixin from './mixin';

HRMMixin.settings = mixin;

import Settings from './settings.vue';
import Hrm_Settings from './general.vue'
import EmailSettings from './email-settings.vue'


// const Hrm_Settings = resolve => {

//     require.ensure(['./general.vue'], () => {
//         resolve(require('./general.vue'));
//     });
// }

let settingsMenu = [
	{ 
		path: 'settings',
		component:  Settings,
		name: 'hrm_setting',

		children: HRMGetRegisterChildrenRoute
		( 
			'hrm_setting',
			[
				{
					path: 'general', 
					component: Hrm_Settings,
					name: 'hrm_general_settings',
					meta: {
						label: 'General'
					}
				},
				{
					path: 'email-settings', 
					component: EmailSettings,
					name: 'hrm_email_settings_settings',
					meta: {
						label: 'Email'
					}
				},
			]
		)
		
	}
];



if (hrm_user_can('manage_settings')) {
	HRMRegisterChildrenRoute ('hrm_root', settingsMenu);
}

export default settingsMenu;
