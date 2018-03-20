wpSpearHrm([16],{

/***/ 141:
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function(useSourceMap) {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		return this.map(function (item) {
			var content = cssWithMappingToString(item, useSourceMap);
			if(item[2]) {
				return "@media " + item[2] + "{" + content + "}";
			} else {
				return content;
			}
		}).join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};

function cssWithMappingToString(item, useSourceMap) {
	var content = item[1] || '';
	var cssMapping = item[3];
	if (!cssMapping) {
		return content;
	}

	if (useSourceMap && typeof btoa === 'function') {
		var sourceMapping = toComment(cssMapping);
		var sourceURLs = cssMapping.sources.map(function (source) {
			return '/*# sourceURL=' + cssMapping.sourceRoot + source + ' */'
		});

		return [content].concat(sourceURLs).concat([sourceMapping]).join('\n');
	}

	return [content].join('\n');
}

// Adapted from convert-source-map (MIT)
function toComment(sourceMap) {
	// eslint-disable-next-line no-undef
	var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));
	var data = 'sourceMappingURL=data:application/json;charset=utf-8;base64,' + base64;

	return '/*# ' + data + ' */';
}


/***/ }),

/***/ 142:
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__(143)

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}
var options = null
var ssrIdKey = 'data-vue-ssr-id'

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction, _options) {
  isProduction = _isProduction

  options = _options || {}

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[' + ssrIdKey + '~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }
  if (options.ssrId) {
    styleElement.setAttribute(ssrIdKey, obj.id)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),

/***/ 143:
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


/***/ }),

/***/ 316:
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
				success: function (res) {
					// self.$store.commit('general/setOrganizationInfo', res.data);
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
				success: function (res) {
					//self.$store.commit('profile/setPersonalInfo', res);
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

/***/ 351:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(141)(false);
// imports


// module
exports.push([module.i, "\n.hrm-title, .hrm-content {\n\tfloat: left;\n}\n.hrm-content {\n\twidth: 65%;\n}\n.hrm-content-wrap {\n\tdisplay: block;\n\tmargin-bottom: 10px;\n\twidth: 100%;\n}\n", ""]);

// exports


/***/ }),

/***/ 420:
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
            _c("div", { staticClass: "inside" }, [
              _c("div", { staticClass: "main" }, [
                !_vm.editMode
                  ? _c(
                      "div",
                      [
                        _vm._l(_vm.fields, function(field, index) {
                          return field.type == "file"
                            ? _c(
                                "div",
                                { key: index, staticClass: "hrm-content-wrap" },
                                [
                                  _c("label", { staticClass: "hrm-title" }, [
                                    _vm._v(
                                      "\n\t\t\t\t\t\t\t\t\tProfile Picture\n\t\t\t\t\t\t\t\t"
                                    )
                                  ]),
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
                                            staticClass: "hrm-uploaded-file",
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
                            : _c("div", { staticClass: "hrm-content-wrap" }, [
                                _c("label", { staticClass: "hrm-title" }, [
                                  _vm._v(
                                    "\n\t\t                \t\t\t" +
                                      _vm._s(field.label) +
                                      "\n\t\t                \t\t\t\t\n\t\t                \t\t"
                                  )
                                ]),
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
                              ])
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
                        attrs: { action: "", enctype: "multipart/form-data" },
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

/***/ 475:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(351);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(142)("161f877d", content, false, {});
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

/***/ 57:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_general_information_vue__ = __webpack_require__(316);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_38646af4_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_general_information_vue__ = __webpack_require__(420);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(475)
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