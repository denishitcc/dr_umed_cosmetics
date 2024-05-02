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
exports.validateRequiredInfo = exports.validateRequiredSync = exports.validateRequired = exports.shouldValidate = void 0;
const error_1 = require("../../../error");
const util_1 = require("../util");
const isAddressComponent = (component) => {
    return component.type === 'address';
};
const isDayComponent = (component) => {
    return component.type === 'day';
};
const isAddressComponentDataObject = (value) => {
    return value !== null && typeof value === 'object' && value.mode && value.address && typeof value.address === 'object';
};
// Checkboxes and selectboxes consider false to be falsy, whereas other components with
// settable values (e.g. radio, select, datamap, container, etc.) consider it truthy
const isComponentThatCannotHaveFalseValue = (component) => {
    return component.type === 'checkbox' || component.type === 'selectboxes';
};
const valueIsPresent = (value, considerFalseTruthy) => {
    // Evaluate for 3 out of 6 falsy values ("", null, undefined), don't check for 0
    // and only check for false under certain conditions
    if (value === null || value === undefined || value === "" || (!considerFalseTruthy && value === false)) {
        return false;
    }
    // Evaluate for empty object
    else if ((0, util_1.isEmptyObject)(value)) {
        return false;
    }
    // Evaluate for empty array
    else if (Array.isArray(value) && value.length === 0) {
        return false;
    }
    // Recursively evaluate
    else if (typeof value === 'object') {
        return Object.values(value).some((val) => valueIsPresent(val, considerFalseTruthy));
    }
    return true;
};
const shouldValidate = (context) => {
    var _a;
    const { component } = context;
    if (((_a = component.validate) === null || _a === void 0 ? void 0 : _a.required) && !component.hidden) {
        return true;
    }
    return false;
};
exports.shouldValidate = shouldValidate;
const validateRequired = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.validateRequiredSync)(context);
});
exports.validateRequired = validateRequired;
const validateRequiredSync = (context) => {
    const error = new error_1.FieldError('required', Object.assign(Object.assign({}, context), { setting: true }));
    const { component, value } = context;
    if (!(0, exports.shouldValidate)(context)) {
        return null;
    }
    if (isAddressComponent(component) && isAddressComponentDataObject(value)) {
        return (0, util_1.isEmptyObject)(value.address) ? error : Object.values(value.address).every((val) => !!val) ? null : error;
    }
    else if (isDayComponent(component) && value === '00/00/0000') {
        return error;
    }
    else if (isComponentThatCannotHaveFalseValue(component)) {
        return !valueIsPresent(value, false) ? error : null;
    }
    return !valueIsPresent(value, true) ? error : null;
};
exports.validateRequiredSync = validateRequiredSync;
exports.validateRequiredInfo = {
    name: 'validateRequired',
    process: exports.validateRequired,
    processSync: exports.validateRequiredSync,
    shouldProcess: exports.shouldValidate,
};
