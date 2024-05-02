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
const validateCustom_1 = require("../validateCustom");
const util_1 = require("./fixtures/util");
it('A simple custom validation will correctly be interpolated', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { validate: {
            custom: 'valid = "Invalid entry"',
        } });
    const data = {
        component: 'any thing',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateCustom_1.validateCustom)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result && result.errorKeyOrMessage).to.equal('Invalid entry');
}));
it('A custom validation that includes data will correctly be interpolated', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { validate: {
            custom: 'valid = data.simpleComponent === "any thing" ? true : "Invalid entry"',
        } });
    const data = {
        simpleComponent: 'any thing',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateCustom_1.validateCustom)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('A custom validation of empty component data will still validate', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { validate: {
            custom: 'valid = data.simpleComponent === "any thing" ? true : "Invalid entry"',
        } });
    const data = {
        simpleComponent: '',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateCustom_1.validateCustom)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result && result.errorKeyOrMessage).to.equal('Invalid entry');
}));
