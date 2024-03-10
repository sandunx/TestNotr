!function (t, e, s, i) { function o(e, o) { this.w = t(s), this.el = t(e), (o = o || a).rootClass !== i && "dd" !== o.rootClass && (o.listClass = o.listClass ? o.listClass : o.rootClass + "-list", o.itemClass = o.itemClass ? o.itemClass : o.rootClass + "-item", o.dragClass = o.dragClass ? o.dragClass : o.rootClass + "-dragel", o.handleClass = o.handleClass ? o.handleClass : o.rootClass + "-handle", o.collapsedClass = o.collapsedClass ? o.collapsedClass : o.rootClass + "-collapsed", o.placeClass = o.placeClass ? o.placeClass : o.rootClass + "-placeholder", o.noDragClass = o.noDragClass ? o.noDragClass : o.rootClass + "-nodrag", o.noChildrenClass = o.noChildrenClass ? o.noChildrenClass : o.rootClass + "-nochildren", o.emptyClass = o.emptyClass ? o.emptyClass : o.rootClass + "-empty"), this.options = t.extend({}, a, o), this.options.json !== i && this._build(), this.init() } var n = "ontouchstart" in s, l = function () { var t = s.createElement("div"), i = s.documentElement; if (!("pointerEvents" in t.style)) return !1; t.style.pointerEvents = "auto", t.style.pointerEvents = "x", i.appendChild(t); var o = e.getComputedStyle && "auto" === e.getComputedStyle(t, "").pointerEvents; return i.removeChild(t), !!o }(), a = { contentCallback: function (t) { return t.content ? t.content : t.id }, listNodeName: "ol", itemNodeName: "li", handleNodeName: "div", contentNodeName: "span", rootClass: "dd", listClass: "dd-list", itemClass: "dd-item", dragClass: "dd-dragel", handleClass: "dd-handle", contentClass: "dd-content", collapsedClass: "dd-collapsed", placeClass: "dd-placeholder", noDragClass: "dd-nodrag", noChildrenClass: "dd-nochildren", emptyClass: "dd-empty", expandBtnHTML: '<button class="dd-expand" data-action="expand" type="button">Expand</button>', collapseBtnHTML: '<button class="dd-collapse" data-action="collapse" type="button">Collapse</button>', group: 0, maxDepth: 5, threshold: 20, fixedDepth: !1, fixed: !1, includeContent: !1, scroll: !1, scrollSensitivity: 1, scrollSpeed: 5, scrollTriggers: { top: 40, left: 40, right: -40, bottom: -40 }, effect: { animation: "none", time: "slow" }, callback: function (t, e, s) { }, onDragStart: function (t, e, s) { }, beforeDragStop: function (t, e, s) { }, listRenderer: function (t, e) { var s = "<" + e.listNodeName + ' class="' + e.listClass + '">'; return s += t, s += "</" + e.listNodeName + ">" }, itemRenderer: function (e, s, i, o, n) { var l = t.map(e, function (t, e) { return " " + e + '="' + t + '"' }).join(" "), a = "<" + o.itemNodeName + l + ">"; return a += "<" + o.handleNodeName + ' class="' + o.handleClass + '">', a += "<" + o.contentNodeName + ' class="' + o.contentClass + '">', a += s, a += "</" + o.contentNodeName + ">", a += "</" + o.handleNodeName + ">", a += i, a += "</" + o.itemNodeName + ">" } }; o.prototype = { init: function () { var s = this; s.reset(), s.el.data("nestable-group", this.options.group), s.placeEl = t('<div class="' + s.options.placeClass + '"/>'); var i = this.el.find(s.options.itemNodeName); t.each(i, function (e, i) { var o = t(i), n = o.parent(); s.setParent(o), n.hasClass(s.options.collapsedClass) && s.collapseItem(n.parent()) }), i.length || this.appendEmptyElement(this.el), s.el.on("click", "button", function (e) { if (!s.dragEl) { var i = t(e.currentTarget), o = i.data("action"), n = i.parents(s.options.itemNodeName).eq(0); "collapse" === o && s.collapseItem(n), "expand" === o && s.expandItem(n) } }); var o = function (e) { var i = t(e.target); if (!i.hasClass(s.options.handleClass)) { if (i.closest("." + s.options.noDragClass).length) return; i = i.closest("." + s.options.handleClass) } i.length && !s.dragEl && (s.isTouch = /^touch/.test(e.type), s.isTouch && 1 !== e.touches.length || (e.preventDefault(), s.dragStart(e.touches ? e.touches[0] : e))) }, l = function (t) { s.dragEl && (t.preventDefault(), s.dragMove(t.touches ? t.touches[0] : t)) }, a = function (t) { s.dragEl && (t.preventDefault(), s.dragStop(t.touches ? t.changedTouches[0] : t)) }; n && (s.el[0].addEventListener("touchstart", o, !1), e.addEventListener("touchmove", l, !1), e.addEventListener("touchend", a, !1), e.addEventListener("touchcancel", a, !1)), s.el.on("mousedown", o), s.w.on("mousemove", l), s.w.on("mouseup", a); s.el.bind("destroy-nestable", function () { n && (s.el[0].removeEventListener("touchstart", o, !1), e.removeEventListener("touchmove", l, !1), e.removeEventListener("touchend", a, !1), e.removeEventListener("touchcancel", a, !1)), s.el.off("mousedown", o), s.w.off("mousemove", l), s.w.off("mouseup", a), s.el.off("click"), s.el.unbind("destroy-nestable"), s.el.data("nestable", null) }) }, destroy: function () { this.el.trigger("destroy-nestable") }, add: function (e) { var s = "." + this.options.listClass, o = t(this.el).children(s); e.parent_id !== i && (o = o.find('[data-id="' + e.parent_id + '"]'), delete e.parent_id, 0 === o.children(s).length && (o = o.append(this.options.listRenderer("", this.options))), o = o.find(s + ":first"), this.setParent(o.parent())), o.append(this._buildItem(e, this.options)) }, replace: function (t) { var e = this._buildItem(t, this.options); this._getItemById(t.id).replaceWith(e) }, removeItem: function (e) { var s = this.options, i = this.el; (e = e || this).remove(); var o = "." + s.listClass + " ." + s.listClass + ":not(:has(*))"; t(i).find(o).remove(); t(i).find('[data-action="expand"], [data-action="collapse"]').each(function () { 0 === t(this).siblings("." + s.listClass).length && t(this).remove() }) }, remove: function (t, e) { var s = this.options, i = this, o = this._getItemById(t), n = s.effect.animation || "fade", l = s.effect.time || "slow"; "fade" === n ? o.fadeOut(l, function () { i.removeItem(o) }) : this.removeItem(o), e && e() }, removeAll: function (e) { function s() { l.each(function () { i.removeItem(t(this)) }), n.show(), e && e() } var i = this, o = this.options, n = i.el.find(o.listNodeName).first(), l = n.children(o.itemNodeName), a = o.effect.animation || "fade", r = o.effect.time || "slow"; "fade" === a ? n.fadeOut(r, s) : s() }, _getItemById: function (e) { return t(this.el).children("." + this.options.listClass).find('[data-id="' + e + '"]') }, _build: function () { var e = this.options.json; "string" == typeof e && (e = JSON.parse(e)), t(this.el).html(this._buildList(e, this.options)) }, _buildList: function (e, s) { if (!e) return ""; var i = "", o = this; return t.each(e, function (t, e) { i += o._buildItem(e, s) }), s.listRenderer(i, s) }, _buildItem: function (e, s) { function i(t) { var e = { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#039;" }; return t + "".replace(/[&<>"']/g, function (t) { return e[t] }) } function o(t) { var e = {}; for (var s in t) e[t[s]] = t[s]; return e } var n = function (e) { delete (e = t.extend({}, e)).children, delete e.classes, delete e.content; var s = {}; return t.each(e, function (t, e) { "object" == typeof e && (e = JSON.stringify(e)), s["data-" + t] = i(e) }), s }(e); n.class = function (e, s) { var i = e.classes || {}; "string" == typeof i && (i = [i]); var n = o(i); return n[s.itemClass] = s.itemClass, t.map(n, function (t) { return t }).join(" ") }(e, s); var l = s.contentCallback(e), a = this._buildList(e.children, s), r = t(s.itemRenderer(n, l, a, s, e)); return this.setParent(r), r[0].outerHTML }, serialize: function () { var e = this, s = function (i) { var o = []; return i.children(e.options.itemNodeName).each(function () { var i = t(this), n = t.extend({}, i.data()), l = i.children(e.options.listNodeName); if (e.options.includeContent) { var a = i.find("." + e.options.contentClass).html(); a && (n.content = a) } l.length && (n.children = s(l)), o.push(n) }), o }; return s(e.el.find(e.options.listNodeName).first()) }, asNestedSet: function () { function e(i, l, a) { var r, d, h = a + 1; return t(i).children(o.listNodeName).children(o.itemNodeName).length > 0 && (l++ , t(i).children(o.listNodeName).children(o.itemNodeName).each(function () { h = e(t(this), l, h) }), l--), r = t(i).attr("data-id"), s(r) && (r = parseInt(r)), d = t(i).parent(o.listNodeName).parent(o.itemNodeName).attr("data-id") || "", s(d) && (d = parseInt(d)), r && n.push({ id: r, parent_id: d, depth: l, lft: a, rgt: h }), a = h + 1 } function s(e) { return t.isNumeric(e) && Math.floor(e) == e } var i = this, o = i.options, n = [], l = 1; return i.el.find(o.listNodeName).first().children(o.itemNodeName).each(function () { l = e(this, 0, l) }), n = n.sort(function (t, e) { return t.lft - e.lft }) }, returnOptions: function () { return this.options }, serialise: function () { return this.serialize() }, toHierarchy: function (e) { function s(e) { var o = (t(e).attr(i.attribute || "id") || "").match(i.expression || /(.+)[-=_](.+)/); if (o) { var n = { id: o[2] }; return t(e).children(i.listType).children(i.items).length > 0 && (n.children = [], t(e).children(i.listType).children(i.items).each(function () { var t = s(this); n.children.push(t) })), n } } var i = t.extend({}, this.options, e), o = []; return t(this.element).children(i.items).each(function () { var t = s(this); o.push(t) }), o }, toArray: function () { function e(n, l, a) { var r, d, h = a + 1; return n.children(s.options.listNodeName).children(s.options.itemNodeName).length > 0 && (l++ , n.children(s.options.listNodeName).children(s.options.itemNodeName).each(function () { h = e(t(this), l, h) }), l--), r = n.data().id, d = l === i + 1 ? s.rootID : n.parent(s.options.listNodeName).parent(s.options.itemNodeName).data().id, r && o.push({ id: r, parent_id: d, depth: l, left: a, right: h }), a = h + 1 } var s = t.extend({}, this.options, this), i = s.startDepthCount || 0, o = [], n = 2, l = this; return l.el.find(l.options.listNodeName).first().children(l.options.itemNodeName).each(function () { n = e(t(this), i + 1, n) }), o = o.sort(function (t, e) { return t.left - e.left }) }, reset: function () { this.mouse = { offsetX: 0, offsetY: 0, startX: 0, startY: 0, lastX: 0, lastY: 0, nowX: 0, nowY: 0, distX: 0, distY: 0, dirAx: 0, dirX: 0, dirY: 0, lastDirX: 0, lastDirY: 0, distAxX: 0, distAxY: 0 }, this.isTouch = !1, this.moving = !1, this.dragEl = null, this.dragRootEl = null, this.dragDepth = 0, this.hasNewRoot = !1, this.pointEl = null }, expandItem: function (t) { t.removeClass(this.options.collapsedClass) }, collapseItem: function (t) { t.children(this.options.listNodeName).length && t.addClass(this.options.collapsedClass) }, expandAll: function () { var e = this; e.el.find(e.options.itemNodeName).each(function () { e.expandItem(t(this)) }) }, collapseAll: function () { var e = this; e.el.find(e.options.itemNodeName).each(function () { e.collapseItem(t(this)) }) }, setParent: function (e) { e.is(this.options.itemNodeName) && e.children(this.options.listNodeName).length && (e.children("[data-action]").remove(), e.prepend(t(this.options.expandBtnHTML)), e.prepend(t(this.options.collapseBtnHTML))) }, unsetParent: function (t) { t.removeClass(this.options.collapsedClass), t.children("[data-action]").remove(), t.children(this.options.listNodeName).remove() }, dragStart: function (e) { var i = this.mouse, o = t(e.target).closest(this.options.itemNodeName), n = { top: e.pageY, left: e.pageX }, l = this.options.onDragStart.call(this, this.el, o, n); if (void 0 === l || !1 !== l) { this.placeEl.css("height", o.height()), i.offsetX = e.pageX - o.offset().left, i.offsetY = e.pageY - o.offset().top, i.startX = i.lastX = e.pageX, i.startY = i.lastY = e.pageY, this.dragRootEl = this.el, this.dragEl = t(s.createElement(this.options.listNodeName)).addClass(this.options.listClass + " " + this.options.dragClass), this.dragEl.css("width", o.outerWidth()), this.setIndexOfItem(o), o.after(this.placeEl), o[0].parentNode.removeChild(o[0]), o.appendTo(this.dragEl), t(s.body).append(this.dragEl), this.dragEl.css({ left: e.pageX - i.offsetX, top: e.pageY - i.offsetY }); var a, r, d = this.dragEl.find(this.options.itemNodeName); for (a = 0; a < d.length; a++)(r = t(d[a]).parents(this.options.listNodeName).length) > this.dragDepth && (this.dragDepth = r) } }, createSubLevel: function (e, s) { var i = t("<" + this.options.listNodeName + "/>").addClass(this.options.listClass); return s && i.append(s), e.append(i), this.setParent(e), i }, setIndexOfItem: function (e, s) { (s = s || []).unshift(e.index()), t(e[0].parentNode)[0] !== this.dragRootEl[0] ? this.setIndexOfItem(t(e[0].parentNode), s) : this.dragEl.data("indexOfItem", s) }, restoreItemAtIndex: function (e, s) { for (var i = this.el, o = s.length - 1, n = 0; n < s.length; n++) { if (o === parseInt(n)) return void function (e, i) { 0 === s[o] ? t(e).prepend(i.clone(!0)) : t(e.children[s[o] - 1]).after(i.clone(!0)) }(i, e); var l = i[0] ? i[0] : i, a = l.children[s[n]]; i = a || this.createSubLevel(t(l)) } }, dragStop: function (t) { var e = { top: t.pageY, left: t.pageX }, s = this.dragEl.data("indexOfItem"), i = this.dragEl.children(this.options.itemNodeName).first(); i[0].parentNode.removeChild(i[0]), this.dragEl.remove(); var o = this.options.beforeDragStop.call(this, this.el, i, this.placeEl.parent()); if (void 0 !== o && !1 === o) { var n = this.placeEl.parent(); return this.placeEl.remove(), n.children().length || this.unsetParent(n.parent()), this.restoreItemAtIndex(i, s), void this.reset() } this.placeEl.replaceWith(i), this.hasNewRoot ? (!0 === this.options.fixed ? this.restoreItemAtIndex(i, s) : this.el.trigger("lostItem"), this.dragRootEl.trigger("gainedItem")) : this.dragRootEl.trigger("change"), this.options.callback.call(this, this.dragRootEl, i, e), this.reset() }, dragMove: function (i) { var o, n, a, r = this.options, d = this.mouse; this.dragEl.css({ left: i.pageX - d.offsetX, top: i.pageY - d.offsetY }), d.lastX = d.nowX, d.lastY = d.nowY, d.nowX = i.pageX, d.nowY = i.pageY, d.distX = d.nowX - d.lastX, d.distY = d.nowY - d.lastY, d.lastDirX = d.dirX, d.lastDirY = d.dirY, d.dirX = 0 === d.distX ? 0 : d.distX > 0 ? 1 : -1, d.dirY = 0 === d.distY ? 0 : d.distY > 0 ? 1 : -1; var h = Math.abs(d.distX) > Math.abs(d.distY) ? 1 : 0; if (!d.moving) return d.dirAx = h, void (d.moving = !0); if (r.scroll) if (void 0 !== e.jQuery.fn.scrollParent) { var c = !1, p = this.el.scrollParent()[0]; p !== s && "HTML" !== p.tagName ? (r.scrollTriggers.bottom + p.offsetHeight - i.pageY < r.scrollSensitivity ? p.scrollTop = c = p.scrollTop + r.scrollSpeed : i.pageY - r.scrollTriggers.top < r.scrollSensitivity && (p.scrollTop = c = p.scrollTop - r.scrollSpeed), r.scrollTriggers.right + p.offsetWidth - i.pageX < r.scrollSensitivity ? p.scrollLeft = c = p.scrollLeft + r.scrollSpeed : i.pageX - r.scrollTriggers.left < r.scrollSensitivity && (p.scrollLeft = c = p.scrollLeft - r.scrollSpeed)) : (i.pageY - t(s).scrollTop() < r.scrollSensitivity ? c = t(s).scrollTop(t(s).scrollTop() - r.scrollSpeed) : t(e).height() - (i.pageY - t(s).scrollTop()) < r.scrollSensitivity && (c = t(s).scrollTop(t(s).scrollTop() + r.scrollSpeed)), i.pageX - t(s).scrollLeft() < r.scrollSensitivity ? c = t(s).scrollLeft(t(s).scrollLeft() - r.scrollSpeed) : t(e).width() - (i.pageX - t(s).scrollLeft()) < r.scrollSensitivity && (c = t(s).scrollLeft(t(s).scrollLeft() + r.scrollSpeed))) } else console.warn("To use scrolling you need to have scrollParent() function, check documentation for more information"); this.scrollTimer && clearTimeout(this.scrollTimer), r.scroll && c && (this.scrollTimer = setTimeout(function () { t(e).trigger(i) }, 10)), d.dirAx !== h ? (d.distAxX = 0, d.distAxY = 0) : (d.distAxX += Math.abs(d.distX), 0 !== d.dirX && d.dirX !== d.lastDirX && (d.distAxX = 0), d.distAxY += Math.abs(d.distY), 0 !== d.dirY && d.dirY !== d.lastDirY && (d.distAxY = 0)), d.dirAx = h, d.dirAx && d.distAxX >= r.threshold && (d.distAxX = 0, a = this.placeEl.prev(r.itemNodeName), d.distX > 0 && a.length && !a.hasClass(r.collapsedClass) && !a.hasClass(r.noChildrenClass) && (o = a.find(r.listNodeName).last(), this.placeEl.parents(r.listNodeName).length + this.dragDepth <= r.maxDepth && (o.length ? (o = a.children(r.listNodeName).last()).append(this.placeEl) : this.createSubLevel(a, this.placeEl))), d.distX < 0 && (this.placeEl.next(r.itemNodeName).length || (n = this.placeEl.parent(), this.placeEl.closest(r.itemNodeName).after(this.placeEl), n.children().length || this.unsetParent(n.parent())))); var f = !1; if (l || (this.dragEl[0].style.visibility = "hidden"), this.pointEl = t(s.elementFromPoint(i.pageX - s.body.scrollLeft, i.pageY - (e.pageYOffset || s.documentElement.scrollTop))), l || (this.dragEl[0].style.visibility = "visible"), this.pointEl.hasClass(r.handleClass) && (this.pointEl = this.pointEl.closest(r.itemNodeName)), this.pointEl.hasClass(r.emptyClass)) f = !0; else if (!this.pointEl.length || !this.pointEl.hasClass(r.itemClass)) return; var u = this.pointEl.closest("." + r.rootClass), m = this.dragRootEl.data("nestable-id") !== u.data("nestable-id"); if (!d.dirAx || m || f) { if (m && r.group !== u.data("nestable-group")) return; if (this.options.fixedDepth && this.dragDepth + 1 !== this.pointEl.parents(r.listNodeName).length) return; if (this.dragDepth - 1 + this.pointEl.parents(r.listNodeName).length > r.maxDepth) return; var g = i.pageY < this.pointEl.offset().top + this.pointEl.height() / 2; n = this.placeEl.parent(), f ? ((o = t(s.createElement(r.listNodeName)).addClass(r.listClass)).append(this.placeEl), this.pointEl.replaceWith(o)) : g ? this.pointEl.before(this.placeEl) : this.pointEl.after(this.placeEl), n.children().length || this.unsetParent(n.parent()), this.dragRootEl.find(r.itemNodeName).length || this.appendEmptyElement(this.dragRootEl), this.dragRootEl = u, m && (this.hasNewRoot = this.el[0] !== this.dragRootEl[0]) } }, appendEmptyElement: function (t) { t.append('<div class="' + this.options.emptyClass + '"/>') } }, t.fn.nestable = function (s) { var i = this, n = this, l = arguments; return "Nestable" in e || (e.Nestable = {}, Nestable.counter = 0), i.each(function () { var e = t(this).data("nestable"); if (e) { if ("string" == typeof s && "function" == typeof e[s]) if (l.length > 1) { for (var i = [], a = 1; a < l.length; a++)i.push(l[a]); n = e[s].apply(e, i) } else n = e[s]() } else Nestable.counter++ , t(this).data("nestable", new o(this, s)), t(this).data("nestable-id", Nestable.counter) }), n || i } }(window.jQuery || window.Zepto, window, document);