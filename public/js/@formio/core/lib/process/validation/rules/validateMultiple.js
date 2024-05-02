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
exports.validateMultipleInfo = exports.validateMultipleSync = exports.validateMultiple = exports.shouldValidate = exports.emptyValueIsArray = exports.isEligible = void 0;
const lodash_1 = require("lodash");
const error_1 = require("../../../error");
const isEligible = (component) => {
    // TODO: would be nice if this was type safe
    switch (component.type) {
        case 'hidden':
        case 'address':
            if (!component.multiple) {
                return false;
            }
            return true;
        case 'textArea':
            if (!component.as || component.as !== 'json') {
                return false;
            }
            return true;
        // TODO: For backwards compatibility, skip multiple validation for select components until we can investigate
        // how this validation might break existing forms
        case 'select':
            return false;
        default:
            return true;
    }
};
exports.isEligible = isEligible;
const emptyValueIsArray = (component) => {
    // TODO: How do we infer the data model of the compoennt given only its JSON? For now, we have to hardcode component types
    switch (component.type) {
        case 'datagrid':
        case 'editgrid':
        case 'tagpad':
        case 'sketchpad':
        case 'datatable':
        case 'dynamicWizard':
        case 'file':
            return true;
        case 'select':
            return !!component.multiple;
        case 'tags':
            return component.storeas !== 'string';
        default:
            return false;
    }
};
exports.emptyValueIsArray = emptyValueIsArray;
const shouldValidate = (context) => {
    const { component } = context;
    if (!(0, exports.isEligible)(component)) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateMultiple = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.validateMultipleSync)(context);
});
exports.validateMultiple = validateMultiple;
const validateMultipleSync = (context) => {
    var _a;
    const { component, value } = context;
    // Skip multiple validation if the component tells us to
    if (!(0, exports.isEligible)(component)) {
        return null;
    }
    const shouldBeArray = !!component.multiple;
    const isRequired = !!((_a = component.validate) === null || _a === void 0 ? void 0 : _a.required);
    const isArray = Array.isArray(value);
    if (shouldBeArray) {
        if (isArray) {
            return isRequired ? value.length > 0 ? null : new error_1.FieldError('array_nonempty', Object.assign(Object.assign({}, context), { setting: true })) : null;
        }
        else {
            const error = new error_1.FieldError('array', Object.assign(Object.assign({}, context), { setting: true }));
            // Null/undefined is ok if this value isn't required; anything else should fail
            return (0, lodash_1.isNil)(value) ? isRequired ? error : null : error;
        }
    }
    else {
        const canBeArray = (0, exports.emptyValueIsArray)(component);
        if (!canBeArray && isArray) {
            return new error_1.FieldError('nonarray', Object.assign(Object.assign({}, context), { setting: false }));
        }
        return null;
    }
};
exports.validateMultipleSync = validateMultipleSync;
exports.validateMultipleInfo = {
    name: 'validateMultiple',
    process: exports.validateMultiple,
    fullValue: true,
    processSync: exports.validateMultipleSync,
    shouldProcess: exports.shouldValidate,
};
