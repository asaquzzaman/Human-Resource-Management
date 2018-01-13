wpSpearHrm([4],{

/***/ 100:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
throw new Error("Cannot find module \"./../../vue-multiselect/vue-multiselect.min\"");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
	props: ['leaveType'],

	mixins: [HRMMixin.leave],

	data() {
		return {
			//departments: []
		};
	},

	computed: {
		departmentDropDown() {
			return this.$store.state.leave.departmentDropDown;
		}
	},

	components: {
		'hrm-multiselect': __WEBPACK_IMPORTED_MODULE_0__vue_multiselect_vue_multiselect_min___default.a
	},

	methods: {
		updateSelfLeaveType() {
			var args = {
				data: {
					id: this.leaveType.id,
					leave_type: this.leaveType.name,
					nextYear: this.leaveType.next_year,
					departments: this.leaveType.departments
				},
				callback: function () {}
			};
			this.updateLeaveType(args);
		}
	}
});

/***/ }),

/***/ 101:
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


var Hrm_Leave_Type_Form = {

	mixins: [HRMMixin.leave],

	data: function () {
		return {
			entitle_from: '',
			entitle_to: '',
			leave_type: '',
			entitlement: '',
			nextYear: false,
			financial_start: HRM_Vars.financial_start,
			financial_end: HRM_Vars.financial_end,
			departments: []
		};
	},

	created: function () {
		//this.getDepartments();
		this.$on('hrm_date_picker', this.setDateTime);
	},

	computed: {
		departmentDropDown() {
			return this.$store.state.leave.departmentDropDown;
		}
	},

	components: {
		'hrm-multiselect': hrm.Multiselect
	},
	methods: {
		setDateTime: function (date) {
			if (date.field == 'datepicker_from') {
				this.entitle_from = date.date;
			}

			if (date.field == 'datepicker_to') {
				this.entitle_to = date.date;
			}
		},
		show_hide_new_leave_type_form: function (el) {
			var self = this;
			var node = jQuery(el.target).closest('.hrm-slide-up');

			node.slideUp(400, function () {
				self.$store.commit('leave/isNewLeaveTypeFormVisible', { is_visible: false });
			});
		},

		filterDepartmentName(department) {
			var pad = '&#8212; ';
			return pad.repeat(department.hierarchical_depth) + department.name;
		},

		createNewLeaveType: function () {

			var request_data = {
				_wpnonce: HRM_Vars.nonce,
				entitlement: this.entitlement,
				leave_type: this.leave_type,
				// entitle_from: this.entitle_from,
				// entitle_to: this.entitle_to,
				nextYear: this.nextYear,
				departments: this.departments
			},
			    self = this;

			this.show_spinner = true;

			wp.ajax.send('create_new_leave_type', {
				data: request_data,

				success: function (res) {
					self.show_spinner = false;

					self.addLeaveTypeMeta(res.leave_type.data);
					// Display a success toast, with a title
					toastr.success(res.success);

					self.show_hide_new_leave_type_form({ target: '.hrm-form-cancel' });

					// self.$store.commit('leave/updateDepartment', {
					//     is_update: is_update, 
					//     dept_id: self.department_id,
					//     target_index: target_index,
					//     departments: res.departments,
					//     dept_drop_down: res.dept_drop_down
					// });

					self.$store.commit('leave/setNewLeaveType', res.leave_type.data);
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
};

/* harmony default export */ __webpack_exports__["a"] = (Hrm_Leave_Type_Form);

/***/ }),

/***/ 102:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__leave_type_edit_form_vue__ = __webpack_require__(135);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



var Hrm_Leave_Type_Records = {

	mixins: [HRMMixin.leave],

	data: function () {
		return {};
	},

	computed: {
		records() {
			return this.$store.state.leave.leaveTypes;
		}
	},

	components: {
		'leave-type-edit-form': __WEBPACK_IMPORTED_MODULE_0__leave_type_edit_form_vue__["a" /* default */]
	},

	created: function () {
		this.getLeaveTypes();
	},
	methods: {
		getLeaveTypes: function () {
			var request_data = {
				_wpnonce: HRM_Vars.nonce
			},
			    self = this;

			wp.ajax.send('get_leave_type', {
				data: request_data,
				success: function (res) {
					res.data.forEach(function (type, index) {
						self.addLeaveTypeMeta(type);
					});

					self.$store.commit('leave/setLeaveTypes', res.data);
				},

				error: function (res) {}
			});
		},

		carryStatus(next_year) {
			return parseInt(next_year) ? 'Enable' : 'Disable';
		},
		showHideLeaveTypeEditForm(status, type) {},
		selfDeleteLeaveType(record) {
			var data = {
				id: record.id,
				callback: function () {}
			};

			this.deleteLeaveType(data);
		}
	}
};

/* harmony default export */ __webpack_exports__["a"] = (Hrm_Leave_Type_Records);

/***/ }),

/***/ 103:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__leave_type_form_vue__ = __webpack_require__(136);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__leave_type_records_vue__ = __webpack_require__(137);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__leave_type_add_btn_vue__ = __webpack_require__(134);
//
//
//
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

	components: {
		'leave-type-form': __WEBPACK_IMPORTED_MODULE_0__leave_type_form_vue__["a" /* default */],
		'leave-type-records': __WEBPACK_IMPORTED_MODULE_1__leave_type_records_vue__["a" /* default */],
		'leave-type-add-btn': __WEBPACK_IMPORTED_MODULE_2__leave_type_add_btn_vue__["a" /* default */]
	},

	computed: {
		is_new_leave_type_form_visible: function () {
			return this.$store.state.leave.is_new_leave_type_form_visible;
		}
	},

	created() {
		this.getSelfDepartments();
	},

	methods: {
		getSelfDepartments() {
			var self = this;
			var request_data = {
				data: {},
				success(res) {
					self.$store.commit('leave/setDepartment', res.dept_drop_down);
				}
			};
			this.httpRequest('get_departments', request_data);
		}
	}

});

