"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const chai_1 = require("chai");
const test_1 = require("../test");
describe('HTML Component', () => {
    it('Should create an HTML Component', () => {
        const comp = new test_1.HTMLComponent({
            type: 'html',
            tag: 'span',
            className: 'testing',
            content: 'Testing',
            attrs: [
                { attr: 'one', value: 'two' },
                { attr: 'three', value: 'four' }
            ]
        });
        chai_1.assert.equal(comp.render(), '<span ref="html" one="two" three="four" class="testing">Testing</span>');
    });
    it('Should also allow for key-value pair attributes', () => {
        const comp = new test_1.HTMLComponent({
            type: 'html',
            tag: 'span',
            className: 'testing',
            content: 'Testing',
            attrs: {
                one: 'two',
                three: 'four'
            }
        });
        chai_1.assert.equal(comp.render(), '<span ref="html" one="two" three="four" class="testing">Testing</span>');
    });
});
