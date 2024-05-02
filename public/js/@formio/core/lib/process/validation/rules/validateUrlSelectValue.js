"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.validateUrlSelectValueInfo = exports.validateUrlSelectValue = exports.shouldValidate = exports.generateUrl = void 0;
const error_1 = require("../../../error");
const utils_1 = require("../../../utils");
const util_1 = require("../util");
const error_2 = require("../../../utils/error");
const isValidatableSelectComponent = (component) => {
    var _a;
    return (component &&
        component.type === 'select' &&
        (0, util_1.toBoolean)(component.dataSrc === 'url') &&
        (0, util_1.toBoolean)((_a = component.validate) === null || _a === void 0 ? void 0 : _a.select));
};
const generateUrl = (baseUrl, component, value) => {
    const url = baseUrl;
    const query = url.searchParams;
    if (component.searchField) {
        let searchValue = value;
        if (component.valueProperty) {
            searchValue = value[component.valueProperty];
        }
        else {
            searchValue = value;
        }
        query.set(component.searchField, typeof searchValue === 'string' ? searchValue : JSON.stringify(searchValue));
    }
    if (component.selectFields) {
        query.set('select', component.selectFields);
    }
    if (component.sort) {
        query.set('sort', component.sort);
    }
    if (component.filter) {
        const filterQueryStrings = new URLSearchParams(component.filter);
        filterQueryStrings.forEach((value, key) => query.set(key, value));
    }
    return url;
};
exports.generateUrl = generateUrl;
const shouldValidate = (context) => {
    var _a;
    const { component, value, data, config } = context;
    // Only run this validation if server-side
    if (!(config === null || config === void 0 ? void 0 : config.server)) {
        return false;
    }
    if (!isValidatableSelectComponent(component)) {
        return false;
    }
    if (!value ||
        (0, util_1.isEmptyObject)(value) ||
        (Array.isArray(value) && value.length === 0)) {
        return false;
    }
    // If given an invalid configuration, do not validate the remote value
    if (component.dataSrc !== 'url' || !((_a = component.data) === null || _a === void 0 ? void 0 : _a.url) || !component.searchField) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateUrlSelectValue = (context) => __awaiter(void 0, void 0, void 0, function* () {
    const { component, value, data, config } = context;
    let _fetch = null;
    try {
        _fetch = context.fetch ? context.fetch : fetch;
    }
    catch (err) {
        _fetch = null;
    }
    try {
        if (!_fetch) {
            console.log('You must provide a fetch interface to the fetch processor.');
            return null;
        }
        if (!(0, exports.shouldValidate)(context)) {
            return null;
        }
        const baseUrl = new URL(utils_1.Evaluator ? utils_1.Evaluator.interpolate(component.data.url, data, {}) : component.data.url);
        const url = (0, exports.generateUrl)(baseUrl, component, value);
        const headers = component.data.headers
            ? component.data.headers.reduce((acc, header) => (Object.assign(Object.assign({}, acc), { [header.key]: header.value })), {})
            : {};
        // Set form.io authentication
        if (component.authenticate && config && config.tokens) {
            Object.assign(headers, config.tokens);
        }
        try {
            const response = yield _fetch(url.toString(), { method: 'GET', headers });
            // TODO: should we always expect JSON here?
            if (response.ok) {
                const data = yield response.json();
                const error = new error_1.FieldError('select', context);
                if (Array.isArray(data)) {
                    return data && data.length ? null : error;
                }
                return data ? ((0, util_1.isEmptyObject)(data) ? error : null) : error;
            }
            const data = yield response.text();
            throw new error_1.ProcessorError(`Component with path ${component.key} returned an error while validating remote value: ${data}`, context, 'validate:validateRemoteSelectValue');
        }
        catch (err) {
            throw new error_1.ProcessorError(`Component with path ${component.key} returned an error while validating remote value: ${err}`, context, 'validate:validateRemoteSelectValue');
        }
    }
    catch (err) {
        console.error((0, error_2.getErrorMessage)(err));
        return null;
    }
});
exports.validateUrlSelectValue = validateUrlSelectValue;
exports.validateUrlSelectValueInfo = {
    name: 'validateUrlSelectValue',
    process: exports.validateUrlSelectValue,
    shouldProcess: exports.shouldValidate,
};
