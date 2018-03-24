wpSpearHrm([23],{

/***/ 300:
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


/* harmony default export */ __webpack_exports__["a"] = ({
	beforeRouteEnter(to, form, next) {
		next(vm => {
			vm.getLeaveFromSettings();
		});
	},
	data() {
		return {
			others_employee: [],
			leave_types: [],
			apply_to: [],
			roles: []
		};
	},
	mixins: [HRMMixin.leave],
	components: {
		'hrm-multiselect': hrm.Multiselect.default
	},

	methods: {
		getLeaveFromSettings() {
			var self = this;
			var request = {
				data: {},
				success(res) {
					self.roles = self.processRoles(res.roles);
					//self.others_employee = self.processOthersEmployee(res.settings, res.roles);
					self.leave_types = self.processLeaveTypes(res.settings, res.roles);
					//self.apply_to = self.processApplyTo(res.settings, res.roles);
				}
			};
			this.httpRequest('get_leave_form_settings', request);
		},

		processApplyTo(settings, roles) {
			if (typeof settings.apply_to === 'undefined') {
				return [];
			}

			var apply_to = [];

			jQuery.each(roles, function (id, name) {
				if (settings.apply_to.indexOf(id) !== -1) {
					apply_to.push({
						id: id,
						name: name
					});
				}
			});

			return apply_to;
		},

		processOthersEmployee(settings, roles) {
			if (typeof settings.others_employee_leave === 'undefined') {
				return [];
			}

			var others_employee_leave = [];

			jQuery.each(roles, function (id, name) {
				if (settings.others_employee_leave.indexOf(id) !== -1) {
					others_employee_leave.push({
						id: id,
						name: name
					});
				}
			});

			return others_employee_leave;
		},

		saveLeaveFormSettings() {
			var self = this;
			var request = {
				data: {
					others_employee_leave: self.others_employee,
					leave_types: self.leave_types,
					apply_to: self.apply_to
				},
				success(res) {}
			};
			this.httpRequest('save_leave_form_settings', request);
		}
	}
});

/***/ }),

/***/ 356:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(35)(false);
// imports


// module
exports.push([module.i, "\n#hrm-hidden-form span {\n\tdisplay: block !important;\n}\n.multiselect__tags {\n\tdisplay: inline-block !important;\n\twidth: 100%;\n}\n.multiselect__input {\n\tborder: none !important;\n\tbox-shadow: none !important;\n}\n\n", ""]);

// exports


/***/ }),

/***/ 427:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "metabox-holder hrm-punch-in-out-wrap" }, [
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
            _c(
              "form",
              {
                attrs: { action: "" },
                on: {
                  submit: function($event) {
                    $event.preventDefault()
                    _vm.saveLeaveFormSettings()
                  }
                }
              },
              [
                false
                  ? _c("div", { staticClass: "hrm-form-field" }, [
                      _vm._m(1),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "hrm-multiselect" },
                        [
                          _c("hrm-multiselect", {
                            attrs: {
                              options: _vm.roles,
                              multiple: true,
                              "close-on-select": true,
                              "clear-on-select": true,
                              "hide-selected": false,
                              "show-labels": true,
                              placeholder: "Select roles",
                              "select-label": "",
                              "selected-label": "selected",
                              "deselect-label": "",
                              taggable: false,
                              label: "name",
                              "track-by": "id",
                              "allow-empty": true
                            },
                            model: {
                              value: _vm.others_employee,
                              callback: function($$v) {
                                _vm.others_employee = $$v
                              },
                              expression: "others_employee"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("span", { staticClass: "hrm-clear" }),
                      _vm._v(" "),
                      _c("span", { staticClass: "description" }, [
                        _vm._v(
                          "This roles can aplly behalf of others employee leave"
                        )
                      ])
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _c("div", { staticClass: "hrm-form-field" }, [
                  _vm._m(2),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "hrm-multiselect" },
                    [
                      _c("hrm-multiselect", {
                        attrs: {
                          options: _vm.roles,
                          multiple: true,
                          "close-on-select": true,
                          "clear-on-select": true,
                          "hide-selected": false,
                          "show-labels": true,
                          placeholder: "Select roles",
                          "select-label": "",
                          "selected-label": "selected",
                          "deselect-label": "",
                          taggable: false,
                          label: "name",
                          "track-by": "id",
                          "allow-empty": true
                        },
                        model: {
                          value: _vm.leave_types,
                          callback: function($$v) {
                            _vm.leave_types = $$v
                          },
                          expression: "leave_types"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("span", { staticClass: "hrm-clear" }),
                  _vm._v(" "),
                  _c("span", { staticClass: "description" }, [
                    _vm._v(
                      "This roles can aplly leave type enable/disable option"
                    )
                  ])
                ]),
                _vm._v(" "),
                false
                  ? _c("div", { staticClass: "hrm-form-field" }, [
                      _vm._m(3),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "hrm-multiselect" },
                        [
                          _c("hrm-multiselect", {
                            attrs: {
                              options: _vm.roles,
                              multiple: true,
                              "close-on-select": true,
                              "clear-on-select": true,
                              "hide-selected": false,
                              "show-labels": true,
                              placeholder: "Select roles",
                              "select-label": "",
                              "selected-label": "selected",
                              "deselect-label": "",
                              taggable: false,
                              label: "name",
                              "track-by": "id",
                              "allow-empty": true
                            },
                            model: {
                              value: _vm.apply_to,
                              callback: function($$v) {
                                _vm.apply_to = $$v
                              },
                              expression: "apply_to"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("span", { staticClass: "hrm-clear" }),
                      _vm._v(" "),
                      _c("span", { staticClass: "description" }, [
                        _vm._v("This roles can change leave status")
                      ])
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _c("input", {
                  staticClass: "button  hrm-button-primary",
                  attrs: {
                    type: "submit",
                    name: "requst",
                    value: "Save changes"
                  }
                })
              ]
            )
          ]
        )
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("h2", { staticClass: "hndle ui-sortable-handle" }, [
      _c("span", [_vm._v("Leave Form Settings")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v("\n\t\t\t\t\t\t\tOthers employee \n\t\t\t\t\t\t\t"),
      _c("em")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v("\n\t\t\t\t\t\t\tLeave type  \n\t\t\t\t\t\t\t"),
      _c("em")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v("\n\t\t\t\t\t\t\tLeave request approve by \n\t\t\t\t\t\t\t"),
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
    require("vue-hot-reload-api")      .rerender("data-v-4798389e", esExports)
  }
}

/***/ }),

/***/ 480:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(356);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(36)("5d2033e6", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4798389e\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-form-settings.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4798389e\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-form-settings.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 52:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_form_settings_vue__ = __webpack_require__(300);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4798389e_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_form_settings_vue__ = __webpack_require__(427);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(480)
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_form_settings_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4798389e_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_form_settings_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/leave/leave-form-settings.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4798389e", Component.options)
  } else {
    hotAPI.reload("data-v-4798389e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ })

});