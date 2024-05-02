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
const __1 = require("../");
const util_1 = require("../../__tests__/fixtures/util");
it('Should normalize a time component with a valid time value that doees not match dataFormat', () => __awaiter(void 0, void 0, void 0, function* () {
    const timeComp = {
        type: 'time',
        key: 'time',
        label: 'Time',
        input: true,
        dataFormat: 'HH:mm:ss'
    };
    const data = { time: '12:00' };
    const context = (0, util_1.generateProcessorContext)(timeComp, data);
    (0, __1.normalizeProcessSync)(context);
    (0, chai_1.expect)(context.data).to.deep.equal({ time: '12:00:00' });
}));
it('Should normalize a select boxes component with an incorrect data model', () => {
    const selectBoxesComp = {
        type: 'selectboxes',
        key: 'selectBoxes',
        label: 'Select Boxes',
        input: true,
        values: [
            { label: 'One', value: 'one' },
            { label: 'Two', value: 'two' },
            { label: 'Three', value: 'three' }
        ]
    };
    const data = {
        selectBoxes: ''
    };
    const context = (0, util_1.generateProcessorContext)(selectBoxesComp, data);
    (0, __1.normalizeProcessSync)(context);
    (0, chai_1.expect)(context.data).to.deep.equal({ selectBoxes: {} });
});
it('Should normalize an email component value', () => {
    const emailComp = {
        type: 'email',
        key: 'email',
        input: true,
        label: 'Email'
    };
    const data = {
        email: 'BrendanBond@Gmail.com'
    };
    const context = (0, util_1.generateProcessorContext)(emailComp, data);
    (0, __1.normalizeProcessSync)(context);
    (0, chai_1.expect)(context.data).to.deep.equal({ email: 'brendanbond@gmail.com' });
});
it('Should normalize a radio component with a string value', () => {
    const radioComp = {
        type: 'radio',
        key: 'radio',
        input: true,
        label: 'Radio',
        values: [
            {
                label: 'Yes',
                value: 'true',
            },
            {
                label: 'No',
                value: 'false',
            }
        ]
    };
    const data = {
        radio: 'true'
    };
    const context = (0, util_1.generateProcessorContext)(radioComp, data);
    (0, __1.normalizeProcessSync)(context);
    (0, chai_1.expect)(context.data).to.deep.equal({ radio: true });
});
it('Should normalize a radio component value with a number', () => {
    const radioComp = {
        type: 'radio',
        key: 'radio',
        input: true,
        label: 'Radio',
        values: [
            {
                label: 'Yes',
                value: '1',
            },
            {
                label: 'No',
                value: '0',
            }
        ]
    };
    const data = {
        radio: '0'
    };
    const context = (0, util_1.generateProcessorContext)(radioComp, data);
    (0, __1.normalizeProcessSync)(context);
    (0, chai_1.expect)(context.data).to.deep.equal({ radio: 0 });
});
