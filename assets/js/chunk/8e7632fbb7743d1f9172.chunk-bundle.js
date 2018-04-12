wpSpearHrm([5],{

/***/ 206:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__router__ = __webpack_require__(53);
//
//
//
//
//
//
//
//
//
//
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

/***/ 207:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_header_vue__ = __webpack_require__(206);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0385a22a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_header_vue__ = __webpack_require__(208);
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

/***/ 208:
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

/***/ 357:
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
	data() {
		return {
			canSubmit: true
		};
	},
	methods: {
		validation(data) {
			var isFormValidate = true;

			if (!data.name) {
				hrm.Toastr.error('Holiday title is required!');
				isFormValidate = false;
			}

			return isFormValidate;
		},
		updateSelfHoliday() {
			if (!this.canSubmit) {
				return false;
			}
			var self = this;
			var args = {
				data: {
					id: this.holiday.id,
					name: this.holiday.name,
					description: this.holiday.description
				},
				callback: function () {
					self.canSubmit = true;
				}
			};

			if (!this.validation(args.data)) {
				return false;
			}
			this.canSubmit = false;
			this.updateHoliday(args);
		}
	}
});

/***/ }),

/***/ 362:
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

/* harmony default export */ __webpack_exports__["a"] = ({
	mixins: [HRMMixin.leave],

	methods: {
		showHideNewHolidayForm: function () {
			this.$store.commit('leave/isNewHolidayFormVisible', { is_visible: true });
		}
	}
});

/***/ }),

/***/ 363:
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
			records: [],
			canSubmit: true
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
				self.$store.commit('leave/isNewHolidayFormVisible', { is_visible: false });
			});
		},

		validation(data) {
			var isFormValidate = true;

			if (!data.name) {
				hrm.Toastr.error('Holiday title is required!');
				isFormValidate = false;
			}
			if (!data.from) {
				hrm.Toastr.error('Holiday start date is required!');
				isFormValidate = false;
			}
			if (!data.to) {
				hrm.Toastr.error('Holiday end date is required!');
				isFormValidate = false;
			}

			return isFormValidate;
		},

		createNewHolidays: function () {

			if (!this.canSubmit) {
				return false;
			}

			var request_data = {
				_wpnonce: HRM_Vars.nonce,
				name: this.name,
				from: this.from,
				to: this.to,
				description: this.description
			},
			    self = this;

			if (!this.validation(request_data)) {
				return false;
			}

			this.show_spinner = true;

			wp.ajax.send('create_new_holidays', {
				data: request_data,

				beforeSend() {
					self.loadingStart('hrm-holiday-form', { animationClass: 'preloader-update-animation' });
				},

				success: function (res) {
					self.show_spinner = false;

					self.addHolidayMeta(res.holiday);

					self.$store.commit('leave/updateHolidays', res.holiday);

					// Display a success toast, with a title
					hrm.Toastr.success(res.success);
					self.loadingStop('hrm-holiday-form');

					jQuery('#hrm-holiday-form').slideUp(400, function () {
						self.$store.commit('leave/isNewHolidayFormVisible', { is_visible: false });
					});
				},

				error: function (res) {
					self.show_spinner = false;
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

/***/ 364:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__holiday_edit_form_vue__ = __webpack_require__(446);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
				beforeSend() {
					self.loadingStart('hrm-holiday-table');
				},
				success: function (res) {
					res.holidays.forEach(function (holiday) {
						self.addHolidayMeta(holiday);
					});
					self.loadingStop('hrm-holiday-table');
					self.$store.commit('leave/setHoliday', res.holidays);
					self.isFetchRecord = true;
				},

				error: function (res) {}
			});
		}
	}
});

/***/ }),

/***/ 365:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__leave_holidays_form_vue__ = __webpack_require__(448);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__leave_holidays_record_vue__ = __webpack_require__(449);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__leave_holidays_add_btn_vue__ = __webpack_require__(447);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__leave_header_vue__ = __webpack_require__(207);
//
//
//
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
		'leave-holidays-add-btn': __WEBPACK_IMPORTED_MODULE_2__leave_holidays_add_btn_vue__["a" /* default */],
		'leave-header': __WEBPACK_IMPORTED_MODULE_3__leave_header_vue__["a" /* default */]
	},

	computed: {
		is_new_holiday_form_visible: function () {
			return this.$store.state.leave.is_new_holiday_form_visible;
		}
	}
};

/* harmony default export */ __webpack_exports__["a"] = (Hrm_Leave_Holidays);

/***/ }),

/***/ 407:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "\n.hrm-input-width {\n\twidth: 50% !important;\n}\n.hrm-multiselect .multiselect {\n\twidth: 50% !important;\n}\n.hrm-field-wrap {\n\tdisplay: block;\n\twidth: 100%;\n}\n.hrm-inline-edit-label, .hrm-inline-edit-field {\n\tfloat: left;\n}\n.hrm-inline-edit-label {\n\twidth: 15%;\n}\n.hrm-inline-edit-field {\n\twidth: 60%;\n}\n.hrm-field-wrap .title {\n\twidth: 100% !important;\n}\n.hrm-field-wrap:after {\n\tvisibility: hidden;\n\tdisplay: block;\n\tfont-size: 0;\n\tcontent: \" \";\n\tclear: both;\n\theight: 0;\n}\n", ""]);

