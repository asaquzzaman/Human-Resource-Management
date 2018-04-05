wpSpearHrm([4],{

/***/ 165:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__router__ = __webpack_require__(42);
//
//
//
//
//
//
//
//
//
//
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

/***/ 166:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_header_vue__ = __webpack_require__(165);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0385a22a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_header_vue__ = __webpack_require__(167);
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

/***/ 167:
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

/***/ 332:
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
	mixins: [HRMMixin.leave]
});

/***/ }),

/***/ 333:
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


/* harmony default export */ __webpack_exports__["a"] = ({
	props: ['leaveType'],

	mixins: [HRMMixin.leave],

	data() {
		return {
			canSubmit: true
		};
	},

	computed: {
		departmentDropDown() {
			return this.$store.state.leave.departmentDropDown;
		}
	},

	components: {
		'hrm-multiselect': hrm.Multiselect.default
	},

	methods: {
		formValidation(data) {
			var isFormValidate = true;

			if (!data.leave_type) {
				hrm.Toastr.error('Leave type is required!');
				isFormValidate = false;
			}
			if (!data.departments.length) {
				hrm.Toastr.error('Department is required!');
				isFormValidate = false;
			}

			return isFormValidate;
		},

		updateSelfLeaveType() {
			if (!this.canSubmit) {
				return false;
			}
			var self = this;
			var args = {
				data: {
					id: this.leaveType.id,
					leave_type: this.leaveType.name,
					nextYear: this.leaveType.next_year,
					departments: this.leaveType.departments.data
				},
				callback: function () {
					self.canSubmit = true;
					self.loadingStop('hrm-edit-' + args.data.id);
				}
			};
			if (!this.formValidation(args.data)) {
				return false;
			}
			this.loadingStart('hrm-edit-' + this.leaveType.id, { animationClass: 'preloader-update-animation' });
			this.canSubmit = false;
			this.updateLeaveType(args);
		}
	}
});

/***/ }),

/***/ 334:
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
			departments: [],
			canSubmit: true
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
		'hrm-multiselect': hrm.Multiselect.default
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
		show_hide_new_leave_type_form: function () {
			var self = this;
			var node = jQuery('.hrm-slide-up');

			node.slideUp(400, function () {
				self.$store.commit('leave/isNewLeaveTypeFormVisible', { is_visible: false });
			});
		},

		filterDepartmentName(department) {
			var pad = '&#8212; ';
			return pad.repeat(department.hierarchical_depth) + department.name;
		},

		formValidation(data) {
			var isFormValidate = true;

			if (!parseInt(data.entitlement)) {
				hrm.Toastr.error('Entitlement is required!');
				isFormValidate = false;
			}
			if (!data.leave_type) {
				hrm.Toastr.error('Leave type is required!');
				isFormValidate = false;
			}
			if (!data.departments.length) {
				hrm.Toastr.error('Department is required!');
				isFormValidate = false;
			}

			return isFormValidate;
		},

		createNewLeaveType: function () {

			if (!this.canSubmit) {
				return false;
			}

			var request_data = {
				_wpnonce: HRM_Vars.nonce,
				entitlement: this.entitlement,
				leave_type: this.leave_type,
				// entitle_from: this.entitle_from,
				// entitle_to: this.entitle_to,
				nextYear: this.nextYear,
				departments: this.departments
			};

			if (!this.formValidation(request_data)) {
				return false;
			}

			self = this;
			this.show_spinner = true;

			wp.ajax.send('create_new_leave_type', {
				data: request_data,

				beforeSend() {
					self.canSubmit = false;
					self.loadingStart('hrm-leave-type-form', { animationClass: 'preloader-update-animation' });
				},

				success: function (res) {
					self.show_spinner = false;
					self.canSubmit = true;
					self.addLeaveTypeMeta(res.leave_type.data);
					// Display a success toast, with a title
					hrm.Toastr.success(res.success);
					self.show_hide_new_leave_type_form();
					self.$store.commit('leave/setNewLeaveType', res.leave_type.data);
					self.loadingStop('hrm-leave-type-form');
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
};

/* harmony default export */ __webpack_exports__["a"] = (Hrm_Leave_Type_Form);

/***/ }),

/***/ 335:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__leave_type_edit_form_vue__ = __webpack_require__(414);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
				beforeSend() {
					self.loadingStart('hrm-leave-type-records-wrap');
				},
				success: function (res) {
					res.data.forEach(function (type, index) {
						self.addLeaveTypeMeta(type);
					});

					self.$store.commit('leave/setLeaveTypes', res.data);
					self.isFetchRecord = true;
					self.loadingStop('hrm-leave-type-records-wrap');
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

/***/ 336:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__leave_type_form_vue__ = __webpack_require__(415);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__leave_type_records_vue__ = __webpack_require__(416);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__leave_type_add_btn_vue__ = __webpack_require__(413);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__leave_header_vue__ = __webpack_require__(166);
//
//
//
//
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
		'leave-type-add-btn': __WEBPACK_IMPORTED_MODULE_2__leave_type_add_btn_vue__["a" /* default */],
		'leave-header': __WEBPACK_IMPORTED_MODULE_3__leave_header_vue__["a" /* default */]
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

/***/ 364:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(16)(false);
// imports


// module
exports.push([module.i, "\n.hrm-td-editble-wrap .inline-edit-legend {\n\tmargin: 0;\n    padding: 0.2em 0.5em 0;\n    line-height: 2.5;\n    font-weight: 600;\n}\n#hrm-leave-type-records-wrap .hrm-td {\n\tpadding: 8px 10px;\n}\n.hrm-field-wrap {\n\tpadding-left: 6px;\n}\n", ""]);

// exports


/***/ }),

