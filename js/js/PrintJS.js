function print() {
    printJS({
        printable: 'printElement',
        type: 'html',
        targetStyles: ['*']
    })

}

function PrintButtonLogs() {

    //Gets Values on inputs


    $('#confirmationPrintform').modal('show');


}

function assessment_form_log(ref, sy, sm) {
    //alert();
    arrayData = {
        sy: $("#sy").val(),
        sm: $("#sm").val(),
        sn: $("#sn").val(),
        ref: $("#rf").val(),
        addressUrl: $("#addressUrl").attr('action'),
    };
    url = $('#addressUrl').val();
    ajax = $.ajax({
        url: url + 'index.php/Registrar/print_logs',
        type: 'GET',
        data: {
            ref: arrayData.ref,
            sy: arrayData.sy,
            sm: arrayData.sm,
            sn: arrayData.sn
        },
        success: function(response) {
            $('#confirmationPrintform').modal('hide');
            console.log('Printing Logged!');
            return;
        },
        fail: function() {
            console.log('Error: request failed');
            return;
        }
    });
}

document.getElementById('printButton').addEventListener("click", print)

// Print.js
! function(e, t) {
    "object" == typeof exports && "object" == typeof module ? module.exports = t() : "function" == typeof define && define.amd ? define("print-js", [], t) : "object" == typeof exports ? exports["print-js"] = t() : e["print-js"] = t()
}(this, function() {
    return function(e) {
        function t(i) {
            if (n[i]) return n[i].exports;
            var o = n[i] = {
                i: i,
                l: !1,
                exports: {}
            };
            return e[i].call(o.exports, o, o.exports, t), o.l = !0, o.exports
        }
        var n = {};
        return t.m = e, t.c = n, t.i = function(e) {
            return e
        }, t.d = function(e, n, i) {
            t.o(e, n) || Object.defineProperty(e, n, {
                configurable: !1,
                enumerable: !0,
                get: i
            })
        }, t.n = function(e) {
            var n = e && e.__esModule ? function() {
                return e.default
            } : function() {
                return e
            };
            return t.d(n, "a", n), n
        }, t.o = function(e, t) {
            return Object.prototype.hasOwnProperty.call(e, t)
        }, t.p = "./", t(t.s = 10)
    }([function(e, t, n) {
        "use strict";

        function i(e, t) {
            if (e.focus(), r.a.isEdge() || r.a.isIE()) try {
                e.contentWindow.document.execCommand("print", !1, null)

            } catch (t) {
                e.contentWindow.print()
            }
            r.a.isIE() || r.a.isEdge() || e.contentWindow.print(), r.a.isIE() && "pdf" === t.type && setTimeout(function() {
                e.parentNode.removeChild(e)
            }, 2e3), t.showModal && a.a.close(), t.onLoadingEnd && t.onLoadingEnd()
        }

        function o(e, t, n) {
            void 0 === e.naturalWidth || 0 === e.naturalWidth ? setTimeout(function() {
                o(e, t, n)
            }, 500) : i(t, n)
        }
        var r = n(1),
            a = n(3),
            d = {
                send: function(e, t) {
                    document.getElementsByTagName("body")[0].appendChild(t);
                    var n = document.getElementById(e.frameId);
                    "pdf" === e.type && (r.a.isIE() || r.a.isEdge()) ? n.setAttribute("onload", i(n, e)) : t.onload = function() {
                        if ("pdf" === e.type) i(n, e);
                        else {
                            var t = n.contentWindow || n.contentDocument;
                            t.document && (t = t.document), t.body.innerHTML = e.htmlData, "image" === e.type ? o(t.getElementById("printableImage"), n, e) : i(n, e)
                        }
                    }
                }
            };
        t.a = d
    }, function(e, t, n) {
        "use strict";
        var i = {
            isFirefox: function() {
                return "undefined" != typeof InstallTrigger
            },
            isIE: function() {
                return -1 !== navigator.userAgent.indexOf("MSIE") || !!document.documentMode
            },
            isEdge: function() {
                return !i.isIE() && !!window.StyleMedia
            },
            isChrome: function() {
                return !!window.chrome && !!window.chrome.webstore
            },
            isSafari: function() {
                return Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor") > 0 || -1 !== navigator.userAgent.toLowerCase().indexOf("safari")
            }
        };
        t.a = i
    }, function(e, t, n) {
        "use strict";

        function i(e, t) {
            return '<div style="font-family:' + t.font + " !important; font-size: " + t.font_size + ' !important; width:100%;">' + e + "</div>"
        }

        function o(e) {
            return e.charAt(0).toUpperCase() + e.slice(1)
        }

        function r(e, t) {
            var n = document.defaultView || window,
                i = [],
                o = "";
            if (n.getComputedStyle) {
                i = n.getComputedStyle(e, "");
                var r = t.targetStyles || ["border", "box", "break", "text-decoration"],
                    a = t.targetStyle || ["clear", "display", "width", "min-width", "height", "min-height", "max-height"];
                t.honorMarginPadding && r.push("margin", "padding"), t.honorColor && r.push("color");
                for (var d = 0; d < i.length; d++)
                    for (var l = 0; l < r.length; l++) "*" !== r[l] && -1 === i[d].indexOf(r[l]) && -1 === a.indexOf(i[d]) || (o += i[d] + ":" + i.getPropertyValue(i[d]) + ";")
            } else if (e.currentStyle) {
                i = e.currentStyle;
                for (var s in i) - 1 !== i.indexOf("border") && -1 !== i.indexOf("color") && (o += s + ":" + i[s] + ";")
            }
            return o += "max-width: " + t.maxWidth + "px !important;" + t.font_size + " !important;"
        }

        function a(e, t) {
            for (var n = 0; n < e.length; n++) {
                var i = e[n],
                    o = i.tagName;
                if ("INPUT" === o || "TEXTAREA" === o || "SELECT" === o) {
                    var d = r(i, t),
                        l = i.parentNode,
                        s = "SELECT" === o ? document.createTextNode(i.options[i.selectedIndex].text) : document.createTextNode(i.value),
                        c = document.createElement("div");
                    c.appendChild(s), c.setAttribute("style", d), l.appendChild(c), l.removeChild(i)
                } else i.setAttribute("style", r(i, t));
                var p = i.children;
                p && p.length && a(p, t)
            }
        }

        function d(e, t, n) {
            var i = document.createElement("h1"),
                o = document.createTextNode(t);
            i.appendChild(o), i.setAttribute("style", n), e.insertBefore(i, e.childNodes[0])
        }
        t.a = i, t.b = o, t.c = r, t.d = a, t.e = d
    }, function(e, t, n) {
        "use strict";
        var i = {
            show: function(e) {
                var t = document.createElement("div");
                t.setAttribute("style", "font-family:sans-serif; display:table; text-align:center; font-weight:300; font-size:30px; left:0; top:0;position:fixed; z-index: 9990;color: #0460B5; width: 100%; height: 100%; background-color:rgba(255,255,255,.9);transition: opacity .3s ease;"), t.setAttribute("id", "printJS-Modal");
                var n = document.createElement("div");
                n.setAttribute("style", "display:table-cell; vertical-align:middle; padding-bottom:100px;");
                var o = document.createElement("div");
                o.setAttribute("class", "printClose"), o.setAttribute("id", "printClose"), n.appendChild(o);
                var r = document.createElement("span");
                r.setAttribute("class", "printSpinner"), n.appendChild(r);
                var a = document.createTextNode(e.modalMessage);
                n.appendChild(a), t.appendChild(n), document.getElementsByTagName("body")[0].appendChild(t), document.getElementById("printClose").addEventListener("click", function() {
                    i.close()
                })
            },
            close: function() {
                var e = document.getElementById("printJS-Modal");
                e.parentNode.removeChild(e)
            }
        };
        t.a = i
    }, function(e, t, n) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var i = n(7),
            o = i.a.init;
        "undefined" != typeof window && (window.printJS = o), t.default = o
    }, function(e, t, n) {
        "use strict";
        var i = n(2),
            o = n(0);
        t.a = {
            print: function(e, t) {
                var r = document.getElementById(e.printable);
                if (!r) return window.console.error("Invalid HTML element id: " + e.printable), !1;
                var a = document.createElement("div");
                a.appendChild(r.cloneNode(!0)), a.setAttribute("style", "display:none;"), a.setAttribute("id", "printJS-html"), r.parentNode.appendChild(a), a = document.getElementById("printJS-html"), a.setAttribute("style", n.i(i.c)(a, e) + "margin:0 !important;");
                var d = a.children;
                n.i(i.d)(d, e), e.header && n.i(i.e)(a, e.header, e.headerStyle), a.parentNode.removeChild(a), e.htmlData = n.i(i.a)(a.innerHTML, e), o.a.send(e, t)
            }
        }
    }, function(e, t, n) {
        "use strict";
        var i = n(2),
            o = n(0);
        t.a = {
            print: function(e, t) {
                var r = document.createElement("img");
                r.src = e.printable, r.onload = function() {
                    r.setAttribute("style", "width:100%;"), r.setAttribute("id", "printableImage");
                    var a = document.createElement("div");
                    a.setAttribute("style", "width:100%"), a.appendChild(r), e.header && n.i(i.e)(a, e.header, e.headerStyle), e.htmlData = a.outerHTML, o.a.send(e, t)
                }
            }
        }
    }, function(e, t, n) {
        "use strict";
        var i = n(1),
            o = n(3),
            r = n(9),
            a = n(5),
            d = n(6),
            l = n(8),
            s = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
                return typeof e
            } : function(e) {
                return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
            },
            c = ["pdf", "html", "image", "json"];
        t.a = {
            init: function() {
                var e = {
                        printable: null,
                        fallbackPrintable: null,
                        type: "pdf",
                        header: null,
                        headerStyle: "font-weight: 300;",
                        maxWidth: 800,
                        font: "TimesNewRoman",
                        font_size: "12pt",
                        honorMarginPadding: !0,
                        honorColor: !1,
                        properties: null,
                        gridHeaderStyle: "font-weight: bold;",
                        gridStyle: "border: 1px solid lightgray; margin-bottom: -1px;",
                        showModal: !1,
                        onLoadingStart: null,
                        onLoadingEnd: null,
                        modalMessage: "Retrieving Document...",
                        frameId: "printJS",
                        htmlData: "",
                        documentTitle: "Document",
                        targetStyle: null,
                        targetStyles: null
                    },
                    t = arguments[0];
                if (void 0 === t) throw new Error("printJS expects at least 1 attribute.");
                switch (void 0 === t ? "undefined" : s(t)) {
                    case "string":
                        e.printable = encodeURI(t), e.fallbackPrintable = e.printable, e.type = arguments[1] || e.type;
                        break;
                    case "object":
                        e.printable = t.printable, e.fallbackPrintable = void 0 !== t.fallbackPrintable ? t.fallbackPrintable : e.printable, e.type = void 0 !== t.type ? t.type : e.type, e.frameId = void 0 !== t.frameId ? t.frameId : e.frameId, e.header = void 0 !== t.header ? t.header : e.header, e.headerStyle = void 0 !== t.headerStyle ? t.headerStyle : e.headerStyle, e.maxWidth = void 0 !== t.maxWidth ? t.maxWidth : e.maxWidth, e.font = void 0 !== t.font ? t.font : e.font, e.font_size = void 0 !== t.font_size ? t.font_size : e.font_size, e.honorMarginPadding = void 0 !== t.honorMarginPadding ? t.honorMarginPadding : e.honorMarginPadding, e.properties = void 0 !== t.properties ? t.properties : e.properties, e.gridHeaderStyle = void 0 !== t.gridHeaderStyle ? t.gridHeaderStyle : e.gridHeaderStyle, e.gridStyle = void 0 !== t.gridStyle ? t.gridStyle : e.gridStyle, e.showModal = void 0 !== t.showModal ? t.showModal : e.showModal, e.onLoadingStart = void 0 !== t.onLoadingStart ? t.onLoadingStart : e.onLoadingStart, e.onLoadingEnd = void 0 !== t.onLoadingEnd ? t.onLoadingEnd : e.onLoadingEnd, e.modalMessage = void 0 !== t.modalMessage ? t.modalMessage : e.modalMessage, e.documentTitle = void 0 !== t.documentTitle ? t.documentTitle : e.documentTitle, e.targetStyle = void 0 !== t.targetStyle ? t.targetStyle : e.targetStyle, e.targetStyles = void 0 !== t.targetStyles ? t.targetStyles : e.targetStyles;
                        break;
                    default:
                        throw new Error('Unexpected argument type! Expected "string" or "object", got ' + (void 0 === t ? "undefined" : s(t)))
                }
                if (!e.printable) throw new Error("Missing printable information.");
                if (!e.type || "string" != typeof e.type || -1 === c.indexOf(e.type.toLowerCase())) throw new Error("Invalid print type. Available types are: pdf, html, image and json.");
                e.showModal && o.a.show(e), e.onLoadingStart && e.onLoadingStart();
                var n = document.getElementById(e.frameId);
                n && n.parentNode.removeChild(n);
                var p = void 0;
                switch (p = document.createElement("iframe"), p.setAttribute("style", "display:none;"), p.setAttribute("id", e.frameId), "pdf" !== e.type && (p.srcdoc = "<html><head><link rel='stylesheet' href='.css/print.css' media='screen' /><title>" + e.documentTitle + "</title></head><body></body></html>"), e.type) {
                    case "pdf":
                        if (i.a.isFirefox() || i.a.isEdge() || i.a.isIE()) {
                            window.open(e.fallbackPrintable, "_blank").focus(), e.showModal && o.a.close(), e.onLoadingEnd && e.onLoadingEnd()
                        } else r.a.print(e, p);
                        break;
                    case "image":
                        d.a.print(e, p);
                        break;
                    case "html":
                        a.a.print(e, p);
                        break;
                    case "json":
                        l.a.print(e, p);
                        break;
                    default:
                        throw new Error("Invalid print type. Available types are: pdf, html, image and json.")
                }
            }
        }
    }, function(e, t, n) {
        "use strict";

        function i(e) {
            var t = e.printable,
                i = e.properties,
                r = '<div style="display:flex; flex-direction: column;">';
            r += '<div style="flex:1 1 auto; display:flex;">';
            for (var a = 0; a < i.length; a++) r += '<div style="flex:1; padding:5px;' + e.gridHeaderStyle + '">' + n.i(o.b)(i[a]) + "</div>";
            r += "</div>";
            for (var d = 0; d < t.length; d++) {
                r += '<div style="flex:1 1 auto; display:flex;">';
                for (var l = 0; l < i.length; l++) {
                    var s = t[d],
                        c = i[l].split(".");
                    if (c.length > 1)
                        for (var p = 0; p < c.length; p++) s = s[c[p]];
                    else s = s[i[l]];
                    r += '<div style="flex:1; padding:5px;' + e.gridStyle + '">' + s + "</div>"
                }
                r += "</div>"
            }
            return r += "</div>"
        }
        var o = n(2),
            r = n(0),
            a = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
                return typeof e
            } : function(e) {
                return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
            };
        t.a = {
            print: function(e, t) {
                if ("object" !== a(e.printable)) throw new Error("Invalid javascript data object (JSON).");
                if (!e.properties || "object" !== a(e.properties)) throw new Error("Invalid properties array for your JSON data.");
                var d = "";
                e.header && (d += '<h1 style="' + e.headerStyle + '">' + e.header + "</h1>"), d += i(e), e.htmlData = n.i(o.a)(d, e), r.a.send(e, t)
            }
        }
    }, function(e, t, n) {
        "use strict";

        function i(e, t) {
            t.setAttribute("src", e.printable), r.a.send(e, t)
        }
        var o = n(1),
            r = n(0);
        t.a = {
            print: function(e, t) {
                if (e.showModal || e.onLoadingStart || o.a.isIE()) {
                    var n = new window.XMLHttpRequest;
                    n.addEventListener("load", i(e, t)), n.open("GET", window.location.origin + "/" + e.printable, !0), n.send()
                } else i(e, t)
            }
        }
    }, function(e, t, n) {
        e.exports = n(4)
    }])
});
printJS({ printable: 'printJS-form', type: 'html', honorColor: true })