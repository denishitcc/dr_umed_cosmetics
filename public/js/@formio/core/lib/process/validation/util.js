"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.interpolateErrors = exports.isObject = exports.isPromise = exports.toBoolean = exports.getComponentErrorField = exports.isEmptyObject = exports.isComponentProtected = exports.isComponentPersistent = void 0;
const utils_1 = require("../../utils");
const i18n_1 = require("./i18n");
function isComponentPersistent(component) {
    return component.persistent ? component.persistent : true;
}
exports.isComponentPersistent = isComponentPersistent;
function isComponentProtected(component) {
    return component.protected ? component.protected : false;
}
exports.isComponentProtected = isComponentProtected;
function isEmptyObject(obj) {
    return !!obj && Object.keys(obj).length === 0 && obj.constructor === Object;
}
exports.isEmptyObject = isEmptyObject;
function getComponentErrorField(component, context) {
    const toInterpolate = component.errorLabel || component.label || component.placeholder || component.key;
    return utils_1.Evaluator.interpolate(toInterpolate, context);
}
exports.getComponentErrorField = getComponentErrorField;
function toBoolean(value) {
    switch (typeof value) {
        case 'string':
            if (value === 'true' || value === '1') {
                return true;
            }
            else if (value === 'false' || value === '0') {
                return false;
            }
            else {
                throw `Cannot coerce string ${value} to boolean}`;
            }
        case 'boolean':
            return value;
        default:
            return !!value;
    }
}
exports.toBoolean = toBoolean;
function isPromise(value) {
    return (value &&
        value.then &&
        typeof value.then === 'function' &&
        Object.prototype.toString.call(value) === '[object Promise]');
}
exports.isPromise = isPromise;
function isObject(obj) {
    return typeof obj != null && (typeof obj === 'object' || typeof obj === 'function');
}
exports.isObject = isObject;
/**
 * Interpolates @formio/core errors so that they are compatible with the renderer
 * @param {FieldError[]} errors
 * @param firstPass
 * @returns {[]}
 */
const interpolateErrors = (errors, lang = 'en') => {
    return errors.map((error) => {
        const { errorKeyOrMessage, context } = error;
        const i18n = i18n_1.VALIDATION_ERRORS[lang] || {};
        const toInterpolate = i18n[errorKeyOrMessage] ? i18n[errorKeyOrMessage] : errorKeyOrMessage;
        const paths = [];
        context.path.split('.').forEach((part) => {
            const match = part.match(/\[([0-9]+)\]$/);
            if (match) {
                paths.push(part.substring(0, match.index));
                paths.push(parseInt(match[1]));
            }
            else {
                paths.push(part);
            }
        });
        return {
            message: (0, utils_1.unescapeHTML)(utils_1.Evaluator.interpolateString(toInterpolate, context)),
            level: error.level,
            path: paths,
            context: {
                validator: error.ruleName,
                hasLabel: context.hasLabel,
                key: context.component.key,
                label: context.component.label || context.component.placeholder || context.component.key,
                path: context.path,
                value: context.value,
                setting: context.setting,
                index: context.index || 0
            }
        };
    });
};
exports.interpolateErrors = interpolateErrors;
