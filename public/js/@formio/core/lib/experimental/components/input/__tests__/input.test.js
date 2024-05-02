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
const test_1 = require("../../test");
const fixtures_1 = require("./fixtures");
describe('Input Component', () => {
    it('Should create a new input component', () => {
        const comp = new test_1.InputComponent(fixtures_1.comp1);
        chai_1.assert.equal(comp.render(), `<input ref="input" type="text" id="input-firstname" name="input-firstname" one="two" three="four"></input>`);
    });
    it('Should create input of different types', () => {
        const comp = new test_1.InputComponent(Object.assign(Object.assign({}, fixtures_1.comp1), { inputType: 'number' }));
        chai_1.assert.equal(comp.render(), `<input ref="input" type="number" id="input-firstname" name="input-firstname" one="two" three="four"></input>`);
    });
    it('Should render a Form input with label and input', () => __awaiter(void 0, void 0, void 0, function* () {
        const comp = new test_1.HTMLContainerComponent(fixtures_1.comp2);
        const parentElement = document.createElement('div');
        const element = document.createElement('div');
        parentElement.appendChild(element);
        yield comp.attach(element);
        comp.setValue({
            firstName: 'Joe',
            lastName: 'Smith'
        });
        chai_1.assert.equal(parentElement.innerHTML, '<span ref="htmlcontainer">' +
            `<label for="input-firstname" class="form-label" ref="html">First Name</label>` +
            `<input placeholder="Enter your first name" class="form-control" name="input-firstname" id="input-firstname" type="text" ref="input">` +
            `<label for="input-firstname" class="form-label" ref="html">Last Name</label>` +
            `<input placeholder="Enter your last name" class="form-control" name="input-lastname" id="input-lastname" type="text" ref="input">` +
            '</span>');
        chai_1.assert.deepEqual(comp.dataValue, {
            firstName: 'Joe',
            lastName: 'Smith'
        });
        yield new Promise((resolve, reject) => {
            comp.on('change', () => {
                // Verify the data changed as well.
                try {
                    chai_1.assert.deepEqual(comp.dataValue, {
                        firstName: 'Sally',
                        lastName: 'Smith'
                    });
                }
                catch (err) {
                    return reject(err);
                }
                resolve();
            });
            // Trigger an input change.
            const firstName = comp.components[1].element;
            firstName.value = 'Sally';
            const evt = document.createEvent("Events");
            evt.initEvent("input", true, true);
            firstName.dispatchEvent(evt);
        });
    }));
});
