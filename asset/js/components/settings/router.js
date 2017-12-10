HRMRegisterModule('settings', 'settings');

const Hrm_Settings = resolve => {

    require.ensure(['./settings.vue'], () => {
        resolve(require('./settings.vue'));
    });
}

let settingsMenu = [
	{ 
		path: 'settings', 
		component: Hrm_Settings,
		name: 'hrm_settings',
		meta: {
			label: 'Settings'
		}

	}
];

HRMRegisterChildrenRoute ('hrm_root', settingsMenu);

export default settingsMenu;
