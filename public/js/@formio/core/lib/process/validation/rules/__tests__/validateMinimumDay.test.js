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
const validateMinimumDay_1 = require("../validateMinimumDay");
it('Validating a non-day component will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleTextField;
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMinimumDay_1.validateMinimumDay)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a day component with a day before the minimum day will return a FieldError', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleDayField), { minDate: '2023-04-01' });
    const data = {
        component: '03/23/2023',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMinimumDay_1.validateMinimumDay)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('minDay');
}));
it('Validating a day component with a day after the minimum day will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleDayField), { minDate: '2023-04-01' });
    const data = {
        component: '04/02/2023',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMinimumDay_1.validateMinimumDay)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a day-first day component with a day before the minimum day will return a FieldError', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleDayField), { dayFirst: true, minDate: '2023-04-01' });
    const data = {
        component: '02/02/2023',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMinimumDay_1.validateMinimumDay)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.contain('minDay');
}));
it('Validating a day-first day component with a day after the minimum day will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleDayField), { dayFirst: true, minDate: '2023-04-01' });
    const data = {
        component: '23/04/2023',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMinimumDay_1.validateMinimumDay)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
