wpSpearHrm([2],{

/***/ 325:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_work_experiance_vue__ = __webpack_require__(329);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_749e1944_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_work_experiance_vue__ = __webpack_require__(331);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_work_experiance_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_749e1944_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_work_experiance_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/js/src/components/profile/work-experiance.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-749e1944", Component.options)
  } else {
    hotAPI.reload("data-v-749e1944", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 329:
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

/* harmony default export */ __webpack_exports__["a"] = ({
	data() {
		return {
			fields: [{
				type: 'text',
				model: '',
				label: 'Title',
				name: 'title'
			}, {
				type: 'date-picker-from',
				model: '',
				label: 'From',
				name: 'from'
			}, {
				type: 'date-picker-to',
				model: '',
				label: 'To',
				name: 'to'
			}, {
				type: 'textarea',
				model: '',
				label: 'Description',
				name: 'description'
			}]
		};
	},
	created() {},
	components: {},

	methods: {
		createNewExperiance() {

			var args = {
				data: this.generateFieldData(this.fields),
				model: 'Work_Experience',
				method: 'create',

				callback(success, res) {}
			};
		},

		generateFieldData(data) {
			var formated = {};

			data.forEach(function (val) {
				formated[val.name] = val.model;
			});
		},

		insertRecords(args) {
			var form_data = {
				data: args.data,

				success: function (res) {
					if (typeof args.callback === 'function') {
						args.callback(true, res);
					}
				},

				error: function (res) {
					self.show_spinner = false;
					// Showing error
					res.error.map(function (value, index) {
						hrm.toastr.error(value);
					});

					if (typeof args.callback === 'function') {
						args.callback(false, res);
					}
				}
			};

			this.httpRequest('create_new_leave', form_data);
		}
	}
});

/***/ }),

/***/ 331:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "postbox", attrs: { id: "hrm-hidden-form-warp" } },
    [
      _vm._m(0),
      _vm._v(" "),
      _c(
        "form",
        {
          attrs: { id: "hrm-hidden-form", action: "" },
          on: {
            submit: function($event) {
              $event.preventDefault()
              _vm.createNewExperiance()
            }
          }
        },
        [
          _c(
            "div",
            { attrs: { id: "hrm-form-field" } },
            [_c("hrm-form-fields", { attrs: { fields: _vm.fields } })],
            1
          ),
          _vm._v(" "),
          _c("div", { staticClass: "hrm-action-wrap" }, [
            _c("input", {
              staticClass: "button  button-primary",
              attrs: { type: "submit", name: "requst", value: "Submit" }
            }),
            _vm._v(" "),
            _c(
              "a",
              {
                staticClass: "button hrm-form-cancel",
                attrs: { target: "_blank", href: "#" }
              },
              [_vm._v("Cancel")]
            ),
            _vm._v(" "),
            true
              ? _c("div", { staticClass: "hrm-spinner" }, [
                  _vm._v("Saving....")
                ])
              : _vm._e()
          ])
        ]
      )
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "hrm-search-head" }, [
      _c("h3", [_vm._v("Work Experiance")])
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-749e1944", esExports)
  }
}

/***/ })

});