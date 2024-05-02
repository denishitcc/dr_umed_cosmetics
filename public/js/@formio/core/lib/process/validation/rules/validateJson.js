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
exports.validateJsonInfo = exports.validateJsonSync = exports.validateJson = exports.shouldValidate = void 0;
const jsonlogic_1 = __importDefault(require("../../../modules/jsonlogic"));
const error_1 = require("../../../error");
const lodash_1 = require("lodash");
const shouldValidate = (context) => {
    var _a;
    const { component } = context;
    if (!((_a = component.validate) === null || _a === void 0 ? void 0 : _a.json) || !(0, lodash_1.isObject)(component.validate.json)) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateJson = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.validateJsonSync)(context);
});
exports.validateJson = validateJson;
const validateJsonSync = (context) => {
    var _a;
    const { component, data, value, evalContext } = context;
    if (!(0, exports.shouldValidate)(context)) {
        return null;
    }
    const func = (_a = component === null || component === void 0 ? void 0 : component.validate) === null || _a === void 0 ? void 0 : _a.json;
    const evalContextValue = evalContext ? evalContext(context) : context;
    evalContextValue.value = value || null;
    const valid = jsonlogic_1.default.evaluator.evaluate(func, Object.assign(Object.assign({}, evalContextValue), { input: value }), 'valid');
    if (valid === null) {
        return null;
    }
    return valid === true
        ? null
        : new error_1.FieldError(valid || 'jsonLogic', Object.assign(Object.assign({}, context), { setting: func }), 'json');
};
exports.validateJsonSync = validateJsonSync;
exports.validateJsonInfo = {
    name: 'validateJson',
    process: exports.validateJson,
    processSync: exports.validateJsonSync,
    shouldProcess: exports.shouldValidate,
};
