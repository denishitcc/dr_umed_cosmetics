"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const chai_1 = require("chai");
const DataComponent_1 = require("../DataComponent");
const fixtures_1 = require("./fixtures");
const DataComponent = (0, DataComponent_1.DataComponent)()();
describe('DataComponent', () => {
    it('Should create a new Data Component', () => {
        const data = {};
        new DataComponent(fixtures_1.comp1, {}, data);
        chai_1.assert.deepEqual(data, { employee: {} });
    });
    it('Should initialize the data component with data', () => {
        const data = {
            employee: {
                firstName: 'Joe',
                lastName: 'Smith'
            }
        };
        const dataComp = new DataComponent(fixtures_1.comp1, {}, data);
        chai_1.assert.deepEqual(dataComp.dataValue, {
            firstName: 'Joe',
            lastName: 'Smith'
        });
        chai_1.assert.equal(dataComp.components[0].dataValue, 'Joe');
        chai_1.assert.equal(dataComp.components[1].dataValue, 'Smith');
    });
    it('Should set the value of the sub components', () => {
        const data = {};
        const dataComp = new DataComponent(fixtures_1.comp1, {}, data);
        dataComp.dataValue = {
            firstName: 'Joe',
            lastName: 'Smith'
        };
        chai_1.assert.deepEqual(data, { employee: {
                firstName: 'Joe',
                lastName: 'Smith'
            } });
        chai_1.assert.deepEqual(dataComp.dataValue, {
            firstName: 'Joe',
            lastName: 'Smith'
        });
        chai_1.assert.equal(dataComp.components[0].dataValue, 'Joe');
        chai_1.assert.equal(dataComp.components[1].dataValue, 'Smith');
    });
});
