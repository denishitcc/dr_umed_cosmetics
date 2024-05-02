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
        processors: [index_1.calculateProcessInfo],
        components: form.components,
        data: submission.data,
        scope: {}
    };
    yield (0, process_1.process)(context);
    return context;
});
describe('Calculation processor', () => {
    it('Calculation processor will perform a simple calculation', () => __awaiter(void 0, void 0, void 0, function* () {
        const form = {
            components: [
                {
                    type: 'number',
                    key: 'a',
                    input: true
                },
                {
                    type: 'number',
                    key: 'b',
                    input: true
                },
                {
                    type: 'number',
                    key: 'c',
                    input: true,
                    calculateValue: 'value = data.a + data.b'
                }
            ]
        };
        const submission = {
            data: {
                a: 1,
                b: 2
            }
        };
        const context = yield processForm(form, submission);
        (0, chai_1.expect)(context.data.c).to.equal(3);
    }));
    it('Calculation processor will perform a simple calculation that overwrites the value prop', () => __awaiter(void 0, void 0, void 0, function* () {
        const form = {
            components: [
                {
                    type: 'number',
                    key: 'a',
                    input: true
                },
                {
                    type: 'number',
                    key: 'b',
                    input: true
                },
                {
                    type: 'number',
                    key: 'c',
                    input: true,
                    calculateValue: 'value = value + data.a + data.b'
                }
            ]
        };
        const submission = {
            data: {
                a: 1,
                b: 2,
                c: 3,
            }
        };
        const context = yield processForm(form, submission);
        (0, chai_1.expect)(context.data.c).to.equal(6);
    }));
});
