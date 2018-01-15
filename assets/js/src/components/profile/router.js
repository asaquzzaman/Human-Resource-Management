
HRMRegisterModule('profile', 'profile');

let personalInformation = resolve => {

    require.ensure(['./personal-information.vue'], () => {
        resolve(require('./personal-information.vue'));
    });
}

let jobLocation = resolve => {

    require.ensure(['./job-location.vue'], () => {
        resolve(require('./job-location.vue'));
    });
}

let workExperiance = resolve => {

    require.ensure(['./work-experiance.vue'], () => {
        resolve(require('./work-experiance.vue'));
    });
}

let education = resolve => {

    require.ensure(['./education.vue'], () => {
        resolve(require('./education.vue'));
    });
}

let skill = resolve => {

    require.ensure(['./skill.vue'], () => {
        resolve(require('./skill.vue'));
    });
}

HRMRegisterChildrenRoute ('hrm_root', 
    [
    	{
            path: 'personal-information', 
        	component: personalInformation, 
        	name: 'personal_information',
        },

        {
            path: 'job-location', 
            component: jobLocation, 
            name: 'job_location',
        },

        {
            path: 'work-experiance', 
            component: workExperiance, 
            name: 'work_experiance',
        },
        
        {
            path: 'education', 
            component: education, 
            name: 'education',
        },

        {
            path: 'skill', 
            component: skill, 
            name: 'skill',
        }
    ]
);

