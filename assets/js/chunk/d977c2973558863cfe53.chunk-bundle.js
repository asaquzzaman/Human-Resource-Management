wpSpearHrm([5],{

/***/ 209:
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


/* harmony default export */ __webpack_exports__["a"] = ({
  props: ['holiday'],
  mixins: [HRMMixin.leave],
  methods: {
    updateSelfHoliday() {
      var args = {
        data: {
          id: this.holiday.id,
          name: this.holiday.name,
          description: this.holiday.description
        },
        callback: function () {}
      };
      this.updateHoliday(args);
    }
  }
});

/***/ }),

/***/ 214:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["a"] = ({
	mixins: [HRMMixin.leave],

	methods: {
		showHideNewLeaveTypeForm: function () {
			this.$store.commit('leave/isNewHolidayFormVisible', { is_visible: true });
		}
	}
});

/***/ }),

/***/ 215:
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


/* harmony default export */ __webpack_exports__["a"] = ({

  mixins: [HRMMixin.leave],

  data: function () {
    return {
      financial_start: HRM_Vars.financial_start,
      financial_end: HRM_Vars.financial_end,
      name: '',
      from: '',
      to: '',
      description: '',
      records: []
    };
  },

  created: function () {
    this.$on('hrm_date_picker', this.setDateTime);
  },
  methods: {
    setDateTime: function (date) {
      if (date.field == 'datepicker_from') {
        this.from = date.date;
      }

      if (date.field == 'datepicker_to') {
        this.to = date.date;
      }
    },
    show_hide_new_leave_type_form: function (el) {
      var self = this;

      this.slideUp(el.target, function () {
        self.$store.commit('leave/isNewLeaveTypeFormVisible', { is_visible: false });
      });
    },

    createNewHolidays: function () {

      var request_data = {
        _wpnonce: HRM_Vars.nonce,
        name: this.name,
        from: this.from,
        to: this.to,
        description: this.description
      },


      // is_update  = parseInt( this.department_id ) ? true : false,

      // target_index = is_update ? this.getIndex(
      //     this.$store.state.leave.departments, this.department_id, 'id'
      // ) : false,

      self = this;

      this.show_spinner = true;

      wp.ajax.send('create_new_holidays', {
        data: request_data,

        success: function (res) {
          self.show_spinner = false;

          self.addHolidayMeta(res.holiday);

          self.$store.commit('leave/updateHolidays', res.holiday);

          // Display a success toast, with a title
          toastr.success(res.success);

          self.slideUp(jQuery('.hrm-form-cancel'), function () {
            self.$store.commit('leave/isNewHolidayFormVisible', { is_visible: false });
          });
        },

        error: function (res) {
          self.show_spinner = false;
          // Showing error
          res.error.map(function (value, index) {
            toastr.error(value);
          });
        }
      });
    }
  }
});

/***/ }),

/***/ 216:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__holiday_edit_form_vue__ = __webpack_require__(256);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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

	data: function () {
		return {};
	},

	components: {
		'holiday-edit-form': __WEBPACK_IMPORTED_MODULE_0__holiday_edit_form_vue__["a" /* default */]
	},

	computed: {
		records() {
			return this.$store.state.leave.holidays;
		}
	},

	created: function () {
		this.getHolidays();
	},
	methods: {
		selfDeleteHoliday(holiday) {
			let formData = {
				id: holiday.id,
				callback() {}
			};

			this.deleteHoliday(formData);
		},
		getHolidays: function () {
			var request_data = {
				_wpnonce: HRM_Vars.nonce
			},
			    self = this;

			wp.ajax.send('get_holidays', {
				data: request_data,
				success: function (res) {
					res.holidays.forEach(function (holiday) {
						self.addHolidayMeta(holiday);
					});

					self.$store.commit('leave/setHoliday', res.holidays);
				},

				error: function (res) {}
			});
		}
	}
});

/***/ }),

/***/ 217:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__leave_holidays_form_vue__ = __webpack_require__(258);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__leave_holidays_record_vue__ = __webpack_require__(259);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__leave_holidays_add_btn_vue__ = __webpack_require__(257);
//
//
//
//
//
//
//
//
//
//
//






