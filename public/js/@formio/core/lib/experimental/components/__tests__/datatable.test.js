"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const chai_1 = require("chai");
const test_1 = require("../test");
describe('DataTable', () => {
    it('Should create a DataTable component', () => {
        const trimHtml = (html) => {
            return html.replace(/\n/g, "")
                .replace(/[\t ]+\</g, "<")
                .replace(/\>[\t ]+\</g, "><")
                .replace(/\>[\t ]+$/g, ">");
        };
        const dataTable = new test_1.DataTableComponent({
            type: 'datatable',
            key: 'customers',
            components: [
                {
                    type: 'datavalue',
                    key: 'firstName',
                    label: 'First Name'
                },
                {
                    type: 'datavalue',
                    key: 'lastName',
                    label: 'Last Name'
                }
            ]
        }, {}, {
            customers: [
                { firstName: 'Joe', lastName: 'Smith' },
                { firstName: 'Sally', lastName: 'Thompson' },
                { firstName: 'Mary', lastName: 'Bono' }
            ]
        });
        chai_1.assert.equal(trimHtml(dataTable.render()), trimHtml(`
        <table class="table table-bordered table-hover table-condensed">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Joe</td>
                    <td>Smith</td>
                </tr>
                <tr>
                    <td>Sally</td>
                    <td>Thompson</td>
                </tr>
                <tr>
                    <td>Mary</td>
                    <td>Bono</td>
                </tr>
            </tbody>
        </table>`));
    });
});
