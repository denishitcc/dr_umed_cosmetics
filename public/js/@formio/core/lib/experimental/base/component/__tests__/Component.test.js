"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const Component_1 = require("../Component");
const chai_1 = require("chai");
const Component = (0, Component_1.Component)()();
describe('Component', () => {
    it('Should create a new Component component', () => {
        // Default to an empty object.
        const comp = new Component({
            type: 'textfield',
            key: 'firstName'
        });
        chai_1.assert.equal(comp.options.language, 'en');
        chai_1.assert.equal(comp.options.namespace, 'formio');
        chai_1.assert.deepEqual(comp.component, {
            type: 'textfield',
            key: 'firstName',
            protected: false,
            persistent: true
        });
    });
    it('init hook should be called.', (done) => {
        new Component({
            type: 'textfield',
            key: 'lastName'
        }, {
            hooks: {
                init: function () {
                    // Init method must be called.
                    (0, chai_1.assert)(this instanceof Component, `'this' must be an instance of Component`);
                    done();
                }
            }
        });
    });
    it('Should render a component', () => {
        const parent = document.createElement('div');
        const element = document.createElement('div');
        parent.appendChild(element);
        const comp = new Component({
            type: 'html',
            key: 'html'
        });
        comp.attach(element);
    });
    // xit ('Should validate a component', async () => {
    //     const comp = new Component({
    //         type: 'textfield',
    //         key: 'firstName',
    //         validate: {
    //             required: true
    //         }
    //     }, {
    //         validator: Validator
    //     });
    //     assert.equal(await comp.checkValidity(), false);
    //     comp.dataValue = 'testing';
    //     assert.equal(await comp.checkValidity(), true);
    // });
    it('Should clear attachedListeners array after detach', () => {
        const element = document.createElement('div');
        const comp = new Component({
            type: 'textfield',
            key: 'firstName'
        });
        comp.attach(element);
        chai_1.assert.deepEqual(comp.attachedListeners, []);
        const listenerObj = { obj: element, type: 'click', func: () => { } };
        comp.attachedListeners.push(listenerObj);
        chai_1.assert.deepEqual(comp.attachedListeners, [listenerObj]);
        comp.detach();
        chai_1.assert.deepEqual(comp.attachedListeners, []);
    });
});
