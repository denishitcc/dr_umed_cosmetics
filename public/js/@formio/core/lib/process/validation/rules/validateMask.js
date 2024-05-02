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
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.validateMaskInfo = exports.validateMaskSync = exports.validateMask = exports.shouldValidate = exports.matchInputMask = void 0;
const lodash_1 = require("lodash");
const error_1 = require("../../../error");
const inputmask_1 = __importDefault(require("inputmask"));
const isMaskType = (obj) => {
    return ((obj === null || obj === void 0 ? void 0 : obj.maskName) &&
        typeof (obj === null || obj === void 0 ? void 0 : obj.maskName) === 'string' &&
        (obj === null || obj === void 0 ? void 0 : obj.value) &&
        typeof (obj === null || obj === void 0 ? void 0 : obj.value) === 'string');
};
const isValidatableComponent = (component) => {
    // For some reason we skip mask validation for time components
    return ((component && component.type && component.type !== 'time') &&
        (component && component.hasOwnProperty('inputMask') && !!component.inputMask) ||
        (component && component.hasOwnProperty('inputMasks') && !(0, lodash_1.isEmpty)(component.inputMasks)));
};
function getMaskByLabel(component, maskName) {
    var _a;
    if (maskName) {
        const inputMask = (_a = component.inputMasks) === null || _a === void 0 ? void 0 : _a.find((inputMask) => {
            return inputMask.label === maskName;
        });
        return inputMask ? inputMask.mask : undefined;
    }
    return;
}
function getInputMask(mask, placeholderChar) {
    if (mask instanceof Array) {
        return mask;
    }
    const maskArray = [];
    for (let i = 0; i < mask.length; i++) {
        switch (mask[i]) {
            case '9':
                maskArray.push(/\d/);
                break;
            case 'A':
                maskArray.push(/[a-zA-Z]/);
                break;
            case 'a':
                maskArray.push(/[a-z]/);
                break;
            case '*':
                maskArray.push(/[a-zA-Z0-9]/);
                break;
            // If char which is used inside mask placeholder was used in the mask, replace it with space to prevent errors
            case placeholderChar:
                maskArray.push(' ');
                break;
            default:
                maskArray.push(mask[i]);
                break;
        }
    }
    return maskArray;
}
function matchInputMask(value, inputMask) {
    if (!inputMask) {
        return true;
    }
    // If value is longer than mask, it isn't valid.
    if (value.length > inputMask.length) {
        return false;
    }
    for (let i = 0; i < inputMask.length; i++) {
        const char = value[i];
        const charPart = inputMask[i];
        if (charPart instanceof RegExp) {
            if (!charPart.test(char)) {
                return false;
            }
            continue;
        }
        else if (charPart !== char) {
            return false;
        }
    }
    return true;
}
exports.matchInputMask = matchInputMask;
const shouldValidate = (context) => {
    var _a;
    const { component, value } = context;
    if (!isValidatableComponent(component) || !value) {
        return false;
    }
    if (value == null) {
        return false;
    }
    if (component.allowMultipleMasks && ((_a = component.inputMasks) === null || _a === void 0 ? void 0 : _a.length)) {
        const mask = value && isMaskType(value) ? value : undefined;
        const formioInputMask = getMaskByLabel(component, mask === null || mask === void 0 ? void 0 : mask.maskName);
        if (formioInputMask && !getInputMask(formioInputMask)) {
            return false;
        }
    }
    else if (!getInputMask(component.inputMask || '')) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateMask = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.validateMaskSync)(context);
});
exports.validateMask = validateMask;
// TODO: this function has side effects
const validateMaskSync = (context) => {
    var _a;
    const { component, value } = context;
    if (!(0, exports.shouldValidate)(context)) {
        return null;
    }
    let inputMask;
    let maskValue;
    if (component.allowMultipleMasks && ((_a = component.inputMasks) === null || _a === void 0 ? void 0 : _a.length)) {
        const mask = value && isMaskType(value) ? value : undefined;
        const formioInputMask = getMaskByLabel(component, mask === null || mask === void 0 ? void 0 : mask.maskName);
        if (formioInputMask) {
            inputMask = formioInputMask;
        }
        maskValue = mask === null || mask === void 0 ? void 0 : mask.value;
    }
    else {
        inputMask = component.inputMask || '';
    }
    if (!inputMask) {
        return null;
    }
    if (value && inputMask && typeof value === 'string' && component.type === 'textfield') {
        return inputmask_1.default.isValid(value, { mask: inputMask.toString() }) ? null : new error_1.FieldError('mask', context);
    }
    let inputMaskArr = getInputMask(inputMask);
    if (value != null && inputMaskArr) {
        const error = new error_1.FieldError('mask', context);
        return matchInputMask(maskValue || value, inputMaskArr) ? null : error;
    }
    return null;
};
exports.validateMaskSync = validateMaskSync;
exports.validateMaskInfo = {
    name: 'validateMask',
    process: exports.validateMask,
    processSync: exports.validateMaskSync,
    shouldProcess: exports.shouldValidate,
};
