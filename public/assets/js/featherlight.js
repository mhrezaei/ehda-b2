! function (e) {
    "use strict";

    function t(e, n) {
        if (!(this instanceof t)) {
            var r = new t(e, n);
            return r.open(), r
        }
        this.id = t.id++, this.setup(e, n), this.chainCallbacks(t._callbackChain)
    }
    if ("undefined" == typeof e) return void("console" in window && window.console.info("Too much lightness, Featherlight needs jQuery."));
    var n = [],
        r = function (t) {
            return n = e.grep(n, function (e) {
                return e !== t && e.$instance.closest("body").length > 0
            })
        },
        o = function (e, t) {
            var n = {},
                r = new RegExp("^" + t + "([A-Z])(.*)");
            for (var o in e) {
                var i = o.match(r);
                if (i) {
                    var a = (i[1] + i[2].replace(/([A-Z])/g, "-$1")).toLowerCase();
                    n[a] = e[o]
                }
            }
            return n
        },
        i = {
            keyup: "onKeyUp",
            resize: "onResize"
        },
        a = function (n) {
            e.each(t.opened().reverse(), function () {
                return n.isDefaultPrevented() || !1 !== this[i[n.type]](n) ? void 0 : (n.preventDefault(), n.stopPropagation(), !1)
            })
        },
        s = function (n) {
            if (n !== t._globalHandlerInstalled) {
                t._globalHandlerInstalled = n;
                var r = e.map(i, function (e, n) {
                    return n + "." + t.prototype.namespace
                }).join(" ");
                e(window)[n ? "on" : "off"](r, a)
            }
        };
    t.prototype = {
        constructor: t,
        namespace: "featherlight",
        targetAttr: "data-featherlight",
        variant: null,
        resetCss: !1,
        background: null,
        openTrigger: "click",
        closeTrigger: "click",
        filter: null,
        root: "body",
        openSpeed: 250,
        closeSpeed: 250,
        closeOnClick: "background",
        closeOnEsc: !0,
        closeIcon: "&#10005;",
        loading: "",
        persist: !1,
        otherClose: null,
        beforeOpen: e.noop,
        beforeContent: e.noop,
        beforeClose: e.noop,
        afterOpen: e.noop,
        afterContent: e.noop,
        afterClose: e.noop,
        onKeyUp: e.noop,
        onResize: e.noop,
        type: null,
        contentFilters: ["jquery", "image", "html", "ajax", "iframe", "text"],
        setup: function (t, n) {
            "object" != typeof t || t instanceof e != 0 || n || (n = t, t = void 0);
            var r = e.extend(this, n, {
                    target: t
                }),
                o = r.resetCss ? r.namespace + "-reset" : r.namespace,
                i = e(r.background || ['<div class="' + o + "-loading " + o + '">', '<div class="' + o + '-content">', '<span class="' + o + "-close-icon " + r.namespace + '-close">', r.closeIcon, "</span>", '<div class="' + r.namespace + '-inner">' + r.loading + "</div>", "</div>", "</div>"].join("")),
                a = "." + r.namespace + "-close" + (r.otherClose ? "," + r.otherClose : "");
            return r.$instance = i.clone().addClass(r.variant), r.$instance.on(r.closeTrigger + "." + r.namespace, function (t) {
                var n = e(t.target);
                ("background" === r.closeOnClick && n.is("." + r.namespace) || "anywhere" === r.closeOnClick || n.closest(a).length) && (r.close(t), t.preventDefault())
            }), this
        },
        getContent: function () {
            if (this.persist !== !1 && this.$content) return this.$content;
            var t = this,
                n = this.constructor.contentFilters,
                r = function (e) {
                    return t.$currentTarget && t.$currentTarget.attr(e)
                },
                o = r(t.targetAttr),
                i = t.target || o || "",
                a = n[t.type];
            if (!a && i in n && (a = n[i], i = t.target && o), i = i || r("href") || "", !a)
                for (var s in n) t[s] && (a = n[s], i = t[s]);
            if (!a) {
                var c = i;
                if (i = null, e.each(t.contentFilters, function () {
                        return a = n[this], a.test && (i = a.test(c)), !i && a.regex && c.match && c.match(a.regex) && (i = c), !i
                    }), !i) return "console" in window && window.console.error("Featherlight: no content filter found " + (c ? ' for "' + c + '"' : " (no target specified)")), !1
            }
            return a.process.call(t, i)
        },
        setContent: function (t) {
            var n = this;
            return (t.is("iframe") || e("iframe", t).length > 0) && n.$instance.addClass(n.namespace + "-iframe"), n.$instance.removeClass(n.namespace + "-loading"), n.$instance.find("." + n.namespace + "-inner").not(t).slice(1).remove().end().replaceWith(e.contains(n.$instance[0], t[0]) ? "" : t), n.$content = t.addClass(n.namespace + "-inner"), n
        },
        open: function (t) {
            var r = this;
            if (r.$instance.hide().appendTo(r.root), !(t && t.isDefaultPrevented() || r.beforeOpen(t) === !1)) {
                t && t.preventDefault();
                var o = r.getContent();
                if (o) return n.push(r), s(!0), r.$instance.fadeIn(r.openSpeed), r.beforeContent(t), e.when(o).always(function (e) {
                    r.setContent(e), r.afterContent(t)
                }).then(r.$instance.promise()).done(function () {
                    r.afterOpen(t)
                })
            }
            return r.$instance.detach(), e.Deferred().reject().promise()
        },
        close: function (t) {
            var n = this,
                o = e.Deferred();
            return n.beforeClose(t) === !1 ? o.reject() : (0 === r(n).length && s(!1), n.$instance.fadeOut(n.closeSpeed, function () {
                n.$instance.detach(), n.afterClose(t), o.resolve()
            })), o.promise()
        },
        resize: function (e, t) {
            if (e && t) {
                this.$content.css("width", "").css("height", "");
                var n = Math.max(e / (parseInt(this.$content.parent().css("width"), 10) - 1), t / (parseInt(this.$content.parent().css("height"), 10) - 1));
                n > 1 && (n = t / Math.floor(t / n), this.$content.css("width", "" + e / n + "px").css("height", "" + t / n + "px"))
            }
        },
        chainCallbacks: function (t) {
            for (var n in t) this[n] = e.proxy(t[n], this, e.proxy(this[n], this))
        }
    }, e.extend(t, {
        id: 0,
        autoBind: "[data-featherlight]",
        defaults: t.prototype,
        contentFilters: {
            jquery: {
                regex: /^[#.]\w/,
                test: function (t) {
                    return t instanceof e && t
                },
                process: function (t) {
                    return this.persist !== !1 ? e(t) : e(t).clone(!0)
                }
            },
            image: {
                regex: /\.(png|jpg|jpeg|gif|tiff|bmp|svg)(\?\S*)?$/i,
                process: function (t) {
                    var n = this,
                        r = e.Deferred(),
                        o = new Image,
                        i = e('<img src="' + t + '" alt="" class="' + n.namespace + '-image" />');
                    return o.onload = function () {
                        i.naturalWidth = o.width, i.naturalHeight = o.height, r.resolve(i)
                    }, o.onerror = function () {
                        r.reject(i)
                    }, o.src = t, r.promise()
                }
            },
            html: {
                regex: /^\s*<[\w!][^<]*>/,
                process: function (t) {
                    return e(t)
                }
            },
            ajax: {
                regex: /./,
                process: function (t) {
                    var n = e.Deferred(),
                        r = e("<div></div>").load(t, function (e, t) {
                            "error" !== t && n.resolve(r.contents()), n.fail()
                        });
                    return n.promise()
                }
            },
            iframe: {
                process: function (t) {
                    var n = new e.Deferred,
                        r = e("<iframe/>").hide().attr("src", t).css(o(this, "iframe")).on("load", function () {
                            n.resolve(r.show())
                        }).appendTo(this.$instance.find("." + this.namespace + "-content"));
                    return n.promise()
                }
            },
            text: {
                process: function (t) {
                    return e("<div>", {
                        text: t
                    })
                }
            }
        },
        functionAttributes: ["beforeOpen", "afterOpen", "beforeContent", "afterContent", "beforeClose", "afterClose"],
        readElementConfig: function (t, n) {
            var r = this,
                o = new RegExp("^data-" + n + "-(.*)"),
                i = {};
            return t && t.attributes && e.each(t.attributes, function () {
                var t = this.name.match(o);
                if (t) {
                    var n = this.value,
                        a = e.camelCase(t[1]);
                    if (e.inArray(a, r.functionAttributes) >= 0) n = new Function(n);
                    else try {
                        n = e.parseJSON(n)
                    } catch (e) {}
                    i[a] = n
                }
            }), i
        },
        extend: function (t, n) {
            var r = function () {
                this.constructor = t
            };
            return r.prototype = this.prototype, t.prototype = new r, t.__super__ = this.prototype, e.extend(t, this, n), t.defaults = t.prototype, t
        },
        attach: function (t, n, r) {
            var o = this;
            "object" != typeof n || n instanceof e != 0 || r || (r = n, n = void 0), r = e.extend({}, r);
            var i, a = r.namespace || o.defaults.namespace,
                s = e.extend({}, o.defaults, o.readElementConfig(t[0], a), r);
            return t.on(s.openTrigger + "." + s.namespace, s.filter, function (a) {
                var c = e.extend({
                        $source: t,
                        $currentTarget: e(this)
                    }, o.readElementConfig(t[0], s.namespace), o.readElementConfig(this, s.namespace), r),
                    f = i || e(this).data("featherlight-persisted") || new o(n, c);
                "shared" === f.persist ? i = f : f.persist !== !1 && e(this).data("featherlight-persisted", f), c.$currentTarget.blur(), f.open(a)
            }), t
        },
        current: function () {
            var e = this.opened();
            return e[e.length - 1] || null
        },
        opened: function () {
            var t = this;
            return r(), e.grep(n, function (e) {
                return e instanceof t
            })
        },
        close: function (e) {
            var t = this.current();
            return t ? t.close(e) : void 0
        },
        _onReady: function () {
            var t = this;
            t.autoBind && (e(t.autoBind).each(function () {
                t.attach(e(this))
            }), e(document).on("click", t.autoBind, function (n) {
                n.isDefaultPrevented() || "featherlight" === n.namespace || (n.preventDefault(), t.attach(e(n.currentTarget)), e(n.target).trigger("click.featherlight"))
            }))
        },
        _callbackChain: {
            onKeyUp: function (t, n) {
                return 27 === n.keyCode ? (this.closeOnEsc && e.featherlight.close(n), !1) : t(n)
            },
            onResize: function (e, t) {
                return this.resize(this.$content.naturalWidth, this.$content.naturalHeight), e(t)
            },
            afterContent: function (e, t) {
                var n = e(t);
                return this.onResize(t), n
            }
        }
    }), e.featherlight = t, e.fn.featherlight = function (e, n) {
        return t.attach(this, e, n)
    }, e(document).ready(function () {
        t._onReady()
    })
}(jQuery);