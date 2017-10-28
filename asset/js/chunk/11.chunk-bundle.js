webpackJsonp([11],{

/***/ 13:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_vue__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_023b6e56_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_vue__ = __webpack_require__(59);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_023b6e56_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "asset/js/components/leave/leave-type.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] leave-type.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-023b6e56", Component.options)
  } else {
    hotAPI.reload("data-v-023b6e56", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 25:
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

/***/ 30:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixin__ = __webpack_require__(2);




function HRMGetComponents() {
	var components = {};

	window.HRM_Components.map(function (obj, key) {
		if (obj.property.mixins) {
			obj.property.mixins.push(__WEBPACK_IMPORTED_MODULE_0__mixin__["a" /* default */]);
		} else {
			obj.property.mixins = [__WEBPACK_IMPORTED_MODULE_0__mixin__["a" /* default */]];
		}

		components[obj.component] = obj.property;
	});

	return components;
}

var action = {
	props: ['hook'],

	components: HRMGetComponents(),

	render(h) {
		var components = [],
		    self = this;

		window.HRM_Components.map(function (obj, key) {
			if (obj.hook == self.hook) {
				components.push(h(obj.component));
			}
		});

		return h('span', {}, components);
	}
};

/* harmony default export */ __webpack_exports__["a"] = (action);

/***/ }),

/***/ 41:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixin__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__hrm_directive__ = __webpack_require__(25);
//
//
//
//
//
//
//
//




var HRM_Leave_Type_Add_Btn = {
	mixins: [__WEBPACK_IMPORTED_MODULE_0__mixin__["a" /* default */]],
	methods: {
		showHideNewLeaveTypeForm: function () {
			this.$store.commit('isNewLeaveTypeFormVisible', { is_visible: true });
		}
	}
};

/* harmony default export */ __webpack_exports__["a"] = (HRM_Leave_Type_Add_Btn);

/***/ }),

/***/ 42:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixin__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__leave_store__ = __webpack_require__(7);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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

  mixins: [__WEBPACK_IMPORTED_MODULE_0__mixin__["a" /* default */]],

  store: __WEBPACK_IMPORTED_MODULE_1__leave_store__["a" /* default */],

  data: function () {
    return {
      entitle_from: '',
      entitle_to: '',
      leave_type: '',
      entitlement: ''
    };
  },

  created: function () {
    this.$on('hrm_date_picker', this.setDateTime);
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
        self.$store.commit('isNewLeaveTypeFormVisible', { is_visible: false });
      });
    },

    createNewLeaveType: function () {
      var request_data = {
        _wpnonce: HRM_Vars.nonce,
        entitlement: this.entitlement,
        leave_type: this.leave_type,
        entitle_from: this.entitle_from,
        entitle_to: this.entitle_to
      },


      //is_update  = parseInt( this.department_id ) ? true : false,

      // target_index = is_update ? this.getIndex(
      //     this.$store.state.departments, this.department_id, 'id'
      // ) : false,

      self = this;

      this.show_spinner = true;

      wp.ajax.send('create_new_leave_type', {
        data: request_data,

        success: function (res) {
          self.show_spinner = false;

          // Display a success toast, with a title
          toastr.success(res.success);

          self.show_hide_new_leave_type_form({ target: '.hrm-form-cancel' });

          // self.slideUp(jQuery('.hrm-form-cancel'), function() {
          // 	self.$store.commit('isNewDepartmentForVisible', {is_visible: false});
          // });

          self.$store.commit('updateDepartment', {
            is_update: is_update,
            dept_id: self.department_id,
            target_index: target_index,
            departments: res.departments,
            dept_drop_down: res.dept_drop_down
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
};

/* harmony default export */ __webpack_exports__["a"] = (Hrm_Leave_Type_Form);

/***/ }),

/***/ 43:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixin__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__leave_store__ = __webpack_require__(7);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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

	mixins: [__WEBPACK_IMPORTED_MODULE_0__mixin__["a" /* default */]],

	store: __WEBPACK_IMPORTED_MODULE_1__leave_store__["a" /* default */],

	data: function () {
		return {
			records: []
		};
	},

	computed: {},

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

					self.records = res.leave_types;
				},

				error: function (res) {}
			});
		}
	}
};

