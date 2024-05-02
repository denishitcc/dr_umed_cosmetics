"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const NestedComponent_1 = require("../NestedComponent");
const chai_1 = require("chai");
const fixtures_1 = require("./fixtures");
const NestedComponent = (0, NestedComponent_1.NestedComponent)()();
describe('Nested', () => {
    it('Should render a nested component', () => {
        const nested = new NestedComponent(fixtures_1.comp1);
        chai_1.assert.equal(nested.render(), `<div ref="nested">` +
            `<strong ref="html" data-within="${nested.id}">Hello</strong>` +
            `<h2 ref="html" data-within="${nested.id}">There</h2>` +
            `</div>`);
    });
    it('Should not set or get data', () => {
        const data = {};
        const nested = new NestedComponent(fixtures_1.comp2, {}, data);
        nested.dataValue = {
            firstName: 'Joe',
            lastName: 'Smith'
        };
        chai_1.assert.deepEqual(data, {
            firstName: 'Joe',
            lastName: 'Smith'
        });
        chai_1.assert.deepEqual(nested.dataValue, {
            firstName: 'Joe',
            lastName: 'Smith'
        });
        chai_1.assert.equal(nested.components[0].dataValue, 'Joe');
        chai_1.assert.equal(nested.components[1].dataValue, 'Smith');
    });
});
