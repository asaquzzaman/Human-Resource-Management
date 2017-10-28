webpackJsonp([10],{

/***/ 12:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_vue__ = __webpack_require__(40);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_550288f7_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_vue__ = __webpack_require__(67);
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

/***/ 27:
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

/***/ 28:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_header_vue__ = __webpack_require__(27);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4dd87430_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_header_vue__ = __webpack_require__(29);
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

/***/ 29:
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

/***/ 37:
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

/***/ 38:
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
	data: function () {
		return {
			employees: [],
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
			disable_leave_type: false,
			selectedEmployee: false,
			isLoading: false,
			leave_proxy: false,
			apply_emp_lev_records: [],
			is_leave_btn_disable: false
		};
	},

	watch: {
		leave_proxy(proxy) {
			this.refresh();
			this.change_leve_type_statue();
		}
	},

	components: {
		'hrm-multiselect': __WEBPACK_IMPORTED_MODULE_0__vue_multiselect_vue_multiselect_min___default.a
	},

	created: function () {
		this.$on('hrm_date_picker', this.setDateTime);
		this.getInitialData();
	},
	methods: {
		changeEmployee: function () {
			this.refresh();
			this.change_leve_type_statue();
		},
		refresh() {
			jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('refetchEvents');
		},
		getInitialData: function () {
			var request_data = {
				_wpnonce: HRM_Vars.nonce
			},
			    self = this;

			wp.ajax.send('get_leave_records_init_data', {
				data: request_data,

				success: function (res) {
					self.leave_types = res.leave_types.data;
					self.administrators = res.apply_to;
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

			if (this.is_leave_btn_disable) {
				return false;
			}

			if (!this.apply_leave_date.length) {
				// Display a success toast, with a title
				toastr.error('Please select your leave date');
				return false;
			}

			var self = this;

			var request_data = {
				leave_comments: this.leave_comments,
				leave_type_id: !this.leave_type ? '' : this.leave_type.id,
				emp_id: !this.selectedEmployee ? false : this.selectedEmployee.ID,
				time: this.apply_leave_date,
				disable_leave_type: this.disable_leave_type,
				leave_status: 1,
				class: 'Leave',
				method: 'create'
			};

			this.show_spinner = true;

			var form_data = {
				data: request_data,

				beforSend: function (xhr) {
					self.is_leave_btn_disable = true;
				},

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
			};

			this.httpRequest('create_new_leave', form_data);
		},

		change_leve_type_statue: function () {
			jQuery.each(this.calendar_evt_id, function (index, event_id) {
				jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('removeEvents', event_id);
			});

			this.calendar_evt_id = [];
			this.apply_leave_date = [];
		},

		asyncFind(query) {
			var self = this;
			if (query.length < 3) {
				return [];
			}
			var start = jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('getView').start;
			var start = moment(start._d).format('YYYY-MM-DD');
			var end = jQuery('.hrm-leave-jquery-fullcalendar').fullCalendar('getView').end;
			var end = moment(end._d).format('YYYY-MM-DD');

			var http_data = {
				data: {
					user: query,
					start: start,
					end: end
				},
				type: 'POST',
				success(res) {
					self.employees = res;
				}
			};

			self.httpRequest('search_emp_leave_records', http_data);
		},
		clearAll() {
			this.selectedEmployee = [];
		}

	}
});

/***/ }),

/***/ 39:
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
	computed: {
		records() {
			return this.$store.state.leave_records;
		}
	},

	created() {
		this.getLeaveRecords({
			'emp_id': HRM_Vars.current_user.data.ID
		});
	}
});

/***/ }),

