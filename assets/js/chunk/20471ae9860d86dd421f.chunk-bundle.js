wpSpearHrm([25],{

/***/ 305:
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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

	computed: {

		pendingLeaves() {
			return this.$store.state.leave.pending_leaves;
		}
	},
	created() {
		this.getSelfLeaveRecords();
	},
	methods: {
		total() {},
		selfEmployeeLeaveSummery(employee_id, row_id, $event) {
			var target = jQuery($event.target).parent();

			target.find('.hrm-spinner').show();

			var args = {
				data: {
					employee_id: employee_id,
					row_id: row_id,
					type: 'pending'
				},

				callback() {
					hrm.Vue.nextTick(function () {
						jQuery('#hrm-toggle-' + row_id).hide();
						jQuery('#hrm-toggle-' + row_id).slideDown(400);
					});
				}
			};

			this.employeeLeaveSummery(args);
		},
		getSelfLeaveRecords() {
			var self = this;

			var records = {
				data: {
					'status': 1
				},
				callback: function (res) {
					self.$store.commit('leave/setPendingLeaves', res.data);
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
						section: 1,
						record: res
					});
				}
			};

			//jQuery('#hrm-tr-'+pendingLeave.id).fadeOut(400, function() {
			self.updateLeave(args);
			//});
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

exports = module.exports = __webpack_require__(35)(false);
// imports


// module
exports.push([module.i, "\n.hrm-image, .hrm-employee-name {\n\t\tfloat: left;\n}\n.hrm-employee-name  {\n\t\twidth: 60%;\n    \tmargin-left: 5px;\n    \tmargin-top: -3px;\n    \tword-wrap: break-word;\n}\n.hrm-td-content, .leave-action-wrap {\n\t\tdisplay: block;\n}\n.leave-action-wrap {\n\t\theight: 5px;\n\t\tmargin-top: 5px;\n\t\tmargin-bottom: 10px;\n}\n.hrm-employee-name {\n\t\tfont-weight: 600;\n}\n.leave-action {\n\t\tfont-size: 12px;\n\t\tdisplay: none;\n}\n.leave-action-tr:hover .leave-action {\n\t\tdisplay: block;\n}\n", ""]);

// exports


/***/ }),

