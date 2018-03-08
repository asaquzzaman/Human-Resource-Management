export default {
	state: {
		organizationinfo: {},
		countries: [],
	},

	mutations: {
		setOrganizationInfo (state, organizationinfo) {
			state.organizationinfo = organizationinfo;
		},
		setCountries (state, countries) {
			state.countries = countries;
		}
	}
};