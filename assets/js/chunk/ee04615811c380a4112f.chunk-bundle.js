wpSpearHrm([2],{

/***/ 195:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_header_vue__ = __webpack_require__(72);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_57e8f391_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_header_vue__ = __webpack_require__(196);
var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_header_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_57e8f391_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_header_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/leave/leave-header.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-57e8f391", Component.options)
  } else {
    hotAPI.reload("data-v-57e8f391", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 196:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c(
      "h2",
      { staticClass: "nav-tab-wrapper" },
      _vm._l(_vm.menu, function(item, index) {
        return _c(
          "router-link",
          {
            key: "index",
            staticClass: "nav-tab",
            attrs: { to: { name: item.name } }
          },
          [_vm._v(_vm._s(item.meta.label))]
        )
      })
    ),
    _vm._v(" "),
    _c("h3", { staticClass: "hrm-sub-nav" }, [
      _c(
        "ul",
        { staticClass: "hrm-subsubsub" },
        _vm._l(_vm.childrens(), function(children) {
          return _c(
            "li",
            [
              _c("router-link", { attrs: { to: { name: children.name } } }, [
                _vm._v(_vm._s(children.meta.label))
              ]),
              _vm._v(" |  \n            ")
            ],
            1
          )
        })
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-57e8f391", esExports)
  }
}

/***/ }),

/***/ 208:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//

/* harmony default export */ __webpack_exports__["a"] = ({
    props: ['value', 'dependency'],
    mounted: function () {
        var self = this,
            limit_date = self.dependency == 'pm-datepickter-from' ? "minDate" : "maxDate";

        jQuery(self.$el).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                jQuery("." + self.dependency).datepicker("option", limit_date, selectedDate);
            },
            onSelect: function (dateText) {
                self.$emit('input', dateText);
            }
        });
    }
});

/***/ }),

/***/ 225:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["a"] = ({
	methods: {
		mixins: [HRMMixin.leave],

		showHideLeaveRecordsForm: function () {
			this.$store.commit('leave/isNewLeaveRecordsFormVisible', { is_visible: true });
		}
	}
});

/***/ }),

/***/ 226:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["a"] = ({
	data: function () {
		return {
			employees: [],
			apply_to: '',
			leave_type: '',
			leave_types: [],
			administrators: [],
			status: '',
			start_time: '',
			end_time: '',
			comments: '',
			emp_leave_with_type_record: [],
			work_week: [],
			leave_entitlements: [],
			apply_leave_date: [],
			calendar_evt_id: [],
			disable_leave_type: false,
			selectedEmployee: false,
			isLoading: false,
			leave_proxy: false,
			apply_emp_lev_records: [],
			is_leave_btn_disable: false,
			holidays: [],
			isLeaveTypeEnable: false
		};
	},

	computed: {
		isManager() {
			return hrm_user_can('manage_leave');
		}
	},

	watch: {
		leave_proxy(proxy) {
			this.refresh();
			this.change_leve_type_statue();
		}
	},

	mixins: [HRMMixin.leave],

	components: {
		'hrm-multiselect': hrm.Multiselect
	},

	created: function () {
		this.$on('hrm_date_picker', this.setDateTime);
		this.getSettings();
		this.getInitialData();
	},
	methods: {
		getSettings() {
			var self = this;
			var request = {
				data: {},
				success(res) {
					let roles = self.processRoles(res.roles);
					let role = hrm_user_can('manage_settings') ? 'hrm_manager' : HRM_Vars.user_role;

					if (res.settings) {
						res.settings.leave_types = res.settings.leave_types || [];
						if (res.settings.leave_types.indexOf(role) != -1) {
							self.isLeaveTypeEnable = true;
						}
					}
				}
			};
			this.httpRequest('get_leave_form_settings', request);
		},

		changeEmployee: function () {
			this.refresh();
			this.change_leve_type_statue();
		},
		refresh() {
			jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('refetchEvents');
		},
		getInitialData: function () {
			var request_data = {
				_wpnonce: HRM_Vars.nonce
			},
			    self = this;

			wp.ajax.send('get_leave_records_init_data', {
				data: request_data,

				success: function (res) {
					self.leave_types = res.leave_types.data;
					self.administrators = res.apply_to;
					self.holidays = res.holidays;
				},

				error: function (res) {}
			});
		},
		setDateTime: function (date) {
			if (date.field == 'datepicker_from') {
				this.from = date.date;
			}

			if (date.field == 'datepicker_to') {
				this.to = date.date;
			}
		},
		show_hide_new_leave_records_form: function (el) {
			var self = this;

			this.slideUp(el.target, function () {
				self.$store.commit('leave/isNewLeaveRecordsFormVisible', { is_visible: false });
			});
		},

		createNewLeave: function () {

			if (this.is_leave_btn_disable) {
				return false;
			}

			if (!this.apply_leave_date.length) {
				// Display a success toast, with a title
				toastr.error('Please select your leave date');
				return false;
			}

			var self = this;

			var request_data = {
				comments: this.comments,
				type: !this.leave_type ? '0' : this.leave_type.id,
				emp_id: !this.selectedEmployee ? false : this.selectedEmployee.ID,
				time: this.apply_leave_date,
				disable_leave_type: this.disable_leave_type,
				status: 1,
				class: 'Leave',
				method: 'create'
			};

			this.show_spinner = true;

			var form_data = {
				data: request_data,

				beforSend: function (xhr) {
					self.is_leave_btn_disable = true;
				},

				success: function (res) {
					self.show_spinner = false;
					console.log(res);
					// Display a success toast, with a title
					toastr.success(res.success);
					self.$store.commit('leave/afterCreateNewLeave', res.resource);

					self.slideUp(jQuery('.hrm-form-cancel'), function () {
						//self.$store.commit('leave/isNewDepartmentForVisible', {is_visible: false});

					});
				},

				error: function (res) {
					self.show_spinner = false;
					// Showing error
					res.error.map(function (value, index) {
						toastr.error(value);
					});
				}
			};

			this.httpRequest('create_new_leave', form_data);
		},

		change_leve_type_statue: function () {
			jQuery.each(this.calendar_evt_id, function (index, event_id) {
				jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('removeEvents', event_id);
			});

			this.calendar_evt_id = [];
			this.apply_leave_date = [];
		},

		asyncFind(query) {
			var self = this;
			if (query.length < 3) {
				return [];
			}
			var start = jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('getView').start;
			var start = moment(start._d).format('YYYY-MM-DD');
			var end = jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('getView').end;
			var end = moment(end._d).format('YYYY-MM-DD');

			var http_data = {
				data: {
					user: query,
					start: start,
					end: end
				},
				type: 'POST',
				success(res) {
					self.employees = res;
				}
			};

			self.httpRequest('search_emp_leave_records', http_data);
		},
		clearAll() {
			this.selectedEmployee = [];
		}

	}
});