var Hrm_Leave_Holidays = {

	mixins: [HRMMixin.leave],

	//store: HRM_Leave_Store,

	data: function () {
		return {};
	},

	components: {
		'leave-holidays-form': __WEBPACK_IMPORTED_MODULE_0__leave_holidays_form_vue__["a" /* default */],
		'leave-holidays-record': __WEBPACK_IMPORTED_MODULE_1__leave_holidays_record_vue__["a" /* default */],
		'leave-holidays-add-btn': __WEBPACK_IMPORTED_MODULE_2__leave_holidays_add_btn_vue__["a" /* default */]
	},

	computed: {
		is_new_holiday_form_visible: function () {
			return this.$store.state.leave.is_new_holiday_form_visible;
		}
	}
};

/* harmony default export */ __webpack_exports__["a"] = (Hrm_Leave_Holidays);

/***/ }),

/***/ 246:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(62)(false);
// imports


// module
exports.push([module.i, "\n.hrm-input-width {\n\twidth: 50% !important;\n}\n.hrm-multiselect .multiselect {\n\twidth: 50% !important;\n}\n.hrm-field-wrap {\n\tdisplay: block;\n\twidth: 100%;\n}\n.hrm-inline-edit-label, .hrm-inline-edit-field {\n\tfloat: left;\n}\n.hrm-inline-edit-label {\n\twidth: 15%;\n}\n.hrm-inline-edit-field {\n\twidth: 60%;\n}\n.hrm-field-wrap .title {\n\twidth: 100% !important;\n}\n.hrm-field-wrap:after {\n\tvisibility: hidden;\n\tdisplay: block;\n\tfont-size: 0;\n\tcontent: \" \";\n\tclear: both;\n\theight: 0;\n}\n", ""]);

// exports


/***/ }),