/***/ 40:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__leave_header_vue__ = __webpack_require__(28);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__leave_records_add_btn_vue__ = __webpack_require__(52);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__leave_records_form_vue__ = __webpack_require__(53);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__leave_records_render_vue__ = __webpack_require__(54);
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

	computed: {
		is_leave_form_active: function () {
			return this.$store.state.is_leave_form_active;
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

/***/ 52:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_add_btn_vue__ = __webpack_require__(37);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4192324c_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_add_btn_vue__ = __webpack_require__(64);
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

/***/ 53:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_form_vue__ = __webpack_require__(38);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_01588d8a_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_form_vue__ = __webpack_require__(58);
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

/***/ 54:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_leave_records_render_vue__ = __webpack_require__(39);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_cfd49448_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_leave_records_render_vue__ = __webpack_require__(71);
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

/***/ 58:
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
  }, [(_vm.leave_proxy) ? _c('div', {
    staticClass: "hrm-form-field"
  }, [_vm._m(1), _vm._v(" "), _c('div', {
    staticClass: "hrm-multiselect"
  }, [_c('hrm-multiselect', {
    attrs: {
      "select-label": "",
      "selected-label": "selected",
      "deselect-label": "",
      "id": "ajax",
      "label": "display_name",
      "track-by": "ID",
      "placeholder": "Type to search",
      "open-direction": "bottom",
      "options": _vm.employees,
      "multiple": false,
      "searchable": true
    },
    on: {
      "input": _vm.changeEmployee,
      "search-change": _vm.asyncFind
    },
    scopedSlots: _vm._u([{
      key: "clear",
      fn: function(props) {
        return [(_vm.selectedEmployee.length) ? _c('div', {
          staticClass: "multiselect__clear",
          on: {
            "mousedown": function($event) {
              $event.preventDefault();
              $event.stopPropagation();
              _vm.clearAll(props.search)
            }
          }
        }) : _vm._e()]
      }
    }]),
    model: {
      value: (_vm.selectedEmployee),
      callback: function($$v) {
        _vm.selectedEmployee = $$v
      },
      expression: "selectedEmployee"
    }
  }, [_c('span', {
    slot: "noResult"
  }, [_vm._v("No user found.")])])], 1), _vm._v(" "), _c('div', {
    staticClass: "hrm-clear"
  })]) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "hrm-form-field "
  }, [_vm._m(2), _vm._v(" "), _c('span', {
    staticClass: "hrm-checkbox-wrap"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.leave_proxy),
      expression: "leave_proxy"
    }],
    attrs: {
      "type": "checkbox",
      "id": "hrm-disable-leave-proxy-checkbox"
    },
    domProps: {
      "checked": Array.isArray(_vm.leave_proxy) ? _vm._i(_vm.leave_proxy, null) > -1 : (_vm.leave_proxy)
    },
    on: {
      "__c": function($event) {
        var $$a = _vm.leave_proxy,
          $$el = $event.target,
          $$c = $$el.checked ? (true) : (false);
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && (_vm.leave_proxy = $$a.concat($$v))
          } else {
            $$i > -1 && (_vm.leave_proxy = $$a.slice(0, $$i).concat($$a.slice($$i + 1)))
          }
        } else {
          _vm.leave_proxy = $$c
        }
      }
    }
  }), _vm._v(" "), _c('label', {
    staticClass: "hrm-radio",
    attrs: {
      "for": "hrm-disable-leave-proxy-checkbox"
    }
  }, [_vm._v("Enable/Disable")])]), _vm._v(" "), _c('span', {
    staticClass: "hrm-clear"
  }), _vm._v(" "), _c('span', {
    staticClass: "description"
  }, [_vm._v("you can apply on behalf of others employee leave")])]), _vm._v(" "), (!_vm.disable_leave_type) ? _c('div', {
    staticClass: "hrm-form-field"
  }, [_vm._m(3), _vm._v(" "), _c('div', {
    staticClass: "hrm-multiselect"
  }, [_c('hrm-multiselect', {
    attrs: {
      "options": _vm.leave_types,
      "multiple": false,
      "close-on-select": true,
      "clear-on-select": true,
      "hide-selected": false,
      "show-labels": true,
      "placeholder": "Select leave type",
      "select-label": "",
      "selected-label": "selected",
      "deselect-label": "",
      "taggable": false,
      "label": "name",
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
  })]) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "hrm-form-field "
  }, [_vm._m(4), _vm._v(" "), _c('span', {
    staticClass: "hrm-checkbox-wrap"
  }, [_c('input', {
    attrs: {
      "type": "checkbox",
      "id": "hrm-disable-leave-type-checkbox"
    },
    on: {
      "change": function($event) {
        _vm.onOff('disable_leave_type')
      }
    }
  }), _vm._v(" "), _c('label', {
    staticClass: "hrm-radio",
    attrs: {
      "for": "hrm-disable-leave-type-checkbox"
    }
  }, [_vm._v("Enable/Disable")])]), _vm._v(" "), _c('span', {
    staticClass: "hrm-clear"
  }), _vm._v(" "), _c('span', {
    staticClass: "description"
  })]), _vm._v(" "), _c('div', {
    staticClass: "hrm-form-field "
  }, [_vm._m(5), _vm._v(" "), _c('span', {
    staticClass: "hrm-checkbox-wrap"
  }, [_c('textarea', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.leave_comments),
      expression: "leave_comments"
    }],
    domProps: {
      "value": (_vm.leave_comments)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.leave_comments = $event.target.value
      }
    }
  }), _vm._v(" "), _c('label', {
    staticClass: "hrm-radio",
    attrs: {
      "for": "hrm-disable-leave-type-checkbox"
    }
  })]), _vm._v(" "), _c('span', {
    staticClass: "hrm-clear"
  }), _vm._v(" "), _c('span', {
    staticClass: "description"
  })]), _vm._v(" "), _c('div', {
    staticClass: "hrm-form-field"
  }, [_vm._m(6), _vm._v(" "), _c('div', {
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
      "value": "Save changes"
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
        _vm.showHideLeaveRecordsForm(false)
      }
    }
  }, [_vm._v("Cancel")])])])])])])
}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('h2', {
    staticClass: "hndle ui-sortable-handle"
  }, [_c('span', [_vm._v("Leave Form")])])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', [_vm._v("\n\t\t\t\t\t\t\tEmployee\n\t\t\t\t\t\t\t"), _c('em', [_vm._v("*")])])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    attrs: {
      "for": ""
    }
  }, [_vm._v("\n\t\t\t\t\t\t\tOthers employee\n\t\t\t\t\t\t\t"), _c('em')])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', [_vm._v("\n\t\t\t\t\t\t\tLeave Type\n\t\t\t\t\t\t\t"), _c('em', [_vm._v("*")])])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    attrs: {
      "for": ""
    }
  }, [_vm._v("\n\t\t\t\t\t\t\tLeave type\n\t\t\t\t\t\t\t"), _c('em')])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', {
    attrs: {
      "for": ""
    }
  }, [_vm._v("\n\t\t\t\t\t\t\tComments\n\t\t\t\t\t\t\t"), _c('em')])
},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('label', [_vm._v("Leave Duration"), _c('em', [_vm._v("*")])])
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

