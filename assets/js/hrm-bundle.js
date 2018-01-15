/******/ (function(modules) { // webpackBootstrap
/******/ 	// install a JSONP callback for chunk loading
/******/ 	var parentJsonpFunction = window["wpSpearHrm"];
/******/ 	window["wpSpearHrm"] = function webpackJsonpCallback(chunkIds, moreModules, executeModules) {
/******/ 		// add "moreModules" to the modules object,
/******/ 		// then flag all "chunkIds" as loaded and fire callback
/******/ 		var moduleId, chunkId, i = 0, resolves = [], result;
/******/ 		for(;i < chunkIds.length; i++) {
/******/ 			chunkId = chunkIds[i];
/******/ 			if(installedChunks[chunkId]) {
/******/ 				resolves.push(installedChunks[chunkId][0]);
/******/ 			}
/******/ 			installedChunks[chunkId] = 0;
/******/ 		}
/******/ 		for(moduleId in moreModules) {
/******/ 			if(Object.prototype.hasOwnProperty.call(moreModules, moduleId)) {
/******/ 				modules[moduleId] = moreModules[moduleId];
/******/ 			}
/******/ 		}
/******/ 		if(parentJsonpFunction) parentJsonpFunction(chunkIds, moreModules, executeModules);
/******/ 		while(resolves.length) {
/******/ 			resolves.shift()();
/******/ 		}
/******/
/******/ 	};
/******/
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// objects to store loaded and loading chunks
/******/ 	var installedChunks = {
/******/ 		27: 0
/******/ 	};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/ 	// This file contains only the entry chunk.
/******/ 	// The chunk loading function for additional chunks
/******/ 	__webpack_require__.e = function requireEnsure(chunkId) {
/******/ 		var installedChunkData = installedChunks[chunkId];
/******/ 		if(installedChunkData === 0) {
/******/ 			return new Promise(function(resolve) { resolve(); });
/******/ 		}
/******/
/******/ 		// a Promise means "currently loading".
/******/ 		if(installedChunkData) {
/******/ 			return installedChunkData[2];
/******/ 		}
/******/
/******/ 		// setup Promise in chunk cache
/******/ 		var promise = new Promise(function(resolve, reject) {
/******/ 			installedChunkData = installedChunks[chunkId] = [resolve, reject];
/******/ 		});
/******/ 		installedChunkData[2] = promise;
/******/
/******/ 		// start chunk loading
/******/ 		var head = document.getElementsByTagName('head')[0];
/******/ 		var script = document.createElement('script');
/******/ 		script.type = 'text/javascript';
/******/ 		script.charset = 'utf-8';
/******/ 		script.async = true;
/******/ 		script.timeout = 120000;
/******/
/******/ 		if (__webpack_require__.nc) {
/******/ 			script.setAttribute("nonce", __webpack_require__.nc);
/******/ 		}
/******/ 		script.src = __webpack_require__.p + "chunk/" + {"2":"e78c8fbdeb53812cb0d2","3":"7450dc88db21a7dd1b01","4":"bab92c8371e6cbd83d90","5":"acdbbc0e0cec7a652512","6":"e1d41f6acd118508578f","11":"cb396e2dd8ba082f8501"}[chunkId] + ".chunk-bundle.js";
/******/ 		var timeout = setTimeout(onScriptComplete, 120000);
/******/ 		script.onerror = script.onload = onScriptComplete;
/******/ 		function onScriptComplete() {
/******/ 			// avoid mem leaks in IE.
/******/ 			script.onerror = script.onload = null;
/******/ 			clearTimeout(timeout);
/******/ 			var chunk = installedChunks[chunkId];
/******/ 			if(chunk !== 0) {
/******/ 				if(chunk) {
/******/ 					chunk[1](new Error('Loading chunk ' + chunkId + ' failed.'));
/******/ 				}
/******/ 				installedChunks[chunkId] = undefined;
/******/ 			}
/******/ 		};
/******/ 		head.appendChild(script);
/******/
/******/ 		return promise;
/******/ 	};
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// on error function for async loading
/******/ 	__webpack_require__.oe = function(err) { console.error(err); throw err; };
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 58);
/******/ })
/************************************************************************/
/******/ ({

/***/ 0:
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ 12:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });

/* harmony default export */ __webpack_exports__["default"] = ({
	methods: {
		updateSettings(args) {
			var request = {
				data: args.data,
				success(res) {
					if (typeof args.callback === 'function') {
						args.callback(res);
					}
				}
			};

			this.httpRequest('update_settings', request);
		},

		getSettings(key, pre_define) {
			var pre_define = pre_define || false,
			    settings = HRM_Vars.settings;

			if (!HRM_Vars.settings[key]) {
				return pre_define;
			}

			return HRM_Vars.settings[key];
		}
	}
});

/***/ }),

/***/ 13:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixin__ = __webpack_require__(12);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__settings_vue__ = __webpack_require__(64);
HRMRegisterModule('settings', 'settings');



HRMMixin.settings = __WEBPACK_IMPORTED_MODULE_0__mixin__["default"];



const Hrm_Settings = resolve => {

	__webpack_require__.e/* require.ensure */(11).then((() => {
		resolve(__webpack_require__(40));
	}).bind(null, __webpack_require__)).catch(__webpack_require__.oe);
};

let settingsMenu = [{
	path: 'settings',
	component: __WEBPACK_IMPORTED_MODULE_1__settings_vue__["a" /* default */],
	name: 'hrm_setting',

	children: HRMGetRegisterChildrenRoute('hrm_setting', [{
		path: 'general',
		component: Hrm_Settings,
		name: 'hrm_general_settings',
		meta: {
			label: 'General'
		}
	}])

}];

if (hrm_user_can('manage_settings')) {
	HRMRegisterChildrenRoute('hrm_root', settingsMenu);
}

/* harmony default export */ __webpack_exports__["a"] = (settingsMenu);

/***/ }),

/***/ 14:
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


