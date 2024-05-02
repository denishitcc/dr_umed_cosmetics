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
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const get_1 = __importDefault(require("lodash/get"));
const chai_1 = require("chai");
const formUtil_1 = require("../formUtil");
describe('getContextualRowData', () => {
    it('Should return the data at path without the last element given nested containers', () => {
        const data = {
            a: {
                b: {
                    c: 'hello',
                },
            },
        };
        const path = 'a.b.c';
        const actual = (0, formUtil_1.getContextualRowData)({
            type: 'textfield',
            input: true,
            key: 'c'
        }, path, data);
        const expected = { c: 'hello' };
        (0, chai_1.expect)(actual).to.deep.equal(expected);
    });
    it('Should return the data at path without the last element given nested containers', () => {
        const data = {
            a: {
                b: {
                    c: 'hello',
                },
            },
        };
        const path = 'a.b';
        const actual = (0, formUtil_1.getContextualRowData)({
            type: 'textfield',
            input: true,
            key: 'b'
        }, path, data);
        const expected = { b: { c: 'hello' } };
        (0, chai_1.expect)(actual).to.deep.equal(expected);
    });
    it('Should return the data at path without the last element given nested containers', () => {
        const data = {
            a: {
                b: {
                    c: 'hello',
                },
            },
        };
        const path = 'a';
        const actual = (0, formUtil_1.getContextualRowData)({
            type: 'textfield',
            input: true,
            key: 'a'
        }, path, data);
        const expected = { a: { b: { c: 'hello' } } };
        (0, chai_1.expect)(actual).to.deep.equal(expected);
    });
    it('Should return the data at path without the last element given nested containers', () => {
        const data = {
            a: {
                b: {
                    c: 'hello',
                },
            },
            d: 'there'
        };
        const path = '';
        const actual = (0, formUtil_1.getContextualRowData)({
            type: 'textfield',
            input: true,
            key: 'd'
        }, path, data);
        const expected = { a: { b: { c: 'hello' } }, d: 'there' };
        (0, chai_1.expect)(actual).to.deep.equal(expected);
    });
    it('Should return the data at path given nested arrays', () => {
        const data = {
            a: [{ b: 'hello', c: 'world' }, { b: 'foo', c: 'bar' }],
        };
        const path = 'a[0].b';
        const actual = (0, formUtil_1.getContextualRowData)({
            type: 'textfield',
            input: true,
            key: 'b'
        }, path, data);
        const expected = { b: 'hello', c: 'world' };
        (0, chai_1.expect)(actual).to.deep.equal(expected);
    });
    it('Should return the data at path given nested arrays', () => {
        const data = {
            a: [{ b: 'hello', c: 'world' }, { b: 'foo', c: 'bar' }],
        };
        const path = 'a[1].b';
        const actual = (0, formUtil_1.getContextualRowData)({
            type: 'textfield',
            input: true,
            key: 'b'
        }, path, data);
        const expected = { b: 'foo', c: 'bar' };
        (0, chai_1.expect)(actual).to.deep.equal(expected);
    });
    it('Should return the data at path given nested arrays', () => {
        const data = {
            a: [{ b: 'hello', c: 'world' }, { b: 'foo', c: 'bar' }],
        };
        const path = 'a';
        const actual = (0, formUtil_1.getContextualRowData)({
            type: 'textfield',
            input: true,
            key: 'a'
        }, path, data);
        const expected = {
            a: [{ b: 'hello', c: 'world' }, { b: 'foo', c: 'bar' }],
        };
        (0, chai_1.expect)(actual).to.deep.equal(expected);
    });
    it('Should return the data at path given nested arrays', () => {
        const data = {
            a: [{ b: 'hello', c: 'world' }, { b: 'foo', c: 'bar' }],
        };
        const path = '';
        const actual = (0, formUtil_1.getContextualRowData)({
            type: 'textfield',
            input: true,
            key: 'a'
        }, path, data);
        const expected = {
            a: [{ b: 'hello', c: 'world' }, { b: 'foo', c: 'bar' }],
        };
        (0, chai_1.expect)(actual).to.deep.equal(expected);
    });
    it('Should return the data at path given nested containers and arrays', () => {
        const data = {
            a: {
                b: [{ c: 'hello', d: 'world' }, { c: 'foo', d: 'bar' }],
            },
        };
        const path = 'a.b[0].c';
        const actual = (0, formUtil_1.getContextualRowData)({
            type: 'textfield',
            input: true,
            key: 'c'
        }, path, data);
        const expected = { c: 'hello', d: 'world' };
        (0, chai_1.expect)(actual).to.deep.equal(expected);
    });
    it('Should return the data at path given nested containers and arrays', () => {
        const data = {
            a: {
                b: [{ c: 'hello', d: 'world' }, { c: 'foo', d: 'bar' }],
            },
        };
        const path = 'a.b[1].c';
        const actual = (0, formUtil_1.getContextualRowData)({
            type: 'textfield',
            input: true,
            key: 'c'
        }, path, data);
        const expected = { c: 'foo', d: 'bar' };
        (0, chai_1.expect)(actual).to.deep.equal(expected);
    });
    it('Should return the data at path given nested containers and arrays', () => {
        const data = {
            a: {
                b: [{ c: 'hello', d: 'world' }, { c: 'foo', d: 'bar' }],
            },
        };
        const path = 'a.b';
        const actual = (0, formUtil_1.getContextualRowData)({
            type: 'textfield',
            input: true,
            key: 'b'
        }, path, data);
        const expected = { b: [{ c: 'hello', d: 'world' }, { c: 'foo', d: 'bar' }] };
        (0, chai_1.expect)(actual).to.deep.equal(expected);
    });
    it('Should return the data at path given nested containers and arrays', () => {
        const data = {
            a: {
                b: [{ c: 'hello', d: 'world' }, { c: 'foo', d: 'bar' }],
            },
        };
        const path = 'a';
        const actual = (0, formUtil_1.getContextualRowData)({
            type: 'textfield',
            input: true,
            key: 'a'
        }, path, data);
        const expected = { a: { b: [{ c: 'hello', d: 'world' }, { c: 'foo', d: 'bar' }] } };
        (0, chai_1.expect)(actual).to.deep.equal(expected);
    });
    it('Should return the data at path given nested containers and arrays', () => {
        const data = {
            a: {
                b: [{ c: 'hello', d: 'world' }, { c: 'foo', d: 'bar' }],
            },
        };
        const path = '';
        const actual = (0, formUtil_1.getContextualRowData)({
            type: 'textfield',
            input: true,
            key: 'a'
        }, path, data);
        const expected = { a: { b: [{ c: 'hello', d: 'world' }, { c: 'foo', d: 'bar' }] } };
        (0, chai_1.expect)(actual).to.deep.equal(expected);
    });
    it('Should work with a component key that has periods in it', () => {
        const data = {
            a: {
                b: [{ c: { e: 'zed' }, d: 'world' }, { c: { e: 'foo' }, d: 'bar' }],
            },
        };
        const path = 'a.b[0].c.e';
        const actual = (0, formUtil_1.getContextualRowData)({
            type: 'textfield',
            input: true,
            key: 'c.e'
        }, path, data);
        const expected = { c: { e: 'zed' }, d: 'world' };
        (0, chai_1.expect)(actual).to.deep.equal(expected);
    });
});
describe('eachComponentDataAsync', () => {
    it('Should iterate over each component and data given a flat components array', () => __awaiter(void 0, void 0, void 0, function* () {
        const components = [
            {
                type: 'textfield',
                key: 'textField',
                label: 'Text Field',
                input: true,
            },
            {
                type: 'textarea',
                key: 'textArea',
                label: 'Text Area',
                input: true,
            }
        ];
        const data = {
            textField: 'hello',
            textArea: 'world',
        };
        const rowResults = new Map();
        yield (0, formUtil_1.eachComponentDataAsync)(components, data, (component, data, row, path) => __awaiter(void 0, void 0, void 0, function* () {
            const value = (0, get_1.default)(data, path);
            rowResults.set(path, [component, value]);
        }));
        (0, chai_1.expect)(rowResults.size).to.equal(2);
        (0, chai_1.expect)(rowResults.get('textField')).to.deep.equal([
            {
                type: 'textfield',
                key: 'textField',
                label: 'Text Field',
                input: true,
            },
            'hello'
        ]);
        (0, chai_1.expect)(rowResults.get('textArea')).to.deep.equal([
            {
                type: 'textarea',
                key: 'textArea',
                label: 'Text Area',
                input: true,
            },
            'world'
        ]);
    }));
    it('Should iterate over each component and data given a container component and a nested components array', () => __awaiter(void 0, void 0, void 0, function* () {
        const components = [
            {
                type: 'textfield',
                key: 'textField',
                label: 'Text Field',
                input: true,
            },
            {
                type: 'container',
                key: 'container',
                label: 'Container',
                input: true,
                components: [
                    {
                        type: 'textfield',
                        key: 'nestedTextField',
                        label: 'Nested Text Field',
                        input: true,
                    },
                    {
                        type: 'textarea',
                        key: 'nestedTextArea',
                        label: 'Nested Text Area',
                        input: true,
                    }
                ]
            }
        ];
        const data = {
            textField: 'hello',
            container: {
                nestedTextField: 'world',
                nestedTextArea: 'foo',
            },
        };
        const rowResults = new Map();
        yield (0, formUtil_1.eachComponentDataAsync)(components, data, (component, data, row, path) => __awaiter(void 0, void 0, void 0, function* () {
            const value = (0, get_1.default)(data, path);
            rowResults.set(path, [component, value]);
        }));
        (0, chai_1.expect)(rowResults.size).to.equal(4);
        (0, chai_1.expect)(rowResults.get('textField')).to.deep.equal([
            {
                type: 'textfield',
                key: 'textField',
                label: 'Text Field',
                input: true,
            },
            'hello'
        ]);
        (0, chai_1.expect)(rowResults.get('container')).to.deep.equal([
            {
                type: 'container',
                key: 'container',
                label: 'Container',
                input: true,
                components: [
                    {
                        type: 'textfield',
                        key: 'nestedTextField',
                        label: 'Nested Text Field',
                        input: true,
                    },
                    {
                        type: 'textarea',
                        key: 'nestedTextArea',
                        label: 'Nested Text Area',
                        input: true,
                    }
                ]
            },
            {
                nestedTextField: 'world',
                nestedTextArea: 'foo',
            }
        ]);
        (0, chai_1.expect)(rowResults.get('container.nestedTextField')).to.deep.equal([
            {
                type: 'textfield',
                key: 'nestedTextField',
                label: 'Nested Text Field',
                input: true,
            },
            'world'
        ]);
        (0, chai_1.expect)(rowResults.get('container.nestedTextArea')).to.deep.equal([
            {
                type: 'textarea',
                key: 'nestedTextArea',
                label: 'Nested Text Area',
                input: true,
            },
            'foo'
        ]);
    }));
    it('Should iterate over each component and data given a datagrid component and a nested components array', () => __awaiter(void 0, void 0, void 0, function* () {
        const components = [
            {
                type: 'textfield',
                key: 'textField',
                label: 'Text Field',
                input: true,
            },
            {
                type: 'datagrid',
                key: 'dataGrid',
                label: 'Data Grid',
                input: true,
                components: [
                    {
                        type: 'textfield',
                        key: 'nestedTextField',
                        label: 'Nested Text Field',
                        input: true,
                    },
                    {
                        type: 'textarea',
                        key: 'nestedTextArea',
                        label: 'Nested Text Area',
                        input: true,
                    }
                ]
            }
        ];
        const data = {
            textField: 'hello',
            dataGrid: [
                {
                    nestedTextField: 'world',
                    nestedTextArea: 'foo',
                },
                {
                    nestedTextField: 'bar',
                    nestedTextArea: 'baz',
                }
            ],
        };
        const rowResults = new Map();
        yield (0, formUtil_1.eachComponentDataAsync)(components, data, (component, data, row, path) => __awaiter(void 0, void 0, void 0, function* () {
            const value = (0, get_1.default)(data, path);
            rowResults.set(path, [component, value]);
        }));
        (0, chai_1.expect)(rowResults.size).to.equal(6);
        (0, chai_1.expect)(rowResults.get('textField')).to.deep.equal([
            {
                type: 'textfield',
                key: 'textField',
                label: 'Text Field',
                input: true,
            },
            'hello'
        ]);
        (0, chai_1.expect)(rowResults.get('dataGrid')).to.deep.equal([
            {
                type: 'datagrid',
                key: 'dataGrid',
                label: 'Data Grid',
                input: true,
                components: [
                    {
                        type: 'textfield',
                        key: 'nestedTextField',
                        label: 'Nested Text Field',
                        input: true,
                    },
                    {
                        type: 'textarea',
                        key: 'nestedTextArea',
                        label: 'Nested Text Area',
                        input: true,
                    }
                ]
            },
            [
                {
                    nestedTextField: 'world',
                    nestedTextArea: 'foo',
                },
                {
                    nestedTextField: 'bar',
                    nestedTextArea: 'baz',
                }
            ]
        ]);
        (0, chai_1.expect)(rowResults.get('dataGrid[0].nestedTextField')).to.deep.equal([
            {
                type: 'textfield',
                key: 'nestedTextField',
                label: 'Nested Text Field',
                input: true,
            },
            'world'
        ]);
    }));
    it('Should iterate over a components array and include components that are not in the data object if the includeAll flag is set to true', () => __awaiter(void 0, void 0, void 0, function* () {
        const components = [
            {
                type: 'textfield',
                key: 'textField',
                label: 'Text Field',
                input: true,
            },
            {
                type: 'textarea',
                key: 'textArea',
                label: 'Text Area',
                input: true,
            }
        ];
        const data = {
            textField: 'hello',
        };
        const rowResults = new Map();
        yield (0, formUtil_1.eachComponentDataAsync)(components, data, (component, data, row, path) => __awaiter(void 0, void 0, void 0, function* () {
            const value = (0, get_1.default)(data, path);
            rowResults.set(path, [component, value]);
        }), undefined, undefined, undefined, true);
        (0, chai_1.expect)(rowResults.size).to.equal(2);
        (0, chai_1.expect)(rowResults.get('textField')).to.deep.equal([
            {
                type: 'textfield',
                key: 'textField',
                label: 'Text Field',
                input: true,
            },
            'hello'
        ]);
        (0, chai_1.expect)(rowResults.get('textArea')).to.deep.equal([
            {
                type: 'textarea',
                key: 'textArea',
                label: 'Text Area',
                input: true,
            },
            undefined
        ]);
    }));
    describe('Flattened form components (for evaluation)', () => {
        it('Should return the correct contextual row data for each component', () => __awaiter(void 0, void 0, void 0, function* () {
            const components = [
                {
                    type: 'textfield',
                    key: 'textField',
                    input: true,
                    tableView: true,
                },
                {
                    type: 'datagrid',
                    key: 'dataGrid',
                    input: true,
                    tableView: true,
                },
                {
                    type: 'textfield',
                    key: 'dataGrid[0].nestedTextField',
                    input: true,
                    tableView: true,
                },
                {
                    type: 'editgrid',
                    key: 'dataGrid[0].nestedEditGrid',
                    input: true,
                    tableView: true,
                },
                {
                    type: 'textfield',
                    key: 'dataGrid[0].nestedEditGrid[0].nestedNestedTextField',
                    input: true,
                    tableView: true,
                },
            ];
            const data = {
                textField: 'hello',
                dataGrid: [
                    {
                        nestedTextField: 'world',
                        nestedEditGrid: [
                            {
                                nestedNestedTextField: 'foo',
                            },
                        ],
                    },
                    {
                        nestedTextField: 'bar',
                        nestedEditGrid: [
                            {
                                nestedNestedTextField: 'baz',
                            },
                        ],
                    },
                ],
            };
            const rowResults = new Map();
            yield (0, formUtil_1.eachComponentDataAsync)(components, data, (component, data, row, path) => __awaiter(void 0, void 0, void 0, function* () {
                rowResults.set(path, row);
            }));
            console.log(rowResults);
        }));
    });
    describe('Normal form components', () => {
        it('Should return the correct contextual row data for each component', () => __awaiter(void 0, void 0, void 0, function* () {
            const components = [
                {
                    type: 'textfield',
                    key: 'textField',
                    input: true,
                    tableView: true,
                },
                {
                    type: 'datagrid',
                    key: 'dataGrid',
                    input: true,
                    tableView: true,
                    components: [
                        {
                            type: 'textfield',
                            key: 'nestedTextField',
                            input: true,
                            tableView: true,
                        },
                        {
                            type: 'editGrid',
                            key: 'nestedEditGrid',
                            input: true,
                            tableView: true,
                            components: [
                                {
                                    type: 'textfield',
                                    key: 'nestedNestedTextField',
                                    input: true,
                                    tableView: true,
                                },
                            ],
                        }
                    ],
                },
            ];
            const data = {
                textField: 'hello',
                dataGrid: [
                    {
                        nestedTextField: 'world',
                        nestedEditGrid: [
                            {
                                nestedNestedTextField: 'foo',
                            },
                        ],
                    },
                    {
                        nestedTextField: 'bar',
                        nestedEditGrid: [
                            {
                                nestedNestedTextField: 'baz',
                            },
                        ],
                    },
                ],
            };
            const rowResults = new Map();
            yield (0, formUtil_1.eachComponentDataAsync)(components, data, (component, data, row, path) => __awaiter(void 0, void 0, void 0, function* () {
                rowResults.set(path, row);
            }));
            console.log(rowResults);
        }));
    });
});
describe('isComponentDataEmpty', () => {
    it('Should return true for an empty object', () => {
        const component = {
            type: 'textfield',
            input: true,
            key: 'textField',
        };
        const data = {};
        const actual = (0, formUtil_1.isComponentDataEmpty)(component, data, 'textField');
        const expected = true;
        (0, chai_1.expect)(actual).to.equal(expected);
    });
    it('Should return false for a non-empty object', () => {
        const component = {
            type: 'textfield',
            input: true,
            key: 'textField',
        };
        const data = {
            textField: 'hello',
        };
        const actual = (0, formUtil_1.isComponentDataEmpty)(component, data, 'textField');
        const expected = false;
        (0, chai_1.expect)(actual).to.equal(expected);
    });
    it('Should return true for a checkbox component set to false', () => {
        const component = {
            type: 'checkbox',
            input: true,
            key: 'checkbox',
        };
        const data = {
            checkbox: false,
        };
        const actual = (0, formUtil_1.isComponentDataEmpty)(component, data, 'checkbox');
        const expected = true;
        (0, chai_1.expect)(actual).to.equal(expected);
    });
    it('Should return false for a checkbox component set to true', () => {
        const component = {
            type: 'checkbox',
            input: true,
            key: 'checkbox',
        };
        const data = {
            checkbox: true,
        };
        const actual = (0, formUtil_1.isComponentDataEmpty)(component, data, 'checkbox');
        const expected = false;
        (0, chai_1.expect)(actual).to.equal(expected);
    });
    it('Should return true for an empty dataGrid component', () => {
        const component = {
            type: 'datagrid',
            input: true,
            key: 'dataGrid',
        };
        const data = {
            dataGrid: [],
        };
        const actual = (0, formUtil_1.isComponentDataEmpty)(component, data, 'dataGrid');
        const expected = true;
        (0, chai_1.expect)(actual).to.equal(expected);
    });
    it('Should return true for a non-empty dataGrid component with empty child components', () => {
        const component = {
            type: 'datagrid',
            input: true,
            key: 'dataGrid',
            components: [
                {
                    type: 'textfield',
                    input: true,
                    key: 'textField',
                },
                {
                    type: 'checkbox',
                    input: true,
                    key: 'checkbox'
                },
                {
                    type: 'textarea',
                    wysiwyg: true,
                    input: true,
                    key: 'textArea'
                }
            ],
        };
        const data = {
            dataGrid: [
                {
                    textField: '',
                    checkbox: false,
                    textArea: '<p>&nbsp;</p>',
                },
            ],
        };
        const actual = (0, formUtil_1.isComponentDataEmpty)(component, data, 'dataGrid');
        const expected = true;
        (0, chai_1.expect)(actual).to.equal(expected);
    });
    it('Should return false for a datagrid with non-empty child components', () => {
        const component = {
            type: 'datagrid',
            input: true,
            key: 'dataGrid',
            components: [
                {
                    type: 'textfield',
                    input: true,
                    key: 'textField',
                },
                {
                    type: 'checkbox',
                    input: true,
                    key: 'checkbox'
                },
                {
                    type: 'textarea',
                    wysiwyg: true,
                    input: true,
                    key: 'textArea'
                }
            ],
        };
        const data = {
            dataGrid: [
                {
                    textField: 'hello',
                    checkbox: true,
                    textArea: '<p>world</p>',
                },
            ],
        };
        const actual = (0, formUtil_1.isComponentDataEmpty)(component, data, 'dataGrid');
        const expected = false;
        (0, chai_1.expect)(actual).to.equal(expected);
    });
    it('Should return true for an empty Select Boxes component', () => {
        const component = {
            type: 'selectboxes',
            input: true,
            key: 'selectBoxes',
            data: {
                values: [
                    {
                        label: 'foo',
                        value: 'foo',
                    },
                    {
                        label: 'bar',
                        value: 'bar',
                    },
                ],
            },
        };
        const data = {
            selectBoxes: {},
        };
        const actual = (0, formUtil_1.isComponentDataEmpty)(component, data, 'selectBoxes');
        const expected = true;
        (0, chai_1.expect)(actual).to.equal(expected);
    });
    it('Should return true for a non-empty Select Boxes component with no selected values', () => {
        const component = {
            type: 'selectboxes',
            input: true,
            key: 'selectBoxes',
            data: {
                values: [
                    {
                        label: 'foo',
                        value: 'foo',
                    },
                    {
                        label: 'bar',
                        value: 'bar',
                    },
                ],
            },
        };
        const data = {
            selectBoxes: {
                foo: false,
                bar: false,
            },
        };
        const actual = (0, formUtil_1.isComponentDataEmpty)(component, data, 'selectBoxes');
        const expected = true;
        (0, chai_1.expect)(actual).to.equal(expected);
    });
    it('Should return false for a non-empty Select Boxes component with selected values', () => {
        const component = {
            type: 'selectboxes',
            input: true,
            key: 'selectBoxes',
            data: {
                values: [
                    {
                        label: 'foo',
                        value: 'foo',
                    },
                    {
                        label: 'bar',
                        value: 'bar',
                    },
                ],
            },
        };
        const data = {
            selectBoxes: {
                foo: true,
                bar: false,
            },
        };
        const actual = (0, formUtil_1.isComponentDataEmpty)(component, data, 'selectBoxes');
        const expected = false;
        (0, chai_1.expect)(actual).to.equal(expected);
    });
    it('Should return true for an empty Select component', () => {
        const component = {
            type: 'select',
            input: true,
            key: 'select',
            data: {
                values: [
                    {
                        label: 'foo',
                        value: 'foo',
                    },
                    {
                        label: 'bar',
                        value: 'bar',
                    },
                ],
            },
        };
        const data = {
            select: '',
        };
        const actual = (0, formUtil_1.isComponentDataEmpty)(component, data, 'select');
        const expected = true;
        (0, chai_1.expect)(actual).to.equal(expected);
    });
    it('Should return true for an empty plain Text Area component', () => {
        const component = {
            type: 'textarea',
            input: true,
            key: 'textArea',
        };
        const data = {
            textArea: '',
        };
        const actual = (0, formUtil_1.isComponentDataEmpty)(component, data, 'textArea');
        const expected = true;
        (0, chai_1.expect)(actual).to.equal(expected);
    });
    it('Should return true for a non-empty non-plain Text Area component with only WYSIWYG or editor HTML', () => {
        const component = {
            type: 'textarea',
            input: true,
            key: 'textArea',
            wysiwyg: true
        };
        const data = {
            textArea: '<p>&nbsp;</p>',
        };
        const actual = (0, formUtil_1.isComponentDataEmpty)(component, data, 'textArea');
        const expected = true;
        (0, chai_1.expect)(actual).to.equal(expected);
    });
    it('Should return true for a non-empty text area with only whitespace', () => {
        const component = {
            type: 'textarea',
            input: true,
            key: 'textArea',
        };
        const data = {
            textArea: '   ',
        };
        const actual = (0, formUtil_1.isComponentDataEmpty)(component, data, 'textArea');
        const expected = true;
        (0, chai_1.expect)(actual).to.equal(expected);
    });
    it('Should return false for a non-empty Text Field', () => {
        const component = {
            type: 'textfield',
            input: true,
            key: 'textField',
        };
        const data = {
            textField: 'hello',
        };
        const actual = (0, formUtil_1.isComponentDataEmpty)(component, data, 'textField');
        const expected = false;
        (0, chai_1.expect)(actual).to.equal(expected);
    });
    it('Should return true for an empty Text Field component', () => {
        const component = {
            type: 'textfield',
            input: true,
            key: 'textField',
        };
        const data = {
            textField: '',
        };
        const actual = (0, formUtil_1.isComponentDataEmpty)(component, data, 'textField');
        const expected = true;
        (0, chai_1.expect)(actual).to.equal(expected);
    });
    it('Should return true for a non-empty Text Field component with only whitespace', () => {
        const component = {
            type: 'textfield',
            input: true,
            key: 'textField',
        };
        const data = {
            textField: '   ',
        };
        const actual = (0, formUtil_1.isComponentDataEmpty)(component, data, 'textField');
        const expected = true;
        (0, chai_1.expect)(actual).to.equal(expected);
    });
});
describe('eachComponent', () => {
    it('Should iterate over each component given a flat components array', () => {
        const components = [
            {
                type: 'textfield',
                key: 'textField',
                input: true,
            },
            {
                type: 'textarea',
                key: 'textArea',
                input: true,
            }
        ];
        const rowResults = new Map();
        (0, formUtil_1.eachComponent)(components, (component, path) => {
            rowResults.set(path, component);
        });
        (0, chai_1.expect)(rowResults.size).to.equal(2);
        (0, chai_1.expect)(rowResults.get('textField')).to.deep.equal({
            type: 'textfield',
            key: 'textField',
            input: true,
        });
        (0, chai_1.expect)(rowResults.get('textArea')).to.deep.equal({
            type: 'textarea',
            key: 'textArea',
            input: true,
        });
    });
    it('Should iterate over each component with correct pathing given a container component', () => {
        const components = [
            {
                type: 'textfield',
                key: 'textField',
                input: true,
            },
            {
                type: 'container',
                key: 'container',
                input: true,
                components: [
                    {
                        type: 'textfield',
                        key: 'nestedTextField',
                        input: true,
                    },
                    {
                        type: 'textarea',
                        key: 'nestedTextArea',
                        input: true,
                    }
                ]
            }
        ];
        const rowResults = new Map();
        (0, formUtil_1.eachComponent)(components, (component, path) => {
            rowResults.set(path, component);
        }, true);
        (0, chai_1.expect)(rowResults.size).to.equal(4);
        (0, chai_1.expect)(rowResults.get('textField')).to.deep.equal({
            type: 'textfield',
            key: 'textField',
            input: true,
        });
        (0, chai_1.expect)(rowResults.get('container')).to.deep.equal({
            type: 'container',
            key: 'container',
            input: true,
            components: [
                {
                    type: 'textfield',
                    key: 'nestedTextField',
                    input: true,
                },
                {
                    type: 'textarea',
                    key: 'nestedTextArea',
                    input: true,
                }
            ]
        });
        (0, chai_1.expect)(rowResults.get('container.nestedTextField')).to.deep.equal({
            type: 'textfield',
            key: 'nestedTextField',
            input: true,
        });
        (0, chai_1.expect)(rowResults.get('container.nestedTextArea')).to.deep.equal({
            type: 'textarea',
            key: 'nestedTextArea',
            input: true,
        });
    });
    it('Should iterate over each component with correct pathing given a datagrid component', () => {
        const components = [
            {
                type: 'textfield',
                key: 'textField',
                input: true,
            },
            {
                type: 'datagrid',
                key: 'dataGrid',
                input: true,
                components: [
                    {
                        type: 'textfield',
                        key: 'nestedTextField',
                        input: true,
                    },
                    {
                        type: 'textarea',
                        key: 'nestedTextArea',
                        input: true,
                    }
                ]
            }
        ];
        const rowResults = new Map();
        (0, formUtil_1.eachComponent)(components, (component, path) => {
            rowResults.set(path, component);
        }, true);
        (0, chai_1.expect)(rowResults.size).to.equal(4);
        (0, chai_1.expect)(rowResults.get('textField')).to.deep.equal({
            type: 'textfield',
            key: 'textField',
            input: true,
        });
        (0, chai_1.expect)(rowResults.get('dataGrid')).to.deep.equal({
            type: 'datagrid',
            key: 'dataGrid',
            input: true,
            components: [
                {
                    type: 'textfield',
                    key: 'nestedTextField',
                    input: true,
                },
                {
                    type: 'textarea',
                    key: 'nestedTextArea',
                    input: true,
                }
            ]
        });
        (0, chai_1.expect)(rowResults.get('dataGrid[0].nestedTextField')).to.deep.equal({
            type: 'textfield',
            key: 'nestedTextField',
            input: true,
        });
        (0, chai_1.expect)(rowResults.get('dataGrid[0].nestedTextArea')).to.deep.equal({
            type: 'textarea',
            key: 'nestedTextArea',
            input: true,
        });
    });
    it('Should iterate over each component with correct pathing given a datagrid\'s child components', () => {
        const components = [
            {
                type: 'datagrid',
                key: 'dataGrid',
                input: true,
                components: [
                    {
                        type: 'textfield',
                        key: 'nestedTextField',
                        input: true,
                    },
                    {
                        type: 'textarea',
                        key: 'nestedTextArea',
                        input: true,
                    }
                ]
            }
        ];
        const rowResults = new Map();
        (0, formUtil_1.eachComponent)(components[0].components, (component, path) => {
            rowResults.set(path, component);
        }, true, 'dataGrid[0]');
        (0, chai_1.expect)(rowResults.size).to.equal(2);
        (0, chai_1.expect)(rowResults.get('dataGrid[0].nestedTextField')).to.deep.equal({
            type: 'textfield',
            key: 'nestedTextField',
            input: true,
        });
        (0, chai_1.expect)(rowResults.get('dataGrid[0].nestedTextArea')).to.deep.equal({
            type: 'textarea',
            key: 'nestedTextArea',
            input: true,
        });
    });
});
describe('eachComponentData', () => {
    it('Should iterate over each component and data given a flat components array', () => {
        const components = [
            {
                type: 'textfield',
                key: 'textField',
                label: 'Text Field',
                input: true,
            },
            {
                type: 'textarea',
                key: 'textArea',
                label: 'Text Area',
                input: true,
            }
        ];
        const data = {
            textField: 'hello',
            textArea: 'world',
        };
        const rowResults = new Map();
        (0, formUtil_1.eachComponentData)(components, data, (component, data, row, path) => {
            const value = (0, get_1.default)(data, path);
            rowResults.set(path, [component, value]);
        });
        (0, chai_1.expect)(rowResults.size).to.equal(2);
        (0, chai_1.expect)(rowResults.get('textField')).to.deep.equal([
            {
                type: 'textfield',
                key: 'textField',
                label: 'Text Field',
                input: true,
            },
            'hello'
        ]);
        (0, chai_1.expect)(rowResults.get('textArea')).to.deep.equal([
            {
                type: 'textarea',
                key: 'textArea',
                label: 'Text Area',
                input: true,
            },
            'world'
        ]);
    });
    it('Should iterate over each component and data given a container component and a nested components array', () => {
        const components = [
            {
                type: 'textfield',
                key: 'textField',
                label: 'Text Field',
                input: true,
            },
            {
                type: 'container',
                key: 'container',
                label: 'Container',
                input: true,
                components: [
                    {
                        type: 'textfield',
                        key: 'nestedTextField',
                        label: 'Nested Text Field',
                        input: true,
                    },
                    {
                        type: 'textarea',
                        key: 'nestedTextArea',
                        label: 'Nested Text Area',
                        input: true,
                    }
                ]
            }
        ];
        const data = {
            textField: 'hello',
            container: {
                nestedTextField: 'world',
                nestedTextArea: 'foo',
            },
        };
        const rowResults = new Map();
        (0, formUtil_1.eachComponentData)(components, data, (component, data, row, path) => {
            const value = (0, get_1.default)(data, path);
            rowResults.set(path, [component, value]);
        });
        (0, chai_1.expect)(rowResults.size).to.equal(4);
        (0, chai_1.expect)(rowResults.get('textField')).to.deep.equal([
            {
                type: 'textfield',
                key: 'textField',
                label: 'Text Field',
                input: true,
            },
            'hello'
        ]);
        (0, chai_1.expect)(rowResults.get('container')).to.deep.equal([
            {
                type: 'container',
                key: 'container',
                label: 'Container',
                input: true,
                components: [
                    {
                        type: 'textfield',
                        key: 'nestedTextField',
                        label: 'Nested Text Field',
                        input: true,
                    },
                    {
                        type: 'textarea',
                        key: 'nestedTextArea',
                        label: 'Nested Text Area',
                        input: true,
                    }
                ]
            },
            {
                nestedTextField: 'world',
                nestedTextArea: 'foo',
            }
        ]);
        (0, chai_1.expect)(rowResults.get('container.nestedTextField')).to.deep.equal([
            {
                type: 'textfield',
                key: 'nestedTextField',
                label: 'Nested Text Field',
                input: true,
            },
            'world'
        ]);
        (0, chai_1.expect)(rowResults.get('container.nestedTextArea')).to.deep.equal([
            {
                type: 'textarea',
                key: 'nestedTextArea',
                label: 'Nested Text Area',
                input: true,
            },
            'foo'
        ]);
    });
    it('Should iterate over each component and data given a datagrid component and a nested components array', () => {
        const components = [
            {
                type: 'textfield',
                key: 'textField',
                label: 'Text Field',
                input: true,
            },
            {
                type: 'datagrid',
                key: 'dataGrid',
                label: 'Data Grid',
                input: true,
                components: [
                    {
                        type: 'textfield',
                        key: 'nestedTextField',
                        label: 'Nested Text Field',
                        input: true,
                    },
                    {
                        type: 'textarea',
                        key: 'nestedTextArea',
                        label: 'Nested Text Area',
                        input: true,
                    }
                ]
            }
        ];
        const data = {
            textField: 'hello',
            dataGrid: [
                {
                    nestedTextField: 'world',
                    nestedTextArea: 'foo',
                },
                {
                    nestedTextField: 'bar',
                    nestedTextArea: 'baz',
                }
            ],
        };
        const rowResults = new Map();
        (0, formUtil_1.eachComponentData)(components, data, (component, data, row, path) => {
            const value = (0, get_1.default)(data, path);
            rowResults.set(path, [component, value]);
        });
        (0, chai_1.expect)(rowResults.size).to.equal(6);
        (0, chai_1.expect)(rowResults.get('textField')).to.deep.equal([
            {
                type: 'textfield',
                key: 'textField',
                label: 'Text Field',
                input: true,
            },
            'hello'
        ]);
        (0, chai_1.expect)(rowResults.get('dataGrid')).to.deep.equal([
            {
                type: 'datagrid',
                key: 'dataGrid',
                label: 'Data Grid',
                input: true,
                components: [
                    {
                        type: 'textfield',
                        key: 'nestedTextField',
                        label: 'Nested Text Field',
                        input: true,
                    },
                    {
                        type: 'textarea',
                        key: 'nestedTextArea',
                        label: 'Nested Text Area',
                        input: true,
                    }
                ]
            },
            [
                {
                    nestedTextField: 'world',
                    nestedTextArea: 'foo',
                },
                {
                    nestedTextField: 'bar',
                    nestedTextArea: 'baz',
                }
            ]
        ]);
        (0, chai_1.expect)(rowResults.get('dataGrid[0].nestedTextField')).to.deep.equal([
            {
                type: 'textfield',
                key: 'nestedTextField',
                label: 'Nested Text Field',
                input: true,
            },
            'world'
        ]);
    });
    it('Should iterate over a components array and include components that are not in the data object if the includeAll flag is set to true', () => {
        const components = [
            {
                type: 'textfield',
                key: 'textField',
                label: 'Text Field',
                input: true,
            },
            {
                type: 'textarea',
                key: 'textArea',
                label: 'Text Area',
                input: true,
            }
        ];
        const data = {
            textField: 'hello',
        };
        const rowResults = new Map();
        (0, formUtil_1.eachComponentData)(components, data, (component, data, row, path) => {
            const value = (0, get_1.default)(data, path);
            rowResults.set(path, [component, value]);
        }, undefined, undefined, undefined, true);
        (0, chai_1.expect)(rowResults.size).to.equal(2);
        (0, chai_1.expect)(rowResults.get('textField')).to.deep.equal([
            {
                type: 'textfield',
                key: 'textField',
                label: 'Text Field',
                input: true,
            },
            'hello'
        ]);
        (0, chai_1.expect)(rowResults.get('textArea')).to.deep.equal([
            {
                type: 'textarea',
                key: 'textArea',
                label: 'Text Area',
                input: true,
            },
            undefined
        ]);
    });
});
