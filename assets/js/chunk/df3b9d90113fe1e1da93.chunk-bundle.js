wpSpearHrm([25],{

/***/ 145:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__router__ = __webpack_require__(38);
//
//
//
//
//
//
//
//
//
//
//
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

/***/ 272:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_attendance_header_vue__ = __webpack_require__(145);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1eeeb27b_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_attendance_header_vue__ = __webpack_require__(273);
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

/***/ 273:
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
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__attendance_header_vue__ = __webpack_require__(272);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
		return {};
	},

	components: {
		'hrm-attendance-header': __WEBPACK_IMPORTED_MODULE_0__attendance_header_vue__["a" /* default */]
	},

	computed: {
		office_start_with_date_time: function () {
			return this.$store.state.attendance.office_start_with_date_time;
		},

		office_closed_with_date_time: function () {
			return this.$store.state.attendance.office_closed_with_date_time;
		},
		hrm_is_multi_attendance: {
			get: function () {
				return this.$store.state.attendance.hrm_is_multi_attendance;
			},

			set: function (val) {
				this.$store.commit('attendance/setMultiAttendance', val);
			}
		},

		allow_ip: {
			get: function () {
				return this.$store.state.attendance.allow_ip;
			},

			set: function (val) {
				this.$store.commit('attendance/setAllowIP', val);
			}
		}
	},

	created: function () {

		this.attendanceInit();
		this.$on('hrm_date_picker', this.setDateTime);
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
		setDateTime: function (date_time) {

			if (date_time.field == 'datetimepicker_from') {
				//this.office_start = date_time.date_time;
				this.$store.commit('attendance/office_start', date_time);
			}

			if (date_time.field == 'datetimepicker_to') {
				//this.office_closed = date_time.date_time;
				this.$store.commit('attendance/office_closed', date_time);
			}
		},
		saveConfiguration: function () {
			var request_data = {
				_wpnonce: HRM_Vars.nonce,
				hrm_is_multi_attendance: this.hrm_is_multi_attendance,
				office_start: this.$store.state.attendance.office_start_with_date_time,
				office_closed: this.$store.state.attendance.office_closed_with_date_time,
				allow_ip: this.$store.state.attendance.allow_ip

			},
			    self = this;

			this.punch_in = 'disable';

			wp.ajax.send('attendance_configuration', {
				data: request_data,
				success: function (res) {
					// Display a success toast, with a title
					hrm.Toastr.success(res.success);

					self.$store.commit('attendance/setAttendance', { records: res.attendance });
				},

				error: function (res) {
					// Showing error
					res.error.map(function (value, index) {
						hrm.Toastr.error(value);
					});
				}
			});
		}
	}
});

/***/ }),