/* harmony default export */ __webpack_exports__["a"] = ({
    created() {

        this.registerModule();
    },
    methods: {
        registerModule() {
            let self = this;

            HRMModules.forEach(function (module) {

                let mixin = __webpack_require__(43)("./" + module.path + '/mixin.js');
                let store = __webpack_require__(44)("./" + module.path + '/store.js');
                HRMMixin[module.name] = mixin.default;

                self.registerStore(module.name, store.default);
            });

            HRM_Store.forEach(function (store) {
                var state = store.store.state;
                var mutations = store.store.mutations;

                self.$store.registerModule(store.name, {
                    namespaced: true,
                    state,
                    mutations
                });
            });
        }
    }

});

/***/ }),

/***/ 15:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";


function HRMGetComponents() {
    var components = {};

    HRM_Components.map(function (obj, key) {
        if (obj.property.mixins) {
            obj.property.mixins.push(mixin);
        }

        components[obj.component] = obj.property;
    });

    return components;
}

var action = {
    props: {
        hook: {
            type: String,
            required: true
        },

        actionData: {
            type: [Object, Array, String, Number],

            default: function () {
                return {};
            }
        }
    },

    components: HRMGetComponents(),

    render(h) {
        this.$options.components = HRMGetComponents();

        var components = [],
            self = this;

        HRM_Components.map(function (obj, key) {
            if (obj.hook == self.hook) {
                components.push(hrm.Vue.compile('<' + obj.component + ' :actionData="actionData"></' + obj.component + '>').render.call(self));
            }
        });

        return h('span', {}, components);
    }
};

/* harmony default export */ __webpack_exports__["a"] = (action);

/***/ }),

/***/ 16:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//

/* harmony default export */ __webpack_exports__["a"] = ({});

/***/ }),

/***/ 17:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__router__ = __webpack_require__(13);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



var Hrm_Settings_Header = {
    mixins: [HRMMixin.settings],

    data: function () {
        return {
            menu: __WEBPACK_IMPORTED_MODULE_0__router__["a" /* default */]
        };
    },

    methods: {
        childrens() {
            let root_menu = this.$route.matched[1].name;

            let index = this.getIndex(this.menu[0].children, root_menu, 'name');

            if (index === false) {
                return [];
            }

            if (this.menu[0].children[index].hasOwnProperty('children')) {
                if (this.menu[0].children[index].children.length) {
                    return this.menu[0].children[index].children;
                }
            } else {
                return [];
            }
        },
        is_it_child: function () {

            if (this.$route.matched.length > 1) {
                return true;
            }
        },
        has_child_menu: function () {
            var path = this.$route.path,
                has_submenu = false;

            jQuery.each(this.header, function (key, val) {

                if (val.url == path) {
                    if (typeof val.submenu != 'undefined' && jQuery(val.submenu).length) {
                        has_submenu = true;
                    }
                }
            });

            return has_submenu;
        },
        get_child_menu: function () {
            var path = this.$route.path,
                submenu = [];

            if (this.is_it_child()) {
                var partent_name = this.$route.matched[0].name;

                jQuery.each(this.header, function (key, val) {
                    if (val.name == partent_name) {
                        if (typeof val.submenu != 'undefined' && jQuery(val.submenu).length) {
                            submenu = val.submenu;
                        }
                    }
                });

                return submenu;
            }

            jQuery.each(this.header, function (key, val) {
                if (val.url == path) {
                    if (typeof val.submenu != 'undefined' && jQuery(val.submenu).length) {
                        submenu = val.submenu;
                    }
                }
            });

            return submenu;
        }
    }
};

/* harmony default export */ __webpack_exports__["a"] = (Hrm_Settings_Header);

/***/ }),

/***/ 18:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//

/* harmony default export */ __webpack_exports__["a"] = ({
	created() {
		if (this.$route.name === 'hrm_setting') {
			this.$router.push({
				name: 'hrm_general_settings'
			});
		};
	}
});

/***/ }),

/***/ 19:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__store_store__ = __webpack_require__(59);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__router_router__ = __webpack_require__(57);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__helpers_mixin__ = __webpack_require__(56);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__directives_directives__ = __webpack_require__(53);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__directives_directives___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__directives_directives__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__helpers_common_components__ = __webpack_require__(54);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__App_vue__ = __webpack_require__(61);
__webpack_require__.p = HRM_Vars.hrm_url + '/assets/js/';








var wpspear_hrm = {
	el: '#wpspear-hrm',
	store: __WEBPACK_IMPORTED_MODULE_0__store_store__["a" /* default */],
	router: __WEBPACK_IMPORTED_MODULE_1__router_router__["a" /* default */],
	render: h => h(__WEBPACK_IMPORTED_MODULE_5__App_vue__["a" /* default */])
};

new hrm.Vue(wpspear_hrm);

/***/ }),

/***/ 208:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//

/* harmony default export */ __webpack_exports__["a"] = ({
    props: ['value', 'dependency'],
    mounted: function () {
        var self = this,
            limit_date = self.dependency == 'pm-datepickter-from' ? "minDate" : "maxDate";

        jQuery(self.$el).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                jQuery("." + self.dependency).datepicker("option", limit_date, selectedDate);
            },
            onSelect: function (dateText) {
                self.$emit('input', dateText);
            }
        });
    }
});

/***/ }),

/***/ 254:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_date_picker_vue__ = __webpack_require__(208);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_fbe01182_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_date_picker_vue__ = __webpack_require__(305);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_date_picker_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_fbe01182_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_date_picker_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/common/date-picker.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-fbe01182", Component.options)
  } else {
    hotAPI.reload("data-v-fbe01182", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 305:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("input", {
    attrs: { type: "text" },
    domProps: { value: _vm.value }
  })
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-fbe01182", esExports)
  }
}

/***/ }),

/***/ 320:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony default export */ __webpack_exports__["default"] = ({
	state: {},

	mutations: {}
});

/***/ }),

/***/ 321:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony default export */ __webpack_exports__["default"] = ({
	methods: {}
});

/***/ }),