/***/ }),

/***/ 107:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(25)(false);
// imports


// module
exports.push([module.i, "\n.hrm-input-width {\n\twidth: 50% !important;\n}\n.hrm-multiselect .multiselect {\n\twidth: 50% !important;\n}\n.hrm-field-wrap {\n\tdisplay: block;\n\twidth: 100%;\n}\n.hrm-inline-edit-label, .hrm-inline-edit-field {\n\tfloat: left;\n}\n.hrm-inline-edit-label {\n\twidth: 15%;\n}\n.hrm-inline-edit-field {\n\twidth: 60%;\n}\n.hrm-field-wrap .title {\n\twidth: 100% !important;\n}\n.hrm-field-wrap:after {\n\tvisibility: hidden;\n\tdisplay: block;\n\tfont-size: 0;\n\tcontent: \" \";\n\tclear: both;\n\theight: 0;\n}\n", ""]);

// exports


/***/ }),

/***/ 110:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(25)(false);
// imports


// module
exports.push([module.i, "\n.hrm-td-editble-wrap .inline-edit-legend {\n\tmargin: 0;\n    padding: 0.2em 0.5em 0;\n    line-height: 2.5;\n    font-weight: 600;\n}\n\n", ""]);

// exports


/***/ }),

/***/ 134:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_add_btn_vue__ = __webpack_require__(99);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_e88718be_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_add_btn_vue__ = __webpack_require__(165);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_add_btn_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_e88718be_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_add_btn_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/leave/leave-type-add-btn.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-e88718be", Component.options)
  } else {
    hotAPI.reload("data-v-e88718be", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 135:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_edit_form_vue__ = __webpack_require__(100);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_39259158_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_edit_form_vue__ = __webpack_require__(143);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(171)
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_edit_form_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_39259158_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_edit_form_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/leave/leave-type-edit-form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-39259158", Component.options)
  } else {
    hotAPI.reload("data-v-39259158", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 136:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_form_vue__ = __webpack_require__(101);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_85cee3ba_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_form_vue__ = __webpack_require__(157);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_form_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_85cee3ba_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_form_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/leave/leave-type-form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-85cee3ba", Component.options)
  } else {
    hotAPI.reload("data-v-85cee3ba", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 137:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_records_vue__ = __webpack_require__(102);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6b48f49a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_records_vue__ = __webpack_require__(152);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(174)
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_records_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6b48f49a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_records_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/leave/leave-type-records.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6b48f49a", Component.options)
  } else {
    hotAPI.reload("data-v-6b48f49a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 143:
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
            _vm.updateSelfLeaveType()
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
                      value: _vm.leaveType.name,
                      expression: "leaveType.name"
                    }
                  ],
                  staticClass: "ptitle hrm-input-width",
                  attrs: { type: "text", name: "post_title", value: "" },
                  domProps: { value: _vm.leaveType.name },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.leaveType, "name", $event.target.value)
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
                      value: _vm.leaveType.next_year,
                      expression: "leaveType.next_year"
                    }
                  ],
                  staticClass: "ptitle",
                  attrs: { type: "checkbox", name: "post_title", value: "" },
                  domProps: {
                    checked: Array.isArray(_vm.leaveType.next_year)
                      ? _vm._i(_vm.leaveType.next_year, "") > -1
                      : _vm.leaveType.next_year
                  },
                  on: {
                    change: function($event) {
                      var $$a = _vm.leaveType.next_year,
                        $$el = $event.target,
                        $$c = $$el.checked ? true : false
                      if (Array.isArray($$a)) {
                        var $$v = "",
                          $$i = _vm._i($$a, $$v)
                        if ($$el.checked) {
                          $$i < 0 &&
                            (_vm.leaveType.next_year = $$a.concat([$$v]))
                        } else {
                          $$i > -1 &&
                            (_vm.leaveType.next_year = $$a
                              .slice(0, $$i)
                              .concat($$a.slice($$i + 1)))
                        }
                      } else {
                        _vm.$set(_vm.leaveType, "next_year", $$c)
                      }
                    }
                  }
                }),
                _vm._v(" "),
                _c("span", { staticClass: "checkbox-title" }, [
                  _vm._v("Leave type carry to next financial year.")
                ])
              ])
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "hrm-field-wrap" }, [
            _vm._m(2),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "hrm-multiselect hrm-inline-edit-field" },
              [
                _c("hrm-multiselect", {
                  attrs: {
                    options: _vm.departmentDropDown,
                    multiple: true,
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
                  model: {
                    value: _vm.leaveType.departments.data,
                    callback: function($$v) {
                      _vm.$set(_vm.leaveType.departments, "data", $$v)
                    },
                    expression: "leaveType.departments.data"
                  }
                })
              ],
              1
            )
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
                  _vm.showHideLeaveTypeUpdateForm("toggle", _vm.leaveType)
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
      _c("span", { staticClass: "title" }, [_vm._v("Leave Type")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "hrm-inline-edit-label" }, [
      _c("span", { staticClass: "title" }, [_vm._v("Next Year")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "hrm-inline-edit-label" }, [
      _c("span", { staticClass: "title" }, [_vm._v("Departments")])
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-39259158", esExports)
  }
}

/***/ }),