/* harmony default export */ __webpack_exports__["a"] = (Hrm_Leave_Type_Records);

/***/ }),

/***/ 44:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixin__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__leave_store__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__leave_type_form_vue__ = __webpack_require__(56);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__leave_type_records_vue__ = __webpack_require__(57);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__leave_type_add_btn_vue__ = __webpack_require__(55);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__do_action_vue__ = __webpack_require__(48);
//
//
//
//
//
//
//
//
//
//
//
//
//




// const Hrm_Leave_Type_Records = (resolve) => {
//        require.ensure(['./leave-type-records.vue'], () => {
//            resolve(require('./leave-type-records.vue'));
//        });
//    };






var Hrm_Leave_Type = {

	mixins: [__WEBPACK_IMPORTED_MODULE_0__mixin__["a" /* default */]],

	store: __WEBPACK_IMPORTED_MODULE_1__leave_store__["a" /* default */],

	components: {
		'leave-type-form': __WEBPACK_IMPORTED_MODULE_2__leave_type_form_vue__["a" /* default */],
		'leave-type-records': __WEBPACK_IMPORTED_MODULE_3__leave_type_records_vue__["a" /* default */],
		'leave-type-add-btn': __WEBPACK_IMPORTED_MODULE_4__leave_type_add_btn_vue__["a" /* default */],
		'my-action': __WEBPACK_IMPORTED_MODULE_5__do_action_vue__["a" /* default */]
	},

	computed: {
		is_new_leave_type_form_visible: function () {
			return this.$store.state.is_new_leave_type_form_visible;
		}
	}

};

/* harmony default export */ __webpack_exports__["a"] = (Hrm_Leave_Type);

/***/ }),

/***/ 48:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_do_action_vue__ = __webpack_require__(30);
var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */

/* template */
var __vue_template__ = null
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_do_action_vue__["a" /* default */],
  __vue_template__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "asset/js/components/do-action.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-246b3aca", Component.options)
  } else {
    hotAPI.reload("data-v-246b3aca", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 55:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_add_btn_vue__ = __webpack_require__(41);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_47802e90_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_add_btn_vue__ = __webpack_require__(65);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_add_btn_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_47802e90_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_add_btn_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "asset/js/components/leave/leave-type-add-btn.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] leave-type-add-btn.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-47802e90", Component.options)
  } else {
    hotAPI.reload("data-v-47802e90", Component.options)
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
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_form_vue__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_134c086c_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_form_vue__ = __webpack_require__(60);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_form_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_134c086c_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_form_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "asset/js/components/leave/leave-type-form.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] leave-type-form.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-134c086c", Component.options)
  } else {
    hotAPI.reload("data-v-134c086c", Component.options)
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
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_records_vue__ = __webpack_require__(43);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1adefaca_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_records_vue__ = __webpack_require__(61);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_records_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1adefaca_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_records_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "asset/js/components/leave/leave-type-records.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] leave-type-records.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1adefaca", Component.options)
  } else {
    hotAPI.reload("data-v-1adefaca", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 59:
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
  }, [_c('leave-type-form')], 1) : _vm._e(), _vm._v(" "), _c('leave-type-add-btn'), _vm._v(" "), _c('leave-type-records'), _vm._v(" "), _c('my-action', {
    attrs: {
      "hook": "hrm-after-leave-type"
    }
  })], 1)
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-023b6e56", esExports)
  }
}

/***/ }),