/***/ 64:
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

/***/ 67:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('leave-header'), _vm._v(" "), (_vm.is_leave_form_active) ? _c('hrm-leave-records-form') : _vm._e(), _vm._v(" "), _c('a', {
    staticClass: "button button-primary hrm-add-button",
    attrs: {
      "href": "#"
    },
    on: {
      "click": function($event) {
        $event.preventDefault();
        _vm.showHideLeaveRecordsForm('toggle')
      }
    }
  }, [_vm._v("Apply Leave")]), _vm._v(" "), _c('hrm-leave-records-render')], 1)
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

/***/ 71:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('div', {
    staticClass: "metabox-holder hrm-leave-type-records-wrap"
  }, [_c('table', {
    staticClass: "wp-list-table widefat fixed striped"
  }, [_vm._m(0), _vm._v(" "), _c('tbody', [_vm._l((_vm.records), function(record) {
    return _c('tr', [_c('td', [_vm._v(_vm._s(record.leave_type.name))]), _vm._v(" "), _c('td', [_vm._v("1")]), _vm._v(" "), _c('td', [_vm._v(_vm._s(_vm.dateFormat(record.start_time)))]), _vm._v(" "), _c('td', [_vm._v(_vm._s(_vm.dateFormat(record.end_time)))])])
  }), _vm._v(" "), (!_vm.records.length) ? _c('tr', [_c('td', {
    attrs: {
      "colspan": "4"
    }
  }, [_vm._v("No record found!")])]) : _vm._e()], 2)])])])
}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('thead', [_c('th', [_vm._v("Leave Type")]), _vm._v(" "), _c('th', [_vm._v("Days")]), _vm._v(" "), _c('th', [_vm._v("Start")]), _vm._v(" "), _c('th', [_vm._v("End")])])
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