/***/ 326:
/***/ (function(module, exports, __webpack_require__) {


HRMRegisterModule('profile', 'profile');

let personalInformation = resolve => {

    __webpack_require__.e/* require.ensure */(4).then((() => {
        resolve(__webpack_require__(323));
    }).bind(null, __webpack_require__)).catch(__webpack_require__.oe);
};

let jobLocation = resolve => {

    __webpack_require__.e/* require.ensure */(6).then((() => {
        resolve(__webpack_require__(335));
    }).bind(null, __webpack_require__)).catch(__webpack_require__.oe);
};

let workExperiance = resolve => {

    __webpack_require__.e/* require.ensure */(2).then((() => {
        resolve(__webpack_require__(325));
    }).bind(null, __webpack_require__)).catch(__webpack_require__.oe);
};

let education = resolve => {

    __webpack_require__.e/* require.ensure */(5).then((() => {
        resolve(__webpack_require__(322));
    }).bind(null, __webpack_require__)).catch(__webpack_require__.oe);
};

let skill = resolve => {

    __webpack_require__.e/* require.ensure */(3).then((() => {
        resolve(__webpack_require__(324));
    }).bind(null, __webpack_require__)).catch(__webpack_require__.oe);
};

HRMRegisterChildrenRoute('hrm_root', [{
    path: 'personal-information',
    component: personalInformation,
    name: 'personal_information'
}, {
    path: 'job-location',
    component: jobLocation,
    name: 'job_location'
}, {
    path: 'work-experiance',
    component: workExperiance,
    name: 'work_experiance'
}, {
    path: 'education',
    component: education,
    name: 'education'
}, {
    path: 'skill',
    component: skill,
    name: 'skill'
}]);

/***/ }),

/***/ 338:
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

/* harmony default export */ __webpack_exports__["a"] = ({
	props: {
		fields: {
			type: [Array],
			default() {
				return [];
			}
		}
	}
});

/***/ }),

/***/ 339:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_form_fields_vue__ = __webpack_require__(338);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_68925914_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_form_fields_vue__ = __webpack_require__(340);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_form_fields_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_68925914_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_form_fields_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/common/form-fields.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-68925914", Component.options)
  } else {
    hotAPI.reload("data-v-68925914", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 340:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    _vm._l(_vm.fields, function(field, field_index) {
      return _c("div", { staticClass: "hrm-form-field " }, [
        field.type == "text"
          ? _c("div", [
              _c("label", { attrs: { for: "title" } }, [
                _vm._v("\n\t                " + _vm._s(field.label)),
                _c("em", [_vm._v("*")])
              ]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: field.model,
                    expression: "field.model"
                  }
                ],
                attrs: { type: "text" },
                domProps: { value: field.model },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(field, "model", $event.target.value)
                  }
                }
              }),
              _vm._v(" "),
              _c("span", { staticClass: "hrm-clear" }),
              _vm._v(" "),
              _c("span", { staticClass: "description" })
            ])
          : _vm._e(),
        _vm._v(" "),
        field.type == "date-picker-from"
          ? _c(
              "div",
              [
                _c("label", { attrs: { for: "title" } }, [
                  _vm._v(
                    "\n\t                " +
                      _vm._s(field.label) +
                      "\n\t            "
                  )
                ]),
                _vm._v(" "),
                _c("hrm-date-picker", {
                  staticClass: "pm-datepickter-to",
                  attrs: {
                    placeholder: "From",
                    dependency: "pm-datepickter-from"
                  },
                  model: {
                    value: field.model,
                    callback: function($$v) {
                      _vm.$set(field, "model", $$v)
                    },
                    expression: "field.model"
                  }
                }),
                _vm._v(" "),
                _c("span", { staticClass: "hrm-clear" }),
                _vm._v(" "),
                _c("span", { staticClass: "description" })
              ],
              1
            )
          : _vm._e(),
        _vm._v(" "),
        field.type == "date-picker-to"
          ? _c(
              "div",
              [
                _c("label", { attrs: { for: "title" } }, [
                  _vm._v(
                    "\n\t                " +
                      _vm._s(field.label) +
                      "\n\t            "
                  )
                ]),
                _vm._v(" "),
                _c("hrm-date-picker", {
                  staticClass: "pm-datepickter-to",
                  attrs: {
                    placeholder: "To",
                    dependency: "pm-datepickter-from"
                  },
                  model: {
                    value: field.model,
                    callback: function($$v) {
                      _vm.$set(field, "model", $$v)
                    },
                    expression: "field.model"
                  }
                }),
                _vm._v(" "),
                _c("span", { staticClass: "hrm-clear" }),
                _vm._v(" "),
                _c("span", { staticClass: "description" })
              ],
              1
            )
          : _vm._e(),
        _vm._v(" "),
        field.type == "textarea"
          ? _c("div", [
              _c("label", { attrs: { for: "description" } }, [
                _vm._v("\n\t\t\t\t\t" + _vm._s(field.label) + "\n\t\t\t\t")
              ]),
              _vm._v(" "),
              _c("textarea", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: field.model,
                    expression: "field.model"
                  }
                ],
                staticClass: "hrm-des-field",
                attrs: { name: "description", id: "description" },
                domProps: { value: field.model },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(field, "model", $event.target.value)
                  }
                }
              }),
              _vm._v(" "),
              _c("span", { staticClass: "hrm-clear" }),
              _vm._v(" "),
              _c("span", { staticClass: "description" })
            ])
          : _vm._e()
      ])
    })
  )
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-68925914", esExports)
  }
}

/***/ }),

/***/ 41:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_header_vue__ = __webpack_require__(17);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6a880113_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_header_vue__ = __webpack_require__(67);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_header_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6a880113_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_header_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/settings/header.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6a880113", Component.options)
  } else {
    hotAPI.reload("data-v-6a880113", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 43:
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"./attendance/mixin.js": 45,
	"./departments/mixin.js": 47,
	"./leave/mixin.js": 50,
	"./profile/mixin.js": 321,
	"./settings/mixin.js": 12
};
function webpackContext(req) {
	return __webpack_require__(webpackContextResolve(req));
};
function webpackContextResolve(req) {
	var id = map[req];
	if(!(id + 1)) // check for number or string
		throw new Error("Cannot find module '" + req + "'.");
	return id;
};
webpackContext.keys = function webpackContextKeys() {
	return Object.keys(map);
};
webpackContext.resolve = webpackContextResolve;
module.exports = webpackContext;
webpackContext.id = 43;

/***/ }),

