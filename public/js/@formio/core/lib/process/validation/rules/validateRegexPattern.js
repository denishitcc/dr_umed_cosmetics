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
exports.validateRegexPatternInfo = exports.validateRegexPatternSync = exports.validateRegexPattern = exports.shouldValidate = void 0;
const error_1 = require("../../../error");
const isValidatableTextFieldComponent = (component) => {
    var _a;
    return component && ((_a = component.validate) === null || _a === void 0 ? void 0 : _a.hasOwnProperty('pattern'));
};
const shouldValidate = (context) => {
    var _a;
    const { component, value } = context;
    if (!isValidatableTextFieldComponent(component) || !value) {
        return false;
    }
    const pattern = (_a = component.validate) === null || _a === void 0 ? void 0 : _a.pattern;
    if (!pattern) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateRegexPattern = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.validateRegexPatternSync)(context);
});
exports.validateRegexPattern = validateRegexPattern;
const validateRegexPatternSync = (context) => {
    var _a, _b;
    const { component, value } = context;
    if (!(0, exports.shouldValidate)(context) || !isValidatableTextFieldComponent(component)) {
        return null;
    }
    const pattern = (_a = component.validate) === null || _a === void 0 ? void 0 : _a.pattern;
    const regex = new RegExp(`^${pattern}$`);
    return typeof value === 'string' && regex.test(value)
        ? null
        : new error_1.FieldError(((_b = component.validate) === null || _b === void 0 ? void 0 : _b.patternMessage) || 'pattern', Object.assign(Object.assign({}, context), { regex: pattern, pattern: pattern, setting: pattern }), 'pattern');
};
exports.validateRegexPatternSync = validateRegexPatternSync;
exports.validateRegexPatternInfo = {
    name: 'validateRegexPattern',
    process: exports.validateRegexPattern,
    processSync: exports.validateRegexPatternSync,
    shouldProcess: exports.shouldValidate,
};
