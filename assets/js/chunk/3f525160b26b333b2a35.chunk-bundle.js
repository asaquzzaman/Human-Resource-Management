wpSpearHrm([17],{

/***/ 165:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__router__ = __webpack_require__(42);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



var Hrm_Leave_Header = {
    mixins: [HRMMixin.leave],

    data: function () {
        return {
            menu: __WEBPACK_IMPORTED_MODULE_0__router__["a" /* default */][0].children
        };
    },

    created() {},

    methods: {
        childrens() {
            if (!this.has_child) {
                return [];
            }

            let root_menu = this.getParentName();
            let index = this.getIndex(this.menu, root_menu, 'name');

            if (index === false) {
                return [];
            }

            if (this.menu[index].hasOwnProperty('children')) {
                if (this.menu[index].children.length) {
                    return this.menu[index].children;
                }
            } else {
                return [];
            }
        },

        has_child: function () {

            if (this.$route.matched.length > 1) {
                return true;
            }

            return false;
        },

        getParentName() {
            let index = this.getIndex(this.$route.matched, this.$route.name, 'name');
            index = parseInt(index) - 1;
            return this.$route.matched[index].name;
        }
    }
};

/* harmony default export */ __webpack_exports__["a"] = (Hrm_Leave_Header);

/***/ }),

/***/ 166:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_header_vue__ = __webpack_require__(165);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0385a22a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_header_vue__ = __webpack_require__(167);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_header_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0385a22a_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_header_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-header.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0385a22a", Component.options)
  } else {
    hotAPI.reload("data-v-0385a22a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 167:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c(
      "h2",
      { staticClass: "nav-tab-wrapper" },
      _vm._l(_vm.menu, function(item, index) {
        return _c(
          "router-link",
          {
            key: index,
            staticClass: "nav-tab",
            attrs: { to: { name: item.name } }
          },
          [_vm._v(_vm._s(item.meta.label))]
        )
      })
    ),
    _vm._v(" "),
    _c("h3", { staticClass: "hrm-sub-nav" }, [
      _c(
        "ul",
        { staticClass: "hrm-subsubsub" },
        _vm._l(_vm.childrens(), function(children, child_key) {
          return _c(
            "li",
            { key: child_key },
            [
              _c("router-link", { attrs: { to: { name: children.name } } }, [
                _vm._v(_vm._s(children.meta.label))
              ]),
              _vm._v(" |  \n            ")
            ],
            1
          )
        })
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-0385a22a", esExports)
  }
}

/***/ }),

/***/ 337:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__leave_header_vue__ = __webpack_require__(166);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



var Hrm_Leave_Work_Week = {

	mixins: [HRMMixin.leave],

	data: function () {
		return {
			saturday: 'full',
			sunday: 'full',
			monday: 'full',
			tuesday: 'full',
			wednesday: 'full',
			thursday: 'full',
			friday: 'full'

		};
	},

	components: {
		'leave-header': __WEBPACK_IMPORTED_MODULE_0__leave_header_vue__["a" /* default */]
	},

	created: function () {
		this.getWorkWeek();
	},
	methods: {
		getWorkWeek: function () {
			var request_data = {
				_wpnonce: HRM_Vars.nonce
			},
			    self = this;

			wp.ajax.send('get_work_week', {
				data: request_data,

				success: function (res) {

					// Display a success toast, with a title
					//hrm.Toastr.success(res.success);

					self.saturday = res.work_week.saturday ? res.work_week.saturday : 'full';
					self.sunday = res.work_week.sunday ? res.work_week.sunday : 'full';
					self.monday = res.work_week.monday ? res.work_week.monday : 'full';
					self.tuesday = res.work_week.tuesday ? res.work_week.tuesday : 'full';
					self.wednesday = res.work_week.wednesday ? res.work_week.wednesday : 'full';
					self.thursday = res.work_week.thursday ? res.work_week.thursday : 'full';
					self.friday = res.work_week.friday ? res.work_week.friday : 'full';
				},

				error: function (res) {
					self.show_spinner = false;
					// Showing error
					res.error.map(function (value, index) {
						hrm.Toastr.error(value);
					});
				}
			});
		},
		saveWorkWeek: function () {

			var request_data = {
				_wpnonce: HRM_Vars.nonce,
				saturday: this.saturday,
				sunday: this.sunday,
				monday: this.monday,
				tuesday: this.tuesday,
				wednesday: this.wednesday,
				thursday: this.thursday,
				friday: this.friday
			};

			wp.ajax.send('save_work_week', {
				data: request_data,

				success: function (res) {
					// Display a success toast, with a title
					hrm.Toastr.success(res.message);
				},

				error: function (res) {
					self.show_spinner = false;
					// Showing error
					res.error.map(function (value, index) {
						hrm.Toastr.error(value);
					});
				}
			});
		}
	}
};

