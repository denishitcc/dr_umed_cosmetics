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
const validateMask_1 = require("../validateMask");
it('Validating a mask component should return a FieldError if the value does not match the mask', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { inputMask: '999-999-9999' });
    const data = {
        component: '1234',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMask_1.validateMask)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('mask');
}));
it('Validating a mask component should return null if the value matches the mask', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { inputMask: '999-999-9999' });
    const data = {
        component: '123-456-7890',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMask_1.validateMask)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a multi-mask component should return a FieldError if the value does not match the masks', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { allowMultipleMasks: true, inputMasks: [
            {
                label: 'maskOne',
                mask: '999-9999',
            },
            {
                label: 'maskTwo',
                mask: '999-999-9999',
            },
        ] });
    let data = {
        component: { maskName: 'maskOne', value: '14567890' },
    };
    let context = (0, util_1.generateProcessorContext)(component, data);
    let result = yield (0, validateMask_1.validateMask)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('mask');
    data = {
        component: { maskName: 'maskTwo', value: '1234567' },
    };
    context = (0, util_1.generateProcessorContext)(component, data);
    result = yield (0, validateMask_1.validateMask)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('mask');
}));
it('Validating a mutil-mask component should return null if the value matches the masks', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { allowMultipleMasks: true, inputMasks: [
            {
                label: 'maskOne',
                mask: '999-9999',
            },
            {
                label: 'maskTwo',
                mask: '999-999-9999',
            },
        ] });
    let data = {
        component: { maskName: 'maskOne', value: '456-7890' },
    };
    let context = (0, util_1.generateProcessorContext)(component, data);
    let result = yield (0, validateMask_1.validateMask)(context);
    (0, chai_1.expect)(result).to.equal(null);
    data = {
        component: { maskName: 'maskTwo', value: '123-456-7890' },
    };
    context = (0, util_1.generateProcessorContext)(component, data);
    result = yield (0, validateMask_1.validateMask)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
