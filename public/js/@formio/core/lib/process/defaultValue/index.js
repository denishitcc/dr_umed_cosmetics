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
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.defaultValueProcessInfo = exports.serverDefaultValueProcessInfo = exports.customDefaultValueProcessInfo = exports.defaultValueProcessSync = exports.defaultValueProcess = exports.serverDefaultValueProcessSync = exports.serverDefaultValueProcess = exports.customDefaultValueProcessSync = exports.customDefaultValueProcess = exports.hasDefaultValue = exports.hasServerDefaultValue = exports.hasCustomDefaultValue = void 0;
const jsonlogic_1 = __importDefault(require("../../modules/jsonlogic"));
const has_1 = __importDefault(require("lodash/has"));
const set_1 = __importDefault(require("lodash/set"));
const formUtil_1 = require("../../utils/formUtil");
const Evaluator = jsonlogic_1.default.evaluator;
const hasCustomDefaultValue = (context) => {
    const { component } = context;
    if (!component.customDefaultValue) {
        return false;
    }
    return true;
};
exports.hasCustomDefaultValue = hasCustomDefaultValue;
const hasServerDefaultValue = (context) => {
    const { component } = context;
    if (!component.hasOwnProperty('defaultValue')) {
        return false;
    }
    return true;
};
exports.hasServerDefaultValue = hasServerDefaultValue;
const hasDefaultValue = (context) => {
    return (0, exports.hasCustomDefaultValue)(context) || (0, exports.hasServerDefaultValue)(context);
};
exports.hasDefaultValue = hasDefaultValue;
const customDefaultValueProcess = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.customDefaultValueProcessSync)(context);
});
exports.customDefaultValueProcess = customDefaultValueProcess;
const customDefaultValueProcessSync = (context) => {
    const { component, row, data, scope, evalContext, path } = context;
    if (!(0, exports.hasCustomDefaultValue)(context)) {
        return;
    }
    if (!scope.defaultValues)
        scope.defaultValues = [];
    if ((0, has_1.default)(row, (0, formUtil_1.getComponentKey)(component))) {
        return;
    }
    let defaultValue = null;
    if (component.customDefaultValue) {
        const evalContextValue = evalContext ? evalContext(context) : context;
        evalContextValue.value = null;
        defaultValue = Evaluator.evaluate(component.customDefaultValue, evalContextValue, 'value');
        if (component.multiple && !Array.isArray(defaultValue)) {
            defaultValue = defaultValue ? [defaultValue] : [];
        }
        scope.defaultValues.push({
            path,
            value: defaultValue
        });
    }
    if (defaultValue !== null && defaultValue !== undefined) {
        (0, set_1.default)(data, path, defaultValue);
    }
};
exports.customDefaultValueProcessSync = customDefaultValueProcessSync;
const serverDefaultValueProcess = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.serverDefaultValueProcessSync)(context);
});
exports.serverDefaultValueProcess = serverDefaultValueProcess;
const serverDefaultValueProcessSync = (context) => {
    const { component, row, data, scope, path } = context;
    if (!(0, exports.hasServerDefaultValue)(context)) {
        return;
    }
    if (!scope.defaultValues)
        scope.defaultValues = [];
    if ((0, has_1.default)(row, (0, formUtil_1.getComponentKey)(component))) {
        return;
    }
    let defaultValue = null;
    if (component.defaultValue !== undefined &&
        component.defaultValue !== null) {
        defaultValue = component.defaultValue;
        if (component.multiple && !Array.isArray(defaultValue)) {
            defaultValue = defaultValue ? [defaultValue] : [];
        }
        scope.defaultValues.push({
            path,
            value: defaultValue
        });
    }
    if (defaultValue !== null && defaultValue !== undefined) {
        (0, set_1.default)(data, path, defaultValue);
    }
};
exports.serverDefaultValueProcessSync = serverDefaultValueProcessSync;
const defaultValueProcess = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.defaultValueProcessSync)(context);
});
exports.defaultValueProcess = defaultValueProcess;
const defaultValueProcessSync = (context) => {
    (0, exports.customDefaultValueProcessSync)(context);
    (0, exports.serverDefaultValueProcessSync)(context);
};
exports.defaultValueProcessSync = defaultValueProcessSync;
exports.customDefaultValueProcessInfo = {
    name: 'customDefaultValue',
    process: exports.customDefaultValueProcess,
    processSync: exports.customDefaultValueProcessSync,
    shouldProcess: exports.hasCustomDefaultValue,
};
exports.serverDefaultValueProcessInfo = {
    name: 'serverDefaultValue',
    process: exports.serverDefaultValueProcess,
    processSync: exports.serverDefaultValueProcessSync,
    shouldProcess: exports.hasServerDefaultValue,
};
exports.defaultValueProcessInfo = {
    name: 'defaultValue',
    process: exports.defaultValueProcess,
    processSync: exports.defaultValueProcessSync,
    shouldProcess: exports.hasDefaultValue,
};
