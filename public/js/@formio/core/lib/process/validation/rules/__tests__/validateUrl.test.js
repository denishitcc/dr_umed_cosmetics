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
const validateUrl_1 = require("../validateUrl");
it('Validating a URL component whose data contains an invalid URL returns a FieldError', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleUrlField;
    const data = {
        component: 'htp:/ww.google',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateUrl_1.validateUrl)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.contain('invalid_url');
}));
it('Validating a URL component whose data contains an invalid URL returns a FieldError', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleUrlField;
    const data = {
        component: 'Hello, world!',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateUrl_1.validateUrl)(context);
    (0, chai_1.expect)(result).to.be.instanceOf(error_1.FieldError);
    (0, chai_1.expect)(result === null || result === void 0 ? void 0 : result.errorKeyOrMessage).to.contain('invalid_url');
}));
// it('Validating a URL component whose data contains an valid URL that is not HTTP or HTTPS returns a FieldError', async () => {
//     const component = simpleUrlField;
//     const data = {
//         component: 'ftp://www.google.com',
//     };
//     const context = generateProcessContext(component, data);
//     const result = await validateUrl(context);
//     expect(result).to.be.instanceOf(FieldError);
//     expect(result?.errorKeyOrMessage).to.contain('invalid_url');
// });
// it('Validating a URL component whose data contains an valid URL that is not HTTP or HTTPS returns a FieldError', async () => {
//     const component = simpleUrlField;
//     const data = {
//         component: 'mailto://www.google.com',
//     };
//     const context = generateProcessContext(component, data);
//     const result = await validateUrl(context);
//     expect(result).to.be.instanceOf(FieldError);
//     expect(result?.errorKeyOrMessage).to.contain('invalid_url');
// });
it('Validating a URL component whose data contains a valid HTTPS URL returns null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleUrlField;
    const data = {
        component: 'https://www.google.com',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateUrl_1.validateUrl)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
it('Validating a URL component whose data contains a valid HTTP URL returns null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleUrlField;
    const data = {
        component: 'http://www.google.com',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateUrl_1.validateUrl)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
// it('Validating a URL component whose data contains a valid localhost URL returns null', async () => {
//     const component = simpleUrlField;
//     const data = {
//         component: 'http://localhost:3000',
//     };
//     const context = generateProcessContext(component, data);
//     const result = await validateUrl(context);
//     expect(result).to.equal(null);
// });
it('Validating a URL component whose data contains a strange but valid URL returns null', () => __awaiter(void 0, void 0, void 0, function* () {
    const component = components_1.simpleUrlField;
    const data = {
        component: 'www.hhh.by',
    };
    const context = (0, util_1.generateProcessorContext)(component, data);
    const result = yield (0, validateUrl_1.validateUrl)(context);
    (0, chai_1.expect)(result).to.equal(null);
}));
