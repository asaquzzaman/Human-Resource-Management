wpSpearHrm([3,30],{

/***/ 155:
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


/* harmony default export */ __webpack_exports__["a"] = ({
    mixins: [HRMMixin.departments],

    created: function () {
        //this.getDepartments();
    },

    watch: {
        '$route': function (to, from) {
            this.departmentQuery();
        }
    },
    computed: {
        total: function () {

            return Math.ceil(this.$store.state.departments.dept_pagination.total / this.$store.state.departments.dept_pagination.limit);
        },

        limit: function () {
            return this.$store.state.departments.dept_pagination.limit;
        },

        page_number: function () {
            return this.$store.state.departments.dept_pagination.page_number;
        }
    },

    methods: {
        departmentQuery() {
            var self = this;

            var conditions = {
                show_all: true
            };

            var args = {
                data: conditions,
                callback: function (res) {}
            };

            this.getDepartments(args);
        },
        pageClass: function (page) {
            if (page == this.page_number) {
                return 'page-numbers current';
            }

            return 'page-numbers';
        }
    }
});

/***/ }),

/***/ 280:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.total > 1
    ? _c("div", [
        _c(
          "div",
          { staticClass: "hrm-pagination-wrap" },
          [
            _vm.page_number > 1
              ? _c(
                  "router-link",
                  {
                    staticClass: "cpm-pagination-btn prev page-numbers",
                    attrs: {
                      to: {
                        name: "department_pagination",
                        params: {
                          page_number: _vm.page_number - 1
                        }
                      }
                    }
                  },
                  [_vm._v("\n            «\n        ")]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm._l(_vm.total, function(page) {
              return _c(
                "router-link",
                {
                  key: "page",
                  class: _vm.pageClass(page) + " cpm-pagination-btn",
                  attrs: {
                    to: {
                      name: "department_pagination",
                      params: {
                        page_number: page
                      }
                    }
                  }
                },
                [_vm._v("\n            " + _vm._s(page) + "\n        ")]
              )
            }),
            _vm._v(" "),
            _vm.page_number < _vm.total
              ? _c(
                  "router-link",
                  {
                    staticClass: "cpm-pagination-btn next page-numbers",
                    attrs: {
                      to: {
                        name: "department_pagination",
                        params: {
                          page_number: _vm.page_number + 1
                        }
                      }
                    }
                  },
                  [_vm._v("\n            »\n        ")]
                )
              : _vm._e()
          ],
          2
        ),
        _vm._v(" "),
        _c("div", { staticClass: "cpm-clearfix" })
      ])
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-340e4472", esExports)
  }
}

/***/ }),

/***/ 289:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["a"] = ({
	mixins: [HRMMixin.departments]
});

/***/ }),

/***/ 290:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["a"] = ({
    props: ['type', 'department_id'],

    mixins: [HRMMixin.departments],

    methods: {
        departmentGroupDelete: function () {
            this.deleteDepartment(this.$store.state.departments.del_dept);
        },

        departmentDelete: function () {

            this.deleteDepartment([this.department_id]);
        },

        deleteDepartment: function (dept_id) {
            var is_continue = true;

            this.$store.state.departments.departments.forEach(function (department) {

                if (dept_id.includes(department.id)) {
                    if (parseInt(department.number_of_employee) > 0 && is_continue) {
                        hrm.Toastr.success('The departments are contain employee you can not remove them');
                        is_continue = false;
                    }
                }
            });

            if (!is_continue) {
                return false;
            }

            var request_data = {
                _wpnonce: HRM_Vars.nonce,
                dept_id: dept_id
            },
                self = this; //The departments are contain employee you can not remove them

            wp.ajax.send('delete_department', {
                data: request_data,
                success: function (res) {
                    // Display a success toast, with a title
                    hrm.Toastr.success(res.success);

                    self.$store.commit('departments/departmentDelId', { del_dept: [] });

                    res.deleted_dept.map(function (deleted_id) {
                        var index = self.getIndex(self.$store.state.departments.departments, deleted_id, 'id');

                        self.$store.commit('departments/afterDeleteDept', { target_del_dept: index, dept_drop_down: res.dept_drop_down });
                    });
                },

                error: function (res) {
                    // Showing error
                    res.error.map(function (value, index) {
                        hrm.Toastr.error(value);
                    });
                }
            });
        }
    }

});

/***/ }),

/***/ 291:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//
//


