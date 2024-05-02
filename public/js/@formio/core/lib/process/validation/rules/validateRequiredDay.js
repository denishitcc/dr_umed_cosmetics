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
exports.validateRequiredDayInfo = exports.validateRequiredDaySync = exports.validateRequiredDay = exports.shouldValidate = void 0;
const error_1 = require("../../../error");
const isValidatableDayComponent = (component) => {
    return (component &&
        component.type === 'day' &&
        component.fields.day &&
        component.fields.day.required);
};
const shouldValidate = (context) => {
    const { component } = context;
    if (!isValidatableDayComponent(component)) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateRequiredDay = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.validateRequiredDaySync)(context);
});
exports.validateRequiredDay = validateRequiredDay;
const validateRequiredDaySync = (context) => {
    const { component, value } = context;
    if (!(0, exports.shouldValidate)(context)) {
        return null;
    }
    if (!value) {
        return new error_1.FieldError('requiredDayEmpty', context, 'day');
    }
    if (typeof value !== 'string') {
        throw new error_1.ProcessorError(`Cannot validate required day field of ${value} because it is not a string`, context, 'validate:validateRequiredDay');
    }
    const [DAY, MONTH, YEAR] = component.dayFirst ? [0, 1, 2] : [1, 0, 2];
    const values = value.split('/').map((x) => parseInt(x, 10)), day = values[DAY], month = values[MONTH], year = values[YEAR];
    if (!day && component.fields.day.required === true) {
        return new error_1.FieldError('requiredDayField', context, 'day');
    }
    if (!month && component.fields.month.required === true) {
        return new error_1.FieldError('requiredMonthField', context, 'day');
    }
    if (!year && component.fields.year.required === true) {
        return new error_1.FieldError('requiredYearField', context, 'day');
    }
    return null;
};
exports.validateRequiredDaySync = validateRequiredDaySync;
exports.validateRequiredDayInfo = {
    name: 'validateRequiredDay',
    process: exports.validateRequiredDay,
    processSync: exports.validateRequiredDaySync,
    shouldProcess: exports.shouldValidate,
};
