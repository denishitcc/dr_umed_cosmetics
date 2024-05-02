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
exports.validateProcessInfo = exports.validateServerProcessInfo = exports.validateCustomProcessInfo = exports.validateAllProcessSync = exports.validateAllProcess = exports.validateServerProcessSync = exports.validateServerProcess = exports.validateCustomProcessSync = exports.validateCustomProcess = exports.validateProcessSync = exports.validateProcess = exports.shouldValidateServer = exports.shouldValidateCustom = exports.shouldValidateAll = exports.shouldSkipValidation = exports.shouldSkipValidationSimple = exports.shouldSkipValidationCustom = exports._shouldSkipValidation = exports.isForcedHidden = exports.isValueHidden = exports.isInputComponent = exports.validationRules = void 0;
const rules_1 = require("./rules");
const find_1 = __importDefault(require("lodash/find"));
const get_1 = __importDefault(require("lodash/get"));
const pick_1 = __importDefault(require("lodash/pick"));
const formUtil_1 = require("../../utils/formUtil");
const error_1 = require("../../utils/error");
const conditions_1 = require("../conditions");
// Cleans up validation errors to remove unnessesary parts
// and make them transferable to ivm.
const cleanupValidationError = (error) => (Object.assign(Object.assign({}, error), { context: (0, pick_1.default)(error.context, [
        'component',
        'path',
        'index',
        'value',
        'field',
        'hasLabel',
        'processor',
        'setting',
        'pattern',
        'length',
        'min',
        'max',
        'maxDate',
        'minDate',
        'maxYear',
        'minYear',
        'minCount',
        'maxCount',
        'regex'
    ]) }));