/* harmony default export */ __webpack_exports__["a"] = ({
	props: ['department_id'],

	mixins: [HRMMixin.departments],

	methods: {
		departmentEdit: function () {
			this.$store.commit('departments/department_edit_id', { department_id: this.department_id });
			this.$store.commit('departments/showHideDepartmentForm', true);
		}
	}
});

/***/ }),

/***/ 292:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__department_edit_btn_vue__ = __webpack_require__(383);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__department_del_btn_vue__ = __webpack_require__(345);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
    mixins: [HRMMixin.departments],

    data: function () {
        return {
            del_all_dept: false,
            del_dept: []
        };
    },

    computed: {
        departments: function () {
            return this.$store.state.departments.departments;
        }
    },

    components: {
        'department-edit-btn': __WEBPACK_IMPORTED_MODULE_0__department_edit_btn_vue__["a" /* default */],
        'department-del-btn': __WEBPACK_IMPORTED_MODULE_1__department_del_btn_vue__["a" /* default */]
    },

    methods: {
        departmentQuery() {
            var self = this;

            var conditions = {
                show_all: true
            };

            var args = {
                data: conditions,
                callback: function (res) {}
            };

            this.getDepartments(args);
        },
        delAllDept: function () {
            if (this.del_all_dept) {
                var depts_id = [];

                this.$store.state.departments.departments.map(function (department) {
                    depts_id.push(department.id);
                });

                this.del_dept = depts_id;
            } else {
                this.del_dept = [];
            }

            this.$store.commit('departments/departmentDelId', { del_dept: this.del_dept });
        },

        delDept: function () {
            var depts_id = [];

            this.$store.state.departments.departments.map(function (department) {
                depts_id.push(department.id);
            });

            if (depts_id.length == this.del_dept.length) {
                this.del_all_dept = true;
            }

            if (depts_id.length != this.del_dept.length) {
                this.del_all_dept = false;
            }

            this.$store.commit('departments/departmentDelId', { del_dept: this.del_dept });
        },

        departmentActivity: function (department) {
            return parseInt(department.active) == 0 ? 'Disable' : 'Enable';
        }
    }
});

/***/ }),

/***/ 293:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__department_add_btn_vue__ = __webpack_require__(382);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__new_department_form_vue__ = __webpack_require__(385);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__department_del_btn_vue__ = __webpack_require__(345);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__department_table_vue__ = __webpack_require__(384);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__department_pagination_vue__ = __webpack_require__(39);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
	mixins: [HRMMixin.departments],
	created() {
		this.getDepartments();
	},
	computed: {
		is_new_department_form_visible: function () {
			return this.$store.state.departments.is_department_form_active;
		}
	},
	components: {
		'new-department-form': __WEBPACK_IMPORTED_MODULE_1__new_department_form_vue__["a" /* default */],
		'department-add-btn': __WEBPACK_IMPORTED_MODULE_0__department_add_btn_vue__["a" /* default */],
		'department-del-btn': __WEBPACK_IMPORTED_MODULE_2__department_del_btn_vue__["a" /* default */],
		'department-table': __WEBPACK_IMPORTED_MODULE_3__department_table_vue__["a" /* default */],
		'department-pagination': __WEBPACK_IMPORTED_MODULE_4__department_pagination_vue__["default"]
	}

});

/***/ }),

/***/ 294:
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

