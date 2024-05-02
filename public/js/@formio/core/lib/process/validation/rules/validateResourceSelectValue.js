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
exports.validateResourceSelectValueInfo = exports.validateResourceSelectValue = exports.shouldValidate = exports.generateUrl = void 0;
const error_1 = require("../../../error");
const util_1 = require("../util");
const isValidatableSelectComponent = (component) => {
    var _a;
    return (component &&
        component.type === 'select' &&
        (0, util_1.toBoolean)(component.dataSrc === 'resource') &&
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
    if (component.dataSrc !== 'resource' || !((_a = component.data) === null || _a === void 0 ? void 0 : _a.resource)) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateResourceSelectValue = (context) => __awaiter(void 0, void 0, void 0, function* () {
    var _a;
    const { value, config, component } = context;
    if (!(0, exports.shouldValidate)(context)) {
        return null;
    }
    if (!config || !config.database) {
        throw new error_1.ProcessorError("Can't validate for resource value without a database config object", context, 'validate:validateResourceSelectValue');
    }
    try {
        const resourceSelectValueResult = yield ((_a = config.database) === null || _a === void 0 ? void 0 : _a.validateResourceSelectValue(context, value));
        return (resourceSelectValueResult === true) ? null : new error_1.FieldError('select', context);
    }
    catch (err) {
        throw new error_1.ProcessorError(err.message || err, context, 'validate:validateResourceSelectValue');
    }
});
exports.validateResourceSelectValue = validateResourceSelectValue;
exports.validateResourceSelectValueInfo = {
    name: 'validateResourceSelectValue',
    process: exports.validateResourceSelectValue,
    shouldProcess: exports.shouldValidate,
};