/***/ 44:
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"./attendance/store.js": 46,
	"./departments/store.js": 49,
	"./leave/store.js": 51,
	"./profile/store.js": 320,
	"./settings/store.js": 52
};
function webpackContext(req) {
	return __webpack_require__(webpackContextResolve(req));
};
function webpackContextResolve(req) {
	var id = map[req];
	if(!(id + 1)) // check for number or string
		throw new Error("Cannot find module '" + req + "'.");
	return id;
};
webpackContext.keys = function webpackContextKeys() {
	return Object.keys(map);
};
webpackContext.resolve = webpackContextResolve;
module.exports = webpackContext;
webpackContext.id = 44;

/***/ }),

/***/ 45:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony default export */ __webpack_exports__["default"] = ({
    methods: {
        getAttendance: function () {

            var request_data = {
                _wpnonce: HRM_Vars.nonce,
                search: this.$route.query
            },
                self = this;

            wp.ajax.send('get_attendance', {
                data: request_data,
                success: function (res) {

                    self.$store.commit('attendance/setAttendance', {
                        records: res.attendance,
                        punch_in_formated_date: res.punch_in_formated_date,
                        punch_out_formated_date: res.punch_out_formated_date,
                        punch_in_date: res.punch_in_date,
                        punch_out_date: res.punch_out_date,
                        totalOfficeTime: res.total_time

                    });
                },

                error: function (res) {}
            });
        }
    }
});

/***/ }),

/***/ 46:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony default export */ __webpack_exports__["default"] = ({
	state: {
		attendance: [],
		search_mode: false,
		punch_in_date: '',
		punch_out_date: '',
		search_user_id: '-1',
		punch_in_status: 'disable',
		punch_in_formated_date: '',
		punch_out_formated_date: '',
		hrm_is_multi_attendance: 0,
		office_start: '',
		office_closed: '',
		office_start_with_date_time: '',
		office_closed_with_date_time: '',
		allow_ip: '',
		employessDropDown: [],
		totalOfficeTime: 0
	},

	mutations: {
		setInitVal: function (state, res) {
			state.punch_out_date = res.punch_out_date;
			state.punch_in_date = res.punch_in_date;
			//state.search_user_id               = res.search_user_id;
			state.punch_in_status = res.punch_in;
			state.punch_in_formated_date = res.punch_in_formated_date;
			state.punch_out_formated_date = res.punch_out_formated_date;
			state.hrm_is_multi_attendance = res.hrm_is_multi_attendance;
			state.office_start = res.office_start;
			state.office_closed = res.office_closed;
			state.office_start_with_date_time = res.office_start_with_date_time;
			state.office_closed_with_date_time = res.office_closed_with_date_time;
			state.employessDropDown = res.employees_dropdown;
			state.allow_ip = res.allow_ip;
		},
		setAttendance: function (state, records) {

			state.attendance = records.records;
			state.totalOfficeTime = records.totalOfficeTime;

			if (typeof records.punch_in_formated_date != 'undefined') {
				state.punch_in_formated_date = records.punch_in_formated_date;
				state.punch_out_formated_date = records.punch_out_formated_date;
				state.punch_in_date = records.punch_in_date, state.punch_out_date = records.punch_out_date;
			}
		},

		searchMode: function (state, search) {
			state.search_mode = search.status;
		},
		setPunchInDate: function (state, date) {
			state.punch_in_date = date.date.date;
		},
		setPunchOutDate: function (state, date) {
			state.punch_out_date = date.date.date;
		},
		setSearchUserId: function (state, user_id) {
			state.search_user_id = user_id;
		},
		office_start: function (state, date_time) {
			state.office_start_with_date_time = date_time.date_time;
		},
		office_closed: function (state, date_time) {
			state.office_closed_with_date_time = date_time.date_time;
		},
		setMultiAttendance: function (state, multi) {
			state.hrm_is_multi_attendance = multi;
		},
		punch_in: function (state, status) {
			state.punch_in_status = status.status;
		},
		setAllowIP: function (state, ip) {
			state.allow_ip = ip;
		}
	}
});

/***/ }),

/***/ 47:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony default export */ __webpack_exports__["default"] = ({
    methods: {
        showHideDepartmentForm(status, department) {
            var department = department || false,
                department = jQuery.isEmptyObject(department) ? false : department;

            if (department) {
                if (status === 'toggle') {
                    department.edit_mode = department.edit_mode ? false : true;
                } else {
                    department.edit_mode = status;
                }
            } else {
                this.$store.commit('departments/showHideDepartmentForm', status);
            }
        },

        manageDepartment() {
            return hrm_user_can('manage_department');
        }

    }
});

/***/ }),

/***/ 49:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony default export */ __webpack_exports__["default"] = ({
	state: {
		is_department_form_active: false,
		departments: [],
		department_id: false,
		del_dept: [],
		dept_pagination: {
			total: 0,
			limit: 5,
			page_number: 1
		},
		dept_drop_down: []
	},

	mutations: {
		showHideDepartmentForm: function (state, status) {
			if (status === 'toggle') {
				state.is_department_form_active = state.is_department_form_active ? false : true;
			} else {
				state.is_department_form_active = status;
			}
		},

		setDepartments: function (state, departments) {
			state.departments = departments.departments;
			state.dept_pagination.total = departments.total_dept;
			state.dept_drop_down = departments.dept_drop_down;
		},

		department_edit_id: function (state, department) {
			state.department_id = department.department_id;
		},

		updateDepartment: function (state, department) {
			if (department.is_update) {
				state.departments = department.departments;
			} else {
				state.departments = department.departments;
			}

			state.dept_drop_down = department.dept_drop_down;
		},

		departmentDelId: function (state, del_dept) {
			state.del_dept = del_dept.del_dept;
		},
		afterDeleteDept: function (state, deleted_dept) {
			state.departments.splice(deleted_dept.target_del_dept, 1);
			state.dept_drop_down = deleted_dept.dept_drop_down;
		}
	}
});

/***/ }),