/* harmony default export */ __webpack_exports__["a"] = ({

    mixins: [HRMMixin.departments],

    data: function () {
        return {
            title: '',
            description: '',
            status: '1',
            parent: '-1',
            department_id: false,
            show_spinner: false
        };
    },

    created: function () {

        this.defaultFormValu(this.$store.state.departments.department_id);

        // if ( !this.$store.state.departments.departments.length ) {
        //     this.getDepartments();
        // }
    },

    watch: {
        '$store.state.department_id': function (department_id) {
            this.defaultFormValu(department_id);
        }
    },

    computed: {
        departments: function () {
            return this.$store.state.departments.departments;
        },

        deptDropDown: function () {
            return this.$store.state.departments.dept_drop_down;
        }
    },

    methods: {
        defaultFormValu: function (department_id) {
            if (!department_id) {
                return;
            }

            var dept_index = this.getIndex(this.$store.state.departments.departments, department_id, 'id'),
                department = this.$store.state.departments.departments[dept_index];

            //console.log(department);

            this.department_id = department_id;
            this.title = department.name;
            this.description = department.description;
            this.status = department.active;
            this.parent = !parseInt(department.parent) ? '-1' : department.parent;
        },

        createNewDepartment: function () {
            var request_data = {
                _wpnonce: HRM_Vars.nonce,
                title: this.title,
                description: this.description,
                status: this.status,
                parent: this.parent,
                dept_id: this.department_id,
                page_number: this.$route.params.page_number
            },
                is_update = parseInt(this.department_id) ? true : false,
                target_index = is_update ? this.getIndex(this.$store.state.departments.departments, this.department_id, 'id') : false,
                self = this;

            this.show_spinner = true;

            wp.ajax.send('create_new_department', {
                data: request_data,

                success: function (res) {
                    self.show_spinner = false;

                    // Display a success toast, with a title
                    hrm.Toastr.success(res.success);
                    self.showHideDepartmentForm(false);

                    self.slideUp(jQuery('.hrm-form-cancel'), function () {
                        self.$store.commit('departments/showHideDepartmentForm', false);
                    });

                    self.$store.commit('departments/updateDepartment', {
                        is_update: is_update,
                        dept_id: self.department_id,
                        target_index: target_index,
                        departments: res.departments,
                        dept_drop_down: res.dept_drop_down
                    });
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
});

/***/ }),

/***/ 345:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_department_del_btn_vue__ = __webpack_require__(290);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_a1156286_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_department_del_btn_vue__ = __webpack_require__(466);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_department_del_btn_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_a1156286_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_department_del_btn_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/departments/department-del-btn.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-a1156286", Component.options)
  } else {
    hotAPI.reload("data-v-a1156286", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 352:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(35)(false);
// imports


// module
exports.push([module.i, "\n#hrm-list-form .hrm-table-action-wrap {\n\tdisplay: inline;\n}\n.hrm-tbl-action-btn-sibling {\n\twidth: 6%;\n}\n.hrm-left-action {\n\tmargin-bottom: 2%;\n}\n", ""]);

// exports


/***/ }),

/***/ 382:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_department_add_btn_vue__ = __webpack_require__(289);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_5a5a4d53_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_department_add_btn_vue__ = __webpack_require__(442);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_department_add_btn_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_5a5a4d53_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_department_add_btn_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/departments/department-add-btn.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5a5a4d53", Component.options)
  } else {
    hotAPI.reload("data-v-5a5a4d53", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 383:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_department_edit_btn_vue__ = __webpack_require__(291);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_701887f4_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_department_edit_btn_vue__ = __webpack_require__(451);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_department_edit_btn_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_701887f4_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_department_edit_btn_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/departments/department-edit-btn.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-701887f4", Component.options)
  } else {
    hotAPI.reload("data-v-701887f4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 384:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_department_table_vue__ = __webpack_require__(292);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_75813db1_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_department_table_vue__ = __webpack_require__(454);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_department_table_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_75813db1_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_department_table_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/departments/department-table.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-75813db1", Component.options)
  } else {
    hotAPI.reload("data-v-75813db1", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 385:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_new_department_form_vue__ = __webpack_require__(294);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_b09a05f8_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_new_department_form_vue__ = __webpack_require__(469);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_new_department_form_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_b09a05f8_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_new_department_form_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/departments/new-department-form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-b09a05f8", Component.options)
  } else {
    hotAPI.reload("data-v-b09a05f8", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 39:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_department_pagination_vue__ = __webpack_require__(155);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_340e4472_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_department_pagination_vue__ = __webpack_require__(280);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_department_pagination_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_340e4472_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_department_pagination_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/departments/department-pagination.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-340e4472", Component.options)
  } else {
    hotAPI.reload("data-v-340e4472", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 418:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "hrm-content-wrap" }, [
    _c("div", { staticClass: "hrm-department" }, [
      _c("div", { staticClass: "hrm-update-notification" }),
      _vm._v(" "),
      _c("div", { attrs: { id: "hrm-admin-department" } }, [
        _vm.is_new_department_form_visible
          ? _c(
              "div",
              {
                directives: [
                  { name: "hrm-slide-down", rawName: "v-hrm-slide-down" }
                ],
                staticClass: "hrm-slide-up",
                staticStyle: { display: "none" }
              },
              [_c("new-department-form")],
              1
            )
          : _vm._e(),
        _vm._v(" "),
        _c(
          "form",
          { attrs: { id: "hrm-list-form", action: "", method: "post" } },
          [
            _c("div", { staticClass: "hrm-table-action-wrap" }, [
              _c(
                "div",
                { staticClass: "hrm-left-action" },
                [
                  _c("department-add-btn"),
                  _vm._v(" "),
                  _c("department-del-btn", { attrs: { type: "group" } }),
                  _vm._v(" "),
                  _c("span", { staticClass: "hrm-clear" })
                ],
                1
              ),
              _vm._v(" "),
              _c("span", { staticClass: "hrm-clear" })
            ]),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "dataTables_wrapper no-footer",
                attrs: { id: "hrm-data-table_wrapper" }
              },
              [_c("department-table")],
              1
            )
          ]
        )
      ])
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
    require("vue-hot-reload-api")      .rerender("data-v-180e36b3", esExports)
  }
}

/***/ }),

/***/ 442:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.manageDepartment()
    ? _c("div", { staticClass: "hrm-tbl-action-btn-sibling" }, [
        _c(
          "a",
          {
            staticClass: "button hrm-button-primary button-primary",
            attrs: { href: "#" },
            on: {
              click: function($event) {
                $event.preventDefault()
                _vm.showHideDepartmentForm("toggle")
              }
            }
          },
          [_vm._v("Add")]
        )
      ])
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-5a5a4d53", esExports)
  }
}

