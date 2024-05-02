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
const index_1 = require("../index");
const rules_1 = require("../rules");
const forms_1 = require("./fixtures/forms");
const types_1 = require("../../../types");
it('Validator will throw the correct errors given a flat components array', () => __awaiter(void 0, void 0, void 0, function* () {
    let errors = [];
    const data = {
        requiredField: '',
        maximumWords: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        minimumWords: 'Hello',
        email: 'brendanb',
        url: 'htpigoogle',
        inputMask: 'hello, world',
        submit: false,
    };
    for (let component of forms_1.simpleForm.components) {
        const path = component.key;
        const scope = { errors: [] };
        yield (0, index_1.validateProcess)({
            component,
            scope,
            data,
            row: data,
            path,
            value: (0, get_1.default)(data, component.key),
            processor: types_1.ProcessorType.Validate,
            rules: rules_1.rules
        });
        if (scope.errors) {
            errors = [...errors, ...scope.errors.map((error) => error.errorKeyOrMessage)];
        }
    }
    (0, chai_1.expect)(errors).to.have.length(6);
}));
