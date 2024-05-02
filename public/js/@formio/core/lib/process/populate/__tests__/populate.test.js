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
const process_1 = require("../../process");
const index_1 = require("../index");
const processForm = (form, submission) => __awaiter(void 0, void 0, void 0, function* () {
    const context = {
        processors: [index_1.populateProcessInfo],
        components: form.components,
        data: submission.data,
        scope: { data: submission.data }
    };
    yield (0, process_1.processSync)(context);
    return context;
});
describe('Populate processor', () => {
    it('Should Populate a Data Grid with some Text fields', () => __awaiter(void 0, void 0, void 0, function* () {
        const form = {
            components: [
                {
                    type: 'datagrid',
                    key: 'grid',
                    components: [
                        {
                            type: 'textfield',
                            key: 'a'
                        },
                        {
                            type: 'textfield',
                            key: 'b'
                        },
                        {
                            type: 'textfield',
                            key: 'c'
                        }
                    ]
                }
            ]
        };
        const submission = { data: {} };
        const context = yield processForm(form, submission);
        (0, chai_1.expect)(context.data).to.deep.equal({
            grid: [
                {}
            ]
        });
        context.scope.row.a = 'foo';
        context.scope.row.b = 'bar';
        context.scope.row.c = 'baz';
        (0, chai_1.expect)(context.data).to.deep.equal({
            grid: [
                {
                    a: 'foo',
                    b: 'bar',
                    c: 'baz'
                }
            ]
        });
    }));
});
