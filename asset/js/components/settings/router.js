HRMRegisterModule('settings', 'settings');

import mixin from './mixin';

HRMMixin.settings = mixin;

import Empty from '@components/common/empty.vue';

const Hrm_Settings = resolve => {

    require.ensure(['./settings.vue'], () => {
        resolve(require('./settings.vue'));
    });
}

let settingsMenu = [
	{ 
		path: 'settings',
		component:  Empty,
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
			]
		)
		
	}
];



if (hrm_user_can('manage_settings')) {
	HRMRegisterChildrenRoute ('hrm_root', settingsMenu);
}

export default settingsMenu;