/***/ }),

/***/ 227:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__leave_search_vue__ = __webpack_require__(266);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["a"] = ({
	data() {
		return {
			status: {
				1: 'Pending',
				2: 'Approve',
				3: 'Cancel'
			}
		};
	},
	mixins: [HRMMixin.leave],
	computed: {
		financialStart() {
			return this.$route.query.start_time || HRM_Vars.financial_start;
		},
		financialEnd() {
			return this.$route.query.start_time || HRM_Vars.financial_end;
		},
		records() {
			var self = this;
			var records = this.$store.state.leave.leave_records;
			var records = _.chain(records).groupBy(self.occurrenceDay).map(self.groupToDay).sortBy('month').value();

			return records;
		},

		meta() {
			return this.$store.state.leave.leave_meta;
		},

		total() {
			if (!this.$store.state.leave.leave_meta.types) {
				return [];
			}

			var types = this.$store.state.leave.leave_meta.types,
			    total_extra = 0;

			var total = {
				entitlement: 0,
				taken_leave: 0,
				remain_leave: 0
			};

			types.forEach(function (type, index) {
				total.entitlement = parseInt(type.entitlement) + total.entitlement;
				total.taken_leave = parseInt(type.count) + total.taken_leave;

				if (type.id === 1) {
					total_extra = total_extra + parseInt(type.count);
				}
			});

			total.remain_leave = total.entitlement - total.taken_leave + total_extra;

			return total;
		}
	},

	components: {
		'hrm-leave-search': __WEBPACK_IMPORTED_MODULE_0__leave_search_vue__["a" /* default */]
	},

	created() {
		this.getLeaveRecords({
			data: {
				'emp_id': HRM_Vars.current_user.data.ID,
				'query': this.$route.query
			}
		});
	},

	methods: {
		occurrenceDay(occurrence) {
			var date = new Date(occurrence.start_time);
			var date = moment(date).format('YYYY-MM-DD');

			return moment(date).startOf('month').format('YYYY-MM-DD');
		},

		groupToDay(group, day) {
			return {
				date: day,
				activities: group
			};
		},
		selfDateFormat(date) {
			return moment(date).format('MMMM');
		},

		selfLeaveDelete(id) {
			var args = {
				data: {
					leave_id: id
				},

				callback: function () {}
			};

			this.deleteLeave(args);
		}
	}
});

/***/ }),

/***/ 228:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__leave_header_vue__ = __webpack_require__(195);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__leave_records_add_btn_vue__ = __webpack_require__(263);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__leave_records_form_vue__ = __webpack_require__(264);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__leave_records_render_vue__ = __webpack_require__(265);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//






/* harmony default export */ __webpack_exports__["a"] = ({
	mixins: [HRMMixin.leave],

	computed: {
		is_leave_form_active: function () {
			return this.$store.state.leave.is_leave_form_active;
		}
	},
	components: {
		'leave-header': __WEBPACK_IMPORTED_MODULE_0__leave_header_vue__["a" /* default */],
		'hrm-leave-records-add-btn': __WEBPACK_IMPORTED_MODULE_1__leave_records_add_btn_vue__["a" /* default */],
		'hrm-leave-records-form': __WEBPACK_IMPORTED_MODULE_2__leave_records_form_vue__["a" /* default */],
		'hrm-leave-records-render': __WEBPACK_IMPORTED_MODULE_3__leave_records_render_vue__["a" /* default */]
	}
});

