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
exports.validateValuePropertyInfo = exports.validateValuePropertySync = exports.validateValueProperty = exports.shouldValidate = void 0;
const lodash_1 = require("lodash");
const error_1 = require("../../../error");
const isValidatableListComponent = (comp) => {
    return (comp &&
        comp.type &&
        (comp.type === "radio" ||
            comp.type === "selectboxes" ||
            comp.type === "select"));
};
const shouldValidate = (context) => {
    const { component, value } = context;
    if (!isValidatableListComponent(component)) {
        return false;
    }
    if (component.dataSrc !== 'url') {
        return false;
    }
    if (!value || (typeof value === 'object' && (0, lodash_1.isEmpty)(value))) {
        return false;
    }
    const valueProperty = component.valueProperty;
    if (!valueProperty) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateValueProperty = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.validateValuePropertySync)(context);
});
exports.validateValueProperty = validateValueProperty;
const validateValuePropertySync = (context) => {
    const { component, value } = context;
    if (!(0, exports.shouldValidate)(context)) {
        return null;
    }
    const error = new error_1.FieldError('invalidValueProperty', context);
    // TODO: at some point in the radio component's change pipeline, object values are coerced into strings; testing for
    // '[object Object]' is an ugly way to determine whether or not the ValueProperty is invalid, but it'll have to do
    // for now
    if (component.inputType === 'radio' && ((0, lodash_1.isUndefined)(value) || (0, lodash_1.isObject)(value) || value === '[object Object]')) {
        return error;
    }
    // TODO: a cousin to the above issue, but sometimes ValueProperty will resolve to a boolean value so the keys in
    // e.g. SelectBoxes components will strings coerced from booleans; again, not pretty, but good enough for now
    else if (component.inputType !== 'radio') {
        if (Object.entries(value).some(([key, value]) => value && (key === '[object Object]' || key === 'true' || key === 'false'))) {
            return error;
        }
    }
    return null;
};
exports.validateValuePropertySync = validateValuePropertySync;
exports.validateValuePropertyInfo = {
    name: 'validateValueProperty',
    process: exports.validateValueProperty,
    processSync: exports.validateValuePropertySync,
    shouldProcess: exports.shouldValidate
};
