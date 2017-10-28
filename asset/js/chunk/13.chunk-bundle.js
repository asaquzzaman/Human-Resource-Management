webpackJsonp([13],{

/***/ 10:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_form_settings_vue__ = __webpack_require__(32);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_49d63b01_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_form_settings_vue__ = __webpack_require__(66);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(73)
}
var normalizeComponent = __webpack_require__(1)
/* script */

/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_form_settings_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_49d63b01_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_form_settings_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "asset/js/components/leave/leave-form-settings.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] leave-form-settings.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-49d63b01", Component.options)
  } else {
    hotAPI.reload("data-v-49d63b01", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 26:
/***/ (function(module, exports, __webpack_require__) {

!function (e, t) {
   true ? module.exports = t() : "function" == typeof define && define.amd ? define([], t) : "object" == typeof exports ? exports.VueMultiselect = t() : e.VueMultiselect = t();
}(this, function () {
  return function (e) {
    function t(n) {
      if (i[n]) return i[n].exports;var s = i[n] = { i: n, l: !1, exports: {} };return e[n].call(s.exports, s, s.exports, t), s.l = !0, s.exports;
    }var i = {};return t.m = e, t.c = i, t.i = function (e) {
      return e;
    }, t.d = function (e, i, n) {
      t.o(e, i) || Object.defineProperty(e, i, { configurable: !1, enumerable: !0, get: n });
    }, t.n = function (e) {
      var i = e && e.__esModule ? function () {
        return e.default;
      } : function () {
        return e;
      };return t.d(i, "a", i), i;
    }, t.o = function (e, t) {
      return Object.prototype.hasOwnProperty.call(e, t);
    }, t.p = "/", t(t.s = 4);
  }([function (e, t, i) {
    "use strict";
    function n(e, t, i) {
      return t in e ? Object.defineProperty(e, t, { value: i, enumerable: !0, configurable: !0, writable: !0 }) : e[t] = i, e;
    }function s(e, t) {
      return !!e && -1 !== e.toString().toLowerCase().indexOf(t.trim());
    }function l(e, t, i) {
      return i ? e.filter(function (e) {
        return s(e[i], t);
      }) : e.filter(function (e) {
        return s(e, t);
      });
    }function o(e) {
      return e.filter(function (e) {
        return !e.$isLabel;
      });
    }function r(e, t) {
      return function (i) {
        return i.reduce(function (i, n) {
          return n[e] && n[e].length ? (i.push({ $groupLabel: n[t], $isLabel: !0 }), i.concat(n[e])) : i.concat(n);
        }, []);
      };
    }function a(e, t, i, s) {
      return function (o) {
        return o.map(function (o) {
          var r,
              a = l(o[i], e, t);return a.length ? (r = {}, n(r, s, o[s]), n(r, i, a), r) : [];
        });
      };
    }Object.defineProperty(t, "__esModule", { value: !0 });var u = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
      return typeof e;
    } : function (e) {
      return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
    },
        c = i(2),
        h = function (e) {
      return e && e.__esModule ? e : { default: e };
    }(c),
        p = function () {
      for (var e = arguments.length, t = Array(e), i = 0; i < e; i++) t[i] = arguments[i];return function (e) {
        return t.reduce(function (e, t) {
          return t(e);
        }, e);
      };
    };t.default = { data: function () {
        return { search: "", isOpen: !1, hasEnoughSpace: !0, internalValue: this.value || 0 === this.value ? (0, h.default)(Array.isArray(this.value) ? this.value : [this.value]) : [] };
      }, props: { internalSearch: { type: Boolean, default: !0 }, options: { type: Array, required: !0 }, multiple: { type: Boolean, default: !1 }, value: { type: null, default: function () {
            return [];
          } }, trackBy: { type: String }, label: { type: String }, searchable: { type: Boolean, default: !0 }, clearOnSelect: { type: Boolean, default: !0 }, hideSelected: { type: Boolean, default: !1 }, placeholder: { type: String, default: "Select option" }, allowEmpty: { type: Boolean, default: !0 }, resetAfter: { type: Boolean, default: !1 }, closeOnSelect: { type: Boolean, default: !0 }, customLabel: { type: Function, default: function (e, t) {
            return t ? e[t] : e;
          } }, taggable: { type: Boolean, default: !1 }, tagPlaceholder: { type: String, default: "Press enter to create a tag" }, max: { type: Number }, id: { default: null }, optionsLimit: { type: Number, default: 1e3 }, groupValues: { type: String }, groupLabel: { type: String }, blockKeys: { type: Array, default: function () {
            return [];
          } } }, mounted: function () {
        this.multiple || this.clearOnSelect || console.warn("[Vue-Multiselect warn]: ClearOnSelect and Multiple props can’t be both set to false.");
      }, computed: { filteredOptions: function () {
          var e = this.search || "",
              t = e.toLowerCase(),
              i = this.options.concat();return this.internalSearch ? (i = this.groupValues ? this.filterAndFlat(i, t, this.label) : l(i, t, this.label), i = this.hideSelected ? i.filter(this.isNotSelected) : i) : i = this.groupValues ? r(this.groupValues, this.groupLabel)(i) : i, this.taggable && t.length && !this.isExistingOption(t) && i.unshift({ isTag: !0, label: e }), i.slice(0, this.optionsLimit);
        }, valueKeys: function () {
          var e = this;return this.trackBy ? this.internalValue.map(function (t) {
            return t[e.trackBy];
          }) : this.internalValue;
        }, optionKeys: function () {
          var e = this,
              t = this.groupValues ? this.flatAndStrip(this.options) : this.options;return this.label ? t.map(function (t) {
            return t[e.label].toString().toLowerCase();
          }) : t.map(function (e) {
            return e.toString().toLowerCase();
          });
        }, currentOptionLabel: function () {
          return this.multiple ? this.searchable ? "" : this.placeholder : this.internalValue[0] ? this.getOptionLabel(this.internalValue[0]) : this.searchable ? "" : this.placeholder;
        } }, watch: { internalValue: function (e, t) {
          this.resetAfter && this.internalValue.length && (this.search = "", this.internalValue = []);
        }, search: function () {
          this.$emit("search-change", this.search, this.id);
        }, value: function (e) {
          this.internalValue = this.getInternalValue(e);
        } }, methods: { getValue: function () {
          return this.multiple ? (0, h.default)(this.internalValue) : 0 === this.internalValue.length ? null : (0, h.default)(this.internalValue[0]);
        }, getInternalValue: function (e) {
          return null === e || void 0 === e ? [] : this.multiple ? (0, h.default)(e) : (0, h.default)([e]);
        }, filterAndFlat: function (e) {
          return p(a(this.search, this.label, this.groupValues, this.groupLabel), r(this.groupValues, this.groupLabel))(e);
        }, flatAndStrip: function (e) {
          return p(r(this.groupValues, this.groupLabel), o)(e);
        }, updateSearch: function (e) {
          this.search = e;
        }, isExistingOption: function (e) {
          return !!this.options && this.optionKeys.indexOf(e) > -1;
        }, isSelected: function (e) {
          var t = this.trackBy ? e[this.trackBy] : e;return this.valueKeys.indexOf(t) > -1;
        }, isNotSelected: function (e) {
          return !this.isSelected(e);
        }, getOptionLabel: function (e) {
          return e || 0 === e ? e.isTag ? e.label : this.customLabel(e, this.label) || "" : "";
        }, select: function (e, t) {
          if (!(-1 !== this.blockKeys.indexOf(t) || this.disabled || e.$isLabel || this.max && this.multiple && this.internalValue.length === this.max)) {
            if (e.isTag) this.$emit("tag", e.label, this.id), this.search = "", this.closeOnSelect && !this.multiple && this.deactivate();else {
              if (this.isSelected(e)) return void ("Tab" !== t && this.removeElement(e));this.multiple ? this.internalValue.push(e) : this.internalValue = [e], this.$emit("select", (0, h.default)(e), this.id), this.$emit("input", this.getValue(), this.id), this.clearOnSelect && (this.search = "");
            }this.closeOnSelect && this.deactivate();
          }
        }, removeElement: function (e) {
          if (!this.disabled && (this.allowEmpty || !(this.internalValue.length <= 1))) {
            var t = "object" === (void 0 === e ? "undefined" : u(e)) ? this.valueKeys.indexOf(e[this.trackBy]) : this.valueKeys.indexOf(e);this.internalValue.splice(t, 1), this.$emit("remove", (0, h.default)(e), this.id), this.$emit("input", this.getValue(), this.id), this.closeOnSelect && this.deactivate();
          }
        }, removeLastElement: function () {
          -1 === this.blockKeys.indexOf("Delete") && 0 === this.search.length && Array.isArray(this.internalValue) && this.removeElement(this.internalValue[this.internalValue.length - 1]);
        }, activate: function () {
          this.isOpen || this.disabled || (this.adjustPosition(), this.groupValues && 0 === this.pointer && this.filteredOptions.length && (this.pointer = 1), this.isOpen = !0, this.searchable ? (this.search = "", this.$refs.search.focus()) : this.$el.focus(), this.$emit("open", this.id));
        }, deactivate: function () {
          this.isOpen && (this.isOpen = !1, this.searchable ? this.$refs.search.blur() : this.$el.blur(), this.search = "", this.$emit("close", this.getValue(), this.id));
        }, toggle: function () {
          this.isOpen ? this.deactivate() : this.activate();
        }, adjustPosition: function () {
          "undefined" != typeof window && (this.hasEnoughSpace = this.$el.getBoundingClientRect().top + this.maxHeight < window.innerHeight);
        } } };
  }, function (e, t, i) {
    "use strict";
    Object.defineProperty(t, "__esModule", { value: !0 }), t.default = { data: function () {
        return { pointer: 0, visibleElements: this.maxHeight / this.optionHeight };
      }, props: { showPointer: { type: Boolean, default: !0 }, optionHeight: { type: Number, default: 40 } }, computed: { pointerPosition: function () {
          return this.pointer * this.optionHeight;
        } }, watch: { filteredOptions: function () {
          this.pointerAdjust();
        } }, methods: { optionHighlight: function (e, t) {
          return { "multiselect__option--highlight": e === this.pointer && this.showPointer, "multiselect__option--selected": this.isSelected(t) };
        }, addPointerElement: function () {
          var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "Enter",
              t = e.key;this.filteredOptions.length > 0 && this.select(this.filteredOptions[this.pointer], t), this.pointerReset();
        }, pointerForward: function () {
          this.pointer < this.filteredOptions.length - 1 && (this.pointer++, this.$refs.list.scrollTop <= this.pointerPosition - this.visibleElements * this.optionHeight && (this.$refs.list.scrollTop = this.pointerPosition - (this.visibleElements - 1) * this.optionHeight), this.filteredOptions[this.pointer].$isLabel && this.pointerForward());
        }, pointerBackward: function () {
          this.pointer > 0 ? (this.pointer--, this.$refs.list.scrollTop >= this.pointerPosition && (this.$refs.list.scrollTop = this.pointerPosition), this.filteredOptions[this.pointer].$isLabel && this.pointerBackward()) : this.filteredOptions[0].$isLabel && this.pointerForward();
        }, pointerReset: function () {
          this.closeOnSelect && (this.pointer = 0, this.$refs.list && (this.$refs.list.scrollTop = 0));
        }, pointerAdjust: function () {
          this.pointer >= this.filteredOptions.length - 1 && (this.pointer = this.filteredOptions.length ? this.filteredOptions.length - 1 : 0);
        }, pointerSet: function (e) {
          this.pointer = e;
        } } };
  }, function (e, t, i) {
    "use strict";
    function n(e) {
      if (Array.isArray(e)) return e.map(n);if (e && "object" === (void 0 === e ? "undefined" : s(e))) {
        for (var t = {}, i = Object.keys(e), l = 0, o = i.length; l < o; l++) {
          var r = i[l];t[r] = n(e[r]);
        }return t;
      }return e;
    }Object.defineProperty(t, "__esModule", { value: !0 });var s = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
      return typeof e;
    } : function (e) {
      return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
    };t.default = n;
  }, function (e, t, i) {
    i(6);var n = i(7)(i(5), i(8), null, null);e.exports = n.exports;
  }, function (e, t, i) {
    "use strict";
    function n(e) {
      return e && e.__esModule ? e : { default: e };
    }Object.defineProperty(t, "__esModule", { value: !0 }), t.deepClone = t.pointerMixin = t.multiselectMixin = t.Multiselect = void 0;var s = i(3),
        l = n(s),
        o = i(0),
        r = n(o),
        a = i(1),
        u = n(a),
        c = i(2),
        h = n(c);t.default = l.default, t.Multiselect = l.default, t.multiselectMixin = r.default, t.pointerMixin = u.default, t.deepClone = h.default;
  }, function (e, t, i) {
    "use strict";
    function n(e) {
      return e && e.__esModule ? e : { default: e };
    }Object.defineProperty(t, "__esModule", { value: !0 });var s = i(0),
        l = n(s),
        o = i(1),
        r = n(o);t.default = { name: "vue-multiselect", mixins: [l.default, r.default], props: { selectLabel: { type: String, default: "Press enter to select" }, selectedLabel: { type: String, default: "Selected" }, deselectLabel: { type: String, default: "Press enter to remove" }, showLabels: { type: Boolean, default: !0 }, limit: { type: Number, default: 99999 }, maxHeight: { type: Number, default: 300 }, limitText: { type: Function, default: function (e) {
            return "and " + e + " more";
          } }, loading: { type: Boolean, default: !1 }, disabled: { type: Boolean, default: !1 } }, computed: { visibleValue: function () {
          return this.multiple ? this.internalValue.slice(0, this.limit) : [];
        }, deselectLabelText: function () {
          return this.showLabels ? this.deselectLabel : "";
        }, selectLabelText: function () {
          return this.showLabels ? this.selectLabel : "";
        }, selectedLabelText: function () {
          return this.showLabels ? this.selectedLabel : "";
        } } };
  }, function (e, t) {}, function (e, t) {
    e.exports = function (e, t, i, n) {
      var s,
          l = e = e || {},
          o = typeof e.default;"object" !== o && "function" !== o || (s = e, l = e.default);var r = "function" == typeof l ? l.options : l;if (t && (r.render = t.render, r.staticRenderFns = t.staticRenderFns), i && (r._scopeId = i), n) {
        var a = Object.create(r.computed || null);Object.keys(n).forEach(function (e) {
          var t = n[e];a[e] = function () {
            return t;
          };
        }), r.computed = a;
      }return { esModule: s, exports: l, options: r };
    };
  }, function (e, t) {
    e.exports = { render: function () {
        var e = this,
            t = e.$createElement,
            i = e._self._c || t;return i("div", { staticClass: "multiselect", class: { "multiselect--active": e.isOpen, "multiselect--disabled": e.disabled, "multiselect--above": !e.hasEnoughSpace }, attrs: { tabindex: e.searchable ? -1 : 0 }, on: { focus: function (t) {
              e.activate();
            }, blur: function (t) {
              !e.searchable && e.deactivate();
            }, keydown: [function (t) {
              e._k(t.keyCode, "down", 40) || t.target === t.currentTarget && (t.preventDefault(), e.pointerForward());
            }, function (t) {
              e._k(t.keyCode, "up", 38) || t.target === t.currentTarget && (t.preventDefault(), e.pointerBackward());
            }, function (t) {
              e._k(t.keyCode, "enter", 13) && e._k(t.keyCode, "tab", 9) || (t.stopPropagation(), t.target === t.currentTarget && e.addPointerElement(t));
            }], keyup: function (t) {
              e._k(t.keyCode, "esc", 27) || e.deactivate();
            } } }, [e._t("carret", [i("div", { staticClass: "multiselect__select", on: { mousedown: function (t) {
              t.preventDefault(), e.toggle();
            } } })]), e._v(" "), i("div", { ref: "tags", staticClass: "multiselect__tags" }, [e._l(e.visibleValue, function (t) {
          return i("span", { staticClass: "multiselect__tag", on: { mousedown: function (e) {
                e.preventDefault();
              } } }, [i("span", { domProps: { textContent: e._s(e.getOptionLabel(t)) } }), e._v(" "), i("i", { staticClass: "multiselect__tag-icon", attrs: { "aria-hidden": "true", tabindex: "1" }, on: { keydown: function (i) {
                e._k(i.keyCode, "enter", 13) || (i.preventDefault(), e.removeElement(t));
              }, mousedown: function (i) {
                i.preventDefault(), e.removeElement(t);
              } } })]);
        }), e._v(" "), e.internalValue && e.internalValue.length > e.limit ? [i("strong", { domProps: { textContent: e._s(e.limitText(e.internalValue.length - e.limit)) } })] : e._e(), e._v(" "), i("transition", { attrs: { name: "multiselect__loading" } }, [e._t("loading", [i("div", { directives: [{ name: "show", rawName: "v-show", value: e.loading, expression: "loading" }], staticClass: "multiselect__spinner" })])], 2), e._v(" "), e.searchable ? i("input", { ref: "search", staticClass: "multiselect__input", attrs: { type: "text", autocomplete: "off", placeholder: e.placeholder, disabled: e.disabled }, domProps: { value: e.isOpen ? e.search : e.currentOptionLabel }, on: { input: function (t) {
              e.updateSearch(t.target.value);
            }, focus: function (t) {
              t.preventDefault(), e.activate();
            }, blur: function (t) {
              t.preventDefault(), e.deactivate();
            }, keyup: function (t) {
              e._k(t.keyCode, "esc", 27) || e.deactivate();
            }, keydown: [function (t) {
              e._k(t.keyCode, "down", 40) || (t.preventDefault(), e.pointerForward());
            }, function (t) {
              e._k(t.keyCode, "up", 38) || (t.preventDefault(), e.pointerBackward());
            }, function (t) {
              e._k(t.keyCode, "enter", 13) || t.preventDefault();
            }, function (t) {
              e._k(t.keyCode, "enter", 13) && e._k(t.keyCode, "tab", 9) || (t.stopPropagation(), t.target === t.currentTarget && e.addPointerElement(t));
            }, function (t) {
              e._k(t.keyCode, "delete", [8, 46]) || e.removeLastElement();
            }] } }) : e._e(), e._v(" "), e.searchable ? e._e() : i("span", { staticClass: "multiselect__single", domProps: { textContent: e._s(e.currentOptionLabel) } })], 2), e._v(" "), i("transition", { attrs: { name: "multiselect" } }, [i("ul", { directives: [{ name: "show", rawName: "v-show", value: e.isOpen, expression: "isOpen" }], ref: "list", staticClass: "multiselect__content", style: { maxHeight: e.maxHeight + "px" }, on: { mousedown: function (e) {
              e.preventDefault();
            } } }, [e._t("beforeList"), e._v(" "), e.multiple && e.max === e.internalValue.length ? i("li", [i("span", { staticClass: "multiselect__option" }, [e._t("maxElements", [e._v("Maximum of " + e._s(e.max) + " options selected. First remove a selected option to select another.")])], 2)]) : e._e(), e._v(" "), !e.max || e.internalValue.length < e.max ? e._l(e.filteredOptions, function (t, n) {
          return i("li", { key: n, staticClass: "multiselect__element" }, [t.$isLabel ? e._e() : i("span", { staticClass: "multiselect__option", class: e.optionHighlight(n, t), attrs: { tabindex: "0", "data-select": t.isTag ? e.tagPlaceholder : e.selectLabelText, "data-selected": e.selectedLabelText, "data-deselect": e.deselectLabelText }, on: { mousedown: function (i) {
                i.preventDefault(), e.select(t);
              }, mouseenter: function (t) {
                e.pointerSet(n);
              } } }, [e._t("option", [i("span", [e._v(e._s(e.getOptionLabel(t)))])], { option: t, search: e.search })], 2), e._v(" "), t.$isLabel ? i("span", { staticClass: "multiselect__option multiselect__option--disabled", class: e.optionHighlight(n, t) }, [e._v("\n              " + e._s(t.$groupLabel) + "\n            ")]) : e._e()]);
        }) : e._e(), e._v(" "), i("li", { directives: [{ name: "show", rawName: "v-show", value: 0 === e.filteredOptions.length && e.search && !e.loading, expression: "filteredOptions.length === 0 && search && !loading" }] }, [i("span", { staticClass: "multiselect__option" }, [e._t("noResult", [e._v("No elements found. Consider changing the search query.")])], 2)]), e._v(" "), e._t("afterList")], 2)])], 2);
      }, staticRenderFns: [] };
  }]);
});

/***/ }),

