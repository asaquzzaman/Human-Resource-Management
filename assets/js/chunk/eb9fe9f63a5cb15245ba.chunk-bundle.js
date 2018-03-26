wpSpearHrm([6,30],{

/***/ 149:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__router__ = __webpack_require__(40);
//
//
//
//
//
//
//
//
//
//
//
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

/***/ 150:
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

/* harmony default export */ __webpack_exports__["a"] = ({
	mixins: [HRMMixin.attendance],

	data: function () {
		return {
			//punch_in_date: 'sdgfashjfdgsad',
			//punch_out_date: '',
			//search_user_id: '-1'
		};
	},

	computed: {
		manageAttendance() {
			if (hrm_user_can('manage_attendance')) {
				return true;
			}

			return false;
		},
		employessDropDown() {
			return this.$store.state.attendance.employessDropDown;
		},
		punch_in_date: function () {
			return this.$store.state.attendance.punch_in_date;
		},

		punch_out_date: function () {
			return this.$store.state.attendance.punch_out_date;
		},

		search_user_id: {
			get: function () {
				return this.$route.query.user_id ? this.$route.query.user_id : '-1';
			},

			set: function (val) {
				this.$store.commit('attendance/setSearchUserId', val);
			}
		}
	},

	created: function () {
		this.$on('hrm_date_picker', this.setdate);
		this.$store.commit('attendance/searchMode', { status: true });
	},

	methods: {

		setdate: function (date) {
			if (date.field == 'datepicker_from') {
				this.$store.commit('attendance/setPunchInDate', { date: date });
			}

			if (date.field == 'datepicker_to') {
				this.$store.commit('attendance/setPunchOutDate', { date: date });
			}
		},
		search: function () {
			this.$router.push({
				query: {
					punch_in: this.$store.state.attendance.punch_in_date,
					punch_out: this.$store.state.attendance.punch_out_date,
					user_id: this.$store.state.attendance.search_user_id
				}
			});

			this.getAttendance();
		}
	}
});

/***/ }),

/***/ 274:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_attendance_header_vue__ = __webpack_require__(149);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1eeeb27b_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_attendance_header_vue__ = __webpack_require__(275);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_attendance_header_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1eeeb27b_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_attendance_header_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/attendance/attendance-header.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1eeeb27b", Component.options)
  } else {
    hotAPI.reload("data-v-1eeeb27b", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 275:
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
        return item.meta.label
          ? _c(
              "router-link",
              {
                key: index,
                staticClass: "nav-tab",
                attrs: { to: { name: item.name } }
              },
              [_vm._v(_vm._s(item.meta.label))]
            )
          : _vm._e()
      })
    ),
    _vm._v(" "),
    _c("h3", { staticClass: "hrm-sub-nav" }, [
      _c(
        "ul",
        { staticClass: "hrm-subsubsub" },
        _vm._l(_vm.childrens(), function(children, child_key) {
          return children.meta.label
            ? _c(
                "li",
                { key: child_key },
                [
                  _c(
                    "router-link",
                    { attrs: { to: { name: children.name } } },
                    [_vm._v(_vm._s(children.meta.label))]
                  ),
                  _vm._v(" |  \n            ")
                ],
                1
              )
            : _vm._e()
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
    require("vue-hot-reload-api")      .rerender("data-v-1eeeb27b", esExports)
  }
}

/***/ }),

/***/ 277:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "hrm-tbl-action-wrap" }, [
    _c(
      "div",
      { staticClass: "hrm-table-action main hrm-attendance-user-searach-main" },
      [
        _c("input", {
          directives: [{ name: "hrm-datepicker", rawName: "v-hrm-datepicker" }],
          staticClass: "hrm-date-picker-from",
          attrs: {
            type: "text",
            placeholder: "From",
            name: "punch_in",
            value: "",
            id: "punch_in"
          },
          domProps: { value: _vm.punch_in_date }
        }),
        _vm._v(" "),
        _c("input", {
          directives: [{ name: "hrm-datepicker", rawName: "v-hrm-datepicker" }],
          staticClass: "hrm-date-picker-to",
          attrs: {
            type: "text",
            placeholder: "To",
            name: "punch_out",
            value: "",
            id: "punch_out"
          },
          domProps: { value: _vm.punch_out_date }
        }),
        _vm._v(" "),
        _vm.manageAttendance
          ? _c(
              "select",
              {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.search_user_id,
                    expression: "search_user_id"
                  }
                ],
                staticClass: "user_id",
                attrs: { name: "user_id", id: "user_id" },
                on: {
                  change: function($event) {
                    var $$selectedVal = Array.prototype.filter
                      .call($event.target.options, function(o) {
                        return o.selected
                      })
                      .map(function(o) {
                        var val = "_value" in o ? o._value : o.value
                        return val
                      })
                    _vm.search_user_id = $event.target.multiple
                      ? $$selectedVal
                      : $$selectedVal[0]
                  }
                }
              },
              [
                _c("option", { attrs: { value: "-1" } }, [
                  _vm._v("-Select Employee-")
                ]),
                _vm._v(" "),
                _vm._l(_vm.employessDropDown, function(employee, id) {
                  return _c("option", { domProps: { value: id } }, [
                    _vm._v(_vm._s(employee))
                  ])
                })
              ],
              2
            )
          : _vm._e(),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "button button-secondary attendance-search-btn",
            on: {
              click: function($event) {
                $event.preventDefault()
                _vm.search()
              }
            }
          },
          [_vm._v("Find")]
        )
      ]
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
    require("vue-hot-reload-api")      .rerender("data-v-7ce2dd28", esExports)
  }
}

