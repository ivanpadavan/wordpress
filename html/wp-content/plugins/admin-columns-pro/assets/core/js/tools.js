!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=16)}([function(e,t,n){"use strict";var r=function(e){return e&&e.__esModule?e:{default:e}}(n(1));function o(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}var i=function(){function e(t){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),t&&(this.el=t,this.dialog=t.querySelector(".ac-modal__dialog"),this.initEvents())}return function(e,t,n){t&&o(e.prototype,t),n&&o(e,n)}(e,[{key:"initEvents",value:function(){var t=this,n=this;document.addEventListener("keydown",function(e){var n=event.key;t.isOpen()&&"Escape"===n&&t.close()});var r=this.el.querySelectorAll('[data-dismiss="modal"], .ac-modal__dialog__close');r.length>0&&r.forEach(function(e){e.addEventListener("click",function(e){e.preventDefault(),n.close()})}),this.el.addEventListener("click",function(){n.close()}),this.el.querySelector(".ac-modal__dialog").addEventListener("click",function(e){e.stopPropagation()}),void 0===document.querySelector("body").dataset.ac_modal_init&&(e.initGlobalEvents(),document.querySelector("body").dataset.ac_modal_init=1),this.el.AC_MODAL=n}},{key:"isOpen",value:function(){return this.el.classList.contains("-active")}},{key:"close",value:function(){this.onClose(),this.el.classList.remove("-active")}},{key:"open",value:function(){this.onOpen(),this.el.removeAttribute("style"),this.el.classList.add("-active")}},{key:"destroy",value:function(){this.el.remove()}},{key:"onClose",value:function(){}},{key:"onOpen",value:function(){}}],[{key:"initGlobalEvents",value:function(){jQuery(document).on("click","[data-ac-open-modal]",function(e){e.preventDefault();var t=e.target.dataset.acOpenModal,n=document.querySelector(t);n&&n.AC_MODAL&&n.AC_MODAL.open()}),jQuery(document).on("click","[data-ac-modal]",function(e){e.preventDefault();var t=jQuery(this).data("ac-modal");r.default.init().get(t)&&r.default.init().get(t).open()})}}]),e}();e.exports=i},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var r=function(e){return e&&e.__esModule?e:{default:e}}(n(0));function o(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}var i=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.modals=[],this.number=1}return function(e,t,n){t&&o(e.prototype,t),n&&o(e,n)}(e,[{key:"register",value:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"";return t||(t="m"+this.number),this.modals[t]=e,this.number++,e}},{key:"get",value:function(e){return!!this.modals[e]&&this.modals[e]}}],[{key:"init",value:function(){return void 0===AdminColumns.Modals&&(AdminColumns.Modals=new this,AdminColumns.Modals._abstract={modal:r.default}),AdminColumns.Modals}}]),e}();t.default=i},,,,,,,,,,,,,,,function(e,t,n){"use strict";var r=u(n(17)),o=u(n(18)),i=u(n(19));function u(e){return e&&e.__esModule?e:{default:e}}document.addEventListener("DOMContentLoaded",function(){AdminColumns.Tools={};var e=document.querySelector(".ac-section.-syncronisation");e&&(AdminColumns.Tools.Synchronisation=new r.default(e));var t=document.querySelector(".ac-section.-export");t&&(AdminColumns.Tools.Export=new o.default(t));var n=document.querySelector(".ac-section.-import");n&&(AdminColumns.Tools.Import=new i.default(n))})},function(e,t,n){"use strict";function r(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function o(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}function i(e,t,n){return t&&o(e.prototype,t),n&&o(e,n),e}Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var u=function(){function e(t){r(this,e),this.element=t;var n=t.querySelector(".ac-table"),o=t.querySelector(".ac-sync-filter");n&&(this.Table=new l(n)),n&&this.Table&&(this.Filter=new a(o,this.Table)),this.init()}return i(e,[{key:"getSyncButton",value:function(){return this.element.querySelector(".button-primary")}},{key:"checkButtonState",value:function(){var e=this.getSyncButton();e&&this.Table&&(e.setAttribute("disabled",!0),this.Table.getSelectedSyncableItems().length>0&&e.removeAttribute("disabled"))}},{key:"init",value:function(){var e=this,t=this.getSyncButton();t&&(t.setAttribute("disabled",!0),this.checkButtonState(),this.Table.table.querySelectorAll("input[type=checkbox]").forEach(function(t){t.addEventListener("change",function(){return e.checkButtonState()})}))}}]),e}();t.default=u;var l=function(){function e(t){r(this,e),this.table=t}return i(e,[{key:"checkNoResults",value:function(e){var t=this.table.querySelector("tfoot");t.style.display="none",this.hasItemsForFilter(e)||(t.style.display="table-footer-group")}},{key:"hasItemsForFilter",value:function(e){var t=e?"tbody tr.".concat(e):"tbody tr";return this.table.querySelectorAll(t).length>0}},{key:"getSelectedSyncableItems",value:function(){return this.table.querySelectorAll("input[type=checkbox]:checked")}},{key:"resetSelection",value:function(){this.table.querySelectorAll("input[checkbox]").forEach(function(e){return e.checked=!1})}},{key:"filterRows",value:function(e){if(!e)return this.table.querySelectorAll("tbody tr").forEach(function(e){return e.style.display="table-row"}),void this.checkNoResults(e);this.table.querySelectorAll("tbody tr").forEach(function(e){return e.style.display="none"}),this.table.querySelectorAll("tbody tr.".concat(e)).forEach(function(e){return e.style.display="table-row"}),this.checkNoResults(e)}}]),e}(),a=function(){function e(t,n){r(this,e),this.filter=t,this.table=n,this.init(),this.refresh()}return i(e,[{key:"refresh",value:function(){var e=this.filter.querySelector("a.current");e&&this.setFilter(e)}},{key:"setFilter",value:function(e){this.filter.querySelectorAll("a").forEach(function(e){return e.classList.remove("current")}),e.classList.add("current");var t=e.dataset.filter?e.dataset.filter:"";this.table.filterRows(t)}},{key:"init",value:function(){var e=this;this.filter.querySelectorAll("a").forEach(function(t){t.addEventListener("click",function(n){n.preventDefault(),e.setFilter(t)})});var t=this.filter.querySelector("li:first-child a");if(t&&!t.classList.contains("current")){var n=t.dataset.filter;this.table.hasItemsForFilter(n)&&this.setFilter(t)}}}]),e}()},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var r=function(e){return e&&e.__esModule?e:{default:e}}(n(0));function o(e){return(o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function i(e,t){return!t||"object"!==o(t)&&"function"!=typeof t?function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e):t}function u(e){return(u=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}function l(e,t){return(l=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function a(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function c(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}function s(e,t,n){return t&&c(e.prototype,t),n&&c(e,n),e}var f=function(){function e(t){a(this,e),this.element=t,this.Table=new d(t.querySelector(".ac-table")),this.Modal=new y(document.querySelector("#ac-modal-export-php")),this.getExportJsonButton().setAttribute("disabled",!0),this.getExportPhpButton().setAttribute("disabled",!0),this.initEvents()}return s(e,[{key:"doAjaxExportCall",value:function(){return jQuery.ajax({url:ajaxurl,method:"get",data:{action:"acp-export-php",encoder:"php-export",list_screen_id:this.Table.getSelectedListScreens(),response_type:"string",_ajax_nonce:this.element.querySelector('[name="_ajax_nonce"]').value}})}},{key:"getExportPhpButton",value:function(){return this.element.querySelector('[data-export="php"]')}},{key:"getExportJsonButton",value:function(){return this.element.querySelector('[data-export="json"]')}},{key:"initEvents",value:function(){var e=this;this.getExportPhpButton().addEventListener("click",function(t){t.preventDefault(),e.Modal.open(),e.Modal.setCode(""),e.doAjaxExportCall().done(function(t){e.Modal.setCode(t)})}),this.Table.element.querySelectorAll("input").forEach(function(t){t.addEventListener("change",function(){e.getExportPhpButton().setAttribute("disabled",!0),e.getExportJsonButton().setAttribute("disabled",!0),e.Table.getSelectedListScreens().length>0&&(e.getExportPhpButton().removeAttribute("disabled"),e.getExportJsonButton().removeAttribute("disabled"))})})}}]),e}();t.default=f;var d=function(){function e(t){a(this,e),this.element=t}return s(e,[{key:"getSelectedListScreens",value:function(){var e=[];return this.element.querySelectorAll('[name="list_screen_id[]"]:checked').forEach(function(t){e.push(t.value)}),e}}]),e}(),y=function(e){function t(e){var n;return a(this,t),(n=i(this,u(t).call(this,e))).initCopyToClipboard(),n}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&l(e,t)}(t,r["default"]),s(t,[{key:"getTextArea",value:function(){return this.el.querySelector("textarea")}},{key:"setCode",value:function(e){this.getTextArea().value=e}},{key:"initCopyToClipboard",value:function(){var e=this.getTextArea();e.addEventListener("click",function(){e.focus(),e.select()})}}]),t}()},function(e,t,n){"use strict";function r(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var o=function(){function e(t){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.element=t,this.disable(),this.initEvents()}return function(e,t,n){t&&r(e.prototype,t),n&&r(e,n)}(e,[{key:"initEvents",value:function(){var e=this,t=this.element.querySelector("input[type=file]");t&&t.addEventListener("change",function(){t.value?e.enable():e.disable()})}},{key:"disable",value:function(){this.element.querySelectorAll('input[type="submit"]').forEach(function(e){return e.setAttribute("disabled",!0)})}},{key:"enable",value:function(){this.element.querySelectorAll('input[type="submit"]').forEach(function(e){return e.removeAttribute("disabled")})}}]),e}();t.default=o}]);