// exports


/***/ }),

/***/ 446:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_holiday_edit_form_vue__ = __webpack_require__(357);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_112aa0cc_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_holiday_edit_form_vue__ = __webpack_require__(473);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(534)
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_112aa0cc_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_holiday_edit_form_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/holiday-edit-form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-112aa0cc", Component.options)
  } else {
    hotAPI.reload("data-v-112aa0cc", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 447:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_add_btn_vue__ = __webpack_require__(362);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_cb710a48_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_add_btn_vue__ = __webpack_require__(528);
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_cb710a48_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_add_btn_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-holidays-add-btn.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-cb710a48", Component.options)
  } else {
    hotAPI.reload("data-v-cb710a48", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 448:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_form_vue__ = __webpack_require__(363);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_cf736e70_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_form_vue__ = __webpack_require__(529);
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_cf736e70_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_form_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-holidays-form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-cf736e70", Component.options)
  } else {
    hotAPI.reload("data-v-cf736e70", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 449:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_record_vue__ = __webpack_require__(364);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0f22eed5_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_record_vue__ = __webpack_require__(472);
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0f22eed5_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_record_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-holidays-record.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0f22eed5", Component.options)
  } else {
    hotAPI.reload("data-v-0f22eed5", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 472:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c(
      "div",
      {
        staticClass: "metabox-holder hrm-leave-type-records-wrap",
        attrs: { id: "hrm-holiday-table" }
      },
      [
        _vm.isFetchRecord
          ? _c(
              "table",
              { staticClass: "wp-list-table widefat fixed striped" },
              [
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
                          ? _c("td", [
                              _vm._v(_vm._s(_vm.dateFormat(record.from)))
                            ])
                          : _vm._e(),
                        _vm._v(" "),
                        !record.editMode
                          ? _c("td", [
                              _vm._v(_vm._s(_vm.dateFormat(record.to)))
                            ])
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
                              [
                                _c("holiday-edit-form", {
                                  attrs: { holiday: record }
                                })
                              ],
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
              ]
            )
          : _vm._e()
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { staticClass: "manage-column column-cb" }, [_vm._v("Name")]),
        _vm._v(" "),
        _c("th", [_vm._v("Start")]),
        _vm._v(" "),
        _c("th", [_vm._v("End")]),
        _vm._v(" "),
        _c("th", [_vm._v("Description")])
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
    require("vue-hot-reload-api")      .rerender("data-v-0f22eed5", esExports)
  }
}

/***/ }),

/***/ 473:
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
        attrs: { id: "hrm-edit-" + _vm.holiday.id },
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
            attrs: { disabled: !_vm.canSubmit, type: "submit", value: "submit" }
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
      _c("span", { staticClass: "title" }, [
        _vm._v("Name "),
        _c("em", [_vm._v("*")])
      ])
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
    require("vue-hot-reload-api")      .rerender("data-v-112aa0cc", esExports)
  }
}

/***/ }),

/***/ 482:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("leave-holidays-add-btn"),
      _vm._v(" "),
      _c("leave-header"),
      _vm._v(" "),
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
    require("vue-hot-reload-api")      .rerender("data-v-2da03ef9", esExports)
  }
}

/***/ }),

/***/ 528:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("h1", { staticClass: "wp-heading-inline" }, [_vm._v("Holiday")]),
    _vm._v(" "),
    _c(
      "a",
      {
        staticClass: "page-title-action hrm-btn",
        attrs: { href: "#" },
        on: {
          click: function($event) {
            $event.preventDefault()
            _vm.showHideNewHolidayForm()
          }
        }
      },
      [_vm._v("\n\t\tAdd New\n\t")]
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
    require("vue-hot-reload-api")      .rerender("data-v-cb710a48", esExports)
  }
}

/***/ }),

/***/ 529:
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
                attrs: { action: "", id: "hrm-holiday-form" },
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
                  _c(
                    "label",
                    { attrs: { for: "hrm-leave-description-textarea-field" } },
                    [_vm._v("\n\t\t\t\t\t\t\tDescription\n\t\t\t\t\t\t")]
                  ),
                  _vm._v(" "),
                  _c("textarea", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.description,
                        expression: "description"
                      }
                    ],
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
                  staticClass: "button button-primary  hrm-button-primary",
                  attrs: {
                    disabled: !_vm.canSubmit,
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
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-cf736e70", esExports)
  }
}

/***/ }),

/***/ 534:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(407);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(2)("ef9a332e", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-112aa0cc\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./holiday-edit-form.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-112aa0cc\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./holiday-edit-form.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 70:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_vue__ = __webpack_require__(365);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_2da03ef9_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_vue__ = __webpack_require__(482);
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_2da03ef9_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-holidays.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-2da03ef9", Component.options)
  } else {
    hotAPI.reload("data-v-2da03ef9", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ })

});