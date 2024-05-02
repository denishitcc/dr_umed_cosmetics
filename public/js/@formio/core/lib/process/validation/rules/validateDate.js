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
exports.validateDateInfo = exports.validateDateSync = exports.validateDate = exports.shouldValidate = void 0;
const error_1 = require("../../../error");
const isValidatableDateTimeComponent = (obj) => {
    return !!obj && !!obj.type && obj.type === 'datetime';
};
const isValidatableTextFieldComponent = (obj) => {
    return !!obj && !!obj.type && obj.widget && obj.widget.type === 'calendar';
};
const isValidatable = (component) => {
    return isValidatableDateTimeComponent(component) || isValidatableTextFieldComponent(component);
};
const shouldValidate = (context) => {
    const { component, value } = context;
    if (!value || !isValidatable(component)) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateDate = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.validateDateSync)(context);
});
exports.validateDate = validateDate;
const validateDateSync = (context) => {
    const error = new error_1.FieldError('invalidDate', context, 'date');
    const { component, value } = context;
    if (!(0, exports.shouldValidate)(context)) {
        return null;
    }
    // TODO: is this right?
    if (typeof value === 'string') {
        if (value.toLowerCase() === 'invalid date') {
            return error;
        }
        if (new Date(value).toString() === 'Invalid Date') {
            return error;
        }
        return null;
    }
    else if (value instanceof Date) {
        return value.toString() !== 'Invalid Date' ? null : error;
    }
    return error;
};
exports.validateDateSync = validateDateSync;
exports.validateDateInfo = {
    name: 'validateDate',
    process: exports.validateDate,
    processSync: exports.validateDateSync,
    shouldProcess: exports.shouldValidate
};
