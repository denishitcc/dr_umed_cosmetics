"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const chai_1 = require("chai");
const validateMultiple_1 = require("../validateMultiple");
const error_1 = require("../../../../error");
describe('validateMultiple', () => {
    describe('isEligible', () => {
        it('should return false for hidden component with multiple', () => {
            const component = {
                type: 'hidden',
                input: true,
                key: 'hidden',
            };
            (0, chai_1.expect)((0, validateMultiple_1.isEligible)(component)).to.be.false;
        });
        it('should return false for address component if not multiple', () => {
            const component = {
                type: 'address',
                input: true,
                key: 'address',
            };
            (0, chai_1.expect)((0, validateMultiple_1.isEligible)(component)).to.be.false;
        });
        it('should return true for address component if multiple', () => {
            const component = {
                type: 'address',
                input: true,
                key: 'address',
                multiple: true,
            };
            (0, chai_1.expect)((0, validateMultiple_1.isEligible)(component)).to.be.true;
        });
        it('should return false for textArea component with as !== json', () => {
            const component = {
                type: 'textArea',
                as: 'text',
                input: true,
                key: 'textArea',
                multiple: true,
                rows: 4,
                wysiwyg: true,
                editor: 'ckeditor',
                fixedSize: true,
                inputFormat: 'plain',
            };
            (0, chai_1.expect)((0, validateMultiple_1.isEligible)(component)).to.be.false;
        });
        it('should return true for textArea component with as === json', () => {
            const component = {
                type: 'textArea',
                as: 'json',
                input: true,
                key: 'textAreaJson',
                multiple: true,
                rows: 4,
                wysiwyg: true,
                editor: 'ckeditor',
                fixedSize: true,
                inputFormat: 'plain',
            };
            (0, chai_1.expect)((0, validateMultiple_1.isEligible)(component)).to.be.true;
        });
        it('should return true for other component types', () => {
            const component = {
                type: 'textfield',
                input: true,
                key: 'textfield',
                multiple: true,
            };
            (0, chai_1.expect)((0, validateMultiple_1.isEligible)(component)).to.be.true;
        });
    });
    describe('emptyValueIsArray', () => {
        it('should return true for datagrid component', () => {
            const component = {
                type: 'datagrid',
                input: true,
                key: 'datagrid',
            };
            (0, chai_1.expect)((0, validateMultiple_1.emptyValueIsArray)(component)).to.be.true;
        });
        it('should return true for editgrid component', () => {
            const component = {
                type: 'editgrid',
                input: true,
                key: 'editgrid',
            };
            (0, chai_1.expect)((0, validateMultiple_1.emptyValueIsArray)(component)).to.be.true;
        });
        it('should return true for tagpad component', () => {
            const component = {
                type: 'tagpad',
                input: true,
                key: 'tagpad',
            };
            (0, chai_1.expect)((0, validateMultiple_1.emptyValueIsArray)(component)).to.be.true;
        });
        it('should return true for sketchpad component', () => {
            const component = {
                type: 'sketchpad',
                input: true,
                key: 'sketchpad',
            };
            (0, chai_1.expect)((0, validateMultiple_1.emptyValueIsArray)(component)).to.be.true;
        });
        it('should return true for datatable component', () => {
            const component = {
                type: 'datatable',
                input: true,
                key: 'datatable',
            };
            (0, chai_1.expect)((0, validateMultiple_1.emptyValueIsArray)(component)).to.be.true;
        });
        it('should return true for dynamicWizard component', () => {
            const component = {
                type: 'dynamicWizard',
                input: true,
                key: 'dynamicWizard',
            };
            (0, chai_1.expect)((0, validateMultiple_1.emptyValueIsArray)(component)).to.be.true;
        });
        it('should return true for file component', () => {
            const component = {
                type: 'file',
                input: true,
                key: 'file',
            };
            (0, chai_1.expect)((0, validateMultiple_1.emptyValueIsArray)(component)).to.be.true;
        });
        it('should return false for select component without multiple', () => {
            const component = {
                type: 'select',
                input: true,
                key: 'select',
            };
            (0, chai_1.expect)((0, validateMultiple_1.emptyValueIsArray)(component)).to.be.false;
        });
        it('should return true for select component with multiple', () => {
            const component = {
                type: 'select',
                input: true,
                key: 'select',
                multiple: true,
            };
            (0, chai_1.expect)((0, validateMultiple_1.emptyValueIsArray)(component)).to.be.true;
        });
        it('should return true for tags component with storeas !== string', () => {
            const component = {
                type: 'tags',
                input: true,
                key: 'tags',
                storeas: 'array',
            };
            (0, chai_1.expect)((0, validateMultiple_1.emptyValueIsArray)(component)).to.be.true;
        });
        it('should return false for tags component with storeas === string', () => {
            const component = {
                type: 'tags',
                input: true,
                key: 'tags',
                storeas: 'string',
            };
            (0, chai_1.expect)((0, validateMultiple_1.emptyValueIsArray)(component)).to.be.false;
        });
        it('should return false for other component types', () => {
            const component = {
                type: 'textfield',
                input: true,
                key: 'textfield',
            };
            (0, chai_1.expect)((0, validateMultiple_1.emptyValueIsArray)(component)).to.be.false;
        });
    });
    describe('validateMultipleSync', () => {
        describe('values that should be arrays', () => {
            // TODO: skipping the following tests until we can resolve whether or not we want to validateMultiple on select components
            xit('should return an error for a select component with multiple that is not an array', () => {
                const component = {
                    type: 'select',
                    input: true,
                    key: 'select',
                    multiple: true,
                };
                const context = {
                    component,
                    data: {
                        select: 'foo',
                    },
                    value: 'foo',
                    row: {
                        select: 'foo'
                    },
                    scope: {
                        errors: []
                    },
                    path: component.key
                };
                (0, chai_1.expect)((0, validateMultiple_1.validateMultipleSync)(context)).to.be.instanceOf(error_1.FieldError);
            });
            xit('should return null for a select component with multiple that is an array', () => {
                const component = {
                    type: 'select',
                    input: true,
                    key: 'select',
                    multiple: true,
                };
                const context = {
                    component,
                    data: {
                        select: ['foo'],
                    },
                    value: ['foo'],
                    row: {
                        select: 'foo'
                    },
                    scope: {
                        errors: []
                    },
                    path: component.key
                };
                (0, chai_1.expect)((0, validateMultiple_1.validateMultipleSync)(context)).to.be.null;
            });
            xit('should return an error for a select component without multiple that is an array', () => {
                const component = {
                    type: 'select',
                    input: true,
                    key: 'select',
                };
                const context = {
                    component,
                    data: {
                        select: ['foo'],
                    },
                    value: ['foo'],
                    row: {
                        select: ['foo']
                    },
                    scope: {
                        errors: []
                    },
                    path: component.key
                };
                (0, chai_1.expect)((0, validateMultiple_1.validateMultipleSync)(context)).to.be.instanceOf(error_1.FieldError);
            });
            xit('should return null for a select component without multiple that is not an array', () => {
                const component = {
                    type: 'select',
                    input: true,
                    key: 'select',
                };
                const context = {
                    component,
                    data: {
                        select: 'foo',
                    },
                    value: 'foo',
                    row: {
                        select: 'foo'
                    },
                    scope: {
                        errors: []
                    },
                    path: component.key
                };
                (0, chai_1.expect)((0, validateMultiple_1.validateMultipleSync)(context)).to.be.null;
            });
            it('should not validate a select component with multiple', () => {
                const component = {
                    type: 'select',
                    input: true,
                    key: 'select',
                    multiple: true,
                };
                const context = {
                    component,
                    data: {
                        select: ['foo', 'bar'],
                    },
                    value: ['foo', 'bar'],
                    row: {
                        select: ['foo', 'bar'],
                    },
                    scope: {
                        errors: []
                    },
                    path: component.key
                };
                (0, chai_1.expect)((0, validateMultiple_1.validateMultipleSync)(context)).to.be.null;
            });
            it('should return null for a sketchpad component', () => {
                const component = {
                    type: 'sketchpad',
                    input: true,
                    key: 'sketchpad',
                };
                const context = {
                    component,
                    data: {
                        sketchpad: ['foo'],
                    },
                    value: ['foo'],
                    row: {
                        sketchpad: ['foo']
                    },
                    scope: {
                        errors: []
                    },
                    path: component.key
                };
                (0, chai_1.expect)((0, validateMultiple_1.validateMultipleSync)(context)).to.be.null;
            });
            it('should return null for a tagpad component', () => {
                const component = {
                    type: 'sketchpad',
                    input: true,
                    key: 'tagpad',
                };
                const context = {
                    component,
                    data: {
                        tagpad: ['foo'],
                    },
                    value: ['foo'],
                    row: {
                        tagpad: ['foo']
                    },
                    scope: {
                        errors: []
                    },
                    path: component.key
                };
                (0, chai_1.expect)((0, validateMultiple_1.validateMultipleSync)(context)).to.be.null;
            });
            it('should return null for a data table component', () => {
                const component = {
                    type: 'datatable',
                    input: true,
                    key: 'datatable',
                };
                const context = {
                    component,
                    data: {
                        [component.key]: ['foo'],
                    },
                    value: ['foo'],
                    row: {
                        [component.key]: ['foo']
                    },
                    scope: {
                        errors: []
                    },
                    path: component.key
                };
                (0, chai_1.expect)((0, validateMultiple_1.validateMultipleSync)(context)).to.be.null;
            });
            it('should return null for a dynamic wizard component', () => {
                const component = {
                    type: 'dynamicWizard',
                    input: true,
                    key: 'dynamicwizard',
                };
                const context = {
                    component,
                    data: {
                        [component.key]: ['foo'],
                    },
                    value: ['foo'],
                    row: {
                        [component.key]: ['foo']
                    },
                    scope: {
                        errors: []
                    },
                    path: component.key
                };
                (0, chai_1.expect)((0, validateMultiple_1.validateMultipleSync)(context)).to.be.null;
            });
        });
        describe('values that should not be arrays', () => {
            it('should return an error for a textfield component without multiple that is an array', () => {
                const component = {
                    type: 'textfield',
                    input: true,
                    key: 'textfield',
                };
                const context = {
                    component,
                    data: {
                        textfield: ['foo'],
                    },
                    value: ['foo'],
                    row: {
                        textfield: ['foo']
                    },
                    scope: {
                        errors: []
                    },
                    path: component.key
                };
                (0, chai_1.expect)((0, validateMultiple_1.validateMultipleSync)(context)).to.be.instanceOf(error_1.FieldError);
            });
        });
    });
});
