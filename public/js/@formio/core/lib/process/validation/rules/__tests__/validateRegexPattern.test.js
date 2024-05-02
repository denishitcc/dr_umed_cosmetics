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
const validateRegexPattern_1 = require("../validateRegexPattern");
it('Validating a component without a pattern parameter will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleTextField;
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateRegexPattern_1.validateRegexPattern)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a component with a pattern parameter will return a FieldError if the value does not match the pattern', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { validate: { pattern: '\\d*' } });
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateRegexPattern_1.validateRegexPattern)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('pattern');
}));
it('Validating a component with a pattern parameter will return null if the value matches the pattern', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { validate: { pattern: '\\d*' } });
    const data = {
        component: '12345',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateRegexPattern_1.validateRegexPattern)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a component with an empty value will not trigger the pattern validation', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { validate: { pattern: '\\d' } });
    const data = {
        component: ''
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateRegexPattern_1.validateRegexPattern)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a component with a pattern parameter and a pattern message will return a FieldError if the value does not match the pattern', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { validate: { pattern: '\\d', patternMessage: 'Can only contain digits.' } });
    const data = {
        component: 'abc',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateRegexPattern_1.validateRegexPattern)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result).to.have.property('errorKeyOrMessage', 'Can only contain digits.');
}));
