webpackJsonp([0],{

/***/ 11:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_vue__ = __webpack_require__(38);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_550288f7_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_vue__ = __webpack_require__(61);
var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */

/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_550288f7_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "asset/js/components/leave/leave-records.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] leave-records.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-550288f7", Component.options)
  } else {
    hotAPI.reload("data-v-550288f7", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 25:
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

//import HRM_Mixin from './../../mixin';

var Hrm_Leave_Header = {

    data: function () {
        return {
            header: []
        };
    },
    created: function () {
        this.getHeader();
    },

    // computed: {
    //     header: function() {
    //         return this.$store.state.header;
    //     },

    // },
    methods: {
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
        },
        getHeader: function () {
            var request_data = {
                _wpnonce: HRM_Vars.nonce
            },
                self = this;

            wp.ajax.send('leave_header', {
                data: request_data,
                success: function (res) {
                    self.header = res.header;
                    //self.$store.commit( 'header', {'header': res.header} );
                },

                error: function (res) {}
            });
        }
    }
};

/* harmony default export */ __webpack_exports__["a"] = (Hrm_Leave_Header);

/***/ }),

/***/ 26:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_header_vue__ = __webpack_require__(25);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4dd87430_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_header_vue__ = __webpack_require__(27);
var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */

/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_header_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4dd87430_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_header_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "asset/js/components/leave/leave-header.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] leave-header.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4dd87430", Component.options)
  } else {
    hotAPI.reload("data-v-4dd87430", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 27:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('h2', {
    staticClass: "nav-tab-wrapper"
  }, _vm._l((_vm.header), function(head) {
    return _c('router-link', {
      staticClass: "nav-tab",
      attrs: {
        "to": head.url
      }
    }, [_vm._v(_vm._s(head.title))])
  })), _vm._v(" "), (_vm.has_child_menu() || _vm.is_it_child()) ? _c('h3', {
    staticClass: "hrm-sub-nav"
  }, [_c('ul', {
    staticClass: "hrm-subsubsub"
  }, _vm._l((_vm.get_child_menu()), function(child_menu) {
    return _c('li', [_c('router-link', {
      attrs: {
        "to": {
          name: child_menu.name
        }
      }
    }, [_vm._v(_vm._s(child_menu.title))]), _vm._v(" | \n            ")], 1)
  }))]) : _vm._e()])
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-4dd87430", esExports)
  }
}

/***/ }),

/***/ 35:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["a"] = ({
	methods: {
		showHideLeaveRecordsForm: function () {
			this.$store.commit('isNewLeaveRecordsFormVisible', { is_visible: true });
		}
	}
});

/***/ }),

