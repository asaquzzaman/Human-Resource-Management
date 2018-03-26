wpSpearHrm([2],{

/***/ 146:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__router__ = __webpack_require__(37);
//
//
//
//
//
//
//
//
//
//
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
            menu: __WEBPACK_IMPORTED_MODULE_0__router__["a" /* default */][0].children
        };
    },

    created() {},

    methods: {
        childrens() {
            if (!this.has_child) {
                return [];
            }

            let root_menu = this.getParentName();
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

        has_child: function () {

            if (this.$route.matched.length > 1) {
                return true;
            }

            return false;
        },

        getParentName() {
            let index = this.getIndex(this.$route.matched, this.$route.name, 'name');
            index = parseInt(index) - 1;
            return this.$route.matched[index].name;
        }
    }
};

/* harmony default export */ __webpack_exports__["a"] = (Hrm_Leave_Header);

/***/ }),

/***/ 147:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_header_vue__ = __webpack_require__(146);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0385a22a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_header_vue__ = __webpack_require__(148);
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0385a22a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_header_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-header.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0385a22a", Component.options)
  } else {
    hotAPI.reload("data-v-0385a22a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 148:
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
            key: index,
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
        _vm._l(_vm.childrens(), function(children, child_key) {
          return _c(
            "li",
            { key: child_key },
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
    require("vue-hot-reload-api")      .rerender("data-v-0385a22a", esExports)
  }
}

/***/ }),

/***/ 306:
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

/***/ 307:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__leave_form_directive__ = __webpack_require__(343);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__leave_form_directive___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__leave_form_directive__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
			isLeaveTypeEnable: false,
			leaveCalendar: ''
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
		'hrm-multiselect': hrm.Multiselect.default
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
			this.leaveCalendar.refetchEvents();
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
				hrm.Toastr.error('Please select your leave date');
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

			var form_data = {
				data: request_data,

				beforeSend: function (xhr) {
					self.is_leave_btn_disable = true;
					self.show_spinner = true;
					self.loadingStart('hrm-leave-records-form', { animationClass: 'preloader-update-animation' });
				},

				success: function (res) {
					self.is_leave_btn_disable = false;
					self.show_spinner = false;
					self.loadingStop('hrm-leave-records-form');

					// Display a success toast, with a title
					hrm.Toastr.success(res.success);
					self.$store.commit('leave/afterCreateNewLeave', res.resource);
					self.showHideLeaveRecordsForm(false);

					//    hrm.Vue.nextTick(function() {
					//     var tr = jQuery('.wp-list-table')
					//     	.find('tbody tr:first-child');

					//     self.newRecordEffect(tr);
					// })
				},

				error: function (res) {
					self.show_spinner = false;
					// Showing error
					res.error.map(function (value, index) {
						hrm.Toastr.error(value);
					});
				}
			};

			this.httpRequest('create_new_leave', form_data);
		},

		change_leve_type_statue: function () {
			var self = this;
			jQuery.each(this.calendar_evt_id, function (index, event_id) {
				self.leaveCalendar.removeEvents(event_id);
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
			var start = hrm.Moment(start._d).format('YYYY-MM-DD');
			var end = jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('getView').end;
			var end = hrm.Moment(end._d).format('YYYY-MM-DD');

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

/***/ 308:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__leave_search_vue__ = __webpack_require__(391);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
			var date = hrm.Moment(date).format('YYYY-MM-DD');

			return hrm.Moment(date).startOf('month').format('YYYY-MM-DD');
		},

		groupToDay(group, day) {
			return {
				date: day,
				activities: group
			};
		},
		selfDateFormat(date) {
			return hrm.Moment(date).format('MMMM');
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

/***/ 309:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__leave_header_vue__ = __webpack_require__(147);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__leave_records_add_btn_vue__ = __webpack_require__(388);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__leave_records_form_vue__ = __webpack_require__(389);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__leave_records_render_vue__ = __webpack_require__(390);
//
//
//
//
//
//
//
//
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

/***/ 311:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__common_date_picker_vue__ = __webpack_require__(44);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
		'hrm-multiselect': hrm.Multiselect.default,
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

/***/ 343:
/***/ (function(module, exports) {

var leaveCalendar;

var HRM_Leave_Apply_Calendar = {
	calendar: function (el, context) {

		var $ = jQuery,
		    work_week = this.work_week_convert_numeric(context.work_week),
		    emp_leave_with_type_record = context.emp_leave_with_type_record,
		    el = $(el);

		leaveCalendar = new hrm.Fullcalendar.Calendar(el, {
			header: {
				left: 'prev,next',
				center: 'title',
				right: 'prev,next'
			},
			height: 400,
			navLinks: false, // can click day/week names to navigate views
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			fixedWeekCount: false, //remove others month days for current month
			showNonCurrentDates: false,
			displayEventTime: false,
			allDay: true,

			dayClick: function (date, jsEvent, view) {
				var emp_id = HRM_Leave_Apply_Calendar.getContentEmpId(context);

				if (!emp_id) {
					// Display a success toast, with a title
					hrm.Toastr.error('Please select employee');
					return;
				}

				var has_leave = HRM_Leave_Apply_Calendar.has_leave_in_this_day(date, jsEvent, view, context);

				if (has_leave) {
					// Display a success toast, with a title
					hrm.Toastr.error('Leave alrady exist');
					return;
				}
				var is_disable_leave_type = context.disable_leave_type;

				if (is_disable_leave_type === true) {
					HRM_Leave_Apply_Calendar.inseret_leave_when_leave_type_is_not_exist(context, date, jsEvent, view);
					return;
				}

				if (!context.leave_type) {
					hrm.Toastr.error('Please select leave type');
					return false;
				}

				var has_entitlement = HRM_Leave_Apply_Calendar.has_entitlement(date, jsEvent, view, context);

				if (!has_entitlement) {
					hrm.Toastr.error('Leave entitlement exist');
					return false;
				}

				HRM_Leave_Apply_Calendar.inseret_leave_when_leave_type_exist(context, date, jsEvent, view);
			},

			events: function (start, end, timezone, callback) {

				var emp_id = HRM_Leave_Apply_Calendar.getContentEmpId(context);

				if (!emp_id) {
					return [];
				}

				var request_data = {
					_wpnonce: HRM_Vars.nonce,
					start: HRM_Leave_Apply_Calendar.get_date(start._d),
					end: HRM_Leave_Apply_Calendar.get_date(end._d),
					emp_id: emp_id

				};

				wp.ajax.send('get_leave_record_events', {
					data: request_data,

					beforeSend() {
						context.loadingStart('hrm-leave-records-form', { animationClass: 'preloader-update-animation' });
					},

					success: function (res) {
						var events = HRM_Leave_Apply_Calendar.leave_records_render(res.records.data, context);
						var weekend = HRM_Leave_Apply_Calendar.render_weekend(start._d, end._d, res.work_week);
						var holidays = HRM_Leave_Apply_Calendar.render_holidays(start._d, end._d, res.holidays);
						events = events.concat(weekend, holidays);
						context.apply_emp_lev_records = res.records;

						context.loadingStop('hrm-leave-records-form');

						callback(events);
					}
				});
			},

			eventClick: function (calEvent, jsEvent, view) {
				var is_disable_leave_type = context.disable_leave_type;

				if (is_disable_leave_type) {
					HRM_Leave_Apply_Calendar.remove_event_when_leave_type_is_not_exist(context, calEvent, jsEvent, view);
				} else {
					HRM_Leave_Apply_Calendar.remove_event_when_leave_type_exist(context, calEvent, jsEvent, view);
				}
			}
		});

		context.leaveCalendar = leaveCalendar;

		leaveCalendar.render();
	},

	remove_event_when_leave_type_exist: function (context, calEvent, jsEvent, view) {
		var in_collect = context.calendar_evt_id.indexOf(calEvent._id);

		if (in_collect == '-1') {
			return;
		}

		var leave_start_date = hrm.Moment(calEvent.start._d).format('YYYY-MM-DD'),
		    collected_lv_st_d = context.apply_leave_date.indexOf(leave_start_date);

		leaveCalendar.removeEvents(calEvent._id);

		context.calendar_evt_id.splice(in_collect, 1);
		context.apply_leave_date.splice(collected_lv_st_d, 1);
	},

	remove_event_when_leave_type_is_not_exist: function (context, calEvent, jsEvent, view) {
		var in_collect = context.calendar_evt_id.indexOf(calEvent._id);
		if (in_collect == '-1') {
			return;
		}

		var leave_start_date = hrm.Moment(calEvent.start._d).format('YYYY-MM-DD'),
		    collected_lv_st_d = context.apply_leave_date.indexOf(leave_start_date);

		leaveCalendar.removeEvents(calEvent._id);

		context.calendar_evt_id.splice(in_collect, 1);
		context.apply_leave_date.splice(collected_lv_st_d, 1);
	},

	inseret_leave_when_leave_type_exist: function (context, date, jsEvent, view) {
		var lv_records = context.apply_emp_lev_records,
		    selected_leave_type = context.leave_type,
		    index = context.getIndex(lv_records.meta.types, selected_leave_type.id, 'id'),
		    lv_type = lv_records.meta.types[index];

		var newEvent = {
			title: lv_type.leave_type_name,
			start: hrm.Moment(date._d).format('YYYY-MM-DD'), //self.get_date(val.start_time),
			end: hrm.Moment(date._d).add(1, 'days').format('YYYY-MM-DD'), //self.get_date(val.end_time),
			backgroundColor: '#e08989',
			borderColor: '#e08989',
			allDay: true
		};

		var evt = leaveCalendar.renderEvent(newEvent, true);

		if (evt.length) {
			jQuery.each(evt, function (indev, val) {
				var start = hrm.Moment(val.start._d).format('YYYY-MM-DD');
				context.calendar_evt_id.push(val._id);
				context.apply_leave_date.push(start);
			});
		}
	},

	inseret_leave_when_leave_type_is_not_exist: function (context, date, jsEvent, view) {

		var newEvent = {
			title: 'Extra',
			start: hrm.Moment(date._d).format('YYYY-MM-DD'), //self.get_date(val.start_time),
			end: hrm.Moment(date._d).add(1, 'days').format('YYYY-MM-DD'), //self.get_date(val.end_time),
			backgroundColor: '#e08989',
			borderColor: '#e08989',
			allDay: true
		};

		var evt = leaveCalendar.renderEvent(newEvent, true);

		if (evt.length) {
			jQuery.each(evt, function (indev, val) {
				var start = hrm.Moment(val.start._d).format('YYYY-MM-DD');
				context.calendar_evt_id.push(val._id);
				context.apply_leave_date.push(start);
			});
		}
	},

	has_entitlement: function (date, jsEvent, view, context) {
		var lv_records = context.apply_emp_lev_records,
		    selected_leave_type = context.leave_type,
		    index = context.getIndex(lv_records.meta.types, selected_leave_type.id, 'id'),
		    lv_type = lv_records.meta.types[index],
		    count = context.apply_leave_date.length + lv_type.count;

		if (lv_type.entitlement > count) {
			return true;
		}

		return false;
	},

	render_weekend: function (start, end, work_week) {
		var work_week = HRM_Leave_Apply_Calendar.work_week_convert_numeric(work_week),
		    events = [];

		jQuery.each(work_week, function (key, val) {

			var days_in_month = HRM_Leave_Apply_Calendar.weekend_in_month(start, end, val);

			jQuery.each(days_in_month, function (index, date) {
				var new_obj = {
					title: 'Weekend',
					start: hrm.Moment(date).format('YYYY-MM-DD'),
					end: hrm.Moment(date).add(1, 'days').format('YYYY-MM-DD'),
					backgroundColor: '#e08989',
					borderColor: '#e08989',
					allDay: true
				};

				events.push(new_obj);
			});
		});

		return events;
	},

	render_holidays: function (start, end, holidays) {

		var events = [];

		jQuery.each(holidays, function (key, holiday) {
			var new_obj = {
				title: holiday.name + ' (Holidays)',
				start: hrm.Moment(holiday.from).format('YYYY-MM-DD'),
				end: hrm.Moment(holiday.to).add(1, 'days').format('YYYY-MM-DD'),
				backgroundColor: '#e08989',
				borderColor: '#e08989',
				allDay: true
			};

			events.push(new_obj);
		});

		return events;
	},

	has_leave_in_this_day: function (date, jsEvent, view, context) {
		var cell_date = hrm.Moment(date._d).format('YYYY-MM-DD'),
		    events = leaveCalendar.clientEvents(),
		    has_leave = [];

		jQuery.each(events, function (key, val) {
			var start = hrm.Moment(val.start._d).format('YYYY-MM-DD'),
			    end = hrm.Moment(val.end._d).subtract(1, 'days').format('YYYY-MM-DD');

			if (hrm.Moment(cell_date).isBetween(start, end, null, '[]')) {
				has_leave.push(val.title);
			}
		});

		return has_leave.length ? true : false;
	},

	weekend_in_month: function (start, end, day) {
		var start = new Date(start),
		    end = new Date(end);

		var date = start;
		var dates = [];

		while (date < end) {
			if (date.getDay() === day) {
				var setDate = hrm.Moment(date).format('YYYY-MM-DD'); //HRM_Leave_Apply_Calendar.get_date(date);
				dates.push(setDate);
			}
			date.setDate(date.getDate() + 1);
		}

		return dates;
	},

	leave_records_render: function (events, context) {
		var evt = [];

		jQuery.each(events, function (key, val) {

			var obj = {
				id: val.id,
				title: val.type == '0' ? 'Extra' : val.leave_type.data.name,
				start: hrm.Moment(val.start_time).format('YYYY-MM-DD'), //self.get_date(val.start_time),
				end: hrm.Moment(val.end_time).add(1, 'days').format('YYYY-MM-DD'), //self.get_date(val.end_time),
				backgroundColor: '#e08989',
				borderColor: '#e08989',
				allDay: true
			};

			evt.push(obj);
		});

		return evt;
	},

	work_week_convert_numeric: function (work_week) {
		var non_working_days = [];

		jQuery.each(work_week, function (key, val) {
			if (key == 'sunday' && val == 'non') {
				non_working_days.push(0);
			}

			if (key == 'moday' && val == 'non') {
				non_working_days.push(1);
			}

			if (key == 'tuesday' && val == 'non') {
				non_working_days.push(2);
			}

			if (key == 'wednesday' && val == 'non') {
				non_working_days.push(3);
			}

			if (key == 'thursday' && val == 'non') {
				non_working_days.push(4);
			}

			if (key == 'friday' && val == 'non') {
				non_working_days.push(5);
			}

			if (key == 'saturday' && val == 'non') {
				non_working_days.push(6);
			}
		});

		return non_working_days;
	},

	get_time: function (date) {
		var d = new Date(date),
		    str_d = d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate(),
		    dd = new Date(str_d);

		return dd.getTime();
	},

	get_date: function (date) {
		var d = new Date(date);
		return d.getFullYear() + '-' + ("0" + (d.getMonth() + 1)).slice(-2) + '-' + ("0" + d.getDate()).slice(-2);
	},

	getContentEmpId(context) {
		if (context.leave_proxy && !context.selectedEmployee) {
			return false;
		}

		if (context.leave_proxy && context.selectedEmployee) {

			var emp_id = context.selectedEmployee.ID;
		} else {
			var emp_id = HRM_Vars.current_user.data.ID;
		}

		return emp_id;
	},

	holidayDatePicker(el, vnodeContext) {

		jQuery(".hrm-date-picker-from").datepicker({
			dateFormat: 'yy-mm-dd',
			changeYear: true,
			changeMonth: true,
			numberOfMonths: 1,
			minDate: HRM_Vars.financial_start,
			maxDate: HRM_Vars.financial_end,
			onClose: function (selectedDate) {
				jQuery(".hrm-date-picker-to").datepicker("option", "minDate", selectedDate);
			},
			onSelect: function (dateText) {
				vnodeContext.$emit('hrm_date_picker', { field: 'datepicker_from', date: dateText, self: this });
			}
		});

		jQuery(".hrm-date-picker-to").datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			numberOfMonths: 1,
			minDate: HRM_Vars.financial_start,
			maxDate: HRM_Vars.financial_end,
			onClose: function (selectedDate) {
				jQuery(".hrm-date-picker-from").datepicker("option", "maxDate", selectedDate);
			},
			onSelect: function (dateText) {
				vnodeContext.$emit('hrm_date_picker', { field: 'datepicker_to', date: dateText });
			}
		});
	}
};

// Register a global custom directive called v-cpm-datepicker
hrm.Vue.directive('hrm-holiday-datepicker', {
	inserted: function (el, binding, vnode) {
		HRM_Leave_Apply_Calendar.holidayDatePicker(el, vnode.context);
	}
});

// Register a global custom directive called v-cpm-datepicker
hrm.Vue.directive('hrm-leave-jquery-fullcalendar', {
	inserted: function (el, binding, vnode) {
		HRM_Leave_Apply_Calendar.calendar(el, vnode.context);
	}
});

/***/ }),

/***/ 349:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(35)(false);
// imports


// module
exports.push([module.i, "\n.hrm-leave-employee-search-wrap .multiselect__input, \n.hrm-leave-employee-search-wrap .multiselect__input:focus,\n.hrm-leave-type-wrap .multiselect__input,\n.hrm-leave-type-wrap .multiselect__input:focus {\n\ttop: -5px;\n\tborder: none;\n\tbox-shadow: none;\n}\n.hrm-leave-employee-search-wrap .multiselect__content,\n.hrm-leave-type-wrap .multiselect__content {\n\tmargin-top: 0 !important;\n\tz-index: 99999 !important;\n}\n.hrm-leave-jquery-fullcalendar {\n\tmargin-left: 21%;\n\twidth: 50%;\n}\n.fc-center h2 {\n\tfont-size: 14px !important;\n\tfont-weight: 600 !important;\n}\n", ""]);

// exports


/***/ }),

