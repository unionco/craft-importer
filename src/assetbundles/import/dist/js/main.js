!function(n){function e(e){for(var r,i,a=e[0],c=e[1],l=e[2],p=0,d=[];p<a.length;p++)i=a[p],o[i]&&d.push(o[i][0]),o[i]=0;for(r in c)Object.prototype.hasOwnProperty.call(c,r)&&(n[r]=c[r]);for(u&&u(e);d.length;)d.shift()();return s.push.apply(s,l||[]),t()}function t(){for(var n,e=0;e<s.length;e++){for(var t=s[e],r=!0,a=1;a<t.length;a++){var c=t[a];0!==o[c]&&(r=!1)}r&&(s.splice(e--,1),n=i(i.s=t[0]))}return n}var r={},o={main:0},s=[];function i(e){if(r[e])return r[e].exports;var t=r[e]={i:e,l:!1,exports:{}};return n[e].call(t.exports,t,t.exports,i),t.l=!0,t.exports}i.m=n,i.c=r,i.d=function(n,e,t){i.o(n,e)||Object.defineProperty(n,e,{enumerable:!0,get:t})},i.r=function(n){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(n,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(n,"__esModule",{value:!0})},i.t=function(n,e){if(1&e&&(n=i(n)),8&e)return n;if(4&e&&"object"==typeof n&&n&&n.__esModule)return n;var t=Object.create(null);if(i.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:n}),2&e&&"string"!=typeof n)for(var r in n)i.d(t,r,function(e){return n[e]}.bind(null,r));return t},i.n=function(n){var e=n&&n.__esModule?function(){return n.default}:function(){return n};return i.d(e,"a",e),e},i.o=function(n,e){return Object.prototype.hasOwnProperty.call(n,e)},i.p="";var a=window.webpackJsonp=window.webpackJsonp||[],c=a.push.bind(a);a.push=e,a=a.slice();for(var l=0;l<a.length;l++)e(a[l]);var u=c;s.push([0,"vendor"]),t()}({"./node_modules/mini-css-extract-plugin/dist/loader.js!./node_modules/css-loader/index.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/lib/loader.js!./resources/sass/Import.scss":
/*!*********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/mini-css-extract-plugin/dist/loader.js!./node_modules/css-loader!./node_modules/postcss-loader/src??embedded!./node_modules/sass-loader/lib/loader.js!./resources/sass/Import.scss ***!
  \*********************************************************************************************************************************************************************************************************/
/*! no static exports found */function(module,exports,__webpack_require__){eval("// extracted by mini-css-extract-plugin\n\n//# sourceURL=webpack:///./resources/sass/Import.scss?./node_modules/mini-css-extract-plugin/dist/loader.js!./node_modules/css-loader!./node_modules/postcss-loader/src??embedded!./node_modules/sass-loader/lib/loader.js")},"./resources/js/Import.js":
/*!********************************!*\
  !*** ./resources/js/Import.js ***!
  \********************************/
/*! no exports provided */function(module,__webpack_exports__,__webpack_require__){"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _sass_Import_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../sass/Import.scss */ "./resources/sass/Import.scss");\n/* harmony import */ var _sass_Import_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_sass_Import_scss__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _modules_FileUpload__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/FileUpload */ "./resources/js/modules/FileUpload.js");\n/* harmony import */ var _modules_SubmitButton__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modules/SubmitButton */ "./resources/js/modules/SubmitButton.js");\n/* harmony import */ var _modules_AjaxSpinner__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./modules/AjaxSpinner */ "./resources/js/modules/AjaxSpinner.js");\n/* harmony import */ var _modules_ImportResults__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./modules/ImportResults */ "./resources/js/modules/ImportResults.js");\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }\n\n\n\n\n\n\n\nvar Import = function Import() {\n  _classCallCheck(this, Import);\n\n  Object(_modules_FileUpload__WEBPACK_IMPORTED_MODULE_1__["onInit"])();\n  Object(_modules_SubmitButton__WEBPACK_IMPORTED_MODULE_2__["onInit"])();\n  Object(_modules_AjaxSpinner__WEBPACK_IMPORTED_MODULE_3__["onInit"])();\n  Object(_modules_ImportResults__WEBPACK_IMPORTED_MODULE_4__["onInit"])();\n};\n\nwindow.onload = function () {\n  if (document.querySelector(\'[data-import-plugin]\')) {\n    window.Import = new Import();\n  }\n};\n\n//# sourceURL=webpack:///./resources/js/Import.js?')},"./resources/js/modules/AjaxSpinner.js":
/*!*********************************************!*\
  !*** ./resources/js/modules/AjaxSpinner.js ***!
  \*********************************************/
/*! exports provided: onInit */function(module,__webpack_exports__,__webpack_require__){"use strict";eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"onInit\", function() { return onInit; });\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\nvar AjaxSpinner =\n/*#__PURE__*/\nfunction () {\n  function AjaxSpinner(node) {\n    _classCallCheck(this, AjaxSpinner);\n\n    this.root = node;\n    console.log('Ajax Spinner loaded');\n    var modal = document.createElement('div');\n    modal.classList.add('AjaxSpinner-modal');\n    var content = document.createElement('div');\n    content.classList.add('content');\n    var img = document.createElement('img');\n    img.src = \"data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBzdGFuZGFsb25lPSJubyI/Pgo8IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPgo8c3ZnIHdpZHRoPSI0MHB4IiBoZWlnaHQ9IjQwcHgiIHZpZXdCb3g9IjAgMCA0MCA0MCIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4bWw6c3BhY2U9InByZXNlcnZlIiBzdHlsZT0iZmlsbC1ydWxlOmV2ZW5vZGQ7Y2xpcC1ydWxlOmV2ZW5vZGQ7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEuNDE0MjE7IiB4PSIwcHgiIHk9IjBweCI+CiAgICA8ZGVmcz4KICAgICAgICA8c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWwogICAgICAgICAgICBALXdlYmtpdC1rZXlmcmFtZXMgc3BpbiB7CiAgICAgICAgICAgICAgZnJvbSB7CiAgICAgICAgICAgICAgICAtd2Via2l0LXRyYW5zZm9ybTogcm90YXRlKDBkZWcpCiAgICAgICAgICAgICAgfQogICAgICAgICAgICAgIHRvIHsKICAgICAgICAgICAgICAgIC13ZWJraXQtdHJhbnNmb3JtOiByb3RhdGUoLTM1OWRlZykKICAgICAgICAgICAgICB9CiAgICAgICAgICAgIH0KICAgICAgICAgICAgQGtleWZyYW1lcyBzcGluIHsKICAgICAgICAgICAgICBmcm9tIHsKICAgICAgICAgICAgICAgIHRyYW5zZm9ybTogcm90YXRlKDBkZWcpCiAgICAgICAgICAgICAgfQogICAgICAgICAgICAgIHRvIHsKICAgICAgICAgICAgICAgIHRyYW5zZm9ybTogcm90YXRlKC0zNTlkZWcpCiAgICAgICAgICAgICAgfQogICAgICAgICAgICB9CiAgICAgICAgICAgIHN2ZyB7CiAgICAgICAgICAgICAgICAtd2Via2l0LXRyYW5zZm9ybS1vcmlnaW46IDUwJSA1MCU7CiAgICAgICAgICAgICAgICAtd2Via2l0LWFuaW1hdGlvbjogc3BpbiAxLjVzIGxpbmVhciBpbmZpbml0ZTsKICAgICAgICAgICAgICAgIC13ZWJraXQtYmFja2ZhY2UtdmlzaWJpbGl0eTogaGlkZGVuOwogICAgICAgICAgICAgICAgYW5pbWF0aW9uOiBzcGluIDEuNXMgbGluZWFyIGluZmluaXRlOwogICAgICAgICAgICB9CiAgICAgICAgXV0+PC9zdHlsZT4KICAgIDwvZGVmcz4KICAgIDxnIGlkPSJvdXRlciI+CiAgICAgICAgPGc+CiAgICAgICAgICAgIDxwYXRoIGQ9Ik0yMCwwQzIyLjIwNTgsMCAyMy45OTM5LDEuNzg4MTMgMjMuOTkzOSwzLjk5MzlDMjMuOTkzOSw2LjE5OTY4IDIyLjIwNTgsNy45ODc4MSAyMCw3Ljk4NzgxQzE3Ljc5NDIsNy45ODc4MSAxNi4wMDYxLDYuMTk5NjggMTYuMDA2MSwzLjk5MzlDMTYuMDA2MSwxLjc4ODEzIDE3Ljc5NDIsMCAyMCwwWiIgc3R5bGU9ImZpbGw6YmxhY2s7Ii8+CiAgICAgICAgPC9nPgogICAgICAgIDxnPgogICAgICAgICAgICA8cGF0aCBkPSJNNS44NTc4Niw1Ljg1Nzg2QzcuNDE3NTgsNC4yOTgxNSA5Ljk0NjM4LDQuMjk4MTUgMTEuNTA2MSw1Ljg1Nzg2QzEzLjA2NTgsNy40MTc1OCAxMy4wNjU4LDkuOTQ2MzggMTEuNTA2MSwxMS41MDYxQzkuOTQ2MzgsMTMuMDY1OCA3LjQxNzU4LDEzLjA2NTggNS44NTc4NiwxMS41MDYxQzQuMjk4MTUsOS45NDYzOCA0LjI5ODE1LDcuNDE3NTggNS44NTc4Niw1Ljg1Nzg2WiIgc3R5bGU9ImZpbGw6cmdiKDIxMCwyMTAsMjEwKTsiLz4KICAgICAgICA8L2c+CiAgICAgICAgPGc+CiAgICAgICAgICAgIDxwYXRoIGQ9Ik0yMCwzMi4wMTIyQzIyLjIwNTgsMzIuMDEyMiAyMy45OTM5LDMzLjgwMDMgMjMuOTkzOSwzNi4wMDYxQzIzLjk5MzksMzguMjExOSAyMi4yMDU4LDQwIDIwLDQwQzE3Ljc5NDIsNDAgMTYuMDA2MSwzOC4yMTE5IDE2LjAwNjEsMzYuMDA2MUMxNi4wMDYxLDMzLjgwMDMgMTcuNzk0MiwzMi4wMTIyIDIwLDMyLjAxMjJaIiBzdHlsZT0iZmlsbDpyZ2IoMTMwLDEzMCwxMzApOyIvPgogICAgICAgIDwvZz4KICAgICAgICA8Zz4KICAgICAgICAgICAgPHBhdGggZD0iTTI4LjQ5MzksMjguNDkzOUMzMC4wNTM2LDI2LjkzNDIgMzIuNTgyNCwyNi45MzQyIDM0LjE0MjEsMjguNDkzOUMzNS43MDE5LDMwLjA1MzYgMzUuNzAxOSwzMi41ODI0IDM0LjE0MjEsMzQuMTQyMUMzMi41ODI0LDM1LjcwMTkgMzAuMDUzNiwzNS43MDE5IDI4LjQ5MzksMzQuMTQyMUMyNi45MzQyLDMyLjU4MjQgMjYuOTM0MiwzMC4wNTM2IDI4LjQ5MzksMjguNDkzOVoiIHN0eWxlPSJmaWxsOnJnYigxMDEsMTAxLDEwMSk7Ii8+CiAgICAgICAgPC9nPgogICAgICAgIDxnPgogICAgICAgICAgICA8cGF0aCBkPSJNMy45OTM5LDE2LjAwNjFDNi4xOTk2OCwxNi4wMDYxIDcuOTg3ODEsMTcuNzk0MiA3Ljk4NzgxLDIwQzcuOTg3ODEsMjIuMjA1OCA2LjE5OTY4LDIzLjk5MzkgMy45OTM5LDIzLjk5MzlDMS43ODgxMywyMy45OTM5IDAsMjIuMjA1OCAwLDIwQzAsMTcuNzk0MiAxLjc4ODEzLDE2LjAwNjEgMy45OTM5LDE2LjAwNjFaIiBzdHlsZT0iZmlsbDpyZ2IoMTg3LDE4NywxODcpOyIvPgogICAgICAgIDwvZz4KICAgICAgICA8Zz4KICAgICAgICAgICAgPHBhdGggZD0iTTUuODU3ODYsMjguNDkzOUM3LjQxNzU4LDI2LjkzNDIgOS45NDYzOCwyNi45MzQyIDExLjUwNjEsMjguNDkzOUMxMy4wNjU4LDMwLjA1MzYgMTMuMDY1OCwzMi41ODI0IDExLjUwNjEsMzQuMTQyMUM5Ljk0NjM4LDM1LjcwMTkgNy40MTc1OCwzNS43MDE5IDUuODU3ODYsMzQuMTQyMUM0LjI5ODE1LDMyLjU4MjQgNC4yOTgxNSwzMC4wNTM2IDUuODU3ODYsMjguNDkzOVoiIHN0eWxlPSJmaWxsOnJnYigxNjQsMTY0LDE2NCk7Ii8+CiAgICAgICAgPC9nPgogICAgICAgIDxnPgogICAgICAgICAgICA8cGF0aCBkPSJNMzYuMDA2MSwxNi4wMDYxQzM4LjIxMTksMTYuMDA2MSA0MCwxNy43OTQyIDQwLDIwQzQwLDIyLjIwNTggMzguMjExOSwyMy45OTM5IDM2LjAwNjEsMjMuOTkzOUMzMy44MDAzLDIzLjk5MzkgMzIuMDEyMiwyMi4yMDU4IDMyLjAxMjIsMjBDMzIuMDEyMiwxNy43OTQyIDMzLjgwMDMsMTYuMDA2MSAzNi4wMDYxLDE2LjAwNjFaIiBzdHlsZT0iZmlsbDpyZ2IoNzQsNzQsNzQpOyIvPgogICAgICAgIDwvZz4KICAgICAgICA8Zz4KICAgICAgICAgICAgPHBhdGggZD0iTTI4LjQ5MzksNS44NTc4NkMzMC4wNTM2LDQuMjk4MTUgMzIuNTgyNCw0LjI5ODE1IDM0LjE0MjEsNS44NTc4NkMzNS43MDE5LDcuNDE3NTggMzUuNzAxOSw5Ljk0NjM4IDM0LjE0MjEsMTEuNTA2MUMzMi41ODI0LDEzLjA2NTggMzAuMDUzNiwxMy4wNjU4IDI4LjQ5MzksMTEuNTA2MUMyNi45MzQyLDkuOTQ2MzggMjYuOTM0Miw3LjQxNzU4IDI4LjQ5MzksNS44NTc4NloiIHN0eWxlPSJmaWxsOnJnYig1MCw1MCw1MCk7Ii8+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4K\";\n    img.alt = \"Loading...\";\n    content.appendChild(img);\n    modal.appendChild(content); // modal.innerHTML = `\n    //     <div class=\"AjaxSpinner-modal\">\n    //         <img alt=\"\" src=\"\" />\n    //     </div>\n    // `;\n\n    this.root.appendChild(modal);\n    this.modal = document.querySelector('.AjaxSpinner-modal');\n  }\n\n  _createClass(AjaxSpinner, [{\n    key: \"show\",\n    value: function show() {\n      this.modal.classList.add('active');\n    }\n  }, {\n    key: \"hide\",\n    value: function hide() {\n      this.modal.classList.remove('active');\n    }\n  }]);\n\n  return AjaxSpinner;\n}();\n\nvar onInit = function onInit() {\n  var pluginRoot = document.querySelector('[data-import-plugin]');\n  window.ajaxSpinner = new AjaxSpinner(pluginRoot);\n};\n\n//# sourceURL=webpack:///./resources/js/modules/AjaxSpinner.js?")},"./resources/js/modules/EntryPreview.js":
/*!**********************************************!*\
  !*** ./resources/js/modules/EntryPreview.js ***!
  \**********************************************/
/*! exports provided: default */function(module,__webpack_exports__,__webpack_require__){"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return EntryPreview; });\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\nvar camelCase = function camelCase(str) {\n  return str.replace(/(?:^\\w|[A-Z]|\\b\\w)/g, function (letter, index) {\n    return index == 0 ? letter.toLowerCase() : letter.toUpperCase();\n  }).replace(/\\s+/g, \'\');\n};\n\nvar EntryPreview =\n/*#__PURE__*/\nfunction () {\n  function EntryPreview(node) {\n    _classCallCheck(this, EntryPreview);\n\n    this.node = node;\n    this.id = node.id;\n    this.section = document.querySelector("#section-".concat(this.id));\n    this.type = document.querySelector("#type-".concat(this.id));\n    this.preview = node.children[0];\n    this.body = node.children[1];\n\n    if (this.preview && this.body) {\n      this.preview.addEventListener(\'click\', this.toggleExpand.bind(this));\n    }\n\n    this.initDropdowns();\n    this.initMultiSelects();\n  }\n\n  _createClass(EntryPreview, [{\n    key: "toggleExpand",\n    value: function toggleExpand() {\n      this.body.classList.toggle(\'active\');\n    }\n  }, {\n    key: "initDropdowns",\n    value: function initDropdowns() {\n      var _this = this;\n\n      var dropdowns = document.querySelectorAll(\'select\');\n\n      if (dropdowns && dropdowns.length) {\n        Array.prototype.forEach.call(dropdowns, function (dropdown) {\n          var namePrefix = dropdown.name.replace(/\\[[0-9]+\\]/, \'\');\n\n          switch (namePrefix) {\n            case \'section\':\n              dropdown.addEventListener(\'change\', _this.updateType.bind(_this));\n              break;\n\n            default:\n          }\n        });\n      }\n    }\n  }, {\n    key: "initMultiSelects",\n    value: function initMultiSelects() {\n      var multiSelectOptions = document.querySelectorAll(\'select[multiple]>option\');\n      Array.prototype.forEach.call(multiSelectOptions, function (opt) {\n        opt.selected = true;\n      });\n    }\n  }, {\n    key: "updateType",\n    value: function updateType(e) {\n      var _this2 = this;\n\n      var newValue = parseInt(e.target.value);\n      fetch("/admin/import/sections/types/".concat(newValue)).then(function (resp) {\n        return resp.json();\n      }).then(function (data) {\n        var newTypes = data;\n\n        if (newTypes) {\n          var options = \'\';\n\n          for (var i = 0; i < newTypes.length; i++) {\n            options += "<option value=\\"".concat(newTypes[i].id, "\\">").concat(newTypes[i].name, "</option>");\n          }\n\n          _this2.type.innerHTML = options;\n        } else {\n          console.log(\'Error\');\n          _this2.type.innerHTML = \'\';\n        }\n      });\n    }\n  }, {\n    key: "toggleSites",\n    value: function toggleSites(e) {\n      var options = document.querySelectorAll("select[name=\\"sites[".concat(this.id, "][]\\"]>option"));\n\n      if (options && options.length) {\n        // Look at the first checkbox to see if we are checking/unchecking the rest of them\n        var selected = options[0].selected;\n        Array.prototype.forEach.call(options, function (option) {\n          option.selected = !selected;\n        });\n      }\n    }\n  }]);\n\n  return EntryPreview;\n}();\n\n\n\n//# sourceURL=webpack:///./resources/js/modules/EntryPreview.js?')},"./resources/js/modules/FileUpload.js":
/*!********************************************!*\
  !*** ./resources/js/modules/FileUpload.js ***!
  \********************************************/
/*! exports provided: onInit */function(module,__webpack_exports__,__webpack_require__){"use strict";eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"onInit\", function() { return onInit; });\n/* harmony import */ var _EntryPreview__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EntryPreview */ \"./resources/js/modules/EntryPreview.js\");\n/* harmony import */ var _NewSectionButton__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./NewSectionButton */ \"./resources/js/modules/NewSectionButton.js\");\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\n\n\n\nvar removeDragData = function removeDragData(e) {\n  if (e.dataTransfer.items) {\n    e.dataTransfer.items.clear();\n  } else {\n    e.dataTransfer.clearData();\n  }\n};\n\nvar FileUpload =\n/*#__PURE__*/\nfunction () {\n  function FileUpload(node) {\n    _classCallCheck(this, FileUpload);\n\n    this.element = node;\n    this.uploadUrl = '/admin/import/upload';\n    this.label = 'Choose a file';\n    this.files = [];\n    this.results = document.querySelector('[data-import-file-upload-result]'); // Drag/drop\n\n    this.element.addEventListener('drop', this.dropHandler.bind(this));\n    this.element.addEventListener('dragover', this.dragOverHandler.bind(this)); // Clear\n\n    document.querySelector('[data-import-file-clear]').addEventListener('click', this.clearFiles.bind(this)); // Input type=\"file\"\n\n    this.input = document.querySelector('input[type=\"file\"].FileUpload-input');\n\n    if (this.input) {\n      this.input.addEventListener('change', this.fileSelectHandler.bind(this));\n    }\n\n    this.setSubmitEnabled(false);\n  }\n\n  _createClass(FileUpload, [{\n    key: \"upload\",\n    value: function upload() {\n      var _this = this;\n\n      if (window.ajaxSpinner) {\n        window.ajaxSpinner.show();\n        console.log('Ajax Spinner activated');\n      }\n\n      var formData = new FormData();\n      Array.prototype.forEach.call(this.files, function (f) {\n        formData.append('files[]', f, f.name);\n      });\n      fetch(this.uploadUrl, {\n        method: 'post',\n        credentials: 'same-origin',\n        headers: {\n          'X-Requested-With': 'XMLHttpRequest'\n        },\n        body: formData\n      }).then(function (resp) {\n        return resp.text();\n      }).then(function (data) {\n        _this.results.innerHTML = data;\n        var entries = document.querySelectorAll('.ImportPreview-entry');\n\n        if (entries && entries.length) {\n          Array.prototype.forEach.call(entries, function (entry) {\n            new _EntryPreview__WEBPACK_IMPORTED_MODULE_0__[\"default\"](entry);\n          });\n\n          _this.setSubmitEnabled(true);\n\n          Object(_NewSectionButton__WEBPACK_IMPORTED_MODULE_1__[\"onInit\"])();\n          var metaFields = document.querySelectorAll('[data-meta]');\n\n          if (metaFields) {\n            Array.prototype.forEach.call(metaFields, function (field) {\n              console.log(field.innerText);\n              eval(field.innerText);\n            });\n          }\n\n          if (window.submitButton) {\n            window.submitButton.show();\n          }\n        }\n      }).finally(function () {\n        if (window.ajaxSpinner) {\n          window.ajaxSpinner.hide();\n        }\n      });\n    }\n  }, {\n    key: \"fileSelectHandler\",\n    value: function fileSelectHandler(e) {\n      this.input.disabed = true;\n      this.files = e.target.files;\n      this.updateLabel();\n      this.upload();\n    }\n  }, {\n    key: \"dropHandler\",\n    value: function dropHandler(e) {\n      var _this2 = this;\n\n      console.log(e);\n      e.preventDefault();\n\n      if (e.dataTransfer.items) {\n        Array.prototype.forEach.call(e.dataTransfer.items, function (item) {\n          if (item.kind === 'file') {\n            var file = item.getAsFile();\n\n            _this2.files.push(file);\n          }\n        });\n      } else {\n        Array.prototype.forEach.call(e.dataTransfer.files, function (file) {\n          _this2.files.push(file);\n        });\n      }\n\n      this.updateLabel();\n      removeDragData(e);\n      this.upload();\n      return;\n    }\n  }, {\n    key: \"dragOverHandler\",\n    value: function dragOverHandler(e) {\n      e.preventDefault();\n      return;\n    }\n  }, {\n    key: \"clearFiles\",\n    value: function clearFiles() {\n      this.files = [];\n      this.updateLabel();\n      this.results.innerHTML = '';\n      this.setSubmitEnabled(false);\n    }\n  }, {\n    key: \"setSubmitEnabled\",\n    value: function setSubmitEnabled(enabled) {\n      var submitButton = document.querySelector('[data-submit-button]');\n\n      if (submitButton) {\n        submitButton.dataset.valid = enabled ? '1' : '0';\n      }\n    }\n  }, {\n    key: \"updateLabel\",\n    value: function updateLabel() {\n      var _this3 = this;\n\n      this.label = '';\n      var labelSpan = document.querySelector('.FileUpload-input + label>span');\n      var instructionSpan = document.querySelector('[data-import-file-instructions]');\n      var clearSpan = document.querySelector('[data-import-file-clear]');\n\n      if (this.files && this.files.length) {\n        console.log(this.files);\n        Array.prototype.forEach.call(this.files, function (file) {\n          if (_this3.label.length) {\n            _this3.label += ', ';\n          }\n\n          _this3.label += file.name;\n        });\n        instructionSpan.classList.add('hidden');\n        clearSpan.classList.remove('hidden');\n      } else {\n        this.label = 'Choose a file';\n        instructionSpan.classList.remove('hidden');\n        clearSpan.classList.add('hidden');\n      }\n\n      labelSpan.innerText = this.label;\n    }\n  }]);\n\n  return FileUpload;\n}();\n\nvar onInit = function onInit() {\n  var fileUploads = document.querySelectorAll('[data-import-file-upload]');\n\n  if (fileUploads && fileUploads.length) {\n    Array.prototype.forEach.call(fileUploads, function (f) {\n      new FileUpload(f);\n    });\n  }\n};\n\n//# sourceURL=webpack:///./resources/js/modules/FileUpload.js?")},"./resources/js/modules/ImportResult.js":
/*!**********************************************!*\
  !*** ./resources/js/modules/ImportResult.js ***!
  \**********************************************/
/*! exports provided: default */function(module,__webpack_exports__,__webpack_require__){"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return ImportResult; });\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\nvar ImportResult =\n/*#__PURE__*/\nfunction () {\n  function ImportResult(node) {\n    _classCallCheck(this, ImportResult);\n\n    this.node = node;\n    this.preview = node.children[0];\n    this.body = node.children[1];\n\n    if (this.preview && this.body) {\n      this.preview.addEventListener(\'click\', this.toggleExpand.bind(this));\n    }\n  }\n\n  _createClass(ImportResult, [{\n    key: "toggleExpand",\n    value: function toggleExpand() {\n      this.body.classList.toggle(\'active\');\n    }\n  }]);\n\n  return ImportResult;\n}();\n\n\n\n//# sourceURL=webpack:///./resources/js/modules/ImportResult.js?')},"./resources/js/modules/ImportResults.js":
/*!***********************************************!*\
  !*** ./resources/js/modules/ImportResults.js ***!
  \***********************************************/
/*! exports provided: onInit */function(module,__webpack_exports__,__webpack_require__){"use strict";eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"onInit\", function() { return onInit; });\n/* harmony import */ var _ImportResult__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ImportResult */ \"./resources/js/modules/ImportResult.js\");\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\n\n\nvar ImportResults =\n/*#__PURE__*/\nfunction () {\n  function ImportResults(node) {\n    _classCallCheck(this, ImportResults);\n\n    this.node = node;\n    console.log(node);\n  }\n\n  _createClass(ImportResults, [{\n    key: \"parseResults\",\n    value: function parseResults(data) {\n      var _this = this;\n\n      var results = document.createElement('div');\n      results.classList.add('ImportResult');\n      var title = document.createElement('h1');\n      title.innerText = 'Results';\n      results.appendChild(title);\n      data.forEach(function (result) {\n        console.log(result);\n        var container = document.createElement('div');\n        container.classList.add('ImportResult-entry');\n        container.id = \"result-\".concat(result.original.id);\n        var preview = document.createElement('div');\n        preview.classList.add('preview');\n\n        if (result.success) {\n          preview.classList.add('success');\n        } else {\n          preview.classList.add('fail');\n        }\n\n        var id = document.createElement('span');\n        id.innerText = \"ID: \".concat(result.original.id);\n        preview.appendChild(id);\n        var body = document.createElement('div');\n        body.classList.add('content');\n        var pre = document.createElement('pre');\n        pre.innerHTML = _this.parseLog(result);\n        body.appendChild(pre);\n        container.appendChild(preview);\n        container.appendChild(body);\n        results.appendChild(container);\n        new _ImportResult__WEBPACK_IMPORTED_MODULE_0__[\"default\"](container);\n      });\n      this.node.appendChild(results);\n    }\n  }, {\n    key: \"parseLog\",\n    value: function parseLog(result) {\n      var markup = '';\n      result.log.forEach(function (line) {\n        var classes = line.indexOf('error') >= 0 ? 'log-error' : 'log-info';\n        markup += \"<span class=\\\"\".concat(classes, \"\\\">\").concat(line, \"</span><br>\");\n      });\n      return markup;\n    }\n  }]);\n\n  return ImportResults;\n}();\n\nvar onInit = function onInit() {\n  var resultsContainer = document.querySelector('.ImportResults');\n\n  if (resultsContainer) {\n    window.importResults = new ImportResults(resultsContainer);\n  }\n};\n\n//# sourceURL=webpack:///./resources/js/modules/ImportResults.js?")},"./resources/js/modules/NewSectionButton.js":
/*!**************************************************!*\
  !*** ./resources/js/modules/NewSectionButton.js ***!
  \**************************************************/
/*! exports provided: onInit */function(module,__webpack_exports__,__webpack_require__){"use strict";eval('__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onInit", function() { return onInit; });\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\nvar NewSectionButton =\n/*#__PURE__*/\nfunction () {\n  function NewSectionButton(node) {\n    _classCallCheck(this, NewSectionButton);\n\n    this.node = node;\n    this.node.addEventListener(\'click\', this.addNewSection);\n  }\n\n  _createClass(NewSectionButton, [{\n    key: "addNewSection",\n    value: function addNewSection() {\n      var opts = {};\n      Craft.postActionRequest(opts);\n    }\n  }]);\n\n  return NewSectionButton;\n}();\n\nvar onInit = function onInit() {\n  var newSectionButtons = document.querySelectorAll(\'[data-new-section-btn]\');\n\n  if (newSectionButtons) {\n    Array.prototype.forEach.call(newSectionButtons, function (button) {\n      new NewSectionButton(button);\n    });\n  }\n};\n\n//# sourceURL=webpack:///./resources/js/modules/NewSectionButton.js?')},"./resources/js/modules/SubmitButton.js":
/*!**********************************************!*\
  !*** ./resources/js/modules/SubmitButton.js ***!
  \**********************************************/
/*! exports provided: onInit */function(module,__webpack_exports__,__webpack_require__){"use strict";eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"onInit\", function() { return onInit; });\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\nvar SubmitButton =\n/*#__PURE__*/\nfunction () {\n  function SubmitButton(node) {\n    _classCallCheck(this, SubmitButton);\n\n    this.container = node;\n    this.button = node.children[0];\n    this.action = node.children[1];\n    this.submitUrl = this.action.value;\n    this.button.addEventListener('click', this.submit.bind(this));\n  }\n\n  _createClass(SubmitButton, [{\n    key: \"show\",\n    value: function show() {\n      this.container.classList.add('active');\n    }\n  }, {\n    key: \"hide\",\n    value: function hide() {\n      this.container.classList.remove('active');\n    }\n  }, {\n    key: \"submit\",\n    value: function submit(e) {\n      var _this = this;\n\n      if (window.ajaxSpinner) {\n        window.ajaxSpinner.show();\n      }\n\n      e.preventDefault();\n      var formData = this.serialize();\n      fetch(this.submitUrl, {\n        method: 'post',\n        credentials: 'same-origin',\n        headers: {\n          'X-Requested-With': 'XMLHttpRequest'\n        },\n        body: formData\n      }).then(function (resp) {\n        return resp.json();\n      }).then(function (data) {\n        console.log(data);\n\n        if (window.importResults) {\n          window.importResults.parseResults(data);\n        }\n      }).finally(function () {\n        if (window.ajaxSpinner) {\n          window.ajaxSpinner.hide();\n        }\n\n        _this.hide();\n      });\n    }\n  }, {\n    key: \"serialize\",\n    value: function serialize() {\n      var formData = new FormData(); // Get the original import file name\n\n      var file = document.querySelector('[name=\"importFile\"]');\n\n      if (file) {\n        formData.append('importFile', file.value);\n      }\n\n      var allInputs = document.querySelectorAll('input,select'); //'.ImportPreview-entry--field>.input>*');\n\n      if (allInputs && allInputs.length) {\n        Array.prototype.forEach.call(allInputs, function (input) {\n          if (input.disabled) {\n            return;\n          } else if (input.options !== undefined) {\n            // Select\n            var value = '';\n            Array.prototype.forEach.call(input.selectedOptions, function (opt) {\n              if (value.length) {\n                value += ',';\n              }\n\n              value += opt.value;\n            });\n            formData.append(input.name, value);\n          } else {\n            // Normal text input\n            formData.append(input.name, input.value);\n          }\n        });\n      }\n\n      return formData;\n    }\n  }]);\n\n  return SubmitButton;\n}();\n\nvar onInit = function onInit() {\n  var submitButton = document.querySelector('#submitButton');\n\n  if (submitButton) {\n    window.submitButton = new SubmitButton(submitButton);\n  }\n};\n\n//# sourceURL=webpack:///./resources/js/modules/SubmitButton.js?")},"./resources/sass/Import.scss":
/*!************************************!*\
  !*** ./resources/sass/Import.scss ***!
  \************************************/
/*! no static exports found */function(module,exports,__webpack_require__){eval('\nvar content = __webpack_require__(/*! !../../node_modules/mini-css-extract-plugin/dist/loader.js!../../node_modules/css-loader!../../node_modules/postcss-loader/src??embedded!../../node_modules/sass-loader/lib/loader.js!./Import.scss */ "./node_modules/mini-css-extract-plugin/dist/loader.js!./node_modules/css-loader/index.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/lib/loader.js!./resources/sass/Import.scss");\n\nif(typeof content === \'string\') content = [[module.i, content, \'\']];\n\nvar transform;\nvar insertInto;\n\n\n\nvar options = {"hmr":true}\n\noptions.transform = transform\noptions.insertInto = undefined;\n\nvar update = __webpack_require__(/*! ../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);\n\nif(content.locals) module.exports = content.locals;\n\nif(false) {}\n\n//# sourceURL=webpack:///./resources/sass/Import.scss?')},0:
/*!**************************************!*\
  !*** multi ./resources/js/Import.js ***!
  \**************************************/
/*! no static exports found */function(module,exports,__webpack_require__){eval('module.exports = __webpack_require__(/*! /Users/abryrath/Union/Library/import/resources/js/Import.js */"./resources/js/Import.js");\n\n\n//# sourceURL=webpack:///multi_./resources/js/Import.js?')}});