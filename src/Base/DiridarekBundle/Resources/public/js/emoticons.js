/*
 * jQuery CSSEmoticons plugin 0.2.9
 *
 * Copyright (c) 2010 Steve Schwartz (JangoSteve)
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Date: Sun Oct 22 1:00:00 2010 -0500
 */
(function(a) {
    a.fn.emoticonize = function(m) {
        var c = a.extend({}, a.fn.emoticonize.defaults, m);
        var d = [")", "(", "*", "[", "]", "{", "}", "|", "^", "<", ">", "\\", "?", "+", "=", "."];
        var l = [":-)", ":o)", ":c)", ":^)", ":-D", ":-(", ":-9", ";-)", ":-P", ":-p", ":-Þ", ":-b", ":-O", ":-/", ":-X", ":-#", ":'(", "B-)", "8-)", ";*(", ":-*", ":-\\", "?-)", ": )", ": ]", "= ]", "= )", "8 )", ": }", ": D", "8 D", "X D", "x D", "= D", ": (", ": [", ": {", "= (", "; )", "; ]", "; D", ": P", ": p", "= P", "= p", ": b", ": Þ", ": O", "8 O", ": /", "= /", ": S", ": #", ": X", "B )", ": |", ": \\", "= \\", ": *", ": &gt;", ": &lt;"];
        var j = [":)", ":]", "=]", "=)", "8)", ":}", ":D", ":(", ":[", ":{", "=(", ";)", ";]", ";D", ":P", ":p", "=P", "=p", ":b", ":Þ", ":O", ":/", "=/", ":S", ":#", ":X", "B)", ":|", ":\\", "=\\", ":*", ":&gt;", ":&lt;"];
        var h = {
            "&gt;:)": {
                cssClass: "red-emoticon small-emoticon spaced-emoticon"
            },
            "&gt;;)": {
                cssClass: "red-emoticon small-emoticon spaced-emoticon"
            },
            "&gt;:(": {
                cssClass: "red-emoticon small-emoticon spaced-emoticon"
            },
            "&gt;: )": {
                cssClass: "red-emoticon small-emoticon"
            },
            "&gt;; )": {
                cssClass: "red-emoticon small-emoticon"
            },
            "&gt;: (": {
                cssClass: "red-emoticon small-emoticon"
            },
            ";(": {
                cssClass: "red-emoticon spaced-emoticon"
            },
            "&lt;3": {
                cssClass: "pink-emoticon counter-rotated"
            },
            O_O: {
                cssClass: "no-rotate"
            },
            o_o: {
                cssClass: "no-rotate"
            },
            "0_o": {
                cssClass: "no-rotate"
            },
            O_o: {
                cssClass: "no-rotate"
            },
            T_T: {
                cssClass: "no-rotate"
            },
            "^_^": {
                cssClass: "no-rotate"
            },
            "O:)": {
                cssClass: "small-emoticon spaced-emoticon"
            },
            "O: )": {
                cssClass: "small-emoticon"
            },
            "8D": {
                cssClass: "small-emoticon spaced-emoticon"
            },
            XD: {
                cssClass: "small-emoticon spaced-emoticon"
            },
            xD: {
                cssClass: "small-emoticon spaced-emoticon"
            },
            "=D": {
                cssClass: "small-emoticon spaced-emoticon"
            },
            "8O": {
                cssClass: "small-emoticon spaced-emoticon"
            },
            "[+=..]": {
                cssClass: "no-rotate nintendo-controller"
            }
        };
        var f = new RegExp("(\\" + d.join("|\\") + ")", "g");
        var n = "(^|[\\s\\0])";
        for (var g = l.length-1; g >= 0; --g) {
            l[g] = l[g].replace(f, "\\$1");
            l[g] = new RegExp(n + "(" + l[g] + ")", "g")
        }
        for (var g = j.length-1; g >= 0; --g) {
            j[g] = j[g].replace(f, "\\$1");
            j[g] = new RegExp(n + "(" + j[g] + ")", "g")
        }
        for (var k in h) {
            h[k].regexp = k.replace(f, "\\$1");
            h[k].regexp = new RegExp(n + "(" + h[k].regexp + ")", "g")
        }
        var e = "span.css-emoticon";
        if (c.exclude) {
            e += "," + c.exclude
        }
        var b = e.split(",");
        return this.not(e).each(function() {
            var o = a(this);
            var i = "css-emoticon";
            if (c.animate) {
                i += " un-transformed-emoticon animated-emoticon"
            }
            for (var p in h) {
                specialCssClass = i + " " + h[p].cssClass;
                o.html(o.html().replace(h[p].regexp, "$1<span class='" + specialCssClass + "'>$2</span>"))
            }
            a(l).each(function() {
                o.html(o.html().replace(this, "$1<span class='" + i + "'>$2</span>"))
            });
            a(j).each(function() {
                o.html(o.html().replace(this, "$1<span class='" + i + " spaced-emoticon'>$2</span>"))
            });
            a.each(b, function(q, r) {
                o.find(a.trim(r) + " span.css-emoticon").each(function() {
                    a(this).replaceWith(a(this).text())
                })
            });
            if (c.animate) {
                setTimeout(function() {
                    a(".un-transformed-emoticon").removeClass("un-transformed-emoticon")
                }, c.delay)
            }
        })
    };
    a.fn.unemoticonize = function(b) {
        var c = a.extend({}, a.fn.emoticonize.defaults, b);
        return this.each(function() {
            var d = a(this);
            d.find("span.css-emoticon").each(function() {
                var e = a(this);
                if (c.animate) {
                    e.addClass("un-transformed-emoticon");
                    setTimeout(function() {
                        e.replaceWith(e.text())
                    }, c.delay)
                } else {
                    e.replaceWith(e.text())
                }
            })
        })
    };
    a.fn.emoticonize.defaults = {
        animate: true,
        delay: 500,
        exclude: "pre,code,.no-emoticons"
    }
})(jQuery);