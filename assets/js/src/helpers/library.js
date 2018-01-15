__webpack_public_path__ = HRM_Vars.hrm_url+ '/assets/js/';

import Promise from 'promise-polyfill'; 

// To add to window
if (!window.Promise) {
  window.Promise = Promise;
}

window.hrm = {};

var scriptsLoaded = {
	'Vue': false,
	'Vuex': false,
	'VueRouter': false,
	'Fullcalendar': false,
	'Multiselect': false,
	'NProgress': false,
	'Moment': false,
	'Toastr': false,
	'Uploader': false,
	'Loading': false,
	//'TimePicker': false
};

window.hrmPromise = new Promise(function(resolve, reject) {
	require.ensure(
		['vue'],
		function(require) {
			require(['vue'], function(script) {
				hrm.Vue = script.default;
			});
		}
	).then(function() {
		scriptsLoaded.Vue = true;
		hrmIsAllScriptsLoaded(resolve, reject);
	});

	require.ensure(
		['vuex'],
		function(require) {
			hrm.Vuex = require('vuex');
		}
	).then(function() {
		scriptsLoaded.Vuex = true;
		hrmIsAllScriptsLoaded(resolve, reject);
	});

	require.ensure(
		['vue-router'],
		function(require) {
			require(['vue-router'], function(script) {
				hrm.VueRouter = script.default;
			});
		}
	).then(function() {
		scriptsLoaded.VueRouter = true;
		hrmIsAllScriptsLoaded(resolve, reject);
	});

	require.ensure(
		['fullcalendar'],
		function(require) {
			hrm.Fullcalendar = require('fullcalendar');
		}
	).then(function() {
		scriptsLoaded.Fullcalendar = true;
		hrmIsAllScriptsLoaded(resolve, reject);
	});

	require.ensure(
		['vue-multiselect'],
		function(require) {
			hrm.Multiselect = require('vue-multiselect');
		}
	).then(function() {
		scriptsLoaded.Multiselect = true;
		hrmIsAllScriptsLoaded(resolve, reject);
	});

	require.ensure(
		['nprogress'],
		function(require) {
			hrm.NProgress = require('nprogress');
		}
	).then(function() {
		scriptsLoaded.NProgress = true;
		hrmIsAllScriptsLoaded(resolve, reject);
	});

	require.ensure(
		['moment'],
		function(require) {
			hrm.Moment = require('moment');
		}
	).then(function() {
		scriptsLoaded.Moment = true;
		hrmIsAllScriptsLoaded(resolve, reject);
	});

	require.ensure(
		['toastr'],
		function(require) {
			hrm.Toastr = require('toastr');
		}
	).then(function() {
		scriptsLoaded.Toastr = true;
		hrmIsAllScriptsLoaded(resolve, reject);
	});

	// require.ensure(
	// 	['./jquery-ui-timepicker/jquery-ui-timepicker'],
	// 	function(require) {
	// 		hrm.TimePicker = require('./jquery-ui-timepicker/jquery-ui-timepicker');
	// 	}
	// ).then(function() {
	// 	scriptsLoaded.TimePicker = true;
	// 	hrmIsAllScriptsLoaded(resolve, reject);
	// });

	require.ensure(
		['./upload/upload'],
		function(require) {
			hrm.Uploader = require('./upload/upload');
		}
	).then(function() {
		scriptsLoaded.Uploader = true;
		hrmIsAllScriptsLoaded(resolve, reject);
	});

	require.ensure(
		['./Elegant-Loading-Indicator/jquery.preloader'],
		function(require) {
			hrm.Loading = require('./Elegant-Loading-Indicator/jquery.preloader');
		}
	).then(function() {
		scriptsLoaded.Loading = true;
		hrmIsAllScriptsLoaded(resolve, reject);
	});

});

function hrmIsAllScriptsLoaded(resolve, reject) {
	var loaded = Object.values(scriptsLoaded);

	if (loaded.indexOf(false) === -1) {
		resolve(true);
	}
}

hrmPromise.then(function(result) {
	hrm.Vue.use(hrm.Vuex);
	hrm.Vue.use(hrm.VueRouter);
});


