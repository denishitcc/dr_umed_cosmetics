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
const validateMaximumLength_1 = require("../validateMaximumLength");
it('Validating a component without a maxLength property will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleTextField;
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMaximumLength_1.validateMaximumLength)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a component with a maxLength property and a length greater than maxLength will return a FieldError', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { validate: { maxLength: 4 } });
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMaximumLength_1.validateMaximumLength)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('maxLength');
}));
it('Validating a component with a maxLength property and a length less than maxLength will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { validate: { maxLength: 4 } });
    const data = {
        component: 'foo',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMaximumLength_1.validateMaximumLength)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a component with a maxLength property that is an empty string will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { validate: { maxLength: 4 } });
    const data = {
        component: '',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMaximumLength_1.validateMaximumLength)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
