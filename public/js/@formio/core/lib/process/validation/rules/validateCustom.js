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
exports.validateCustomInfo = exports.validateCustomSync = exports.shouldValidate = exports.validateCustom = void 0;
const error_1 = require("../../../error");
const utils_1 = require("../../../utils");
const validateCustom = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.validateCustomSync)(context);
});
exports.validateCustom = validateCustom;
const shouldValidate = (context) => {
    var _a;
    const { component } = context;
    const customValidation = (_a = component.validate) === null || _a === void 0 ? void 0 : _a.custom;
    if (!customValidation) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateCustomSync = (context) => {
    var _a;
    const { component, data, row, value, index, instance, evalContext } = context;
    const customValidation = (_a = component.validate) === null || _a === void 0 ? void 0 : _a.custom;
    try {
        if (!(0, exports.shouldValidate)(context)) {
            return null;
        }
        const evalContextValue = Object.assign(Object.assign({}, ((instance === null || instance === void 0 ? void 0 : instance.evalContext) ? instance.evalContext() : (evalContext ? evalContext(context) : context))), { component,
            data,
            row, rowIndex: index, instance, valid: true, input: value });
        const isValid = utils_1.Evaluator.evaluate(customValidation, evalContextValue, 'valid', true, {}, {});
        if (isValid === null || isValid === true) {
            return null;
        }
        return new error_1.FieldError(typeof isValid === 'string' ? isValid : 'custom', Object.assign(Object.assign({}, context), { hasLabel: false, setting: customValidation }), 'custom');
    }
    catch (err) {
        throw new error_1.ProcessorError(err.message || err, context, 'validate:validateCustom');
    }
};
exports.validateCustomSync = validateCustomSync;
exports.validateCustomInfo = {
    name: 'validateCustom',
    process: exports.validateCustom,
    processSync: exports.validateCustomSync,
    shouldProcess: exports.shouldValidate
};