/***/ 50:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony default export */ __webpack_exports__["default"] = ({
    methods: {
        employeeLeaveSummery(args) {
            var self = this;
            var pre_define = {};

            var data = jQuery.extend(true, pre_define, args.data);

            var request_data = {
                data: { employee_id: data.employee_id },
                success(res) {

                    self.$store.commit('leave/afterEmployeeLeaveSummery', {
                        res: res,
                        row_id: data.row_id,
                        type: data.type
                    });

                    if (typeof args.callback === 'function') {
                        args.callback(res);
                    }
                }
            };

            self.httpRequest('get_employee_leave_summery', request_data);
        },
        processRoles(role_object) {
            var roles = [];
            jQuery.each(role_object, function (id, name) {
                roles.push({
                    id: id,
                    name: name
                });
            });

            return roles;
        },
        processLeaveTypes(settings, roles) {
            if (!settings) {
                return [];
            }
            settings.leave_types = settings.leave_types || [];

            var leave_types = [];

            jQuery.each(roles, function (id, name) {
                if (settings.leave_types.indexOf(id) !== -1) {
                    leave_types.push({
                        id: id,
                        name: name
                    });
                }
            });

            return leave_types;
        },
        showHideLeaveRecordsForm(status, leave) {
            var leave = leave || false,
                leave = jQuery.isEmptyObject(leave) ? false : leave;

            if (leave) {
                if (status === 'toggle') {
                    leave.edit_mode = leave.edit_mode ? false : true;
                } else {
                    leave.edit_mode = status;
                }
            } else {
                this.$store.commit('leave/showHideleaveForm', status);
            }
        },

        showHideLeaveTypeUpdateForm(status, type) {
            var type = type || false,
                type = jQuery.isEmptyObject(type) ? false : type;

            if (type) {
                if (status === 'toggle') {
                    type.editMode = type.editMode ? false : true;
                } else {
                    type.editMode = status;
                }
            }
        },

        showHideHolidayUpdateForm(status, holiday) {
            var holiday = holiday || false,
                holiday = jQuery.isEmptyObject(holiday) ? false : holiday;

            if (holiday) {
                if (status === 'toggle') {
                    holiday.editMode = holiday.editMode ? false : true;
                } else {
                    holiday.editMode = status;
                }
            }
        },

        getLeaveRecords(args) {
            var self = this;
            var pre_define = {};

            var data = jQuery.extend(true, pre_define, args.data);

            var request_data = {
                data: data,
                success(res) {
                    res.data.forEach(function (leave) {
                        self.setLeaveRecoredsMeta(leave);
                    });

                    self.$store.commit('leave/getLeaveRecords', res);

                    if (typeof args.callback === 'function') {
                        args.callback(res);
                    }
                }
            };

            self.httpRequest('get_leaves', request_data);
        },

        setLeaveRecoredsMeta(leave) {
            leave.metaSummery = [];
            leave.metaSummeryDisplay = false;
        },

        updateLeave(args) {
            if (this.is_leave_btn_disable) {
                return false;
            }

            var self = this;

            var form_data = {
                data: args.data,

                beforSend: function (xhr) {
                    self.show_spinner = true;
                    self.is_leave_btn_disable = true;
                },

                success: function (res) {
                    self.show_spinner = false;
                    // Display a success toast, with a title
                    //toastr.success(res.success);

                    if (typeof args.callback === 'function') {
                        args.callback(res.data);
                    }
                },

                error: function (res) {
                    self.show_spinner = false;
                    // Showing error
                    res.error.map(function (value, index) {
                        toastr.error(value);
                    });
                }
            };

            this.httpRequest('update_leave', form_data);
        },

        updateLeaveStatus(pendingLeave, status) {
            var self = this;

            var args = {
                data: {
                    id: pendingLeave.id,
                    status: status,
                    class: 'Leave',
                    method: 'update'
                },

                callback: function (res) {}
            };

            self.updateLeave(args);
        },

        deleteLeave(args) {
            if (!confirm('Are you sure')) {
                return;
            }
            var self = this;

            var request_data = {
                data: {
                    leave_id: args.data.leave_id
                },
                success: function (res) {
                    self.$store.commit('leave/afterDeleteLeave', args.data.leave_id);

                    if (typeof args.callback === 'function') {
                        args.callback();
                    }
                }
            };

            self.httpRequest('delete_leave', request_data);
        },

        updateLeaveType(args) {
            // Exit from this function, If submit button disabled 
            if (this.submit_disabled) {
                //return;
            }

            var self = this;
            var pre_define = {};
            var args = jQuery.extend(true, pre_define, args);

            // Disable submit button for preventing multiple click
            this.submit_disabled = true;

            // Showing loading option 
            this.show_spinner = true;

            var request_data = {
                data: args.data,
                success(res) {
                    self.show_spinner = false;
                    // Display a success toast, with a title
                    toastr.success(res.success);
                    self.addLeaveTypeMeta(res.leave_type.data);
                    self.submit_disabled = false;

                    self.$store.commit('leave/afterUpdateLeaveType', res.leave_type.data);

                    if (typeof args.callback === 'function') {
                        args.callback(res);
                    }
                },

                error(res) {
                    self.show_spinner = false;

                    // Showing error
                    res.data.error.map(function (value, index) {
                        toastr.error(value);
                    });
                    self.submit_disabled = false;
                }
            };

            self.httpRequest('create_new_leave_type', request_data);
        },

        addLeaveTypeMeta(type) {
            type.editMode = false;
        },

        addHolidayMeta(holiday) {
            holiday.editMode = false;
        },

        deleteLeaveType(args) {

            if (!confirm('Are you sure')) {
                return;
            }
            var self = this;
            var pre_define = {
                id: false,
                callback: false
            };

            var args = jQuery.extend(true, pre_define, args);

            var request_data = {
                data: {
                    'id': args.id
                },
                success: function () {

                    self.$store.commit('leave/afterDeleteLeaveType', args.id);

                    if (typeof args.callback === 'function') {
                        args.callback();
                    }
                },
                error: function (res) {

                    self.show_spinner = false;
                    // Showing error
                    res.error.map(function (value, index) {
                        toastr.error(value);
                    });
                }
            };

            self.httpRequest('delete_leave_type', request_data);
        },
        updateHoliday(args) {
            // Exit from this function, If submit button disabled 
            if (this.submit_disabled) {
                return;
            }

            var self = this;
            var pre_define = {};
            var args = jQuery.extend(true, pre_define, args);

            // Disable submit button for preventing multiple click
            this.submit_disabled = true;

            // Showing loading option 
            this.show_spinner = true;

            var request_data = {
                data: args.data,
                success(res) {
                    self.show_spinner = false;
                    // Display a success toast, with a title
                    toastr.success(res.success);
                    self.addHolidayMeta(res.holiday);
                    self.submit_disabled = false;

                    self.$store.commit('leave/afterUpdateHoliday', res.holiday);

                    if (typeof args.callback === 'function') {
                        args.callback(res.data);
                    }
                },

                error(res) {
                    self.show_spinner = false;

                    // Showing error
                    res.data.error.map(function (value, index) {
                        toastr.error(value);
                    });
                    self.submit_disabled = false;
                }
            };

            self.httpRequest('create_new_holidays', request_data);
        },

        deleteHoliday(args) {
            if (!confirm('Are you sure')) {
                return;
            }
            // Exit from this function, If submit button disabled 
            if (this.submit_disabled) {
                return;
            }

            let self = this;
            let pre_define = {};
            args = jQuery.extend(true, pre_define, args);

            // Disable submit button for preventing multiple click
            this.submit_disabled = true;

            // Showing loading option 
            this.show_spinner = true;

            var request_data = {
                data: {
                    'id': args.id
                },
                success: function (res) {
                    self.$store.commit('leave/afterDeleteHoliday', args.id);
                    if (typeof args.callback === 'function') {
                        args.callback();
                    }
                },
                error: function (res) {

                    self.show_spinner = false;
                    // Showing error
                    res.error.map(function (value, index) {
                        toastr.error(value);
                    });
                }
            };

            self.httpRequest('delete_holiday', request_data);
        },
        canManamgeLeave() {
            if (hrm_user_can('manage_leave')) {
                return true;
            }

            return false;
        },

        totalEntitlement(types) {
            let total = this.totalSummery(types);

            return total.entitlement;
        },

        totalTakeLeave(types) {
            let total = this.totalSummery(types);

            return total.taken_leave;
        },

        totalRemainLeave(types) {
            let total = this.totalSummery(types);

            return total.remain_leave;
        },

        totalSummery(types) {
            var total_extra = 0;

            var total = {
                entitlement: 0,
                taken_leave: 0,
                remain_leave: 0
            };

            types.forEach(function (type, index) {
                total.entitlement = parseInt(type.entitlement) + total.entitlement;
                total.taken_leave = parseInt(type.count) + total.taken_leave;

                if (type.id === 1) {
                    total_extra = total_extra + parseInt(type.count);
                }
            });

            total.remain_leave = total.entitlement - total.taken_leave + total_extra;

            return total;
        },

        showHideSummery(showHideSummery, type, status) {
            status = status || 'toggle';
            this.$store.commit('leave/showHideSummery', {
                id: showHideSummery.id,
                status: status,
                type: type
            });
        },

        getEmployeeDropDown(args) {
            var self = this;
            var request_data = {
                data: {},
                success: function (res) {
                    self.$store.commit('leave/setEmployeeDropDown', res);
                    if (typeof args.callback === 'function') {
                        args.callback();
                    }
                },
                error: function (res) {

                    self.show_spinner = false;
                    // Showing error
                    res.error.map(function (value, index) {
                        toastr.error(value);
                    });
                }
            };

            this.httpRequest('get_employee_dropdown', request_data);
        }
    }
});