/***/ 256:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_holiday_edit_form_vue__ = __webpack_require__(209);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_fc843a98_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_holiday_edit_form_vue__ = __webpack_require__(303);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(315)
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_holiday_edit_form_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_fc843a98_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_holiday_edit_form_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/leave/holiday-edit-form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-fc843a98", Component.options)
  } else {
    hotAPI.reload("data-v-fc843a98", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 257:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_add_btn_vue__ = __webpack_require__(214);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_814baffc_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_add_btn_vue__ = __webpack_require__(289);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_add_btn_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_814baffc_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_add_btn_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/leave/leave-holidays-add-btn.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-814baffc", Component.options)
  } else {
    hotAPI.reload("data-v-814baffc", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 258:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_form_vue__ = __webpack_require__(215);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4acdc53c_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_form_vue__ = __webpack_require__(278);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_form_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4acdc53c_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_form_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/leave/leave-holidays-form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4acdc53c", Component.options)
  } else {
    hotAPI.reload("data-v-4acdc53c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 259:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_record_vue__ = __webpack_require__(216);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_081304ef_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_record_vue__ = __webpack_require__(270);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_record_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_081304ef_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_record_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/leave/leave-holidays-record.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-081304ef", Component.options)
  } else {
    hotAPI.reload("data-v-081304ef", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 270:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("div", { staticClass: "metabox-holder hrm-leave-type-records-wrap" }, [
      _c("table", { staticClass: "wp-list-table widefat fixed striped" }, [
        _vm._m(0),
        _vm._v(" "),
        _c(
          "tbody",
          [
            _vm._l(_vm.records, function(record) {
              return _c("tr", { staticClass: "hrm-tr" }, [
                !record.editMode
                  ? _c("td", [
                      _vm._v(
                        "\n\t\t\t\t\t\t" +
                          _vm._s(record.name) +
                          "\n\t\t\t\t\t\t"
                      ),
                      _c("div", { staticClass: "row-actions" }, [
                        _c("span", { staticClass: "edit" }, [
                          _c(
                            "a",
                            {
                              attrs: {
                                href: "#",
                                "aria-label": "Edit “Hello world!”"
                              },
                              on: {
                                click: function($event) {
                                  $event.preventDefault()
                                  _vm.showHideHolidayUpdateForm(
                                    "toggle",
                                    record
                                  )
                                }
                              }
                            },
                            [
                              _vm._v(
                                "\n\t\t\t\t\t\t\t\t\tEdit\n\t\t\t\t\t\t\t\t"
                              )
                            ]
                          )
                        ]),
                        _vm._v("\n\t\t\t\t\t\t\t|\n\t\t\t\t\t\t\t"),
                        _c("span", { staticClass: "edit" }, [
                          _c(
                            "a",
                            {
                              attrs: {
                                href: "#",
                                "aria-label": "Edit “Hello world!”"
                              },
                              on: {
                                click: function($event) {
                                  $event.preventDefault()
                                  _vm.selfDeleteHoliday(record)
                                }
                              }
                            },
                            [
                              _vm._v(
                                "\n\t\t\t\t\t\t\t\t\tDelete\n\t\t\t\t\t\t\t\t"
                              )
                            ]
                          )
                        ])
                      ])
                    ])
                  : _vm._e(),
                _vm._v(" "),
                !record.editMode
                  ? _c("td", [_vm._v(_vm._s(_vm.dateFormat(record.from)))])
                  : _vm._e(),
                _vm._v(" "),
                !record.editMode
                  ? _c("td", [_vm._v(_vm._s(_vm.dateFormat(record.to)))])
                  : _vm._e(),
                _vm._v(" "),
                !record.editMode
                  ? _c("td", [_vm._v(_vm._s(record.description))])
                  : _vm._e(),
                _vm._v(" "),
                record.editMode
                  ? _c(
                      "td",
                      { attrs: { colspan: "4" } },
                      [_c("holiday-edit-form", { attrs: { holiday: record } })],
                      1
                    )
                  : _vm._e()
              ])
            }),
            _vm._v(" "),
            !_vm.records.length
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
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("th", [_vm._v("Name")]),
      _vm._v(" "),
      _c("th", [_vm._v("Start")]),
      _vm._v(" "),
      _c("th", [_vm._v("End")]),
      _vm._v(" "),
      _c("th", [_vm._v("Description")])
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-081304ef", esExports)
  }
}

/***/ }),

/***/ 278:
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
                attrs: { action: "" },
                on: {
                  submit: function($event) {
                    $event.preventDefault()
                    _vm.createNewHolidays()
                  }
                }
              },
              [
                _c("div", { staticClass: "hrm-form-field " }, [
                  _vm._m(1),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.name,
                        expression: "name"
                      }
                    ],
                    attrs: {
                      type: "text",
                      id: "hrm-leave-type-text-field",
                      required: "required",
                      name: "name"
                    },
                    domProps: { value: _vm.name },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.name = $event.target.value
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("span", { staticClass: "hrm-clear" }),
                  _vm._v(" "),
                  _c("span", { staticClass: "description" })
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "hrm-form-field " }, [
                  _vm._m(2),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      { name: "hrm-datepicker", rawName: "v-hrm-datepicker" }
                    ],
                    staticClass: "hrm-date-picker-from",
                    attrs: {
                      type: "text",
                      id: "hrm-leave-holidays-from-text-field",
                      required: "required",
                      name: "from"
                    },
                    domProps: { value: _vm.from }
                  }),
                  _vm._v(" "),
                  _c("span", { staticClass: "hrm-clear" }),
                  _vm._v(" "),
                  _c("span", { staticClass: "description" })
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "hrm-form-field " }, [
                  _vm._m(3),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      { name: "hrm-datepicker", rawName: "v-hrm-datepicker" }
                    ],
                    staticClass: "hrm-date-picker-to",
                    attrs: {
                      type: "text",
                      id: "hrm-leave-holidays-to-text-field",
                      required: "required",
                      name: "to"
                    },
                    domProps: { value: _vm.to }
                  }),
                  _vm._v(" "),
                  _c("span", { staticClass: "hrm-clear" }),
                  _vm._v(" "),
                  _c("span", { staticClass: "description" })
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "hrm-form-field" }, [
                  _c(
                    "label",
                    { attrs: { for: "hrm-leave-entitlement-text-field" } },
                    [_vm._v("Validaty")]
                  ),
                  _vm._v(" "),
                  _c("div", [
                    _vm._v("From "),
                    _c("strong", [
                      _vm._v(_vm._s(_vm.dateFormat(_vm.financial_start)))
                    ]),
                    _vm._v(" to "),
                    _c("strong", [
                      _vm._v(_vm._s(_vm.dateFormat(_vm.financial_end)))
                    ])
                  ]),
                  _vm._v(" "),
                  _c("span", { staticClass: "hrm-clear" }),
                  _vm._v(" "),
                  _c("span", { staticClass: "description" })
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "hrm-form-field " }, [
                  _vm._m(4),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.description,
                        expression: "description"
                      }
                    ],
                    attrs: {
                      type: "text",
                      id: "hrm-leave-description-textarea-field",
                      required: "required",
                      name: "description"
                    },
                    domProps: { value: _vm.description },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.description = $event.target.value
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("span", { staticClass: "hrm-clear" }),
                  _vm._v(" "),
                  _c("span", { staticClass: "description" })
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
                        _vm.show_hide_new_leave_type_form($event)
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
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("h2", { staticClass: "hndle ui-sortable-handle" }, [
      _c("span", [_vm._v("Holidays")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: "hrm-leave-type-text-field" } }, [
      _vm._v("\n\t\t\t\t\t\t\tName"),
      _c("em", [_vm._v("  *")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      { attrs: { for: "hrm-leave-holidays-from-text-field" } },
      [_vm._v("\n\t\t\t\t\t\t\tFrom "), _c("em", [_vm._v("  *")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: "hrm-leave-holidays-to-text-field" } }, [
      _vm._v("\n\t\t\t\t\t\t\tTo"),
      _c("em", [_vm._v("  *")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      { attrs: { for: "hrm-leave-description-textarea-field" } },
      [_vm._v("\n\t\t\t\t\t\t\tDescription"), _c("em", [_vm._v("  *")])]
    )
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-4acdc53c", esExports)
  }
}

/***/ }),

/***/ 283:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _vm.is_new_holiday_form_visible
        ? _c(
            "div",
            {
              directives: [
                { name: "hrm-slide-down", rawName: "v-hrm-slide-down" }
              ],
              staticClass: "hrm-slide-up",
              staticStyle: { display: "none" }
            },
            [_c("leave-holidays-form")],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _c("leave-holidays-add-btn"),
      _vm._v(" "),
      _c("leave-holidays-record")
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
    require("vue-hot-reload-api")      .rerender("data-v-69251bc2", esExports)
  }
}

/***/ }),

/***/ 289:
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
            _vm.showHideNewLeaveTypeForm()
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
    require("vue-hot-reload-api")      .rerender("data-v-814baffc", esExports)
  }
}

