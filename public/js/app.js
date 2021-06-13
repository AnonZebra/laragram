/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

 // language picker toggling

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

var desktopLangPicker = document.getElementById('language-picker');
var mobileLangPicker = document.getElementById('mobile-language-picker');
[desktopLangPicker, mobileLangPicker].forEach(function (langPicker) {
  langPicker.addEventListener('click', langClickWrapper(langPicker));
  langPicker.addEventListener('mouseover', langMouseOverWrapper(langPicker));
  langPicker.addEventListener('mouseout', langMouseOutWrapper(langPicker));
});

function langClickWrapper(targetEl) {
  var innerFun = function innerFun() {
    targetEl.classList.toggle('activated');

    var _iterator = _createForOfIteratorHelper(targetEl.children),
        _step;

    try {
      for (_iterator.s(); !(_step = _iterator.n()).done;) {
        var child = _step.value;

        if (child.classList.contains('language-choice')) {
          child.classList.toggle('display-none');
          child.classList.toggle('display-block');
        }
      }
    } catch (err) {
      _iterator.e(err);
    } finally {
      _iterator.f();
    }
  };

  return innerFun;
}

function langMouseOverWrapper(targetEl) {
  var innerFun = function innerFun() {
    targetEl.classList.add('activated');

    var _iterator2 = _createForOfIteratorHelper(targetEl.children),
        _step2;

    try {
      for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
        var child = _step2.value;

        if (child.classList.contains('language-choice')) {
          child.classList.remove('display-none');
          child.classList.add('display-block');
        }
      }
    } catch (err) {
      _iterator2.e(err);
    } finally {
      _iterator2.f();
    }
  };

  return innerFun;
}

function langMouseOutWrapper(targetEl) {
  var innerFun = function innerFun() {
    targetEl.classList.remove('activated');

    var _iterator3 = _createForOfIteratorHelper(targetEl.children),
        _step3;

    try {
      for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
        var child = _step3.value;

        if (child.classList.contains('language-choice')) {
          child.classList.add('display-none');
          child.classList.remove('display-block');
        }
      }
    } catch (err) {
      _iterator3.e(err);
    } finally {
      _iterator3.f();
    }
  };

  return innerFun;
} // mobile navigation toggling


var menuToggle = document.getElementById('menu-toggle');
var mobileNav = document.getElementById('mobile-nav');
var mobileNavShadow = document.getElementById('mobile-nav-shadow');
var isThrottling = false;
menuToggle.addEventListener('click', function () {
  if (isThrottling) {
    return;
  }

  if (mobileNav.classList.contains('active')) {
    isThrottling = true;
    setTimeout(function () {
      mobileNavShadow.classList.toggle('active');
      mobileNav.classList.toggle('active');
      isThrottling = false;
    }, 1000);
    window.requestAnimationFrame(rightStep);
    window.requestAnimationFrame(downOpacity);
  } else {
    isThrottling = true;
    setTimeout(function () {
      isThrottling = false;
    }, 1000);
    mobileNavShadow.classList.toggle('active');
    mobileNav.classList.toggle('active');
    window.requestAnimationFrame(leftStep);
    window.requestAnimationFrame(upOpacity);
  }
});
window.addEventListener('resize', function () {
  if (isThrottling) {
    return;
  }

  if (mobileNav.classList.contains('active') && window.innerWidth > 700) {
    isThrottling = true;
    setTimeout(function () {
      mobileNavShadow.classList.toggle('active');
      mobileNav.classList.toggle('active');
      isThrottling = false;
    }, 1000);
    window.requestAnimationFrame(rightStep);
    window.requestAnimationFrame(downOpacity);
  }
});
var start;

function leftStep(timestamp) {
  if (start === undefined) start = timestamp;
  var elapsed = timestamp - start; // `Math.min()` is used here to make sure that the element stops at exactly 50vw.

  var vwWal = Math.max(100 - 0.2 * elapsed, 50);
  mobileNav.style.left = vwWal + 'vw';

  if (elapsed < 1000 || vwWal > 50) {
    // Stop the animation after 1 second
    window.requestAnimationFrame(leftStep);
  } else {
    start = undefined;
  }
}

function rightStep(timestamp) {
  if (start === undefined) start = timestamp;
  var elapsed = timestamp - start; // `Math.min()` is used here to make sure that the element stops at exactly 100vw.

  var vWval = Math.min(50 + 0.2 * elapsed, 100);
  mobileNav.style.left = vWval + 'vw';

  if (elapsed < 1000 || vWval < 100) {
    window.requestAnimationFrame(rightStep);
  } else {
    start = undefined;
  }
}

var opStart;

function upOpacity(timestamp) {
  if (opStart === undefined) opStart = timestamp;
  var elapsed = timestamp - opStart; // `Math.min()` is used here to make sure that the element stops at exactly 0.9.

  var opa = Math.min(0.0018 * elapsed, 0.9);
  mobileNavShadow.style.opacity = opa;

  if (elapsed < 500 || opa < 0.9) {
    window.requestAnimationFrame(upOpacity);
  } else {
    opStart = undefined;
  }
}

function downOpacity(timestamp) {
  if (opStart === undefined) opStart = timestamp;
  var elapsed = timestamp - opStart;
  var opa = Math.max(0.9 - 0.0018 * elapsed, 0);
  mobileNavShadow.style.opacity = opa;

  if (elapsed < 500 || opa > 0) {
    window.requestAnimationFrame(downOpacity);
  } else {
    opStart = undefined;
  }
}

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					result = fn();
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			for(moduleId in moreModules) {
/******/ 				if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 					__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 				}
/******/ 			}
/******/ 			if(runtime) var result = runtime(__webpack_require__);
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/sass/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;