/***/ }),

/***/ 51:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
let HRM_Leave_Store = {
	state: {
		header: {},
		is_new_leave_type_form_visible: false,
		is_new_holiday_form_visible: false,
		is_new_leave_records_form_visible: false,
		is_leave_form_active: false,
		leave_records: [],
		leave_meta: {},
		current_emp_current_month_leaves: [],
		pending_leaves: [],
		departmentDropDown: [],
		holidays: [],
		leaveTypes: [],
		approvedLeaves: [],
		cancelLeaves: [],
		employeeDropDown: [],
		getIndex: function (itemList, id, slug) {
			var index = false;

			itemList.forEach(function (item, key) {
				if (item[slug] == id) {
					index = key;
				}
			});

			return index;
		}
	},

	mutations: {
		afterUpdateLeaveType(state, type) {
			let index = state.getIndex(state.leaveTypes, type.id, 'id');

			state.leaveTypes.splice(index, 1, type);
		},
		afterEmployeeLeaveSummery(state, data) {
			if (data.type == 'pending') {
				let index = state.getIndex(state.pending_leaves, data.row_id, 'id');
				state.pending_leaves[index].metaSummery = data.res;
				state.pending_leaves[index].metaSummeryDisplay = true;
			}
		},
		showHideSummery(state, data) {
			if (data.type == 'pending') {
				let index = state.getIndex(state.pending_leaves, data.id, 'id');

				if (data.status == 'toggle') {
					state.pending_leaves[index].metaSummeryDisplay = state.pending_leaves[index].metaSummeryDisplay ? false : true;
				} else {
					state.pending_leaves[index].metaSummeryDisplay = status;
				}
			}
		},
		setCancelLeaves(state, calcelLeaves) {
			state.cancelLeaves = calcelLeaves;
		},
		setApprovalLeaves(state, approvedLeaves) {
			state.approvedLeaves = approvedLeaves;
		},
		header(state, header) {
			state.header = header.header;
		},
		isNewLeaveTypeFormVisible(state, is_visible) {
			state.is_new_leave_type_form_visible = is_visible.is_visible;
		},
		isNewLeaveRecordsFormVisible(state, is_visible) {
			state.is_new_leave_records_form_visible = is_visible.is_visible;
		},

		isNewHolidayFormVisible(state, is_visible) {
			state.is_new_holiday_form_visible = is_visible.is_visible;
		},

		showHideleaveForm(state, status) {
			if (status === 'toggle') {
				state.is_leave_form_active = state.is_leave_form_active ? false : true;
			} else {
				state.is_leave_form_active = status;
			}
		},

		getLeaveRecords(state, leave_records) {
			state.leave_records = leave_records.data;
			state.leave_meta = leave_records.meta;
		},

		setPendingLeaves(state, pending_leaves) {
			state.pending_leaves = pending_leaves;
		},

		afterDeleteLeave(state, id) {
			var index = state.getIndex(state.leave_records, id, 'id');
			state.leave_records.splice(index, 1);
		},
		setDepartment(state, dropDown) {
			state.departmentDropDown = dropDown;
		},
		setHoliday(state, holidays) {
			state.holidays = holidays;
		},
		updateHolidays(state, holidays) {
			state.holidays.push(holidays);
		},
		afterUpdateHoliday(state, holiday) {
			var index = state.getIndex(state.holidays, holiday.id, 'id');
			state.holidays.splice(index, 1, holiday);
		},
		afterDeleteHoliday(state, id) {
			var index = state.getIndex(state.holidays, id, 'id');
			state.holidays.splice(index, 1);
		},
		setLeaveTypes(state, leaveTypes) {
			state.leaveTypes = leaveTypes;
		},
		setNewLeaveType(state, leaveType) {
			state.leaveTypes.push(leaveType);
		},

		afterDeleteLeaveType(state, id) {
			var index = state.getIndex(state.leaveTypes, id, 'id');
			state.leaveTypes.splice(index, 1);
		},
		afterUpdateStatus(state, data) {

			if (data.section == 1) {
				let index = state.getIndex(state.pending_leaves, data.record.id, 'id');
				state.pending_leaves.splice(index, 1);
			} else if (data.section == 2) {
				let index = state.getIndex(state.approvedLeaves, data.record.id, 'id');
				state.approvedLeaves.splice(index, 1);
			} else if (data.section == 3) {
				let index = state.getIndex(state.cancelLeaves, data.record.id, 'id');
				state.cancelLeaves.splice(index, 1);
			}

			if (data.record.status == 1) {
				state.pending_leaves.push(data.record);
			} else if (data.record.status == 2) {
				state.approvedLeaves.push(data.record);
			} else if (data.record.status == 3) {
				state.cancelLeaves.push(data.record);
			}
		},

		afterCreateNewLeave(state, leaves) {
			leaves.forEach(function (leave) {
				state.leave_records.push(leave.data);
			});
		},
		setEmployeeDropDown(state, employees) {
			state.employeeDropDown = employees;
		}
	}
};

