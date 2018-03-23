wpSpearHrm([7],{

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

/***/ 291:
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

/* harmony default export */ __webpack_exports__["a"] = ({
	mixins: [HRMMixin.employee],
	props: {
		deleteCheckbox: {
			type: [Boolean],
			default() {
				return true;
			}
		},
		fields: {
			type: [Array],
			default() {
				return [];
			}
		}
	},

	data() {
		return {
			canSubmit: true,
			loading: false,
			deleteAllStatus: false,
			deletedId: []
		};
	},

	created() {
		this.getRecords();
	},

	computed: {
		records() {
			return this.$store.state[this.nameSpace].records;
		}
	},

	watch: {
		deletedId() {
			this.$store.commit(this.nameSpace + '/setDeletedId', this.deletedId);
		},
		'$route'(to, from) {
			this.getRecords();
		}
	},
	methods: {
		filterEditField(fields) {
			return fields.filter(function (field) {
				return field.editable ? true : false;
			});
		},
		filterHeader(fields) {
			return fields.filter(function (field) {
				return typeof field.tableHead === 'undefined' ? false : true;
			});
		},
		printCellData(record, field) {
			if (typeof field.filterPrintData == 'undefined') {
				return record[field.name];
			}

			return field.filterPrintData(record[field.name]);
		},

		recordEditForm(record, status) {
			status = status || 'toggle';
			this.$store.commit(this.nameSpace + '/showHideEditForm', {
				id: record.id,
				status: status
			});
		},

		selfUpdate(record) {

			var self = this,
			    data = {};

			data['id'] = record.id;

			//self.canSubmit = false;
			//self.loading = true;

			self.fields.forEach(function (field) {
				if (!field.editable) {
					return;
				}

				if (typeof field.filterEditingData != 'undefined') {
					data[field.name] = field.filterEditingData(record[field.name]);
				} else {
					data[field.name] = record[field.name];
				}
			});

			var args = {
				data: data,
				callback() {
					self.canSubmit = true;
					self.loading = false;
				}
			};

			this.updateRecord(args);
		},
		selfDelete(record) {
			var self = this;
			this.recordDelete([record.id], function () {
				var hasRecords = self.$store.state[self.nameSpace].records.length;
				var page = self.$route.params.current_page_number;
				if (!hasRecords && page > 1) {
					self.$router.push({
						params: {
							current_page_number: page - 1
						},
						query: self.$route.query
					});
				}

				if (!hasRecords && typeof self.pagination != 'undefined' && self.pagination.total_pages > 1) {
					self.getRecords();
				}
			});
		},
		deleteAll() {
			if (this.deleteAllStatus) {
				var deleted_id = [];

				this.$store.state[this.nameSpace].records.map(function (record) {
					deleted_id.push(record.id);
				});

				this.deletedId = deleted_id;
			} else {
				this.deletedId = [];
			}
		},

		actionCheckbox() {
			let records = this.$store.state[this.nameSpace].records;

			if (records.length == this.deletedId.length) {
				this.deleteAllStatus = true;
			} else {
				this.deleteAllStatus = false;
			}
		}
	}

});

/***/ }),

