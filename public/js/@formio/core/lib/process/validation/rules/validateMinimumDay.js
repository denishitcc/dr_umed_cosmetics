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
exports.validateMinimumDayInfo = exports.validateMinimumDaySync = exports.validateMinimumDay = exports.shouldValidate = void 0;
const error_1 = require("../../../error");
const date_1 = require("../../../utils/date");
const isValidatableDayComponent = (component) => {
    return component && component.type === 'day' && component.hasOwnProperty('minDate');
};
const shouldValidate = (context) => {
    const { component, value } = context;
    if (!isValidatableDayComponent(component)) {
        return false;
    }
    if ((0, date_1.isPartialDay)(component, value)) {
        return false;
    }
    if ((0, date_1.getDateSetting)(component.minDate) === null) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateMinimumDay = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.validateMinimumDaySync)(context);
});
exports.validateMinimumDay = validateMinimumDay;
const validateMinimumDaySync = (context) => {
    const { component, value } = context;
    if (!(0, exports.shouldValidate)(context)) {
        return null;
    }
    if (typeof value !== 'string') {
        throw new error_1.ProcessorError(`Cannot validate day value ${value} because it is not a string`, context, 'validate:validateMinimumDay');
    }
    const date = (0, date_1.getDateValidationFormat)(component)
        ? (0, date_1.dayjs)(value, (0, date_1.getDateValidationFormat)(component))
        : (0, date_1.dayjs)(value);
    const minDate = (0, date_1.getDateSetting)(component.minDate);
    if (minDate === null) {
        return null;
    }
    else {
        minDate.setHours(0, 0, 0, 0);
    }
    const error = new error_1.FieldError('minDay', Object.assign(Object.assign({}, context), { minDate: String(minDate), setting: String(minDate) }));
    return date.isAfter(minDate) || date.isSame(minDate) ? null : error;
};
exports.validateMinimumDaySync = validateMinimumDaySync;
exports.validateMinimumDayInfo = {
    name: 'validateMinimumDay',
    process: exports.validateMinimumDay,
    processSync: exports.validateMinimumDaySync,
    shouldProcess: exports.shouldValidate,
};