/***/ }),

/***/ 230:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__common_date_picker_vue__ = __webpack_require__(254);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["a"] = ({
	data() {
		return {
			employee_id: '',
			start_time: this.$route.query.start_time || HRM_Vars.financial_start,
			end_time: this.$route.query.end_time || HRM_Vars.financial_end
		};
	},
	created() {
		this.selfEmployeeDropDown();
	},
	mixins: [HRMMixin.leave],
	computed: {
		emp_id: {
			get() {
				let emp_id = this.$route.query.emp_id || HRM_Vars.current_user.data.ID;
				let dropDown = this.$store.state.leave.employeeDropDown;

				let index = this.getIndex(dropDown, emp_id, 'id');

				if (index !== false) {
					return dropDown[index];
				}

				return '';
			},

			set(emp) {
				this.employee_id = emp.id;
			}
		},
		employessDropDown() {
			return this.$store.state.leave.employeeDropDown;
		}
	},
	watch: {
		'$route'() {
			this.getLeaveRecords({
				data: {
					'emp_id': HRM_Vars.current_user.data.ID,
					'query': this.$route.query
				}
			});
		}
	},
	components: {
		'hrm-multiselect': hrm.Multiselect,
		'date-picker': __WEBPACK_IMPORTED_MODULE_0__common_date_picker_vue__["a" /* default */]
	},
	methods: {
		selfEmployeeDropDown() {
			var args = {
				callback() {}
			};
			this.getEmployeeDropDown(args);
		},

		leaveFilter() {
			var query = {
				start_time: this.start_time || '',
				end_time: this.end_time || '',
				emp_id: this.employee_id || ''
			};

			this.$router.push({
				name: 'leave_records',
				query: query
			});
		}
	}
});

/***/ }),

/***/ 242:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(69)(false);
// imports


// module
exports.push([module.i, "\n.hrm-start-date, .hrm-end-date {\n\tfont-size: 11px;\n\tcolor: #333;\n\tfont-weight: 800;\n}\n.page-title-action {\n\tmargin-top: 14px;\n    padding: 4px 8px;\n    position: relative;\n    text-decoration: none;\n    border: none;\n    border: 1px solid #ccc;\n    -webkit-border-radius: 2px;\n    border-radius: 2px;\n    background: #f7f7f7;\n    text-shadow: none;\n    font-weight: 600;\n    font-size: 13px;\n    line-height: normal;\n    color: #0073aa;\n    outline: 0;\n    display: inline-block;\n}\n.wrap .page-title-action:hover {\n\tbackground: #f7f7f7;\n\tcolor: #0073aa;\n\tborder: 1px solid #ccc;\n}\n.ui-sortable-handle {\n\tborder: none !important;\n}\n.postbox .inside {\n\tmargin: 0 !important;\n}\n#wpbody-content .metabox-holder {\n\tpadding-top: 0 !important;\n}\n.metabox-holder {\n\tmargin-top: 8px;\n}\n", ""]);

// exports


/***/ }),

/***/ 244:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(69)(false);
// imports


// module
exports.push([module.i, "\n.hrm-form-field {\n\t\tmargin-bottom: 12px;\n}\n.search-date-field-wrap, .hrm-multiselect {\n}\n.hrm-leave-search .multiselect {\n\t\twidth: auto;\n}\n.hrm-leave-search .multiselect__tags {\n\t\tbackground: inherit !important;\n\t\tborder: none !important;\n\t\tpadding: 0 !important;\n\t\tmin-height: 0 !important;\n}\n.hrm-leave-search .multiselect {\n\t\tmin-height: 0 !important;\n}\n.hrm-leave-search .multiselect__select {\n\t\tdisplay: none !important;\n}\n.pm-datepickter-to, .pm-datepickter-from {\n\t\theight: 30px;\n}\n.hrm-leave-search .multiselect__input {\n\t\tmargin-bottom: 0 !important;\n\t\twidth: 30% !important;\n}\n.hrm-leave-search {\n\t\tmargin-left: 2px;\n}\n.hrm-leave-search-wrap .button-secondary {\n\t\tmargin-left: 8px !important;\n    \tmargin-top: 2px !important;\n}\n.hrm-leave-search, .pm-datepickter-to, .pm-datepickter-from, .button-secondary {\n\t\tdisplay: inline-block;\n}\n", ""]);

// exports


/***/ }),

/***/ 245:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(69)(false);
// imports