/***/ 292:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__employee_table_vue__ = __webpack_require__(379);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__new_employee_form_vue__ = __webpack_require__(380);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__employee_form_fields__ = __webpack_require__(340);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
	mixins: [HRMMixin.employee],

	data() {

		return {
			search: {
				filter: 'active',
				name: this.$route.query.name
			},
			bulkAction: -1,

			fields: __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2__employee_form_fields__["a" /* FormFields */])(this)
		};
	},

	created() {
		var self = this;
		this.getDepartments({
			callback(departments) {
				var index = self.getIndex(self.fields, 'department', 'name');
				self.fields[index].options = departments.dept_drop_down;
			}
		});

		this.getDesignations({
			callback(designations) {
				var index = self.getIndex(self.fields, 'designation', 'name');
				self.fields[index].options = designations.data;
			}
		});

		this.getLocations({
			callback(location) {
				var index = self.getIndex(self.fields, 'location', 'name');
				self.fields[index].options = location.data;
			}
		});
	},

	computed: {
		isNewRecordFormActive() {
			return this.$store.state[this.nameSpace].isNewRecordFormActive;
		},

		total_experiance_page() {
			return 10;
		},

		pagination() {
			var pagination = this.$store.state[this.nameSpace].pagination;
			pagination['total_pages'] = Math.ceil(pagination.total / pagination.per_page);
			return pagination;
		}
	},
	components: {
		'hrm-table': __WEBPACK_IMPORTED_MODULE_0__employee_table_vue__["a" /* default */],
		'add-new-record-form': __WEBPACK_IMPORTED_MODULE_1__new_employee_form_vue__["a" /* default */]
	},

	methods: {

		selfBulkAction() {
			var self = this;
			switch (this.bulkAction) {
				case 'delete':
					this.recordDelete(self.$store.state[self.nameSpace].deletedId, function () {
						var hasRecords = self.$store.state[self.nameSpace].records.length;
						var page = self.$route.params.current_page_number;

						if (!hasRecords && page > 1) {
							self.$router.push({
								params: {
									current_page_number: page - 1
								},
								query: self.$route.query
							});
						}
						if (!hasRecords && self.pagination.total_pages > 1) {
							self.getRecords();
						}
					});
					break;

				default:

					break;
			}
		},

		recordSearch() {
			this.$router.push({ query: this.search });
			//this.getRecords();
		}
	}
});

/***/ }),

/***/ 293:
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

/* harmony default export */ __webpack_exports__["a"] = ({
	mixins: [HRMMixin.employee],
	props: {
		fields: {
			type: [Array]
		}
	},

	data() {
		return {
			loading: false,
			canSubmit: true
		};
	},

	computed: {},

	methods: {
		selfNewRecord() {
			var self = this;
			var postData = this.generateFieldData(this.fields);
			var isFormValidate = true;

			this.fields.forEach(function (val) {
				if (val.required === true && !postData[val.name]) {
					hrm.Toastr.error(val.label + ' is required!');
					isFormValidate = false;
				}
			});

			if (!isFormValidate) {
				return false;
			}

			var args = {
				data: postData,
				callback(success, res) {
					self.loading = false;
					self.canSubmit = true;
					self.showHideNewRecordForm(false);
					self.makeEmptyField(self.fields);
				}
			};

			this.addNewRecord(args);
		},

		generateFieldData(data) {
			var formated = {};

			data.forEach(function (val) {
				if (typeof val.filterSubmited !== 'undefined') {
					formated[val.name] = val.filterSubmited(val.model);
				} else {
					formated[val.name] = val.model;
				}
			});

			return formated;
		},
		makeEmptyField(data) {
			data.forEach(function (val) {
				val.model = '';
			});
		}
	}
});

/***/ }),

