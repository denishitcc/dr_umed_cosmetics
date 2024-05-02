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
const lodash_1 = require("lodash");
const error_1 = require("../../../../error");
const components_1 = require("./fixtures/components");
const util_1 = require("./fixtures/util");
const validateUrlSelectValue_1 = require("../validateUrlSelectValue");
it('Validating a component without the remote value validation parameter will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleTextField;
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateUrlSelectValue_1.validateUrlSelectValue)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a select component without the remote value validation parameter will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'url', data: {
            url: 'http://localhost:8080/numbers',
            headers: [],
        } });
    const data = {
        component: {
            id: 'b',
            value: 2,
        },
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateUrlSelectValue_1.validateUrlSelectValue)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('The remote value validation will generate the correct URL given a searchField and a valueProperty', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'url', data: {
            url: 'http://localhost:8080/numbers',
            headers: [],
        }, searchField: 'number', valueProperty: 'value', validate: { select: true } });
    const data = {
        component: {
            id: 'b',
            value: 2,
        },
    };
    const value = (0, lodash_1.get)(data, component.key);
    if (!component.data || !component.data.url) {
        throw new Error('Component passed to remote validation testing does not contain a URL');
    }
    const baseUrl = new URL(component.data.url);
    const result = (0, validateUrlSelectValue_1.generateUrl)(baseUrl, component, value);
    (0, chai_1.expect)(result).to.be.instanceOf(URL);
    (0, chai_1.expect)(result.href).to.equal(`http://localhost:8080/numbers?number=2`);
}));
it('Validating a select component with the remote validation parameter will return a FieldError if the value does not exist and the API returns an array', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'url', data: {
            url: 'http://localhost:8080/numbers',
            headers: [],
        }, searchField: 'number', valueProperty: 'value', validate: { select: true } });
    const data = {
        component: {
            id: 'b',
            value: 2,
        },
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateUrlSelectValue_1.validateUrlSelectValue)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('select');
}));
it('Validating a select component with the remote validation parameter will return a FieldError if the value does not exist and the API returns an object', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'url', data: {
            url: 'http://localhost:8080/numbers',
            headers: [],
        }, searchField: 'number', valueProperty: 'value', validate: { select: true } });
    const data = {
        component: {
            id: 'b',
            value: 2,
        },
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateUrlSelectValue_1.validateUrlSelectValue)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('select');
}));
it('Validating a select component with the remote validation parameter will return null if the value exists', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'url', data: {
            url: 'http://localhost:8080/numbers',
            headers: [],
        }, searchField: 'number', valueProperty: 'value', validate: { select: true } });
    const data = {
        component: {
            id: 'b',
            value: 2,
        },
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    context.fetch = (url, options) => {
        return Promise.resolve({
            ok: true,
            json: () => Promise.resolve([{ id: 'b', value: 2 }])
        });
    };
    const result = yield (0, validateUrlSelectValue_1.validateUrlSelectValue)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