/***/ 40:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_attendance_configuration_vue__ = __webpack_require__(277);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_8b029810_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_attendance_configuration_vue__ = __webpack_require__(454);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_attendance_configuration_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_8b029810_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_attendance_configuration_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/attendance/attendance-configuration.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-8b029810", Component.options)
  } else {
    hotAPI.reload("data-v-8b029810", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 454:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "hrm-attendance hrm-attendance-configuration" },
    [
      _c("hrm-attendance-header"),
      _vm._v(" "),
      _c("div", { staticClass: "metabox-holder hrm-punch-in-out-wrap" }, [
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
                _c("div", { staticClass: "hrm-form-field " }, [
                  _vm._m(1),
                  _vm._v(" "),
                  _c("span", { staticClass: "hrm-checkbox-wrap" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.hrm_is_multi_attendance,
                          expression: "hrm_is_multi_attendance"
                        }
                      ],
                      attrs: {
                        type: "checkbox",
                        value: "yes",
                        id: "hrm-multi-attendance-checkbox"
                      },
                      domProps: {
                        checked: Array.isArray(_vm.hrm_is_multi_attendance)
                          ? _vm._i(_vm.hrm_is_multi_attendance, "yes") > -1
                          : _vm.hrm_is_multi_attendance
                      },
                      on: {
                        change: function($event) {
                          var $$a = _vm.hrm_is_multi_attendance,
                            $$el = $event.target,
                            $$c = $$el.checked ? true : false
                          if (Array.isArray($$a)) {
                            var $$v = "yes",
                              $$i = _vm._i($$a, $$v)
                            if ($$el.checked) {
                              $$i < 0 &&
                                (_vm.hrm_is_multi_attendance = $$a.concat([
                                  $$v
                                ]))
                            } else {
                              $$i > -1 &&
                                (_vm.hrm_is_multi_attendance = $$a
                                  .slice(0, $$i)
                                  .concat($$a.slice($$i + 1)))
                            }
                          } else {
                            _vm.hrm_is_multi_attendance = $$c
                          }
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c(
                      "label",
                      {
                        staticClass: "hrm-radio",
                        attrs: { for: "hrm-multi-attendance-checkbox" }
                      },
                      [_vm._v("Enable")]
                    )
                  ]),
                  _vm._v(" "),
                  _c("span", { staticClass: "hrm-clear" }),
                  _vm._v(" "),
                  _c("span", { staticClass: "description" }, [
                    _vm._v("Enable multiple attendance for per day")
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "hrm-form-field " }, [
                  _vm._m(2),
                  _vm._v(" "),
                  _c("input", {
                    staticClass: "hrm-date-time-picker-from",
                    attrs: { type: "text", id: "hrm-office-start-date-field" },
                    domProps: { value: _vm.office_start_with_date_time }
                  }),
                  _vm._v(" "),
                  _c("span", { staticClass: "hrm-clear" }),
                  _vm._v(" "),
                  _c("span", { staticClass: "description" }, [
                    _vm._v("Format: 2018-03-08 06:00 pm")
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "hrm-form-field " }, [
                  _vm._m(3),
                  _vm._v(" "),
                  _c("input", {
                    staticClass: "hrm-date-time-picker-to",
                    attrs: { type: "text", id: "hrm-office-closed-date-field" },
                    domProps: { value: _vm.office_closed_with_date_time }
                  }),
                  _vm._v(" "),
                  _c("span", { staticClass: "hrm-clear" }),
                  _vm._v(" "),
                  _c("span", { staticClass: "description" }, [
                    _vm._v("Format: 2018-03-08 06:00 pm")
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "hrm-form-field " }, [
                  _vm._m(4),
                  _vm._v(" "),
                  _c("textarea", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.allow_ip,
                        expression: "allow_ip"
                      }
                    ],
                    attrs: {
                      type: "textarea",
                      value: "",
                      placeholder: 'IP seperated by pipe "|"'
                    },
                    domProps: { value: _vm.allow_ip },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.allow_ip = $event.target.value
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("span", { staticClass: "hrm-clear" }),
                  _vm._v(" "),
                  _c("span", { staticClass: "description" }, [
                    _vm._v("Employee can puch in/out only from this IP")
                  ])
                ]),
                _vm._v(" "),
                _c("input", {
                  staticClass: "button hrm-button-primary  button-primary",
                  attrs: {
                    type: "submit",
                    name: "requst",
                    value: "Save changes"
                  },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      _vm.saveConfiguration()
                    }
                  }
                })
              ]
            )
          ])
        ])
      ])
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("h2", { staticClass: "hndle ui-sortable-handle" }, [
      _c("span", [_vm._v("Attendance Configuration")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: "" } }, [
      _vm._v("\n\t\t\t\t\t\t\tEnabale multiple attendance\n\t\t\t\t\t\t\t"),
      _c("em")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: "hrm-office-start-date-field" } }, [
      _vm._v("\n\t\t\t\t\t\t\tOffice start time\n\t\t\t\t\t\t\t"),
      _c("em")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: "hrm-office-closed-date-field" } }, [
      _vm._v("\n\t\t\t\t\t\t\tOffice closing time\n\t\t\t\t\t\t\t"),
      _c("em")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: " " } }, [
      _vm._v("\n\t\t\t\t\t\t\tAllow IP\n\t\t\t\t\t\t\t"),
      _c("em")
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-8b029810", esExports)
  }
}

/***/ })

});