/***/ 340:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return FormFields; });
function FormFields(self) {
	return [{
		type: 'text',
		model: '',
		label: 'User Name',
		name: 'userName',
		//tableHead: 'Title',
		//tbRowAction: true,
		editable: false,
		required: true
	}, {
		type: 'email',
		model: '',
		label: 'Email',
		name: 'email',
		required: true
	}, {
		type: 'text',
		model: '',
		label: 'First Name',
		name: 'firstName',
		editable: true,
		required: true
	}, {
		type: 'text',
		model: '',
		label: 'Last Name',
		name: 'lastName',
		editable: true,
		required: true
	}, {
		type: 'select',
		model: hrmGetDefaultRole(),
		options: hrmGetRoles(),
		label: 'Role',
		optionLabel: 'display_name',
		placeholder: 'Select Role',
		name: 'role',
		tableHead: 'Role',
		trackBy: 'name',
		editable: true,
		required: true,
		//Filter submited new data
		filterSubmited(val) {
			return val.name;
		},

		//Table print data
		filterPrintData(val) {
			if (!val) {
				return '&#8211 &#8211';
			}
			return val.display_name;
		},

		//Filter edit submited data
		filterEditingData(val) {
			if (val) {
				return val.name;
			}
		}
	}, {
		type: 'select',
		model: '',
		options: [],
		label: 'Department',
		optionLabel: 'name',
		placeholder: 'Select Department',
		name: 'department',
		tableHead: 'Department',
		editable: true,
		required: true,
		helpText: '<a href="#/departments">Create Department</a>',
		//Filter submited new data
		filterSubmited(val) {
			return val.id;
		},
		//Table print data
		filterPrintData(val) {
			if (!val) {
				return '&#8211 &#8211';
			}
			return val.data.name;
		},
		// Filter edit form field data
		filterComputedGet(val) {
			if (!val) {
				return '';
			}
			return val.data;
		},
		// Filer edit changable data
		filterComputedSet(val) {
			return { data: val };
		},
		//Filter edit submited data
		filterEditingData(val) {
			if (val) {
				return val.data.id;
			}
		}
	}, {
		type: 'select',
		model: '',
		options: [],
		label: 'Designation',
		optionLabel: 'title',
		placeholder: 'Select Designation',
		name: 'designation',
		tableHead: 'Designation',
		editable: true,
		required: true,
		helpText: '<a href="#/designation">Create Designation</a>',
		//Filter submited new data
		filterSubmited(val) {
			return val.id;
		},
		//Table print data
		filterPrintData(val) {

			if (!val) {
				return '&#8211 &#8211';
			}
			return val.data.title;
		},
		// Filter edit form field data
		filterComputedGet(val) {

			if (!val) {
				return '';
			}
			return val.data;
		},
		// Filer edit changable data
		filterComputedSet(val) {
			return { data: val };
		},
		//Filter edit submited data
		filterEditingData(val) {
			if (val) {
				return val.data.id;
			}
		}
	}, {
		type: 'select',
		model: '',
		options: [],
		label: 'Location',
		optionLabel: 'name',
		placeholder: 'Select Location',
		name: 'location',
		tableHead: 'Location',
		editable: true,
		helpText: '<a href="#/organization/location">Create Location</a>',
		//Filter submited new data
		filterSubmited(val) {
			return val.id;
		},
		//Table print data
		filterPrintData(val) {

			if (!val) {
				return '&#8211 &#8211';
			}
			return val.data.name;
		},
		// Filter edit form field data
		filterComputedGet(val) {

			if (!val) {
				return '';
			}
			return val.data;
		},
		// Filer edit changable data
		filterComputedSet(val) {
			return { data: val };
		},
		//Filter edit submited data
		filterEditingData(val) {
			if (val) {
				return val.data.id;
			}
		}

	}, {
		type: 'select',
		model: hrmGetDefaultStatus(),
		options: hrmGetStatus(),
		label: 'Status',
		optionLabel: 'label',
		placeholder: 'Select Status',
		name: 'status',
		tableHead: 'Status',
		editable: true,
		//Filter submited new data
		filterSubmited(val) {
			return val.key;
		},
		//Filter edit submited data
		filterEditingData(val) {
			return val.key;
		},
		//Table print data
		filterPrintData(val) {

			if (!val) {
				return '&#8211 &#8211';
			}
			return val.label;
		}

	}, {
		type: 'select',
		model: '',
		options: hrmGetGender(),
		label: 'Gender',
		optionLabel: 'label',
		placeholder: 'Select Gender',
		name: 'gender',
		tableHead: 'Gender',
		editable: true,
		//Filter submited new data
		filterSubmited(val) {
			return val.key;
		},
		//Filter edit submited data
		filterEditingData(val) {
			return val.key;
		},
		//Table print data
		filterPrintData(val) {

			if (!val) {
				return '&#8211 &#8211';
			}
			return val.label;
		}
	}, {
		type: 'text',
		model: '',
		label: 'Mobile Number',
		name: 'mobileNumber',
		editable: true
	}, {
		type: 'datePickerFrom',
		model: '',
		label: 'Joining Date',
		name: 'joiningDate',
		editable: true
	}, {
		type: 'textarea',
		model: '',
		label: 'Description',
		name: 'description',
		tableHead: 'Description',
		editable: true
	}, {
		type: 'file',
		model: [],
		label: 'Profile Picture',
		name: 'employee_image',
		editMode: false,
		multiple: false,
		deleted_files: [],
		attr: {
			height: '80px',
			width: '80px'
		},
		default: []
	}];
}

function hrmGetGender() {
	return [{
		key: 1,
		label: 'Male'
	}, {
		key: 2,
		label: 'Female'
	}, {
		key: 3,
		label: 'Others'
	}];
}

