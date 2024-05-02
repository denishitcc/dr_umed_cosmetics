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
const validateMaximumYear_1 = require("../validateMaximumYear");
it('Validating a component without the maxYear parameter will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleTextField;
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMaximumYear_1.validateMaximumYear)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a day component without the maxYear parameter will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleDayField;
    const data = {
        component: '01/22/2023',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMaximumYear_1.validateMaximumYear)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a day component with the maxYear parameter will return a FieldError if the year is greater than the maximum', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleDayField), { fields: Object.assign(Object.assign({}, components_1.simpleDayField.fields), { year: Object.assign(Object.assign({}, components_1.simpleDayField.fields.year), { maxYear: '2022' }) }), maxYear: '2022' });
    const data = {
        component: '01/22/2023',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMaximumYear_1.validateMaximumYear)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('maxYear');
}));
it('Validating a day component with the maxYear parameter will return null if the year is equal to the maximum', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleDayField), { fields: Object.assign(Object.assign({}, components_1.simpleDayField.fields), { year: Object.assign(Object.assign({}, components_1.simpleDayField.fields.year), { maxYear: '2022' }) }), maxYear: '2022' });
    const data = {
        component: '01/22/2022',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMaximumYear_1.validateMaximumYear)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a day component with the maxYear parameter will return null if the year is less than the maximum', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleDayField), { fields: Object.assign(Object.assign({}, components_1.simpleDayField.fields), { year: Object.assign(Object.assign({}, components_1.simpleDayField.fields.year), { maxYear: '2022' }) }), maxYear: '2022' });
    const data = {
        component: '01/22/2021',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMaximumYear_1.validateMaximumYear)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