/***/ }),

/***/ 280:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__common_clock_vue__ = __webpack_require__(375);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
	mixins: [HRMMixin.attendance],
	data: function () {
		return {
			press_punch_in_btn: false,
			press_punch_our_btn: false,
			punch_out_disable: false,
			punch_id: 0
		};
	},
	created() {},
	components: {
		'clock': __WEBPACK_IMPORTED_MODULE_0__common_clock_vue__["a" /* default */]
	},
	methods: {

		punchIn: function () {

			//for preventing multipule submit
			if (this.press_punch_in_btn) {
				return false;
			}

			//for preventing multipule submit
			this.press_punch_in_btn = true;

			var request_data = {
				_wpnonce: HRM_Vars.nonce
			},
			    self = this;

			wp.ajax.send('punch_in', {
				data: request_data,
				success: function (res) {
					// Display a success toast, with a title
					hrm.Toastr.success(res.success);
					//self.punch_id = res.punch_id;
					//self.punch_id = res.punch_in_status;

					self.$store.commit('attendance/setAttendance', {
						records: res.attendance,
						totalOfficeTime: res.total_time
					});
					self.$store.commit('attendance/punch_in', { status: 'disable' });

					//for preventing multipule submit
					self.press_punch_in_btn = false;
				},

				error: function (res) {
					//for preventing multipule submit
					self.press_punch_in_btn = false;

					// Showing error
					res.error.map(function (value, index) {
						hrm.Toastr.error(value);
					});
				}
			});
		},

		punchOut: function () {
			//for preventing multipule submit
			if (this.press_punch_our_btn) {
				return false;
			}

			//for preventing multipule submit
			this.press_punch_our_btn = true;

			var request_data = {
				_wpnonce: HRM_Vars.nonce
			},
			    self = this;

			self.punch_out_disable = true;

			wp.ajax.send('punch_out', {
				data: request_data,
				success: function (res) {
					// Display a success toast, with a title
					hrm.Toastr.success(res.success);
					self.punch_out_disable = false;

					self.$store.commit('attendance/setAttendance', {
						records: res.attendance,
						totalOfficeTime: res.total_time
					});

					self.$store.commit('attendance/punch_in', { status: res.punch_in_status });

					//for preventing multipule submit
					self.press_punch_our_btn = false;
				},

				error: function (res) {
					self.punch_out_disable = false;
					//for preventing multipule submit
					self.press_punch_our_btn = false;

					// Showing error
					res.error.map(function (value, index) {
						hrm.Toastr.error(value);
					});
				}
			});
		},

		isDisabled: function () {
			if (this.$store.state.attendance.punch_in_status == 'enable') {
				return false;
			}

			return true;
		}
	}
});

/***/ }),

