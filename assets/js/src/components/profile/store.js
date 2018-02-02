export default {
	state: {
		personalInfo: {
			country_list: []
		}
	},

	mutations: {
		setPersonalInfo (state, personalInfo) {
			state.personalInfo = personalInfo;
		}
	}
};