function localFallback(elem, attr, url) {
    elem.removeAttribute('onerror');
    elem.removeAttribute('integrity');
    elem.setAttribute(attr, url);
}