/* harmony default export */ __webpack_exports__["default"] = (HRM_Leave_Store);

/***/ }),

/***/ 52:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
let HRM_Settings_Store = {
	state: {},

	mutations: {}
};

/* harmony default export */ __webpack_exports__["default"] = (HRM_Settings_Store);

/***/ }),

/***/ 53:
/***/ (function(module, exports) {

/**
 * Required jQuery methods 
 * 
 * @type Object
 */
var HRM_Admin = {
    init: function () {
        this.datepicker();
    },

    datepicker: function (el, vnodeContext) {

        jQuery('.hrm-date-field').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: '-50:+5',
            onSelect: function (dateText) {
                vnodeContext.$emit('hrm_date_picker', { field: 'datepicker', date: dateText });
            }
        });

        jQuery(".hrm-date-picker-from").datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                jQuery(".hrm-date-picker-to").datepicker("option", "minDate", selectedDate);
            },
            onSelect: function (dateText) {
                vnodeContext.$emit('hrm_date_picker', { field: 'datepicker_from', date: dateText, self: this });
            }
        });

        jQuery(".hrm-date-picker-to").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                jQuery(".hrm-date-picker-from").datepicker("option", "maxDate", selectedDate);
            },
            onSelect: function (dateText) {
                vnodeContext.$emit('hrm_date_picker', { field: 'datepicker_to', date: dateText });
            }
        });

        jQuery(".hrm-date-time-picker-from").datetimepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                jQuery(".hrm-date-time-picker-to").datetimepicker("option", "minDate", selectedDate);
            },
            onSelect: function (dateText) {
                vnodeContext.$emit('hrm_date_picker', { field: 'datetimepicker_from', date_time: dateText });
            }
        });

        jQuery(".hrm-date-time-picker-to").datetimepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                jQuery(".hrm-date-time-picker-from").datetimepicker("option", "maxDate", selectedDate);
            },
            onSelect: function (dateText) {
                vnodeContext.$emit('hrm_date_picker', { field: 'datetimepicker_to', date_time: dateText });
            }
        });
    }

    // Register a global custom directive called v-cpm-datepicker
};hrm.Vue.directive('hrm-datepicker', {
    inserted: function (el, binding, vnode) {
        HRM_Admin.datepicker(el, vnode.context);
    }
});

hrm.Vue.directive('hrm-slide-down', {
    inserted: function (el) {
        var node = jQuery(el);

        if (node.is(':visible')) {
            node.slideUp(400);
        } else {
            node.slideDown(400);
        }
    }
});

/***/ }),

/***/ 54:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_common_do_action_vue__ = __webpack_require__(62);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_settings_header_vue__ = __webpack_require__(41);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_common_date_picker_vue__ = __webpack_require__(254);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_common_form_fields_vue__ = __webpack_require__(339);





hrm.Vue.component('hrm-do-action', __WEBPACK_IMPORTED_MODULE_0__components_common_do_action_vue__["a" /* default */]);
hrm.Vue.component('hrm-settings-header', __WEBPACK_IMPORTED_MODULE_1__components_settings_header_vue__["a" /* default */]);
hrm.Vue.component('hrm-date-picker', __WEBPACK_IMPORTED_MODULE_2__components_common_date_picker_vue__["a" /* default */]);
hrm.Vue.component('hrm-form-fields', __WEBPACK_IMPORTED_MODULE_3__components_common_form_fields_vue__["a" /* default */]);

/***/ }),

