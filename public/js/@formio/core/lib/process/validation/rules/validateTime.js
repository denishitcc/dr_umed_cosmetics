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
exports.validateTimeInfo = exports.validateTime = exports.validateTimeSync = exports.shouldValidate = void 0;
const formUtil_1 = require("../../../utils/formUtil");
const error_1 = require("../../../error");
const date_1 = require("../../../utils/date");
const customParseFormat_1 = __importDefault(require("dayjs/plugin/customParseFormat"));
date_1.dayjs.extend(customParseFormat_1.default);
const isValidatableTimeComponent = (comp) => {
    return comp && comp.type === 'time';
};
const shouldValidate = (context) => {
    const { component, value } = context;
    if (!isValidatableTimeComponent(component)) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateTimeSync = (context) => {
    const { component, data, path, value, config } = context;
    if (!(0, exports.shouldValidate)(context)) {
        return null;
    }
    try {
        if (!value || (0, formUtil_1.isComponentDataEmpty)(component, data, path))
            return null;
        // Server side evaluations of validity should use the "dataFormat" vs the "format" which is used on the client.
        const format = (config === null || config === void 0 ? void 0 : config.server) ?
            (component.dataFormat || 'HH:mm:ss') :
            (component.format || 'HH:mm');
        const isValid = (0, date_1.dayjs)(String(value), format, true).isValid();
        return isValid ? null : new error_1.FieldError('time', context);
    }
    catch (err) {
        throw new error_1.ProcessorError(`Could not validate time component ${component.key} with value ${value}`, context, 'validate:validateTime');
    }
};
exports.validateTimeSync = validateTimeSync;
const validateTime = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.validateTimeSync)(context);
});
exports.validateTime = validateTime;
exports.validateTimeInfo = {
    name: 'validateTime',
    process: exports.validateTime,
    processSync: exports.validateTimeSync,
    shouldProcess: exports.shouldValidate,
};
