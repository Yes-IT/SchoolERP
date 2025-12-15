<html lang="en" class="sf-js-enabled"><head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1.0, user-scalable=0">
    <title>School Management System | Dashboard</title>

    <!-- fabicon -->
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/brands.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/regular.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/solid.min.css">

    <!-- slick slider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">

    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

    <link rel="stylesheet" href="https://saserp.tgastaging.com/student/css/style.css">
    <meta name="csrf-token" content="NHn738kSkVp4duFVd2zQ7BHpv5g6HPluJUZC2ls1">




    <!-- <style>
        label.error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }
    </style> -->

    <style>
        label.error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }

        .search-suggestions-list {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #ddd;
            border-top: none;
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            border-radius: 0 0 5px 5px;
        }

        .search-suggestions-list ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .search-suggestions-list ul li a {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
        }

        .search-suggestions-list ul li a:hover {
            background-color: #f5f5f5;
        }
        .cmn-popwrp .modal-body {
           background: var(--white);
    border-radius: 8px;
    padding: 15px 0;
    border: 1px solid var(--primary-clr);
    width: 565px;
    margin-left: 153px;
    height: 500px;
}

.cmn-pop-head p{
       max-width: 450px;
    position: relative;
    left: 62px;
    top: -17px;
    color: grey;
}
select{
width: 332px;
    height: 40px;
    position: relative;
    left: 33px;
    top: -52px;
background-color: var(--primary-clr);
color: white;

}
option{
font-size: 15px;
    background-color: white;
    color: black;


}
option:hover{
background-color: var(--primary-clr);
color: white;
}
.select-wrapper {
       background: grey;
    padding: 77px;
    border-radius: 21px;
    margin-top: -40px;
    width: 498px;
    margin-left: 27px;
    height: 277px;

}
.custom-select {
  width: 100%;
    cursor: pointer;
    position: relative;
    top: -66px;
}

.custom-select .selected {
       padding: 10px;
    background: var(--primary-clr);
    /* border: 1px solid #ccc; */
    border-radius: 11px;
    color: white;
}

.custom-select .options {
    list-style: none;
    padding: 0;
    margin: 0;
    display: none;
    position: absolute;
    width: 100%;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 6px;
    max-height: 200px;
    overflow-y: auto;
    z-index: 10;
}

.custom-select .options li {
     padding: 5px;
    transition: 0.2s;
    font-size: 16px;
}

/* 🔥 Hover Effect */
.custom-select .options li:hover {
    background: grey;
    color: var(--primary-clr);
}


    </style>
