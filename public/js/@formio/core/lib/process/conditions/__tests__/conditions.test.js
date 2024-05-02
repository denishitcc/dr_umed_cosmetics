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
const processForm = (form, submission) => {
    const context = {
        processors: [index_1.conditionProcessInfo],
        components: form.components,
        data: submission.data,
        scope: {}
    };
    (0, process_1.processSync)(context);
    return context;
};
describe('Condition processor', () => {
    it('Should modify component\'s "hidden" property when conditionally visible is false', () => __awaiter(void 0, void 0, void 0, function* () {
        const form = {
            components: [
                {
                    type: 'textfield',
                    key: 'a',
                    input: true
                },
                {
                    type: 'textfield',
                    key: 'b',
                    input: true,
                    conditional: {
                        show: false,
                        conjunction: 'all',
                        conditions: [
                            {
                                component: 'a',
                                operator: 'isEmpty'
                            }
                        ]
                    },
                }
            ]
        };
        const submission = {
            data: {
                a: '',
            }
        };
        const context = processForm(form, submission);
        (0, chai_1.expect)(context.components[1]).to.haveOwnProperty('hidden');
        (0, chai_1.expect)(context.components[1].hidden).to.be.true;
    }));
});