/***/ 371:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(16)(false);
// imports


// module
exports.push([module.i, "\n.hrm-input-width {\n\twidth: 50% !important;\n}\n.hrm-multiselect .multiselect {\n\twidth: 50% !important;\n}\n.hrm-field-wrap {\n\tdisplay: block;\n\twidth: 100%;\n}\n.hrm-inline-edit-label, .hrm-inline-edit-field {\n\tfloat: left;\n}\n.hrm-inline-edit-label {\n\twidth: 15%;\n}\n.hrm-inline-edit-field {\n\twidth: 60%;\n}\n.hrm-field-wrap .title {\n\twidth: 100% !important;\n}\n.hrm-field-wrap:after {\n\tvisibility: hidden;\n\tdisplay: block;\n\tfont-size: 0;\n\tcontent: \" \";\n\tclear: both;\n\theight: 0;\n}\n", ""]);

// exports


/***/ }),

/***/ 413:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_add_btn_vue__ = __webpack_require__(332);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_68ad790a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_add_btn_vue__ = __webpack_require__(464);
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_68ad790a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_add_btn_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-type-add-btn.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-68ad790a", Component.options)
  } else {
    hotAPI.reload("data-v-68ad790a", Component.options)
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
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_edit_form_vue__ = __webpack_require__(333);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_311dd2b2_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_edit_form_vue__ = __webpack_require__(442);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(498)
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_311dd2b2_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_edit_form_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-type-edit-form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-311dd2b2", Component.options)
  } else {
    hotAPI.reload("data-v-311dd2b2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 415:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_form_vue__ = __webpack_require__(334);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_bd8146ee_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_form_vue__ = __webpack_require__(486);
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_bd8146ee_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_form_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-type-form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-bd8146ee", Component.options)
  } else {
    hotAPI.reload("data-v-bd8146ee", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 416:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_records_vue__ = __webpack_require__(335);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0a48558d_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_records_vue__ = __webpack_require__(429);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(491)
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0a48558d_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_records_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-type-records.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0a48558d", Component.options)
  } else {
    hotAPI.reload("data-v-0a48558d", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 429:
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
        attrs: { id: "hrm-leave-type-records-wrap" }
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
                      return _c(
                        "tr",
                        {
                          staticClass:
                            "hrm-tr  inline-edit-row inline-edit-row-post inline-edit-post quick-edit-row quick-edit-row-post inline-edit-post inline-editor"
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
                                    _vm._v(
                                      "\n\t\t\t\t\t\t\t\t|\n\t\t\t\t\t\t\t\t"
                                    ),
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
                                        _vm._s(
                                          _vm.dateFormat(record.entitle_from)
                                        )
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
                                      _vm._v(
                                        _vm._s(
                                          _vm.dateFormat(record.entitle_to)
                                        )
                                      )
                                    ])
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          !record.editMode
                            ? _c("td", { staticClass: "hrm-td" }, [
                                _vm._v(
                                  _vm._s(_vm.carryStatus(record.next_year))
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          record.editMode
                            ? _c(
                                "td",
                                { attrs: { colspan: "5" } },
                                [
                                  _c("leave-type-edit-form", {
                                    attrs: {
                                      id: "hrm-edit-" + record.id,
                                      leaveType: record
                                    }
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
        _c("th", { staticClass: "manage-column column-cb" }, [
          _vm._v("Leave Type")
        ]),
        _vm._v(" "),
        _c("th", [_vm._v("Days")]),
        _vm._v(" "),
        _c("th", [_vm._v("Start")]),
        _vm._v(" "),
        _c("th", [_vm._v("End")]),
        _vm._v(" "),
        _c("th", [_vm._v("Carry to next year")])
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
    require("vue-hot-reload-api")      .rerender("data-v-0a48558d", esExports)
  }
}

/***/ }),

/***/ 442:
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
        attrs: { id: "hrm-edit-" + _vm.leaveType.id },
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
    require("vue-hot-reload-api")      .rerender("data-v-311dd2b2", esExports)
  }
}

/***/ }),

/***/ 463:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("leave-type-add-btn"),
      _vm._v(" "),
      _c("leave-header"),
      _vm._v(" "),
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
    require("vue-hot-reload-api")      .rerender("data-v-66481698", esExports)
  }
}

/***/ }),

