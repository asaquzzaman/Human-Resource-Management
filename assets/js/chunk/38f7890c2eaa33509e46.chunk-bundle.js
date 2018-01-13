wpSpearHrm([9],{

/***/ 215:
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

/***/ 239:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(67)(false);
// imports


// module
exports.push([module.i, "\n.hrm-image, .hrm-employee-name {\n\t\tfloat: left;\n}\n.hrm-employee-name  {\n\t\twidth: 60%;\n    \tmargin-left: 5px;\n    \tmargin-top: -3px;\n    \tword-wrap: break-word;\n}\n.hrm-td-content, .leave-action-wrap {\n\t\tdisplay: block;\n}\n.leave-action-wrap {\n\t\theight: 5px;\n\t\tmargin-top: 5px;\n\t\tmargin-bottom: 10px;\n}\n.hrm-employee-name {\n\t\tfont-weight: 600;\n}\n.leave-action {\n\t\tfont-size: 12px;\n\t\tdisplay: none;\n}\n.leave-action-tr:hover .leave-action {\n\t\tdisplay: block;\n}\n", ""]);

// exports


/***/ }),

/***/ 282:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "hrm-leave" }, [
    _c("div", { staticClass: "metabox-holder hrm-leave-type-records-wrap" }, [
      _c("table", { staticClass: "wp-list-table widefat fixed striped" }, [
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
                        _vm._v(_vm._s(pendingLeave.employee.data.display_name))
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
                      _vm._s(_vm.dateFormat(pendingLeave.apply_at.date)) +
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
                  _vm._v(_vm._s(_vm.dateFormat(pendingLeave.start_time)))
                ]),
                _vm._v(" "),
                _c("td", [
                  _vm._v(_vm._s(_vm.dateFormat(pendingLeave.end_time)))
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
                              _vm.selfUpdateLeaveStatus(pendingLeave, 1)
                            }
                          }
                        },
                        [
                          _c("i", {
                            staticClass: "fa fa-undo",
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
                            staticClass: "fa fa-trash-o",
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
              ])
            }),
            _vm._v(" "),
            !_vm.pendingLeaves.length
              ? _c("tr", [
                  _c("td", { attrs: { colspan: "7" } }, [
                    _vm._v("No record found!")
                  ])
                ])
              : _vm._e()
          ],
          2
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
    return _c("thead", [
      _c("th", [_vm._v("Employee")]),
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
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-529c80fe", esExports)
  }
}

/***/ }),

/***/ 29:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_cancel_vue__ = __webpack_require__(215);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_529c80fe_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_cancel_vue__ = __webpack_require__(282);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(306)
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_529c80fe_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_leave_cancel_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/leave/leave-cancel.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-529c80fe", Component.options)
  } else {
    hotAPI.reload("data-v-529c80fe", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 306:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(239);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(68)("67148dfc", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-529c80fe\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-cancel.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-529c80fe\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-cancel.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 67:
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

/***/ 68:
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

var listToStyles = __webpack_require__(69)

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

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction) {
  isProduction = _isProduction

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
  var styleElement = document.querySelector('style[data-vue-ssr-id~="' + obj.id + '"]')

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

/***/ 69:
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


/***/ })

});