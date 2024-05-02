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
const __1 = require("../");
const util_1 = require("../../__tests__/fixtures/util");
it('Should not filter empty array value for dataGrid component', () => __awaiter(void 0, void 0, void 0, function* () {
    const dataGridComp = {
        type: 'datagrid',
        key: 'dataGrid',
        input: true,
        path: 'dataGrid',
        components: [
            {
                type: 'textfield',
                key: 'textField',
                input: true,
                label: 'Text Field'
            }
        ]
    };
    const data = {
        dataGrid: []
    };
    const context = (0, util_1.generateProcessorContext)(dataGridComp, data);
    (0, __1.filterProcessSync)(context);
    (0, chai_1.expect)(context.scope.filter).to.deep.equal({ 'dataGrid': { 'compModelType': 'array', 'include': true } });
}));
it('Should not filter empty array value for editGrid component', () => __awaiter(void 0, void 0, void 0, function* () {
    const editGridComp = {
        type: 'editgrid',
        key: 'editGrid',
        input: true,
        path: 'editGrid',
        components: [
            {
                type: 'textfield',
                key: 'textField',
                input: true,
                label: 'Text Field'
            }
        ]
    };
    const data = {
        editGrid: []
    };
    const context = (0, util_1.generateProcessorContext)(editGridComp, data);
    (0, __1.filterProcessSync)(context);
    (0, chai_1.expect)(context.scope.filter).to.deep.equal({ 'editGrid': { 'compModelType': 'array', 'include': true } });
}));
it('Should not filter empty array value for datTable component', () => __awaiter(void 0, void 0, void 0, function* () {
    const dataTableComp = {
        type: 'datatable',
        key: 'dataTable',
        input: true,
        path: 'dataTable',
        components: [
            {
                type: 'textfield',
                key: 'textField',
                input: true,
                label: 'Text Field'
            }
        ]
    };
    const data = {
        dataTable: []
    };
    const context = (0, util_1.generateProcessorContext)(dataTableComp, data);
    (0, __1.filterProcessSync)(context);
    (0, chai_1.expect)(context.scope.filter).to.deep.equal({ 'dataTable': { 'compModelType': 'array', 'include': true } });
}));