/***/ 152:
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
              return _c(
                "tr",
                {
                  staticClass:
                    "hrm-tr inline-edit-row inline-edit-row-post inline-edit-post quick-edit-row quick-edit-row-post inline-edit-post inline-editor"
                },
                [
                  !record.editMode
                    ? _c("td", { staticClass: "hrm-td" }, [
                        _c("div", { staticClass: "hrm-td-content" }, [
                          _vm._v(
                            "\n\t\t\t\t\t\t\t" +
                              _vm._s(record.name) +
                              "\n\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t"
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
                                      _vm.showHideLeaveTypeUpdateForm(
                                        "toggle",
                                        record
                                      )
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n\t\t\t\t\t\t\t\t\t\tEdit\n\t\t\t\t\t\t\t\t\t"
                                  )
                                ]
                              )
                            ]),
                            _vm._v("\n\t\t\t\t\t\t\t\t|\n\t\t\t\t\t\t\t\t"),
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
                                      _vm.selfDeleteLeaveType(record)
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n\t\t\t\t\t\t\t\t\t\tDelete\n\t\t\t\t\t\t\t\t\t"
                                  )
                                ]
                              )
                            ])
                          ])
                        ])
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  !record.editMode
                    ? _c("td", { staticClass: "hrm-td" }, [
                        _vm._v(_vm._s(record.entitlement))
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  !record.editMode
                    ? _c("td", { staticClass: "hrm-td" }, [
                        record.next_year === 1
                          ? _c("span", [_vm._v("¯¯")])
                          : _c("span", [
                              _vm._v(
                                _vm._s(_vm.dateFormat(record.entitle_from))
                              )
                            ])
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  !record.editMode
                    ? _c("td", { staticClass: "hrm-td" }, [
                        record.next_year === 1
                          ? _c("span", [_vm._v("¯¯")])
                          : _c("span", [
                              _vm._v(_vm._s(_vm.dateFormat(record.entitle_to)))
                            ])
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  !record.editMode
                    ? _c("td", { staticClass: "hrm-td" }, [
                        _vm._v(_vm._s(_vm.carryStatus(record.next_year)))
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  record.editMode
                    ? _c(
                        "td",
                        { attrs: { colspan: "5" } },
                        [
                          _c("leave-type-edit-form", {
                            attrs: { leaveType: record }
                          })
                        ],
                        1
                      )
                    : _vm._e()
                ]
              )
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
      _c("th", [_vm._v("Leave Type")]),
      _vm._v(" "),
      _c("th", [_vm._v("Days")]),
      _vm._v(" "),
      _c("th", [_vm._v("Start")]),
      _vm._v(" "),
      _c("th", [_vm._v("End")]),
      _vm._v(" "),
      _c("th", [_vm._v("Carry to next year")])
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-6b48f49a", esExports)
  }
}

/***/ }),

/***/ 155:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _vm.is_new_leave_type_form_visible
        ? _c(
            "div",
            {
              directives: [
                { name: "hrm-slide-down", rawName: "v-hrm-slide-down" }
              ],
              staticClass: "hrm-slide-up",
              staticStyle: { display: "none" }
            },
            [_c("leave-type-form")],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _c("leave-type-add-btn"),
      _vm._v(" "),
      _c("leave-type-records")
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
    require("vue-hot-reload-api")      .rerender("data-v-7d48ccbe", esExports)
  }
}

/***/ }),