/***/ 60:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "metabox-holder hrm-slide-up hrm-punch-in-out-wrap"
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
        _vm.createNewLeaveType()
      }
    }
  }, [_c('div', {
    staticClass: "hrm-form-field "
  }, [_vm._m(1), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.leave_type),
      expression: "leave_type"
    }],
    attrs: {
      "type": "text",
      "id": "hrm-leave-type-text-field",
      "required": "required",
      "name": "leave_type"
    },
    domProps: {
      "value": (_vm.leave_type)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.leave_type = $event.target.value
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
      name: "model",
      rawName: "v-model",
      value: (_vm.entitlement),
      expression: "entitlement"
    }],
    attrs: {
      "type": "text",
      "id": "hrm-leave-entitlement-text-field",
      "required": "required",
      "name": "entitlement"
    },
    domProps: {
      "value": (_vm.entitlement)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.entitlement = $event.target.value
      }
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
    staticClass: "hrm-date-picker-from",
    attrs: {
      "type": "text",
      "id": "hrm-leave-entitlement-from-text-field",
      "required": "required",
      "name": "entitle_from"
    },
    domProps: {
      "value": _vm.entitle_from
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "hrm-clear"
  }), _vm._v(" "), _c('span', {
    staticClass: "description"
  })]), _vm._v(" "), _c('div', {
    staticClass: "hrm-form-field "
  }, [_vm._m(4), _vm._v(" "), _c('input', {
    directives: [{
      name: "hrm-datepicker",
      rawName: "v-hrm-datepicker"
    }],
    staticClass: "hrm-date-picker-to",
    attrs: {
      "type": "text",
      "id": "hrm-leave-entitlement-to-text-field",
      "required": "required",
      "name": "entitle_to"
    },
    domProps: {
      "value": _vm.entitle_to
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
  }, [_c('span', [_vm._v("Leave Type")])])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    attrs: {
      "for": "hrm-leave-type-text-field"
    }
  }, [_vm._v("Leave Type"), _c('em', [_vm._v("  *")])])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    attrs: {
      "for": "hrm-leave-entitlement-text-field"
    }
  }, [_vm._v("Entitlement "), _c('em', [_vm._v("  *")])])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    attrs: {
      "for": "hrm-leave-entitlement-from-text-field"
    }
  }, [_vm._v("Entitle from"), _c('em', [_vm._v("  *")])])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    attrs: {
      "for": "hrm-leave-entitlement-to-text-field"
    }
  }, [_vm._v("Entitle to"), _c('em', [_vm._v("  *")])])
}]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-134c086c", esExports)
  }
}

/***/ }),

/***/ 61:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('div', {
    staticClass: "metabox-holder hrm-leave-type-records-wrap"
  }, [_c('table', {
    staticClass: "wp-list-table widefat fixed striped"
  }, [_vm._m(0), _vm._v(" "), _c('tbody', [_vm._l((_vm.records), function(record) {
    return _c('tr', [_c('td', [_vm._v(_vm._s(record.leave_type_name))]), _vm._v(" "), _c('td', [_vm._v(_vm._s(record.entitlement))]), _vm._v(" "), _c('td', [_vm._v(_vm._s(record.entitle_from))]), _vm._v(" "), _c('td', [_vm._v(_vm._s(record.entitle_to))])])
  }), _vm._v(" "), (!_vm.records.length) ? _c('tr', [_c('td', {
    attrs: {
      "colspan": "4"
    }
  }, [_vm._v("No record found!")])]) : _vm._e()], 2)])])])
}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('thead', [_c('th', [_vm._v("Leave Type")]), _vm._v(" "), _c('th', [_vm._v("Days")]), _vm._v(" "), _c('th', [_vm._v("Start")]), _vm._v(" "), _c('th', [_vm._v("End")])])
}]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-1adefaca", esExports)
  }
}

/***/ }),

/***/ 65:
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
     require("vue-hot-reload-api").rerender("data-v-47802e90", esExports)
  }
}

/***/ })

});