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
exports.validateDayInfo = exports.validateDaySync = exports.validateDay = exports.shouldValidate = void 0;
const error_1 = require("../../../error");
const isLeapYear = (year) => {
    // Year is leap if it is evenly divisible by 400 or evenly divisible by 4 and not evenly divisible by 100.
    return !(year % 400) || (!!(year % 100) && !(year % 4));
};
const getDaysInMonthCount = (month, year) => {
    switch (month) {
        case 1: // January
        case 3: // March
        case 5: // May
        case 7: // July
        case 8: // August
        case 10: // October
        case 12: // December
            return 31;
        case 4: // April
        case 6: // June
        case 9: // September
        case 11: // November
            return 30;
        case 2: // February
            return isLeapYear(year) ? 29 : 28;
        default:
            return 31;
    }
};
const isDayComponent = (component) => {
    return component && component.type === 'day';
};
const shouldValidate = (context) => {
    const { component, value } = context;
    if (!value) {
        return false;
    }
    if (!isDayComponent(component)) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateDay = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.validateDaySync)(context);
});
exports.validateDay = validateDay;
const validateDaySync = (context) => {
    const { component, value } = context;
    if (!(0, exports.shouldValidate)(context)) {
        return null;
    }
    const error = new error_1.FieldError('invalidDay', context, 'day');
    if (typeof value !== 'string') {
        return error;
    }
    const [DAY, MONTH, YEAR] = component.dayFirst ? [0, 1, 2] : [1, 0, 2];
    const values = value.split('/').map((x) => parseInt(x, 10)), day = values[DAY], month = values[MONTH], year = values[YEAR], maxDay = getDaysInMonthCount(month, year);
    if (isNaN(day) || day < 0 || day > maxDay) {
        return error;
    }
    if (isNaN(month) || month < 0 || month > 12) {
        return error;
    }
    if (isNaN(year) || year < 0 || year > 9999) {
        return error;
    }
    return null;
};
exports.validateDaySync = validateDaySync;
exports.validateDayInfo = {
    name: 'validateDay',
    process: exports.validateDay,
    processSync: exports.validateDaySync,
    shouldProcess: exports.shouldValidate
};
