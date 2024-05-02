"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const chai_1 = require("chai");
const test_1 = require("../test");
const fixtures_1 = require("./fixtures");
describe('HTMLContainerComponent', () => {
    it('Should create an HTMLContainerComponent', () => {
        const comp = new test_1.HTMLContainerComponent(fixtures_1.comp1);
        chai_1.assert.equal(comp.render(), '<div ref="htmlcontainer" one="two" three="four" class="testing">' +
            `<span ref="html" data-within="${comp.id}">Testing</span>` +
            '</div>');
    });
    it('Should create nested HTML hiararchies', () => {
        const comp = new test_1.HTMLContainerComponent(fixtures_1.comp2);
        chai_1.assert.equal(comp.render(), '<div ref="htmlcontainer" one="two" three="four" class="testing">' +
            `<span ref="html" data-within="${comp.id}">Testing</span>` +
            `<div ref="htmlcontainer" data-within="${comp.id}">` +
            `<h3 ref="html" data-within="${comp.components[1].id}"><script>alert("No XSS allowed!!!!");</script>This is a title</h3>` +
            '</div>' +
            '</div>');
    });
    it('Should sanitize the output to ensure XSS does not occur.', () => {
        const comp = new test_1.HTMLContainerComponent(fixtures_1.comp2);
        const parentElement = document.createElement('div');
        const element = document.createElement('div');
        parentElement.appendChild(element);
        comp.attach(element);
        chai_1.assert.equal(parentElement.innerHTML, '<div class="testing" ref="htmlcontainer">' +
            `<span data-within="${comp.id}" ref="html">Testing</span>` +
            `<div data-within="${comp.id}" ref="htmlcontainer">` +
            `<h3 data-within="${comp.components[1].id}" ref="html">This is a title</h3>` +
            '</div>' +
            '</div>');
    });
});