/***/ 32:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__vue_multiselect_vue_multiselect_min__ = __webpack_require__(26);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__vue_multiselect_vue_multiselect_min___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__vue_multiselect_vue_multiselect_min__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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

	components: {
		'hrm-multiselect': __WEBPACK_IMPORTED_MODULE_0__vue_multiselect_vue_multiselect_min___default.a
	},

	methods: {
		getLeaveFromSettings() {
			var self = this;
			var request = {
				data: {},
				success(res) {
					self.roles = self.processRoles(res.roles);
					self.others_employee = self.processOthersEmployee(res.settings, res.roles);
					self.leave_types = self.processLeaveTypes(res.settings, res.roles);
					self.apply_to = self.processApplyTo(res.settings, res.roles);
				}
			};
			this.httpRequest('get_leave_form_settings', request);
		},

		processLeaveTypes(settings, roles) {
			if (typeof settings.leave_types === 'undefined') {
				return [];
			}

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

/***/ 46:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(47)(undefined);
// imports


// module
exports.push([module.i, "\n#hrm-hidden-form span {\n\tdisplay: inline-block !important;\n}\n.multiselect__tags {\n\tdisplay: inline-block !important;\n\twidth: 100%;\n}\n.multiselect__input {\n\tborder: none !important;\n\tbox-shadow: none !important;\n}\n\n", ""]);

// exports


/***/ }),