function hrmGetStatus() {
	return [{
		key: 1,
		label: 'Active'
	}, {
		key: 2,
		label: 'Disable'
	}];
}

function hrmGetRoles() {
	var roles = [];

	jQuery.each(HRM_Vars.hrm_roles, function (key, val) {
		roles.push({
			name: key,
			display_name: val
		});
	});

	return roles;
}

function hrmGetDefaultRole() {
	var role = {};

	jQuery.each(HRM_Vars.hrm_roles, function (key, val) {
		if (key == 'hrm_employee') {
			role = {
				name: key,
				display_name: val
			};
		}
	});

	return role;
}

function hrmGetDefaultStatus() {
	return {
		key: 1,
		label: 'Active'
	};
}



/***/ }),

/***/ 352:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(141)(false);
// imports


// module
exports.push([module.i, "\n.hrm-bulk-wrap, .hrm-filter-wrap {\n\tfloat: left;\n}\n.hrm-tbl-action-wrap {\n\tmargin-top: 20px;\n}\n", ""]);

// exports


/***/ }),

/***/ 370:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(141)(false);
// imports


// module
exports.push([module.i, "\n.alignright {\n\tfloat: right;\n}\n.hrm-spinner {\n\tmargin-right: 10px;\n\tmargin-top: 6px;\n}\n.hrm-avatar,\n.hrm-profile-link {\n\tfloat: left;\n}\n.hrm-avatar {\n\tmargin-right: 5px;\n}\n.has-row-actions {\n\twidth: 16%;\n}\n\n", ""]);

// exports


/***/ }),

/***/ 379:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_employee_table_vue__ = __webpack_require__(291);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_ebc3d820_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_employee_table_vue__ = __webpack_require__(465);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_employee_table_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_ebc3d820_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_employee_table_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/employee/employee-table.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-ebc3d820", Component.options)
  } else {
    hotAPI.reload("data-v-ebc3d820", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 380:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_new_employee_form_vue__ = __webpack_require__(293);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_65c495b6_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_new_employee_form_vue__ = __webpack_require__(438);
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_new_employee_form_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_65c495b6_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_new_employee_form_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/employee/new-employee-form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-65c495b6", Component.options)
  } else {
    hotAPI.reload("data-v-65c495b6", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),

/***/ 421:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _vm.manageEmployee()
        ? _c("h1", { staticClass: "wp-heading-inline" }, [_vm._v("Employee")])
        : _vm._e(),
      _vm._v(" "),
      _vm.manageEmployee()
        ? _c(
            "a",
            {
              staticClass: "page-title-action",
              on: {
                click: function($event) {
                  $event.preventDefault()
                  _vm.showHideNewRecordForm("toggle")
                }
              }
            },
            [_vm._v("Add New")]
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.isNewRecordFormActive && _vm.manageEmployee()
        ? _c("add-new-record-form", {
            staticClass: "hrm-toggle",
            attrs: { fields: _vm.fields }
          })
        : _vm._e(),
      _vm._v(" "),
      _c("div", { staticClass: "hrm-tbl-action-wrap" }, [
        _vm.manageEmployee()
          ? _c("div", { staticClass: "hrm-table-action hrm-bulk-wrap" }, [
              _c(
                "label",
                {
                  staticClass: "screen-reader-text",
                  attrs: { for: "bulk-action-selector-top" }
                },
                [_vm._v("\n\t\t\t\t\tSelect bulk action\n\t\t\t\t")]
              ),
              _vm._v(" "),
              _c(
                "select",
                {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.bulkAction,
                      expression: "bulkAction"
                    }
                  ],
                  attrs: { name: "action", id: "bulk-action-selector-top" },
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
                      _vm.bulkAction = $event.target.multiple
                        ? $$selectedVal
                        : $$selectedVal[0]
                    }
                  }
                },
                [
                  _c("option", { attrs: { value: "-1" } }, [
                    _vm._v("Bulk Actions")
                  ]),
                  _vm._v(" "),
                  _c("option", { attrs: { value: "delete" } }, [
                    _vm._v("Delete")
                  ])
                ]
              ),
              _vm._v(" "),
              _c(
                "a",
                {
                  staticClass: "button hrm-button-secondary button-secondary",
                  attrs: { href: "#" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      _vm.selfBulkAction()
                    }
                  }
                },
                [_vm._v("Apply")]
              )
            ])
          : _vm._e(),
        _vm._v(" "),
        _c("div", { staticClass: "hrm-table-action hrm-filter-wrap" }, [
          _c("div", { staticClass: "alignleft actions" }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.search.name,
                  expression: "search.name"
                }
              ],
              attrs: {
                size: "40",
                placeholder: "Search by user login, nicename, email",
                type: "text"
              },
              domProps: { value: _vm.search.name },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.$set(_vm.search, "name", $event.target.value)
                }
              }
            }),
            _vm._v(" "),
            _c(
              "a",
              {
                staticClass: "button hrm-button-secondary button-secondary",
                attrs: { href: "#" },
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    _vm.recordSearch()
                  }
                }
              },
              [_vm._v("Filter")]
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "hrm-clear" })
      ]),
      _vm._v(" "),
      _c("hrm-table", {
        attrs: { id: "hrm-employee-list-table", fields: _vm.fields }
      }),
      _vm._v(" "),
      _c("hrm-pagination", {
        attrs: {
          total_pages: _vm.pagination.total_pages,
          component_name: "employee_pagination"
        }
      })
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
    require("vue-hot-reload-api")      .rerender("data-v-38baa9ef", esExports)
  }
}