/***/ }),

/***/ 29:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_vue__ = __webpack_require__(217);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_69251bc2_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_vue__ = __webpack_require__(283);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_69251bc2_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/leave/leave-holidays.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-69251bc2", Component.options)
  } else {
    hotAPI.reload("data-v-69251bc2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 303:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "hrm-td-editble-wrap inline-edit-row" }, [
    _c(
      "form",
      {
        on: {
          submit: function($event) {
            $event.preventDefault()
            _vm.updateSelfHoliday()
          }
        }
      },
      [
        _c("fieldset", { staticClass: "hrm-inline-edit-col-left" }, [
          _c("legend", { staticClass: "inline-edit-legend" }, [
            _vm._v("Quick Edit")
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "hrm-field-wrap" }, [
            _vm._m(0),
            _vm._v(" "),
            _c("div", { staticClass: "hrm-inline-edit-field" }, [
              _c("span", { staticClass: "input-text-wrap" }, [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.holiday.name,
                      expression: "holiday.name"
                    }
                  ],
                  staticClass: "ptitle hrm-input-width",
                  attrs: { type: "text", name: "post_title", value: "" },
                  domProps: { value: _vm.holiday.name },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.holiday, "name", $event.target.value)
                    }
                  }
                })
              ])
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "hrm-field-wrap" }, [
            _vm._m(1),
            _vm._v(" "),
            _c("div", { staticClass: "hrm-inline-edit-field" }, [
              _c("span", { staticClass: "input-text-wrap" }, [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.holiday.description,
                      expression: "holiday.description"
                    }
                  ],
                  staticClass: "ptitle hrm-input-width",
                  attrs: { type: "text", name: "post_title", value: "" },
                  domProps: { value: _vm.holiday.description },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.holiday, "description", $event.target.value)
                    }
                  }
                })
              ])
            ])
          ])
        ]),
        _vm._v(" "),
        _c("p", { staticClass: "submit inline-edit-save" }, [
          _c(
            "button",
            {
              staticClass: "button cancel alignleft",
              attrs: { type: "button" },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  _vm.showHideHolidayUpdateForm("toggle", _vm.holiday)
                }
              }
            },
            [_vm._v("Cancel")]
          ),
          _vm._v(" "),
          _c("input", {
            staticClass: "button button-primary save alignright",
            attrs: { type: "submit", value: "submit" }
          }),
          _vm._v(" "),
          _c("br", { staticClass: "clear" })
        ])
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "hrm-inline-edit-label" }, [
      _c("span", { staticClass: "title" }, [_vm._v("Name")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "hrm-inline-edit-label" }, [
      _c("span", { staticClass: "title" }, [_vm._v("Description")])
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-fc843a98", esExports)
  }
}

/***/ }),

/***/ 315:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(246);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(63)("01d2231e", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-fc843a98\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./holiday-edit-form.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-fc843a98\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./holiday-edit-form.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 62:
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

/***/ 63:
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

var listToStyles = __webpack_require__(64)

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

/***/ 64:
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


/***/ })

});