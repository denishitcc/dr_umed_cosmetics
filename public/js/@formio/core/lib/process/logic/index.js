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
exports.logicProcessInfo = exports.logicProcess = exports.logicProcessSync = void 0;
const logic_1 = require("../../utils/logic");
// This processor ensures that a "linked" row context is provided to every component.
const logicProcessSync = (context) => {
    return (0, logic_1.applyActions)(context);
};
exports.logicProcessSync = logicProcessSync;
const logicProcess = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.logicProcessSync)(context);
});
exports.logicProcess = logicProcess;
exports.logicProcessInfo = {
    name: 'logic',
    process: exports.logicProcess,
    processSync: exports.logicProcessSync,
    shouldProcess: logic_1.hasLogic
};
