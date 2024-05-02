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
const process_1 = require("../../process");
const index_1 = require("../index");
const processForm = (form, submission) => __awaiter(void 0, void 0, void 0, function* () {
    const context = {
        processors: [index_1.fetchProcessInfo],
        components: form.components,
        data: submission.data,
        scope: {}
    };
    yield (0, process_1.process)(context);
    return context;
});
describe('Fetch processor', () => {
    it('Perform a fetch operation.', () => __awaiter(void 0, void 0, void 0, function* () {
    }));
});
