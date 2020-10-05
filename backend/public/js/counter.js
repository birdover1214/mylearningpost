/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
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
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/text_counter.js":
/*!*********************************************!*\
  !*** ./resources/assets/js/text_counter.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("window.addEventListener('DOMContentLoaded', function () {\n  var defaultCount = $('.input-textarea').val().length;\n  $('.text-counter').text(defaultCount);\n});\n$(function () {\n  $('.input-textarea').keyup(function () {\n    var count = $(this).val().length;\n    $('.text-counter').text(count);\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2pzL3RleHRfY291bnRlci5qcz8yMDYyIl0sIm5hbWVzIjpbIndpbmRvdyIsImFkZEV2ZW50TGlzdGVuZXIiLCJkZWZhdWx0Q291bnQiLCIkIiwidmFsIiwibGVuZ3RoIiwidGV4dCIsImtleXVwIiwiY291bnQiXSwibWFwcGluZ3MiOiJBQUFBQSxNQUFNLENBQUNDLGdCQUFQLENBQXdCLGtCQUF4QixFQUE0QyxZQUFXO0FBQ25ELE1BQU1DLFlBQVksR0FBR0MsQ0FBQyxDQUFDLGlCQUFELENBQUQsQ0FBcUJDLEdBQXJCLEdBQTJCQyxNQUFoRDtBQUNBRixHQUFDLENBQUMsZUFBRCxDQUFELENBQW1CRyxJQUFuQixDQUF3QkosWUFBeEI7QUFDSCxDQUhEO0FBS0FDLENBQUMsQ0FBQyxZQUFXO0FBQ1RBLEdBQUMsQ0FBQyxpQkFBRCxDQUFELENBQXFCSSxLQUFyQixDQUEyQixZQUFXO0FBQ2xDLFFBQUlDLEtBQUssR0FBR0wsQ0FBQyxDQUFDLElBQUQsQ0FBRCxDQUFRQyxHQUFSLEdBQWNDLE1BQTFCO0FBQ0FGLEtBQUMsQ0FBQyxlQUFELENBQUQsQ0FBbUJHLElBQW5CLENBQXdCRSxLQUF4QjtBQUNILEdBSEQ7QUFJSCxDQUxBLENBQUQiLCJmaWxlIjoiLi9yZXNvdXJjZXMvYXNzZXRzL2pzL3RleHRfY291bnRlci5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbIndpbmRvdy5hZGRFdmVudExpc3RlbmVyKCdET01Db250ZW50TG9hZGVkJywgZnVuY3Rpb24oKSB7XHJcbiAgICBjb25zdCBkZWZhdWx0Q291bnQgPSAkKCcuaW5wdXQtdGV4dGFyZWEnKS52YWwoKS5sZW5ndGg7XHJcbiAgICAkKCcudGV4dC1jb3VudGVyJykudGV4dChkZWZhdWx0Q291bnQpO1xyXG59KVxyXG5cclxuJChmdW5jdGlvbigpIHtcclxuICAgICQoJy5pbnB1dC10ZXh0YXJlYScpLmtleXVwKGZ1bmN0aW9uKCkge1xyXG4gICAgICAgIGxldCBjb3VudCA9ICQodGhpcykudmFsKCkubGVuZ3RoO1xyXG4gICAgICAgICQoJy50ZXh0LWNvdW50ZXInKS50ZXh0KGNvdW50KTtcclxuICAgIH0pO1xyXG59KTsiXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/assets/js/text_counter.js\n");

/***/ }),

/***/ 2:
/*!***************************************************!*\
  !*** multi ./resources/assets/js/text_counter.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\userpc\desktop\docker-php\laravel-tmp\backend\resources\assets\js\text_counter.js */"./resources/assets/js/text_counter.js");


/***/ })

/******/ });