/***/ 358:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(35)(false);
// imports


// module
exports.push([module.i, "\n.hrm-start-date, .hrm-end-date {\n\tfont-size: 11px;\n\tcolor: #333;\n\tfont-weight: 800;\n}\n.page-title-action {\n\tmargin-top: 14px;\n    padding: 4px 8px;\n    position: relative;\n    text-decoration: none;\n    border: none;\n    border: 1px solid #ccc;\n    -webkit-border-radius: 2px;\n    border-radius: 2px;\n    background: #f7f7f7;\n    text-shadow: none;\n    font-weight: 600;\n    font-size: 13px;\n    line-height: normal;\n    color: #0073aa;\n    outline: 0;\n    display: inline-block;\n}\n.wrap .page-title-action:hover {\n\tbackground: #f7f7f7;\n\tcolor: #0073aa;\n\tborder: 1px solid #ccc;\n}\n.ui-sortable-handle {\n\tborder: none !important;\n}\n.postbox .inside {\n\tmargin: 0 !important;\n}\n#wpbody-content .metabox-holder {\n\tpadding-top: 0 !important;\n}\n.metabox-holder {\n\tmargin-top: 8px;\n}\n", ""]);

// exports


/***/ }),

/***/ 360:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(35)(false);
// imports


// module
exports.push([module.i, "\n.hrm-employee-leave-records {\n\twidth: 50%;\n}\n", ""]);