/***/ 36:
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
	//mixins: [HRM_Mixin],

	//store: HRM_Leave_Store,

	data: function () {
		return {
			employees: [],
			emp: '',
			apply_to: '',
			leave_type: '',
			leave_types: [],
			administrators: [],
			leave_status: '',
			start_time: '',
			end_time: '',
			leave_comments: '',
			emp_leave_with_type_record: [],
			work_week: [],
			leave_entitlements: [],
			apply_leave_date: [],
			calendar_evt_id: [],
			disable_leave_type: false
		};
	},

	created: function () {
		this.$on('hrm_date_picker', this.setDateTime);
		this.getInitialData();
	},
	methods: {
		getInitialData: function () {
			var request_data = {
				_wpnonce: HRM_Vars.nonce
			},
			    self = this;

			wp.ajax.send('get_leave_records_init_data', {
				data: request_data,

				success: function (res) {
					self.leave_types = res.leave_types;
					self.employees = res.employess;
					self.administrators = res.apply_to;
					self.emp_leave_with_type_record = res.emp_leave_with_type_record;
					self.leave_entitlements = res.leave_entitlements;
					self.work_week = res.work_week;
					self.emp = res.current_user;
					self.leave_status = 1;
				},

				error: function (res) {}
			});
		},
		setDateTime: function (date) {
			if (date.field == 'datepicker_from') {
				this.from = date.date;
			}

			if (date.field == 'datepicker_to') {
				this.to = date.date;
			}
		},
		show_hide_new_leave_records_form: function (el) {
			var self = this;

			this.slideUp(el.target, function () {
				self.$store.commit('isNewLeaveRecordsFormVisible', { is_visible: false });
			});
		},

		createNewLeave: function () {

			var request_data = {
				_wpnonce: hrm_ajax_data.nonce,
				leave_status: this.leave_status,
				leave_comments: this.leave_comments,
				leave_type_id: !this.leave_type ? '' : this.leave_type.id,
				emp_id: !this.emp ? '' : this.emp.ID,
				time: this.apply_leave_date,
				disable_leave_type: this.disable_leave_type,
				apply_to: this.apply_to.length ? true : '',
				class: 'Leave',
				method: 'create'
			},


			// is_update  = parseInt( this.department_id ) ? true : false,

			// target_index = is_update ? this.getIndex(
			//     this.$store.state.departments, this.department_id, 'id'
			// ) : false,

			self = this;

			this.show_spinner = true;

			wp.ajax.send('create_new_leave', {
				data: request_data,

				success: function (res) {
					self.show_spinner = false;

					// Display a success toast, with a title
					toastr.success(res.success);

					self.slideUp(jQuery('.hrm-form-cancel'), function () {
						//self.$store.commit('isNewDepartmentForVisible', {is_visible: false});
					});
				},

				error: function (res) {
					self.show_spinner = false;
					// Showing error
					res.error.map(function (value, index) {
						toastr.error(value);
					});
				}
			});
		},

		change_leve_type_statue: function () {

			jQuery.each(this.calendar_evt_id, function (index, event_id) {
				jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('removeEvents', event_id);
			});

			this.calendar_evt_id = [];
			this.apply_leave_date = [];
		}
	}
});

/***/ }),

/***/ 37:
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

/* harmony default export */ __webpack_exports__["a"] = ({

	//store: HRM_Leave_Store,

	data: function () {
		return {
			records: []
		};
	},

	computed: {},

	created: function () {
		this.getLeaveRecords();
	},
	methods: {
		getLeaveRecords: function () {
			var request_data = {
				_wpnonce: HRM_Vars.nonce
			},
			    self = this;

			wp.ajax.send('get_leave_records', {
				data: request_data,
				success: function (res) {

					self.records = res.leave_types;
				},

				error: function (res) {}
			});
		}
	}
});

/***/ }),

/***/ 38:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__leave_header_vue__ = __webpack_require__(26);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__leave_records_add_btn_vue__ = __webpack_require__(48);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__leave_records_form_vue__ = __webpack_require__(49);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__leave_records_render_vue__ = __webpack_require__(50);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__leave_store__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__leave_directive__ = __webpack_require__(8);
//
//
//
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
	store: __WEBPACK_IMPORTED_MODULE_4__leave_store__["a" /* default */],

	computed: {
		is_new_leave_records_form_visible: function () {
			return this.$store.state.is_new_leave_records_form_visible;
		}
	},
	components: {
		'leave-header': __WEBPACK_IMPORTED_MODULE_0__leave_header_vue__["a" /* default */],
		'hrm-leave-records-add-btn': __WEBPACK_IMPORTED_MODULE_1__leave_records_add_btn_vue__["a" /* default */],
		'hrm-leave-records-form': __WEBPACK_IMPORTED_MODULE_2__leave_records_form_vue__["a" /* default */],
		'hrm-leave-records-render': __WEBPACK_IMPORTED_MODULE_3__leave_records_render_vue__["a" /* default */]
	}
});

/***/ }),

/***/ 48:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_add_btn_vue__ = __webpack_require__(35);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4192324c_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_add_btn_vue__ = __webpack_require__(59);
var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */

/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_add_btn_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4192324c_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_add_btn_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "asset/js/components/leave/leave-records-add-btn.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] leave-records-add-btn.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4192324c", Component.options)
  } else {
    hotAPI.reload("data-v-4192324c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 49:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_form_vue__ = __webpack_require__(36);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_01588d8a_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_form_vue__ = __webpack_require__(53);
var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */

/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_form_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_01588d8a_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_form_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "asset/js/components/leave/leave-records-form.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] leave-records-form.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-01588d8a", Component.options)
  } else {
    hotAPI.reload("data-v-01588d8a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 50:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_render_vue__ = __webpack_require__(37);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_cfd49448_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_render_vue__ = __webpack_require__(65);
var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */

/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_render_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_cfd49448_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_render_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "asset/js/components/leave/leave-records-render.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] leave-records-render.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-cfd49448", Component.options)
  } else {
    hotAPI.reload("data-v-cfd49448", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 53:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "metabox-holder hrm-punch-in-out-wrap"
  }, [_c('div', {
    staticClass: "postbox"
  }, [_vm._m(0), _vm._v(" "), _c('div', {
    staticClass: "inside"
  }, [_c('div', {
    staticClass: "hrm-attendance-configuration",
    attrs: {
      "id": "hrm-hidden-form"
    }
  }, [_c('form', {
    attrs: {
      "action": ""
    },
    on: {
      "submit": function($event) {
        $event.preventDefault();
        _vm.createNewLeave()
      }
    }
  }, [_c('div', {
    staticClass: "hrm-form-field"
  }, [_vm._m(1), _vm._v(" "), _c('div', {
    staticClass: "hrm-multiselect"
  }, [_c('hrm-multiselect', {
    attrs: {
      "options": _vm.employees,
      "multiple": false,
      "close-on-select": true,
      "clear-on-select": true,
      "hide-selected": false,
      "show-labels": true,
      "placeholder": "<?php _e( 'Select employee', 'cpm' ); ?>",
      "select-label": "",
      "selected-label": "selected",
      "deselect-label": "",
      "taggable": false,
      "label": "display_name",
      "track-by": "ID",
      "allow-empty": true
    },
    scopedSlots: _vm._u([{
      key: "option",
      fn: function(props) {
        return [_c('div', [_c('div', {
          staticClass: "multi-img-wrap"
        }, [_c('img', {
          staticClass: "option__image",
          attrs: {
            "height": "16",
            "width": "16",
            "src": props.option.avatar_url,
            "alt": "<?php _e( '', 'cpm' ); ?>"
          }
        })]), _vm._v(" "), _c('div', {
          staticClass: "option__descΩ"
        }, [_c('span', {
          staticClass: "option__title"
        }, [_vm._v(_vm._s(props.option.display_name))])]), _vm._v(" "), _c('div', {
          staticClass: "hrm-clear"
        })])]
      }
    }]),
    model: {
      value: (_vm.emp),
      callback: function($$v) {
        _vm.emp = $$v
      },
      expression: "emp"
    }
  })], 1), _vm._v(" "), _c('div', {
    staticClass: "hrm-clear"
  })]), _vm._v(" "), (!_vm.disable_leave_type) ? _c('div', {
    staticClass: "hrm-form-field"
  }, [_vm._m(2), _vm._v(" "), _c('div', {
    staticClass: "hrm-multiselect"
  }, [_c('hrm-multiselect', {
    attrs: {
      "options": _vm.leave_types,
      "multiple": false,
      "close-on-select": true,
      "clear-on-select": true,
      "hide-selected": false,
      "show-labels": true,
      "placeholder": "<?php _e( 'Select leave type', 'cpm' ); ?>",
      "select-label": "",
      "selected-label": "selected",
      "deselect-label": "",
      "taggable": false,
      "label": "leave_type_name",
      "track-by": "id",
      "allow-empty": true
    },
    on: {
      "input": function($event) {
        _vm.change_leve_type_statue()
      }
    },
    model: {
      value: (_vm.leave_type),
      callback: function($$v) {
        _vm.leave_type = $$v
      },
      expression: "leave_type"
    }
  })], 1), _vm._v(" "), _c('div', {
    staticClass: "hrm-clear"
  })]) : _vm._e(), _vm._v("\n\n\t\t\t\t\t<?php\n\t\t\t\t\t$field = array(\n\t\t\t            'label' => __( 'Disable leave type', 'hrm' ),\n\t\t\t            'is_vue' => true,\n\t\t\t            'fields' => array(\n\t\t\t                array(\n\t\t\t                    'label'   => __( 'Disable', 'hrm' ),\n\t\t\t                    'checked' => '',\n\t\t\t                    'elements' => array(\n\t\t\t                    \t'id'      => 'hrm-disable-leave-type-checkbox',\n\t\t\t                    \t'v-model' => 'disable_leave_type',\n\t\t\t                    \t\"@change\" => 'change_leve_type_statue()'\n\t\t\t                    )\n\t\t\t                )\n\t\t\t            ),\n\t\t\t        );\n\n\t\t\t        echo Hrm_Settings::getInstance()->new_checkbox_field( $field );\n\n\t\t\t        ?>\n\n\t\t\t\t\t"), _c('div', {
    staticClass: "hrm-form-field"
  }, [_vm._m(3), _vm._v(" "), _c('div', {
    staticClass: "hrm-multiselect"
  }, [_c('hrm-multiselect', {
    attrs: {
      "options": _vm.administrators,
      "multiple": true,
      "close-on-select": true,
      "clear-on-select": true,
      "hide-selected": false,
      "show-labels": true,
      "placeholder": "<?php _e( 'Select administrators', 'cpm' ); ?>",
      "select-label": "",
      "selected-label": "selected",
      "deselect-label": "",
      "taggable": false,
      "label": "display_name",
      "track-by": "ID",
      "allow-empty": true
    },
    scopedSlots: _vm._u([{
      key: "option",
      fn: function(props) {
        return [_c('div', [_c('div', {
          staticClass: "multi-img-wrap"
        }, [_c('img', {
          staticClass: "option__image",
          attrs: {
            "height": "16",
            "width": "16",
            "src": props.option.avatar_url,
            "alt": "<?php _e( 'kkk', 'cpm' ); ?>"
          }
        })]), _vm._v(" "), _c('div', {
          staticClass: "option__descΩ"
        }, [_c('span', {
          staticClass: "option__title"
        }, [_vm._v(_vm._s(props.option.display_name))])]), _vm._v(" "), _c('div', {
          staticClass: "hrm-clear"
        })])]
      }
    }]),
    model: {
      value: (_vm.apply_to),
      callback: function($$v) {
        _vm.apply_to = $$v
      },
      expression: "apply_to"
    }
  })], 1), _vm._v(" "), _c('div', {
    staticClass: "hrm-clear"
  })]), _vm._v("\n\n\t\t\t\t\t<?php\n\t\t\t\t\t    //hidden form\n\t\t\t\t        $field_obj = array(\n\t\t\t\t\t\t\t'label'    =>  __( 'Status', 'hrm' ),\n\t\t\t\t\t\t\t'required' =>  true,\n\t\t\t\t\t\t\t'is_vue' => true,\n\t\t\t\t\t\t\t'option'  => Hrm_Leave::getInstance()->leave_status(),\n\t\t\t\t            'field_elements' => array(\n\t\t\t\t\t\t\t\t'id'       => 'hrm-leave-type-select-field',\n\t\t\t\t\t\t\t\t//'required' => 'required',\n\t\t\t\t\t\t\t\t'v-model'  => 'leave_status',\n\t\t\t\t\t\t\t\t'name'     => 'leave_status',\n\t\t\t\t            )\n\t\t\t\t        );\n\n\t\t\t\t\t\techo Hrm_Settings::getInstance()->new_select_field( $field_obj );\n\n\t\t\t\t        $field_obj = array(\n\t\t\t\t\t\t\t'label' =>  __( 'Description', 'hrm' ),\n\t\t\t\t\t\t\t'id'       => 'hrm-leave-description-textarea-field',\n\t\t\t\t            'field_elements' => array(\n\t\t\t\t\t\t\t\t'v-model'  => 'leave_comments'\n\t\t\t\t            ),\n\t\t\t\t        );\n\n\t\t\t\t\t    echo Hrm_Settings::getInstance()->new_textarea_field( $field_obj );\n\t\t\t\t\t?>\n\t\t\t\t\t"), _c('div', {
    staticClass: "hrm-form-field"
  }, [_vm._m(4), _vm._v(" "), _c('div', {
    directives: [{
      name: "hrm-leave-jquery-fullcalendar",
      rawName: "v-hrm-leave-jquery-fullcalendar"
    }],
    staticClass: "hrm-leave-jquery-fullcalendar"
  })]), _vm._v(" "), _c('input', {
    staticClass: "button hrm-submit-button button-primary",
    attrs: {
      "type": "submit",
      "name": "requst",
      "value": "<?php _e( 'Save changes', 'hrm' ); ?>"
    }
  }), _vm._v(" "), _c('a', {
    staticClass: "button hrm-form-cancel",
    attrs: {
      "target": "_blank",
      "href": "#"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.show_hide_new_leave_records_form($event)
      }
    }
  }, [_vm._v("<?php _e( 'Cancel', 'hrm' ); ?>")])])])])])])
}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('h2', {
    staticClass: "hndle ui-sortable-handle"
  }, [_c('span', [_vm._v("<?php _e( 'Holidays', 'hrm' ); ?>")])])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', [_vm._v("\n\t\t\t\t\t\t\t<?php _e( 'Employee', 'hrm' ); ?>\n\t\t\t\t\t\t\t"), _c('em', [_vm._v("*")])])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', [_vm._v("\n\t\t\t\t\t\t\t<?php _e( 'Leave Type', 'hrm' ); ?>\n\t\t\t\t\t\t\t"), _c('em', [_vm._v("*")])])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', [_vm._v("\n\t\t\t\t\t\t\t<?php _e( 'Apply to', 'hrm' ); ?>\n\t\t\t\t\t\t\t"), _c('em', [_vm._v("*")])])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', [_vm._v("<?php _e( 'Leave Duration', 'hrm' ); ?>"), _c('em', [_vm._v("*")])])
}]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-01588d8a", esExports)
  }
}