// module
exports.push([module.i, "\n.hrm-leave-employee-search-wrap .multiselect__input, \n.hrm-leave-employee-search-wrap .multiselect__input:focus,\n.hrm-leave-type-wrap .multiselect__input,\n.hrm-leave-type-wrap .multiselect__input:focus {\n\ttop: -5px;\n\tborder: none;\n\tbox-shadow: none;\n}\n.hrm-leave-employee-search-wrap .multiselect__content,\n.hrm-leave-type-wrap .multiselect__content {\n\tmargin-top: 0 !important;\n\tz-index: 99999 !important;\n}\n.hrm-leave-jquery-fullcalendar {\n\tmargin-left: 21%;\n\twidth: 50%;\n}\n.fc-center h2 {\n\tfont-size: 14px !important;\n\tfont-weight: 600 !important;\n}\n", ""]);

// exports


/***/ }),

/***/ 246:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(69)(false);
// imports


// module
exports.push([module.i, "\n.hrm-employee-leave-records {\n\twidth: 50%;\n}\n", ""]);

// exports


/***/ }),

/***/ 254:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_date_picker_vue__ = __webpack_require__(208);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_fbe01182_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_date_picker_vue__ = __webpack_require__(305);
var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_date_picker_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_fbe01182_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_date_picker_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/common/date-picker.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-fbe01182", Component.options)
  } else {
    hotAPI.reload("data-v-fbe01182", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 263:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_add_btn_vue__ = __webpack_require__(225);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6d600751_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_add_btn_vue__ = __webpack_require__(288);
var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_add_btn_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6d600751_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_add_btn_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/leave/leave-records-add-btn.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6d600751", Component.options)
  } else {
    hotAPI.reload("data-v-6d600751", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 264:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_form_vue__ = __webpack_require__(226);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_9e55cf1a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_form_vue__ = __webpack_require__(296);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(312)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_form_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_9e55cf1a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_form_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/leave/leave-records-form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-9e55cf1a", Component.options)
  } else {
    hotAPI.reload("data-v-9e55cf1a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 265:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_render_vue__ = __webpack_require__(227);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_5a9b2a85_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_render_vue__ = __webpack_require__(285);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(309)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_render_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_5a9b2a85_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_render_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/leave/leave-records-render.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5a9b2a85", Component.options)
  } else {
    hotAPI.reload("data-v-5a9b2a85", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 266:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_search_vue__ = __webpack_require__(230);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_909d1da8_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_search_vue__ = __webpack_require__(294);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(311)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_search_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_909d1da8_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_search_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/leave/leave-search.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-909d1da8", Component.options)
  } else {
    hotAPI.reload("data-v-909d1da8", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 285:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c(
      "div",
      { staticClass: "metabox-holder" },
      [
        _c("div", { staticClass: "hrm-records-text" }, [
          _vm._m(0),
          _vm._v(" "),
          _c("div", { staticClass: "hrm-records-from" }, [
            _c("h2", [_vm._v("From")]),
            _vm._v(" "),
            _c("span", [
              _c("i", {
                staticClass: "fa fa-calendar",
                attrs: { "aria-hidden": "true" }
              }),
              _vm._v(
                "\n\t\t\t\t\t" +
                  _vm._s(_vm.dateFormat(_vm.financialStart)) +
                  "\n\t\t\t\t"
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "hrm-records-to" }, [
            _c("h2", [_vm._v("To")]),
            _vm._v(" "),
            _c("span", [
              _c("i", {
                staticClass: "fa fa-calendar",
                attrs: { "aria-hidden": "true" }
              }),
              _vm._v(
                "\n\t\t\t\t\t" +
                  _vm._s(_vm.dateFormat(_vm.financialEnd)) +
                  "\n\t\t\t\t"
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "hrm-clear" })
        ]),
        _vm._v(" "),
        _c("hrm-leave-search"),
        _vm._v(" "),
        !_vm.records.length
          ? _c("div", { staticClass: "notice notice-success" }, [
              _c("p", [_vm._v("No leave record found")])
            ])
          : _vm._e(),
        _vm._v(" "),
        _vm.records.length
          ? _c("div", { staticClass: "postbox" }, [
              _vm._m(1),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass:
                    "inside metabox-holder hrm-leave-type-records-wrap"
                },
                [
                  _c(
                    "table",
                    { staticClass: "wp-list-table widefat fixed striped" },
                    [
                      _vm._m(2),
                      _vm._v(" "),
                      _c(
                        "tbody",
                        [
                          _vm._l(_vm.meta.types, function(type) {
                            return _c("tr", [
                              _c("td", [_vm._v(_vm._s(type.leave_type_name))]),
                              _vm._v(" "),
                              type.id === 1
                                ? _c("td", [_vm._v("–")])
                                : _c("td", [
                                    _vm._v(_vm._s(_vm.pad(type.entitlement)))
                                  ]),
                              _vm._v(" "),
                              _c("td", [_vm._v(_vm._s(_vm.pad(type.count)))]),
                              _vm._v(" "),
                              type.id === 0
                                ? _c("td", [_vm._v("–")])
                                : _c("td", [
                                    _vm._v(
                                      _vm._s(
                                        _vm.pad(type.entitlement - type.count)
                                      )
                                    )
                                  ])
                            ])
                          }),
                          _vm._v(" "),
                          _c("tr", [
                            _vm._m(3),
                            _vm._v(" "),
                            _c("td", [
                              _c("strong", [
                                _vm._v(_vm._s(_vm.pad(_vm.total.entitlement)))
                              ])
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("strong", [
                                _vm._v(_vm._s(_vm.pad(_vm.total.taken_leave)))
                              ])
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("strong", [
                                _vm._v(_vm._s(_vm.pad(_vm.total.remain_leave)))
                              ])
                            ])
                          ])
                        ],
                        2
                      )
                    ]
                  )
                ]
              )
            ])
          : _vm._e(),
        _vm._v(" "),
        _vm._l(_vm.records, function(record) {
          return _c("div", { staticClass: "postbox" }, [
            _c("h2", { staticClass: "hndle ui-sortable-handle" }, [
              _c("span", [_vm._v(_vm._s(_vm.selfDateFormat(record.date)))])
            ]),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "inside metabox-holder hrm-leave-type-records-wrap"
              },
              [
                _c(
                  "table",
                  { staticClass: "wp-list-table widefat fixed striped" },
                  [
                    _vm._m(4, true),
                    _vm._v(" "),
                    _c(
                      "tbody",
                      _vm._l(record.activities, function(leave) {
                        return _c("tr", [
                          _c("td", [
                            _vm._v(_vm._s(leave.leave_type.data.name))
                          ]),
                          _vm._v(" "),
                          _c("td", [_vm._v("1")]),
                          _vm._v(" "),
                          _c("td", [
                            _vm._v(_vm._s(_vm.dateFormat(leave.start_time)))
                          ]),
                          _vm._v(" "),
                          _c("td", [
                            _vm._v(_vm._s(_vm.dateFormat(leave.end_time)))
                          ]),
                          _vm._v(" "),
                          _c("td", [_vm._v(_vm._s(_vm.status[leave.status]))]),
                          _vm._v(" "),
                          _c("td", [
                            leave.status === 1 || leave.status === 3
                              ? _c(
                                  "button",
                                  {
                                    on: {
                                      click: function($event) {
                                        $event.preventDefault()
                                        _vm.selfLeaveDelete(leave.id)
                                      }
                                    }
                                  },
                                  [_vm._v("Delete")]
                                )
                              : _c("div", [_vm._v("Not available")])
                          ])
                        ])
                      })
                    )
                  ]
                )
              ]
            )
          ])
        })
      ],
      2
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "hrm-attendance-records-text-wrap" }, [
      _c("h2", [_vm._v("Leave Records")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("h2", { staticClass: "hndle ui-sortable-handle" }, [
      _c("span", [_vm._v("Summery")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("th", [_vm._v("Leave Type")]),
      _vm._v(" "),
      _c("th", [_vm._v("Entitlement")]),
      _vm._v(" "),
      _c("th", [_vm._v("Taken Leave")]),
      _vm._v(" "),
      _c("th", [_vm._v("Remain")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("td", [_c("strong", [_vm._v("Total")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("th", [_vm._v("Leave Type")]),
      _vm._v(" "),
      _c("th", [_vm._v("Duration")]),
      _vm._v(" "),
      _c("th", [_vm._v("Start")]),
      _vm._v(" "),
      _c("th", [_vm._v("End")]),
      _vm._v(" "),
      _c("th", [_vm._v("Status")]),
      _vm._v(" "),
      _c("th", [_vm._v("Action")])
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-5a9b2a85", esExports)
  }
}

/***/ }),

/***/ 288:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "hrm-tbl-action-btn-sibling" }, [
    _c(
      "a",
      {
        staticClass: "button button-primary ",
        attrs: { href: "#" },
        on: {
          click: function($event) {
            $event.preventDefault()
            _vm.showHideLeaveRecordsForm()
          }
        }
      },
      [_vm._v("Add")]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-6d600751", esExports)
  }
}

/***/ }),

/***/ 294:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "hrm-form-field hrm-leave-search-wrap" },
    [
      _c("date-picker", {
        staticClass: "pm-datepickter-to",
        attrs: { placeholder: "Leave From", dependency: "pm-datepickter-from" },
        model: {
          value: _vm.start_time,
          callback: function($$v) {
            _vm.start_time = $$v
          },
          expression: "start_time"
        }
      }),
      _vm._v(" "),
      _c("date-picker", {
        staticClass: "pm-datepickter-from",
        attrs: { placeholder: "Leave To", dependency: "pm-datepickter-to" },
        model: {
          value: _vm.end_time,
          callback: function($$v) {
            _vm.end_time = $$v
          },
          expression: "end_time"
        }
      }),
      _vm._v(" "),
      _vm.canManamgeLeave()
        ? _c(
            "div",
            { staticClass: "hrm-multiselect hrm-leave-search" },
            [
              _c("hrm-multiselect", {
                attrs: {
                  options: _vm.employessDropDown,
                  multiple: false,
                  "close-on-select": true,
                  "clear-on-select": true,
                  "hide-selected": false,
                  "show-labels": true,
                  placeholder: "Select Employee",
                  "select-label": "",
                  "selected-label": "selected",
                  "deselect-label": "",
                  taggable: false,
                  label: "name",
                  "track-by": "id",
                  "allow-empty": true
                },
                model: {
                  value: _vm.emp_id,
                  callback: function($$v) {
                    _vm.emp_id = $$v
                  },
                  expression: "emp_id"
                }
              })
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "button button-secondary",
          on: {
            click: function($event) {
              $event.preventDefault()
              _vm.leaveFilter()
            }
          }
        },
        [_vm._v("Filter")]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-909d1da8", esExports)
  }
}

/***/ }),

/***/ 296:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "metabox-holder hrm-leave-records-form-warp" },
    [
      _c("div", { staticClass: "postbox" }, [
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "inside" }, [
          _c(
            "div",
            {
              staticClass: "hrm-attendance-configuration",
              attrs: { id: "hrm-hidden-form" }
            },
            [
              _c(
                "form",
                {
                  staticClass: "hrm-leave-records-form",
                  attrs: { action: "" },
                  on: {
                    submit: function($event) {
                      $event.preventDefault()
                      _vm.createNewLeave()
                    }
                  }
                },
                [
                  _vm.leave_proxy
                    ? _c(
                        "div",
                        {
                          staticClass:
                            "hrm-form-field hrm-leave-employee-search-wrap"
                        },
                        [
                          _vm._m(1),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "hrm-multiselect" },
                            [
                              _c(
                                "hrm-multiselect",
                                {
                                  attrs: {
                                    "select-label": "",
                                    "selected-label": "selected",
                                    "deselect-label": "",
                                    id: "ajax",
                                    label: "display_name",
                                    "track-by": "ID",
                                    placeholder: "Type to search",
                                    "open-direction": "bottom",
                                    options: _vm.employees,
                                    multiple: false,
                                    searchable: true
                                  },
                                  on: {
                                    input: _vm.changeEmployee,
                                    "search-change": _vm.asyncFind
                                  },
                                  scopedSlots: _vm._u([
                                    {
                                      key: "clear",
                                      fn: function(props) {
                                        return [
                                          _vm.selectedEmployee.length
                                            ? _c("div", {
                                                staticClass:
                                                  "multiselect__clear",
                                                on: {
                                                  mousedown: function($event) {
                                                    $event.preventDefault()
                                                    $event.stopPropagation()
                                                    _vm.clearAll(props.search)
                                                  }
                                                }
                                              })
                                            : _vm._e()
                                        ]
                                      }
                                    }
                                  ]),
                                  model: {
                                    value: _vm.selectedEmployee,
                                    callback: function($$v) {
                                      _vm.selectedEmployee = $$v
                                    },
                                    expression: "selectedEmployee"
                                  }
                                },
                                [
                                  _c(
                                    "span",
                                    {
                                      attrs: { slot: "noResult" },
                                      slot: "noResult"
                                    },
                                    [_vm._v("No user found.")]
                                  )
                                ]
                              )
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c("div", { staticClass: "hrm-clear" })
                        ]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.isManager
                    ? _c("div", { staticClass: "hrm-form-field " }, [
                        _vm._m(2),
                        _vm._v(" "),
                        _c("span", { staticClass: "hrm-checkbox-wrap" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.leave_proxy,
                                expression: "leave_proxy"
                              }
                            ],
                            attrs: {
                              type: "checkbox",
                              id: "hrm-disable-leave-proxy-checkbox"
                            },
                            domProps: {
                              checked: Array.isArray(_vm.leave_proxy)
                                ? _vm._i(_vm.leave_proxy, null) > -1
                                : _vm.leave_proxy
                            },
                            on: {
                              change: function($event) {
                                var $$a = _vm.leave_proxy,
                                  $$el = $event.target,
                                  $$c = $$el.checked ? true : false
                                if (Array.isArray($$a)) {
                                  var $$v = null,
                                    $$i = _vm._i($$a, $$v)
                                  if ($$el.checked) {
                                    $$i < 0 &&
                                      (_vm.leave_proxy = $$a.concat([$$v]))
                                  } else {
                                    $$i > -1 &&
                                      (_vm.leave_proxy = $$a
                                        .slice(0, $$i)
                                        .concat($$a.slice($$i + 1)))
                                  }
                                } else {
                                  _vm.leave_proxy = $$c
                                }
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c(
                            "label",
                            {
                              staticClass: "hrm-radio",
                              attrs: { for: "hrm-disable-leave-proxy-checkbox" }
                            },
                            [_vm._v("Enable/Disable")]
                          )
                        ]),
                        _vm._v(" "),
                        _c("span", { staticClass: "hrm-clear" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "description" }, [
                          _vm._v(
                            "you can apply on behalf of others employee leave"
                          )
                        ])
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  !_vm.disable_leave_type
                    ? _c(
                        "div",
                        { staticClass: "hrm-form-field hrm-leave-type-wrap" },
                        [
                          _vm._m(3),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "hrm-multiselect" },
                            [
                              _c("hrm-multiselect", {
                                attrs: {
                                  options: _vm.leave_types,
                                  multiple: false,
                                  "close-on-select": true,
                                  "clear-on-select": true,
                                  "hide-selected": false,
                                  "show-labels": true,
                                  placeholder: "Select leave type",
                                  "select-label": "",
                                  "selected-label": "selected",
                                  "deselect-label": "",
                                  taggable: false,
                                  label: "name",
                                  "track-by": "id",
                                  "allow-empty": true
                                },
                                on: {
                                  input: function($event) {
                                    _vm.change_leve_type_statue()
                                  }
                                },
                                model: {
                                  value: _vm.leave_type,
                                  callback: function($$v) {
                                    _vm.leave_type = $$v
                                  },
                                  expression: "leave_type"
                                }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c("div", { staticClass: "hrm-clear" })
                        ]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.isLeaveTypeEnable
                    ? _c("div", { staticClass: "hrm-form-field " }, [
                        _vm._m(4),
                        _vm._v(" "),
                        _c("span", { staticClass: "hrm-checkbox-wrap" }, [
                          _c("input", {
                            attrs: {
                              type: "checkbox",
                              id: "hrm-disable-leave-type-checkbox"
                            },
                            on: {
                              change: function($event) {
                                _vm.onOff("disable_leave_type")
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c(
                            "label",
                            {
                              staticClass: "hrm-radio",
                              attrs: { for: "hrm-disable-leave-type-checkbox" }
                            },
                            [_vm._v("Enable/Disable")]
                          )
                        ]),
                        _vm._v(" "),
                        _c("span", { staticClass: "hrm-clear" }),
                        _vm._v(" "),
                        _c("span", { staticClass: "description" })
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _c("div", { staticClass: "hrm-form-field " }, [
                    _vm._m(5),
                    _vm._v(" "),
                    _c("span", { staticClass: "hrm-checkbox-wrap" }, [
                      _c("textarea", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.comments,
                            expression: "comments"
                          }
                        ],
                        domProps: { value: _vm.comments },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.comments = $event.target.value
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("label", {
                        staticClass: "hrm-radio",
                        attrs: { for: "hrm-disable-leave-type-checkbox" }
                      })
                    ]),
                    _vm._v(" "),
                    _c("span", { staticClass: "hrm-clear" }),
                    _vm._v(" "),
                    _c("span", { staticClass: "description" })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "hrm-form-field" }, [
                    _vm._m(6),
                    _vm._v(" "),
                    _c("div", {
                      directives: [
                        {
                          name: "hrm-leave-jquery-fullcalendar",
                          rawName: "v-hrm-leave-jquery-fullcalendar"
                        }
                      ],
                      staticClass: "hrm-leave-jquery-fullcalendar"
                    })
                  ]),
                  _vm._v(" "),
                  _c("input", {
                    staticClass: "button  button-primary",
                    attrs: {
                      type: "submit",
                      name: "requst",
                      value: "Save changes"
                    }
                  }),
                  _vm._v(" "),
                  _c(
                    "a",
                    {
                      staticClass: "button hrm-form-cancel",
                      attrs: { target: "_blank", href: "#" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          _vm.showHideLeaveRecordsForm(false)
                        }
                      }
                    },
                    [_vm._v("Cancel")]
                  )
                ]
              )
            ]
          )
        ])
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("h2", { staticClass: "hndle ui-sortable-handle" }, [
      _c("span", [_vm._v("Leave Form")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v("\n\t\t\t\t\t\t\tEmployee\n\t\t\t\t\t\t\t"),
      _c("em", [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: "" } }, [
      _vm._v("\n\t\t\t\t\t\t\tOthers employee\n\t\t\t\t\t\t\t"),
      _c("em")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v("\n\t\t\t\t\t\t\tLeave Type\n\t\t\t\t\t\t\t"),
      _c("em", [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: "" } }, [
      _vm._v("\n\t\t\t\t\t\t\tLeave type\n\t\t\t\t\t\t\t"),
      _c("em")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: "" } }, [
      _vm._v("\n\t\t\t\t\t\t\tComments\n\t\t\t\t\t\t\t"),
      _c("em")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_vm._v("Leave Duration"), _c("em", [_vm._v("*")])])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-9e55cf1a", esExports)
  }
}

/***/ }),

/***/ 297:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "wrap hrm-leave" },
    [
      _c("h1", { staticClass: "wp-heading-inline" }, [_vm._v("Leaves")]),
      _vm._v(" "),
      _c(
        "a",
        {
          staticClass: "page-title-action hrm-btn",
          attrs: { href: "#" },
          on: {
            click: function($event) {
              $event.preventDefault()
              _vm.showHideLeaveRecordsForm("toggle")
            }
          }
        },
        [_vm._v("\n\t\tAdd New\n\t")]
      ),
      _vm._v(" "),
      _c("leave-header"),
      _vm._v(" "),
      _vm.is_leave_form_active ? _c("hrm-leave-records-form") : _vm._e(),
      _vm._v(" "),
      _c("hrm-leave-records-render")
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-9e59df24", esExports)
  }
}

/***/ }),

/***/ 305:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("input", {
    attrs: { type: "text" },
    domProps: { value: _vm.value }
  })
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-fbe01182", esExports)
  }
}

/***/ }),

/***/ 309:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(242);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(70)("2c46b7d2", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-5a9b2a85\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-records-render.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-5a9b2a85\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-records-render.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 311:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(244);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(70)("5ea5ec00", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-909d1da8\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-search.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-909d1da8\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-search.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 312:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(245);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(70)("48e1b8f4", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-9e55cf1a\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-records-form.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-9e55cf1a\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-records-form.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 313:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(246);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(70)("7cf44b32", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-9e59df24\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-records.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-9e59df24\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-records.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 36:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_vue__ = __webpack_require__(228);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_9e59df24_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_vue__ = __webpack_require__(297);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(313)
}
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */

/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_9e59df24_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/leave/leave-records.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-9e59df24", Component.options)
  } else {
    hotAPI.reload("data-v-9e59df24", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 69:
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function(useSourceMap) {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		return this.map(function (item) {
			var content = cssWithMappingToString(item, useSourceMap);
			if(item[2]) {
				return "@media " + item[2] + "{" + content + "}";
			} else {
				return content;
			}
		}).join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};

function cssWithMappingToString(item, useSourceMap) {
	var content = item[1] || '';
	var cssMapping = item[3];
	if (!cssMapping) {
		return content;
	}

	if (useSourceMap && typeof btoa === 'function') {
		var sourceMapping = toComment(cssMapping);
		var sourceURLs = cssMapping.sources.map(function (source) {
			return '/*# sourceURL=' + cssMapping.sourceRoot + source + ' */'
		});

		return [content].concat(sourceURLs).concat([sourceMapping]).join('\n');
	}

	return [content].join('\n');
}

// Adapted from convert-source-map (MIT)
function toComment(sourceMap) {
	// eslint-disable-next-line no-undef
	var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));
	var data = 'sourceMappingURL=data:application/json;charset=utf-8;base64,' + base64;

	return '/*# ' + data + ' */';
}


/***/ }),

/***/ 70:
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__(71)

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction) {
  isProduction = _isProduction

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[data-vue-ssr-id~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),

/***/ 71:
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


/***/ }),

/***/ 72:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__router__ = __webpack_require__(21);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



var Hrm_Leave_Header = {
    mixins: [HRMMixin.leave],

    data: function () {
        return {
            menu: __WEBPACK_IMPORTED_MODULE_0__router__["a" /* default */]
        };
    },

    methods: {
        childrens() {
            let root_menu = this.$route.matched[1].name;
            let index = this.getIndex(this.menu, root_menu, 'name');

            if (index === false) {
                return [];
            }

            if (this.menu[index].hasOwnProperty('children')) {
                if (this.menu[index].children.length) {
                    return this.menu[index].children;
                }
            } else {
                return [];
            }
        },
        is_it_child: function () {

            if (this.$route.matched.length > 1) {
                return true;
            }
        },
        has_child_menu: function () {
            var path = this.$route.path,
                has_submenu = false;

            jQuery.each(this.header, function (key, val) {

                if (val.url == path) {
                    if (typeof val.submenu != 'undefined' && jQuery(val.submenu).length) {
                        has_submenu = true;
                    }
                }
            });

            return has_submenu;
        },
        get_child_menu: function () {
            var path = this.$route.path,
                submenu = [];

            if (this.is_it_child()) {
                var partent_name = this.$route.matched[0].name;

                jQuery.each(this.header, function (key, val) {
                    if (val.name == partent_name) {
                        if (typeof val.submenu != 'undefined' && jQuery(val.submenu).length) {
                            submenu = val.submenu;
                        }
                    }
                });

                return submenu;
            }

            jQuery.each(this.header, function (key, val) {
                if (val.url == path) {
                    if (typeof val.submenu != 'undefined' && jQuery(val.submenu).length) {
                        submenu = val.submenu;
                    }
                }
            });

            return submenu;
        },
        getHeader: function () {
            var request_data = {
                _wpnonce: HRM_Vars.nonce
            },
                self = this;

            wp.ajax.send('leave_header', {
                data: request_data,
                success: function (res) {
                    self.header = res.header;
                    //self.$store.commit( 'header', {'header': res.header} );
                },

                error: function (res) {}
            });
        }
    }
};

/* harmony default export */ __webpack_exports__["a"] = (Hrm_Leave_Header);

/***/ })

});