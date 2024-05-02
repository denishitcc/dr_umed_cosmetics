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
exports.ProcessTargets = exports.ProcessorMap = exports.processSync = exports.process = void 0;
const formUtil_1 = require("../utils/formUtil");
const processOne_1 = require("./processOne");
const defaultValue_1 = require("./defaultValue");
const fetch_1 = require("./fetch");
const calculation_1 = require("./calculation");
const logic_1 = require("./logic");
const conditions_1 = require("./conditions");
const validation_1 = require("./validation");
const filter_1 = require("./filter");
const normalize_1 = require("./normalize");
const dereference_1 = require("./dereference");
const clearHidden_1 = require("./clearHidden");
function process(context) {
    return __awaiter(this, void 0, void 0, function* () {
        const { instances, components, data, scope, flat, processors } = context;
        yield (0, formUtil_1.eachComponentDataAsync)(components, data, (component, compData, row, path, components, index) => __awaiter(this, void 0, void 0, function* () {
            // Skip processing if row is null or undefined
            if (!row) {
                return;
            }
            yield (0, processOne_1.processOne)(Object.assign(Object.assign({}, context), {
                data: compData,
                component,
                components,
                path,
                row,
                index,
                instance: instances ? instances[path] : undefined
            }));
            if (flat) {
                return true;
            }
            if (scope.noRecurse) {
                scope.noRecurse = false;
                return true;
            }
        }));
        for (let i = 0; i < (processors === null || processors === void 0 ? void 0 : processors.length); i++) {
            const processor = processors[i];
            if (processor.postProcess) {
                processor.postProcess(context);
            }
        }
        return scope;
    });
}
exports.process = process;
function processSync(context) {
    const { instances, components, data, scope, flat, processors } = context;
    (0, formUtil_1.eachComponentData)(components, data, (component, compData, row, path, components, index) => {
        // Skip processing if row is null or undefined
        if (!row) {
            return;
        }
        (0, processOne_1.processOneSync)(Object.assign(Object.assign({}, context), { data: compData, component,
            components,
            path,
            row,
            index, instance: instances ? instances[path] : undefined }));
        if (flat) {
            return true;
        }
        if (scope.noRecurse) {
            scope.noRecurse = false;
            return true;
        }
    });
    for (let i = 0; i < (processors === null || processors === void 0 ? void 0 : processors.length); i++) {
        const processor = processors[i];
        if (processor.postProcess) {
            processor.postProcess(context);
        }
    }
    return scope;
}
exports.processSync = processSync;
exports.ProcessorMap = {
    filter: filter_1.filterProcessInfo,
    defaultValue: defaultValue_1.defaultValueProcessInfo,
    serverDefaultValue: defaultValue_1.serverDefaultValueProcessInfo,
    customDefaultValue: defaultValue_1.customDefaultValueProcessInfo,
    calculate: calculation_1.calculateProcessInfo,
    conditions: conditions_1.conditionProcessInfo,
    customConditions: conditions_1.customConditionProcessInfo,
    simpleConditions: conditions_1.simpleConditionProcessInfo,
    normalize: normalize_1.normalizeProcessInfo,
    dereference: dereference_1.dereferenceProcessInfo,
    clearHidden: clearHidden_1.clearHiddenProcessInfo,
    fetch: fetch_1.fetchProcessInfo,
    logic: logic_1.logicProcessInfo,
    validate: validation_1.validateProcessInfo,
    validateCustom: validation_1.validateCustomProcessInfo,
    validateServer: validation_1.validateServerProcessInfo
};
exports.ProcessTargets = {
    submission: [
        filter_1.filterProcessInfo,
        defaultValue_1.serverDefaultValueProcessInfo,
        normalize_1.normalizeProcessInfo,
        dereference_1.dereferenceProcessInfo,
        fetch_1.fetchProcessInfo,
        conditions_1.simpleConditionProcessInfo,
        validation_1.validateServerProcessInfo
    ],
    evaluator: [
        defaultValue_1.customDefaultValueProcessInfo,
        calculation_1.calculateProcessInfo,
        logic_1.logicProcessInfo,
        conditions_1.conditionProcessInfo,
        clearHidden_1.clearHiddenProcessInfo,
        validation_1.validateProcessInfo
    ]
};
