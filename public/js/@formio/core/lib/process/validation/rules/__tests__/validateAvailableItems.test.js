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
const validateAvailableItems_1 = require("../validateAvailableItems");
it('Validating a component without the available items validation parameter will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleTextField;
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a simple select boxes component without the available items validation parameter will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleSelectBoxes;
    const data = {
        component: {
            foo: false,
            bar: false,
            baz: false,
            biz: false,
        },
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a simple radio component without the available items validation parameter will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleRadioField;
    const data = {
        component: 'bar',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a simple radio component with the available items validation parameter will return null if the item is valid', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleRadioField), { validate: { onlyAvailableItems: true } });
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('invalidOption');
}));
it('Validating a simple static values select component without the available items validation parameter will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'values', data: {
            values: [
                { label: 'foo', value: 'foo' },
                { label: 'bar', value: 'bar' },
                { label: 'baz', value: 'baz' },
                { label: 'baz', value: 'baz' },
            ],
        } });
    const data = {
        component: 'foo',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a simple static values select component with the available items validation parameter will return null if the selected item is valid', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'values', data: {
            values: [
                { label: 'foo', value: 'foo' },
                { label: 'bar', value: 'bar' },
                { label: 'baz', value: 'baz' },
                { label: 'baz', value: 'baz' },
            ],
        }, validate: { onlyAvailableItems: true } });
    const data = {
        component: 'foo',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a simple URL select component without the available items validation parameter will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'url', data: {
            url: 'http://localhost:8080/numbers',
            headers: [],
        } });
    const data = {
        component: 'foo',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a simple JSON select component (string JSON) without the available items validation parameter will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'json', data: {
            json: '["foo", "bar", "baz", "biz"]',
        } });
    const data = {
        component: 'foo',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a simple JSON select component (string JSON) with the available items validation parameter will return a FieldError if the item is invalid', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'json', data: {
            json: '["foo", "bar", "baz", "biz"]',
        }, validate: { onlyAvailableItems: true } });
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('invalidOption');
}));
it('Validating a simple JSON select component (string JSON) with the available items validation parameter will return null if the item is valid', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'json', data: {
            json: '["foo", "bar", "baz", "biz"]',
        }, validate: { onlyAvailableItems: true } });
    const data = {
        component: 'foo',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a simple JSON select component (nested string JSON) with the available items validation parameter will return null if the item is valid', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'json', data: {
            json: '[{"foo": "foo", "bar": "bar"}, {"baz": "baz", "biz": "biz"}]',
        }, validate: { onlyAvailableItems: true } });
    const data = {
        component: { foo: 'foo', bar: 'bar' },
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a simple JSON select component (nested string JSON) with the available items validation parameter will return a FieldError if the item is invalid', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'json', data: {
            json: '[{"foo": "foo", "bar": "bar"}, {"baz": "baz", "biz": "biz"}]',
        }, validate: { onlyAvailableItems: true } });
    const data = {
        component: { foo: 'bar', bar: 'baz' },
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('invalidOption');
}));
it('Validating a simple JSON select component (nested string JSON with valueProperty) with the available items validation parameter will return a FieldError if the item is invalid', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'json', data: {
            json: '[{"foo": "foo", "bar": "bar"}, {"baz": "baz", "biz": "biz"}]',
        }, valueProperty: 'foo', validate: { onlyAvailableItems: true } });
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('invalidOption');
}));
it('Validating a simple JSON select component (nested string JSON with valueProperty) with the available items validation parameter will return null if the item is valid', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'json', data: {
            json: '[{"foo": "foo", "bar": "bar"}, {"baz": "baz", "biz": "biz"}]',
        }, valueProperty: 'foo', validate: { onlyAvailableItems: true } });
    const data = {
        component: 'foo',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a simple JSON select component (actual JSON) without the available items validation parameter will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'json', data: {
            json: ['foo', 'bar', 'baz', 'biz'],
        } });
    const data = {
        component: 'foo',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a simple JSON select component (actual JSON) with the available items validation parameter will return a FieldError if the selected item is invalid', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'json', data: {
            json: ['foo', 'bar', 'baz', 'biz'],
        }, validate: { onlyAvailableItems: true } });
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('invalidOption');
}));
it('Validating a simple JSON select component (actual JSON) with the available items validation parameter will return null if the selected item is valid', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'json', data: {
            json: ['foo', 'bar', 'baz', 'biz'],
        }, validate: { onlyAvailableItems: true } });
    const data = {
        component: 'foo',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a simple JSON select component (nested actual JSON) with the available items validation parameter will return a FieldError if the selected item is invalid', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'json', data: {
            json: [
                { foo: 'foo', bar: 'bar' },
                { baz: 'baz', biz: 'biz' },
            ],
        }, validate: { onlyAvailableItems: true } });
    const data = {
        component: { foo: 'baz', bar: 'biz' },
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('invalidOption');
}));
it('Validating a simple JSON select component (nested actual JSON) with the available items validation parameter will return null if the selected item is valid', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'json', data: {
            json: [
                { foo: 'foo', bar: 'bar' },
                { baz: 'baz', biz: 'biz' },
            ],
        }, validate: { onlyAvailableItems: true } });
    const data = {
        component: { foo: 'foo', bar: 'bar' },
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a simple JSON select component (nested actual JSON with valueProperty) with the available items validation parameter will return a FieldError if the selected item is invalid', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'json', data: {
            json: [
                { foo: 'foo', bar: 'bar' },
                { foo: 'baz', bar: 'biz' },
            ],
        }, validate: { onlyAvailableItems: true }, valueProperty: 'foo' });
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.equal('invalidOption');
}));
it('Validating a simple JSON select component (nested actual JSON with valueProperty) with the available items validation parameter will return null if the selected item is valid', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectOptions), { dataSrc: 'json', data: {
            json: [
                { foo: 'foo', bar: 'bar' },
                { foo: 'baz', bar: 'biz' },
            ],
        }, validate: { onlyAvailableItems: true }, valueProperty: 'foo' });
    const data = {
        component: 'foo',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateAvailableItems_1.validateAvailableItems)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