// exports


/***/ }),

/***/ 363:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(35)(false);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),

/***/ 388:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_add_btn_vue__ = __webpack_require__(306);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_746ff137_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_add_btn_vue__ = __webpack_require__(447);
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_746ff137_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_add_btn_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-records-add-btn.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-746ff137", Component.options)
  } else {
    hotAPI.reload("data-v-746ff137", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 389:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_form_vue__ = __webpack_require__(307);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1e7c2f66_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_form_vue__ = __webpack_require__(414);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(474)
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1e7c2f66_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_form_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-records-form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1e7c2f66", Component.options)
  } else {
    hotAPI.reload("data-v-1e7c2f66", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 390:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_render_vue__ = __webpack_require__(308);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_52936bdf_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_render_vue__ = __webpack_require__(431);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(483)
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_52936bdf_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_render_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-records-render.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-52936bdf", Component.options)
  } else {
    hotAPI.reload("data-v-52936bdf", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 391:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_search_vue__ = __webpack_require__(311);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_5e05ac86_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_search_vue__ = __webpack_require__(438);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(488)
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_5e05ac86_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_search_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-search.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5e05ac86", Component.options)
  } else {
    hotAPI.reload("data-v-5e05ac86", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 414:
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
                  attrs: { id: "hrm-leave-records-form", action: "" },
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
                    _vm._m(7),
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
                    staticClass: "button hrm-button-primary button-primary",
                    attrs: {
                      disabled: _vm.is_leave_btn_disable,
                      type: "submit",
                      name: "requst",
                      value: "Save changes"
                    }
                  }),
                  _vm._v(" "),
                  _c(
                    "a",
                    {
                      staticClass: "button hrm-button-secondary",
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
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", [
      _c("strong", [_vm._v("To take leave just click the calendar date cell.")])
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-1e7c2f66", esExports)
  }
}

/***/ }),

/***/ 431:
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
        _c("hrm-leave-search"),
        _vm._v(" "),
        _c("div", { attrs: { id: "hrm-leave-record-wrap" } }, [
          _vm.isFetchRecord
            ? _c(
                "div",
                [
                  !_vm.records.length
                    ? _c("div", { staticClass: "notice notice-success" }, [
                        _c("p", [_vm._v("No leave record found")])
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.records.length
                    ? _c("div", { staticClass: "postbox" }, [
                        _vm._m(0),
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
                              {
                                staticClass:
                                  "wp-list-table widefat fixed striped"
                              },
                              [
                                _vm._m(1),
                                _vm._v(" "),
                                _c(
                                  "tbody",
                                  [
                                    _vm._l(_vm.meta.types, function(type) {
                                      return _c("tr", [
                                        _c("td", [
                                          _vm._v(_vm._s(type.leave_type_name))
                                        ]),
                                        _vm._v(" "),
                                        type.id === 1
                                          ? _c("td", [_vm._v("–")])
                                          : _c("td", [
                                              _vm._v(
                                                _vm._s(
                                                  _vm.pad(type.entitlement)
                                                )
                                              )
                                            ]),
                                        _vm._v(" "),
                                        _c("td", [
                                          _vm._v(_vm._s(_vm.pad(type.count)))
                                        ]),
                                        _vm._v(" "),
                                        type.id === 0
                                          ? _c("td", [_vm._v("–")])
                                          : _c("td", [
                                              _vm._v(
                                                _vm._s(
                                                  _vm.pad(
                                                    type.entitlement -
                                                      type.count
                                                  )
                                                )
                                              )
                                            ])
                                      ])
                                    }),
                                    _vm._v(" "),
                                    _c("tr", [
                                      _vm._m(2),
                                      _vm._v(" "),
                                      _c("td", [
                                        _c("strong", [
                                          _vm._v(
                                            _vm._s(
                                              _vm.pad(_vm.total.entitlement)
                                            )
                                          )
                                        ])
                                      ]),
                                      _vm._v(" "),
                                      _c("td", [
                                        _c("strong", [
                                          _vm._v(
                                            _vm._s(
                                              _vm.pad(_vm.total.taken_leave)
                                            )
                                          )
                                        ])
                                      ]),
                                      _vm._v(" "),
                                      _c("td", [
                                        _c("strong", [
                                          _vm._v(
                                            _vm._s(
                                              _vm.pad(_vm.total.remain_leave)
                                            )
                                          )
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
                        _c("span", [
                          _vm._v(_vm._s(_vm.selfDateFormat(record.date)))
                        ])
                      ]),
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
                            {
                              staticClass: "wp-list-table widefat fixed striped"
                            },
                            [
                              _vm._m(3, true),
                              _vm._v(" "),
                              _c(
                                "tbody",
                                _vm._l(record.activities, function(leave) {
                                  return _c(
                                    "tr",
                                    { attrs: { "data-recordID": leave.id } },
                                    [
                                      _c("td", [
                                        _vm._v(
                                          _vm._s(leave.leave_type.data.name)
                                        )
                                      ]),
                                      _vm._v(" "),
                                      _c("td", [_vm._v("1")]),
                                      _vm._v(" "),
                                      _c("td", [
                                        _vm._v(
                                          _vm._s(
                                            _vm.dateFormat(leave.start_time)
                                          )
                                        )
                                      ]),
                                      _vm._v(" "),
                                      _c("td", [
                                        _vm._v(
                                          _vm._s(_vm.dateFormat(leave.end_time))
                                        )
                                      ]),
                                      _vm._v(" "),
                                      _c("td", [
                                        _vm._v(_vm._s(_vm.status[leave.status]))
                                      ]),
                                      _vm._v(" "),
                                      _c("td", [
                                        leave.status === 1 || leave.status === 3
                                          ? _c(
                                              "button",
                                              {
                                                staticClass:
                                                  "hrm-button-secondary",
                                                on: {
                                                  click: function($event) {
                                                    $event.preventDefault()
                                                    _vm.selfLeaveDelete(
                                                      leave.id
                                                    )
                                                  }
                                                }
                                              },
                                              [_vm._v("Delete")]
                                            )
                                          : _c("div", [_vm._v("Not available")])
                                      ])
                                    ]
                                  )
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
            : _vm._e()
        ])
      ],
      1
    )
  ])
}
var staticRenderFns = [
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
      _c("tr", [
        _c("th", { staticClass: "manage-column column-cb" }, [
          _vm._v("Leave Type")
        ]),
        _vm._v(" "),
        _c("th", [_vm._v("Entitlement")]),
        _vm._v(" "),
        _c("th", [_vm._v("Taken Leave")]),
        _vm._v(" "),
        _c("th", [_vm._v("Remain")])
      ])
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
      _c("tr", [
        _c("th", { staticClass: "manage-column column-cb" }, [
          _vm._v("Leave Type")
        ]),
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
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-52936bdf", esExports)
  }
}

/***/ }),

/***/ 433:
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
      _vm.is_leave_form_active
        ? _c("hrm-leave-records-form", { staticClass: "hrm-toggle" })
        : _vm._e(),
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
    require("vue-hot-reload-api")      .rerender("data-v-55f37f58", esExports)
  }
}

/***/ }),

/***/ 438:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "hrm-tbl-action-wrap hrm-form-field hrm-leave-search-wrap" },
    [
      _c(
        "form",
        {
          on: {
            submit: function($event) {
              $event.preventDefault()
              _vm.leaveFilter()
            }
          }
        },
        [
          _c(
            "div",
            { staticClass: "hrm-table-action" },
            [
              _c("date-picker", {
                staticClass: "search-input pm-datepickter-to",
                attrs: {
                  placeholder: "Leave From",
                  dependency: "pm-datepickter-from"
                },
                model: {
                  value: _vm.start_time,
                  callback: function($$v) {
                    _vm.start_time = $$v
                  },
                  expression: "start_time"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "hrm-table-action" },
            [
              _c("date-picker", {
                staticClass: "search-input pm-datepickter-from",
                attrs: {
                  placeholder: "Leave To",
                  dependency: "pm-datepickter-to"
                },
                model: {
                  value: _vm.end_time,
                  callback: function($$v) {
                    _vm.end_time = $$v
                  },
                  expression: "end_time"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c("div", { staticClass: "hrm-table-action" }, [
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
              : _vm._e()
          ]),
          _vm._v(" "),
          _vm._m(0)
        ]
      )
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "hrm-table-action" }, [
      _c("input", {
        staticClass: "button hrm-button-secondary button-secondary",
        attrs: { type: "submit", value: "Filter" }
      })
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-5e05ac86", esExports)
  }
}

/***/ }),

/***/ 447:
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
    require("vue-hot-reload-api")      .rerender("data-v-746ff137", esExports)
  }
}

/***/ }),

/***/ 474:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(349);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(36)("790f1ea3", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1e7c2f66\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-records-form.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1e7c2f66\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-records-form.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 483:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(358);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(36)("a89f6d18", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-52936bdf\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-records-render.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-52936bdf\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-records-render.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 485:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(360);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(36)("7cb7f01e", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-55f37f58\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-records.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-55f37f58\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-records.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 488:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(363);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(36)("58851ca4", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-5e05ac86\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-search.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-5e05ac86\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-search.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 55:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_vue__ = __webpack_require__(309);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_55f37f58_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_vue__ = __webpack_require__(433);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(485)
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_55f37f58_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-records.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-55f37f58", Component.options)
  } else {
    hotAPI.reload("data-v-55f37f58", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ })

});