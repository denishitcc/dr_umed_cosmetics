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
exports.validateMaximumLengthInfo = exports.validateMaximumLengthSync = exports.validateMaximumLength = exports.shouldValidate = void 0;
const error_1 = require("../../../error");
const isValidatableTextFieldComponent = (component) => {
    var _a;
    return component && ((_a = component.validate) === null || _a === void 0 ? void 0 : _a.hasOwnProperty('maxLength'));
};
const getValidationSetting = (component) => {
    var _a;
    let maxLength = (_a = component.validate) === null || _a === void 0 ? void 0 : _a.maxLength;
    maxLength = (typeof maxLength === 'string') ? parseInt(maxLength, 10) : maxLength;
    return maxLength;
};
const shouldValidate = (context) => {
    const { component, value } = context;
    if (!isValidatableTextFieldComponent(component)) {
        return false;
    }
    if (!value) {
        return false;
    }
    if (typeof value !== 'string') {
        return false;
    }
    const setting = getValidationSetting(component);
    if (setting === undefined) {
        return false;
    }
    if (!setting || Number.isNaN(setting)) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateMaximumLength = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.validateMaximumLengthSync)(context);
});
exports.validateMaximumLength = validateMaximumLength;
const validateMaximumLengthSync = (context) => {
    const { component, value } = context;
    if (!(0, exports.shouldValidate)(context)) {
        return null;
    }
    const maxLength = getValidationSetting(component);
    if (maxLength === undefined || Number.isNaN(maxLength)) {
        return null;
    }
    if (!value || typeof value !== 'string') {
        return null;
    }
    if (value.length > maxLength) {
        const error = new error_1.FieldError('maxLength', Object.assign(Object.assign({}, context), { length: String(maxLength), setting: String(maxLength) }));
        return error;
    }
    return null;
};
exports.validateMaximumLengthSync = validateMaximumLengthSync;
exports.validateMaximumLengthInfo = {
    name: 'validateMaximumLength',
    process: exports.validateMaximumLength,
    processSync: exports.validateMaximumLengthSync,
    shouldProcess: exports.shouldValidate,
};
