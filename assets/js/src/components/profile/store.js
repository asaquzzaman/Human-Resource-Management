export default {
	state: {
		personalInfo: {
			country_list: []
		},

		jobLocation: {}
	},

	mutations: {
		setPersonalInfo (state, personalInfo) {
			state.personalInfo = personalInfo;
		},

		setJobLocation (state, jobLocation) {
			state.jobLocation = jobLocation;
		}
	}
};