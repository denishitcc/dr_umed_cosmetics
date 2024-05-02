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
const validateMinimumYear_1 = require("../validateMinimumYear");
it('Validating a component without the minYear parameter will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleTextField;
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMinimumYear_1.validateMinimumYear)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a day component without the minYear parameter will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleDayField;
    const data = {
        component: '01/22/2023',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMinimumYear_1.validateMinimumYear)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a day component with the minYear parameter will return a FieldError if the year is less than the minimum', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleDayField), { fields: Object.assign(Object.assign({}, components_1.simpleDayField.fields), { year: Object.assign(Object.assign({}, components_1.simpleDayField.fields.year), { minYear: '2023' }) }), minYear: '2023' });
    const data = {
        component: '01/22/2022',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMinimumYear_1.validateMinimumYear)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.contain('minYear');
}));
it('Validating a day component with the minYear parameter will return null if the year is equal to the minimum', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleDayField), { fields: Object.assign(Object.assign({}, components_1.simpleDayField.fields), { year: Object.assign(Object.assign({}, components_1.simpleDayField.fields.year), { minYear: '2022' }) }), minYear: '2022' });
    const data = {
        component: '01/22/2022',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMinimumYear_1.validateMinimumYear)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a day component with the minYear parameter will return null if the year is greater than the minimum', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleDayField), { fields: Object.assign(Object.assign({}, components_1.simpleDayField.fields), { year: Object.assign(Object.assign({}, components_1.simpleDayField.fields.year), { minYear: '2022' }) }), minYear: '2022' });
    const data = {
        component: '01/22/2023',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMinimumYear_1.validateMinimumYear)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
