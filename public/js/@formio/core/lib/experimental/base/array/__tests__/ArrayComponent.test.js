"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const chai_1 = require("chai");
const ArrayComponent_1 = require("../ArrayComponent");
const fixtures_1 = require("./fixtures");
const ArrayComponent = (0, ArrayComponent_1.ArrayComponent)()();
describe('ArrayComponent', () => {
    it('Should create a new Array Component', () => {
        const data = {};
        new ArrayComponent(fixtures_1.comp1, {}, data);
        chai_1.assert.deepEqual(data, { employees: [] });
    });
    it('Should create an Array Component with default data', () => {
        let employees = [
            {
                firstName: 'Joe',
                lastName: 'Smith'
            },
            {
                firstName: 'Sally',
                lastName: 'Thompson'
            }
        ];
        const data = {
            employees: employees
        };
        const arrComp = new ArrayComponent(fixtures_1.comp1, {}, data);
        chai_1.assert.deepEqual(data, { employees: employees });
        chai_1.assert.deepEqual(arrComp.dataValue, employees);
        chai_1.assert.equal(arrComp.rows.length, 2);
        chai_1.assert.equal(arrComp.rows[0].length, 2);
        chai_1.assert.equal(arrComp.rows[1].length, 2);
        chai_1.assert.equal(arrComp.components.length, 4);
        chai_1.assert.equal(arrComp.components[0].dataValue, 'Joe');
        chai_1.assert.equal(arrComp.components[1].dataValue, 'Smith');
        chai_1.assert.strictEqual(arrComp.rows[0][0], arrComp.components[0]);
        chai_1.assert.strictEqual(arrComp.rows[0][1], arrComp.components[1]);
        chai_1.assert.strictEqual(arrComp.rows[1][0], arrComp.components[2]);
        chai_1.assert.strictEqual(arrComp.rows[1][1], arrComp.components[3]);
        chai_1.assert.equal(arrComp.components[2].dataValue, 'Sally');
        chai_1.assert.equal(arrComp.components[3].dataValue, 'Thompson');
    });
    it('Should set the value of the sub components', () => {
        const data = {};
        const arrComp = new ArrayComponent(fixtures_1.comp1, {}, data);
        let employees = [
            {
                firstName: 'Joe',
                lastName: 'Smith'
            },
            {
                firstName: 'Sally',
                lastName: 'Thompson'
            }
        ];
        arrComp.dataValue = employees;
        chai_1.assert.deepEqual(data, { employees: employees });
        chai_1.assert.deepEqual(arrComp.dataValue, employees);
        chai_1.assert.equal(arrComp.rows.length, 2);
        chai_1.assert.equal(arrComp.rows[0].length, 2);
        chai_1.assert.equal(arrComp.rows[1].length, 2);
        chai_1.assert.equal(arrComp.components.length, 4);
        chai_1.assert.equal(arrComp.components[0].dataValue, 'Joe');
        chai_1.assert.equal(arrComp.components[1].dataValue, 'Smith');
        chai_1.assert.strictEqual(arrComp.rows[0][0], arrComp.components[0]);
        chai_1.assert.strictEqual(arrComp.rows[0][1], arrComp.components[1]);
        chai_1.assert.strictEqual(arrComp.rows[1][0], arrComp.components[2]);
        chai_1.assert.strictEqual(arrComp.rows[1][1], arrComp.components[3]);
        chai_1.assert.equal(arrComp.components[2].dataValue, 'Sally');
        chai_1.assert.equal(arrComp.components[3].dataValue, 'Thompson');
        // Ensure it removes rows.
        employees = [
            {
                firstName: 'Sally',
                lastName: 'Thompson'
            }
        ];
        arrComp.dataValue = employees;
        chai_1.assert.deepEqual(data, { employees: employees });
        chai_1.assert.deepEqual(arrComp.dataValue, employees);
        chai_1.assert.equal(arrComp.rows.length, 1);
        chai_1.assert.equal(arrComp.rows[0].length, 2);
        chai_1.assert.equal(arrComp.components.length, 2);
        chai_1.assert.strictEqual(arrComp.rows[0][0], arrComp.components[0]);
        chai_1.assert.strictEqual(arrComp.rows[0][1], arrComp.components[1]);
        chai_1.assert.equal(arrComp.components[0].dataValue, 'Sally');
        chai_1.assert.equal(arrComp.components[1].dataValue, 'Thompson');
        // Ensure it adds another row.
        employees = [
            {
                firstName: 'Sally',
                lastName: 'Thompson'
            },
            {
                firstName: 'Joe',
                lastName: 'Smith'
            }
        ];
        arrComp.dataValue = employees;
        chai_1.assert.deepEqual(data, { employees: employees });
        chai_1.assert.deepEqual(arrComp.dataValue, employees);
        chai_1.assert.equal(arrComp.rows.length, 2);
        chai_1.assert.equal(arrComp.rows[0].length, 2);
        chai_1.assert.equal(arrComp.rows[1].length, 2);
        chai_1.assert.equal(arrComp.components.length, 4);
        chai_1.assert.equal(arrComp.components[0].dataValue, 'Sally');
        chai_1.assert.equal(arrComp.components[1].dataValue, 'Thompson');
        chai_1.assert.strictEqual(arrComp.rows[0][0], arrComp.components[0]);
        chai_1.assert.strictEqual(arrComp.rows[0][1], arrComp.components[1]);
        chai_1.assert.strictEqual(arrComp.rows[1][0], arrComp.components[2]);
        chai_1.assert.strictEqual(arrComp.rows[1][1], arrComp.components[3]);
        chai_1.assert.equal(arrComp.components[2].dataValue, 'Joe');
        chai_1.assert.equal(arrComp.components[3].dataValue, 'Smith');
    });
    const employees = [
        {
            firstName: 'Joe',
            lastName: 'Smith',
            department: {
                name: 'HR',
                phoneNumber: '555-123-4567'
            },
            children: [
                {
                    firstName: 'Joe Jr.',
                    dob: '5-17-2008'
                },
                {
                    firstName: 'Joey',
                    dob: '12-2-2010'
                }
            ]
        },
        {
            firstName: 'Sally',
            lastName: 'Thompson',
            department: {
                name: 'Sales',
                phoneNumber: '123-456-7890'
            },
            children: [
                {
                    firstName: 'Harry',
                    dob: '1-23-2002'
                },
                {
                    firstName: 'Sue',
                    dob: '3-23-2010'
                },
                {
                    firstName: 'Stuart',
                    dob: '9-23-2014'
                }
            ]
        }
    ];
    it('Should allow complex data structures', () => {
        const data = { employees };
        const arrComp = new ArrayComponent(fixtures_1.comp2, {}, data);
        chai_1.assert.deepEqual(data, { employees: employees });
        chai_1.assert.deepEqual(arrComp.dataValue, employees);
        chai_1.assert.equal(arrComp.rows.length, 2);
        chai_1.assert.equal(arrComp.rows[0].length, 4);
        chai_1.assert.equal(arrComp.rows[1].length, 4);
        chai_1.assert.equal(arrComp.components.length, 8);
        chai_1.assert.strictEqual(arrComp.rows[0][0], arrComp.components[0]);
        chai_1.assert.strictEqual(arrComp.rows[0][1], arrComp.components[1]);
        chai_1.assert.strictEqual(arrComp.rows[0][2], arrComp.components[2]);
        chai_1.assert.strictEqual(arrComp.rows[0][3], arrComp.components[3]);
        chai_1.assert.strictEqual(arrComp.rows[1][0], arrComp.components[4]);
        chai_1.assert.strictEqual(arrComp.rows[1][1], arrComp.components[5]);
        chai_1.assert.strictEqual(arrComp.rows[1][2], arrComp.components[6]);
        chai_1.assert.strictEqual(arrComp.rows[1][3], arrComp.components[7]);
        chai_1.assert.equal(arrComp.components[0].dataValue, employees[0].firstName);
        chai_1.assert.equal(arrComp.components[1].dataValue, employees[0].lastName);
        chai_1.assert.equal(arrComp.components[2].dataValue, employees[0].department);
        chai_1.assert.equal(arrComp.components[2].components.length, 2);
        chai_1.assert.equal(arrComp.components[2].components[0].dataValue, employees[0].department.name);
        chai_1.assert.equal(arrComp.components[2].components[1].dataValue, employees[0].department.phoneNumber);
        chai_1.assert.equal(arrComp.components[3].dataValue, employees[0].children);
        chai_1.assert.equal(arrComp.components[3].components.length, 4);
        chai_1.assert.equal(arrComp.components[3].components[0].dataValue, employees[0].children[0].firstName);
        chai_1.assert.equal(arrComp.components[3].components[1].dataValue, employees[0].children[0].dob);
        chai_1.assert.equal(arrComp.components[3].components[2].dataValue, employees[0].children[1].firstName);
        chai_1.assert.equal(arrComp.components[3].components[3].dataValue, employees[0].children[1].dob);
        chai_1.assert.equal(arrComp.components[4].dataValue, employees[1].firstName);
        chai_1.assert.equal(arrComp.components[5].dataValue, employees[1].lastName);
        chai_1.assert.equal(arrComp.components[6].dataValue, employees[1].department);
        chai_1.assert.equal(arrComp.components[6].components.length, 2);
        chai_1.assert.equal(arrComp.components[6].components[0].dataValue, employees[1].department.name);
        chai_1.assert.equal(arrComp.components[6].components[1].dataValue, employees[1].department.phoneNumber);
        chai_1.assert.equal(arrComp.components[7].dataValue, employees[1].children);
        chai_1.assert.equal(arrComp.components[7].components.length, 6);
        chai_1.assert.equal(arrComp.components[7].components[0].dataValue, employees[1].children[0].firstName);
        chai_1.assert.equal(arrComp.components[7].components[1].dataValue, employees[1].children[0].dob);
        chai_1.assert.equal(arrComp.components[7].components[2].dataValue, employees[1].children[1].firstName);
        chai_1.assert.equal(arrComp.components[7].components[3].dataValue, employees[1].children[1].dob);
        chai_1.assert.equal(arrComp.components[7].components[4].dataValue, employees[1].children[2].firstName);
        chai_1.assert.equal(arrComp.components[7].components[5].dataValue, employees[1].children[2].dob);
    });
    it('Should be able to set complex data structures.', () => {
        const data = {};
        const arrComp = new ArrayComponent(fixtures_1.comp2, {}, data);
        arrComp.dataValue = employees;
        chai_1.assert.deepEqual(data, { employees: employees });
        chai_1.assert.deepEqual(arrComp.dataValue, employees);
        chai_1.assert.equal(arrComp.rows.length, 2);
        chai_1.assert.equal(arrComp.rows[0].length, 4);
        chai_1.assert.equal(arrComp.rows[1].length, 4);
        chai_1.assert.equal(arrComp.components.length, 8);
        chai_1.assert.strictEqual(arrComp.rows[0][0], arrComp.components[0]);
        chai_1.assert.strictEqual(arrComp.rows[0][1], arrComp.components[1]);
        chai_1.assert.strictEqual(arrComp.rows[0][2], arrComp.components[2]);
        chai_1.assert.strictEqual(arrComp.rows[0][3], arrComp.components[3]);
        chai_1.assert.strictEqual(arrComp.rows[1][0], arrComp.components[4]);
        chai_1.assert.strictEqual(arrComp.rows[1][1], arrComp.components[5]);
        chai_1.assert.strictEqual(arrComp.rows[1][2], arrComp.components[6]);
        chai_1.assert.strictEqual(arrComp.rows[1][3], arrComp.components[7]);
        chai_1.assert.equal(arrComp.components[0].dataValue, employees[0].firstName);
        chai_1.assert.equal(arrComp.components[1].dataValue, employees[0].lastName);
        chai_1.assert.equal(arrComp.components[2].dataValue, employees[0].department);
        chai_1.assert.equal(arrComp.components[2].components.length, 2);
        chai_1.assert.equal(arrComp.components[2].components[0].dataValue, employees[0].department.name);
        chai_1.assert.equal(arrComp.components[2].components[1].dataValue, employees[0].department.phoneNumber);
        chai_1.assert.equal(arrComp.components[3].dataValue, employees[0].children);
        chai_1.assert.equal(arrComp.components[3].components.length, 4);
        chai_1.assert.equal(arrComp.components[3].components[0].dataValue, employees[0].children[0].firstName);
        chai_1.assert.equal(arrComp.components[3].components[1].dataValue, employees[0].children[0].dob);
        chai_1.assert.equal(arrComp.components[3].components[2].dataValue, employees[0].children[1].firstName);
        chai_1.assert.equal(arrComp.components[3].components[3].dataValue, employees[0].children[1].dob);
        chai_1.assert.equal(arrComp.components[4].dataValue, employees[1].firstName);
        chai_1.assert.equal(arrComp.components[5].dataValue, employees[1].lastName);
        chai_1.assert.equal(arrComp.components[6].dataValue, employees[1].department);
        chai_1.assert.equal(arrComp.components[6].components.length, 2);
        chai_1.assert.equal(arrComp.components[6].components[0].dataValue, employees[1].department.name);
        chai_1.assert.equal(arrComp.components[6].components[1].dataValue, employees[1].department.phoneNumber);
        chai_1.assert.equal(arrComp.components[7].dataValue, employees[1].children);
        chai_1.assert.equal(arrComp.components[7].components.length, 6);
        chai_1.assert.equal(arrComp.components[7].components[0].dataValue, employees[1].children[0].firstName);
        chai_1.assert.equal(arrComp.components[7].components[1].dataValue, employees[1].children[0].dob);
        chai_1.assert.equal(arrComp.components[7].components[2].dataValue, employees[1].children[1].firstName);
        chai_1.assert.equal(arrComp.components[7].components[3].dataValue, employees[1].children[1].dob);
        chai_1.assert.equal(arrComp.components[7].components[4].dataValue, employees[1].children[2].firstName);
        chai_1.assert.equal(arrComp.components[7].components[5].dataValue, employees[1].children[2].dob);
        // Ensure parent and root elements are all set correctly.
        chai_1.assert.strictEqual(arrComp.components[7].components[0].parent, arrComp.components[7]);
        chai_1.assert.strictEqual(arrComp.components[7].components[1].parent, arrComp.components[7]);
        chai_1.assert.strictEqual(arrComp.components[7].components[0].root, arrComp);
        chai_1.assert.strictEqual(arrComp.components[7].parent, arrComp);
    });
});
