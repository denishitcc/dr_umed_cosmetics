"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.unescapeHTML = exports.boolValue = exports.escapeRegExCharacters = void 0;
const lodash_1 = require("lodash");
/**
 * Escapes RegEx characters in provided String value.
 *
 * @param {String} value
 *   String for escaping RegEx characters.
 * @returns {string}
 *   String with escaped RegEx characters.
 */
function escapeRegExCharacters(value) {
    return value.replace(/[-[\]/{}()*+?.\\^$|]/g, '\\$&');
}
exports.escapeRegExCharacters = escapeRegExCharacters;
/**
 * Determines the boolean value of a setting.
 *
 * @param value
 * @return {boolean}
 */
function boolValue(value) {
    if ((0, lodash_1.isBoolean)(value)) {
        return value;
    }
    else if ((0, lodash_1.isString)(value)) {
        return (value.toLowerCase() === 'true');
    }
    else {
        return !!value;
    }
}
exports.boolValue = boolValue;
/**
 * Unescape HTML characters like &lt, &gt, &amp and etc.
 * @param str
 * @returns {string}
 */
function unescapeHTML(str) {
    if (typeof window === 'undefined' || !('DOMParser' in window)) {
        return str;
    }
    const doc = new window.DOMParser().parseFromString(str, 'text/html');
    return doc.documentElement.textContent;
}
exports.unescapeHTML = unescapeHTML;