/***/ 56:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony default export */ var _unused_webpack_default_export = (hrm.Vue.mixin({
    methods: {
        registerStore(module_name, store) {
            if (typeof store === 'undefined') {
                return false;
            }

            var self = this;
            if (typeof store !== 'undefined') {
                var mutations = store.mutations || {}; //self.$options.mutations;
                var state = store.state || {}; //self.$options.state;
            }

            // register a module `myModule`

            self.$store.registerModule(module_name, {
                namespaced: true,
                state,
                mutations
            });
        },
        httpRequest(hook, property) {
            var before = function (xhr) {
                xhr.setRequestHeader("Authorization_name", btoa('asaquzzaman')); //btoa js encoding base64_encode
                xhr.setRequestHeader("Authorization_password", btoa(12345678)); //atob js decode base64_decode
            };

            property.beforeSend = typeof property.beforeSend === 'undefined' ? before : property.beforeSend;
            property.data._wpnonce = HRM_Vars.nonce;

            wp.ajax.send(hook, property);
        },
        slideUp(target_el, callback) {
            var node = jQuery(target_el).closest('.hrm-slide-up');

            node.slideUp(400, function () {
                callback();
            });
        },

        /**
            * Get index from array object element
            * 
            * @param   array 
            * @param   id    
            * 
            * @return  int      
            */
        getIndex(array, id, slug) {
            var target = false;

            array.forEach(function (content, index) {
                if (content[slug] == id) {
                    target = index;
                }
            });

            return target;
        },

        getDepartments(args) {
            var self = this;
            var pre_define = {
                _wpnonce: HRM_Vars.nonce,
                page_number: this.$route.params.page_number
            };

            var request_data = jQuery.extend(true, pre_define, args.data);

            wp.ajax.send('get_departments', {
                data: request_data,
                success(res) {
                    self.$store.commit('departments/setDepartments', {
                        departments: res.departments,
                        'total_dept': res.total_dept,
                        'dept_drop_down': res.dept_drop_down
                    });

                    if (typeof args.callback === 'function') {
                        args.callback(res);
                    }
                },

                error(res) {}
            });
        },
        /**
               * WP settings date format convert to moment date format with time zone
               * 
               * @param  string date 
               * 
               * @return string      
               */
        dateFormat: function (date) {
            if (typeof date === 'undefined') {
                date = moment().format();
            }

            // moment.tz.add(HRM_Vars.time_zones);
            // moment.tz.link(HRM_Vars.time_links);

            date = new Date(date);
            date = moment(date).format('YYYY-MM-DD');

            var format = 'MMMM DD YYYY';

            if (HRM_Vars.wp_date_format == 'Y-m-d') {
                format = 'YYYY-MM-DD';
            } else if (HRM_Vars.wp_date_format == 'm/d/Y') {
                format = 'MM/DD/YYYY';
            } else if (HRM_Vars.wp_date_format == 'd/m/Y') {
                format = 'DD/MM/YYYY';
            }

            return moment(date).format(format);
        },

        currentDate() {
            return this.dateFormat();
        },

        pad(d) {
            if (typeof d === 'undefined') {
                return d;
            }
            return d < 10 ? '0' + d.toString() : d.toString();
        },

        onOff(key, status) {
            var status = status || 'no';

            if (status === 'no') {
                this[key] = this[key] ? false : true;
            } else {
                this[key] = status;
            }
            this.leave_type = '';
            this.change_leve_type_statue();
        },

        loadingStart(id, args) {
            var pre_define = {
                // loading text
                text: '',

                // from 0 to 100 
                percent: '',

                // duration in ms
                duration: '',

                // z-index property
                zIndex: '',

                // sets relative position to preloader's parent
                setRelative: false

            };
            var args = jQuery.extend(true, pre_define, args);

            jQuery('#' + id).preloader(args);
        },

        loadingStop(id) {
            jQuery('#' + id).preloader('remove');
        }
    }
}));

/***/ }),

/***/ 57:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_profile_router__ = __webpack_require__(326);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_profile_router___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__components_profile_router__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_common_empty_vue__ = __webpack_require__(63);
// import leave from '@components/leave/router';
// import settings from '@components/settings/router';
// import departments from '@components/departments/router';
// import Attendance from '@components/attendance/router';




HRM_Routers.push({
	path: '/',
	component: __WEBPACK_IMPORTED_MODULE_1__components_common_empty_vue__["a" /* default */],
	name: 'hrm_root',

	children: HRMGetRegisterChildrenRoute('hrm_root')
});

var router = new hrm.VueRouter({
	routes: HRM_Routers
});

/* harmony default export */ __webpack_exports__["a"] = (router);

/***/ }),

/***/ 58:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__.p = HRM_Vars.hrm_url + '/assets/js/';

hrmPromise.then(function (result) {
    __webpack_require__(19);
});

/***/ }),

/***/ 59:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/**
 * Make sure to call Vue.use(Vuex) first if using a vuex module system
 */
/* harmony default export */ __webpack_exports__["a"] = (new hrm.Vuex.Store({

	state: {},

	mutations: {}

}));

/***/ }),

/***/ 61:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_App_vue__ = __webpack_require__(14);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_ea4b6e04_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_App_vue__ = __webpack_require__(68);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_App_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_ea4b6e04_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_App_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/App.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-ea4b6e04", Component.options)
  } else {
    hotAPI.reload("data-v-ea4b6e04", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 62:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_do_action_vue__ = __webpack_require__(15);
/* unused harmony namespace reexport */
var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */


/* template */
var __vue_template__ = null
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_do_action_vue__["a" /* default */],
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/common/do-action.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0aa39e6a", Component.options)
  } else {
    hotAPI.reload("data-v-0aa39e6a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 63:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_empty_vue__ = __webpack_require__(16);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_05b5b47f_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_empty_vue__ = __webpack_require__(65);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_empty_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_05b5b47f_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_empty_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/common/empty.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-05b5b47f", Component.options)
  } else {
    hotAPI.reload("data-v-05b5b47f", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 64:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_settings_vue__ = __webpack_require__(18);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_606387ae_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_settings_vue__ = __webpack_require__(66);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_settings_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_606387ae_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_settings_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/settings/settings.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-606387ae", Component.options)
  } else {
    hotAPI.reload("data-v-606387ae", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 65:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("router-view")
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-05b5b47f", esExports)
  }
}

/***/ }),

/***/ 66:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("router-view")
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-606387ae", esExports)
  }
}

/***/ }),

/***/ 67:
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
      _vm._l(_vm.menu[0].children, function(item, index) {
        return _c(
          "router-link",
          {
            key: "index",
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
        _vm._l(_vm.childrens(), function(children) {
          return children.meta.label
            ? _c(
                "li",
                [
                  _c(
                    "router-link",
                    { attrs: { to: { name: children.name } } },
                    [_vm._v(_vm._s(children.meta.label))]
                  ),
                  _vm._v(" |  \n            ")
                ],
                1
              )
            : _vm._e()
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
    require("vue-hot-reload-api")      .rerender("data-v-6a880113", esExports)
  }
}

/***/ }),

/***/ 68:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { attrs: { id: "hrm" } }, [_c("router-view")], 1)
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-ea4b6e04", esExports)
  }
}

/***/ })

/******/ });