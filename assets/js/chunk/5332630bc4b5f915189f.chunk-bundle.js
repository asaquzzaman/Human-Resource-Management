wpSpearHrm([27],{

/***/ 302:
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

/* harmony default export */ __webpack_exports__["a"] = ({
	beforeRouteEnter(to, from, next) {
		next(vm => {
			vm.getSelfLeaveRecords();
		});
	},
	mixins: [HRMMixin.leave],
	computed: {
		pendingLeaves() {
			return this.$store.state.leave.approvedLeaves;
		}
	},

	methods: {
		getSelfLeaveRecords() {
			var self = this;

			var records = {
				data: {
					'status': 2
				},
				callback: function (res) {
					self.$store.commit('leave/setApprovalLeaves', res.data);
				}
			};

			this.getLeaveRecords(records);
		}
	}
});

/***/ }),

/***/ 375:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(35)(false);
// imports


// module
exports.push([module.i, "\n.hrm-image, .hrm-employee-name {\n\t\tfloat: left;\n}\n.hrm-employee-name  {\n\t\twidth: 60%;\n    \tmargin-left: 5px;\n    \tmargin-top: -3px;\n    \tword-wrap: break-word;\n}\n.hrm-td-content, .leave-action-wrap {\n\t\tdisplay: block;\n}\n.leave-action-wrap {\n\t\theight: 5px;\n\t\tmargin-top: 5px;\n\t\tmargin-bottom: 10px;\n}\n.hrm-employee-name {\n\t\tfont-weight: 600;\n}\n.leave-action {\n\t\tfont-size: 12px;\n\t\tdisplay: none;\n}\n.leave-action-tr:hover .leave-action {\n\t\tdisplay: block;\n}\n", ""]);

// exports


/***/ }),

/***/ 467:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "hrm-leave" }, [
    _c(
      "div",
      {
        staticClass: "metabox-holder hrm-leave-type-records-wrap",
        attrs: { id: "hrm-leave-record-wrap" }
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
                    _vm._l(_vm.pendingLeaves, function(pendingLeave) {
                      return _c("tr", [
                        _c("td", [
                          _c("div", [
                            _c("div", { staticClass: "hrm-td-content" }, [
                              _c("div", { staticClass: "hrm-image" }, [
                                _c("img", {
                                  attrs: {
                                    src: pendingLeave.employee.data.avatar_url,
                                    height: "32",
                                    width: "32"
                                  }
                                })
                              ]),
                              _vm._v(" "),
                              _c("span", { staticClass: "hrm-employee-name" }, [
                                _vm._v(
                                  _vm._s(
                                    pendingLeave.employee.data.display_name
                                  )
                                )
                              ]),
                              _vm._v(" "),
                              _c("div", { staticClass: "hrm-clear" })
                            ])
                          ])
                        ]),
                        _vm._v(" "),
                        _c("td", [
                          _vm._v(
                            "\n\t\t\t\t\t\t" +
                              _vm._s(pendingLeave.leave_type.data.name) +
                              "\n\t\t\t\t\t"
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", [
                          _vm._v(
                            "\n\t\t\t\t\t\t" +
                              _vm._s(
                                _vm.dateFormat(pendingLeave.apply_at.date)
                              ) +
                              "\n\t\t\t\t\t"
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", [_vm._v("1 day")]),
                        _vm._v(" "),
                        _c("td", {
                          domProps: { innerHTML: _vm._s(pendingLeave.comments) }
                        }),
                        _vm._v(" "),
                        _c("td", [
                          _vm._v(
                            _vm._s(_vm.dateFormat(pendingLeave.start_time))
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", [
                          _vm._v(_vm._s(_vm.dateFormat(pendingLeave.end_time)))
                        ])
                      ])
                    }),
                    _vm._v(" "),
                    !_vm.pendingLeaves.length
                      ? _c("tr", [
                          _c("td", { attrs: { colspan: "6" } }, [
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
          _vm._v("Employee")
        ]),
        _vm._v(" "),
        _c("th", [_vm._v("Leave Type")]),
        _vm._v(" "),
        _c("th", [_vm._v("Apply Date")]),
        _vm._v(" "),
        _c("th", [_vm._v("Leave Duration")]),
        _vm._v(" "),
        _c("th", [_vm._v("Comment")]),
        _vm._v(" "),
        _c("th", [_vm._v("Start")]),
        _vm._v(" "),
        _c("th", [_vm._v("End")])
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
    require("vue-hot-reload-api")      .rerender("data-v-a14ab042", esExports)
  }
}

/***/ }),

/***/ 50:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_approve_vue__ = __webpack_require__(302);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_a14ab042_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_approve_vue__ = __webpack_require__(467);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(502)
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_approve_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_a14ab042_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_approve_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-approve.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-a14ab042", Component.options)
  } else {
    hotAPI.reload("data-v-a14ab042", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 502:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(375);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(36)("729cbebe", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-a14ab042\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-approve.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-a14ab042\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-approve.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ })

});