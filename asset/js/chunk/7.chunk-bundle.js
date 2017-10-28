webpackJsonp([7],{

/***/ 14:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_pending_vue__ = __webpack_require__(41);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_47cc41cc_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_pending_vue__ = __webpack_require__(74);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_pending_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_47cc41cc_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_pending_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "asset/js/components/leave/leave-pending.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] leave-pending.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-47cc41cc", Component.options)
  } else {
    hotAPI.reload("data-v-47cc41cc", Component.options)
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
	beforeRouteEnter(to, from, next) {
		next(vm => {
			vm.getSelfLeaveRecords();
		});
	},

	computed: {
		pendingLeaves() {
			return this.$store.state.pending_leaves;
		}
	},

	methods: {
		getSelfLeaveRecords() {
			var self = this;

			var records = {
				data: {
					'status': 1
				},
				callback: function (res) {
					self.$store.commit('setPendingLeaves', res.data);
				}
			};

			this.getLeaveRecords(records);
		}
	}
});

/***/ }),

/***/ 74:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('div', {
    staticClass: "metabox-holder hrm-leave-type-records-wrap"
  }, [_c('pre', [_vm._v(_vm._s(_vm.pendingLeaves))]), _vm._v(" "), _c('table', {
    staticClass: "wp-list-table widefat fixed striped"
  }, [_vm._m(0), _vm._v(" "), _c('tbody', _vm._l((_vm.pendingLeaves), function(pendingLeave) {
    return _c('tr', [_c('td', [_c('img', {
      attrs: {
        "src": pendingLeave.employee.data.avatar_url,
        "height": "32",
        "width": "32"
      }
    }), _vm._v("\n\t\t\t\t\t\t" + _vm._s(pendingLeave.employee.data.display_name) + "\n\t\t\t\t\t")]), _vm._v(" "), _c('td', [_c('button', {
      staticClass: "button button-secondary",
      on: {
        "click": function($event) {
          $event.preventDefault();
          _vm.updateLeaveStatus(pendingLeave, 2)
        }
      }
    }, [_vm._v("Approve")]), _vm._v(" "), _c('button', {
      staticClass: "button secondary",
      on: {
        "click": function($event) {
          $event.preventDefault();
          _vm.updateLeaveStatus(pendingLeave, 3)
        }
      }
    }, [_vm._v("Cancel")])])])
  }))])])])
}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('thead', [_c('th', [_vm._v("Employee")]), _vm._v(" "), _c('th', [_vm._v("Action")])])
}]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-47cc41cc", esExports)
  }
}

/***/ })

});