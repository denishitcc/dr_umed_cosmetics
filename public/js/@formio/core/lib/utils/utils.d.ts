/**
 * Escapes RegEx characters in provided String value.
 *
 * @param {String} value
 *   String for escaping RegEx characters.
 * @returns {string}
 *   String with escaped RegEx characters.
 */
export declare function escapeRegExCharacters(value: string): string;
/**
 * Determines the boolean value of a setting.
 *
 * @param value
 * @return {boolean}
 */
export declare function boolValue(value: any): boolean;
/**
 * Unescape HTML characters like &lt, &gt, &amp and etc.
 * @param str
 * @returns {string}
 */
export declare function unescapeHTML(str: string): string | null;
