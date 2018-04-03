wpSpearHrm([26],{

/***/ 318:
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
			return this.$store.state.leave.cancelLeaves;
		}
	},

	methods: {
		getSelfLeaveRecords() {
			var self = this;

			var records = {
				data: {
					'status': 3
				},
				callback: function (res) {
					self.$store.commit('leave/setCancelLeaves', res.data);
				}
			};

			this.getLeaveRecords(records);
		},

		selfUpdateLeaveStatus(pendingLeave, status) {
			var self = this;

			var args = {
				data: {
					id: pendingLeave.id,
					status: status,
					class: 'Leave',
					method: 'update'
				},
				callback: function (res) {
					self.$store.commit('leave/afterUpdateStatus', {
						section: 3,
						record: res
					});
				}
			};

			self.updateLeave(args);
		},

		selfLeaveDelete(id) {
			var args = {
				data: {
					leave_id: id
				},

				callback: function () {}
			};

			this.deleteLeave(args);
		}
	}
});

/***/ }),

/***/ 365:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(16)(false);
// imports


// module
exports.push([module.i, "\n.hrm-image, .hrm-employee-name {\n\t\tfloat: left;\n}\n.hrm-employee-name  {\n\t\twidth: 60%;\n    \tmargin-left: 5px;\n    \tmargin-top: -3px;\n    \tword-wrap: break-word;\n}\n.hrm-td-content, .leave-action-wrap {\n\t\tdisplay: block;\n}\n.leave-action-wrap {\n\t\theight: 5px;\n\t\tmargin-top: 5px;\n\t\tmargin-bottom: 10px;\n}\n.hrm-employee-name {\n\t\tfont-weight: 600;\n}\n.leave-action {\n\t\tfont-size: 12px;\n\t\tdisplay: none;\n}\n.leave-action-tr:hover .leave-action {\n\t\tdisplay: block;\n}\n", ""]);

// exports


/***/ }),

/***/ 430:
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
                      return _c(
                        "tr",
                        {
                          attrs: {
                            "data-recordId": pendingLeave.id,
                            id: "hrm-tr-" + pendingLeave.id
                          }
                        },
                        [
                          _c("td", [
                            _c("div", [
                              _c("div", { staticClass: "hrm-td-content" }, [
                                _c("div", { staticClass: "hrm-image" }, [
                                  _c("img", {
                                    attrs: {
                                      src:
                                        pendingLeave.employee.data.avatar_url,
                                      height: "32",
                                      width: "32"
                                    }
                                  })
                                ]),
                                _vm._v(" "),
                                _c(
                                  "span",
                                  { staticClass: "hrm-employee-name" },
                                  [
                                    _vm._v(
                                      _vm._s(
                                        pendingLeave.employee.data.display_name
                                      )
                                    )
                                  ]
                                ),
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
                            domProps: {
                              innerHTML: _vm._s(pendingLeave.comments)
                            }
                          }),
                          _vm._v(" "),
                          _c("td", [
                            _vm._v(
                              _vm._s(_vm.dateFormat(pendingLeave.start_time))
                            )
                          ]),
                          _vm._v(" "),
                          _c("td", [
                            _vm._v(
                              _vm._s(_vm.dateFormat(pendingLeave.end_time))
                            )
                          ]),
                          _vm._v(" "),
                          _c("td", [
                            _vm.canManamgeLeave()
                              ? _c(
                                  "button",
                                  {
                                    staticClass: "button button-secondary",
                                    on: {
                                      click: function($event) {
                                        $event.preventDefault()
                                        _vm.selfUpdateLeaveStatus(
                                          pendingLeave,
                                          1
                                        )
                                      }
                                    }
                                  },
                                  [
                                    _c("i", {
                                      staticClass: "fas fa-undo",
                                      attrs: { "aria-hidden": "true" }
                                    })
                                  ]
                                )
                              : _vm._e(),
                            _vm._v(" "),
                            _vm.canManamgeLeave()
                              ? _c(
                                  "button",
                                  {
                                    staticClass: "button button-secondary",
                                    on: {
                                      click: function($event) {
                                        $event.preventDefault()
                                        _vm.selfLeaveDelete(pendingLeave.id)
                                      }
                                    }
                                  },
                                  [
                                    _c("i", {
                                      staticClass: "fas fa-trash",
                                      attrs: { "aria-hidden": "true" }
                                    })
                                  ]
                                )
                              : _vm._e(),
                            _vm._v(" "),
                            !_vm.canManamgeLeave()
                              ? _c("div", [_vm._v("Not available")])
                              : _vm._e()
                          ])
                        ]
                      )
                    }),
                    _vm._v(" "),
                    !_vm.pendingLeaves.length
                      ? _c("tr", [
                          _c("td", { attrs: { colspan: "8" } }, [
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
        _c("th", [_vm._v("End")]),
        _vm._v(" "),
        _c("th", [_vm._v("Action")])
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
    require("vue-hot-reload-api")      .rerender("data-v-0e1e8750", esExports)
  }
}

/***/ }),

/***/ 492:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(365);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(17)("eef5a3dc", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-0e1e8750\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-cancel.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-0e1e8750\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-cancel.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 55:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_cancel_vue__ = __webpack_require__(318);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0e1e8750_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_cancel_vue__ = __webpack_require__(430);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(492)
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_cancel_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0e1e8750_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_cancel_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-cancel.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0e1e8750", Component.options)
  } else {
    hotAPI.reload("data-v-0e1e8750", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ })

});