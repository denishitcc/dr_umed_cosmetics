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
const validateMaximumSelectedCount_1 = require("../validateMaximumSelectedCount");
const util_1 = require("./fixtures/util");
it('Validting a non-select boxes component will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleTextField;
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMaximumSelectedCount_1.validateMaximumSelectedCount)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a select boxes component without maxSelectedCount will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleSelectBoxes;
    const data = {
        component: {
            foo: true,
            bar: true,
            baz: false,
            biz: false,
        },
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMaximumSelectedCount_1.validateMaximumSelectedCount)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a select boxes component where the number of selected fields is greater than maxSelectedCount will return a FieldError', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectBoxes), { validate: { maxSelectedCount: 1 } });
    const data = {
        component: {
            foo: true,
            bar: true,
            baz: false,
            biz: false,
        },
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMaximumSelectedCount_1.validateMaximumSelectedCount)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.contain('maxSelectedCount');
}));
it('Validating a select boxes component where the number of selected fields is equal to maxSelectedCount will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectBoxes), { validate: { maxSelectedCount: 1 } });
    const data = {
        component: {
            foo: true,
            bar: false,
            baz: false,
            biz: false,
        },
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMaximumSelectedCount_1.validateMaximumSelectedCount)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a select boxes component where the number of selected fields is less than maxSelectedCount will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = Object.assign(Object.assign({}, components_1.simpleSelectBoxes), { validate: { maxSelectedCount: 2 } });
    const data = {
        component: {
            foo: true,
            bar: false,
            baz: false,
            biz: false,
        },
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateMaximumSelectedCount_1.validateMaximumSelectedCount)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