/***/ }),

/***/ 438:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "metabox-holder" }, [
    _c(
      "div",
      { staticClass: "postbox", attrs: { id: "hrm-hidden-form-warp" } },
      [
        _c("h2", { staticClass: "hndle" }, [_vm._v("Employee")]),
        _vm._v(" "),
        _c("div", { staticClass: "inside" }, [
          _c(
            "form",
            {
              attrs: { id: "hrm-hidden-form", action: "" },
              on: {
                submit: function($event) {
                  $event.preventDefault()
                  _vm.selfNewRecord()
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
                  staticClass: "button hrm-button-primary button-primary",
                  attrs: {
                    disabled: !_vm.canSubmit,
                    type: "submit",
                    name: "requst",
                    value: "Submit"
                  }
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
                        _vm.showHideNewRecordForm(false)
                      }
                    }
                  },
                  [_vm._v("Cancel")]
                ),
                _vm._v(" "),
                _vm.loading
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
  ])
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-65c495b6", esExports)
  }
}

/***/ }),

/***/ 46:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_employee_vue__ = __webpack_require__(292);
/* empty harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_38baa9ef_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_employee_vue__ = __webpack_require__(421);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(476)
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
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_employee_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_38baa9ef_hasScoped_false_buble_transforms_node_modules_vue_loader_lib_selector_type_template_index_0_employee_vue__["a" /* default */],
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "assets/src/components/employee/employee.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-38baa9ef", Component.options)
  } else {
    hotAPI.reload("data-v-38baa9ef", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),

/***/ 465:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _vm.isFetchRecord
      ? _c(
          "table",
          { staticClass: "wp-list-table widefat fixed striped pages" },
          [
            _c("thead", [
              _c(
                "tr",
                [
                  _vm.manageEmployee()
                    ? _c(
                        "td",
                        {
                          staticClass: "manage-column column-cb check-column",
                          attrs: { id: "cb" }
                        },
                        [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.deleteAllStatus,
                                expression: "deleteAllStatus"
                              }
                            ],
                            attrs: { id: "cb-select-all-1", type: "checkbox" },
                            domProps: {
                              checked: Array.isArray(_vm.deleteAllStatus)
                                ? _vm._i(_vm.deleteAllStatus, null) > -1
                                : _vm.deleteAllStatus
                            },
                            on: {
                              change: [
                                function($event) {
                                  var $$a = _vm.deleteAllStatus,
                                    $$el = $event.target,
                                    $$c = $$el.checked ? true : false
                                  if (Array.isArray($$a)) {
                                    var $$v = null,
                                      $$i = _vm._i($$a, $$v)
                                    if ($$el.checked) {
                                      $$i < 0 &&
                                        (_vm.deleteAllStatus = $$a.concat([
                                          $$v
                                        ]))
                                    } else {
                                      $$i > -1 &&
                                        (_vm.deleteAllStatus = $$a
                                          .slice(0, $$i)
                                          .concat($$a.slice($$i + 1)))
                                    }
                                  } else {
                                    _vm.deleteAllStatus = $$c
                                  }
                                },
                                function($event) {
                                  $event.preventDefault()
                                  _vm.deleteAll()
                                }
                              ]
                            }
                          })
                        ]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _c("th", { staticClass: "has-row-actions" }, [
                    _vm._v("Name")
                  ]),
                  _vm._v(" "),
                  _vm._l(_vm.filterHeader(_vm.fields), function(
                    header,
                    header_index
                  ) {
                    return _c("th", { key: header_index }, [
                      _vm._v(
                        "\n                    \t" +
                          _vm._s(header.tableHead) +
                          "\n                    "
                      )
                    ])
                  })
                ],
                2
              )
            ]),
            _vm._v(" "),
            _c(
              "tbody",
              [
                _vm._l(_vm.records, function(record, record_index) {
                  return !record.editMode
                    ? _c(
                        "tr",
                        {
                          key: record_index,
                          attrs: { "data-recordId": record.id }
                        },
                        [
                          _vm.manageEmployee()
                            ? _c(
                                "th",
                                {
                                  staticClass: "check-column",
                                  attrs: { scope: "row" }
                                },
                                [
                                  _c("input", {
                                    directives: [
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value: _vm.deletedId,
                                        expression: "deletedId"
                                      }
                                    ],
                                    attrs: {
                                      id: "cb-select-7",
                                      type: "checkbox"
                                    },
                                    domProps: {
                                      value: record.id,
                                      checked: Array.isArray(_vm.deletedId)
                                        ? _vm._i(_vm.deletedId, record.id) > -1
                                        : _vm.deletedId
                                    },
                                    on: {
                                      change: [
                                        function($event) {
                                          var $$a = _vm.deletedId,
                                            $$el = $event.target,
                                            $$c = $$el.checked ? true : false
                                          if (Array.isArray($$a)) {
                                            var $$v = record.id,
                                              $$i = _vm._i($$a, $$v)
                                            if ($$el.checked) {
                                              $$i < 0 &&
                                                (_vm.deletedId = $$a.concat([
                                                  $$v
                                                ]))
                                            } else {
                                              $$i > -1 &&
                                                (_vm.deletedId = $$a
                                                  .slice(0, $$i)
                                                  .concat($$a.slice($$i + 1)))
                                            }
                                          } else {
                                            _vm.deletedId = $$c
                                          }
                                        },
                                        function($event) {
                                          _vm.actionCheckbox()
                                        }
                                      ]
                                    }
                                  })
                                ]
                              )
                            : _vm._e(),
                          _vm._v(" "),
                          _c(
                            "td",
                            {},
                            [
                              _c("img", {
                                staticClass: "hrm-avatar",
                                staticStyle: { height: "32px", width: "32px" },
                                attrs: { src: record.avatar }
                              }),
                              _vm._v(" "),
                              _c(
                                "router-link",
                                {
                                  staticClass: "hrm-profile-link",
                                  attrs: {
                                    to: {
                                      name: "employee_general_information",
                                      params: {
                                        employeeId: record.id
                                      }
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n\t\t\t\t\t\t\t" +
                                      _vm._s(record.display_name) +
                                      "\n\t\t\t\t\t\t"
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c("div", { staticClass: "hrm-clear" }),
                              _vm._v(" "),
                              _c("div", { staticClass: "row-actions" }, [
                                _vm.manageEmployee() || record.can_update
                                  ? _c("span", { staticClass: "edit" }, [
                                      _c(
                                        "a",
                                        {
                                          attrs: { href: "#" },
                                          on: {
                                            click: function($event) {
                                              $event.preventDefault()
                                              _vm.recordEditForm(record)
                                            }
                                          }
                                        },
                                        [_vm._v("Edit")]
                                      )
                                    ])
                                  : _vm._e(),
                                _vm._v(" "),
                                _vm.manageEmployee()
                                  ? _c("span", { staticClass: "trash" }, [
                                      _vm._v(" | "),
                                      _c(
                                        "a",
                                        {
                                          attrs: { href: "#" },
                                          on: {
                                            click: function($event) {
                                              $event.preventDefault()
                                              _vm.selfDelete(record)
                                            }
                                          }
                                        },
                                        [_vm._v("Delete")]
                                      )
                                    ])
                                  : _vm._e()
                              ])
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _vm._l(_vm.filterHeader(_vm.fields), function(
                            field,
                            field_index
                          ) {
                            return _c("td", [
                              _c("span", {
                                domProps: {
                                  innerHTML: _vm._s(
                                    _vm.printCellData(record, field)
                                  )
                                }
                              })
                            ])
                          })
                        ],
                        2
                      )
                    : _c(
                        "tr",
                        {
                          staticClass: "hrm-eidt-toggle inline-edit-row-page",
                          attrs: { id: "edit-8" }
                        },
                        [
                          _c(
                            "td",
                            {
                              staticClass: "colspanchange",
                              attrs: { colspan: _vm.fields.length + 1 }
                            },
                            [
                              _c(
                                "form",
                                {
                                  attrs: { action: "" },
                                  on: {
                                    submit: function($event) {
                                      $event.preventDefault()
                                      _vm.selfUpdate(record)
                                    }
                                  }
                                },
                                [
                                  _c(
                                    "fieldset",
                                    { staticClass: "inline-edit-col-left" },
                                    [
                                      _c(
                                        "legend",
                                        { staticClass: "inline-edit-legend" },
                                        [_vm._v("Quick Edit")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        { staticClass: "inline-edit-col" },
                                        _vm._l(
                                          _vm.filterEditField(_vm.fields),
                                          function(field, field_index) {
                                            return _c("label", [
                                              _c(
                                                "span",
                                                { staticClass: "title" },
                                                [_vm._v(_vm._s(field.label))]
                                              ),
                                              _vm._v(" "),
                                              _c(
                                                "span",
                                                {
                                                  staticClass: "input-text-wrap"
                                                },
                                                [
                                                  _c("hrm-edit-field", {
                                                    attrs: {
                                                      record: record,
                                                      field: field
                                                    }
                                                  })
                                                ],
                                                1
                                              )
                                            ])
                                          }
                                        )
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _vm._m(0),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    { staticClass: "submit inline-edit-save" },
                                    [
                                      _c(
                                        "button",
                                        {
                                          staticClass:
                                            "button hrm-button-secondary cancel alignleft",
                                          attrs: { type: "button" },
                                          on: {
                                            click: function($event) {
                                              $event.preventDefault()
                                              _vm.recordEditForm(record, false)
                                            }
                                          }
                                        },
                                        [_vm._v("Cancel")]
                                      ),
                                      _vm._v(" "),
                                      _c("input", {
                                        staticClass:
                                          "button hrm-button-primary button-primary save alignright",
                                        attrs: {
                                          disabled: !_vm.canSubmit,
                                          type: "submit",
                                          value: "Update"
                                        }
                                      }),
                                      _vm._v(" "),
                                      _vm.loading
                                        ? _c("div", {
                                            staticClass:
                                              "hrm-spinner alignright"
                                          })
                                        : _vm._e(),
                                      _vm._v(" "),
                                      _c("br", { staticClass: "clear" })
                                    ]
                                  )
                                ]
                              )
                            ]
                          )
                        ]
                      )
                }),
                _vm._v(" "),
                !_vm.records.length
                  ? _c("tr", [
                      _c("td", { attrs: { colspan: "9" } }, [
                        _vm._v("\n\t\t\t\t\t\tNo result found!\n\t\t\t\t\t")
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
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("fieldset", { staticClass: "inline-edit-col-right" }, [
      _c("div", { staticClass: "inline-edit-col" })
    ])
  }
]
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-ebc3d820", esExports)
  }
}

/***/ }),

/***/ 476:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(352);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(142)("938f1d8e", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-38baa9ef\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./employee.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-38baa9ef\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./employee.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 494:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(370);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(142)("5b2e88ce", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-ebc3d820\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./employee-table.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-ebc3d820\",\"scoped\":false,\"hasInlineConfig\":false}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./employee-table.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ })

});