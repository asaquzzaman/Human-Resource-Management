wpSpearHrm([28],{

/***/ 339:
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

/* harmony default export */ __webpack_exports__["a"] = ({});

/***/ }),

/***/ 434:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "\n.text {\n\tdisplay: block;\n\tmargin: 10px 0;\n}\n.title h1 {\n\tmargin: 0;\n\tpadding: 0;\n}\n.metabox-holder {\n\twidth: 100%\n}\n.hrm-addon-block {\n\tfloat: left;\n\twidth: 48%;\n}\n.hrm-block-content {\n\tpadding: 10px;\n\tmargin: 10px;\n\tbackground: #fff;\n\tborder: 1px solid #e5e5e5;\n}\n", ""]);

// exports


/***/ }),

/***/ 530:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm._m(0)
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "metabox-holder" }, [
      _c("div", { staticClass: "hrm-addon-block" }, [
        _c("div", { staticClass: "hrm-block-content" }, [
          _c("div", { staticClass: "title" }, [
            _c("h1", [_vm._v("HRM Front-End")])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "hrm-block-description" }, [
            _c("span", { staticClass: "text" }, [
              _vm._v("You will get back-end all feature in front-end")
            ]),
            _vm._v(" "),
            _c(
              "a",
              {
                staticClass: "button button-primary hrm-link",
                attrs: {
                  href: "http://mishubd.com/product/hrm-front-end/",
                  target: "_blank"
                }
              },
              [_vm._v("\n\t\t\t\t\tGet it now!\n\t\t\t\t")]
            )
          ])
        ])
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
    require("vue-hot-reload-api")      .rerender("data-v-eb36cae2", esExports)
  }
}

/***/ }),

/***/ 561:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(434);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(2)("c30f9c60", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-eb36cae2\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./addons.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-eb36cae2\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./addons.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 58:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_addons_vue__ = __webpack_require__(339);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_eb36cae2_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_addons_vue__ = __webpack_require__(530);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(561)
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_addons_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_eb36cae2_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_addons_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/addons/addons.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-eb36cae2", Component.options)
  } else {
    hotAPI.reload("data-v-eb36cae2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ })

});