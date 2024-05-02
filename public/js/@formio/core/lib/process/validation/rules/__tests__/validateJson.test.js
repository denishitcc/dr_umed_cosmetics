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
const FieldError_1 = require("../../../../error/FieldError");
const components_1 = require("./fixtures/components");
const util_1 = require("./fixtures/util");
const validateJson_1 = require("../validateJson");
it('A simple component without JSON logic validation will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleTextField;
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateJson_1.validateJson)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('A simple component with JSON logic evaluation will return a FieldError if the JSON logic returns invalid', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { validate: {
            json: {
                if: [
                    {
                        '===': [
                            {
                                var: 'input',
                            },
                            'foo',
                        ],
                    },
                    true,
                    "Input must be 'foo'",
                ],
            },
        } });
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateJson_1.validateJson)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(FieldError_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.contain('Input must be \'foo\'');
}));
it('A simple component with JSON logic evaluation will return null if the JSON logic returns valid', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { validate: {
            json: {
                if: [
                    {
                        '===': [
                            {
                                var: 'input',
                            },
                            'foo',
                        ],
                    },
                    true,
                    "Input must be 'foo'",
                ],
            },
        } });
    const data = {
        component: 'foo',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateJson_1.validateJson)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('A simple component with JSON logic evaluation will validate even if the value is falsy', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { validate: {
            json: {
                if: [
                    {
                        '===': [
                            {
                                var: 'input',
                            },
                            'foo',
                        ],
                    },
                    true,
                    "Input must be 'foo'",
                ],
            },
        } });
    const data = {
        component: '',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateJson_1.validateJson)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(FieldError_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.contain("Input must be 'foo'");
}));
it('Should have access to form JSON in its validation context', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleTextField), { validate: {
            json: {
                if: [
                    {
                        '>': [
                            {
                                var: 'form.components',
                            },
                            5,
                        ],
                    },
                    true,
                    'Form must have greater than 5 components',
                ],
            },
        } });
    const form = {
        components: [component],
    };
    const data = {
        component: 'foo',
    };
    const context = (0, util_1.generateProcessorContext)(component, data, form);
    const result = yield (0, validateJson_1.validateJson)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(FieldError_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.contain("Form must have greater than 5 components");
}));
