"use strict";
var __createBinding = (this && this.__createBinding) || (Object.create ? (function(o, m, k, k2) {
    if (k2 === undefined) k2 = k;
    var desc = Object.getOwnPropertyDescriptor(m, k);
    if (!desc || ("get" in desc ? !m.__esModule : desc.writable || desc.configurable)) {
      desc = { enumerable: true, get: function() { return m[k]; } };
    }
    Object.defineProperty(o, k2, desc);
}) : (function(o, m, k, k2) {
    if (k2 === undefined) k2 = k;
    o[k2] = m[k];
}));
var __exportStar = (this && this.__exportStar) || function(m, exports) {
    for (var p in m) if (p !== "default" && !Object.prototype.hasOwnProperty.call(exports, p)) __createBinding(exports, m, p);
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.processes = void 0;
const processes_1 = require("../../process");
__exportStar(require("./ProcessType"), exports);
__exportStar(require("./ProcessorType"), exports);
__exportStar(require("./ProcessorContext"), exports);
__exportStar(require("./ProcessorFn"), exports);
__exportStar(require("./ProcessContext"), exports);
__exportStar(require("./ProcessorContext"), exports);
__exportStar(require("./ProcessorScope"), exports);
__exportStar(require("./ProcessorsScope"), exports);
__exportStar(require("./ProcessConfig"), exports);
__exportStar(require("./ProcessorInfo"), exports);
__exportStar(require("./validation"), exports);
__exportStar(require("./calculation"), exports);
__exportStar(require("./conditions"), exports);
__exportStar(require("./defaultValue"), exports);
__exportStar(require("./fetch"), exports);
__exportStar(require("./filter"), exports);
__exportStar(require("./populate"), exports);
__exportStar(require("./logic"), exports);
exports.processes = {
    calculation: processes_1.calculateProcessInfo,
    conditions: processes_1.conditionProcessInfo,
    defaultValue: processes_1.defaultValueProcessInfo,
    fetch: processes_1.fetchProcessInfo,
    filter: processes_1.filterProcessInfo,
    logic: processes_1.logicProcessInfo,
    populate: processes_1.populateProcessInfo,
    validation: processes_1.validateProcessInfo
};
