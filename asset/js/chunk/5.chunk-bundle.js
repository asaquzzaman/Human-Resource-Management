webpackJsonp([5],{

/***/ 28:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_type_records_vue__ = __webpack_require__(41);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1adefaca_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_type_records_vue__ = __webpack_require__(56);
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

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 41:
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

/***/ 56:
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

/***/ })

});