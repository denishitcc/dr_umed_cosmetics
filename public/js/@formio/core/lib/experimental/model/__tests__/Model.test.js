"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const chai_1 = require("chai");
const Model_1 = require("../Model");
const BaseModel = (0, Model_1.Model)()();
describe('Model', () => {
    it('new Model()', () => {
        const model = new BaseModel({
            key: 'firstName'
        }, {}, {
            firstName: 'Joe'
        });
        chai_1.assert.equal(model.dataValue, 'Joe');
        model.dataValue = 'Sally';
        chai_1.assert.equal(model.dataValue, 'Sally');
        chai_1.assert.deepEqual(model.data, { firstName: 'Sally' });
    });
    it('Model.isEmpty', () => {
        const model = new BaseModel({
            key: 'firstName'
        }, {}, {
            firstName: 'Joe'
        });
        chai_1.assert.equal(model.isEmpty(), false);
        model.dataValue = '';
        chai_1.assert.equal(model.isEmpty(), true);
        model.dataValue = null;
        chai_1.assert.equal(model.isEmpty(), true);
        model.dataValue = [];
        chai_1.assert.equal(model.isEmpty(), true);
        model.dataValue = [null];
        chai_1.assert.equal(model.isEmpty(), true);
        model.dataValue = [''];
        chai_1.assert.equal(model.isEmpty(), false);
        model.dataValue = ['hello'];
        chai_1.assert.equal(model.isEmpty(), false);
    });
});
