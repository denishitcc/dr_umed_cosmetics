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
exports.validateNumberInfo = exports.validateNumberSync = exports.validateNumber = exports.shouldValidate = void 0;
const FieldError_1 = require("../../../error/FieldError");
const isValidatableNumberComponent = (component) => {
    return component && component.type === 'number';
};
const shouldValidate = (context) => {
    const { component, value } = context;
    if (!value) {
        return false;
    }
    if (!isValidatableNumberComponent(component)) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateNumber = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.validateNumberSync)(context);
});
exports.validateNumber = validateNumber;
const validateNumberSync = (context) => {
    const error = new FieldError_1.FieldError('number', context);
    const { value } = context;
    if (typeof value !== 'number') {
        return error;
    }
    return null;
};
exports.validateNumberSync = validateNumberSync;
exports.validateNumberInfo = {
    name: 'validateNumber',
    process: exports.validateNumber,
    processSync: exports.validateNumberSync,
    shouldProcess: exports.shouldValidate,
};
