wpSperaHrm([8],{

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


/* harmony default export */ __webpack_exports__["a"] = ({
    data() {
        return {
            financial_year: ''
        };
    },

    components: {},

    methods: {}
});

/***/ }),

/***/ 20:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_settings_vue__ = __webpack_require__(101);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_fd377a1c_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_settings_vue__ = __webpack_require__(96);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_settings_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_fd377a1c_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_settings_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "asset/js/components/settings/settings.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] settings.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-fd377a1c", Component.options)
  } else {
    hotAPI.reload("data-v-fd377a1c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 96:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('div', {
    staticClass: "metabox-holder"
  }, [_c('div', {
    staticClass: "group",
    attrs: {
      "id": "pm_general"
    }
  }, [_c('form', {
    attrs: {
      "method": "post",
      "action": "options.php"
    }
  }, [_c('h2', [_vm._v("General")]), _vm._v(" "), _c('table', {
    staticClass: "form-table"
  }, [_c('tbody', [_c('tr', [_vm._m(0), _vm._v(" "), _c('td', [_c('hrm-datepickter', {
    staticClass: "hrm-datepickter-to",
    attrs: {
      "dependency": "hrm-datepickter-from"
    },
    model: {
      value: (_vm.financial_year),
      callback: function($$v) {
        _vm.financial_year = $$v
      },
      expression: "financial_year"
    }
  }), _vm._v(" "), _c('p', {
    staticClass: "description"
  })], 1)])])])])])])])
}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('th', {
    attrs: {
      "scope": "row"
    }
  }, [_c('label', {
    attrs: {
      "for": ""
    }
  }, [_vm._v("financial Year")])])
}]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-fd377a1c", esExports)
  }
}

/***/ })

});