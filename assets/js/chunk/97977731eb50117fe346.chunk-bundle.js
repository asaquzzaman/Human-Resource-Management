wpSpearHrm([23],{

/***/ 335:
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

/* harmony default export */ __webpack_exports__["a"] = ({
	mixins: [HRMMixin.profile],

	data() {
		return {
			editMode: false,
			isFetchRecord: false,
			fields: [{
				type: 'file',
				model: [],
				label: 'Profile Picture',
				name: '_hrm_user_image_id',
				editMode: false,
				multiple: false,
				deleted_files: [],
				attr: {
					height: '80px',
					width: '80px'
				},
				default: []
			}, {
				type: 'template',
				label: 'Department',
				model: '',
				name: 'department',
				default: '&#8211 &#8211'
			}, {
				type: 'radio',
				model: '',
				label: 'Gender',
				name: '_gender',
				editMode: false,
				default: '&#8211 &#8211',
				options: [{
					label: 'Male',
					value: 'male'
				}, {
					label: 'Female',
					value: 'female'
				}],
				filter(val) {
					if (val == 'male') {
						return 'Male';
					}
					if (val == 'female') {
						return 'Female';
					}
				}
			}, {
				type: 'radio',
				model: '',
				label: 'Marital Status',
				name: '_marital_status',
				editMode: false,
				options: [{
					label: 'Single',
					value: 'single'
				}, {
					label: 'Married',
					value: 'married'
				}],
				default: '&#8211 &#8211',
				filter(val) {
					if (val == 'single') {
						return 'Single';
					}
					if (val == 'married') {
						return 'Married';
					}
				}
			}, {
				type: 'text',
				model: '',
				label: 'Nationality',
				name: '_national_code',
				editMode: false,
				default: '&#8211 &#8211'
			}, {
				type: 'datePickerFrom',
				model: '',
				label: 'Birthday',
				name: '_birthday',
				editMode: false,
				default: '&#8211 &#8211',
				filter(val, self) {
					return self.dateFormat(val);
				}
			}, {
				type: 'text',
				model: '',
				label: 'Address Street 1',
				name: '_street1',
				editMode: false,
				default: '&#8211 &#8211'
			}, {
				type: 'text',
				model: '',
				label: 'Address Street 2',
				name: '_street2',
				editMode: false,
				default: '&#8211 &#8211'
			}, {
				type: 'text',
				model: '',
				label: 'City',
				name: '_city_code',
				editMode: false,
				default: '&#8211 &#8211'
			}, {
				type: 'text',
				model: '',
				label: 'State/Province',
				name: '_state',
				editMode: false,
				default: '&#8211 &#8211'
			}, {
				type: 'text',
				model: '',
				label: 'Zip/Postal Code',
				name: '_zip',
				editMode: false,
				default: '&#8211 &#8211'
			}, {
				type: 'text',
				model: '',
				label: 'Work Telephone',
				name: '_work_mobile',
				editMode: false,
				default: '&#8211 &#8211'
			}, {
				type: 'template',
				label: 'Email',
				model: '<b>joy.mishu@gmail.com</b>',
				name: 'email'
			}, {
				type: 'select',
				model: '',
				options: [],
				label: 'Country',
				optionLabel: 'country',
				placeholder: 'Select Country',
				name: '_country_code',
				editMode: false,
				default: '&#8211 &#8211',
				filter(val) {
					return val.country;
				}
			}],

			loading: false,
			canSubmit: false,
			record: {}
		};
	},

	created() {
		var self = this;
		var args = {
			employee_id: this.$route.params.employeeId,
			callback(info) {

				self.record = info;
				self.fields.forEach(function (field) {

					if (field.name == '_country_code') {
						field.options = info.country_list;
					}

					if (field.name == '_hrm_user_image_id') {
						field.default = info.default_profile_pic;
					}
				});

				self.afterGetRecored();
			}
		};
		this.getPersonalInfo(args);
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
		selfSavePersonalInfo() {
			var self = this;

			self.loading = true;
			self.canSubmit = true;

			var postData = this.generateFieldData(this.fields);

			var args = {
				data: postData,
				files: this.getFiles(this.fields),
				deleted_files: this.getDeletedFiles(this.fields),
				callback(res) {
					self.record = res;
					self.loading = false;
					self.canSubmit = false;
					self.editMode = false;
				}
			};

			this.savePersonalInfo(args);
		},

		getDeletedFiles(fields) {
			var deleted = [];

			fields.forEach(function (field) {
				if (field.type == 'file') {
					var newFile = {};

					newFile['name'] = field.name;
					newFile['files'] = field.deleted_files;

					deleted.push(newFile);
				}
			});

			return deleted;
		},

		getFiles(fields) {
			var files = [];

			fields.forEach(function (field) {

				if (field.type == 'file') {
					var newFile = {};

					newFile['name'] = field.name;
					newFile['files'] = [];
					newFile['multiple'] = field.multiple;

					field.model.forEach(function (fileObj) {
						if (fileObj.hasOwnProperty('lastModifiedDate')) {
							newFile['files'].push(fileObj);
						}
					});

					files.push(newFile);
				}
			});

			return files;
		},

		generateFieldData(data) {
			var formated = [];

			data.forEach(function (val) {
				if (val.type == 'template' || val.type == 'file') {
					return;
				}
				formated.push({
					'name': val.name,
					'value': val.model
				});
			});

			return formated;
		},

		savePersonalInfo(args) {
			var self = this;

			var data = new FormData();

			args.data.forEach(function (fieldObj) {
				data.set(fieldObj.name, JSON.stringify(fieldObj.value));
			});

			data.append('action', 'hrm_save_personal_info');

			args.deleted_files.map(function (del_file) {
				data.append('deleted_files[]', JSON.stringify(del_file));
			});

			args.files.forEach(function (fileObj) {
				var name = fileObj.name;
				data.append('is_multiple_file', fileObj.multiple);

				fileObj.files.forEach(function (attachment) {
					if (typeof attachment.attachment_id === 'undefined') {
						var decode = self.dataURLtoFile(attachment.thumb, attachment.name);

						data.append(name + '[]', decode);
					}
				});
			});

			var request_data = {
				data: data,
				type: 'POST',
				cache: false,
				contentType: false,
				processData: false,
				beforeSend() {
					self.loadingStart('hrm-personal-gnrl-info', { animationClass: 'preloader-update-animation' });
				},
				success: function (res) {
					self.$store.commit('profile/setPersonalInfo', res);
					if (typeof args.callback === 'function') {
						args.callback(res);
					}
					hrm.Toastr.success('Update successfully!');
					self.loadingStop('hrm-personal-gnrl-info');
				}
			};

			self.httpRequest('hrm_save_personal_info', request_data);
		}

	}
});

/***/ }),

