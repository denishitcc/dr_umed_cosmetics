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
exports.validateMaximumDayInfo = exports.validateMaximumDaySync = exports.validateMaximumDay = exports.shouldValidate = void 0;
const error_1 = require("../../../error");
const date_1 = require("../../../utils/date");
const isValidatableDayComponent = (component) => {
    return component && component.type === 'day' && component.hasOwnProperty('maxDate');
};
const shouldValidate = (context) => {
    const { component, value } = context;
    if (!isValidatableDayComponent(component)) {
        return false;
    }
    if ((0, date_1.isPartialDay)(component, value)) {
        return false;
    }
    if (!(0, date_1.getDateSetting)(component.maxDate)) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateMaximumDay = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.validateMaximumDaySync)(context);
});
exports.validateMaximumDay = validateMaximumDay;
const validateMaximumDaySync = (context) => {
    const { component, value } = context;
    if (!(0, exports.shouldValidate)(context)) {
        return null;
    }
    if (typeof value !== 'string') {
        throw new error_1.ProcessorError(`Cannot validate day value ${value} because it is not a string`, context, 'validate:validateMaximumDay');
    }
    // TODO: this validation probably goes for dates and days
    const format = (0, date_1.getDateValidationFormat)(component);
    const date = (0, date_1.dayjs)(value, format);
    const maxDate = (0, date_1.getDateSetting)(component.maxDate);
    if (maxDate === null) {
        return null;
    }
    else {
        maxDate.setHours(0, 0, 0, 0);
    }
    const error = new error_1.FieldError('maxDay', Object.assign(Object.assign({}, context), { maxDate: String(maxDate), setting: String(maxDate) }));
    return date.isBefore((0, date_1.dayjs)(maxDate)) || date.isSame((0, date_1.dayjs)(maxDate)) ? null : error;
};
exports.validateMaximumDaySync = validateMaximumDaySync;
exports.validateMaximumDayInfo = {
    name: 'validateMaximumDay',
    process: exports.validateMaximumDay,
    processSync: exports.validateMaximumDaySync,
    shouldProcess: exports.shouldValidate,
};