/***/ 47:
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

/***/ 66:
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
        _vm.saveLeaveFormSettings()
      }
    }
  }, [_c('div', {
    staticClass: "hrm-form-field"
  }, [_vm._m(1), _vm._v(" "), _c('div', {
    staticClass: "hrm-multiselect"
  }, [_c('hrm-multiselect', {
    attrs: {
      "options": _vm.roles,
      "multiple": true,
      "close-on-select": true,
      "clear-on-select": true,
      "hide-selected": false,
      "show-labels": true,
      "placeholder": "Select roles",
      "select-label": "",
      "selected-label": "selected",
      "deselect-label": "",
      "taggable": false,
      "label": "name",
      "track-by": "id",
      "allow-empty": true
    },
    model: {
      value: (_vm.others_employee),
      callback: function($$v) {
        _vm.others_employee = $$v
      },
      expression: "others_employee"
    }
  })], 1), _vm._v(" "), _c('span', {
    staticClass: "hrm-clear"
  }), _vm._v(" "), _c('span', {
    staticClass: "description"
  }, [_vm._v("This roles can aplly behalf of others employee leave")])]), _vm._v(" "), _c('div', {
    staticClass: "hrm-form-field"
  }, [_vm._m(2), _vm._v(" "), _c('div', {
    staticClass: "hrm-multiselect"
  }, [_c('hrm-multiselect', {
    attrs: {
      "options": _vm.roles,
      "multiple": true,
      "close-on-select": true,
      "clear-on-select": true,
      "hide-selected": false,
      "show-labels": true,
      "placeholder": "Select roles",
      "select-label": "",
      "selected-label": "selected",
      "deselect-label": "",
      "taggable": false,
      "label": "name",
      "track-by": "id",
      "allow-empty": true
    },
    model: {
      value: (_vm.leave_types),
      callback: function($$v) {
        _vm.leave_types = $$v
      },
      expression: "leave_types"
    }
  })], 1), _vm._v(" "), _c('span', {
    staticClass: "hrm-clear"
  }), _vm._v(" "), _c('span', {
    staticClass: "description"
  }, [_vm._v("This roles can aplly leave type enable/disable option")])]), _vm._v(" "), _c('div', {
    staticClass: "hrm-form-field"
  }, [_vm._m(3), _vm._v(" "), _c('div', {
    staticClass: "hrm-multiselect"
  }, [_c('hrm-multiselect', {
    attrs: {
      "options": _vm.roles,
      "multiple": true,
      "close-on-select": true,
      "clear-on-select": true,
      "hide-selected": false,
      "show-labels": true,
      "placeholder": "Select roles",
      "select-label": "",
      "selected-label": "selected",
      "deselect-label": "",
      "taggable": false,
      "label": "name",
      "track-by": "id",
      "allow-empty": true
    },
    model: {
      value: (_vm.apply_to),
      callback: function($$v) {
        _vm.apply_to = $$v
      },
      expression: "apply_to"
    }
  })], 1), _vm._v(" "), _c('span', {
    staticClass: "hrm-clear"
  }), _vm._v(" "), _c('span', {
    staticClass: "description"
  }, [_vm._v("This roles can change leave status")])]), _vm._v(" "), _c('input', {
    staticClass: "button hrm-submit-button button-primary",
    attrs: {
      "type": "submit",
      "name": "requst",
      "value": "Save changes"
    }
  })])])])])])
}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('h2', {
    staticClass: "hndle ui-sortable-handle"
  }, [_c('span', [_vm._v("Leave Form Settings")])])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', [_vm._v("\n\t\t\t\t\t\t\tOthers employee \n\t\t\t\t\t\t\t"), _c('em')])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', [_vm._v("\n\t\t\t\t\t\t\tLeave type  \n\t\t\t\t\t\t\t"), _c('em')])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', [_vm._v("\n\t\t\t\t\t\t\tLeave request approve by \n\t\t\t\t\t\t\t"), _c('em')])
}]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-49d63b01", esExports)
  }
}

/***/ }),

/***/ 73:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(46);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(74)("bb08730c", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-49d63b01\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-form-settings.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-49d63b01\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./leave-form-settings.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 74:
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

var listToStyles = __webpack_require__(75)

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

/***/ 75:
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