/***/ 157:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "metabox-holder hrm-slide-up hrm-punch-in-out-wrap" },
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
                  attrs: { action: "" },
                  on: {
                    submit: function($event) {
                      $event.preventDefault()
                      _vm.createNewLeaveType()
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
                          value: _vm.leave_type,
                          expression: "leave_type"
                        }
                      ],
                      attrs: {
                        type: "text",
                        id: "hrm-leave-type-text-field",
                        required: "required",
                        name: "leave_type"
                      },
                      domProps: { value: _vm.leave_type },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.leave_type = $event.target.value
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("span", { staticClass: "hrm-clear" }),
                    _vm._v(" "),
                    _c("span", { staticClass: "description" })
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "hrm-form-field hrm-leave-type-wrap" },
                    [
                      _vm._m(2),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "hrm-multiselect" },
                        [
                          _c("hrm-multiselect", {
                            attrs: {
                              options: _vm.departmentDropDown,
                              multiple: true,
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
                            model: {
                              value: _vm.departments,
                              callback: function($$v) {
                                _vm.departments = $$v
                              },
                              expression: "departments"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "hrm-clear" })
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "hrm-form-field " }, [
                    _vm._m(3),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.entitlement,
                          expression: "entitlement"
                        }
                      ],
                      attrs: {
                        type: "text",
                        id: "hrm-leave-entitlement-text-field",
                        required: "required",
                        name: "entitlement"
                      },
                      domProps: { value: _vm.entitlement },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.entitlement = $event.target.value
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("span", { staticClass: "hrm-clear" }),
                    _vm._v(" "),
                    _c("span", { staticClass: "description" })
                  ]),
                  _vm._v(" "),
                  !_vm.nextYear
                    ? _c("div", { staticClass: "hrm-form-field" }, [
                        _c(
                          "label",
                          {
                            attrs: { for: "hrm-leave-entitlement-text-field" }
                          },
                          [_vm._v("Duration")]
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
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _c("div", { staticClass: "hrm-form-field " }, [
                    _vm._m(4),
                    _vm._v(" "),
                    _c("span", { staticClass: "hrm-checkbox-wrap" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.nextYear,
                            expression: "nextYear"
                          }
                        ],
                        attrs: { type: "checkbox", id: "hrm-next-year" },
                        domProps: {
                          checked: Array.isArray(_vm.nextYear)
                            ? _vm._i(_vm.nextYear, null) > -1
                            : _vm.nextYear
                        },
                        on: {
                          change: function($event) {
                            var $$a = _vm.nextYear,
                              $$el = $event.target,
                              $$c = $$el.checked ? true : false
                            if (Array.isArray($$a)) {
                              var $$v = null,
                                $$i = _vm._i($$a, $$v)
                              if ($$el.checked) {
                                $$i < 0 && (_vm.nextYear = $$a.concat([$$v]))
                              } else {
                                $$i > -1 &&
                                  (_vm.nextYear = $$a
                                    .slice(0, $$i)
                                    .concat($$a.slice($$i + 1)))
                              }
                            } else {
                              _vm.nextYear = $$c
                            }
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c(
                        "label",
                        {
                          staticClass: "hrm-radio",
                          attrs: { for: "hrm-next-year" }
                        },
                        [_vm._v("Enable/Disable")]
                      )
                    ]),
                    _vm._v(" "),
                    _c("span", { staticClass: "hrm-clear" }),
                    _vm._v(" "),
                    _c("span", { staticClass: "description" }, [
                      _vm._v("Leave type carry to next financial year.")
                    ])
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
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("h2", { staticClass: "hndle ui-sortable-handle" }, [
      _c("span", [_vm._v("Leave Type")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: "hrm-leave-type-text-field" } }, [
      _vm._v("Leave Type"),
      _c("em", [_vm._v("  *")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v("\n\t\t\t\t\t\t\tDepartments\n\t\t\t\t\t\t\t"),
      _c("em", [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: "hrm-leave-entitlement-text-field" } }, [
      _vm._v("Entitlement "),
      _c("em", [_vm._v("  *")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: "" } }, [
      _vm._v("\n\t\t\t\t\t\t\tNext Year\n\t\t\t\t\t\t\t"),
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
    require("vue-hot-reload-api")      .rerender("data-v-85cee3ba", esExports)
  }
}

/***/ }),

/***/ 165:
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
    require("vue-hot-reload-api")      .rerender("data-v-e88718be", esExports)
  }
}

/***/ }),

/***/ 171:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(107);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(33)("0f200f1c", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-39259158\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-type-edit-form.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-39259158\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-type-edit-form.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 174:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(110);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(33)("5035f202", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-6b48f49a\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-type-records.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-6b48f49a\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-type-records.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 25:
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

/***/ 33:
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

var listToStyles = __webpack_require__(34)

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

/***/ 34:
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

/***/ 57:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_vue__ = __webpack_require__(103);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_7d48ccbe_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_vue__ = __webpack_require__(155);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_7d48ccbe_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/leave/leave-type.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7d48ccbe", Component.options)
  } else {
    hotAPI.reload("data-v-7d48ccbe", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 99:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
throw new Error("Cannot find module \"./../../mixin\"");
throw new Error("Cannot find module \"./../../hrm-directive\"");
//
//
//
//
//
//
//
//




var HRM_Leave_Type_Add_Btn = {
	mixins: [HRMMixin.leave],
	methods: {
		showHideNewLeaveTypeForm: function () {
			this.$store.commit('leave/isNewLeaveTypeFormVisible', { is_visible: true });
		}
	}
};

/* harmony default export */ __webpack_exports__["a"] = (HRM_Leave_Type_Add_Btn);

/***/ })

});