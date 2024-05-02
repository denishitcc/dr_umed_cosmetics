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
const validateNumber_1 = require("../validateNumber");
it('Validating a valid number will return null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleNumberField;
    const data = {
        component: 45,
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateNumber_1.validateNumber)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating an invalid number will return a FieldError', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleNumberField;
    const data = {
        component: 'text',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateNumber_1.validateNumber)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.contain('number');
}));
