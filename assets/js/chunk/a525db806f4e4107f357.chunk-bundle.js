wpSpearHrm([24],{

/***/ 379:
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

/* harmony default export */ __webpack_exports__["a"] = ({
	mixins: [HRMMixin.profile],

	data() {
		return {
			editMode: false,
			isFetchRecord: false,
			fields: [{
				type: 'text',
				model: '',
				label: 'Organization Name ',
				name: 'organization_name',
				required: true,
				editMode: false,
				default: '&#8211 &#8211'
			}, {
				type: 'text',
				model: '',
				label: 'Tax ID',
				name: 'tax_id',
				editMode: false,
				default: '&#8211 &#8211'
			}, {
				type: 'text',
				model: '',
				label: 'Registration Number',
				name: 'registration_number',
				editMode: false,
				default: '&#8211 &#8211'
			}, {
				type: 'text',
				model: '',
				label: 'Phone',
				name: 'phone',
				editMode: false,
				default: '&#8211 &#8211'
			}, {
				type: 'text',
				model: '',
				label: 'Fax',
				name: 'fax',
				editMode: false,
				default: '&#8211 &#8211'
			}, {
				type: 'text',
				model: '',
				label: 'Address Street 1',
				name: 'addres_street_1',
				editMode: false,
				default: '&#8211 &#8211'
			}, {
				type: 'text',
				model: '',
				label: 'Address Street 2',
				name: 'address_street_2',
				editMode: false,
				default: '&#8211 &#8211'
			}, {
				type: 'text',
				model: '',
				label: 'City',
				name: 'city',
				editMode: false,
				default: '&#8211 &#8211'
			}, {
				type: 'text',
				model: '',
				label: 'State/Province',
				name: 'state_province',
				editMode: false,
				default: '&#8211 &#8211'
			}, {
				type: 'text',
				model: '',
				label: 'Zip/Postal Code',
				name: 'zip',
				editMode: false,
				default: '&#8211 &#8211'
			}, {
				type: 'select',
				model: '',
				options: [],
				label: 'Country',
				optionLabel: 'country',
				placeholder: 'Select Country',
				name: 'country',
				editMode: false,
				default: '&#8211 &#8211',
				filter(val) {
					return val.country;
				}
			}, {
				type: 'textarea',
				model: '',
				label: 'Note',
				name: 'note',
				editMode: false,
				default: '&#8211 &#8211'
			}],

			loading: false,
			canSubmit: false,
			record: {}
		};
	},

	created() {
		var self = this;
		var args = {
			callback(res) {
				self.record = res.data;
				self.fields.forEach(function (field) {
					if (field.name == 'country') {
						field.options = res.countries;
					}
				});

				self.afterGetRecored();
			}
		};
		this.getOrganizationInfo(args);
	},

	methods: {
		filter(value, field) {

			if (!value) {
				return field.default;
			}

			if (typeof field.filter !== 'undefined') {
				return field.filter(value, this);
			}
			return value;
		},
		afterGetRecored() {
			var self = this,
			    record = self.record;
			if (record == null) {
				return;
			}
			self.fields.forEach(function (field) {
				field.model = record[field.name] ? record[field.name] : '';
			});
		},
		update(status) {

			this.editMode = status;

			this.afterGetRecored();
		},
		setStyle(field) {
			return {
				height: field.attr.height,
				width: field.attr.width
			};
		},
		getOrganizationInfo(args) {
			var self = this;

			var request_data = {
				data: {},
				beforeSend() {
					self.loadingStart('hrm-visible-form');
				},
				success: function (res) {
					// self.$store.commit('general/setOrganizationInfo', res.data);
					self.loadingStop('hrm-visible-form');
					self.isFetchRecord = true;
					if (typeof args.callback === 'function') {
						args.callback(res);
					}
				}
			};

			self.httpRequest('hrm_get_organigation_info', request_data);
		},
		selfSaveOrganizationalInfo() {
			var self = this;

			self.loading = true;
			self.canSubmit = true;
			var postData = this.generateFieldData(this.fields);
			var args = {
				data: postData,
				callback(res) {
					self.record = res.data;
					self.loading = false;
					self.canSubmit = false;
					self.editMode = false;
				}
			};

			this.saveOrganizationalInfo(args);
		},

		generateFieldData(data) {
			var formated = [];

			data.forEach(function (val) {
				formated.push({
					'name': val.name,
					'value': val.model
				});
			});

			return formated;
		},

		saveOrganizationalInfo(args) {
			var self = this;
			args.data.push({
				name: 'action',
				value: 'single_form'
			});
			args.data.push({
				name: 'table_option',
				value: 'hrm_general_info'
			});
			var request_data = {
				data: args.data,
				type: 'POST',
				beforeSend() {
					self.loadingStart('hrm-general-info-form', { animationClass: 'preloader-update-animation' });
				},
				success: function (res) {
					//self.$store.commit('profile/setPersonalInfo', res);
					self.loadingStop('hrm-general-info-form');
					hrm.Toastr.success('Update successfully!');
					if (typeof args.callback === 'function') {
						args.callback(res);
					}
				}
			};

			self.httpRequest('single_form', request_data);
		}

	}
});

/***/ }),

