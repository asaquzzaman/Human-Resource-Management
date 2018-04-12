wpSpearHrm([30],{

/***/ 211:
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


/* harmony default export */ __webpack_exports__["a"] = ({
    mixins: [HRMMixin.departments],

    created: function () {
        //this.getDepartments();
    },

    watch: {
        '$route': function (to, from) {
            this.departmentQuery();
        }
    },
    computed: {
        total: function () {

            return Math.ceil(this.$store.state.departments.dept_pagination.total / this.$store.state.departments.dept_pagination.limit);
        },

        limit: function () {
            return this.$store.state.departments.dept_pagination.limit;
        },

        page_number: function () {
            return this.$store.state.departments.dept_pagination.page_number;
        }
    },

    methods: {
        departmentQuery() {
            var self = this;

            var conditions = {
                show_all: true
            };

            var args = {
                data: conditions,
                callback: function (res) {}
            };

            this.getDepartments(args);
        },
        pageClass: function (page) {
            if (page == this.page_number) {
                return 'page-numbers current';
            }

            return 'page-numbers';
        }
    }
});

/***/ }),

/***/ 336:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.total > 1
    ? _c("div", [
        _c(
          "div",
          { staticClass: "hrm-pagination-wrap" },
          [
            _vm.page_number > 1
              ? _c(
                  "router-link",
                  {
                    staticClass: "cpm-pagination-btn prev page-numbers",
                    attrs: {
                      to: {
                        name: "department_pagination",
                        params: {
                          page_number: _vm.page_number - 1
                        }
                      }
                    }
                  },
                  [_vm._v("\n            «\n        ")]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm._l(_vm.total, function(page) {
              return _c(
                "router-link",
                {
                  key: "page",
                  class: _vm.pageClass(page) + " cpm-pagination-btn",
                  attrs: {
                    to: {
                      name: "department_pagination",
                      params: {
                        page_number: page
                      }
                    }
                  }
                },
                [_vm._v("\n            " + _vm._s(page) + "\n        ")]
              )
            }),
            _vm._v(" "),
            _vm.page_number < _vm.total
              ? _c(
                  "router-link",
                  {
                    staticClass: "cpm-pagination-btn next page-numbers",
                    attrs: {
                      to: {
                        name: "department_pagination",
                        params: {
                          page_number: _vm.page_number + 1
                        }
                      }
                    }
                  },
                  [_vm._v("\n            »\n        ")]
                )
              : _vm._e()
          ],
          2
        ),
        _vm._v(" "),
        _c("div", { staticClass: "cpm-clearfix" })
      ])
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-340e4472", esExports)
  }
}

/***/ }),

/***/ 55:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_department_pagination_vue__ = __webpack_require__(211);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_340e4472_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_department_pagination_vue__ = __webpack_require__(336);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_department_pagination_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_340e4472_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_department_pagination_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/departments/department-pagination.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-340e4472", Component.options)
  } else {
    hotAPI.reload("data-v-340e4472", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ })

});