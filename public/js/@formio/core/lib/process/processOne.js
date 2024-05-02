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
exports.processOneSync = exports.processOne = exports.dataValue = void 0;
const lodash_1 = require("lodash");
const types_1 = require("../types");
const formUtil_1 = require("../utils/formUtil");
function dataValue(component, row) {
    const key = (0, formUtil_1.getComponentKey)(component);
    return key ? (0, lodash_1.get)(row, key) : undefined;
}
exports.dataValue = dataValue;
function processOne(context) {
    return __awaiter(this, void 0, void 0, function* () {
        const { processors } = context;
        // Create a getter for `value` that is always derived from the current data object
        if (typeof context.value === 'undefined') {
            Object.defineProperty(context, 'value', {
                enumerable: true,
                get() {
                    return (0, lodash_1.get)(context.data, context.path);
                },
                set(newValue) {
                    (0, lodash_1.set)(context.data, context.path, newValue);
                }
            });
        }
        if (!context.row) {
            return;
        }
        context.processor = types_1.ProcessorType.Custom;
        for (const processor of processors) {
            if (processor === null || processor === void 0 ? void 0 : processor.process) {
                yield processor.process(context);
            }
        }
    });
}
exports.processOne = processOne;
function processOneSync(context) {
    const { processors, component } = context;
    // Create a getter for `value` that is always derived from the current data object
    if (typeof context.value === 'undefined') {
        Object.defineProperty(context, 'value', {
            enumerable: true,
            get() {
                return (0, lodash_1.get)(context.data, context.path);
            },
            set(newValue) {
                (0, lodash_1.set)(context.data, context.path, newValue);
            }
        });
    }
    if (!context.row) {
        return;
    }
    context.processor = types_1.ProcessorType.Custom;
    for (const processor of processors) {
        if (processor === null || processor === void 0 ? void 0 : processor.processSync) {
            processor.processSync(context);
        }
    }
}
exports.processOneSync = processOneSync;