/***/ 414:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "\n.hrm-title, .hrm-content {\n\tfloat: left;\n}\n.hrm-content {\n\twidth: 65%;\n}\n.hrm-content-wrap {\n\tdisplay: block;\n\tmargin-bottom: 10px;\n\twidth: 100%;\n}\n", ""]);

// exports


/***/ }),

/***/ 485:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "page-organization metabox-holder" },
    [
      _c("h1", { staticClass: "wp-heading-inline" }, [_vm._v("Organization")]),
      _vm._v(" "),
      _c("organization-menu"),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "postbox", attrs: { id: "hrm-hidden-form-warp" } },
        [
          _c("h2", { staticClass: "hndle ui-sortable-handle" }, [
            _vm._v("General Information")
          ]),
          _vm._v(" "),
          _c("div", { attrs: { id: "hrm-visible-form" } }, [
            _vm.isFetchRecord
              ? _c("div", { staticClass: "inside" }, [
                  _c("div", { staticClass: "main" }, [
                    !_vm.editMode
                      ? _c(
                          "div",
                          [
                            _vm._l(_vm.fields, function(field, index) {
                              return field.type == "file"
                                ? _c(
                                    "div",
                                    {
                                      key: index,
                                      staticClass: "hrm-content-wrap"
                                    },
                                    [
                                      _c(
                                        "label",
                                        { staticClass: "hrm-title" },
                                        [
                                          _vm._v(
                                            "\n\t\t\t\t\t\t\t\t\tProfile Picture\n\t\t\t\t\t\t\t\t"
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        { staticClass: "hrm-uploaded-item" },
                                        _vm._l(field.model, function(file) {
                                          return _c(
                                            "a",
                                            {
                                              staticClass: "hrm-uploaded-img",
                                              attrs: {
                                                href: file.url,
                                                target: "_blank"
                                              }
                                            },
                                            [
                                              _c("img", {
                                                staticClass:
                                                  "hrm-uploaded-file",
                                                style: _vm.setStyle(field),
                                                attrs: {
                                                  src: file.thumb,
                                                  alt: "10-dithering-opt-3"
                                                }
                                              })
                                            ]
                                          )
                                        })
                                      ),
                                      _vm._v(" "),
                                      _c("div", { staticClass: "hrm-clear" })
                                    ]
                                  )
                                : _c(
                                    "div",
                                    { staticClass: "hrm-content-wrap" },
                                    [
                                      _c(
                                        "label",
                                        { staticClass: "hrm-title" },
                                        [
                                          _vm._v(
                                            "\n\t\t                \t\t\t" +
                                              _vm._s(field.label) +
                                              "\n\t\t                \t\t\t\t\n\t\t                \t\t"
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c("div", {
                                        staticClass: "hrm-content",
                                        domProps: {
                                          innerHTML: _vm._s(
                                            _vm.filter(field.model, field)
                                          )
                                        }
                                      }),
                                      _vm._v(" "),
                                      _c("div", { staticClass: "hrm-clear" })
                                    ]
                                  )
                            }),
                            _vm._v(" "),
                            _vm.manageOrganization()
                              ? _c(
                                  "a",
                                  {
                                    staticClass:
                                      "button hrm-button-primary button-primary",
                                    attrs: { href: "#" },
                                    on: {
                                      click: function($event) {
                                        $event.preventDefault()
                                        _vm.update(true)
                                      }
                                    }
                                  },
                                  [_vm._v("Update")]
                                )
                              : _vm._e()
                          ],
                          2
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.editMode && _vm.manageOrganization()
                      ? _c(
                          "form",
                          {
                            attrs: {
                              id: "hrm-general-info-form",
                              action: "",
                              enctype: "multipart/form-data"
                            },
                            on: {
                              submit: function($event) {
                                $event.preventDefault()
                                _vm.selfSaveOrganizationalInfo()
                              }
                            }
                          },
                          [
                            _c("hrm-form-fields", {
                              attrs: { fields: _vm.fields }
                            }),
                            _vm._v(" "),
                            _c("input", {
                              staticClass:
                                "button hrm-button-primary button-primary",
                              attrs: { disabled: _vm.canSubmit, type: "submit" }
                            }),
                            _vm._v(" "),
                            _c(
                              "a",
                              {
                                staticClass:
                                  "button hrm-button-secondary button-secondary",
                                attrs: { href: "#" },
                                on: {
                                  click: function($event) {
                                    $event.preventDefault()
                                    _vm.update(false)
                                  }
                                }
                              },
                              [_vm._v("cancel")]
                            ),
                            _vm._v(" "),
                            _vm.loading
                              ? _c("div", { staticClass: "hrm-spinner" }, [
                                  _vm._v("Saving....")
                                ])
                              : _vm._e()
                          ],
                          1
                        )
                      : _vm._e()
                  ])
                ])
              : _vm._e()
          ])
        ]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-38646af4", esExports)
  }
}

/***/ }),

/***/ 541:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(414);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(2)("161f877d", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-38646af4\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./general-information.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-38646af4\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./general-information.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 76:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_general_information_vue__ = __webpack_require__(379);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_38646af4_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_general_information_vue__ = __webpack_require__(485);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(541)
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_general_information_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_38646af4_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_general_information_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/organization/general/general-information.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-38646af4", Component.options)
  } else {
    hotAPI.reload("data-v-38646af4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ })

});