<link rel="stylesheet" type="text/css" property="stylesheet" href="/_debugbar/assets/stylesheets?v=1764061800" data-turbolinks-eval="false" data-turbo-eval="false"><script src="/_debugbar/assets/javascript?v=1764061800" data-turbolinks-eval="false" data-turbo-eval="false"></script><script data-turbo-eval="false">jQuery.noConflict(true);</script>
<script> Sfdump = window.Sfdump || (function (doc) { doc.documentElement.classList.add('sf-js-enabled'); var rxEsc = /([.*+?^${}()|\[\]\/\\])/g, idRx = /\bsf-dump-\d+-ref[012]\w+\b/, keyHint = 0 <= navigator.platform.toUpperCase().indexOf('MAC') ? 'Cmd' : 'Ctrl', addEventListener = function (e, n, cb) { e.addEventListener(n, cb, false); }; if (!doc.addEventListener) { addEventListener = function (element, eventName, callback) { element.attachEvent('on' + eventName, function (e) { e.preventDefault = function () {e.returnValue = false;}; e.target = e.srcElement; callback(e); }); }; } function toggle(a, recursive) { var s = a.nextSibling || {}, oldClass = s.className, arrow, newClass; if (/\bsf-dump-compact\b/.test(oldClass)) { arrow = '▼'; newClass = 'sf-dump-expanded'; } else if (/\bsf-dump-expanded\b/.test(oldClass)) { arrow = '▶'; newClass = 'sf-dump-compact'; } else { return false; } if (doc.createEvent && s.dispatchEvent) { var event = doc.createEvent('Event'); event.initEvent('sf-dump-expanded' === newClass ? 'sfbeforedumpexpand' : 'sfbeforedumpcollapse', true, false); s.dispatchEvent(event); } a.lastChild.innerHTML = arrow; s.className = s.className.replace(/\bsf-dump-(compact|expanded)\b/, newClass); if (recursive) { try { a = s.querySelectorAll('.'+oldClass); for (s = 0; s < a.length; ++s) { if (-1 == a[s].className.indexOf(newClass)) { a[s].className = newClass; a[s].previousSibling.lastChild.innerHTML = arrow; } } } catch (e) { } } return true; }; function collapse(a, recursive) { var s = a.nextSibling || {}, oldClass = s.className; if (/\bsf-dump-expanded\b/.test(oldClass)) { toggle(a, recursive); return true; } return false; }; function expand(a, recursive) { var s = a.nextSibling || {}, oldClass = s.className; if (/\bsf-dump-compact\b/.test(oldClass)) { toggle(a, recursive); return true; } return false; }; function collapseAll(root) { var a = root.querySelector('a.sf-dump-toggle'); if (a) { collapse(a, true); expand(a); return true; } return false; } function reveal(node) { var previous, parents = []; while ((node = node.parentNode || {}) && (previous = node.previousSibling) && 'A' === previous.tagName) { parents.push(previous); } if (0 !== parents.length) { parents.forEach(function (parent) { expand(parent); }); return true; } return false; } function highlight(root, activeNode, nodes) { resetHighlightedNodes(root); Array.from(nodes||[]).forEach(function (node) { if (!/\bsf-dump-highlight\b/.test(node.className)) { node.className = node.className + ' sf-dump-highlight'; } }); if (!/\bsf-dump-highlight-active\b/.test(activeNode.className)) { activeNode.className = activeNode.className + ' sf-dump-highlight-active'; } } function resetHighlightedNodes(root) { Array.from(root.querySelectorAll('.sf-dump-str, .sf-dump-key, .sf-dump-public, .sf-dump-protected, .sf-dump-private')).forEach(function (strNode) { strNode.className = strNode.className.replace(/\bsf-dump-highlight\b/, ''); strNode.className = strNode.className.replace(/\bsf-dump-highlight-active\b/, ''); }); } return function (root, x) { root = doc.getElementById(root); var indentRx = new RegExp('^('+(root.getAttribute('data-indent-pad') || ' ').replace(rxEsc, '\\$1')+')+', 'm'), options = {"maxDepth":1,"maxStringLength":160,"fileLinkFormat":false}, elt = root.getElementsByTagName('A'), len = elt.length, i = 0, s, h, t = []; while (i < len) t.push(elt[i++]); for (i in x) { options[i] = x[i]; } function a(e, f) { addEventListener(root, e, function (e, n) { if ('A' == e.target.tagName) { f(e.target, e); } else if ('A' == e.target.parentNode.tagName) { f(e.target.parentNode, e); } else { n = /\bsf-dump-ellipsis\b/.test(e.target.className) ? e.target.parentNode : e.target; if ((n = n.nextElementSibling) && 'A' == n.tagName) { if (!/\bsf-dump-toggle\b/.test(n.className)) { n = n.nextElementSibling || n; } f(n, e, true); } } }); }; function isCtrlKey(e) { return e.ctrlKey || e.metaKey; } function xpathString(str) { var parts = str.match(/[^'"]+|['"]/g).map(function (part) { if ("'" == part) { return '"\'"'; } if ('"' == part) { return "'\"'"; } return "'" + part + "'"; }); return "concat(" + parts.join(",") + ", '')"; } function xpathHasClass(className) { return "contains(concat(' ', normalize-space(@class), ' '), ' " + className +" ')"; } a('mouseover', function (a, e, c) { if (c) { e.target.style.cursor = "pointer"; } }); a('click', function (a, e, c) { if (/\bsf-dump-toggle\b/.test(a.className)) { e.preventDefault(); if (!toggle(a, isCtrlKey(e))) { var r = doc.getElementById(a.getAttribute('href').slice(1)), s = r.previousSibling, f = r.parentNode, t = a.parentNode; t.replaceChild(r, a); f.replaceChild(a, s); t.insertBefore(s, r); f = f.firstChild.nodeValue.match(indentRx); t = t.firstChild.nodeValue.match(indentRx); if (f && t && f[0] !== t[0]) { r.innerHTML = r.innerHTML.replace(new RegExp('^'+f[0].replace(rxEsc, '\\$1'), 'mg'), t[0]); } if (/\bsf-dump-compact\b/.test(r.className)) { toggle(s, isCtrlKey(e)); } } if (c) { } else if (doc.getSelection) { try { doc.getSelection().removeAllRanges(); } catch (e) { doc.getSelection().empty(); } } else { doc.selection.empty(); } } else if (/\bsf-dump-str-toggle\b/.test(a.className)) { e.preventDefault(); e = a.parentNode.parentNode; e.className = e.className.replace(/\bsf-dump-str-(expand|collapse)\b/, a.parentNode.className); } }); elt = root.getElementsByTagName('SAMP'); len = elt.length; i = 0; while (i < len) t.push(elt[i++]); len = t.length; for (i = 0; i < len; ++i) { elt = t[i]; if ('SAMP' == elt.tagName) { a = elt.previousSibling || {}; if ('A' != a.tagName) { a = doc.createElement('A'); a.className = 'sf-dump-ref'; elt.parentNode.insertBefore(a, elt); } else { a.innerHTML += ' '; } a.title = (a.title ? a.title+'\n[' : '[')+keyHint+'+click] Expand all children'; a.innerHTML += elt.className == 'sf-dump-compact' ? '<span>▶</span>' : '<span>▼</span>'; a.className += ' sf-dump-toggle'; x = 1; if ('sf-dump' != elt.parentNode.className) { x += elt.parentNode.getAttribute('data-depth')/1; } } else if (/\bsf-dump-ref\b/.test(elt.className) && (a = elt.getAttribute('href'))) { a = a.slice(1); elt.className += ' sf-dump-hover'; elt.className += ' '+a; if (/[\[{]$/.test(elt.previousSibling.nodeValue)) { a = a != elt.nextSibling.id && doc.getElementById(a); try { s = a.nextSibling; elt.appendChild(a); s.parentNode.insertBefore(a, s); if (/^[@#]/.test(elt.innerHTML)) { elt.innerHTML += ' <span>▶</span>'; } else { elt.innerHTML = '<span>▶</span>'; elt.className = 'sf-dump-ref'; } elt.className += ' sf-dump-toggle'; } catch (e) { if ('&' == elt.innerHTML.charAt(0)) { elt.innerHTML = '…'; elt.className = 'sf-dump-ref'; } } } } } if (doc.evaluate && Array.from && root.children.length > 1) { root.setAttribute('tabindex', 0); SearchState = function () { this.nodes = []; this.idx = 0; }; SearchState.prototype = { next: function () { if (this.isEmpty()) { return this.current(); } this.idx = this.idx < (this.nodes.length - 1) ? this.idx + 1 : 0; return this.current(); }, previous: function () { if (this.isEmpty()) { return this.current(); } this.idx = this.idx > 0 ? this.idx - 1 : (this.nodes.length - 1); return this.current(); }, isEmpty: function () { return 0 === this.count(); }, current: function () { if (this.isEmpty()) { return null; } return this.nodes[this.idx]; }, reset: function () { this.nodes = []; this.idx = 0; }, count: function () { return this.nodes.length; }, }; function showCurrent(state) { var currentNode = state.current(), currentRect, searchRect; if (currentNode) { reveal(currentNode); highlight(root, currentNode, state.nodes); if ('scrollIntoView' in currentNode) { currentNode.scrollIntoView(true); currentRect = currentNode.getBoundingClientRect(); searchRect = search.getBoundingClientRect(); if (currentRect.top < (searchRect.top + searchRect.height)) { window.scrollBy(0, -(searchRect.top + searchRect.height + 5)); } } } counter.textContent = (state.isEmpty() ? 0 : state.idx + 1) + ' of ' + state.count(); } var search = doc.createElement('div'); search.className = 'sf-dump-search-wrapper sf-dump-search-hidden'; search.innerHTML = ' <input type="text" class="sf-dump-search-input"> <span class="sf-dump-search-count">0 of 0<\/span> <button type="button" class="sf-dump-search-input-previous" tabindex="-1"> <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 1331l-166 165q-19 19-45 19t-45-19L896 965l-531 531q-19 19-45 19t-45-19l-166-165q-19-19-19-45.5t19-45.5l742-741q19-19 45-19t45 19l742 741q19 19 19 45.5t-19 45.5z"\/><\/svg> <\/button> <button type="button" class="sf-dump-search-input-next" tabindex="-1"> <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 808l-742 741q-19 19-45 19t-45-19L109 808q-19-19-19-45.5t19-45.5l166-165q19-19 45-19t45 19l531 531 531-531q19-19 45-19t45 19l166 165q19 19 19 45.5t-19 45.5z"\/><\/svg> <\/button> '; root.insertBefore(search, root.firstChild); var state = new SearchState(); var searchInput = search.querySelector('.sf-dump-search-input'); var counter = search.querySelector('.sf-dump-search-count'); var searchInputTimer = 0; var previousSearchQuery = ''; addEventListener(searchInput, 'keyup', function (e) { var searchQuery = e.target.value; /* Don't perform anything if the pressed key didn't change the query */ if (searchQuery === previousSearchQuery) { return; } previousSearchQuery = searchQuery; clearTimeout(searchInputTimer); searchInputTimer = setTimeout(function () { state.reset(); collapseAll(root); resetHighlightedNodes(root); if ('' === searchQuery) { counter.textContent = '0 of 0'; return; } var classMatches = [ "sf-dump-str", "sf-dump-key", "sf-dump-public", "sf-dump-protected", "sf-dump-private", ].map(xpathHasClass).join(' or '); var xpathResult = doc.evaluate('.//span[' + classMatches + '][contains(translate(child::text(), ' + xpathString(searchQuery.toUpperCase()) + ', ' + xpathString(searchQuery.toLowerCase()) + '), ' + xpathString(searchQuery.toLowerCase()) + ')]', root, null, XPathResult.ORDERED_NODE_ITERATOR_TYPE, null); while (node = xpathResult.iterateNext()) state.nodes.push(node); showCurrent(state); }, 400); }); Array.from(search.querySelectorAll('.sf-dump-search-input-next, .sf-dump-search-input-previous')).forEach(function (btn) { addEventListener(btn, 'click', function (e) { e.preventDefault(); -1 !== e.target.className.indexOf('next') ? state.next() : state.previous(); searchInput.focus(); collapseAll(root); showCurrent(state); }) }); addEventListener(root, 'keydown', function (e) { var isSearchActive = !/\bsf-dump-search-hidden\b/.test(search.className); if ((114 === e.keyCode && !isSearchActive) || (isCtrlKey(e) && 70 === e.keyCode)) { /* F3 or CMD/CTRL + F */ if (70 === e.keyCode && document.activeElement === searchInput) { /* * If CMD/CTRL + F is hit while having focus on search input, * the user probably meant to trigger browser search instead. * Let the browser execute its behavior: */ return; } e.preventDefault(); search.className = search.className.replace(/\bsf-dump-search-hidden\b/, ''); searchInput.focus(); } else if (isSearchActive) { if (27 === e.keyCode) { /* ESC key */ search.className += ' sf-dump-search-hidden'; e.preventDefault(); resetHighlightedNodes(root); searchInput.value = ''; } else if ( (isCtrlKey(e) && 71 === e.keyCode) /* CMD/CTRL + G */ || 13 === e.keyCode /* Enter */ || 114 === e.keyCode /* F3 */ ) { e.preventDefault(); e.shiftKey ? state.previous() : state.next(); collapseAll(root); showCurrent(state); } } }); } if (0 >= options.maxStringLength) { return; } try { elt = root.querySelectorAll('.sf-dump-str'); len = elt.length; i = 0; t = []; while (i < len) t.push(elt[i++]); len = t.length; for (i = 0; i < len; ++i) { elt = t[i]; s = elt.innerText || elt.textContent; x = s.length - options.maxStringLength; if (0 < x) { h = elt.innerHTML; elt[elt.innerText ? 'innerText' : 'textContent'] = s.substring(0, options.maxStringLength); elt.className += ' sf-dump-str-collapse'; elt.innerHTML = '<span class=sf-dump-str-collapse>'+h+'<a class="sf-dump-ref sf-dump-str-toggle" title="Collapse"> ◀</a></span>'+ '<span class=sf-dump-str-expand>'+elt.innerHTML+'<a class="sf-dump-ref sf-dump-str-toggle" title="'+x+' remaining characters"> ▶</a></span>'; } } } catch (e) { } }; })(document); </script><style> .sf-js-enabled .phpdebugbar pre.sf-dump .sf-dump-compact, .sf-js-enabled .sf-dump-str-collapse .sf-dump-str-collapse, .sf-js-enabled .sf-dump-str-expand .sf-dump-str-expand { display: none; } .sf-dump-hover:hover { background-color: #B729D9; color: #FFF !important; border-radius: 2px; } .phpdebugbar pre.sf-dump { display: block; white-space: pre; padding: 5px; overflow: initial !important; } .phpdebugbar pre.sf-dump:after { content: ""; visibility: hidden; display: block; height: 0; clear: both; } .phpdebugbar pre.sf-dump .sf-dump-ellipsization { display: inline-flex; } .phpdebugbar pre.sf-dump a { text-decoration: none; cursor: pointer; border: 0; outline: none; color: inherit; } .phpdebugbar pre.sf-dump img { max-width: 50em; max-height: 50em; margin: .5em 0 0 0; padding: 0; background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAAAAAA6mKC9AAAAHUlEQVQY02O8zAABilCaiQEN0EeA8QuUcX9g3QEAAjcC5piyhyEAAAAASUVORK5CYII=) #D3D3D3; } .phpdebugbar pre.sf-dump .sf-dump-ellipsis { text-overflow: ellipsis; white-space: nowrap; overflow: hidden; } .phpdebugbar pre.sf-dump .sf-dump-ellipsis-tail { flex-shrink: 0; } .phpdebugbar pre.sf-dump code { display:inline; padding:0; background:none; } .sf-dump-public.sf-dump-highlight, .sf-dump-protected.sf-dump-highlight, .sf-dump-private.sf-dump-highlight, .sf-dump-str.sf-dump-highlight, .sf-dump-key.sf-dump-highlight { background: rgba(111, 172, 204, 0.3); border: 1px solid #7DA0B1; border-radius: 3px; } .sf-dump-public.sf-dump-highlight-active, .sf-dump-protected.sf-dump-highlight-active, .sf-dump-private.sf-dump-highlight-active, .sf-dump-str.sf-dump-highlight-active, .sf-dump-key.sf-dump-highlight-active { background: rgba(253, 175, 0, 0.4); border: 1px solid #ffa500; border-radius: 3px; } .phpdebugbar pre.sf-dump .sf-dump-search-hidden { display: none !important; } .phpdebugbar pre.sf-dump .sf-dump-search-wrapper { font-size: 0; white-space: nowrap; margin-bottom: 5px; display: flex; position: -webkit-sticky; position: sticky; top: 5px; } .phpdebugbar pre.sf-dump .sf-dump-search-wrapper > * { vertical-align: top; box-sizing: border-box; height: 21px; font-weight: normal; border-radius: 0; background: #FFF; color: #757575; border: 1px solid #BBB; } .phpdebugbar pre.sf-dump .sf-dump-search-wrapper > input.sf-dump-search-input { padding: 3px; height: 21px; font-size: 12px; border-right: none; border-top-left-radius: 3px; border-bottom-left-radius: 3px; color: #000; min-width: 15px; width: 100%; } .phpdebugbar pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-input-next, .phpdebugbar pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-input-previous { background: #F2F2F2; outline: none; border-left: none; font-size: 0; line-height: 0; } .phpdebugbar pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-input-next { border-top-right-radius: 3px; border-bottom-right-radius: 3px; } .phpdebugbar pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-input-next > svg, .phpdebugbar pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-input-previous > svg { pointer-events: none; width: 12px; height: 12px; } .phpdebugbar pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-count { display: inline-block; padding: 0 5px; margin: 0; border-left: none; line-height: 21px; font-size: 12px; }.phpdebugbar pre.sf-dump, .phpdebugbar pre.sf-dump .sf-dump-default{word-wrap: break-word; white-space: pre-wrap; word-break: normal}.phpdebugbar pre.sf-dump .sf-dump-num{font-weight:bold; color:#1299DA}.phpdebugbar pre.sf-dump .sf-dump-const{font-weight:bold}.phpdebugbar pre.sf-dump .sf-dump-str{font-weight:bold; color:#3A9B26}.phpdebugbar pre.sf-dump .sf-dump-note{color:#1299DA}.phpdebugbar pre.sf-dump .sf-dump-ref{color:#7B7B7B}.phpdebugbar pre.sf-dump .sf-dump-public{color:#000000}.phpdebugbar pre.sf-dump .sf-dump-protected{color:#000000}.phpdebugbar pre.sf-dump .sf-dump-private{color:#000000}.phpdebugbar pre.sf-dump .sf-dump-meta{color:#B729D9}.phpdebugbar pre.sf-dump .sf-dump-key{color:#3A9B26}.phpdebugbar pre.sf-dump .sf-dump-index{color:#1299DA}.phpdebugbar pre.sf-dump .sf-dump-ellipsis{color:#A0A000}.phpdebugbar pre.sf-dump .sf-dump-ns{user-select:none;}.phpdebugbar pre.sf-dump .sf-dump-ellipsis-note{color:#1299DA}.phpdebugbar[data-theme='dark'] pre.sf-dump, pre.sf-dump .sf-dump-default{background-color:#18171B; color:#FF8400; line-height:1.2em; font:12px Menlo, Monaco, Consolas, monospace; word-wrap: break-word; white-space: pre-wrap; position:relative; z-index:99999; word-break: break-all}.phpdebugbar[data-theme='dark'] pre.sf-dump .sf-dump-num{font-weight:bold; color:#1299DA}.phpdebugbar[data-theme='dark'] pre.sf-dump .sf-dump-const{font-weight:bold}.phpdebugbar[data-theme='dark'] pre.sf-dump .sf-dump-str{font-weight:bold; color:#56DB3A}.phpdebugbar[data-theme='dark'] pre.sf-dump .sf-dump-note{color:#1299DA}.phpdebugbar[data-theme='dark'] pre.sf-dump .sf-dump-ref{color:#A0A0A0}.phpdebugbar[data-theme='dark'] pre.sf-dump .sf-dump-public{color:#FFFFFF}.phpdebugbar[data-theme='dark'] pre.sf-dump .sf-dump-protected{color:#FFFFFF}.phpdebugbar[data-theme='dark'] pre.sf-dump .sf-dump-private{color:#FFFFFF}.phpdebugbar[data-theme='dark'] pre.sf-dump .sf-dump-meta{color:#B729D9}.phpdebugbar[data-theme='dark'] pre.sf-dump .sf-dump-key{color:#56DB3A}.phpdebugbar[data-theme='dark'] pre.sf-dump .sf-dump-index{color:#1299DA}.phpdebugbar[data-theme='dark'] pre.sf-dump .sf-dump-ellipsis{color:#FF8400}.phpdebugbar[data-theme='dark'] pre.sf-dump .sf-dump-ns{user-select:none;}.phpdebugbar[data-theme='dark'] pre.sf-dump .sf-dump-ellipsis-note{color:#1299DA}</style>
</head>

<body inmaintabuse="1" class="modal-open" style="overflow: hidden; padding-right: 0px;">
    <!-- Sidebar Begin -->
<div class="sidebar">
    <div class="sidebar-head">
        <a href="/dashboard.html" class="logo">
            <img src="https://saserp.tgastaging.com/student/images/logo.png" alt="Logo">
        </a>
        <button class="sidebar-toggler"><i class="fa-solid fa-chevron-left"></i></button>
    </div>
    <div class="sidebar-body">
        <ul>
            <li class="active">
                <a href="https://saserp.tgastaging.com/student_dashboard">
                    <img src="https://saserp.tgastaging.com/student/images/sidebar-icon-1.svg" alt="Sidebar Icon">
                    Dashboard
                </a>
            </li>
            <li class="">
                <a href="https://saserp.tgastaging.com/student_profile">
                    <img src="https://saserp.tgastaging.com/student/images/sidebar-icon-2.svg" alt="Sidebar Icon">
                    My Profile
                </a> 
            </li>
            <li class="">
                <a href="https://saserp.tgastaging.com/student_classes">
                    <img src="https://saserp.tgastaging.com/student/images/sidebar-icon-3.svg" alt="Sidebar Icon">
                    My Classes
                </a>
            </li>
            <li class="">
                <a href="https://saserp.tgastaging.com/student_assignment">
                    <img src="https://saserp.tgastaging.com/student/images/sidebar-icon-4.svg" alt="Sidebar Icon">
                    My Assignments
                </a>
            </li>
            <li class="">
                <a href="https://saserp.tgastaging.com/student_attendance">
                    <img src="https://saserp.tgastaging.com/student/images/sidebar-icon-5.svg" alt="Sidebar Icon">
                    My Attendance
                </a>
            </li>
            <li class="">
                <a href="https://saserp.tgastaging.com/student_grades">
                    <img src="https://saserp.tgastaging.com/student/images/sidebar-icon-6.svg" alt="Sidebar Icon">
                    My Grades
                </a>
            </li>
            <li class="">
                <a href="https://saserp.tgastaging.com/student_fees">
                    <img src="https://saserp.tgastaging.com/student/images/sidebar-icon-7.svg" alt="Sidebar Icon">
                    My Fees
                </a>
            </li>
            <li class="">
                <a href="https://saserp.tgastaging.com/student_request_transcript">
                    <img src="https://saserp.tgastaging.com/student/images/sidebar-icon-8.svg" alt="Sidebar Icon">
                    Request Transcript
                </a>
            </li>
            <li class="">
                <a href="https://saserp.tgastaging.com/student_apply_leave">
                    <img src="https://saserp.tgastaging.com/student/images/sidebar-icon-9.svg" alt="Sidebar Icon">
                    Apply Leaves (to admin)
                </a>
            </li>
            <li class="">
                <a href="https://saserp.tgastaging.com/student_notice_board">
                    <img src="https://saserp.tgastaging.com/student/images/sidebar-icon-10.svg" alt="Sidebar Icon">
                    Notice Board
                </a>
            </li>
            
            <li class="">
                <a href="https://saserp.tgastaging.com/student_late_curfew_request">
                    <img src="https://saserp.tgastaging.com/student/images/clock-icon.svg" alt="Sidebar Icon">
                    Late Curfew Request
                </a>
            </li>
            <li>
                <a href="https://saserp.tgastaging.com/student_logout">
                    <img src="https://saserp.tgastaging.com/student/images/sidebar-icon-12.svg" alt="Sidebar Icon">
                    Logout
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- End Of Sidebar -->



    <div class="dashboard-main light-bg">
        <div class="dashboard-body">
            <div class="dashboard-body-head">
                <!-- <div class="dsbdy-head-left">
                    <div class="dsbdy-search-form">
                        <div class="input-grp search-field">
                            <input type="text" placeholder="Search Page">
                            <input type="submit" value="Search">
                        </div>
                    </div>
                </div> -->

                <div class="dsbdy-head-left">
                    <form class="dsbdy-search-form">
                        <div class="input-grp search-field" style="position: relative;">
                            <input type="text" id="page-search-input" placeholder="Search Page" autocomplete="off">
                            <input type="submit" value="Search">
                            <div id="search-suggestions" class="search-suggestions-list" style="display: none;">
                                <ul>
                                    <!-- Suggestions will be populated by JavaScript -->
                                <li><a href="https://saserp.tgastaging.com/student_dashboard">Dashboard</a></li><li><a href="https://saserp.tgastaging.com/student_profile">My Profile</a></li><li><a href="https://saserp.tgastaging.com/student_classes">My Classes</a></li><li><a href="https://saserp.tgastaging.com/student_assignment">My Assignments</a></li><li><a href="https://saserp.tgastaging.com/student_attendance">My Attendance</a></li><li><a href="https://saserp.tgastaging.com/student_grades">My Grades</a></li><li><a href="https://saserp.tgastaging.com/student_fees">My Fees</a></li><li><a href="https://saserp.tgastaging.com/student_request_transcript">Request Transcript</a></li><li><a href="https://saserp.tgastaging.com/student_apply_leave">Apply Leaves (to admin)</a></li><li><a href="https://saserp.tgastaging.com/student_notice_board">Notice Board</a></li><li><a href="https://saserp.tgastaging.com/student_late_curfew_request">Late Curfew Request</a></li></ul>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="dsbdy-head-right">
                    <button class="tgl-flscrn" onclick="toggleFullScreen()" aria-label="Toggle fullscreen">
                        <img src="https://saserp.tgastaging.com/student/images/fullscreen-toggler-icon.svg" alt="Icon">
                    </button>
                    <div class="profile-ctrl">
                        <button class="profile-ctrl-toggler">
                            <div class="pr-pic">
                                <img src="https://saserp.tgastaging.com/student/images/profile-picture.png" alt="Profile Picture">
                            </div>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="pr-ctrl-menu">
                            <ul>
                                <li><a href="https://saserp.tgastaging.com/student_profile">My Profile</a></li>
                                <li><a href="https://saserp.tgastaging.com/update_password_view">Change Password</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start Dashboard -->
<div class="ds-breadcrumb">
    <div class="bread-left-wrp"><h1>My Assignments</h1><ul>
        <li><a href="https://saserp.tgastaging.com/student_dashboard">Dashboard</a> /</li>
        <li>My Assignments </li>
    </ul></div>
    
</div>
<div class="ds-pr-body">

    <div class="ds-cmn-table-wrp tab-wrapper">
        <div class="ds-content-head">
            <div class="sec-head">
                <h2>Assignments</h2>
            </div>
            <div class="cmn-tab-head">
                <ul>
                    <li class="tab-bg" style="left: 12px; top: 4px; width: 123.156px; height: 35px; display: block;"></li>
                    <li class="tab-btn active" data-tab="pending" data-filter=".pending">
                        Pending
                    </li>

                    <li class="tab-btn" data-tab="completed" data-filter=".completed">
                        Completed
                    </li>
                </ul>
            </div>
        </div>

        <div class="ds-cmn-tble pending count-row active" style="display: block;">
            <table>
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Subject</th>
                        <th>Assignment Title</th>
                        <th>Assignment Description</th>
                        <th>Attachment</th>
                        <th>Assigned Date</th>
                        <th>Due Date</th>
                        <th>Upload File</th>
                    </tr>
                </thead>
                
                <tbody>
                    
                                        <tr data-assignment-id="2" data-subject-id="6">
                        <td>1</td>

                        <td>Hindi</td>
                        <td>assignment title 1</td>
                        <td>
                            <div class="toggle-text-wrapper">
                                <div class="toggle-text-content" style="width: 100%; height: 44.8px; overflow: hidden;">thisjfdjdkf… <a href="#" class="read-more">Read more <i class="fa-solid fa-arrow-right" style="transform:rotate(-45deg)"></i></a></div>
                            </div>

                        </td>
                        <td>
                            <button class="view-attachment-btn" data-bs-target="#viewAttachedDocs" data-bs-toggle="modal" data-id="2" data-title="assignment title 1" data-subject="Hindi" data-file="backend/uploads/assignments/images/1764680659_about-img.png" data-media_type="" data-file_name="" data-download-url="">
                                <img src="https://saserp.tgastaging.com/student/images/eye-white.svg" alt="Eye Icon">
                            </button>
                        </td>


                        <td>08/10/2025</td>
                        <td>10/10/2025</td>

                        <td>
                            <div class="file-upload">
                                <button class="file-upload-btn" data-bs-target="#viewAttachments" data-bs-toggle="modal" data-assignment-id="2" data-subject-id="6">
                                    <img src="https://saserp.tgastaging.com/student/images/upload-white.svg">Upload
                                </button>

                            </div>
                        </td>
                    </tr>
                                    </tbody>
            </table>

            
            <div class="tablepagination">
                <div class="tbl-pagination-inr">
                    <ul>
                        
                                                <li><a><img src="https://saserp.tgastaging.com/student/images/arrow-left.svg"></a></li>
                        
                        
                                                <li class="active">
                            <a href="https://saserp.tgastaging.com/student_assignment?tab=pending&amp;pending_page=1">
                                1
                            </a>
                        </li>
                        
                        
                                                <li><a><img src="https://saserp.tgastaging.com/student/images/arrow-right.svg"></a></li>
                                            </ul>

                </div>

                <div class="pages-select">
                    <form method="GET">
                        <input type="hidden" name="tab" value="pending">

                        <div class="formfield">
                            <label>Per page</label>

                            <select name="pending_per_page" onchange="this.form.submit()">
                                                                <option value="1">
                                    1
                                </option>
                                                                <option value="2">
                                    2
                                </option>
                                                                <option value="3">
                                    3
                                </option>
                                                                <option value="4">
                                    4
                                </option>
                                                                <option value="5" selected="">
                                    5
                                </option>
                                                                <option value="6">
                                    6
                                </option>
                                                                <option value="7">
                                    7
                                </option>
                                                                <option value="8">
                                    8
                                </option>
                                                                <option value="9">
                                    9
                                </option>
                                                                <option value="10">
                                    10
                                </option>
                                                            </select>
                        </div>
                    </form>

                    <p>of 1 results</p>
                </div>
            </div>
            

        </div>

        <div class="ds-cmn-tble completed count-row" style="display: none !important;">
            <table>
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Subject</th>
                        <th>Assignment Title</th>
                        <th>Assignment Description</th>
                        <th>Attachment</th>
                        <th>Assigned Date</th>
                        <th>Due Date</th>
                        <th>Submitted On</th>
                        <th>Edit File</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    
                    
                                        <tr data-assignment-id="3" data-subject-id="6">
                        <td>1</td>
                        <td>Hindi</td>
                        <td>assignment2</td>
                        <td>
                            <div class="toggle-text-wrapper">
                                <div class="toggle-text-content" style="width: 100%; height: 44.8px; overflow: hidden;">this is testing… <a href="#" class="read-more">Read more <i class="fa-solid fa-arrow-right" style="transform:rotate(-45deg)"></i></a></div>
                            </div>
                        </td>
                        <td>
                            <button class="view-attachment-btn" data-bs-target="#viewAttachedDocs" data-bs-toggle="modal" data-id="3" data-title="assignment2" data-subject="Hindi" data-file="backend/uploads/assignments/images/1764139436_cross-icon.png" data-media_type="" data-file_name="" data-download-url="">
                                <img src="https://saserp.tgastaging.com/student/images/eye-white.svg" alt="Eye Icon">
                            </button>
                        </td>

                        <td>08/10/2025</td>
                        <td>13/10/2025</td>
                        <td>
                            <div class="submitted-on">
                                <span>15/10/2025</span>
                                <div class="submitted-tag">Submitted</div>
                            </div>
                        </td>
                        <td>
                            <button class="edit-file-btn cmn-tbl-btn" data-bs-target="#editFile" data-bs-toggle="modal" data-assignment-id="3" data-subject-id="6"><img src="https://saserp.tgastaging.com/student/images/edit-icon.svg" alt="Eye Icon"> Edit</button>
                        </td>
                        <td>30</td>
                    </tr>
                                        <tr data-assignment-id="1" data-subject-id="5">
                        <td>2</td>
                        <td>English</td>
                        <td>testing title</td>
                        <td>
                            <div class="toggle-text-wrapper">
                                <div class="toggle-text-content" style="width: 100%; height: 44.8px; overflow: hidden;">thisjfdjdkf… <a href="#" class="read-more">Read more <i class="fa-solid fa-arrow-right" style="transform:rotate(-45deg)"></i></a></div>
                            </div>
                        </td>
                        <td>
                            <button class="view-attachment-btn" data-bs-target="#viewAttachedDocs" data-bs-toggle="modal" data-id="1" data-title="testing title" data-subject="English" data-file="backend/uploads/assignments/images/1764139851_cross-icon.png" data-media_type="" data-file_name="" data-download-url="">
                                <img src="https://saserp.tgastaging.com/student/images/eye-white.svg" alt="Eye Icon">
                            </button>
                        </td>

                        <td>04/12/2025</td>
                        <td>07/10/2025</td>
                        <td>
                            <div class="submitted-on">
                                <span>17/10/2025</span>
                                <div class="submitted-tag">Submitted</div>
                            </div>
                        </td>
                        <td>
                            <button class="edit-file-btn cmn-tbl-btn" data-bs-target="#editFile" data-bs-toggle="modal" data-assignment-id="1" data-subject-id="5"><img src="https://saserp.tgastaging.com/student/images/edit-icon.svg" alt="Eye Icon"> Edit</button>
                        </td>
                        <td>50</td>
                    </tr>
                    
                </tbody>
            </table>


            
            <div class="tablepagination">
                <div class="tbl-pagination-inr">
                    <ul>
                        
                                                <li><a><img src="https://saserp.tgastaging.com/student/images/arrow-left.svg"></a></li>
                        
                        
                                                <li class="active">
                            <a href="https://saserp.tgastaging.com/student_assignment?tab=completed&amp;completed_page=1">
                                1
                            </a>
                        </li>
                        
                        
                                                <li><a><img src="https://saserp.tgastaging.com/student/images/arrow-right.svg"></a></li>
                                            </ul>



                </div>

                <div class="pages-select">
                    <form method="GET">
                        <input type="hidden" name="tab" value="completed">

                        <div class="formfield">
                            <label>Per page</label>

                            <select name="completed_per_page" onchange="this.form.submit()">
                                                                <option value="1">
                                    1
                                </option>
                                                                <option value="2">
                                    2
                                </option>
                                                                <option value="3">
                                    3
                                </option>
                                                                <option value="4">
                                    4
                                </option>
                                                                <option value="5" selected="">
                                    5
                                </option>
                                                                <option value="6">
                                    6
                                </option>
                                                                <option value="7">
                                    7
                                </option>
                                                                <option value="8">
                                    8
                                </option>
                                                                <option value="9">
                                    9
                                </option>
                                                                <option value="10">
                                    10
                                </option>
                                                            </select>
                        </div>
                    </form>

                    <p>of 2 results</p>
                </div>


            </div>
            

        </div>

        
</div>
</div>
<!-- End Dashboard -->

<!-- Attachments Modal Begin -->
<div class="modal fade cmn-popwrp pop800 show" id="viewAttachments" tabindex="-1" role="dialog" aria-labelledby="viewAttachments" aria-modal="true" style="display: block; padding-right: 15px;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">


            <div class="modal-body">
                <div class="tab-wrapper">
                    <div class="cmn-pop-head" style="text-align: center;">
                        <h3>Choose your Student</h3>
                        <p>Welcome! You have more then student linked to your account
                        To get started clicked on this dropdown to choose the student whose data you want to view.</p>
                    </div>

                    <div class="cmn-pop-inr-content-wrp">
                    
                        <div class="select-wrapper">
                            <div class="custom-select">
                                <div class="selected">Select Student</div>
                                    <ul class="options">
                                        @foreach ($students as $student )
                                        {{-- <li>{{ $student->first_name }}{{ $student->last_name }} (ID-{{ $student->student_id }})</li> --}}

                                        <li data-id="{{ $student->id }}">
                                            {{ $student->first_name }} {{ $student->last_name }} 
                                            (ID-{{ $student->student_id }})
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>

            </div>
        </div>
</div>

<!-- End Of Attachments Modal -->

<!-- Edit File Modal Begin -->

<div class="modal fade cmn-popwrp pop800" id="editFile" tabindex="-1" role="dialog" aria-labelledby="editFile" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="https://saserp.tgastaging.com/student/images/cross-icon.svg" alt="Icon"></span>
            </button>

            <div class="modal-body">
                <div class="cmn-pop-content-wrapper">
                    <div class="cmn-pop-head">
                        <h2>UploadedFiles</h2>
                    </div>

                    <div class="cmn-pop-inr-content-wrp">
                        <div class="cmn-tab-content mb-4">
                            <form action="https://saserp.tgastaging.com/student/assignment/upload" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="NHn738kSkVp4duFVd2zQ7BHpv5g6HPluJUZC2ls1">                                <input type="hidden" name="assignment_id" id="edit_assignment_id" value="2">
                                <input type="hidden" name="subject_id" id="edit_subject_id" value="6">

                                <div class="file-upload-lg">
                                    <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png,.webp,.mp4,.mov,.doc,.docx,.xls,.xlsx">
                                    <div class="file-upld-lg-design">
                                        <div class="fupld-lg-icon">
                                            <img src="https://saserp.tgastaging.com/student/images/upload-white.svg" alt="Icon">
                                        </div>
                                        <p class="upload-text-edit">Click to browse or drag and drop your files</p>
                                    </div>
                                </div>

                                <div class="note">
                                    <p>Supports .pdf, .jpg, .jpeg, .png, .webp, .mp4, .mov, URL, .doc, .docx, .xls,
                                        .xlsx files.</p>
                                </div>

                                <button type="submit" style="margin-top: 20px;" class="btn-sm cmn-btn">Upload</button>
                            </form>
                        </div>

                        <div class="cmn-tab-content">
                            <div class="upload-list">
                                <ul class="uploads">
                                                                                                            <li class="upload-item">
                                        <span class="icon pdf-icon">
                                            <img src="https://saserp.tgastaging.com/student/images/pdf-icon.svg" alt="icon">
                                        </span>
                                        <div class="details">
                                            <span class="filename">1764139436_cross-icon.png</span>
                                            <span class="timestamp">1 week ago</span>
                                        </div>
                                        <span class="size">542 B</span>
                                        <button class="remove-btn">
                                            <img src="https://saserp.tgastaging.com/student/images/cross-circle.svg" alt="Icon">
                                        </button>
                                    </li>
                                                                                                                                                <li class="upload-item">
                                        <span class="icon pdf-icon">
                                            <img src="https://saserp.tgastaging.com/student/images/pdf-icon.svg" alt="icon">
                                        </span>
                                        <div class="details">
                                            <span class="filename">1764066405_cross-icon.png</span>
                                            <span class="timestamp">1 week ago</span>
                                        </div>
                                        <span class="size">542 B</span>
                                        <button class="remove-btn">
                                            <img src="https://saserp.tgastaging.com/student/images/cross-circle.svg" alt="Icon">
                                        </button>
                                    </li>
                                                                        <li class="upload-item">
                                        <span class="icon pdf-icon">
                                            <img src="https://saserp.tgastaging.com/student/images/pdf-icon.svg" alt="icon">
                                        </span>
                                        <div class="details">
                                            <span class="filename">1764139851_cross-icon.png</span>
                                            <span class="timestamp">1 week ago</span>
                                        </div>
                                        <span class="size">542 B</span>
                                        <button class="remove-btn">
                                            <img src="https://saserp.tgastaging.com/student/images/cross-circle.svg" alt="Icon">
                                        </button>
                                    </li>
                                                                                                        </ul>
                                <div class="btn-wrp justify-content-end">
                                    <button class="btn-sm cmn-btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button class="btn-sm cmn-btn">Save Changes</button>
                                </div>
                                <div class="last-updated">
                                    <img src="https://saserp.tgastaging.com/student/images/check-circle.svg" alt="Icon">
                                    Last updated:
                                    26 Nov 2025, 06:50 AM
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Of Edit File Modal -->

<!-- viewAttachedDocs Modal Begin -->

<div class="modal fade cmn-popwrp pop800" id="viewAttachedDocs" tabindex="-1" role="dialog" aria-labelledby="viewAttachedDocs" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="https://saserp.tgastaging.com/student/images/cross-icon.svg" alt="Icon"></span>
            </button>
            <div class="modal-body">
                <div class="cmn-pop-content-wrapper">
                    <div class="cmn-pop-head">
                        <h2>Attached Files</h2>
                    </div>

                    <div class="cmn-pop-inr-content-wrp">
                        <div class="viewAttachedDocs">
                            <!-- Assignment details will be inserted dynamically -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Of viewAttachedDocs Modal -->

        </div>
    </div>

    <!-- Jquery-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://saserp.tgastaging.com/student/js/common.js"></script>


    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
    <script>
        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen();
                } else if (document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen();
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            }
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.querySelector('.dsbdy-search-form');
            const searchInput = document.getElementById('page-search-input');
            const suggestionsContainer = document.getElementById('search-suggestions');
            const suggestionsList = suggestionsContainer.querySelector('ul');
            const sidebarLinks = document.querySelectorAll('.sidebar-body ul li a');
            let allPages = [];

            // 1. Populate suggestions and store page data
            sidebarLinks.forEach(link => {
                const linkText = link.textContent.trim();
                if (linkText.toLowerCase() !== 'logout') {
                    allPages.push({
                        text: linkText,
                        href: link.href
                    });
                    const listItem = document.createElement('li');
                    const anchor = document.createElement('a');
                    anchor.href = link.href;
                    anchor.textContent = linkText;
                    listItem.appendChild(anchor);
                    suggestionsList.appendChild(listItem);
                }
            });

            // 2. Show/hide suggestions on focus/blur
            searchInput.addEventListener('focus', () => {
                suggestionsContainer.style.display = 'block';
            });

            document.addEventListener('click', (event) => {
                if (!searchForm.contains(event.target)) {
                    suggestionsContainer.style.display = 'none';
                }
            });

            // 3. Filter suggestions as user types
            searchInput.addEventListener('input', () => {
                const query = searchInput.value.trim().toLowerCase();
                const listItems = suggestionsList.querySelectorAll('li');
                listItems.forEach(item => {
                    const itemText = item.textContent.trim().toLowerCase();
                    if (itemText.includes(query)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            // 4. Handle form submission (typing and clicking search)
            searchForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const query = searchInput.value.trim().toLowerCase();
                if (!query) return;

                let found = false;
                for (const page of allPages) {
                    if (page.text.toLowerCase().includes(query)) {
                        window.location.href = page.href;
                        found = true;
                        break;
                    }
                }

                if (!found) {
                    alert('No page found matching your search.');
                }
            });
        });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {

        let activeTab = "pending";

        if (activeTab === "completed") {

            // Switch tab header
            document.querySelectorAll(".cmn-tab-head li")[1].classList.remove("active");
            document.querySelectorAll(".cmn-tab-head li")[2].classList.add("active");

            // Switch sections
            document.querySelector(".pending-section").style.display = "none";
            document.querySelector(".completed-section").style.display = "block";
        }
    });



    $(document).on('click', '.file-upload-btn, .edit-file-btn', function() {
        let assignmentId = $(this).data('assignment-id');
        let subjectId = $(this).data('subject-id');

        // Fill the hidden inputs in the modal form
        $('#assignment_id').val(assignmentId);
        $('#subject_id').val(subjectId);

        $('#edit_assignment_id').val(assignmentId);
        $('#edit_subject_id').val(subjectId);


    });


    document.addEventListener('DOMContentLoaded', function() {
        $(document).on('click', '.view-attachment-btn', function() {
            const title = $(this).data('title');
            const subject = $(this).data('subject');
            const mediaType = $(this).data('media_type') || 'N/A';
            const downloadUrl = $(this).data('download-url');
            const fileName = $(this).data('assignment_uploads') || '';

            let fileSection = `
            <div class="attached-doc-card">
                <div class="attached-doc-info">
                    <p><strong>Subject:</strong> ${subject}</p>
                    <p><strong>Title:</strong> ${title}</p>
                    <p><strong>File Path:</strong> ${fileName}</p>
                </div>
                <div class="btn-wrp">
                    <a href="${downloadUrl || '#'}"
                       ${downloadUrl ? '' : 'disabled'}
                       class="cmn-btn ${downloadUrl ? '' : 'disabled'}"
                       download>
                       Download
                    </a>
                </div>
            </div>
        `;

            $('.viewAttachedDocs').html(fileSection);
        });
    });



    document.addEventListener('DOMContentLoaded', function() {
        $(document).on('click', '.view-attachment-btn', function() {
            const title = $(this).data('title');
            const subject = $(this).data('subject');
            const mediaType = $(this).data('media_type') || 'N/A';
            const downloadUrl = $(this).data('download-url');
            const fileName = $(this).data('file') || 'N/A';

            let fileSection = `
            <div class="attached-doc-card">
                <div class="attached-doc-info">
                    <p><strong>Subject:</strong> ${subject}</p>
                    <p><strong>Title:</strong> ${title}</p>
                    <p><strong>File Path:</strong> ${fileName}</p>
                </div>
                <div class="btn-wrp">
                    <a href="${downloadUrl || '#'}"
                       ${downloadUrl ? '' : 'disabled'}
                       class="cmn-btn ${downloadUrl ? '' : 'disabled'}"
                       download>
                       Download
                    </a>
                </div>
            </div>
        `;

            $('.viewAttachedDocs').html(fileSection);
        });
    });
</script>




<script>
    $('.cmn-tab-btn').on('click', function() {
        let tab = $(this).data('tab');

        // Update the URL (no refresh)
        let baseUrl = window.location.origin + window.location.pathname;
        let newUrl = baseUrl + '?tab=' + tab;
        window.history.pushState({}, '', newUrl);

        // FIX pagination - update all pagination links
        $('.tablepagination a').each(function() {
            let href = $(this).attr('href');

            if (!href) return;

            // Remove old tab value
            href = href.replace(/tab=\w+/g, '');

            // Remove ?& or && duplicates
            href = href.replace(/[?&]+$/, '');

            // Add correct tab
            if (href.includes('?')) {
                href += '&tab=' + tab;
            } else {
                href += '?tab=' + tab;
            }

            $(this).attr('href', href);
        });
    });
</script>


<script>
    $("#recent-upload-container").click(function() {
        $(".cmn-tab-content.recent").css("display", "block");
        $(".cmn-tab-content.new-upload").css("display", "none");

        $("#recent-upload-container").addClass("active");
        $("#new-upload-container").removeClass("active");
    });

    $("#new-upload-container").click(function() {
        $(".cmn-tab-content.recent").css("display", "none");
        $(".cmn-tab-content.new-upload").css("display", "block");

        $("#new-upload-container").addClass("active");
        $("#recent-upload-container").removeClass("active");
    });
</script>




<style>
        label.error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }
        .search-suggestions-list {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #ddd;
            border-top: none;
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            border-radius: 0 0 5px 5px;
        }
        .search-suggestions-list ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .search-suggestions-list ul li a {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
        }
        .search-suggestions-list ul li a:hover {
            background-color: #f5f5f5;
        }
    </style>

<script type="text/javascript">
var phpdebugbar = new PhpDebugBar.DebugBar({"theme":"auto","hideEmptyTabs":false});
phpdebugbar.addTab("request", new PhpDebugBar.DebugBar.Tab({"icon":"tags","order":-100,"title":"Request", "widget": new PhpDebugBar.Widgets.HtmlVariableListWidget()}));
phpdebugbar.addIndicator("php_version", new PhpDebugBar.DebugBar.Indicator({"icon":"code","tooltip":"PHP Version"}), "right");
phpdebugbar.addTab("messages", new PhpDebugBar.DebugBar.Tab({"icon":"list-alt","title":"Messages", "widget": new PhpDebugBar.Widgets.MessagesWidget()}));
phpdebugbar.addIndicator("time", new PhpDebugBar.DebugBar.Indicator({"icon":"clock-o","tooltip":"Request Duration","link":"timeline"}), "right");
phpdebugbar.addTab("timeline", new PhpDebugBar.DebugBar.Tab({"icon":"tasks","title":"Timeline", "widget": new PhpDebugBar.Widgets.TimelineWidget()}));
phpdebugbar.addIndicator("memory", new PhpDebugBar.DebugBar.Indicator({"icon":"cogs","tooltip":"Memory Usage"}), "right");
phpdebugbar.addTab("exceptions", new PhpDebugBar.DebugBar.Tab({"icon":"bug","title":"Exceptions", "widget": new PhpDebugBar.Widgets.ExceptionsWidget()}));
phpdebugbar.addTab("views", new PhpDebugBar.DebugBar.Tab({"icon":"leaf","title":"Views", "widget": new PhpDebugBar.Widgets.TemplatesWidget()}));
phpdebugbar.addTab("route", new PhpDebugBar.DebugBar.Tab({"icon":"share","title":"Route", "widget": new PhpDebugBar.Widgets.HtmlVariableListWidget()}));
phpdebugbar.addTab("queries", new PhpDebugBar.DebugBar.Tab({"icon":"database","title":"Queries", "widget": new PhpDebugBar.Widgets.LaravelQueriesWidget()}));
phpdebugbar.addTab("models", new PhpDebugBar.DebugBar.Tab({"icon":"cubes","title":"Models", "widget": new PhpDebugBar.Widgets.TableVariableListWidget()}));
phpdebugbar.addTab("emails", new PhpDebugBar.DebugBar.Tab({"icon":"inbox","title":"Mails", "widget": new PhpDebugBar.Widgets.MailsWidget()}));
phpdebugbar.addTab("gate", new PhpDebugBar.DebugBar.Tab({"icon":"list-alt","title":"Gate", "widget": new PhpDebugBar.Widgets.MessagesWidget()}));
phpdebugbar.addTab("session", new PhpDebugBar.DebugBar.Tab({"icon":"archive","title":"Session", "widget": new PhpDebugBar.Widgets.VariableListWidget()}));
phpdebugbar.addIndicator("currentrequest", new PhpDebugBar.DebugBar.Indicator({"icon":"share","link":"request"}), "right");
phpdebugbar.setDataMap({
"request": ["request.data", {}],
"php_version": ["php.version", ],
"messages": ["messages.messages", []],
"messages:badge": ["messages.count", null],
"time": ["time.duration_str", '0ms'],
"timeline": ["time", {}],
"memory": ["memory.peak_usage_str", '0B'],
"exceptions": ["exceptions.exceptions", []],
"exceptions:badge": ["exceptions.count", null],
"views": ["views", []],
"views:badge": ["views.nb_templates", 0],
"route": ["route", {}],
"queries": ["queries", []],
"queries:badge": ["queries.nb_statements", 0],
"models": ["models", {}],
"models:badge": ["models.count", 0],
"emails": ["symfonymailer_mails.mails", []],
"emails:badge": ["symfonymailer_mails.count", null],
"gate": ["gate.messages", []],
"gate:badge": ["gate.count", null],
"session": ["session", {}],
"request:badge": ["request.badge", null],
"currentrequest": ["request.data.uri", ],
"currentrequest:tooltip": ["request.tooltip", {}]
});
phpdebugbar.restoreState();
phpdebugbar.enableAjaxHandlerTab();
phpdebugbar.ajaxHandler = new PhpDebugBar.AjaxHandler(phpdebugbar, undefined, true);
phpdebugbar.ajaxHandler.bindToFetch();
phpdebugbar.ajaxHandler.bindToXHR();
phpdebugbar.setOpenHandler(new PhpDebugBar.OpenHandler({"url":"https:\/\/saserp.tgastaging.com\/_debugbar\/open"}));
phpdebugbar.addDataSet({"__meta":{"id":"01KBMGWC886QYND7FNSWN12EKP","datetime":"2025-12-04 11:10:12","utime":1764846612.74507808685302734375,"method":"GET","uri":"\/student_assignment","ip":"223.233.73.145"},"php":{"version":"8.2.25","interface":"litespeed"},"messages":{"count":0,"messages":[]},"time":{"count":3,"start":1764846612.3976910114288330078125,"end":1764846612.7451059818267822265625,"duration":0.34741497039794921875,"duration_str":"347ms","measures":[{"label":"Booting","start":1764846612.3976910114288330078125,"relative_start":0,"end":1764846612.64894199371337890625,"relative_end":1764846612.64894199371337890625,"duration":0.2512509822845458984375,"duration_str":"251ms","memory":0,"memory_str":"0B","params":[],"collector":"time","group":null},{"label":"Application","start":1764846612.6489560604095458984375,"relative_start":0.251265048980712890625,"end":1764846612.745109081268310546875,"relative_end":3.0994415283203125e-6,"duration":0.0961530208587646484375,"duration_str":"96.15ms","memory":0,"memory_str":"0B","params":[],"collector":"time","group":null},{"label":"Routing","start":1764846612.658792972564697265625,"relative_start":0.2611019611358642578125,"end":1764846612.6744620800018310546875,"relative_end":1764846612.6744620800018310546875,"duration":0.0156691074371337890625,"duration_str":"15.67ms","memory":0,"memory_str":"0B","params":[],"collector":null,"group":null}]},"memory":{"peak_usage":31547680,"peak_usage_str":"30MB"},"exceptions":{"count":0,"exceptions":[]},"views":{"count":3,"nb_templates":3,"templates":[{"name":"student.assignment","param_count":null,"params":[],"start":1764846612.7299520969390869140625,"type":"blade","hash":"blade\/home3\/tgast4rf\/saserp.tgastaging.com\/resources\/views\/student\/assignment.blade.phpstudent.assignment","xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fresources%2Fviews%2Fstudent%2Fassignment.blade.php\u0026line=1","ajax":false,"filename":"assignment.blade.php","line":"?"}},{"name":"student.Layout.app","param_count":null,"params":[],"start":1764846612.7381250858306884765625,"type":"blade","hash":"blade\/home3\/tgast4rf\/saserp.tgastaging.com\/resources\/views\/student\/Layout\/app.blade.phpstudent.Layout.app","xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fresources%2Fviews%2Fstudent%2FLayout%2Fapp.blade.php\u0026line=1","ajax":false,"filename":"app.blade.php","line":"?"}},{"name":"student.Layout.sidebar","param_count":null,"params":[],"start":1764846612.7419140338897705078125,"type":"blade","hash":"blade\/home3\/tgast4rf\/saserp.tgastaging.com\/resources\/views\/student\/Layout\/sidebar.blade.phpstudent.Layout.sidebar","xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fresources%2Fviews%2Fstudent%2FLayout%2Fsidebar.blade.php\u0026line=1","ajax":false,"filename":"sidebar.blade.php","line":"?"}}]},"route":{"uri":"GET student_assignment","middleware":"web, XssSanitizer, lang, CheckSubscription, StudentPanel, auth.routes","controller":"App\\Http\\Controllers\\Students\\StudentController@studentAssignment\u003Ca href=\u0022phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php\u0026line=544\u0022 class=\u0022phpdebugbar-widgets-editor-link\u0022\u003E\u003C\/a\u003E","as":"student.assignment","file":"\u003Ca href=\u0022phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php\u0026line=544\u0022 onclick=\u0022\u0022 class=\u0022phpdebugbar-widgets-editor-link\u0022\u003Eapp\/Http\/Controllers\/Students\/StudentController.php:544-617\u003C\/a\u003E"},"queries":{"count":17,"nb_statements":16,"nb_visible_statements":17,"nb_excluded_statements":0,"nb_failed_statements":0,"accumulated_duration":0.0190899999999999993305355161510306061245501041412353515625,"accumulated_duration_str":"19.09ms","memory_usage":0,"memory_usage_str":null,"statements":[{"sql":"Connection Established","type":"transaction","params":[],"bindings":[],"hints":null,"show_copy":false,"backtrace":[{"index":11,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Auth\/EloquentUserProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Auth\/EloquentUserProvider.php","line":168},{"index":12,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Auth\/EloquentUserProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Auth\/EloquentUserProvider.php","line":57},{"index":13,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Auth\/SessionGuard.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Auth\/SessionGuard.php","line":159},{"index":14,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Auth\/AuthManager.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Auth\/AuthManager.php","line":57},{"index":19,"namespace":"middleware","name":"throttle","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php","line":169}],"start":1764846612.6887419223785400390625,"duration":0,"duration_str":"","memory":0,"memory_str":null,"filename":"EloquentUserProvider.php:168","source":{"index":11,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Auth\/EloquentUserProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Auth\/EloquentUserProvider.php","line":168},"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fvendor%2Flaravel%2Fframework%2Fsrc%2FIlluminate%2FAuth%2FEloquentUserProvider.php\u0026line=168","ajax":false,"filename":"EloquentUserProvider.php","line":"168"},"connection":"tgast4rf_saserpdb","explain":null,"start_percent":0,"width_percent":0},{"sql":"select * from `users` where `id` = 92 limit 1","type":"query","params":[],"bindings":[92],"hints":null,"show_copy":true,"backtrace":[{"index":15,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Auth\/EloquentUserProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Auth\/EloquentUserProvider.php","line":59},{"index":16,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Auth\/SessionGuard.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Auth\/SessionGuard.php","line":159},{"index":17,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Auth\/AuthManager.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Auth\/AuthManager.php","line":57},{"index":22,"namespace":"middleware","name":"throttle","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php","line":169},{"index":23,"namespace":"middleware","name":"throttle","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Middleware\/ThrottleRequests.php","line":62}],"start":1764846612.6962630748748779296875,"duration":0.0041600000000000005029310301551959128119051456451416015625,"duration_str":"4.16ms","memory":0,"memory_str":null,"filename":"EloquentUserProvider.php:59","source":{"index":15,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Auth\/EloquentUserProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Auth\/EloquentUserProvider.php","line":59},"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fvendor%2Flaravel%2Fframework%2Fsrc%2FIlluminate%2FAuth%2FEloquentUserProvider.php\u0026line=59","ajax":false,"filename":"EloquentUserProvider.php","line":"59"},"connection":"tgast4rf_saserpdb","explain":null,"start_percent":0,"width_percent":21.792000000000001591615728102624416351318359375},{"sql":"select * from `students` where `user_id` = 92 limit 1","type":"query","params":[],"bindings":[92],"hints":null,"show_copy":true,"backtrace":[{"index":13,"namespace":null,"name":"app\/Http\/Controllers\/Students\/StudentController.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Http\/Controllers\/Students\/StudentController.php","line":547},{"index":14,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php","line":54},{"index":15,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php","line":43},{"index":16,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","line":259},{"index":17,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","line":205}],"start":1764846612.705047130584716796875,"duration":0.0013700000000000001239286451237830988247878849506378173828125,"duration_str":"1.37ms","memory":0,"memory_str":null,"filename":"StudentController.php:547","source":{"index":13,"namespace":null,"name":"app\/Http\/Controllers\/Students\/StudentController.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Http\/Controllers\/Students\/StudentController.php","line":547},"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php\u0026line=547","ajax":false,"filename":"StudentController.php","line":"547"},"connection":"tgast4rf_saserpdb","explain":null,"start_percent":21.792000000000001591615728102624416351318359375,"width_percent":7.17699999999999960209606797434389591217041015625},{"sql":"select count(*) as aggregate from `assignments` left join `subjects` on `assignments`.`subject_id` = `subjects`.`id` where `assignments`.`grade` is null","type":"query","params":[],"bindings":[],"hints":null,"show_copy":true,"backtrace":[{"index":15,"namespace":null,"name":"app\/Http\/Controllers\/Students\/StudentController.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Http\/Controllers\/Students\/StudentController.php","line":569},{"index":16,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php","line":54},{"index":17,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php","line":43},{"index":18,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","line":259},{"index":19,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","line":205}],"start":1764846612.707396030426025390625,"duration":0.003000000000000000062450045135165055398829281330108642578125,"duration_str":"3ms","memory":0,"memory_str":null,"filename":"StudentController.php:569","source":{"index":15,"namespace":null,"name":"app\/Http\/Controllers\/Students\/StudentController.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Http\/Controllers\/Students\/StudentController.php","line":569},"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php\u0026line=569","ajax":false,"filename":"StudentController.php","line":"569"},"connection":"tgast4rf_saserpdb","explain":null,"start_percent":28.967999999999999971578290569595992565155029296875,"width_percent":15.714999999999999857891452847979962825775146484375},{"sql":"select `assignments`.*, `subjects`.`name` as `subject_name` from `assignments` left join `subjects` on `assignments`.`subject_id` = `subjects`.`id` where `assignments`.`grade` is null order by `assignments`.`assigned_date` desc limit 5 offset 0","type":"query","params":[],"bindings":[],"hints":null,"show_copy":true,"backtrace":[{"index":13,"namespace":null,"name":"app\/Http\/Controllers\/Students\/StudentController.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Http\/Controllers\/Students\/StudentController.php","line":569},{"index":14,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php","line":54},{"index":15,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php","line":43},{"index":16,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","line":259},{"index":17,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","line":205}],"start":1764846612.7109661102294921875,"duration":0.000630000000000000026124935548210714841843582689762115478515625,"duration_str":"630\u03bcs","memory":0,"memory_str":null,"filename":"StudentController.php:569","source":{"index":13,"namespace":null,"name":"app\/Http\/Controllers\/Students\/StudentController.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Http\/Controllers\/Students\/StudentController.php","line":569},"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php\u0026line=569","ajax":false,"filename":"StudentController.php","line":"569"},"connection":"tgast4rf_saserpdb","explain":null,"start_percent":44.68299999999999982946974341757595539093017578125,"width_percent":3.29999999999999982236431605997495353221893310546875},{"sql":"select count(*) as aggregate from `assignments` left join `subjects` on `assignments`.`subject_id` = `subjects`.`id` where `assignments`.`grade` is not null","type":"query","params":[],"bindings":[],"hints":null,"show_copy":true,"backtrace":[{"index":15,"namespace":null,"name":"app\/Http\/Controllers\/Students\/StudentController.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Http\/Controllers\/Students\/StudentController.php","line":578},{"index":16,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php","line":54},{"index":17,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php","line":43},{"index":18,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","line":259},{"index":19,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","line":205}],"start":1764846612.7128169536590576171875,"duration":0.000489999999999999984179321899091519298963248729705810546875,"duration_str":"490\u03bcs","memory":0,"memory_str":null,"filename":"StudentController.php:578","source":{"index":15,"namespace":null,"name":"app\/Http\/Controllers\/Students\/StudentController.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Http\/Controllers\/Students\/StudentController.php","line":578},"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php\u0026line=578","ajax":false,"filename":"StudentController.php","line":"578"},"connection":"tgast4rf_saserpdb","explain":null,"start_percent":47.98299999999999698729880037717521190643310546875,"width_percent":2.56700000000000017053025658242404460906982421875},{"sql":"select `assignments`.*, `subjects`.`name` as `subject_name` from `assignments` left join `subjects` on `assignments`.`subject_id` = `subjects`.`id` where `assignments`.`grade` is not null order by `assignments`.`assigned_date` desc limit 5 offset 0","type":"query","params":[],"bindings":[],"hints":null,"show_copy":true,"backtrace":[{"index":13,"namespace":null,"name":"app\/Http\/Controllers\/Students\/StudentController.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Http\/Controllers\/Students\/StudentController.php","line":578},{"index":14,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php","line":54},{"index":15,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php","line":43},{"index":16,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","line":259},{"index":17,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","line":205}],"start":1764846612.7138030529022216796875,"duration":0.00126000000000000005224987109642142968368716537952423095703125,"duration_str":"1.26ms","memory":0,"memory_str":null,"filename":"StudentController.php:578","source":{"index":13,"namespace":null,"name":"app\/Http\/Controllers\/Students\/StudentController.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Http\/Controllers\/Students\/StudentController.php","line":578},"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php\u0026line=578","ajax":false,"filename":"StudentController.php","line":"578"},"connection":"tgast4rf_saserpdb","explain":null,"start_percent":50.5499999999999971578290569595992565155029296875,"width_percent":6.5999999999999996447286321199499070644378662109375},{"sql":"select * from `assignment_media` where `assignment_id` in (2, 3, 1) and `student_id` = 37","type":"query","params":[],"bindings":[2,3,1,37],"hints":null,"show_copy":true,"backtrace":[{"index":12,"namespace":null,"name":"app\/Http\/Controllers\/Students\/StudentController.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Http\/Controllers\/Students\/StudentController.php","line":587},{"index":13,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Controller.php","line":54},{"index":14,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php","line":43},{"index":15,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","line":259},{"index":16,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php","line":205}],"start":1764846612.7157161235809326171875,"duration":0.002910000000000000260069743518442919594235718250274658203125,"duration_str":"2.91ms","memory":0,"memory_str":null,"filename":"StudentController.php:587","source":{"index":12,"namespace":null,"name":"app\/Http\/Controllers\/Students\/StudentController.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Http\/Controllers\/Students\/StudentController.php","line":587},"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php\u0026line=587","ajax":false,"filename":"StudentController.php","line":"587"},"connection":"tgast4rf_saserpdb","explain":null,"start_percent":57.14999999999999857891452847979962825775146484375,"width_percent":15.243999999999999772626324556767940521240234375},{"sql":"select count(*) as aggregate from `subscribes`","type":"query","params":[],"bindings":[],"hints":null,"show_copy":true,"backtrace":[{"index":18,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":111},{"index":19,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":162},{"index":22,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":177},{"index":23,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":176},{"index":24,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":147}],"start":1764846612.7233369350433349609375,"duration":0.00093000000000000005405398351143730906187556684017181396484375,"duration_str":"930\u03bcs","memory":0,"memory_str":null,"filename":"AppServiceProvider.php:111","source":{"index":18,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":111},"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php\u0026line=111","ajax":false,"filename":"AppServiceProvider.php","line":"111"},"connection":"tgast4rf_saserpdb","explain":null,"start_percent":72.394000000000005456968210637569427490234375,"width_percent":4.8719999999999998863131622783839702606201171875},{"sql":"select * from `page_sections`","type":"query","params":[],"bindings":[],"hints":null,"show_copy":true,"backtrace":[{"index":14,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":112},{"index":15,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":162},{"index":18,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":177},{"index":19,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":176},{"index":20,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":147}],"start":1764846612.7251818180084228515625,"duration":0.000790000000000000012108369862318113518995232880115509033203125,"duration_str":"790\u03bcs","memory":0,"memory_str":null,"filename":"AppServiceProvider.php:112","source":{"index":14,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":112},"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php\u0026line=112","ajax":false,"filename":"AppServiceProvider.php","line":"112"},"connection":"tgast4rf_saserpdb","explain":null,"start_percent":77.2660000000000053432813729159533977508544921875,"width_percent":4.1379999999999999005240169935859739780426025390625},{"sql":"select * from `uploads` where `uploads`.`id` in (5, 6, 7)","type":"query","params":[],"bindings":[],"hints":null,"show_copy":true,"backtrace":[{"index":19,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":112},{"index":20,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":162},{"index":23,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":177},{"index":24,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":176},{"index":25,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":147}],"start":1764846612.7284629344940185546875,"duration":0.00076000000000000004184153024056058711721561849117279052734375,"duration_str":"760\u03bcs","memory":0,"memory_str":null,"filename":"AppServiceProvider.php:112","source":{"index":19,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":112},"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php\u0026line=112","ajax":false,"filename":"AppServiceProvider.php","line":"112"},"connection":"tgast4rf_saserpdb","explain":null,"start_percent":81.40399999999999636202119290828704833984375,"width_percent":3.9809999999999998721023075631819665431976318359375},{"sql":"select count(*) as aggregate from `subscribes`","type":"query","params":[],"bindings":[],"hints":null,"show_copy":true,"backtrace":[{"index":18,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":111},{"index":19,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":162},{"index":22,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":177},{"index":23,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":176},{"index":24,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":147}],"start":1764846612.7349240779876708984375,"duration":0.000489999999999999984179321899091519298963248729705810546875,"duration_str":"490\u03bcs","memory":0,"memory_str":null,"filename":"AppServiceProvider.php:111","source":{"index":18,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":111},"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php\u0026line=111","ajax":false,"filename":"AppServiceProvider.php","line":"111"},"connection":"tgast4rf_saserpdb","explain":null,"start_percent":85.3850000000000051159076974727213382720947265625,"width_percent":2.56700000000000017053025658242404460906982421875},{"sql":"select * from `page_sections`","type":"query","params":[],"bindings":[],"hints":null,"show_copy":true,"backtrace":[{"index":14,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":112},{"index":15,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":162},{"index":18,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":177},{"index":19,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":176},{"index":20,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":147}],"start":1764846612.7359859943389892578125,"duration":0.0005200000000000000628663787693994891014881432056427001953125,"duration_str":"520\u03bcs","memory":0,"memory_str":null,"filename":"AppServiceProvider.php:112","source":{"index":14,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":112},"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php\u0026line=112","ajax":false,"filename":"AppServiceProvider.php","line":"112"},"connection":"tgast4rf_saserpdb","explain":null,"start_percent":87.951999999999998181010596454143524169921875,"width_percent":2.724000000000000198951966012828052043914794921875},{"sql":"select * from `uploads` where `uploads`.`id` in (5, 6, 7)","type":"query","params":[],"bindings":[],"hints":null,"show_copy":true,"backtrace":[{"index":19,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":112},{"index":20,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":162},{"index":23,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":177},{"index":24,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":176},{"index":25,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":147}],"start":1764846612.737185955047607421875,"duration":0.0004299999999999999894355340313012447950313799083232879638671875,"duration_str":"430\u03bcs","memory":0,"memory_str":null,"filename":"AppServiceProvider.php:112","source":{"index":19,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":112},"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php\u0026line=112","ajax":false,"filename":"AppServiceProvider.php","line":"112"},"connection":"tgast4rf_saserpdb","explain":null,"start_percent":90.6760000000000019326762412674725055694580078125,"width_percent":2.25199999999999977973175191436894237995147705078125},{"sql":"select count(*) as aggregate from `subscribes`","type":"query","params":[],"bindings":[],"hints":null,"show_copy":true,"backtrace":[{"index":18,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":111},{"index":19,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":162},{"index":22,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":177},{"index":23,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":176},{"index":24,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":147}],"start":1764846612.7386958599090576171875,"duration":0.0003899999999999999929396754527743951257434673607349395751953125,"duration_str":"390\u03bcs","memory":0,"memory_str":null,"filename":"AppServiceProvider.php:111","source":{"index":18,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":111},"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php\u0026line=111","ajax":false,"filename":"AppServiceProvider.php","line":"111"},"connection":"tgast4rf_saserpdb","explain":null,"start_percent":92.9279999999999972715158946812152862548828125,"width_percent":2.04300000000000014921397450962103903293609619140625},{"sql":"select * from `page_sections`","type":"query","params":[],"bindings":[],"hints":null,"show_copy":true,"backtrace":[{"index":14,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":112},{"index":15,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":162},{"index":18,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":177},{"index":19,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":176},{"index":20,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":147}],"start":1764846612.739510059356689453125,"duration":0.0005000000000000000104083408558608425664715468883514404296875,"duration_str":"500\u03bcs","memory":0,"memory_str":null,"filename":"AppServiceProvider.php:112","source":{"index":14,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":112},"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php\u0026line=112","ajax":false,"filename":"AppServiceProvider.php","line":"112"},"connection":"tgast4rf_saserpdb","explain":null,"start_percent":94.97100000000000363797880709171295166015625,"width_percent":2.619000000000000216715534406830556690692901611328125},{"sql":"select * from `uploads` where `uploads`.`id` in (5, 6, 7)","type":"query","params":[],"bindings":[],"hints":null,"show_copy":true,"backtrace":[{"index":19,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":112},{"index":20,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":162},{"index":23,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Concerns\/ManagesEvents.php","line":177},{"index":24,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":176},{"index":25,"namespace":null,"name":"vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php","line":147}],"start":1764846612.7408611774444580078125,"duration":0.000460000000000000013912482277333992897183634340763092041015625,"duration_str":"460\u03bcs","memory":0,"memory_str":null,"filename":"AppServiceProvider.php:112","source":{"index":19,"namespace":null,"name":"app\/Providers\/AppServiceProvider.php","file":"\/home3\/tgast4rf\/saserp.tgastaging.com\/app\/Providers\/AppServiceProvider.php","line":112},"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php\u0026line=112","ajax":false,"filename":"AppServiceProvider.php","line":"112"},"connection":"tgast4rf_saserpdb","explain":null,"start_percent":97.590000000000003410605131648480892181396484375,"width_percent":2.410000000000000142108547152020037174224853515625}]},"models":{"data":{"App\\Models\\WebsiteSetup\\PageSections":{"retrieved":36,"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FModels%2FWebsiteSetup%2FPageSections.php\u0026line=1","ajax":false,"filename":"PageSections.php","line":"?"}},"App\\Models\\Upload":{"retrieved":9,"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FModels%2FUpload.php\u0026line=1","ajax":false,"filename":"Upload.php","line":"?"}},"App\\Models\\User":{"retrieved":1,"xdebug_link":{"url":"phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FModels%2FUser.php\u0026line=1","ajax":false,"filename":"User.php","line":"?"}}},"count":46,"key_map":{"retrieved":"Retrieved","created":"Created","updated":"Updated","deleted":"Deleted"},"is_counter":true,"badges":{"retrieved":46}},"symfonymailer_mails":{"count":0,"mails":[]},"gate":{"count":0,"messages":[]},"session":{"_token":"NHn738kSkVp4duFVd2zQ7BHpv5g6HPluJUZC2ls1","_flash":"array:2 [\n  \u0022old\u0022 =\u003E []\n  \u0022new\u0022 =\u003E []\n]","locale":"en","_previous":"array:1 [\n  \u0022url\u0022 =\u003E \u0022https:\/\/saserp.tgastaging.com\/student_dashboard\u0022\n]","login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d":"92"},"request":{"data":{"status":"200 OK","full_url":"https:\/\/saserp.tgastaging.com\/student_assignment","action_name":"student.assignment","controller_action":"App\\Http\\Controllers\\Students\\StudentController@studentAssignment","uri":"GET student_assignment","controller":"App\\Http\\Controllers\\Students\\StudentController@studentAssignment\u003Ca href=\u0022phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php\u0026line=544\u0022 class=\u0022phpdebugbar-widgets-editor-link\u0022\u003E\u003C\/a\u003E","file":"\u003Ca href=\u0022phpstorm:\/\/open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php\u0026line=544\u0022 onclick=\u0022\u0022 class=\u0022phpdebugbar-widgets-editor-link\u0022\u003Eapp\/Http\/Controllers\/Students\/StudentController.php:544-617\u003C\/a\u003E","middleware":"web, web, XssSanitizer, lang, CheckSubscription, StudentPanel, auth.routes","duration":"348ms","peak_memory":"32MB","response":"text\/html; charset=UTF-8","request_format":"html","request_query":"\u003Cpre class=sf-dump id=sf-dump-1088426653 data-indent-pad=\u0022  \u0022\u003E[]\n\u003C\/pre\u003E\u003Cscript\u003ESfdump(\u0022sf-dump-1088426653\u0022, {\u0022maxDepth\u0022:0})\u003C\/script\u003E\n","request_request":"\u003Cpre class=sf-dump id=sf-dump-1513376007 data-indent-pad=\u0022  \u0022\u003E[]\n\u003C\/pre\u003E\u003Cscript\u003ESfdump(\u0022sf-dump-1513376007\u0022, {\u0022maxDepth\u0022:0})\u003C\/script\u003E\n","request_headers":"\u003Cpre class=sf-dump id=sf-dump-1180573468 data-indent-pad=\u0022  \u0022\u003E\u003Cspan class=sf-dump-note\u003Earray:22\u003C\/span\u003E [\u003Csamp data-depth=1 class=sf-dump-expanded\u003E\n  \u0022\u003Cspan class=sf-dump-key\u003Eaccept\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u0022135 characters\u0022\u003Etext\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/avif,image\/webp,image\/apng,*\/*;q=0.8,application\/signed-exchange;v=b3;q=0.7\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Eaccept-encoding\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u002223 characters\u0022\u003Egzip, deflate, br, zstd\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Eaccept-language\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u002214 characters\u0022\u003Een-US,en;q=0.9\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Econnection\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Econtent-length\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str\u003E0\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Ecookie\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u0022411 characters\u0022\u003Eischool_session=gvDVQ7VHTHmwHH1kGcrAjpPOFD6Anug8Epa0CTD4; XSRF-TOKEN=eyJpdiI6InRZMU1MR2h4aGQ4Wks3VDBvTGxEMlE9PSIsInZhbHVlIjoiakx0Yk5wbnMxQlpKc1M1QTFGQ2c2UW5HZnRRNnhrSmRaUWp1NzVaNXMwYWVvZEh0aVhuR1hZSjNScmljVVFuWHFRd1o1R2JuUVRiblcwWjFsWTIvYTM0TTlmWkNLT1N0TzRVWWc1WW1wanVjNWozQkdhbzNYaW5mbGt4SnFPS0MiLCJtYWMiOiJlYTk0NDhkMjhhYjQyMGJhMjYzMWFlZWM5ZDg5MjgxYzc3MTE2MDI2NTQ1NGE5ZDQwY2IxMDAzYmNlYjkxYTUyIiwidGFnIjoiIn0%3D\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Ehost\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u002221 characters\u0022\u003Esaserp.tgastaging.com\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Ereferer\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u002247 characters\u0022\u003Ehttps:\/\/saserp.tgastaging.com\/student_dashboard\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Euser-agent\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u0022111 characters\u0022\u003EMozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/142.0.0.0 Safari\/537.36\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Ex-forwarded-for\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u002214 characters\u0022\u003E223.233.73.145\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Ex-real-ip\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u002214 characters\u0022\u003E223.233.73.145\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Ex-eig-origin\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u002213 characters\u0022\u003E119.18.54.161\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Ex-cache-req\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str\u003E1\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Esec-ch-ua\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u002265 characters\u0022\u003E\u0026quot;Chromium\u0026quot;;v=\u0026quot;142\u0026quot;, \u0026quot;Google Chrome\u0026quot;;v=\u0026quot;142\u0026quot;, \u0026quot;Not_A Brand\u0026quot;;v=\u0026quot;99\u0026quot;\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Esec-ch-ua-mobile\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u00222 characters\u0022\u003E?0\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Esec-ch-ua-platform\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u00229 characters\u0022\u003E\u0026quot;Windows\u0026quot;\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Eupgrade-insecure-requests\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str\u003E1\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Esec-fetch-site\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u002211 characters\u0022\u003Esame-origin\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Esec-fetch-mode\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u00228 characters\u0022\u003Enavigate\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Esec-fetch-user\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u00222 characters\u0022\u003E?1\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Esec-fetch-dest\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u00228 characters\u0022\u003Edocument\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Epriority\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u00226 characters\u0022\u003Eu=0, i\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n\u003C\/samp\u003E]\n\u003C\/pre\u003E\u003Cscript\u003ESfdump(\u0022sf-dump-1180573468\u0022, {\u0022maxDepth\u0022:0})\u003C\/script\u003E\n","request_cookies":"\u003Cpre class=sf-dump id=sf-dump-759354035 data-indent-pad=\u0022  \u0022\u003E\u003Cspan class=sf-dump-note\u003Earray:2\u003C\/span\u003E [\u003Csamp data-depth=1 class=sf-dump-expanded\u003E\n  \u0022\u003Cspan class=sf-dump-key\u003Eischool_session\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-const\u003Enull\u003C\/span\u003E\n  \u0022\u003Cspan class=sf-dump-key\u003EXSRF-TOKEN\u003C\/span\u003E\u0022 =\u003E \u0022\u003Cspan class=sf-dump-str title=\u002240 characters\u0022\u003ENHn738kSkVp4duFVd2zQ7BHpv5g6HPluJUZC2ls1\u003C\/span\u003E\u0022\n\u003C\/samp\u003E]\n\u003C\/pre\u003E\u003Cscript\u003ESfdump(\u0022sf-dump-759354035\u0022, {\u0022maxDepth\u0022:0})\u003C\/script\u003E\n","response_headers":"\u003Cpre class=sf-dump id=sf-dump-16315669 data-indent-pad=\u0022  \u0022\u003E\u003Cspan class=sf-dump-note\u003Earray:3\u003C\/span\u003E [\u003Csamp data-depth=1 class=sf-dump-expanded\u003E\n  \u0022\u003Cspan class=sf-dump-key\u003Econtent-type\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u002224 characters\u0022\u003Etext\/html; charset=UTF-8\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Ecache-control\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u002217 characters\u0022\u003Eno-cache, private\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Edate\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u003Cspan class=sf-dump-index\u003E0\u003C\/span\u003E =\u003E \u0022\u003Cspan class=sf-dump-str title=\u002229 characters\u0022\u003EThu, 04 Dec 2025 11:10:12 GMT\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n\u003C\/samp\u003E]\n\u003C\/pre\u003E\u003Cscript\u003ESfdump(\u0022sf-dump-16315669\u0022, {\u0022maxDepth\u0022:0})\u003C\/script\u003E\n","session_attributes":"\u003Cpre class=sf-dump id=sf-dump-2030287089 data-indent-pad=\u0022  \u0022\u003E\u003Cspan class=sf-dump-note\u003Earray:5\u003C\/span\u003E [\u003Csamp data-depth=1 class=sf-dump-expanded\u003E\n  \u0022\u003Cspan class=sf-dump-key\u003E_token\u003C\/span\u003E\u0022 =\u003E \u0022\u003Cspan class=sf-dump-str title=\u002240 characters\u0022\u003ENHn738kSkVp4duFVd2zQ7BHpv5g6HPluJUZC2ls1\u003C\/span\u003E\u0022\n  \u0022\u003Cspan class=sf-dump-key\u003E_flash\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:2\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u0022\u003Cspan class=sf-dump-key\u003Eold\u003C\/span\u003E\u0022 =\u003E []\n    \u0022\u003Cspan class=sf-dump-key\u003Enew\u003C\/span\u003E\u0022 =\u003E []\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Elocale\u003C\/span\u003E\u0022 =\u003E \u0022\u003Cspan class=sf-dump-str title=\u00222 characters\u0022\u003Een\u003C\/span\u003E\u0022\n  \u0022\u003Cspan class=sf-dump-key\u003E_previous\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-note\u003Earray:1\u003C\/span\u003E [\u003Csamp data-depth=2 class=sf-dump-compact\u003E\n    \u0022\u003Cspan class=sf-dump-key\u003Eurl\u003C\/span\u003E\u0022 =\u003E \u0022\u003Cspan class=sf-dump-str title=\u002247 characters\u0022\u003Ehttps:\/\/saserp.tgastaging.com\/student_dashboard\u003C\/span\u003E\u0022\n  \u003C\/samp\u003E]\n  \u0022\u003Cspan class=sf-dump-key\u003Elogin_web_59ba36addc2b2f9401580f014c7f58ea4e30989d\u003C\/span\u003E\u0022 =\u003E \u003Cspan class=sf-dump-num\u003E92\u003C\/span\u003E\n\u003C\/samp\u003E]\n\u003C\/pre\u003E\u003Cscript\u003ESfdump(\u0022sf-dump-2030287089\u0022, {\u0022maxDepth\u0022:0})\u003C\/script\u003E\n"},"tooltip":{"status":"200 OK","full_url":"https:\/\/saserp.tgastaging.com\/student_assignment","action_name":"student.assignment","controller_action":"App\\Http\\Controllers\\Students\\StudentController@studentAssignment"},"badge":null}}, "01KBMGWC886QYND7FNSWN12EKP");

</script><div class="phpdebugbar phpdebugbar-minimized phpdebugbar-closed" data-bodymarginbottom="true" data-theme="light" data-openbtnposition="bottomLeft" data-hideemptytabs="false"><div class="phpdebugbar-drag-capture"></div><div class="phpdebugbar-resize-handle" style="display: none;"></div><div class="phpdebugbar-header" style="display: none;"><a class="phpdebugbar-restore-btn"></a><div class="phpdebugbar-header-left"><a class="phpdebugbar-tab" data-empty="false" data-collector="request"><i class="phpdebugbar-fa phpdebugbar-fa-tags"></i><span class="phpdebugbar-text">Request</span><span class="phpdebugbar-badge"></span></a><a class="phpdebugbar-tab" data-empty="true" data-collector="messages"><i class="phpdebugbar-fa phpdebugbar-fa-list-alt"></i><span class="phpdebugbar-text">Messages</span><span class="phpdebugbar-badge"></span></a><a class="phpdebugbar-tab" data-empty="false" data-collector="timeline"><i class="phpdebugbar-fa phpdebugbar-fa-tasks"></i><span class="phpdebugbar-text">Timeline</span><span class="phpdebugbar-badge"></span></a><a class="phpdebugbar-tab" data-empty="true" data-collector="exceptions"><i class="phpdebugbar-fa phpdebugbar-fa-bug"></i><span class="phpdebugbar-text">Exceptions</span><span class="phpdebugbar-badge"></span></a><a class="phpdebugbar-tab" data-empty="false" data-collector="views"><i class="phpdebugbar-fa phpdebugbar-fa-leaf"></i><span class="phpdebugbar-text">Views</span><span class="phpdebugbar-badge phpdebugbar-visible">3</span></a><a class="phpdebugbar-tab" data-empty="false" data-collector="route"><i class="phpdebugbar-fa phpdebugbar-fa-share"></i><span class="phpdebugbar-text">Route</span><span class="phpdebugbar-badge"></span></a><a class="phpdebugbar-tab" data-empty="false" data-collector="queries"><i class="phpdebugbar-fa phpdebugbar-fa-database"></i><span class="phpdebugbar-text">Queries</span><span class="phpdebugbar-badge phpdebugbar-visible">16</span></a><a class="phpdebugbar-tab" data-empty="false" data-collector="models"><i class="phpdebugbar-fa phpdebugbar-fa-cubes"></i><span class="phpdebugbar-text">Models</span><span class="phpdebugbar-badge phpdebugbar-visible">46</span></a><a class="phpdebugbar-tab" data-empty="true" data-collector="emails"><i class="phpdebugbar-fa phpdebugbar-fa-inbox"></i><span class="phpdebugbar-text">Mails</span><span class="phpdebugbar-badge"></span></a><a class="phpdebugbar-tab" data-empty="true" data-collector="gate"><i class="phpdebugbar-fa phpdebugbar-fa-list-alt"></i><span class="phpdebugbar-text">Gate</span><span class="phpdebugbar-badge"></span></a><a class="phpdebugbar-tab" data-empty="false" data-collector="session"><i class="phpdebugbar-fa phpdebugbar-fa-archive"></i><span class="phpdebugbar-text">Session</span><span class="phpdebugbar-badge"></span></a></div><div class="phpdebugbar-header-right"><a class="phpdebugbar-close-btn"></a><a class="phpdebugbar-minimize-btn"></a><a class="phpdebugbar-tab phpdebugbar-tab-settings" data-collector="__settings"><i class="phpdebugbar-fa phpdebugbar-fa-sliders"></i><span class="phpdebugbar-text">Settings</span><span class="phpdebugbar-badge"></span></a><a class="phpdebugbar-maximize-btn"></a><a class="phpdebugbar-open-btn" style=""></a><a class="phpdebugbar-tab phpdebugbar-tab-history" data-collector="__datasets" style="" data-empty="false"><i class="phpdebugbar-fa phpdebugbar-fa-history"></i><span class="phpdebugbar-text">Request history</span><span class="phpdebugbar-badge"></span></a><select class="phpdebugbar-datasets-switcher" name="datasets-switcher"><option value="01KBMGWC886QYND7FNSWN12EKP">#1 student_assignment (11:10:12)</option></select><span class="phpdebugbar-indicator"><i class="phpdebugbar-fa phpdebugbar-fa-code"></i><span class="phpdebugbar-text">8.2.25</span><span class="phpdebugbar-tooltip">PHP Version</span></span><span class="phpdebugbar-indicator" style="cursor: pointer;"><i class="phpdebugbar-fa phpdebugbar-fa-clock-o"></i><span class="phpdebugbar-text">347ms</span><span class="phpdebugbar-tooltip">Request Duration</span></span><span class="phpdebugbar-indicator"><i class="phpdebugbar-fa phpdebugbar-fa-cogs"></i><span class="phpdebugbar-text">30MB</span><span class="phpdebugbar-tooltip">Memory Usage</span></span><span class="phpdebugbar-indicator" style="cursor: pointer;"><i class="phpdebugbar-fa phpdebugbar-fa-share"></i><span class="phpdebugbar-text">GET student_assignment</span><span class="phpdebugbar-tooltip"><dl><dt>status</dt><dd>200 OK</dd><dt>full_url</dt><dd>https://saserp.tgastaging.com/student_assignment</dd><dt>action_name</dt><dd>student.assignment</dd><dt>controller_action</dt><dd>App\Http\Controllers\Students\StudentController@studentAssignment</dd></dl></span></span></div></div><div class="phpdebugbar-body" style="height: 40px; display: none;"><div class="phpdebugbar-panel" data-collector="__settings"><form class="phpdebugbar-settings"><div class="phpdebugbar-form-row"><div class="phpdebugbar-form-label">Theme</div><div class="phpdebugbar-form-input"><select><option value="auto">Auto (System preference)</option><option value="light">Light</option><option value="dark">Dark</option></select></div></div><div class="phpdebugbar-form-row"><div class="phpdebugbar-form-label">Open Button Position</div><div class="phpdebugbar-form-input"><select><option value="bottomLeft">Bottom Left</option><option value="bottomRight">Bottom Right</option><option value="topLeft">Top Left</option><option value="topRight">Top Right</option></select></div></div><div class="phpdebugbar-form-row"><div class="phpdebugbar-form-label">Hide Empty Tabs</div><div class="phpdebugbar-form-input"><label><input type="checkbox">Hide empty tabs until they have data</label></div></div><div class="phpdebugbar-form-row"><div class="phpdebugbar-form-label">Autoshow</div><div class="phpdebugbar-form-input"><label><input type="checkbox">Automatically show new incoming Ajax requests</label></div></div><div class="phpdebugbar-form-row"><div class="phpdebugbar-form-label">Reset to defaults</div><div class="phpdebugbar-form-input"><button>Reset settings</button></div></div></form></div><div class="phpdebugbar-panel" data-collector="request"><dl class="phpdebugbar-widgets-kvlist phpdebugbar-widgets-htmlvarlist"><dt class="phpdebugbar-widgets-key"><span title="status">status</span></dt><dd class="phpdebugbar-widgets-value">200 OK</dd><dt class="phpdebugbar-widgets-key"><span title="full_url">full_url</span></dt><dd class="phpdebugbar-widgets-value">https://saserp.tgastaging.com/student_assignment</dd><dt class="phpdebugbar-widgets-key"><span title="action_name">action_name</span></dt><dd class="phpdebugbar-widgets-value">student.assignment</dd><dt class="phpdebugbar-widgets-key"><span title="controller_action">controller_action</span></dt><dd class="phpdebugbar-widgets-value">App\Http\Controllers\Students\StudentController@studentAssignment</dd><dt class="phpdebugbar-widgets-key"><span title="uri">uri</span></dt><dd class="phpdebugbar-widgets-value">GET student_assignment</dd><dt class="phpdebugbar-widgets-key"><span title="controller">controller</span></dt><dd class="phpdebugbar-widgets-value">App\Http\Controllers\Students\StudentController@studentAssignment<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php&amp;line=544" class="phpdebugbar-widgets-editor-link"></a></dd><dt class="phpdebugbar-widgets-key"><span title="file">file</span></dt><dd class="phpdebugbar-widgets-value"><a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php&amp;line=544" onclick="" class="phpdebugbar-widgets-editor-link">app/Http/Controllers/Students/StudentController.php:544-617</a></dd><dt class="phpdebugbar-widgets-key"><span title="middleware">middleware</span></dt><dd class="phpdebugbar-widgets-value">web, web, XssSanitizer, lang, CheckSubscription, StudentPanel, auth.routes</dd><dt class="phpdebugbar-widgets-key"><span title="duration">duration</span></dt><dd class="phpdebugbar-widgets-value">348ms</dd><dt class="phpdebugbar-widgets-key"><span title="peak_memory">peak_memory</span></dt><dd class="phpdebugbar-widgets-value">32MB</dd><dt class="phpdebugbar-widgets-key"><span title="response">response</span></dt><dd class="phpdebugbar-widgets-value">text/html; charset=UTF-8</dd><dt class="phpdebugbar-widgets-key"><span title="request_format">request_format</span></dt><dd class="phpdebugbar-widgets-value">html</dd><dt class="phpdebugbar-widgets-key"><span title="request_query">request_query</span></dt><dd class="phpdebugbar-widgets-value"><pre class="sf-dump" id="sf-dump-1088426653" data-indent-pad="  ">[]
</pre><script>Sfdump("sf-dump-1088426653", {"maxDepth":0})</script>
</dd><dt class="phpdebugbar-widgets-key"><span title="request_request">request_request</span></dt><dd class="phpdebugbar-widgets-value"><pre class="sf-dump" id="sf-dump-1513376007" data-indent-pad="  ">[]
</pre><script>Sfdump("sf-dump-1513376007", {"maxDepth":0})</script>
</dd><dt class="phpdebugbar-widgets-key"><span title="request_headers">request_headers</span></dt><dd class="phpdebugbar-widgets-value"><pre class="sf-dump" id="sf-dump-1180573468" data-indent-pad="  " tabindex="0"><div class="sf-dump-search-wrapper sf-dump-search-hidden"> <input type="text" class="sf-dump-search-input"> <span class="sf-dump-search-count">0 of 0</span> <button type="button" class="sf-dump-search-input-previous" tabindex="-1"> <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 1331l-166 165q-19 19-45 19t-45-19L896 965l-531 531q-19 19-45 19t-45-19l-166-165q-19-19-19-45.5t19-45.5l742-741q19-19 45-19t45 19l742 741q19 19 19 45.5t-19 45.5z"></path></svg> </button> <button type="button" class="sf-dump-search-input-next" tabindex="-1"> <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 808l-742 741q-19 19-45 19t-45-19L109 808q-19-19-19-45.5t19-45.5l166-165q19-19 45-19t45 19l531 531 531-531q19-19 45-19t45 19l166 165q19 19 19 45.5t-19 45.5z"></path></svg> </button> </div><span class="sf-dump-note">array:22</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▼</span></a><samp data-depth="1" class="sf-dump-expanded">
  "<span class="sf-dump-key">accept</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="135 characters">text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7</span>"
  </samp>]
  "<span class="sf-dump-key">accept-encoding</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="23 characters">gzip, deflate, br, zstd</span>"
  </samp>]
  "<span class="sf-dump-key">accept-language</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="14 characters">en-US,en;q=0.9</span>"
  </samp>]
  "<span class="sf-dump-key">connection</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; ""
  </samp>]
  "<span class="sf-dump-key">content-length</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str">0</span>"
  </samp>]
  "<span class="sf-dump-key">cookie</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str sf-dump-str-collapse" title="411 characters"><span class="sf-dump-str-collapse">ischool_session=gvDVQ7VHTHmwHH1kGcrAjpPOFD6Anug8Epa0CTD4; XSRF-TOKEN=eyJpdiI6InRZMU1MR2h4aGQ4Wks3VDBvTGxEMlE9PSIsInZhbHVlIjoiakx0Yk5wbnMxQlpKc1M1QTFGQ2c2UW5HZnRRNnhrSmRaUWp1NzVaNXMwYWVvZEh0aVhuR1hZSjNScmljVVFuWHFRd1o1R2JuUVRiblcwWjFsWTIvYTM0TTlmWkNLT1N0TzRVWWc1WW1wanVjNWozQkdhbzNYaW5mbGt4SnFPS0MiLCJtYWMiOiJlYTk0NDhkMjhhYjQyMGJhMjYzMWFlZWM5ZDg5MjgxYzc3MTE2MDI2NTQ1NGE5ZDQwY2IxMDAzYmNlYjkxYTUyIiwidGFnIjoiIn0%3D<a class="sf-dump-ref sf-dump-str-toggle" title="Collapse"> ◀</a></span><span class="sf-dump-str-expand">ischool_session=gvDVQ7VHTHmwHH1kGcrAjpPOFD6Anug8Epa0CTD4; XSRF-TOKEN=eyJpdiI6InRZMU1MR2h4aGQ4Wks3VDBvTGxEMlE9PSIsInZhbHVlIjoiakx0Yk5wbnMxQlpKc1M1QTFGQ2c2UW5HZnR<a class="sf-dump-ref sf-dump-str-toggle" title="251 remaining characters"> ▶</a></span></span>"
  </samp>]
  "<span class="sf-dump-key">host</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="21 characters">saserp.tgastaging.com</span>"
  </samp>]
  "<span class="sf-dump-key">referer</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="47 characters">https://saserp.tgastaging.com/student_dashboard</span>"
  </samp>]
  "<span class="sf-dump-key">user-agent</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="111 characters">Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36</span>"
  </samp>]
  "<span class="sf-dump-key">x-forwarded-for</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="14 characters">223.233.73.145</span>"
  </samp>]
  "<span class="sf-dump-key">x-real-ip</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="14 characters">223.233.73.145</span>"
  </samp>]
  "<span class="sf-dump-key">x-eig-origin</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="13 characters">119.18.54.161</span>"
  </samp>]
  "<span class="sf-dump-key">x-cache-req</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str">1</span>"
  </samp>]
  "<span class="sf-dump-key">sec-ch-ua</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="65 characters">"Chromium";v="142", "Google Chrome";v="142", "Not_A Brand";v="99"</span>"
  </samp>]
  "<span class="sf-dump-key">sec-ch-ua-mobile</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="2 characters">?0</span>"
  </samp>]
  "<span class="sf-dump-key">sec-ch-ua-platform</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="9 characters">"Windows"</span>"
  </samp>]
  "<span class="sf-dump-key">upgrade-insecure-requests</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str">1</span>"
  </samp>]
  "<span class="sf-dump-key">sec-fetch-site</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="11 characters">same-origin</span>"
  </samp>]
  "<span class="sf-dump-key">sec-fetch-mode</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="8 characters">navigate</span>"
  </samp>]
  "<span class="sf-dump-key">sec-fetch-user</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="2 characters">?1</span>"
  </samp>]
  "<span class="sf-dump-key">sec-fetch-dest</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="8 characters">document</span>"
  </samp>]
  "<span class="sf-dump-key">priority</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="6 characters">u=0, i</span>"
  </samp>]
</samp>]
</pre><script>Sfdump("sf-dump-1180573468", {"maxDepth":0})</script>
</dd><dt class="phpdebugbar-widgets-key"><span title="request_cookies">request_cookies</span></dt><dd class="phpdebugbar-widgets-value"><pre class="sf-dump" id="sf-dump-759354035" data-indent-pad="  " tabindex="0"><div class="sf-dump-search-wrapper sf-dump-search-hidden"> <input type="text" class="sf-dump-search-input"> <span class="sf-dump-search-count">0 of 0</span> <button type="button" class="sf-dump-search-input-previous" tabindex="-1"> <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 1331l-166 165q-19 19-45 19t-45-19L896 965l-531 531q-19 19-45 19t-45-19l-166-165q-19-19-19-45.5t19-45.5l742-741q19-19 45-19t45 19l742 741q19 19 19 45.5t-19 45.5z"></path></svg> </button> <button type="button" class="sf-dump-search-input-next" tabindex="-1"> <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 808l-742 741q-19 19-45 19t-45-19L109 808q-19-19-19-45.5t19-45.5l166-165q19-19 45-19t45 19l531 531 531-531q19-19 45-19t45 19l166 165q19 19 19 45.5t-19 45.5z"></path></svg> </button> </div><span class="sf-dump-note">array:2</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▼</span></a><samp data-depth="1" class="sf-dump-expanded">
  "<span class="sf-dump-key">ischool_session</span>" =&gt; <span class="sf-dump-const">null</span>
  "<span class="sf-dump-key">XSRF-TOKEN</span>" =&gt; "<span class="sf-dump-str" title="40 characters">NHn738kSkVp4duFVd2zQ7BHpv5g6HPluJUZC2ls1</span>"
</samp>]
</pre><script>Sfdump("sf-dump-759354035", {"maxDepth":0})</script>
</dd><dt class="phpdebugbar-widgets-key"><span title="response_headers">response_headers</span></dt><dd class="phpdebugbar-widgets-value"><pre class="sf-dump" id="sf-dump-16315669" data-indent-pad="  " tabindex="0"><div class="sf-dump-search-wrapper sf-dump-search-hidden"> <input type="text" class="sf-dump-search-input"> <span class="sf-dump-search-count">0 of 0</span> <button type="button" class="sf-dump-search-input-previous" tabindex="-1"> <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 1331l-166 165q-19 19-45 19t-45-19L896 965l-531 531q-19 19-45 19t-45-19l-166-165q-19-19-19-45.5t19-45.5l742-741q19-19 45-19t45 19l742 741q19 19 19 45.5t-19 45.5z"></path></svg> </button> <button type="button" class="sf-dump-search-input-next" tabindex="-1"> <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 808l-742 741q-19 19-45 19t-45-19L109 808q-19-19-19-45.5t19-45.5l166-165q19-19 45-19t45 19l531 531 531-531q19-19 45-19t45 19l166 165q19 19 19 45.5t-19 45.5z"></path></svg> </button> </div><span class="sf-dump-note">array:3</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▼</span></a><samp data-depth="1" class="sf-dump-expanded">
  "<span class="sf-dump-key">content-type</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="24 characters">text/html; charset=UTF-8</span>"
  </samp>]
  "<span class="sf-dump-key">cache-control</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="17 characters">no-cache, private</span>"
  </samp>]
  "<span class="sf-dump-key">date</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    <span class="sf-dump-index">0</span> =&gt; "<span class="sf-dump-str" title="29 characters">Thu, 04 Dec 2025 11:10:12 GMT</span>"
  </samp>]
</samp>]
</pre><script>Sfdump("sf-dump-16315669", {"maxDepth":0})</script>
</dd><dt class="phpdebugbar-widgets-key"><span title="session_attributes">session_attributes</span></dt><dd class="phpdebugbar-widgets-value"><pre class="sf-dump" id="sf-dump-2030287089" data-indent-pad="  " tabindex="0"><div class="sf-dump-search-wrapper sf-dump-search-hidden"> <input type="text" class="sf-dump-search-input"> <span class="sf-dump-search-count">0 of 0</span> <button type="button" class="sf-dump-search-input-previous" tabindex="-1"> <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 1331l-166 165q-19 19-45 19t-45-19L896 965l-531 531q-19 19-45 19t-45-19l-166-165q-19-19-19-45.5t19-45.5l742-741q19-19 45-19t45 19l742 741q19 19 19 45.5t-19 45.5z"></path></svg> </button> <button type="button" class="sf-dump-search-input-next" tabindex="-1"> <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 808l-742 741q-19 19-45 19t-45-19L109 808q-19-19-19-45.5t19-45.5l166-165q19-19 45-19t45 19l531 531 531-531q19-19 45-19t45 19l166 165q19 19 19 45.5t-19 45.5z"></path></svg> </button> </div><span class="sf-dump-note">array:5</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▼</span></a><samp data-depth="1" class="sf-dump-expanded">
  "<span class="sf-dump-key">_token</span>" =&gt; "<span class="sf-dump-str" title="40 characters">NHn738kSkVp4duFVd2zQ7BHpv5g6HPluJUZC2ls1</span>"
  "<span class="sf-dump-key">_flash</span>" =&gt; <span class="sf-dump-note">array:2</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    "<span class="sf-dump-key">old</span>" =&gt; []
    "<span class="sf-dump-key">new</span>" =&gt; []
  </samp>]
  "<span class="sf-dump-key">locale</span>" =&gt; "<span class="sf-dump-str" title="2 characters">en</span>"
  "<span class="sf-dump-key">_previous</span>" =&gt; <span class="sf-dump-note">array:1</span> [<a class="sf-dump-ref sf-dump-toggle" title="[Ctrl+click] Expand all children"><span>▶</span></a><samp data-depth="2" class="sf-dump-compact">
    "<span class="sf-dump-key">url</span>" =&gt; "<span class="sf-dump-str" title="47 characters">https://saserp.tgastaging.com/student_dashboard</span>"
  </samp>]
  "<span class="sf-dump-key">login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d</span>" =&gt; <span class="sf-dump-num">92</span>
</samp>]
</pre><script>Sfdump("sf-dump-2030287089", {"maxDepth":0})</script>
</dd></dl></div><div class="phpdebugbar-panel" data-collector="messages"><div class="phpdebugbar-widgets-messages"><ul class="phpdebugbar-widgets-list"></ul><div class="phpdebugbar-widgets-toolbar"><i class="phpdebugbar-fa phpdebugbar-fa-search"></i><input type="text" name="search" aria-label="Search" placeholder="Search"><a class="phpdebugbar-widgets-filter" style="visibility: hidden;"></a></div></div></div><div class="phpdebugbar-panel" data-collector="timeline"><ul class="phpdebugbar-widgets-timeline"><li><div class="phpdebugbar-widgets-measure"><span class="phpdebugbar-widgets-value" style="left: 0%; width: 72.32%;"></span><span class="phpdebugbar-widgets-label">Booting (251ms)</span><span class="phpdebugbar-widgets-collector">time</span></div></li><li><div class="phpdebugbar-widgets-measure"><span class="phpdebugbar-widgets-value" style="left: 72.32%; width: 27.68%;"></span><span class="phpdebugbar-widgets-label">Application (96.15ms)</span><span class="phpdebugbar-widgets-collector">time</span></div></li><li><div class="phpdebugbar-widgets-measure"><span class="phpdebugbar-widgets-value" style="left: 75.16%; width: 4.51%;"></span><span class="phpdebugbar-widgets-label">Routing (15.67ms)</span></div></li><li><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">1 x Booting (72.32%)</td><td class="phpdebugbar-widgets-value"><div class="phpdebugbar-widgets-measure"><span class="phpdebugbar-widgets-value" style="width: 72.32%;"></span><span class="phpdebugbar-widgets-label">251ms</span></div></td></tr><tr><td class="phpdebugbar-widgets-name">1 x Application (27.68%)</td><td class="phpdebugbar-widgets-value"><div class="phpdebugbar-widgets-measure"><span class="phpdebugbar-widgets-value" style="width: 27.68%;"></span><span class="phpdebugbar-widgets-label">96.15ms</span></div></td></tr><tr><td class="phpdebugbar-widgets-name">1 x Routing (4.51%)</td><td class="phpdebugbar-widgets-value"><div class="phpdebugbar-widgets-measure"><span class="phpdebugbar-widgets-value" style="width: 4.51%;"></span><span class="phpdebugbar-widgets-label">15.67ms</span></div></td></tr></table></li></ul></div><div class="phpdebugbar-panel" data-collector="exceptions"><div class="phpdebugbar-widgets-exceptions"><ul class="phpdebugbar-widgets-list"></ul></div></div><div class="phpdebugbar-panel" data-collector="views"><div class="phpdebugbar-widgets-templates"><div class="phpdebugbar-widgets-status"><span>3 templates were rendered</span></div><ul class="phpdebugbar-widgets-list"><li class="phpdebugbar-widgets-list-item"><span class="phpdebugbar-widgets-name">student.assignment</span><span class="phpdebugbar-widgets-filename">assignment.blade.php#?<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fresources%2Fviews%2Fstudent%2Fassignment.blade.php&amp;line=1" class="phpdebugbar-widgets-editor-link"></a></span><span title="Parameter count" class="phpdebugbar-widgets-param-count"></span><span title="Type" class="phpdebugbar-widgets-type">blade</span></li><li class="phpdebugbar-widgets-list-item"><span class="phpdebugbar-widgets-name">student.Layout.app</span><span class="phpdebugbar-widgets-filename">app.blade.php#?<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fresources%2Fviews%2Fstudent%2FLayout%2Fapp.blade.php&amp;line=1" class="phpdebugbar-widgets-editor-link"></a></span><span title="Parameter count" class="phpdebugbar-widgets-param-count"></span><span title="Type" class="phpdebugbar-widgets-type">blade</span></li><li class="phpdebugbar-widgets-list-item"><span class="phpdebugbar-widgets-name">student.Layout.sidebar</span><span class="phpdebugbar-widgets-filename">sidebar.blade.php#?<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fresources%2Fviews%2Fstudent%2FLayout%2Fsidebar.blade.php&amp;line=1" class="phpdebugbar-widgets-editor-link"></a></span><span title="Parameter count" class="phpdebugbar-widgets-param-count"></span><span title="Type" class="phpdebugbar-widgets-type">blade</span></li></ul><div class="phpdebugbar-widgets-callgraph"></div></div></div><div class="phpdebugbar-panel" data-collector="route"><dl class="phpdebugbar-widgets-kvlist phpdebugbar-widgets-htmlvarlist"><dt class="phpdebugbar-widgets-key"><span title="uri">uri</span></dt><dd class="phpdebugbar-widgets-value">GET student_assignment</dd><dt class="phpdebugbar-widgets-key"><span title="middleware">middleware</span></dt><dd class="phpdebugbar-widgets-value">web, XssSanitizer, lang, CheckSubscription, StudentPanel, auth.routes</dd><dt class="phpdebugbar-widgets-key"><span title="controller">controller</span></dt><dd class="phpdebugbar-widgets-value">App\Http\Controllers\Students\StudentController@studentAssignment<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php&amp;line=544" class="phpdebugbar-widgets-editor-link"></a></dd><dt class="phpdebugbar-widgets-key"><span title="as">as</span></dt><dd class="phpdebugbar-widgets-value">student.assignment</dd><dt class="phpdebugbar-widgets-key"><span title="file">file</span></dt><dd class="phpdebugbar-widgets-value"><a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php&amp;line=544" onclick="" class="phpdebugbar-widgets-editor-link">app/Http/Controllers/Students/StudentController.php:544-617</a></dd></dl></div><div class="phpdebugbar-panel" data-collector="queries"><div class="phpdebugbar-widgets-sqlqueries"><div class="phpdebugbar-widgets-status"><span>16 statements were executed (9 duplicates)</span><a class="phpdebugbar-widgets-duplicates">Show only duplicates</a><span title="Accumulated duration" class="phpdebugbar-widgets-duration">19.09ms</span></div><ul class="phpdebugbar-widgets-list"><li class="phpdebugbar-widgets-list-item phpdebugbar-widgets-expandable" data-connection="tgast4rf_saserpdb" data-duplicate="false"><span title="Filename" class="phpdebugbar-widgets-filename">EloquentUserProvider.php#168<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fvendor%2Flaravel%2Fframework%2Fsrc%2FIlluminate%2FAuth%2FEloquentUserProvider.php&amp;line=168" class="phpdebugbar-widgets-editor-link"></a></span><span title="Connection" class="phpdebugbar-widgets-database">tgast4rf_saserpdb</span><strong class="phpdebugbar-widgets-sql phpdebugbar-widgets-name">Connection Established</strong><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">Backtrace<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-list-ul"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Auth/EloquentUserProvider.php:168</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Auth/EloquentUserProvider.php:57</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Auth/SessionGuard.php:159</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Auth/AuthManager.php:57</li><li class="phpdebugbar-widgets-table-list-item">middleware::throttle:169</li></ul></td></tr></table></li><li class="phpdebugbar-widgets-list-item phpdebugbar-widgets-expandable" data-connection="tgast4rf_saserpdb" data-duplicate="false"><span title="Filename" class="phpdebugbar-widgets-filename">EloquentUserProvider.php#59<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fvendor%2Flaravel%2Fframework%2Fsrc%2FIlluminate%2FAuth%2FEloquentUserProvider.php&amp;line=59" class="phpdebugbar-widgets-editor-link"></a></span><span title="Connection" class="phpdebugbar-widgets-database">tgast4rf_saserpdb</span><span title="Duration" class="phpdebugbar-widgets-duration">4.16ms</span><span title="Copy to clipboard" class="phpdebugbar-widgets-copy-clipboard" style="cursor: pointer;"></span><code class="phpdebugbar-widgets-sql"><span class="hljs-keyword">select</span> <span class="hljs-operator">*</span> <span class="hljs-keyword">from</span> `users` <span class="hljs-keyword">where</span> `id` <span class="hljs-operator">=</span> <span class="hljs-number">92</span> <span class="hljs-keyword">limit</span> <span class="hljs-number">1</span></code><div class="phpdebugbar-widgets-bg-measure"><div class="phpdebugbar-widgets-value" style="left: 0%; width: 21.792%;"></div></div><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">Bindings<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-thumb-tack"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item"><span class="phpdebugbar-text-muted">0:</span>&nbsp;<span>92</span></li></ul></td></tr><tr><td class="phpdebugbar-widgets-name">Backtrace<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-list-ul"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Auth/EloquentUserProvider.php:59</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Auth/SessionGuard.php:159</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Auth/AuthManager.php:57</li><li class="phpdebugbar-widgets-table-list-item">middleware::throttle:169</li><li class="phpdebugbar-widgets-table-list-item">middleware::throttle:62</li></ul></td></tr></table></li><li class="phpdebugbar-widgets-list-item phpdebugbar-widgets-expandable" data-connection="tgast4rf_saserpdb" data-duplicate="false"><span title="Filename" class="phpdebugbar-widgets-filename">StudentController.php#547<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php&amp;line=547" class="phpdebugbar-widgets-editor-link"></a></span><span title="Connection" class="phpdebugbar-widgets-database">tgast4rf_saserpdb</span><span title="Duration" class="phpdebugbar-widgets-duration">1.37ms</span><span title="Copy to clipboard" class="phpdebugbar-widgets-copy-clipboard" style="cursor: pointer;"></span><code class="phpdebugbar-widgets-sql"><span class="hljs-keyword">select</span> <span class="hljs-operator">*</span> <span class="hljs-keyword">from</span> `students` <span class="hljs-keyword">where</span> `user_id` <span class="hljs-operator">=</span> <span class="hljs-number">92</span> <span class="hljs-keyword">limit</span> <span class="hljs-number">1</span></code><div class="phpdebugbar-widgets-bg-measure"><div class="phpdebugbar-widgets-value" style="left: 21.792%; width: 7.177%;"></div></div><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">Bindings<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-thumb-tack"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item"><span class="phpdebugbar-text-muted">0:</span>&nbsp;<span>92</span></li></ul></td></tr><tr><td class="phpdebugbar-widgets-name">Backtrace<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-list-ul"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item">app/Http/Controllers/Students/StudentController.php:547</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Controller.php:54</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php:43</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Route.php:259</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Route.php:205</li></ul></td></tr></table></li><li class="phpdebugbar-widgets-list-item phpdebugbar-widgets-expandable" data-connection="tgast4rf_saserpdb" data-duplicate="false"><span title="Filename" class="phpdebugbar-widgets-filename">StudentController.php#569<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php&amp;line=569" class="phpdebugbar-widgets-editor-link"></a></span><span title="Connection" class="phpdebugbar-widgets-database">tgast4rf_saserpdb</span><span title="Duration" class="phpdebugbar-widgets-duration">3ms</span><span title="Copy to clipboard" class="phpdebugbar-widgets-copy-clipboard" style="cursor: pointer;"></span><code class="phpdebugbar-widgets-sql"><span class="hljs-keyword">select</span> <span class="hljs-built_in">count</span>(<span class="hljs-operator">*</span>) <span class="hljs-keyword">as</span> aggregate <span class="hljs-keyword">from</span> `assignments` <span class="hljs-keyword">left</span> <span class="hljs-keyword">join</span> `subjects` <span class="hljs-keyword">on</span> `assignments`.`subject_id` <span class="hljs-operator">=</span> `subjects`.`id` <span class="hljs-keyword">where</span> `assignments`.`grade` <span class="hljs-keyword">is</span> <span class="hljs-keyword">null</span></code><div class="phpdebugbar-widgets-bg-measure"><div class="phpdebugbar-widgets-value" style="left: 28.968%; width: 15.715%;"></div></div><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">Backtrace<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-list-ul"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item">app/Http/Controllers/Students/StudentController.php:569</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Controller.php:54</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php:43</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Route.php:259</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Route.php:205</li></ul></td></tr></table></li><li class="phpdebugbar-widgets-list-item phpdebugbar-widgets-expandable" data-connection="tgast4rf_saserpdb" data-duplicate="false"><span title="Filename" class="phpdebugbar-widgets-filename">StudentController.php#569<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php&amp;line=569" class="phpdebugbar-widgets-editor-link"></a></span><span title="Connection" class="phpdebugbar-widgets-database">tgast4rf_saserpdb</span><span title="Duration" class="phpdebugbar-widgets-duration">630μs</span><span title="Copy to clipboard" class="phpdebugbar-widgets-copy-clipboard" style="cursor: pointer;"></span><code class="phpdebugbar-widgets-sql"><span class="hljs-keyword">select</span> `assignments`.<span class="hljs-operator">*</span>, `subjects`.`name` <span class="hljs-keyword">as</span> `subject_name` <span class="hljs-keyword">from</span> `assignments` <span class="hljs-keyword">left</span> <span class="hljs-keyword">join</span> `subjects` <span class="hljs-keyword">on</span> `assignments`.`subject_id` <span class="hljs-operator">=</span> `subjects`.`id` <span class="hljs-keyword">where</span> `assignments`.`grade` <span class="hljs-keyword">is</span> <span class="hljs-keyword">null</span> <span class="hljs-keyword">order</span> <span class="hljs-keyword">by</span> `assignments`.`assigned_date` <span class="hljs-keyword">desc</span> <span class="hljs-keyword">limit</span> <span class="hljs-number">5</span> <span class="hljs-keyword">offset</span> <span class="hljs-number">0</span></code><div class="phpdebugbar-widgets-bg-measure"><div class="phpdebugbar-widgets-value" style="left: 44.683%; width: 3.3%;"></div></div><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">Backtrace<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-list-ul"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item">app/Http/Controllers/Students/StudentController.php:569</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Controller.php:54</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php:43</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Route.php:259</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Route.php:205</li></ul></td></tr></table></li><li class="phpdebugbar-widgets-list-item phpdebugbar-widgets-expandable" data-connection="tgast4rf_saserpdb" data-duplicate="false"><span title="Filename" class="phpdebugbar-widgets-filename">StudentController.php#578<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php&amp;line=578" class="phpdebugbar-widgets-editor-link"></a></span><span title="Connection" class="phpdebugbar-widgets-database">tgast4rf_saserpdb</span><span title="Duration" class="phpdebugbar-widgets-duration">490μs</span><span title="Copy to clipboard" class="phpdebugbar-widgets-copy-clipboard" style="cursor: pointer;"></span><code class="phpdebugbar-widgets-sql"><span class="hljs-keyword">select</span> <span class="hljs-built_in">count</span>(<span class="hljs-operator">*</span>) <span class="hljs-keyword">as</span> aggregate <span class="hljs-keyword">from</span> `assignments` <span class="hljs-keyword">left</span> <span class="hljs-keyword">join</span> `subjects` <span class="hljs-keyword">on</span> `assignments`.`subject_id` <span class="hljs-operator">=</span> `subjects`.`id` <span class="hljs-keyword">where</span> `assignments`.`grade` <span class="hljs-keyword">is</span> <span class="hljs-keyword">not null</span></code><div class="phpdebugbar-widgets-bg-measure"><div class="phpdebugbar-widgets-value" style="left: 47.983%; width: 2.567%;"></div></div><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">Backtrace<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-list-ul"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item">app/Http/Controllers/Students/StudentController.php:578</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Controller.php:54</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php:43</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Route.php:259</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Route.php:205</li></ul></td></tr></table></li><li class="phpdebugbar-widgets-list-item phpdebugbar-widgets-expandable" data-connection="tgast4rf_saserpdb" data-duplicate="false"><span title="Filename" class="phpdebugbar-widgets-filename">StudentController.php#578<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php&amp;line=578" class="phpdebugbar-widgets-editor-link"></a></span><span title="Connection" class="phpdebugbar-widgets-database">tgast4rf_saserpdb</span><span title="Duration" class="phpdebugbar-widgets-duration">1.26ms</span><span title="Copy to clipboard" class="phpdebugbar-widgets-copy-clipboard" style="cursor: pointer;"></span><code class="phpdebugbar-widgets-sql"><span class="hljs-keyword">select</span> `assignments`.<span class="hljs-operator">*</span>, `subjects`.`name` <span class="hljs-keyword">as</span> `subject_name` <span class="hljs-keyword">from</span> `assignments` <span class="hljs-keyword">left</span> <span class="hljs-keyword">join</span> `subjects` <span class="hljs-keyword">on</span> `assignments`.`subject_id` <span class="hljs-operator">=</span> `subjects`.`id` <span class="hljs-keyword">where</span> `assignments`.`grade` <span class="hljs-keyword">is</span> <span class="hljs-keyword">not null</span> <span class="hljs-keyword">order</span> <span class="hljs-keyword">by</span> `assignments`.`assigned_date` <span class="hljs-keyword">desc</span> <span class="hljs-keyword">limit</span> <span class="hljs-number">5</span> <span class="hljs-keyword">offset</span> <span class="hljs-number">0</span></code><div class="phpdebugbar-widgets-bg-measure"><div class="phpdebugbar-widgets-value" style="left: 50.55%; width: 6.6%;"></div></div><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">Backtrace<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-list-ul"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item">app/Http/Controllers/Students/StudentController.php:578</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Controller.php:54</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php:43</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Route.php:259</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Route.php:205</li></ul></td></tr></table></li><li class="phpdebugbar-widgets-list-item phpdebugbar-widgets-expandable" data-connection="tgast4rf_saserpdb" data-duplicate="false"><span title="Filename" class="phpdebugbar-widgets-filename">StudentController.php#587<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FHttp%2FControllers%2FStudents%2FStudentController.php&amp;line=587" class="phpdebugbar-widgets-editor-link"></a></span><span title="Connection" class="phpdebugbar-widgets-database">tgast4rf_saserpdb</span><span title="Duration" class="phpdebugbar-widgets-duration">2.91ms</span><span title="Copy to clipboard" class="phpdebugbar-widgets-copy-clipboard" style="cursor: pointer;"></span><code class="phpdebugbar-widgets-sql"><span class="hljs-keyword">select</span> <span class="hljs-operator">*</span> <span class="hljs-keyword">from</span> `assignment_media` <span class="hljs-keyword">where</span> `assignment_id` <span class="hljs-keyword">in</span> (<span class="hljs-number">2</span>, <span class="hljs-number">3</span>, <span class="hljs-number">1</span>) <span class="hljs-keyword">and</span> `student_id` <span class="hljs-operator">=</span> <span class="hljs-number">37</span></code><div class="phpdebugbar-widgets-bg-measure"><div class="phpdebugbar-widgets-value" style="left: 57.15%; width: 15.244%;"></div></div><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">Bindings<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-thumb-tack"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item"><span class="phpdebugbar-text-muted">0:</span>&nbsp;<span>2</span></li><li class="phpdebugbar-widgets-table-list-item"><span class="phpdebugbar-text-muted">1:</span>&nbsp;<span>3</span></li><li class="phpdebugbar-widgets-table-list-item"><span class="phpdebugbar-text-muted">2:</span>&nbsp;<span>1</span></li><li class="phpdebugbar-widgets-table-list-item"><span class="phpdebugbar-text-muted">3:</span>&nbsp;<span>37</span></li></ul></td></tr><tr><td class="phpdebugbar-widgets-name">Backtrace<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-list-ul"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item">app/Http/Controllers/Students/StudentController.php:587</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Controller.php:54</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php:43</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Route.php:259</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/Routing/Route.php:205</li></ul></td></tr></table></li><li class="phpdebugbar-widgets-list-item phpdebugbar-widgets-sql-duplicate phpdebugbar-widgets-expandable" data-connection="tgast4rf_saserpdb" data-duplicate="true"><span title="Filename" class="phpdebugbar-widgets-filename">AppServiceProvider.php#111<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php&amp;line=111" class="phpdebugbar-widgets-editor-link"></a></span><span title="Connection" class="phpdebugbar-widgets-database">tgast4rf_saserpdb</span><span title="Duration" class="phpdebugbar-widgets-duration">930μs</span><span title="Copy to clipboard" class="phpdebugbar-widgets-copy-clipboard" style="cursor: pointer;"></span><code class="phpdebugbar-widgets-sql"><span class="hljs-keyword">select</span> <span class="hljs-built_in">count</span>(<span class="hljs-operator">*</span>) <span class="hljs-keyword">as</span> aggregate <span class="hljs-keyword">from</span> `subscribes`</code><div class="phpdebugbar-widgets-bg-measure"><div class="phpdebugbar-widgets-value" style="left: 72.394%; width: 4.872%;"></div></div><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">Backtrace<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-list-ul"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item">app/Providers/AppServiceProvider.php:111</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:162</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:177</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:176</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:147</li></ul></td></tr></table></li><li class="phpdebugbar-widgets-list-item phpdebugbar-widgets-sql-duplicate phpdebugbar-widgets-expandable" data-connection="tgast4rf_saserpdb" data-duplicate="true"><span title="Filename" class="phpdebugbar-widgets-filename">AppServiceProvider.php#112<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php&amp;line=112" class="phpdebugbar-widgets-editor-link"></a></span><span title="Connection" class="phpdebugbar-widgets-database">tgast4rf_saserpdb</span><span title="Duration" class="phpdebugbar-widgets-duration">790μs</span><span title="Copy to clipboard" class="phpdebugbar-widgets-copy-clipboard" style="cursor: pointer;"></span><code class="phpdebugbar-widgets-sql"><span class="hljs-keyword">select</span> <span class="hljs-operator">*</span> <span class="hljs-keyword">from</span> `page_sections`</code><div class="phpdebugbar-widgets-bg-measure"><div class="phpdebugbar-widgets-value" style="left: 77.266%; width: 4.138%;"></div></div><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">Backtrace<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-list-ul"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item">app/Providers/AppServiceProvider.php:112</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:162</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:177</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:176</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:147</li></ul></td></tr></table></li><li class="phpdebugbar-widgets-list-item phpdebugbar-widgets-sql-duplicate phpdebugbar-widgets-expandable" data-connection="tgast4rf_saserpdb" data-duplicate="true"><span title="Filename" class="phpdebugbar-widgets-filename">AppServiceProvider.php#112<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php&amp;line=112" class="phpdebugbar-widgets-editor-link"></a></span><span title="Connection" class="phpdebugbar-widgets-database">tgast4rf_saserpdb</span><span title="Duration" class="phpdebugbar-widgets-duration">760μs</span><span title="Copy to clipboard" class="phpdebugbar-widgets-copy-clipboard" style="cursor: pointer;"></span><code class="phpdebugbar-widgets-sql"><span class="hljs-keyword">select</span> <span class="hljs-operator">*</span> <span class="hljs-keyword">from</span> `uploads` <span class="hljs-keyword">where</span> `uploads`.`id` <span class="hljs-keyword">in</span> (<span class="hljs-number">5</span>, <span class="hljs-number">6</span>, <span class="hljs-number">7</span>)</code><div class="phpdebugbar-widgets-bg-measure"><div class="phpdebugbar-widgets-value" style="left: 81.404%; width: 3.981%;"></div></div><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">Backtrace<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-list-ul"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item">app/Providers/AppServiceProvider.php:112</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:162</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:177</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:176</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:147</li></ul></td></tr></table></li><li class="phpdebugbar-widgets-list-item phpdebugbar-widgets-sql-duplicate phpdebugbar-widgets-expandable" data-connection="tgast4rf_saserpdb" data-duplicate="true"><span title="Filename" class="phpdebugbar-widgets-filename">AppServiceProvider.php#111<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php&amp;line=111" class="phpdebugbar-widgets-editor-link"></a></span><span title="Connection" class="phpdebugbar-widgets-database">tgast4rf_saserpdb</span><span title="Duration" class="phpdebugbar-widgets-duration">490μs</span><span title="Copy to clipboard" class="phpdebugbar-widgets-copy-clipboard" style="cursor: pointer;"></span><code class="phpdebugbar-widgets-sql"><span class="hljs-keyword">select</span> <span class="hljs-built_in">count</span>(<span class="hljs-operator">*</span>) <span class="hljs-keyword">as</span> aggregate <span class="hljs-keyword">from</span> `subscribes`</code><div class="phpdebugbar-widgets-bg-measure"><div class="phpdebugbar-widgets-value" style="left: 85.385%; width: 2.567%;"></div></div><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">Backtrace<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-list-ul"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item">app/Providers/AppServiceProvider.php:111</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:162</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:177</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:176</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:147</li></ul></td></tr></table></li><li class="phpdebugbar-widgets-list-item phpdebugbar-widgets-sql-duplicate phpdebugbar-widgets-expandable" data-connection="tgast4rf_saserpdb" data-duplicate="true"><span title="Filename" class="phpdebugbar-widgets-filename">AppServiceProvider.php#112<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php&amp;line=112" class="phpdebugbar-widgets-editor-link"></a></span><span title="Connection" class="phpdebugbar-widgets-database">tgast4rf_saserpdb</span><span title="Duration" class="phpdebugbar-widgets-duration">520μs</span><span title="Copy to clipboard" class="phpdebugbar-widgets-copy-clipboard" style="cursor: pointer;"></span><code class="phpdebugbar-widgets-sql"><span class="hljs-keyword">select</span> <span class="hljs-operator">*</span> <span class="hljs-keyword">from</span> `page_sections`</code><div class="phpdebugbar-widgets-bg-measure"><div class="phpdebugbar-widgets-value" style="left: 87.952%; width: 2.724%;"></div></div><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">Backtrace<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-list-ul"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item">app/Providers/AppServiceProvider.php:112</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:162</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:177</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:176</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:147</li></ul></td></tr></table></li><li class="phpdebugbar-widgets-list-item phpdebugbar-widgets-sql-duplicate phpdebugbar-widgets-expandable" data-connection="tgast4rf_saserpdb" data-duplicate="true"><span title="Filename" class="phpdebugbar-widgets-filename">AppServiceProvider.php#112<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php&amp;line=112" class="phpdebugbar-widgets-editor-link"></a></span><span title="Connection" class="phpdebugbar-widgets-database">tgast4rf_saserpdb</span><span title="Duration" class="phpdebugbar-widgets-duration">430μs</span><span title="Copy to clipboard" class="phpdebugbar-widgets-copy-clipboard" style="cursor: pointer;"></span><code class="phpdebugbar-widgets-sql"><span class="hljs-keyword">select</span> <span class="hljs-operator">*</span> <span class="hljs-keyword">from</span> `uploads` <span class="hljs-keyword">where</span> `uploads`.`id` <span class="hljs-keyword">in</span> (<span class="hljs-number">5</span>, <span class="hljs-number">6</span>, <span class="hljs-number">7</span>)</code><div class="phpdebugbar-widgets-bg-measure"><div class="phpdebugbar-widgets-value" style="left: 90.676%; width: 2.252%;"></div></div><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">Backtrace<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-list-ul"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item">app/Providers/AppServiceProvider.php:112</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:162</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:177</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:176</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:147</li></ul></td></tr></table></li><li class="phpdebugbar-widgets-list-item phpdebugbar-widgets-sql-duplicate phpdebugbar-widgets-expandable" data-connection="tgast4rf_saserpdb" data-duplicate="true"><span title="Filename" class="phpdebugbar-widgets-filename">AppServiceProvider.php#111<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php&amp;line=111" class="phpdebugbar-widgets-editor-link"></a></span><span title="Connection" class="phpdebugbar-widgets-database">tgast4rf_saserpdb</span><span title="Duration" class="phpdebugbar-widgets-duration">390μs</span><span title="Copy to clipboard" class="phpdebugbar-widgets-copy-clipboard" style="cursor: pointer;"></span><code class="phpdebugbar-widgets-sql"><span class="hljs-keyword">select</span> <span class="hljs-built_in">count</span>(<span class="hljs-operator">*</span>) <span class="hljs-keyword">as</span> aggregate <span class="hljs-keyword">from</span> `subscribes`</code><div class="phpdebugbar-widgets-bg-measure"><div class="phpdebugbar-widgets-value" style="left: 92.928%; width: 2.043%;"></div></div><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">Backtrace<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-list-ul"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item">app/Providers/AppServiceProvider.php:111</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:162</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:177</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:176</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:147</li></ul></td></tr></table></li><li class="phpdebugbar-widgets-list-item phpdebugbar-widgets-sql-duplicate phpdebugbar-widgets-expandable" data-connection="tgast4rf_saserpdb" data-duplicate="true"><span title="Filename" class="phpdebugbar-widgets-filename">AppServiceProvider.php#112<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php&amp;line=112" class="phpdebugbar-widgets-editor-link"></a></span><span title="Connection" class="phpdebugbar-widgets-database">tgast4rf_saserpdb</span><span title="Duration" class="phpdebugbar-widgets-duration">500μs</span><span title="Copy to clipboard" class="phpdebugbar-widgets-copy-clipboard" style="cursor: pointer;"></span><code class="phpdebugbar-widgets-sql"><span class="hljs-keyword">select</span> <span class="hljs-operator">*</span> <span class="hljs-keyword">from</span> `page_sections`</code><div class="phpdebugbar-widgets-bg-measure"><div class="phpdebugbar-widgets-value" style="left: 94.971%; width: 2.619%;"></div></div><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">Backtrace<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-list-ul"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item">app/Providers/AppServiceProvider.php:112</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:162</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:177</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:176</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:147</li></ul></td></tr></table></li><li class="phpdebugbar-widgets-list-item phpdebugbar-widgets-sql-duplicate phpdebugbar-widgets-expandable" data-connection="tgast4rf_saserpdb" data-duplicate="true"><span title="Filename" class="phpdebugbar-widgets-filename">AppServiceProvider.php#112<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FProviders%2FAppServiceProvider.php&amp;line=112" class="phpdebugbar-widgets-editor-link"></a></span><span title="Connection" class="phpdebugbar-widgets-database">tgast4rf_saserpdb</span><span title="Duration" class="phpdebugbar-widgets-duration">460μs</span><span title="Copy to clipboard" class="phpdebugbar-widgets-copy-clipboard" style="cursor: pointer;"></span><code class="phpdebugbar-widgets-sql"><span class="hljs-keyword">select</span> <span class="hljs-operator">*</span> <span class="hljs-keyword">from</span> `uploads` <span class="hljs-keyword">where</span> `uploads`.`id` <span class="hljs-keyword">in</span> (<span class="hljs-number">5</span>, <span class="hljs-number">6</span>, <span class="hljs-number">7</span>)</code><div class="phpdebugbar-widgets-bg-measure"><div class="phpdebugbar-widgets-value" style="left: 97.59%; width: 2.41%;"></div></div><table class="phpdebugbar-widgets-params"><tr><td class="phpdebugbar-widgets-name">Backtrace<i class="phpdebugbar-text-muted phpdebugbar-fa phpdebugbar-fa-list-ul"></i></td><td class="phpdebugbar-widgets-value"><ul class="phpdebugbar-widgets-table-list"><li class="phpdebugbar-widgets-table-list-item">app/Providers/AppServiceProvider.php:112</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:162</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/Concerns/ManagesEvents.php:177</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:176</li><li class="phpdebugbar-widgets-table-list-item">vendor/laravel/framework/src/Illuminate/View/View.php:147</li></ul></td></tr></table></li></ul></div></div><div class="phpdebugbar-panel" data-collector="models"><div class="phpdebugbar-widgets-tablevarlist"><table class="phpdebugbar-widgets-tablevar"><tr class="phpdebugbar-widgets-header"><td></td><td>Retrieved<span class="phpdebugbar-widgets-badge">46</span></td><td>Created</td><td>Updated</td><td>Deleted</td><td></td></tr><tr class="phpdebugbar-widgets-item"><td class="phpdebugbar-widgets-key">App\Models\WebsiteSetup\PageSections</td><td class="phpdebugbar-widgets-value">36</td><td class="phpdebugbar-widgets-value"></td><td class="phpdebugbar-widgets-value"></td><td class="phpdebugbar-widgets-value"></td><td class="phpdebugbar-widgets-editor"><span class="phpdebugbar-widgets-filename">PageSections.php#?<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FModels%2FWebsiteSetup%2FPageSections.php&amp;line=1" class="phpdebugbar-widgets-editor-link"></a></span></td></tr><tr class="phpdebugbar-widgets-item"><td class="phpdebugbar-widgets-key">App\Models\Upload</td><td class="phpdebugbar-widgets-value">9</td><td class="phpdebugbar-widgets-value"></td><td class="phpdebugbar-widgets-value"></td><td class="phpdebugbar-widgets-value"></td><td class="phpdebugbar-widgets-editor"><span class="phpdebugbar-widgets-filename">Upload.php#?<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FModels%2FUpload.php&amp;line=1" class="phpdebugbar-widgets-editor-link"></a></span></td></tr><tr class="phpdebugbar-widgets-item"><td class="phpdebugbar-widgets-key">App\Models\User</td><td class="phpdebugbar-widgets-value">1</td><td class="phpdebugbar-widgets-value"></td><td class="phpdebugbar-widgets-value"></td><td class="phpdebugbar-widgets-value"></td><td class="phpdebugbar-widgets-editor"><span class="phpdebugbar-widgets-filename">User.php#?<a href="phpstorm://open?file=%2Fhome3%2Ftgast4rf%2Fsaserp.tgastaging.com%2Fapp%2FModels%2FUser.php&amp;line=1" class="phpdebugbar-widgets-editor-link"></a></span></td></tr></table></div></div><div class="phpdebugbar-panel" data-collector="emails"><div class="phpdebugbar-widgets-mails"><ul class="phpdebugbar-widgets-list"></ul></div></div><div class="phpdebugbar-panel" data-collector="gate"><div class="phpdebugbar-widgets-messages"><ul class="phpdebugbar-widgets-list"></ul><div class="phpdebugbar-widgets-toolbar"><i class="phpdebugbar-fa phpdebugbar-fa-search"></i><input type="text" name="search" aria-label="Search" placeholder="Search"><a class="phpdebugbar-widgets-filter" style="visibility: hidden;"></a></div></div></div><div class="phpdebugbar-panel" data-collector="session"><dl class="phpdebugbar-widgets-kvlist phpdebugbar-widgets-varlist"><dt class="phpdebugbar-widgets-key"><span title="_token">_token</span></dt><dd class="phpdebugbar-widgets-value">NHn738kSkVp4duFVd2zQ7BHpv5g6HPluJUZC2ls1</dd><dt class="phpdebugbar-widgets-key"><span title="_flash">_flash</span></dt><dd class="phpdebugbar-widgets-value">array:2 [
  "old" =&gt; []
  "new" =&gt; []
]</dd><dt class="phpdebugbar-widgets-key"><span title="locale">locale</span></dt><dd class="phpdebugbar-widgets-value">en</dd><dt class="phpdebugbar-widgets-key"><span title="_previous">_previous</span></dt><dd class="phpdebugbar-widgets-value">array:1 [
  "url" =&gt; "https://saserp.tgastaging.com/student_dashboard"
]</dd><dt class="phpdebugbar-widgets-key"><span title="login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d">login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d</span></dt><dd class="phpdebugbar-widgets-value">92</dd></dl></div><div class="phpdebugbar-panel" data-collector="__datasets"><div class="phpdebugbar-widgets-dataset-history"><div class="phpdebugbar-widgets-dataset-actions"><label>Autoshow<input type="checkbox"></label><a>Clear</a><a>Show all</a><select name="method" style="width:100px"><option>(method)</option><option>GET</option><option>POST</option><option>PUT</option><option>DELETE</option></select><input type="text" name="search" aria-label="Search" placeholder="Search"></div><table><thead><tr><th style="width: 30px;"></th><th style="width: 175px;">Date ↕</th><th style="width: 80px;">Method</th><th>URL</th><th width="40%">Data</th></tr></thead><tbody><tr data-id="01KBMGWC886QYND7FNSWN12EKP" class="phpdebugbar-widgets-table-row phpdebugbar-widgets-active" style="cursor: pointer;"><td>#1</td><td>2025-12-04 11:10:12</td><td>GET</td><td>/student_assignment</td><td><a title="Views"><i class="phpdebugbar-fa phpdebugbar-fa-leaf"></i><span class="phpdebugbar-badge" style="display: inline-block;">3</span></a><a title="Queries"><i class="phpdebugbar-fa phpdebugbar-fa-database"></i><span class="phpdebugbar-badge" style="display: inline-block;">16</span></a><a title="Models"><i class="phpdebugbar-fa phpdebugbar-fa-cubes"></i><span class="phpdebugbar-badge" style="display: inline-block;">46</span></a></td></tr></tbody></table></div></div></div><a class="phpdebugbar-restore-btn" style=""></a></div><div class="phpdebugbar-openhandler" data-theme="light" style="display: none;"><div class="phpdebugbar-openhandler-header">PHP DebugBar | Open<a><i class="phpdebugbar-fa phpdebugbar-fa-times"></i></a></div><table><thead><tr><th width="155">Date</th><th width="75">Method</th><th>URL</th><th width="125">IP</th><th width="100">Filter data</th></tr></thead><tbody></tbody></table><div class="phpdebugbar-openhandler-actions"><a>Load more</a><a>Show only current URL</a><a>Show all</a><a>Delete all</a><form><br><b>Filter results</b><br><select name="method"><option selected="">(Method)</option><option>GET</option><option>POST</option><option>PUT</option><option>DELETE</option></select><input type="text" name="uri" placeholder="URI"><input type="text" name="ip" placeholder="IP"><button type="submit">Search</button></form></div></div><div class="phpdebugbar-openhandler-overlay" style="display: none;"></div>


<script src="chrome-extension://okkffdhbfplmbjblhgapnchjinanmnij/content/sm.js" data-pname="recorder-screenshot-v3" data-asset-path="chrome-extension://okkffdhbfplmbjblhgapnchjinanmnij/"></script><div class="modal-backdrop fade show"></div>

<script>
const select = document.querySelector(".custom-select");
const selected = select.querySelector(".selected");
const options = select.querySelector(".options");

selected.onclick = () => {
    options.style.display =
        options.style.display === "block" ? "none" : "block";
};

document.querySelectorAll(".options li").forEach(option => {
    option.onclick = () => {
        selected.innerText = option.innerText;
        options.style.display = "none";
    };
});

// Close dropdown when clicking outside
document.addEventListener("click", (e) => {
    if (!select.contains(e.target)) {
        options.style.display = "none";
    }
});



</script>




</body>
</html>