!function(r){"use strict";var n=function(o,d,k){var a,p=this;o=r(o),d="function"==typeof d?d(o.val(),void 0,o,k):d,p.init=function(){k=k||{},p.byPassKeys=[9,16,17,18,36,37,38,39,40,91],p.translation={0:{pattern:/\d/},9:{pattern:/\d/,optional:!0},"#":{pattern:/\d/,recursive:!0},A:{pattern:/[a-zA-Z0-9]/},S:{pattern:/[a-zA-Z]/}},p.translation=r.extend({},p.translation,k.translation),p=r.extend(!0,{},p,k),o.each(function(){!1!==k.maxlength&&o.attr("maxlength",d.length),o.attr("autocomplete","off"),y.destroyEvents(),y.events(),y.val(y.getMasked())})};var y={getCaret:function(){var t,e=0,n=o.get(0),a=document.selection,r=n.selectionStart;return a&&-1===navigator.appVersion.indexOf("MSIE 10")?(n.focus(),(t=a.createRange()).moveStart("character",-n.value.length),e=t.text.length):(r||"0"===r)&&(e=r),e},setCaret:function(t){var e,n=o.get(0);n.setSelectionRange?(n.focus(),n.setSelectionRange(t,t)):n.createTextRange&&((e=n.createTextRange()).collapse(!0),e.moveEnd("character",t),e.moveStart("character",t),e.select())},events:function(){o.on("keydown.mask",function(){a=y.val()}),o.on("keyup.mask",y.behaviour),o.on("paste.mask",function(){setTimeout(function(){o.keydown().keyup()},100)})},destroyEvents:function(){o.off("keydown.mask keyup.mask paste.mask")},val:function(t){var e="input"===o.get(0).tagName.toLowerCase();return 0<arguments.length?e?o.val(t):o.text(t):e?o.val():o.text()},behaviour:function(t){if(t=t||window.event,-1===r.inArray(t.keyCode||t.which,p.byPassKeys)){var e,n=y.getCaret();return n<y.val().length&&(e=!0),y.val(y.getMasked()),e&&y.setCaret(n),y.callbacks(t)}},getMasked:function(t){var e,n,a=[],r=y.val(),o=0,s=d.length,i=0,c=r.length,u=1,l="push",f=-1;for(k.reverse?(l="unshift",u=-1,e=0,o=s-1,i=c-1,n=function(){return-1<o&&-1<i}):(e=s-1,n=function(){return o<s&&i<c});n();){var v=d.charAt(o),h=r.charAt(i),g=p.translation[v];g?(h.match(g.pattern)?(a[l](h),g.recursive&&(-1===f?f=o:o===e&&(o=f-u),e===f&&(o-=u)),o+=u):g.optional&&(o+=u,i-=u),i+=u):(t||a[l](v),h===v&&(i+=u),o+=u)}var m=d.charAt(e);return s!==c+1||p.translation[m]||a.push(m),a.join("")},callbacks:function(t){var e=y.val(),n=y.val()!==a;!0===n&&"function"==typeof k.onChange&&k.onChange(e,t,o,k),!0===n&&"function"==typeof k.onKeyPress&&k.onKeyPress(e,t,o,k),"function"==typeof k.onComplete&&e.length===d.length&&k.onComplete(e,t,o,k)}};p.remove=function(){y.destroyEvents(),y.val(p.getCleanVal()).removeAttr("maxlength")},p.getCleanVal=function(){return y.getMasked(!0)},p.init()};r.fn.mask=function(t,e){return this.each(function(){r(this).data("mask",new n(this,t,e))})},r.fn.unmask=function(){return this.each(function(){try{r(this).data("mask").remove()}catch(t){}})},r.fn.cleanVal=function(){return r(this).data("mask").getCleanVal()},r("*[data-mask]").each(function(){var t=r(this),e={};"true"===t.attr("data-mask-reverse")&&(e.reverse=!0),"false"===t.attr("data-mask-maxlength")&&(e.maxlength=!1),t.mask(t.attr("data-mask"),e)})}(window.jQuery||window.Zepto);