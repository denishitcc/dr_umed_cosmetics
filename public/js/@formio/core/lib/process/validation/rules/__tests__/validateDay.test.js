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
const components_1 = require("./fixtures/components");
const util_1 = require("./fixtures/util");
const validateDay_1 = require("../validateDay");
it('Validating a non-day component will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleTextField;
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateDay_1.validateDay)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a day component with an invalid date string value will return a FieldError', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleDayField;
    const data = {
        component: 'hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateDay_1.validateDay)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('invalidDay');
}));
it('Validating a day component with an valid date string value will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleDayField;
    const data = {
        component: '03/23/2023',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateDay_1.validateDay)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a day component with an invalid Date object will return a FieldError', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleDayField;
    const data = {
        component: new Date('Hello, world!'),
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateDay_1.validateDay)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('invalidDay');
}));
it('Validating a day component with a valid Date object will return a field error', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleDayField;
    const data = {
        component: new Date(),
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateDay_1.validateDay)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('invalidDay');
}));