/***/ }),

/***/ 451:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.manageDepartment()
    ? _c("div", { staticClass: "hrm-department-edit-btn-wrap" }, [
        _c(
          "a",
          {
            staticClass: "hrm-edit",
            attrs: {
              href: "#",
              "data-table_option": "hrm_job_title_option",
              "data-id": "3"
            },
            on: {
              click: function($event) {
                $event.preventDefault()
                _vm.departmentEdit()
              }
            }
          },
          [_vm._v("Edit")]
        )
      ])
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-701887f4", esExports)
  }
}

/***/ }),

/***/ 454:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { attrs: { id: "hrm-department-tbl-wrap" } }, [
    _vm.isFetchRecord
      ? _c(
          "table",
          { staticClass: "widefat", attrs: { id: "hrm-data-table" } },
          [
            _c("thead", [
              _c("tr", { attrs: { role: "row" } }, [
                _vm.manageDepartment()
                  ? _c("th", { staticClass: "sorting_asc" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.del_all_dept,
                            expression: "del_all_dept"
                          }
                        ],
                        staticClass: "hrm-all-checked",
                        attrs: { type: "checkbox" },
                        domProps: {
                          checked: Array.isArray(_vm.del_all_dept)
                            ? _vm._i(_vm.del_all_dept, null) > -1
                            : _vm.del_all_dept
                        },
                        on: {
                          change: [
                            function($event) {
                              var $$a = _vm.del_all_dept,
                                $$el = $event.target,
                                $$c = $$el.checked ? true : false
                              if (Array.isArray($$a)) {
                                var $$v = null,
                                  $$i = _vm._i($$a, $$v)
                                if ($$el.checked) {
                                  $$i < 0 &&
                                    (_vm.del_all_dept = $$a.concat([$$v]))
                                } else {
                                  $$i > -1 &&
                                    (_vm.del_all_dept = $$a
                                      .slice(0, $$i)
                                      .concat($$a.slice($$i + 1)))
                                }
                              } else {
                                _vm.del_all_dept = $$c
                              }
                            },
                            function($event) {
                              $event.preventDefault()
                              _vm.delAllDept()
                            }
                          ]
                        }
                      })
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _c("th", { staticClass: "sorting" }, [
                  _vm._v(
                    "\n                    Department Title\n                "
                  )
                ]),
                _vm._v(" "),
                _c("th", { staticClass: "sorting" }, [
                  _vm._v(
                    "\n                    Department Description\n                "
                  )
                ]),
                _vm._v(" "),
                _c("th", { staticClass: "sorting" }, [
                  _vm._v("\n                    Status\n                ")
                ]),
                _vm._v(" "),
                _c("th", { staticClass: "sorting" }, [
                  _vm._v(
                    "\n                    No. of Employee\n                "
                  )
                ])
              ])
            ]),
            _vm._v(" "),
            _c(
              "tbody",
              [
                _vm._l(_vm.departments, function(department) {
                  return _c(
                    "tr",
                    {
                      staticClass: "hrm-even hrm-tr odd",
                      attrs: { role: "row" }
                    },
                    [
                      _vm.manageDepartment()
                        ? _c(
                            "td",
                            { staticClass: "hrm-table-checkbox sorting_1" },
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: _vm.del_dept,
                                    expression: "del_dept"
                                  }
                                ],
                                staticClass: "hrm-single-checked",
                                attrs: { name: "", type: "checkbox" },
                                domProps: {
                                  value: department.id,
                                  checked: Array.isArray(_vm.del_dept)
                                    ? _vm._i(_vm.del_dept, department.id) > -1
                                    : _vm.del_dept
                                },
                                on: {
                                  change: [
                                    function($event) {
                                      var $$a = _vm.del_dept,
                                        $$el = $event.target,
                                        $$c = $$el.checked ? true : false
                                      if (Array.isArray($$a)) {
                                        var $$v = department.id,
                                          $$i = _vm._i($$a, $$v)
                                        if ($$el.checked) {
                                          $$i < 0 &&
                                            (_vm.del_dept = $$a.concat([$$v]))
                                        } else {
                                          $$i > -1 &&
                                            (_vm.del_dept = $$a
                                              .slice(0, $$i)
                                              .concat($$a.slice($$i + 1)))
                                        }
                                      } else {
                                        _vm.del_dept = $$c
                                      }
                                    },
                                    function($event) {
                                      $event.preventDefault()
                                      _vm.delDept(department)
                                    }
                                  ]
                                }
                              })
                            ]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _c("td", [
                        _vm.manageDepartment()
                          ? _c("div", { staticClass: "hrm-title-wrap" }, [
                              _c(
                                "div",
                                { staticClass: "hrm-editable hrm-title" },
                                [
                                  _c("span", {
                                    domProps: {
                                      innerHTML: _vm._s(
                                        department.hierarchical_pad
                                      )
                                    }
                                  }),
                                  _c("span", [_vm._v(_vm._s(department.name))])
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "div",
                                { staticClass: "hrm-title-action row-actions" },
                                [
                                  _c("department-edit-btn", {
                                    attrs: { department_id: department.id }
                                  }),
                                  _vm._v(" "),
                                  _c("department-del-btn", {
                                    attrs: {
                                      department_id: department.id,
                                      type: "single"
                                    }
                                  }),
                                  _vm._v(" "),
                                  _c("span", { staticClass: "hrm-clear" })
                                ],
                                1
                              )
                            ])
                          : _c("div", { staticClass: "hrm-title-wrap" }, [
                              _c("span", {
                                staticClass: "hrm-editable hrm-title",
                                domProps: {
                                  innerHTML: _vm._s(department.hierarchical_pad)
                                }
                              }),
                              _c("span", [_vm._v(_vm._s(department.name))])
                            ])
                      ]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(department.description))]),
                      _vm._v(" "),
                      _c("td", [
                        _vm._v(_vm._s(_vm.departmentActivity(department)))
                      ]),
                      _vm._v(" "),
                      _c("td", [_vm._v(_vm._s(department.number_of_employee))])
                    ]
                  )
                }),
                _vm._v(" "),
                !_vm.departments.length
                  ? _c("tr", [
                      _c("td", { attrs: { colspan: "5" } }, [
                        _vm._v(
                          "\n                    No record found!\n                "
                        )
                      ])
                    ])
                  : _vm._e()
              ],
              2
            )
          ]
        )
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-75813db1", esExports)
  }
}