/* harmony default export */ __webpack_exports__["a"] = (Hrm_Leave_Work_Week);

/***/ }),

/***/ 474:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("leave-header"),
      _vm._v(" "),
      _c("div", { staticClass: "metabox-holder hrm-punch-in-out-wrap" }, [
        _c("div", { staticClass: "postbox" }, [
          _vm._m(0),
          _vm._v(" "),
          _c("div", { staticClass: "inside" }, [
            _c(
              "div",
              {
                staticClass: "hrm-attendance-configuration",
                attrs: { id: "hrm-hidden-form" }
              },
              [
                _c("form", { attrs: { action: "" } }, [
                  _c("div", { staticClass: "hrm-form-field " }, [
                    _vm._m(1),
                    _vm._v(" "),
                    _c(
                      "select",
                      {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.saturday,
                            expression: "saturday"
                          }
                        ],
                        attrs: { name: "saturday" },
                        on: {
                          change: [
                            function($event) {
                              var $$selectedVal = Array.prototype.filter
                                .call($event.target.options, function(o) {
                                  return o.selected
                                })
                                .map(function(o) {
                                  var val = "_value" in o ? o._value : o.value
                                  return val
                                })
                              _vm.saturday = $event.target.multiple
                                ? $$selectedVal
                                : $$selectedVal[0]
                            },
                            function($event) {
                              $event.preventDefault()
                              _vm.saveWorkWeek()
                            }
                          ]
                        }
                      },
                      [
                        _c("option", { attrs: { value: "full" } }, [
                          _vm._v("Full Day")
                        ]),
                        _vm._v(" "),
                        _c("option", { attrs: { value: "non" } }, [
                          _vm._v("Non-Working Day")
                        ])
                      ]
                    ),
                    _vm._v(" "),
                    _c("span", { staticClass: "hrm-clear" }),
                    _vm._v(" "),
                    _c("span", { staticClass: "description" })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "hrm-form-field " }, [
                    _vm._m(2),
                    _vm._v(" "),
                    _c(
                      "select",
                      {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.sunday,
                            expression: "sunday"
                          }
                        ],
                        attrs: { name: "sunday" },
                        on: {
                          change: [
                            function($event) {
                              var $$selectedVal = Array.prototype.filter
                                .call($event.target.options, function(o) {
                                  return o.selected
                                })
                                .map(function(o) {
                                  var val = "_value" in o ? o._value : o.value
                                  return val
                                })
                              _vm.sunday = $event.target.multiple
                                ? $$selectedVal
                                : $$selectedVal[0]
                            },
                            function($event) {
                              $event.preventDefault()
                              _vm.saveWorkWeek()
                            }
                          ]
                        }
                      },
                      [
                        _c("option", { attrs: { value: "full" } }, [
                          _vm._v("Full Day")
                        ]),
                        _vm._v(" "),
                        _c("option", { attrs: { value: "non" } }, [
                          _vm._v("Non-Working Day")
                        ])
                      ]
                    ),
                    _vm._v(" "),
                    _c("span", { staticClass: "hrm-clear" }),
                    _vm._v(" "),
                    _c("span", { staticClass: "description" })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "hrm-form-field " }, [
                    _vm._m(3),
                    _vm._v(" "),
                    _c(
                      "select",
                      {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.monday,
                            expression: "monday"
                          }
                        ],
                        attrs: { name: "monday" },
                        on: {
                          change: [
                            function($event) {
                              var $$selectedVal = Array.prototype.filter
                                .call($event.target.options, function(o) {
                                  return o.selected
                                })
                                .map(function(o) {
                                  var val = "_value" in o ? o._value : o.value
                                  return val
                                })
                              _vm.monday = $event.target.multiple
                                ? $$selectedVal
                                : $$selectedVal[0]
                            },
                            function($event) {
                              $event.preventDefault()
                              _vm.saveWorkWeek()
                            }
                          ]
                        }
                      },
                      [
                        _c("option", { attrs: { value: "full" } }, [
                          _vm._v("Full Day")
                        ]),
                        _vm._v(" "),
                        _c("option", { attrs: { value: "non" } }, [
                          _vm._v("Non-Working Day")
                        ])
                      ]
                    ),
                    _vm._v(" "),
                    _c("span", { staticClass: "hrm-clear" }),
                    _vm._v(" "),
                    _c("span", { staticClass: "description" })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "hrm-form-field " }, [
                    _vm._m(4),
                    _vm._v(" "),
                    _c(
                      "select",
                      {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.tuesday,
                            expression: "tuesday"
                          }
                        ],
                        attrs: { name: "tuesday" },
                        on: {
                          change: [
                            function($event) {
                              var $$selectedVal = Array.prototype.filter
                                .call($event.target.options, function(o) {
                                  return o.selected
                                })
                                .map(function(o) {
                                  var val = "_value" in o ? o._value : o.value
                                  return val
                                })
                              _vm.tuesday = $event.target.multiple
                                ? $$selectedVal
                                : $$selectedVal[0]
                            },
                            function($event) {
                              $event.preventDefault()
                              _vm.saveWorkWeek()
                            }
                          ]
                        }
                      },
                      [
                        _c("option", { attrs: { value: "full" } }, [
                          _vm._v("Full Day")
                        ]),
                        _vm._v(" "),
                        _c("option", { attrs: { value: "non" } }, [
                          _vm._v("Non-Working Day")
                        ])
                      ]
                    ),
                    _vm._v(" "),
                    _c("span", { staticClass: "hrm-clear" }),
                    _vm._v(" "),
                    _c("span", { staticClass: "description" })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "hrm-form-field " }, [
                    _vm._m(5),
                    _vm._v(" "),
                    _c(
                      "select",
                      {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.wednesday,
                            expression: "wednesday"
                          }
                        ],
                        attrs: { name: "wednesday" },
                        on: {
                          change: [
                            function($event) {
                              var $$selectedVal = Array.prototype.filter
                                .call($event.target.options, function(o) {
                                  return o.selected
                                })
                                .map(function(o) {
                                  var val = "_value" in o ? o._value : o.value
                                  return val
                                })
                              _vm.wednesday = $event.target.multiple
                                ? $$selectedVal
                                : $$selectedVal[0]
                            },
                            function($event) {
                              $event.preventDefault()
                              _vm.saveWorkWeek()
                            }
                          ]
                        }
                      },
                      [
                        _c("option", { attrs: { value: "full" } }, [
                          _vm._v("Full Day")
                        ]),
                        _vm._v(" "),
                        _c("option", { attrs: { value: "non" } }, [
                          _vm._v("Non-Working Day")
                        ])
                      ]
                    ),
                    _vm._v(" "),
                    _c("span", { staticClass: "hrm-clear" }),
                    _vm._v(" "),
                    _c("span", { staticClass: "description" })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "hrm-form-field " }, [
                    _vm._m(6),
                    _vm._v(" "),
                    _c(
                      "select",
                      {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.thursday,
                            expression: "thursday"
                          }
                        ],
                        attrs: { name: "thursday" },
                        on: {
                          change: [
                            function($event) {
                              var $$selectedVal = Array.prototype.filter
                                .call($event.target.options, function(o) {
                                  return o.selected
                                })
                                .map(function(o) {
                                  var val = "_value" in o ? o._value : o.value
                                  return val
                                })
                              _vm.thursday = $event.target.multiple
                                ? $$selectedVal
                                : $$selectedVal[0]
                            },
                            function($event) {
                              $event.preventDefault()
                              _vm.saveWorkWeek()
                            }
                          ]
                        }
                      },
                      [
                        _c("option", { attrs: { value: "full" } }, [
                          _vm._v("Full Day")
                        ]),
                        _vm._v(" "),
                        _c("option", { attrs: { value: "non" } }, [
                          _vm._v("Non-Working Day")
                        ])
                      ]
                    ),
                    _vm._v(" "),
                    _c("span", { staticClass: "hrm-clear" }),
                    _vm._v(" "),
                    _c("span", { staticClass: "description" })
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "hrm-form-field " }, [
                    _vm._m(7),
                    _vm._v(" "),
                    _c(
                      "select",
                      {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.friday,
                            expression: "friday"
                          }
                        ],
                        attrs: { name: "friday" },
                        on: {
                          change: [
                            function($event) {
                              var $$selectedVal = Array.prototype.filter
                                .call($event.target.options, function(o) {
                                  return o.selected
                                })
                                .map(function(o) {
                                  var val = "_value" in o ? o._value : o.value
                                  return val
                                })
                              _vm.friday = $event.target.multiple
                                ? $$selectedVal
                                : $$selectedVal[0]
                            },
                            function($event) {
                              $event.preventDefault()
                              _vm.saveWorkWeek()
                            }
                          ]
                        }
                      },
                      [
                        _c("option", { attrs: { value: "full" } }, [
                          _vm._v("Full Day")
                        ]),
                        _vm._v(" "),
                        _c("option", { attrs: { value: "non" } }, [
                          _vm._v("Non-Working Day")
                        ])
                      ]
                    ),
                    _vm._v(" "),
                    _c("span", { staticClass: "hrm-clear" }),
                    _vm._v(" "),
                    _c("span", { staticClass: "description" })
                  ])
                ])
              ]
            )
          ])
        ])
      ])
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("h2", { staticClass: "hndle" }, [_c("span", [_vm._v("Weekend")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: " " } }, [
      _vm._v("\n\t\t\t\t\t\t\t\tSaturday"),
      _c("em")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: " " } }, [
      _vm._v("\n\t\t\t\t\t\t\t\tSunday"),
      _c("em")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: " " } }, [
      _vm._v("\n\t\t\t\t\t\t\t\tMonday"),
      _c("em")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: " " } }, [
      _vm._v("\n\t\t\t\t\t\t\t\tTuesday"),
      _c("em")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: " " } }, [
      _vm._v("\n\t\t\t\t\t\t\t\tWednesday"),
      _c("em")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: " " } }, [
      _vm._v("\n\t\t\t\t\t\t\t\tThursday"),
      _c("em")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: " " } }, [
      _vm._v("\n\t\t\t\t\t\t\t\tFriday"),
      _c("em")
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-7bf6fc7c", esExports)
  }
}

/***/ }),

/***/ 64:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_work_week_vue__ = __webpack_require__(337);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_7bf6fc7c_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_work_week_vue__ = __webpack_require__(474);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_work_week_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_7bf6fc7c_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_work_week_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-work-week.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7bf6fc7c", Component.options)
  } else {
    hotAPI.reload("data-v-7bf6fc7c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ })

});