webpackJsonp([2],{

/***/ 13:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_vue__ = __webpack_require__(40);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_a5a5ea94_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_vue__ = __webpack_require__(79);
var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */

/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_a5a5ea94_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "asset/js/components/leave/leave-holidays.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] leave-holidays.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-a5a5ea94", Component.options)
  } else {
    hotAPI.reload("data-v-a5a5ea94", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 32:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__vue_vue__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__vue_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__vue_vue__);


/**
 * Required jQuery methods 
 * 
 * @type Object
 */
var HRM_Admin = {
    init: function () {
        this.datepicker();
    },

    datepicker: function (el, vnodeContext) {

        jQuery('.hrm-date-field').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: '-50:+5',
            onSelect: function (dateText) {
                vnodeContext.$emit('hrm_date_picker', { field: 'datepicker', date: dateText });
            }
        });

        jQuery(".hrm-date-picker-from").datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true,
            numberOfMonths: 1,
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
            onClose: function (selectedDate) {
                jQuery(".hrm-date-picker-from").datepicker("option", "maxDate", selectedDate);
            },
            onSelect: function (dateText) {
                vnodeContext.$emit('hrm_date_picker', { field: 'datepicker_to', date: dateText });
            }
        });

        jQuery(".hrm-date-time-picker-from").datetimepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                jQuery(".hrm-date-time-picker-to").datetimepicker("option", "minDate", selectedDate);
            },
            onSelect: function (dateText) {
                vnodeContext.$emit('hrm_date_picker', { field: 'datetimepicker_from', date_time: dateText });
            }
        });

        jQuery(".hrm-date-time-picker-to").datetimepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                jQuery(".hrm-date-time-picker-from").datetimepicker("option", "maxDate", selectedDate);
            },
            onSelect: function (dateText) {
                vnodeContext.$emit('hrm_date_picker', { field: 'datetimepicker_to', date_time: dateText });
            }
        });
    }

    // Register a global custom directive called v-cpm-datepicker
};__WEBPACK_IMPORTED_MODULE_0__vue_vue___default.a.directive('hrm-datepicker', {
    inserted: function (el, binding, vnode) {
        HRM_Admin.datepicker(el, vnode.context);
    }
});

__WEBPACK_IMPORTED_MODULE_0__vue_vue___default.a.directive('hrm-slide-down', {
    inserted: function (el) {
        var node = jQuery(el);

        if (node.is(':visible')) {
            node.slideUp(400);
        } else {
            node.slideDown(400);
        }
    }
});

/***/ }),

/***/ 37:
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
	methods: {
		showHideNewLeaveTypeForm: function () {
			this.$store.commit('isNewLeaveTypeFormVisible', { is_visible: true });
		}
	}
});

/***/ }),

/***/ 38:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixin__ = __webpack_require__(2);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


console.log(__WEBPACK_IMPORTED_MODULE_0__mixin__["a" /* default */]);
/* harmony default export */ __webpack_exports__["a"] = ({

	mixins: [__WEBPACK_IMPORTED_MODULE_0__mixin__["a" /* default */]],

	//store: HRM_Leave_Store,

	data: function () {
		return {
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
				self.$store.commit('isNewLeaveTypeFormVisible', { is_visible: false });
			});
		},

		createNewHolidays: function () {

			var request_data = {
				_wpnonce: hrm_ajax_data.nonce,
				name: this.name,
				from: this.from,
				to: this.to,
				description: this.description
			},


			// is_update  = parseInt( this.department_id ) ? true : false,

			// target_index = is_update ? this.getIndex(
			//     this.$store.state.departments, this.department_id, 'id'
			// ) : false,

			self = this;

			this.show_spinner = true;

			wp.ajax.send('create_new_holidays', {
				data: request_data,

				success: function (res) {
					self.show_spinner = false;

					// Display a success toast, with a title
					toastr.success(res.success);

					self.slideUp(jQuery('.hrm-form-cancel'), function () {
						self.$store.commit('isNewDepartmentForVisible', { is_visible: false });
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

/***/ 39:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixin__ = __webpack_require__(2);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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

	mixins: [__WEBPACK_IMPORTED_MODULE_0__mixin__["a" /* default */]],

	//store: HRM_Leave_Store,

	data: function () {
		return {
			records: []
		};
	},

	computed: {},

	created: function () {
		this.getHolidays();
	},
	methods: {
		getHolidays: function () {
			var request_data = {
				_wpnonce: HRM_Vars.nonce
			},
			    self = this;

			wp.ajax.send('get_holidays', {
				data: request_data,
				success: function (res) {

					self.records = res.holidays;
				},

				error: function (res) {}
			});
		}
	}
});

/***/ }),

/***/ 40:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixin__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__leave_store__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__hrm_directive__ = __webpack_require__(32);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__leave_holidays_form_vue__ = __webpack_require__(56);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__leave_holidays_record_vue__ = __webpack_require__(57);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__leave_holidays_add_btn_vue__ = __webpack_require__(55);
//
//
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

	mixins: [__WEBPACK_IMPORTED_MODULE_0__mixin__["a" /* default */]],

	store: __WEBPACK_IMPORTED_MODULE_1__leave_store__["a" /* default */],

	data: function () {
		return {};
	},

	components: {
		'leave-holidays-form': __WEBPACK_IMPORTED_MODULE_3__leave_holidays_form_vue__["a" /* default */],
		'leave-holidays-record': __WEBPACK_IMPORTED_MODULE_4__leave_holidays_record_vue__["a" /* default */],
		'leave-holidays-add-btn': __WEBPACK_IMPORTED_MODULE_5__leave_holidays_add_btn_vue__["a" /* default */]
	},

	computed: {
		is_new_leave_type_form_visible: function () {
			return this.$store.state.is_new_leave_type_form_visible;
		}
	}
};

/* harmony default export */ __webpack_exports__["a"] = (Hrm_Leave_Holidays);

/***/ }),