/***/ 446:
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
                    _vm._l(_vm.pendingLeaves, function(pendingLeave, index) {
                      return _c(
                        "tr",
                        {
                          key: index,
                          staticClass: "leave-action-tr",
                          attrs: {
                            "data-recordId": pendingLeave.id,
                            id: "hrm-tr-" + pendingLeave.id
                          }
                        },
                        [
                          !pendingLeave.metaSummeryDisplay
                            ? _c("td", [
                                _c("div", [
                                  _c("div", { staticClass: "hrm-td-content" }, [
                                    _c("div", { staticClass: "hrm-image" }, [
                                      _c("img", {
                                        attrs: {
                                          src:
                                            pendingLeave.employee.data
                                              .avatar_url,
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
                                            pendingLeave.employee.data
                                              .display_name
                                          )
                                        )
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c("div", { staticClass: "hrm-clear" })
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    { staticClass: "leave-action-wrap" },
                                    [
                                      _c(
                                        "div",
                                        { staticClass: "leave-action" },
                                        [
                                          _c(
                                            "a",
                                            {
                                              staticClass: "pm-todo-edit",
                                              attrs: { href: "#" },
                                              on: {
                                                click: function($event) {
                                                  $event.preventDefault()
                                                  _vm.selfEmployeeLeaveSummery(
                                                    pendingLeave.employee.data
                                                      .id,
                                                    pendingLeave.id,
                                                    $event
                                                  )
                                                }
                                              }
                                            },
                                            [
                                              _c("span", {}, [
                                                _vm._v("Summery")
                                              ]),
                                              _vm._v(" "),
                                              _c("span", {
                                                staticClass: "hrm-spinner",
                                                staticStyle: { display: "none" }
                                              })
                                            ]
                                          )
                                        ]
                                      )
                                    ]
                                  )
                                ])
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          !pendingLeave.metaSummeryDisplay
                            ? _c("td", [
                                _vm._v(
                                  "\n\t\t\t\t\t\t" +
                                    _vm._s(pendingLeave.leave_type.data.name) +
                                    "\n\t\t\t\t\t"
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          !pendingLeave.metaSummeryDisplay
                            ? _c("td", [
                                _vm._v(
                                  "\n\t\t\t\t\t\t" +
                                    _vm._s(
                                      _vm.dateFormat(pendingLeave.apply_at.date)
                                    ) +
                                    "\n\t\t\t\t\t"
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          !pendingLeave.metaSummeryDisplay
                            ? _c("td", [
                                _vm._v("\n\t\t\t\t\t\t1 day\n\t\t\t\t\t")
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          !pendingLeave.metaSummeryDisplay
                            ? _c("td", {
                                domProps: {
                                  innerHTML: _vm._s(pendingLeave.comments)
                                }
                              })
                            : _vm._e(),
                          _vm._v(" "),
                          !pendingLeave.metaSummeryDisplay
                            ? _c("td", [
                                _vm._v(
                                  "\n\t\t\t\t\t\t" +
                                    _vm._s(
                                      _vm.dateFormat(pendingLeave.start_time)
                                    ) +
                                    "\n\t\t\t\t\t"
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          !pendingLeave.metaSummeryDisplay
                            ? _c("td", [
                                _vm._v(
                                  "\n\t\t\t\t\t\t" +
                                    _vm._s(
                                      _vm.dateFormat(pendingLeave.end_time)
                                    ) +
                                    "\n\t\t\t\t\t"
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          !pendingLeave.metaSummeryDisplay
                            ? _c("td", [
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
                                              2
                                            )
                                          }
                                        }
                                      },
                                      [_c("i", { staticClass: "fas fa-check" })]
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
                                            _vm.selfUpdateLeaveStatus(
                                              pendingLeave,
                                              3
                                            )
                                          }
                                        }
                                      },
                                      [_c("i", { staticClass: "fas fa-ban" })]
                                    )
                                  : _vm._e(),
                                _vm._v(" "),
                                _c(
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
                                  [_c("i", { staticClass: "fas fa-trash" })]
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          pendingLeave.metaSummeryDisplay
                            ? _c("td", { attrs: { colspan: "8" } }, [
                                _c(
                                  "div",
                                  {
                                    attrs: {
                                      id: "hrm-toggle-" + pendingLeave.id
                                    }
                                  },
                                  [
                                    _c(
                                      "table",
                                      {
                                        staticClass:
                                          "wp-list-table widefat fixed striped"
                                      },
                                      [
                                        _vm._m(1, true),
                                        _vm._v(" "),
                                        _c(
                                          "tbody",
                                          [
                                            _vm._l(
                                              pendingLeave.metaSummery,
                                              function(type) {
                                                return _c("tr", [
                                                  _c("td", [
                                                    _vm._v(
                                                      _vm._s(
                                                        type.leave_type_name
                                                      )
                                                    )
                                                  ]),
                                                  _vm._v(" "),
                                                  type.id === 1
                                                    ? _c("td", [_vm._v("–")])
                                                    : _c("td", [
                                                        _vm._v(
                                                          _vm._s(
                                                            _vm.pad(
                                                              type.entitlement
                                                            )
                                                          )
                                                        )
                                                      ]),
                                                  _vm._v(" "),
                                                  _c("td", [
                                                    _vm._v(
                                                      _vm._s(
                                                        _vm.pad(type.count)
                                                      )
                                                    )
                                                  ]),
                                                  _vm._v(" "),
                                                  type.id === 0
                                                    ? _c("td", [_vm._v("–")])
                                                    : _c("td", [
                                                        _vm._v(
                                                          _vm._s(
                                                            _vm.pad(
                                                              type.entitlement -
                                                                type.count
                                                            )
                                                          )
                                                        )
                                                      ])
                                                ])
                                              }
                                            ),
                                            _vm._v(" "),
                                            _c("tr", [
                                              _vm._m(2, true),
                                              _vm._v(" "),
                                              _c("td", [
                                                _c("strong", [
                                                  _vm._v(
                                                    _vm._s(
                                                      _vm.pad(
                                                        _vm.totalEntitlement(
                                                          pendingLeave.metaSummery
                                                        )
                                                      )
                                                    )
                                                  )
                                                ])
                                              ]),
                                              _vm._v(" "),
                                              _c("td", [
                                                _c("strong", [
                                                  _vm._v(
                                                    _vm._s(
                                                      _vm.pad(
                                                        _vm.totalTakeLeave(
                                                          pendingLeave.metaSummery
                                                        )
                                                      )
                                                    )
                                                  )
                                                ])
                                              ]),
                                              _vm._v(" "),
                                              _c("td", [
                                                _c("strong", [
                                                  _vm._v(
                                                    _vm._s(
                                                      _vm.pad(
                                                        _vm.totalRemainLeave(
                                                          pendingLeave.metaSummery
                                                        )
                                                      )
                                                    )
                                                  )
                                                ])
                                              ])
                                            ])
                                          ],
                                          2
                                        )
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "a",
                                      {
                                        staticClass: "button button-secondary",
                                        staticStyle: { "margin-top": "10px" },
                                        attrs: { href: "#" },
                                        on: {
                                          click: function($event) {
                                            $event.preventDefault()
                                            _vm.showHideSummery(
                                              pendingLeave,
                                              "pending"
                                            )
                                          }
                                        }
                                      },
                                      [_vm._v("Cancel")]
                                    )
                                  ]
                                )
                              ])
                            : _vm._e()
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
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("th", [_vm._v("Leave Type")]),
      _vm._v(" "),
      _c("th", [_vm._v("Entitlement")]),
      _vm._v(" "),
      _c("th", [_vm._v("Taken Leave")]),
      _vm._v(" "),
      _c("th", [_vm._v("Remain")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("td", [_c("strong", [_vm._v("Total")])])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-70600dae", esExports)
  }
}

/***/ }),

/***/ 490:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(365);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(36)("bdde7e58", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-70600dae\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-pending.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-70600dae\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-pending.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 54:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_pending_vue__ = __webpack_require__(305);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_70600dae_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_pending_vue__ = __webpack_require__(446);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(490)
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_pending_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_70600dae_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_pending_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-pending.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-70600dae", Component.options)
  } else {
    hotAPI.reload("data-v-70600dae", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ })

});