/***/ 464:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("h1", { staticClass: "wp-heading-inline" }, [_vm._v("Leave Type")]),
    _vm._v(" "),
    _c(
      "a",
      {
        staticClass: "page-title-action hrm-btn",
        attrs: { href: "#" },
        on: {
          click: function($event) {
            $event.preventDefault()
            _vm.showHideNewLeaveTypeForm()
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
    require("vue-hot-reload-api")      .rerender("data-v-68ad790a", esExports)
  }
}

/***/ }),

/***/ 486:
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
        _c("h2", { staticClass: "hndle" }, [
          _vm._v("\n\t\t\tLeave Type\n\t\t")
        ]),
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
                  attrs: { id: "hrm-leave-type-form", action: "" },
                  on: {
                    submit: function($event) {
                      $event.preventDefault()
                      _vm.createNewLeaveType()
                    }
                  }
                },
                [
                  _c("div", { staticClass: "hrm-form-field " }, [
                    _vm._m(0),
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
                      _vm._m(1),
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
                      _c("div", { staticClass: "hrm-clear" }),
                      _vm._v(" "),
                      _vm._m(2)
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
                    staticClass: "button hrm-button-primary button-primary",
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
    ]
  )
}
var staticRenderFns = [
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
    return _c("span", { staticClass: "description" }, [
      _c("a", { attrs: { href: "#/departments" } }, [
        _vm._v("Create Department")
      ])
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
    require("vue-hot-reload-api")      .rerender("data-v-bd8146ee", esExports)
  }
}

/***/ }),

/***/ 491:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(364);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(17)("eeef3e60", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-0a48558d\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-type-records.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-0a48558d\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-type-records.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 498:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(371);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(17)("22e4b684", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-311dd2b2\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-type-edit-form.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-311dd2b2\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-type-edit-form.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 63:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_vue__ = __webpack_require__(336);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_66481698_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_vue__ = __webpack_require__(463);
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_66481698_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-type.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-66481698", Component.options)
  } else {
    hotAPI.reload("data-v-66481698", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ })

});