/***/ 55:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_add_btn_vue__ = __webpack_require__(37);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_ef418cce_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_add_btn_vue__ = __webpack_require__(82);
var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */

/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_add_btn_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_ef418cce_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_add_btn_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "asset/js/components/leave/leave-holidays-add-btn.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] leave-holidays-add-btn.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-ef418cce", Component.options)
  } else {
    hotAPI.reload("data-v-ef418cce", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 56:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_form_vue__ = __webpack_require__(38);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_caf769aa_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_form_vue__ = __webpack_require__(80);
var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */

/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_form_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_caf769aa_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_form_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "asset/js/components/leave/leave-holidays-form.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] leave-holidays-form.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-caf769aa", Component.options)
  } else {
    hotAPI.reload("data-v-caf769aa", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 57:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_record_vue__ = __webpack_require__(39);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_79e9e478_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_record_vue__ = __webpack_require__(78);
var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */

/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_holidays_record_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_79e9e478_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_holidays_record_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "asset/js/components/leave/leave-holidays-record.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] leave-holidays-record.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-79e9e478", Component.options)
  } else {
    hotAPI.reload("data-v-79e9e478", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 78:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('div', {
    staticClass: "metabox-holder hrm-leave-type-records-wrap"
  }, [_c('table', {
    staticClass: "wp-list-table widefat fixed striped"
  }, [_vm._m(0), _vm._v(" "), _c('tbody', [_vm._l((_vm.records), function(record) {
    return _c('tr', [_c('td', [_vm._v(_vm._s(record.name))]), _vm._v(" "), _c('td', [_vm._v(_vm._s(record.from))]), _vm._v(" "), _c('td', [_vm._v(_vm._s(record.to))]), _vm._v(" "), _c('td', [_vm._v(_vm._s(record.description))])])
  }), _vm._v(" "), (!_vm.records.length) ? _c('tr', [_c('td', {
    attrs: {
      "colspan": "4"
    }
  }, [_vm._v("No record found!")])]) : _vm._e()], 2)])])])
}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('thead', [_c('th', [_vm._v("Name")]), _vm._v(" "), _c('th', [_vm._v("Start")]), _vm._v(" "), _c('th', [_vm._v("End")]), _vm._v(" "), _c('th', [_vm._v("Description")])])
}]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-79e9e478", esExports)
  }
}

/***/ }),

/***/ 79:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [(_vm.is_new_leave_type_form_visible) ? _c('div', {
    directives: [{
      name: "hrm-slide-down",
      rawName: "v-hrm-slide-down"
    }],
    staticClass: "hrm-slide-up",
    staticStyle: {
      "display": "none"
    }
  }, [_c('leave-holidays-form')], 1) : _vm._e(), _vm._v(" "), _c('leave-holidays-add-btn'), _vm._v(" "), _c('leave-holidays-record')], 1)
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-a5a5ea94", esExports)
  }
}

/***/ }),