/***/ }),

/***/ 466:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.manageDepartment()
    ? _c(
        "div",
        {
          staticClass: "hrm-department-del-btn-wrap hrm-tbl-action-btn-sibling"
        },
        [
          _vm.type == "group"
            ? _c(
                "a",
                {
                  staticClass: "button hrm-button-secondary",
                  attrs: { href: "#" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      _vm.departmentGroupDelete()
                    }
                  }
                },
                [_vm._v("Delete")]
              )
            : _vm._e(),
          _vm._v(" "),
          _vm.type == "single"
            ? _c(
                "a",
                {
                  staticClass: "hrm-delete",
                  attrs: { href: "#" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      _vm.departmentDelete()
                    }
                  }
                },
                [_vm._v("Delete")]
              )
            : _vm._e()
        ]
      )
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-a1156286", esExports)
  }
}

/***/ }),

/***/ 469:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "metabox-holder" }, [
    _vm.manageDepartment()
      ? _c(
          "div",
          { staticClass: "postbox", attrs: { id: "hrm-hidden-form-warp" } },
          [
            _c("h2", { staticClass: "hndle" }, [_vm._v("Department")]),
            _vm._v(" "),
            _c("div", { staticClass: "inside" }, [
              _c(
                "form",
                {
                  attrs: { id: "hrm-hidden-form", action: "" },
                  on: {
                    submit: function($event) {
                      $event.preventDefault()
                      _vm.createNewDepartment()
                    }
                  }
                },
                [
                  _c("div", { attrs: { id: "hrm-form-field" } }, [
                    _c("div", { staticClass: "hrm-form-field " }, [
                      _vm._m(0),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.title,
                            expression: "title"
                          }
                        ],
                        staticClass: "title",
                        attrs: {
                          type: "text",
                          required: "required",
                          name: "title",
                          value: "",
                          placeholder: "",
                          id: "title",
                          "data-hrm_validation": "1",
                          "data-hrm_required": "1",
                          "data-hrm_required_error_msg":
                            "This field is required"
                        },
                        domProps: { value: _vm.title },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.title = $event.target.value
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "hrm-clear" }),
                      _vm._v(" "),
                      _c("span", { staticClass: "description" })
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "hrm-form-field " }, [
                      _vm._m(1),
                      _vm._v(" "),
                      _c("textarea", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.description,
                            expression: "description"
                          }
                        ],
                        staticClass: "hrm-admin-notice-field",
                        attrs: { name: "description", id: "description" },
                        domProps: { value: _vm.description },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.description = $event.target.value
                          }
                        }
                      }),
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
                              value: _vm.status,
                              expression: "status"
                            }
                          ],
                          staticClass: "status",
                          attrs: {
                            name: "status",
                            id: "status",
                            "data-placeholder": "-- Chose --"
                          },
                          on: {
                            change: function($event) {
                              var $$selectedVal = Array.prototype.filter
                                .call($event.target.options, function(o) {
                                  return o.selected
                                })
                                .map(function(o) {
                                  var val = "_value" in o ? o._value : o.value
                                  return val
                                })
                              _vm.status = $event.target.multiple
                                ? $$selectedVal
                                : $$selectedVal[0]
                            }
                          }
                        },
                        [
                          _c("option", { attrs: { value: "1" } }, [
                            _vm._v("Enable")
                          ]),
                          _vm._v(" "),
                          _c("option", { attrs: { value: "0" } }, [
                            _vm._v("Desable")
                          ])
                        ]
                      ),
                      _vm._v(" "),
                      _c("span", { staticClass: "hrm-clear" }),
                      _vm._v(" "),
                      _c("span", { staticClass: "description" }, [
                        _vm._v("Choose department status")
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "hrm-action-wrap" }, [
                    _c("input", {
                      staticClass: "button hrm-button-primary button-primary",
                      attrs: { type: "submit", name: "requst", value: "Submit" }
                    }),
                    _vm._v(" "),
                    _c(
                      "a",
                      {
                        staticClass: "button hrm-button-secondary",
                        attrs: { target: "_blank", href: "#" },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            _vm.showHideDepartmentForm(false)
                          }
                        }
                      },
                      [_vm._v("Cancel")]
                    ),
                    _vm._v(" "),
                    _vm.show_spinner
                      ? _c("div", { staticClass: "hrm-spinner" }, [
                          _vm._v("Saving....")
                        ])
                      : _vm._e()
                  ])
                ]
              )
            ])
          ]
        )
      : _vm._e()
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: "title" } }, [
      _vm._v("\n                            Title"),
      _c("em", [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: "description" } }, [
      _vm._v("\n                            Description"),
      _c("em")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { attrs: { for: "status" } }, [
      _vm._v("Status"),
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
    require("vue-hot-reload-api")      .rerender("data-v-b09a05f8", esExports)
  }
}

/***/ }),

/***/ 47:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_departments_vue__ = __webpack_require__(293);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_180e36b3_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_departments_vue__ = __webpack_require__(418);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(479)
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_departments_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_180e36b3_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_departments_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/departments/departments.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-180e36b3", Component.options)
  } else {
    hotAPI.reload("data-v-180e36b3", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 479:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(352);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(36)("7997c263", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-180e36b3\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./departments.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-180e36b3\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./departments.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ })

});