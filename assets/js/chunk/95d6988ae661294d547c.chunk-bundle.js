wpSpearHrm([18],{

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

/***/ 298:
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

/***/ 354:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(141)(false);
// imports


// module
exports.push([module.i, "\n#hrm-hidden-form span {\n\tdisplay: block !important;\n}\n.multiselect__tags {\n\tdisplay: inline-block !important;\n\twidth: 100%;\n}\n.multiselect__input {\n\tborder: none !important;\n\tbox-shadow: none !important;\n}\n\n", ""]);

// exports


/***/ }),

/***/ 425:
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

/***/ 478:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(354);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(142)("5d2033e6", content, false, {});
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

/***/ 50:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_form_settings_vue__ = __webpack_require__(298);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4798389e_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_form_settings_vue__ = __webpack_require__(425);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(478)
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