/***/ 281:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__attendance_punch_in_out_btn_vue__ = __webpack_require__(374);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__attendance_user_search_vue__ = __webpack_require__(38);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__attendance_header_vue__ = __webpack_require__(274);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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

	mixins: [HRMMixin.attendance],

	components: {
		'hrm-attendace-punch-in-out-btn': __WEBPACK_IMPORTED_MODULE_0__attendance_punch_in_out_btn_vue__["a" /* default */],
		'hrm-attendace-user-search': __WEBPACK_IMPORTED_MODULE_1__attendance_user_search_vue__["default"],
		'hrm-attendance-header': __WEBPACK_IMPORTED_MODULE_2__attendance_header_vue__["a" /* default */]
	},

	data: function () {
		return {};
	},

	created: function () {
		this.attendanceInit();
		this.getAttendance();
	},

	computed: {
		totalOfficeTime: function () {
			return this.$store.state.attendance.totalOfficeTime;
		},
		attendace_records: function () {
			return this.$store.state.attendance.attendance;
		},
		punchInFormatedDate: function () {
			let date = this.$store.state.attendance.punch_in_formated_date;

			return date ? date : this.firstDay();
		},
		punchOutFormatedDate: function () {
			let date = this.$store.state.attendance.punch_out_formated_date;
			return date ? date : this.lastDay();
		}
	},
	methods: {
		attendanceInit: function () {
			var request_data = {
				_wpnonce: HRM_Vars.nonce
			},
			    self = this;

			wp.ajax.send('attendance_init', {
				data: request_data,
				success: function (res) {
					self.$store.commit('attendance/setInitVal', res);
				},

				error: function (res) {}
			});
		},

		firstDay() {

			var date = new Date(),
			    y = date.getFullYear(),
			    m = date.getMonth();

			var firstDay = new Date(y, m, 1);

			date = hrm.Moment(firstDay).format('YYYY-MM-DD');

			var format = 'MMMM DD YYYY';

			if (HRM_Vars.wp_date_format == 'Y-m-d') {
				format = 'YYYY-MM-DD';
			} else if (HRM_Vars.wp_date_format == 'm/d/Y') {
				format = 'MM/DD/YYYY';
			} else if (HRM_Vars.wp_date_format == 'd/m/Y') {
				format = 'DD/MM/YYYY';
			}

			return hrm.Moment(date).format(format);
		},

		lastDay() {
			var date = new Date(),
			    y = date.getFullYear(),
			    m = date.getMonth();

			var lastDay = new Date(y, m + 1, 0);

			date = hrm.Moment(lastDay).format('YYYY-MM-DD');

			var format = 'MMMM DD YYYY';

			if (HRM_Vars.wp_date_format == 'Y-m-d') {
				format = 'YYYY-MM-DD';
			} else if (HRM_Vars.wp_date_format == 'm/d/Y') {
				format = 'MM/DD/YYYY';
			} else if (HRM_Vars.wp_date_format == 'd/m/Y') {
				format = 'DD/MM/YYYY';
			}

			return hrm.Moment(date).format(format);
		}
	}
});

/***/ }),

/***/ 282:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//


/* harmony default export */ __webpack_exports__["a"] = ({
    data() {
        return {
            time: Date.now()
        };
    },
    computed: {
        display() {
            return hrm.Moment(this.time).format('LTS');
        }
    },
    created() {
        setInterval(() => {
            this.time = Date.now();
        }, 1000);
    }
});

/***/ }),

