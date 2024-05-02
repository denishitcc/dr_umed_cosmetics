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
const chai_1 = require("chai");
const error_1 = require("../../../../error");
const util_1 = require("./fixtures/util");
const validateTime_1 = require("../validateTime");
const timeField = {
    type: 'time',
    key: 'time',
    label: 'Time',
    input: true,
    dataFormat: 'HH:mm:ss'
};
it('Should validate a time component with a valid time value', () => __awaiter(void 0, void 0, void 0, function* () {
    const data = { time: '12:00:00' };
    const context = (0, util_1.generateProcessorContext)(timeField, data);
    const result = yield (0, validateTime_1.validateTime)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Should return a FieldError when validating a time component with an invalid time value', () => __awaiter(void 0, void 0, void 0, function* () {
    const data = { time: '25:00:00' };
    const context = (0, util_1.generateProcessorContext)(timeField, data);
    const result = yield (0, validateTime_1.validateTime)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.contain('time');
}));
it('Should return a FieldError when validating a time component with a valid format but one that does not match the dataFormat', () => __awaiter(void 0, void 0, void 0, function* () {
    const data = { time: '12:00' };
    const context = (0, util_1.generateProcessorContext)(timeField, data);
    const result = yield (0, validateTime_1.validateTime)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.contain('time');
}));
it('Should return a FieldError when validating a time component with an invalid format', () => __awaiter(void 0, void 0, void 0, function* () {
    const data = { time: '12:' };
    const context = (0, util_1.generateProcessorContext)(timeField, data);
    const result = yield (0, validateTime_1.validateTime)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.contain('time');
}));