/***/ 367:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(35)(false);
// imports


// module
exports.push([module.i, "\n.hrm-title, .hrm-content {\n\tfloat: left;\n}\n.hrm-content {\n\twidth: 65%;\n}\n.hrm-content-wrap {\n\tdisplay: block;\n\tmargin-bottom: 10px;\n\twidth: 100%;\n}\n", ""]);

// exports


/***/ }),

/***/ 441:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("profile-menu"),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "metabox-holder", attrs: { id: "hrm-general-info" } },
        [
          _vm.isFetchRecord
            ? _c(
                "div",
                {
                  staticClass: "postbox",
                  attrs: { id: "hrm-hidden-form-warp" }
                },
                [
                  _c("h2", { staticClass: "hndle" }, [
                    _vm._v("General Information")
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "inside" }, [
                    _c("div", { attrs: { id: "hrm-visible-form" } }, [
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
                                                "\n\t\t\t\t\t\t\t\t\t\tProfile Picture\n\t\t\t\t\t\t\t\t\t"
                                              )
                                            ]
                                          ),
                                          _vm._v(" "),
                                          field.model.length
                                            ? _c(
                                                "div",
                                                {
                                                  staticClass:
                                                    "hrm-uploaded-item"
                                                },
                                                _vm._l(field.model, function(
                                                  file
                                                ) {
                                                  return _c(
                                                    "a",
                                                    {
                                                      staticClass:
                                                        "hrm-uploaded-img",
                                                      attrs: {
                                                        href: file.url,
                                                        target: "_blank"
                                                      }
                                                    },
                                                    [
                                                      _c("img", {
                                                        staticClass:
                                                          "hrm-uploaded-file",
                                                        style: _vm.setStyle(
                                                          field
                                                        ),
                                                        attrs: {
                                                          src: file.thumb,
                                                          alt:
                                                            "10-dithering-opt-3"
                                                        }
                                                      })
                                                    ]
                                                  )
                                                })
                                              )
                                            : _vm._e(),
                                          _vm._v(" "),
                                          _vm._l(field.default, function(file) {
                                            return !field.model.length
                                              ? _c(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "hrm-uploaded-item"
                                                  },
                                                  [
                                                    _c("img", {
                                                      staticClass:
                                                        "hrm-uploaded-file",
                                                      style: _vm.setStyle(
                                                        field
                                                      ),
                                                      attrs: {
                                                        src: file.url,
                                                        alt: file.name
                                                      }
                                                    })
                                                  ]
                                                )
                                              : _vm._e()
                                          }),
                                          _vm._v(" "),
                                          _c("div", {
                                            staticClass: "hrm-clear"
                                          })
                                        ],
                                        2
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
                                                "\n\t\t\t                \t\t\t" +
                                                  _vm._s(field.label) +
                                                  "\n\t\t\t                \t\t\t\t\n\t\t\t                \t\t"
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
                                          _c("div", {
                                            staticClass: "hrm-clear"
                                          })
                                        ]
                                      )
                                }),
                                _vm._v(" "),
                                _c(
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
                              ],
                              2
                            )
                          : _vm._e(),
                        _vm._v(" "),
                        _vm.editMode
                          ? _c(
                              "form",
                              {
                                attrs: {
                                  id: "hrm-personal-gnrl-info",
                                  action: "",
                                  enctype: "multipart/form-data"
                                },
                                on: {
                                  submit: function($event) {
                                    $event.preventDefault()
                                    _vm.selfSavePersonalInfo()
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
                                  attrs: {
                                    disabled: _vm.canSubmit,
                                    type: "submit"
                                  }
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
                  ])
                ]
              )
            : _vm._e()
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
    require("vue-hot-reload-api")      .rerender("data-v-59f72ef5", esExports)
  }
}

/***/ }),

/***/ 494:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(367);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(36)("6acdb394", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-59f72ef5\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./personal-information.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-59f72ef5\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./personal-information.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 65:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_personal_information_vue__ = __webpack_require__(335);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_59f72ef5_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_personal_information_vue__ = __webpack_require__(441);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(494)
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_personal_information_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_59f72ef5_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_personal_information_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/profile/personal-information.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-59f72ef5", Component.options)
  } else {
    hotAPI.reload("data-v-59f72ef5", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ })

});