/***/ 374:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_attendance_punch_in_out_btn_vue__ = __webpack_require__(280);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_22028cbc_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_attendance_punch_in_out_btn_vue__ = __webpack_require__(416);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_attendance_punch_in_out_btn_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_22028cbc_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_attendance_punch_in_out_btn_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/attendance/attendance-punch-in-out-btn.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-22028cbc", Component.options)
  } else {
    hotAPI.reload("data-v-22028cbc", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 375:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_clock_vue__ = __webpack_require__(282);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_3e30099a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_clock_vue__ = __webpack_require__(426);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_clock_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_3e30099a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_clock_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/common/clock.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3e30099a", Component.options)
  } else {
    hotAPI.reload("data-v-3e30099a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 38:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_attendance_user_search_vue__ = __webpack_require__(150);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_7ce2dd28_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_attendance_user_search_vue__ = __webpack_require__(277);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_attendance_user_search_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_7ce2dd28_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_attendance_user_search_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/attendance/attendance-user-search.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7ce2dd28", Component.options)
  } else {
    hotAPI.reload("data-v-7ce2dd28", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 416:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "metabox-holder hrm-punch-in-out-wrap" }, [
    _c("div", { staticClass: "postbox" }, [
      _vm._m(0),
      _vm._v(" "),
      _c("div", { staticClass: "inside" }, [
        _c("div", { staticClass: "main hrm-punch-in-out-main" }, [
          _c("div", { staticClass: "hrm-clock-wrap" }, [
            _c("strong", [
              _c("time", [
                _c("i", { staticClass: "far fa-calendar-alt" }),
                _vm._v(" " + _vm._s(_vm.currentDate()))
              ])
            ]),
            _vm._v(" "),
            _c("strong", [
              _c(
                "time",
                [
                  _c("i", { staticClass: "far fa-clock" }),
                  _vm._v(" "),
                  _c("clock")
                ],
                1
              )
            ])
          ]),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "button hrm-button-primary button-primary",
              attrs: { disabled: _vm.isDisabled() },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  _vm.punchIn()
                }
              }
            },
            [_vm._v("Punch In")]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "button hrm-button-secondary button-secondary",
              attrs: { disabled: _vm.punch_out_disable },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  _vm.punchOut()
                }
              }
            },
            [_vm._v("Punch Out")]
          )
        ])
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("h2", { staticClass: "hndle ui-sortable-handle" }, [
      _c("span", [_vm._v("Punch in/out")])
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-22028cbc", esExports)
  }
}

/***/ }),

/***/ 426:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("span", [_vm._v(_vm._s(_vm.display))])
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-3e30099a", esExports)
  }
}

/***/ }),

/***/ 43:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_attendance_records_vue__ = __webpack_require__(281);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6af5a278_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_attendance_records_vue__ = __webpack_require__(444);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_attendance_records_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6af5a278_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_attendance_records_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/attendance/attendance-records.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6af5a278", Component.options)
  } else {
    hotAPI.reload("data-v-6af5a278", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 444:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "hrm-attendance" },
    [
      _c("hrm-attendance-header"),
      _vm._v(" "),
      _c("hrm-attendace-punch-in-out-btn"),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "metabox-holder hrm-attendance-records-wrap" },
        [
          _vm._m(0),
          _vm._v(" "),
          _c("hrm-attendace-user-search"),
          _vm._v(" "),
          _c("table", { staticClass: "wp-list-table widefat fixed striped" }, [
            _vm._m(1),
            _vm._v(" "),
            _c(
              "tbody",
              [
                _vm._l(_vm.attendace_records, function(attendace) {
                  return _c("tr", [
                    _c("td", [_vm._v(_vm._s(attendace.date))]),
                    _vm._v(" "),
                    _c("td", [_vm._v(_vm._s(attendace.punch_in))]),
                    _vm._v(" "),
                    _c("td", {
                      domProps: { innerHTML: _vm._s(attendace.punch_out) }
                    }),
                    _vm._v(" "),
                    _c("td", {
                      domProps: { innerHTML: _vm._s(attendace.total) }
                    })
                  ])
                }),
                _vm._v(" "),
                _vm.attendace_records.length
                  ? _c("tr", [
                      _vm._m(2),
                      _vm._v(" "),
                      _c("td", [_vm._v("– –")]),
                      _vm._v(" "),
                      _c("td", [_vm._v("– –")]),
                      _vm._v(" "),
                      _c("td", [
                        _c("strong", [_vm._v(_vm._s(_vm.totalOfficeTime))])
                      ])
                    ])
                  : _vm._e(),
                _vm._v(" "),
                !_vm.attendace_records.length
                  ? _c("tr", [
                      _c("td", { attrs: { colspan: "4" } }, [
                        _vm._v("No record found!")
                      ])
                    ])
                  : _vm._e()
              ],
              2
            )
          ])
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "hrm-records-text" }, [
      _c("div", { staticClass: "hrm-attendance-records-text-wrap" }, [
        _c("h2", [_vm._v("Attendace Records")])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "hrm-clear" })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("Date")]),
        _vm._v(" "),
        _c("th", [_vm._v("In Time")]),
        _vm._v(" "),
        _c("th", [_vm._v("Out Time")]),
        _vm._v(" "),
        _c("th", [_vm._v("Duration")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("td", [_c("strong", [_vm._v("Total Duration")])])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-6af5a278", esExports)
  }
}

/***/ })

});