/***/ }),

/***/ 59:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "hrm-tbl-action-btn-sibling"
  }, [_c('a', {
    staticClass: "button button-primary hrm-add-button",
    attrs: {
      "href": "#"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.showHideLeaveRecordsForm()
      }
    }
  }, [_vm._v("Add")])])
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-4192324c", esExports)
  }
}

/***/ }),

/***/ 61:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('leave-header'), _vm._v(" "), (_vm.is_new_leave_records_form_visible) ? _c('div', {
    directives: [{
      name: "hrm-slide-down",
      rawName: "v-hrm-slide-down"
    }],
    staticClass: "hrm-slide-up",
    staticStyle: {
      "display": "none"
    }
  }, [_c('hrm-leave-records-form')], 1) : _vm._e(), _vm._v(" "), _c('hrm-leave-records-add-btn'), _vm._v(" "), _c('hrm-leave-records-render')], 1)
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-550288f7", esExports)
  }
}

/***/ }),

/***/ 65:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('div', {
    staticClass: "metabox-holder hrm-leave-type-records-wrap"
  }, [_c('table', {
    staticClass: "wp-list-table widefat fixed striped"
  }, [_vm._m(0), _vm._v(" "), _c('tbody', [_vm._l((_vm.records), function(record) {
    return _c('tr', [_c('td', [_vm._v(_vm._s(record.leave_type_name))]), _vm._v(" "), _c('td', [_vm._v(_vm._s(record.entitlement))]), _vm._v(" "), _c('td', [_vm._v(_vm._s(record.entitle_from))]), _vm._v(" "), _c('td', [_vm._v(_vm._s(record.entitle_to))])])
  }), _vm._v(" "), (!_vm.records.length) ? _c('tr', [_c('td', {
    attrs: {
      "colspan": "4"
    }
  }, [_vm._v("<?php _e( 'No record found!', 'hrm' ); ?>")])]) : _vm._e()], 2)])])])
}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('thead', [_c('th', [_vm._v("<?php _e( 'Leave Type', 'cpm' ); ?>")]), _vm._v(" "), _c('th', [_vm._v("<?php _e( 'Days', 'cpm' ); ?>")]), _vm._v(" "), _c('th', [_vm._v("<?php _e( 'Start', 'cpm' ); ?>")]), _vm._v(" "), _c('th', [_vm._v("<?php _e( 'End', 'cpm' ); ?>")])])
}]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-cfd49448", esExports)
  }
}

/***/ })

});