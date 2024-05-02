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
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const get_1 = __importDefault(require("lodash/get"));
const chai_1 = require("chai");
const util_1 = require("../util");
const __1 = require("../");
const forms_1 = require("./fixtures/forms");
const types_1 = require("../../../types");
const rules_1 = require("../rules");
const formUtil_1 = require("../../../utils/formUtil");
describe('interpolateErrors', () => {
    it('Interpolated validation errors should include the rule name mapping in the "validator" param for simple components', () => __awaiter(void 0, void 0, void 0, function* () {
        const data = {
            requiredField: '',
            maximumWords: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            minimumWords: 'Hello',
            email: 'brendanb',
            url: 'htpigoogle',
            inputMask: 'hello, world',
            submit: false,
        };
        const result = new Map();
        for (let component of forms_1.simpleForm.components) {
            const path = component.key;
            const scope = { errors: [] };
            yield (0, __1.validateProcess)({
                component,
                scope,
                data,
                row: data,
                path,
                value: (0, get_1.default)(data, component.key),
                processor: types_1.ProcessorType.Validate,
                rules: rules_1.rules
            });
            result.set(path, (0, util_1.interpolateErrors)(scope.errors));
        }
        (0, chai_1.expect)(result.get('requiredField')).to.have.length(1);
        (0, chai_1.expect)(result.get('requiredField')[0].context.validator).to.equal('required');
        (0, chai_1.expect)(result.get('maximumWords')).to.have.length(1);
        (0, chai_1.expect)(result.get('maximumWords')[0].context.validator).to.equal('maxWords');
        (0, chai_1.expect)(result.get('minimumWords')).to.have.length(1);
        (0, chai_1.expect)(result.get('minimumWords')[0].context.validator).to.equal('minWords');
        (0, chai_1.expect)(result.get('email')).to.have.length(1);
        (0, chai_1.expect)(result.get('email')[0].context.validator).to.equal('email');
        (0, chai_1.expect)(result.get('url')).to.have.length(1);
        (0, chai_1.expect)(result.get('url')[0].context.validator).to.equal('url');
        (0, chai_1.expect)(result.get('inputMask')).to.have.length(1);
        (0, chai_1.expect)(result.get('inputMask')[0].context.validator).to.equal('mask');
    }));
    it('Interpolated validation errors should include the rule name mapping in the "validator" param for nested components', () => __awaiter(void 0, void 0, void 0, function* () {
        const data = {
            dataGrid: [
                {
                    requiredField: '',
                    maximumLength: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                    numbersOnly: 'abc',
                    submit: false,
                },
                {
                    requiredField: '',
                    maximumLength: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                    numbersOnly: 'abc',
                    submit: false,
                }, ,
            ]
        };
        const result = new Map();
        yield (0, formUtil_1.eachComponentDataAsync)(forms_1.simpleNestedForm.components, data, (component, data, row, path) => __awaiter(void 0, void 0, void 0, function* () {
            const scope = { errors: [] };
            yield (0, __1.validateProcess)({
                component,
                scope,
                data,
                row: data,
                path,
                value: (0, get_1.default)(data, path),
                processor: types_1.ProcessorType.Validate,
                rules: rules_1.rules
            });
            result.set(path, (0, util_1.interpolateErrors)(scope.errors));
        }));
        (0, chai_1.expect)(result.get('dataGrid[0].requiredField')).to.have.length(1);
        (0, chai_1.expect)(result.get('dataGrid[0].requiredField')[0].context.validator).to.equal('required');
        (0, chai_1.expect)(result.get('dataGrid[1].requiredField')).to.have.length(1);
        (0, chai_1.expect)(result.get('dataGrid[1].requiredField')[0].context.validator).to.equal('required');
        (0, chai_1.expect)(result.get('dataGrid[0].maximumLength')).to.have.length(1);
        (0, chai_1.expect)(result.get('dataGrid[0].maximumLength')[0].context.validator).to.equal('maxLength');
        (0, chai_1.expect)(result.get('dataGrid[1].maximumLength')).to.have.length(1);
        (0, chai_1.expect)(result.get('dataGrid[1].maximumLength')[0].context.validator).to.equal('maxLength');
        (0, chai_1.expect)(result.get('dataGrid[0].numbersOnly')).to.have.length(1);
        (0, chai_1.expect)(result.get('dataGrid[0].numbersOnly')[0].context.validator).to.equal('pattern');
    }));
    it('Interpolated validation errors should include the rule name mapping in the "validator" param for components with custom validation', () => __awaiter(void 0, void 0, void 0, function* () {
        const data = {
            customValidation: 'abc',
            submit: false,
        };
        const result = new Map();
        for (let component of forms_1.simpleCustomValidationForm.components) {
            const path = component.key;
            const scope = { errors: [] };
            yield (0, __1.validateProcess)({
                component,
                scope,
                data,
                row: data,
                path,
                value: (0, get_1.default)(data, component.key),
                processor: types_1.ProcessorType.Validate,
                rules: rules_1.rules
            });
            result.set(path, (0, util_1.interpolateErrors)(scope.errors));
        }
        (0, chai_1.expect)(result.get('customValidation')).to.have.length(1);
        (0, chai_1.expect)(result.get('customValidation')[0].context.validator).to.equal('custom');
    }));
    it('Interpolated validation errors should include the rule name mapping in the "validator" param for components with json logic validation', () => __awaiter(void 0, void 0, void 0, function* () {
        const data = {
            jsonLogic: 'abc',
            submit: false,
        };
        const result = new Map();
        for (let component of forms_1.simpleJsonLogicValidationForm.components) {
            const path = component.key;
            const scope = { errors: [] };
            yield (0, __1.validateProcess)({
                component,
                scope,
                data,
                row: data,
                path,
                value: (0, get_1.default)(data, component.key),
                processor: types_1.ProcessorType.Validate,
                rules: rules_1.rules
            });
            result.set(path, (0, util_1.interpolateErrors)(scope.errors));
        }
        (0, chai_1.expect)(result.get('jsonLogic')).to.have.length(1);
        (0, chai_1.expect)(result.get('jsonLogic')[0].context.validator).to.equal('json');
    }));
});
