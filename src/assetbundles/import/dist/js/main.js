!function(e){function n(n){for(var t,a,i=n[0],l=n[1],c=n[2],u=0,d=[];u<i.length;u++)a=i[u],o[a]&&d.push(o[a][0]),o[a]=0;for(t in l)Object.prototype.hasOwnProperty.call(l,t)&&(e[t]=l[t]);for(p&&p(n);d.length;)d.shift()();return s.push.apply(s,c||[]),r()}function r(){for(var e,n=0;n<s.length;n++){for(var r=s[n],t=!0,i=1;i<r.length;i++){var l=r[i];0!==o[l]&&(t=!1)}t&&(s.splice(n--,1),e=a(a.s=r[0]))}return e}var t={},o={main:0},s=[];function a(n){if(t[n])return t[n].exports;var r=t[n]={i:n,l:!1,exports:{}};return e[n].call(r.exports,r,r.exports,a),r.l=!0,r.exports}a.m=e,a.c=t,a.d=function(e,n,r){a.o(e,n)||Object.defineProperty(e,n,{enumerable:!0,get:r})},a.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},a.t=function(e,n){if(1&n&&(e=a(e)),8&n)return e;if(4&n&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(a.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&n&&"string"!=typeof e)for(var t in e)a.d(r,t,function(n){return e[n]}.bind(null,t));return r},a.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return a.d(n,"a",n),n},a.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},a.p="";var i=window.webpackJsonp=window.webpackJsonp||[],l=i.push.bind(i);i.push=n,i=i.slice();for(var c=0;c<i.length;c++)n(i[c]);var p=l;s.push([0,"vendor"]),r()}({"./node_modules/mini-css-extract-plugin/dist/loader.js!./node_modules/css-loader/index.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/lib/loader.js!./resources/sass/Import.scss":
/*!*********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/mini-css-extract-plugin/dist/loader.js!./node_modules/css-loader!./node_modules/postcss-loader/src??embedded!./node_modules/sass-loader/lib/loader.js!./resources/sass/Import.scss ***!
  \*********************************************************************************************************************************************************************************************************/
/*! no static exports found */function(module,exports,__webpack_require__){eval("// extracted by mini-css-extract-plugin\n\n//# sourceURL=webpack:///./resources/sass/Import.scss?./node_modules/mini-css-extract-plugin/dist/loader.js!./node_modules/css-loader!./node_modules/postcss-loader/src??embedded!./node_modules/sass-loader/lib/loader.js")},"./resources/js/Import.js":
/*!********************************!*\
  !*** ./resources/js/Import.js ***!
  \********************************/
/*! no exports provided */function(module,__webpack_exports__,__webpack_require__){"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _sass_Import_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../sass/Import.scss */ "./resources/sass/Import.scss");\n/* harmony import */ var _sass_Import_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_sass_Import_scss__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _modules_FileUpload__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/FileUpload */ "./resources/js/modules/FileUpload.js");\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }\n\n\n\n\nvar Import = function Import() {\n  _classCallCheck(this, Import);\n\n  console.log(\'Hello, world!\');\n  Object(_modules_FileUpload__WEBPACK_IMPORTED_MODULE_1__["onInit"])();\n};\n\nwindow.onload = function () {\n  if (document.querySelector(\'[data-import-plugin]\')) {\n    new Import();\n  }\n};\n\n//# sourceURL=webpack:///./resources/js/Import.js?')},"./resources/js/modules/EntryPreview.js":
/*!**********************************************!*\
  !*** ./resources/js/modules/EntryPreview.js ***!
  \**********************************************/
/*! exports provided: default */function(module,__webpack_exports__,__webpack_require__){"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return EntryPreview; });\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\nvar camelCase = function camelCase(str) {\n  return str.replace(/(?:^\\w|[A-Z]|\\b\\w)/g, function (letter, index) {\n    return index == 0 ? letter.toLowerCase() : letter.toUpperCase();\n  }).replace(/\\s+/g, \'\');\n};\n\nvar EntryPreview =\n/*#__PURE__*/\nfunction () {\n  function EntryPreview(node) {\n    _classCallCheck(this, EntryPreview);\n\n    this.node = node;\n    this.id = node.id;\n    this.section = document.querySelector("#section-".concat(this.id));\n    this.type = document.querySelector("#type-".concat(this.id));\n    this.section.addEventListener(\'change\', this.updateType.bind(this));\n    this.initDropdowns();\n  }\n\n  _createClass(EntryPreview, [{\n    key: "initDropdowns",\n    value: function initDropdowns() {\n      var dropdowns = document.querySelectorAll(\'[data-value]\');\n\n      if (dropdowns && dropdowns.length) {\n        Array.prototype.forEach.call(dropdowns, function (dropdown) {\n          var value = JSON.parse(dropdown.dataset.value);\n          var name = dropdown.dataset.name;\n          var camelName = camelCase("select ".concat(name));\n          var options = JSON.parse(dropdown.dataset[camelName]);\n          var matches;\n\n          switch (name) {\n            case \'author\':\n              value = value.email; // Try to match based on email\n\n              matches = Array.prototype.filter.call(options, function (option) {\n                //console.log(option.email);\n                if (option.email == value) {\n                  return true;\n                }\n              });\n              console.log(options); //console.log(\'possible matches: \', matches);\n\n              break;\n\n            case \'type\':\n              break;\n\n            case \'section\':\n              //const matches = Ar\n              break;\n          }\n\n          var optionsMarkup = \'\';\n\n          if (!matches || !matches.length) {\n            optionsMarkup += "<option default value=\\"new-".concat(value, "\\">").concat(value, " (New)</option>");\n          }\n\n          Array.prototype.forEach.call(options, function (option) {\n            var name = option.name;\n\n            if (!name) {\n              name = option.email;\n            }\n\n            optionsMarkup += "<option value=\\"".concat(option.id, "\\">").concat(name, "</option>");\n          });\n          dropdown.innerHTML = optionsMarkup;\n        });\n      }\n    }\n  }, {\n    key: "updateType",\n    value: function updateType(e) {\n      var newValue = parseInt(e.target.value);\n      var allTypes = JSON.parse(this.type.dataset.selectType); // console.log(allTypes[newValue]);\n\n      var newTypes = allTypes[newValue];\n\n      if (newTypes) {\n        var options = \'\';\n\n        for (var i = 0; i < newTypes.length; i++) {\n          options += "<option value=\\"".concat(newTypes[i].id, "\\">").concat(newTypes[i].name, "</option>");\n        }\n\n        this.type.innerHTML = options;\n      } else {\n        console.log(\'Error\');\n        this.type.innerHTML = \'\';\n      }\n    }\n  }]);\n\n  return EntryPreview;\n}();\n\n\n\n//# sourceURL=webpack:///./resources/js/modules/EntryPreview.js?')},"./resources/js/modules/FileUpload.js":
/*!********************************************!*\
  !*** ./resources/js/modules/FileUpload.js ***!
  \********************************************/
/*! exports provided: onInit */function(module,__webpack_exports__,__webpack_require__){"use strict";eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"onInit\", function() { return onInit; });\n/* harmony import */ var _EntryPreview__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EntryPreview */ \"./resources/js/modules/EntryPreview.js\");\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\n\n\nvar removeDragData = function removeDragData(e) {\n  if (e.dataTransfer.items) {\n    e.dataTransfer.items.clear();\n  } else {\n    e.dataTransfer.clearData();\n  }\n};\n\nvar FileUpload =\n/*#__PURE__*/\nfunction () {\n  function FileUpload(node) {\n    _classCallCheck(this, FileUpload);\n\n    this.element = node;\n    this.uploadUrl = '/admin/import/upload';\n    this.label = 'Choose a file';\n    this.files = [];\n    this.results = document.querySelector('[data-import-file-upload-result]'); // Drag/drop\n\n    this.element.addEventListener('drop', this.dropHandler.bind(this));\n    this.element.addEventListener('dragover', this.dragOverHandler.bind(this)); // Clear\n\n    document.querySelector('[data-import-file-clear]').addEventListener('click', this.clearFiles.bind(this)); // Input type=\"file\"\n\n    this.input = document.querySelector('input[type=\"file\"].FileUpload-input');\n\n    if (this.input) {\n      this.input.addEventListener('change', this.fileSelectHandler.bind(this));\n    }\n  }\n\n  _createClass(FileUpload, [{\n    key: \"upload\",\n    value: function upload() {\n      var _this = this;\n\n      var formData = new FormData();\n      Array.prototype.forEach.call(this.files, function (f) {\n        formData.append('files[]', f, f.name);\n      });\n      fetch(this.uploadUrl, {\n        method: 'post',\n        credentials: 'same-origin',\n        headers: {\n          'X-Requested-With': 'XMLHttpRequest'\n        },\n        body: formData\n      }).then(function (resp) {\n        return resp.text();\n      }).then(function (data) {\n        _this.results.innerHTML = data;\n        var entries = document.querySelectorAll('.ImportPreview-entry');\n\n        if (entries && entries.length) {\n          Array.prototype.forEach.call(entries, function (entry) {\n            new _EntryPreview__WEBPACK_IMPORTED_MODULE_0__[\"default\"](entry);\n          });\n        }\n      });\n    }\n  }, {\n    key: \"fileSelectHandler\",\n    value: function fileSelectHandler(e) {\n      this.input.disabed = true;\n      this.files = e.target.files;\n      this.updateLabel();\n      this.upload();\n    }\n  }, {\n    key: \"dropHandler\",\n    value: function dropHandler(e) {\n      var _this2 = this;\n\n      console.log(e);\n      e.preventDefault();\n\n      if (e.dataTransfer.items) {\n        Array.prototype.forEach.call(e.dataTransfer.items, function (item) {\n          if (item.kind === 'file') {\n            var file = item.getAsFile();\n\n            _this2.files.push(file);\n          }\n        });\n      } else {\n        Array.prototype.forEach.call(e.dataTransfer.files, function (file) {\n          _this2.files.push(file);\n        });\n      }\n\n      this.updateLabel();\n      removeDragData(e);\n      this.upload();\n      return;\n    }\n  }, {\n    key: \"dragOverHandler\",\n    value: function dragOverHandler(e) {\n      e.preventDefault();\n      return;\n    }\n  }, {\n    key: \"clearFiles\",\n    value: function clearFiles() {\n      this.files = [];\n      this.updateLabel();\n      this.results.innerHTML = '';\n    }\n  }, {\n    key: \"updateLabel\",\n    value: function updateLabel() {\n      var _this3 = this;\n\n      this.label = '';\n      var labelSpan = document.querySelector('.FileUpload-input + label>span');\n      var instructionSpan = document.querySelector('[data-import-file-instructions]');\n      var clearSpan = document.querySelector('[data-import-file-clear]');\n\n      if (this.files && this.files.length) {\n        console.log(this.files);\n        Array.prototype.forEach.call(this.files, function (file) {\n          if (_this3.label.length) {\n            _this3.label += ', ';\n          }\n\n          _this3.label += file.name;\n        });\n        instructionSpan.classList.add('hidden');\n        clearSpan.classList.remove('hidden');\n      } else {\n        this.label = 'Choose a file';\n        instructionSpan.classList.remove('hidden');\n        clearSpan.classList.add('hidden');\n      }\n\n      labelSpan.innerText = this.label;\n    }\n  }]);\n\n  return FileUpload;\n}();\n\nvar onInit = function onInit() {\n  var fileUploads = document.querySelectorAll('[data-import-file-upload]');\n\n  if (fileUploads && fileUploads.length) {\n    Array.prototype.forEach.call(fileUploads, function (f) {\n      new FileUpload(f);\n    });\n  }\n};\n\n//# sourceURL=webpack:///./resources/js/modules/FileUpload.js?")},"./resources/sass/Import.scss":
/*!************************************!*\
  !*** ./resources/sass/Import.scss ***!
  \************************************/
/*! no static exports found */function(module,exports,__webpack_require__){eval('\nvar content = __webpack_require__(/*! !../../node_modules/mini-css-extract-plugin/dist/loader.js!../../node_modules/css-loader!../../node_modules/postcss-loader/src??embedded!../../node_modules/sass-loader/lib/loader.js!./Import.scss */ "./node_modules/mini-css-extract-plugin/dist/loader.js!./node_modules/css-loader/index.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/lib/loader.js!./resources/sass/Import.scss");\n\nif(typeof content === \'string\') content = [[module.i, content, \'\']];\n\nvar transform;\nvar insertInto;\n\n\n\nvar options = {"hmr":true}\n\noptions.transform = transform\noptions.insertInto = undefined;\n\nvar update = __webpack_require__(/*! ../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);\n\nif(content.locals) module.exports = content.locals;\n\nif(false) {}\n\n//# sourceURL=webpack:///./resources/sass/Import.scss?')},0:
/*!**************************************!*\
  !*** multi ./resources/js/Import.js ***!
  \**************************************/
/*! no static exports found */function(module,exports,__webpack_require__){eval('module.exports = __webpack_require__(/*! /Users/abryrath/Union/Library/import/resources/js/Import.js */"./resources/js/Import.js");\n\n\n//# sourceURL=webpack:///multi_./resources/js/Import.js?')}});