function validationRules(context, rules, skipValidation) {
    if (skipValidation && skipValidation(context)) {
        return [];
    }
    const validationRules = [];
    return rules.reduce((acc, rule) => {
        if (rule.shouldProcess && rule.shouldProcess(context)) {
            acc.push(rule);
        }
        return acc;
    }, validationRules);
}
exports.validationRules = validationRules;
function isInputComponent(context) {
    const { component } = context;
    return !component.hasOwnProperty('input') || component.input;
}
exports.isInputComponent = isInputComponent;
function isValueHidden(context) {
    const { component, config } = context;
    if (component.protected) {
        return false;
    }
    if ((component.hasOwnProperty('persistent') && !component.persistent) ||
        (component.persistent === 'client-only')) {
        return true;
    }
    return false;
}
exports.isValueHidden = isValueHidden;
function isForcedHidden(context, isConditionallyHidden) {
    const { component } = context;
    if (isConditionallyHidden(context)) {
        return true;
    }
    if (component.hasOwnProperty('hidden')) {
        return !!component.hidden;
    }
    return false;
}
exports.isForcedHidden = isForcedHidden;
const _shouldSkipValidation = (context, isConditionallyHidden) => {
    const { component, scope, path } = context;
    if ((scope === null || scope === void 0 ? void 0 : scope.conditionals) &&
        (0, find_1.default)(scope.conditionals, {
            path: (0, formUtil_1.getComponentPath)(component, path),
            conditionallyHidden: true
        })) {
        return true;
    }
    const { validateWhenHidden = false } = component || {};
    const rules = [
        // Skip validation if component is readOnly
        // () => this.options.readOnly,
        // Do not check validations if component is not an input component.
        () => !isInputComponent(context),
        // Check to see if we are editing and if so, check component persistence.
        () => isValueHidden(context),
        // Force valid if component is hidden.
        () => isForcedHidden(context, isConditionallyHidden) && !validateWhenHidden,
    ];
    return rules.some(pred => pred());
};
exports._shouldSkipValidation = _shouldSkipValidation;
const shouldSkipValidationCustom = (context) => {
    return (0, exports._shouldSkipValidation)(context, conditions_1.isCustomConditionallyHidden);
};
exports.shouldSkipValidationCustom = shouldSkipValidationCustom;
const shouldSkipValidationSimple = (context) => {
    return (0, exports._shouldSkipValidation)(context, conditions_1.isSimpleConditionallyHidden);
};
exports.shouldSkipValidationSimple = shouldSkipValidationSimple;
const shouldSkipValidation = (context) => {
    return (0, exports._shouldSkipValidation)(context, conditions_1.isConditionallyHidden);
};
exports.shouldSkipValidation = shouldSkipValidation;
function shouldValidateAll(context) {
    return validationRules(context, rules_1.rules, exports.shouldSkipValidation).length > 0;
}
exports.shouldValidateAll = shouldValidateAll;
function shouldValidateCustom(context) {
    const { component } = context;
    if (component.customConditional) {
        return true;
    }
    return !(0, exports.shouldSkipValidationCustom)(context);
}
exports.shouldValidateCustom = shouldValidateCustom;
function shouldValidateServer(context) {
    const { component } = context;
    if (component.customConditional) {
        return false;
    }
    if ((0, exports.shouldSkipValidationSimple)(context)) {
        return false;
    }
    return shouldValidateAll(context);
}
exports.shouldValidateServer = shouldValidateServer;
function handleError(error, context) {
    const { scope, component } = context;
    const absolutePath = (0, formUtil_1.getComponentAbsolutePath)(component);
    if (error) {
        const cleanedError = cleanupValidationError(error);
        cleanedError.context.path = absolutePath;
        if (!(0, find_1.default)(scope.errors, { errorKeyOrMessage: cleanedError.errorKeyOrMessage, context: {
                path: absolutePath
            } })) {
            if (!scope.validated)
                scope.validated = [];
            if (!scope.errors)
                scope.errors = [];
            scope.errors.push(cleanedError);
            scope.validated.push({ path: absolutePath, error: cleanedError });
        }
    }
}
const validateProcess = (context) => __awaiter(void 0, void 0, void 0, function* () {
    const { component, data, row, path, instance, scope, rules, skipValidation } = context;
    let { value } = context;
    if (!scope.validated)
        scope.validated = [];
    if (!scope.errors)
        scope.errors = [];
    if (!rules || !rules.length) {
        return;
    }
    if (component.multiple && Array.isArray(value) && value.length > 0) {
        const fullValueRules = rules.filter(rule => rule.fullValue);
        const otherRules = rules.filter(rule => !rule.fullValue);
        for (let i = 0; i < value.length; i++) {
            const amendedPath = `${path}[${i}]`;
            let amendedValue = (0, get_1.default)(data, amendedPath);
            if (instance === null || instance === void 0 ? void 0 : instance.shouldSkipValidation(data)) {
                return;
            }
            const rulesToExecute = validationRules(context, otherRules, skipValidation);
            if (!rulesToExecute.length) {
                continue;
            }
            if (component.truncateMultipleSpaces && amendedValue && typeof amendedValue === 'string') {
                amendedValue = amendedValue.trim().replace(/\s{2,}/g, ' ');
            }
            for (const rule of rulesToExecute) {
                if (rule && rule.process) {
                    handleError(yield rule.process(Object.assign(Object.assign({}, context), { value: amendedValue, index: i, path: amendedPath })), context);
                }
            }
        }
        for (const rule of fullValueRules) {
            if (rule && rule.process) {
                handleError(yield rule.process(Object.assign(Object.assign({}, context), { value })), context);
            }
        }
        return;
    }
    if (instance === null || instance === void 0 ? void 0 : instance.shouldSkipValidation(data, row)) {
        return;
    }
    const rulesToExecute = validationRules(context, rules, skipValidation);
    if (!rulesToExecute.length) {
        return;
    }
    if (component.truncateMultipleSpaces && value && typeof value === 'string') {
        value = value.trim().replace(/\s{2,}/g, ' ');
    }
    for (const rule of rulesToExecute) {
        try {
            if (rule && rule.process) {
                handleError(yield rule.process(Object.assign(Object.assign({}, context), { value })), context);
            }
        }
        catch (err) {
            console.error("Validator error:", (0, error_1.getErrorMessage)(err));
        }
    }
    return;
});
exports.validateProcess = validateProcess;
const validateProcessSync = (context) => {
    const { component, data, row, path, instance, scope, rules, skipValidation } = context;
    let { value } = context;
    if (!scope.validated)
        scope.validated = [];
    if (!scope.errors)
        scope.errors = [];
    if (!rules || !rules.length) {
        return;
    }
    if (component.multiple && Array.isArray(value) && value.length > 0) {
        const fullValueRules = rules.filter(rule => rule.fullValue);
        const otherRules = rules.filter(rule => !rule.fullValue);
        for (let i = 0; i < value.length; i++) {
            const amendedPath = `${path}[${i}]`;
            let amendedValue = (0, get_1.default)(data, amendedPath);
            if (instance === null || instance === void 0 ? void 0 : instance.shouldSkipValidation(data)) {
                return;
            }
            const rulesToExecute = validationRules(context, otherRules, skipValidation);
            if (!rulesToExecute.length) {
                continue;
            }
            if (component.truncateMultipleSpaces && amendedValue && typeof amendedValue === 'string') {
                amendedValue = amendedValue.trim().replace(/\s{2,}/g, ' ');
            }
            for (const rule of rulesToExecute) {
                if (rule && rule.processSync) {
                    handleError(rule.processSync(Object.assign(Object.assign({}, context), { value: amendedValue, index: i, path: amendedPath })), context);
                }
            }
        }
        for (const rule of fullValueRules) {
            if (rule && rule.processSync) {
                handleError(rule.processSync(Object.assign(Object.assign({}, context), { value })), context);
            }
        }
        return;
    }
    if (instance === null || instance === void 0 ? void 0 : instance.shouldSkipValidation(data, row)) {
        return;
    }
    const rulesToExecute = validationRules(context, rules, skipValidation);
    if (!rulesToExecute.length) {
        return;
    }
    if (component.truncateMultipleSpaces && value && typeof value === 'string') {
        value = value.trim().replace(/\s{2,}/g, ' ');
    }
    for (const rule of rulesToExecute) {
        try {
            if (rule && rule.processSync) {
                handleError(rule.processSync(Object.assign(Object.assign({}, context), { value })), context);
            }
        }
        catch (err) {
            console.error("Validator error:", (0, error_1.getErrorMessage)(err));
        }
    }
    return;
};
exports.validateProcessSync = validateProcessSync;
const validateCustomProcess = (context) => __awaiter(void 0, void 0, void 0, function* () {
    context.rules = context.rules || rules_1.evaluationRules;
    context.skipValidation = exports.shouldSkipValidationCustom;
    return (0, exports.validateProcess)(context);
});
exports.validateCustomProcess = validateCustomProcess;
const validateCustomProcessSync = (context) => {
    context.rules = context.rules || rules_1.evaluationRules;
    context.skipValidation = exports.shouldSkipValidationCustom;
    return (0, exports.validateProcessSync)(context);
};
exports.validateCustomProcessSync = validateCustomProcessSync;
const validateServerProcess = (context) => __awaiter(void 0, void 0, void 0, function* () {
    context.rules = context.rules || rules_1.serverRules;
    context.skipValidation = exports.shouldSkipValidationSimple;
    return (0, exports.validateProcess)(context);
});
exports.validateServerProcess = validateServerProcess;
const validateServerProcessSync = (context) => {
    context.rules = context.rules || rules_1.serverRules;
    context.skipValidation = exports.shouldSkipValidationSimple;
    return (0, exports.validateProcessSync)(context);
};
exports.validateServerProcessSync = validateServerProcessSync;
const validateAllProcess = (context) => __awaiter(void 0, void 0, void 0, function* () {
    context.rules = context.rules || rules_1.rules;
    context.skipValidation = exports.shouldSkipValidation;
    return (0, exports.validateProcess)(context);
});
exports.validateAllProcess = validateAllProcess;
const validateAllProcessSync = (context) => {
    context.rules = context.rules || rules_1.rules;
    context.skipValidation = exports.shouldSkipValidation;
    return (0, exports.validateProcessSync)(context);
};
exports.validateAllProcessSync = validateAllProcessSync;
exports.validateCustomProcessInfo = {
    name: 'validateCustom',
    process: exports.validateCustomProcess,
    processSync: exports.validateCustomProcessSync,
    shouldProcess: shouldValidateCustom,
};
exports.validateServerProcessInfo = {
    name: 'validateServer',
    process: exports.validateServerProcess,
    processSync: exports.validateServerProcessSync,
    shouldProcess: shouldValidateServer,
};
exports.validateProcessInfo = {
    name: 'validate',
    process: exports.validateAllProcess,
    processSync: exports.validateAllProcessSync,
    shouldProcess: shouldValidateAll,
};
__exportStar(require("./util"), exports);
