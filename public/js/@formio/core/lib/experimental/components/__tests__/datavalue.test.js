"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const chai_1 = require("chai");
const test_1 = require("../test");
describe('DataValue', () => {
    it('Should create a DataValue component', () => {
        const dataValue = new test_1.DataValueComponent({
            type: 'datavalue',
            key: 'firstName',
            label: 'First Name'
        }, {}, {
            firstName: 'Joe'
        });
        chai_1.assert.equal(dataValue.render(), '<span ref="val">Joe</span>');
    });
});
