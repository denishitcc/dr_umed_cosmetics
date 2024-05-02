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
const validateRequired_1 = require("../validateRequired");
const components_1 = require("./fixtures/components");
const processOne_1 = require("../../../processOne");
const util_1 = require("./fixtures/util");
const validation_1 = require("../../../validation");
it('Validating a simple component that is required and not present in the data will return a field error', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { validate: { required: true } });
    const data = {};
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateRequired_1.validateRequired)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result && result.errorKeyOrMessage).to.equal('required');
}));
it('Validating a simple component that is required and present in the data will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { validate: { required: true } });
    const data = { component: 'a simple value' };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateRequired_1.validateRequired)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a simple component that is not required and present in the data will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleTextField;
    const data = { component: 'a simple value' };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateRequired_1.validateRequired)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a simple component that is not required and not present in the data will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleTextField;
    const data = {};
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateRequired_1.validateRequired)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Should validate a hidden component that does not contain data', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.hiddenRequiredField;
    const data = { otherData: 'hideme' };
    const context = (0, util_1.generateProcessorContext)(component, data);
    context.processors = [validation_1.validateProcessInfo];
    yield (0, processOne_1.processOne)(context);
    (0, chai_1.expect)(context.scope.errors.length).to.equal(1);
    (0, chai_1.expect)(context.scope.errors[0] && context.scope.errors[0].errorKeyOrMessage).to.equal('required');
}));
it('Should not validate a hidden component that is conditionally hidden', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.conditionallyHiddenRequiredHiddenField;
    const data = { otherData: 'hideme' };
    const context = (0, util_1.generateProcessorContext)(component, data);
    context.processors = [validation_1.validateProcessInfo];
    yield (0, processOne_1.processOne)(context);
    (0, chai_1.expect)(context.scope.errors.length).to.equal(0);
}));
it('Should not validate a hidden component that has the hidden property set to true.', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.hiddenRequiredField;
    component.hidden = true;
    const data = {};
    const context = (0, util_1.generateProcessorContext)(component, data);
    context.processors = [validation_1.validateProcessInfo];
    yield (0, processOne_1.processOne)(context);
    (0, chai_1.expect)(context.scope.errors.length).to.equal(0);
}));
it('Validating a simple component that is required but conditionally hidden', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign({}, components_1.simpleTextField);
    component.validate = { required: true };
    component.conditional = {
        show: false,
        when: 'otherData',
        eq: 'hideme'
    };
    const data = { otherData: 'hideme' };
    const context = (0, util_1.generateProcessorContext)(component, data);
    context.processors = [validation_1.validateProcessInfo];
    yield (0, processOne_1.processOne)(context);
    (0, chai_1.expect)(context.scope.errors.length).to.equal(0);
}));
it('Validating a simple component that is required but not persistent', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign({}, components_1.simpleTextField);
    component.validate = { required: true };
    component.persistent = false;
    const data = { otherData: 'hideme' };
    const context = (0, util_1.generateProcessorContext)(component, data);
    context.processors = [validation_1.validateProcessInfo];
    yield (0, processOne_1.processOne)(context);
    (0, chai_1.expect)(context.scope.errors.length).to.equal(0);
}));
it('Validating a simple component that is required but persistent set to client-only', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign({}, components_1.simpleTextField);
    component.validate = { required: true };
    component.persistent = 'client-only';
    const data = { otherData: 'hideme' };
    const context = (0, util_1.generateProcessorContext)(component, data);
    context.processors = [validation_1.validateProcessInfo];
    yield (0, processOne_1.processOne)(context);
    (0, chai_1.expect)(context.scope.errors.length).to.equal(0);
}));
it('Should not validate a non input comonent', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.requiredNonInputField;
    const data = {};
    const context = (0, util_1.generateProcessorContext)(component, data);
    context.processors = [validation_1.validateProcessInfo];
    yield (0, processOne_1.processOne)(context);
    (0, chai_1.expect)(context.scope.errors.length).to.equal(0);
}));
it('Should validate a conditionally hidden component with validateWhenHidden flag set to true', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign({}, components_1.simpleTextField);
    component.validate = { required: true };
    component.validateWhenHidden = true;
    component.conditional = {
        show: false,
        when: 'otherData',
        eq: 'hideme'
    };
    const data = { otherData: 'hideme' };
    const context = (0, util_1.generateProcessorContext)(component, data);
    context.processors = [validation_1.validateProcessInfo];
    yield (0, processOne_1.processOne)(context);
    (0, chai_1.expect)(context.scope.errors.length).to.equal(1);
    (0, chai_1.expect)(context.scope.errors[0] && context.scope.errors[0].errorKeyOrMessage).to.equal('required');
}));
it('Validating a simple radio component that is required and present in the data with value set to false will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleRadioField), { validate: { required: true }, values: [
            {
                label: 'Yes',
                value: 'true',
            },
            {
                label: 'No',
                value: 'false',
            }
        ] });
    const data = { component: false };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateRequired_1.validateRequired)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a simple selectbox that is required and present in the data with value set to 0 will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectBoxes), { validate: { required: true }, values: [
            {
                label: 'true',
                value: 'true',
            },
            {
                label: 'Null',
                value: '0',
            }
        ] });
    const data = { component: 0 };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateRequired_1.validateRequired)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a simple selectbox that is required and present in the data with value set to false will return a FieldError', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectBoxes), { validate: { required: true }, values: [
            {
                label: 'true',
                value: 'true',
            },
            {
                label: 'false',
                value: 'false',
            }
        ] });
    const data = {
        component: {
            true: false,
            false: false
        }
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateRequired_1.validateRequired)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
}));
it('Validating a simple checkbox that is required and present in the data with value set to false will return a FieldError', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleCheckBoxField), { validate: { required: true } });
    const data = { component: false };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateRequired_1.validateRequired)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
}));