/***/ 80:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "metabox-holder hrm-punch-in-out-wrap"
  }, [_c('div', {
    staticClass: "postbox"
  }, [_vm._m(0), _vm._v(" "), _c('div', {
    staticClass: "inside"
  }, [_c('div', {
    staticClass: "hrm-attendance-configuration",
    attrs: {
      "id": "hrm-hidden-form"
    }
  }, [_c('form', {
    attrs: {
      "action": ""
    },
    on: {
      "submit": function($event) {
        $event.preventDefault();
        _vm.createNewHolidays()
      }
    }
  }, [_c('div', {
    staticClass: "hrm-form-field "
  }, [_vm._m(1), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.name),
      expression: "name"
    }],
    attrs: {
      "type": "text",
      "id": "hrm-leave-type-text-field",
      "required": "required",
      "name": "name"
    },
    domProps: {
      "value": (_vm.name)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.name = $event.target.value
      }
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "hrm-clear"
  }), _vm._v(" "), _c('span', {
    staticClass: "description"
  })]), _vm._v(" "), _c('div', {
    staticClass: "hrm-form-field "
  }, [_vm._m(2), _vm._v(" "), _c('input', {
    directives: [{
      name: "hrm-datepicker",
      rawName: "v-hrm-datepicker"
    }],
    staticClass: "hrm-date-picker-from",
    attrs: {
      "type": "text",
      "id": "hrm-leave-holidays-from-text-field",
      "required": "required",
      "name": "from"
    },
    domProps: {
      "value": _vm.from
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "hrm-clear"
  }), _vm._v(" "), _c('span', {
    staticClass: "description"
  })]), _vm._v(" "), _c('div', {
    staticClass: "hrm-form-field "
  }, [_vm._m(3), _vm._v(" "), _c('input', {
    directives: [{
      name: "hrm-datepicker",
      rawName: "v-hrm-datepicker"
    }],
    staticClass: "hrm-date-picker-to",
    attrs: {
      "type": "text",
      "id": "hrm-leave-holidays-to-text-field",
      "required": "required",
      "name": "to"
    },
    domProps: {
      "value": _vm.to
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "hrm-clear"
  }), _vm._v(" "), _c('span', {
    staticClass: "description"
  })]), _vm._v(" "), _c('div', {
    staticClass: "hrm-form-field "
  }, [_vm._m(4), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.description),
      expression: "description"
    }],
    attrs: {
      "type": "text",
      "id": "hrm-leave-description-textarea-field",
      "required": "required",
      "name": "description"
    },
    domProps: {
      "value": (_vm.description)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.description = $event.target.value
      }
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "hrm-clear"
  }), _vm._v(" "), _c('span', {
    staticClass: "description"
  })]), _vm._v(" "), _c('input', {
    staticClass: "button hrm-submit-button button-primary",
    attrs: {
      "type": "submit",
      "name": "requst",
      "value": "Save changes"
    }
  }), _vm._v(" "), _c('a', {
    staticClass: "button hrm-form-cancel",
    attrs: {
      "target": "_blank",
      "href": "#"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.show_hide_new_leave_type_form($event)
      }
    }
  }, [_vm._v("Cancel")])])])])])])
}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('h2', {
    staticClass: "hndle ui-sortable-handle"
  }, [_c('span', [_vm._v("Holidays")])])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    attrs: {
      "for": "hrm-leave-type-text-field"
    }
  }, [_vm._v("\n\t\t\t\t\t\t\tName"), _c('em', [_vm._v("  *")])])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    attrs: {
      "for": "hrm-leave-holidays-from-text-field"
    }
  }, [_vm._v("\n\t\t\t\t\t\t\tFrom "), _c('em', [_vm._v("  *")])])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    attrs: {
      "for": "hrm-leave-holidays-to-text-field"
    }
  }, [_vm._v("\n\t\t\t\t\t\t\tTo"), _c('em', [_vm._v("  *")])])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    attrs: {
      "for": "hrm-leave-description-textarea-field"
    }
  }, [_vm._v("\n\t\t\t\t\t\t\tDescription"), _c('em', [_vm._v("  *")])])
}]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-caf769aa", esExports)
  }
}

/***/ }),

/***/ 82:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "hrm-tbl-action-btn-sibling"
  }, [_c('a', {
    staticClass: "button button-primary hrm-add-button",
    attrs: {
      "href": "#"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.showHideNewLeaveTypeForm()
      }
    }
  }, [_vm._v("Add")])])
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-ef418cce", esExports)
  }
}

/***/ })

});