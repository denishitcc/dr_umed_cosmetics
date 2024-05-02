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
var __setModuleDefault = (this && this.__setModuleDefault) || (Object.create ? (function(o, v) {
    Object.defineProperty(o, "default", { enumerable: true, value: v });
}) : function(o, v) {
    o["default"] = v;
});
var __importStar = (this && this.__importStar) || function (mod) {
    if (mod && mod.__esModule) return mod;
    var result = {};
    if (mod != null) for (var k in mod) if (k !== "default" && Object.prototype.hasOwnProperty.call(mod, k)) __createBinding(result, mod, k);
    __setModuleDefault(result, mod);
    return result;
};
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.checkSimpleConditional = exports.checkJsonConditional = exports.checkLegacyConditional = exports.checkCustomConditional = exports.conditionallyHidden = exports.isSimpleConditional = exports.isLegacyConditional = exports.isJSONConditional = void 0;
const jsonlogic_1 = __importStar(require("../modules/jsonlogic"));
const formUtil_1 = require("./formUtil");
const lodash_1 = require("lodash");
const JSONLogicEvaluator = jsonlogic_1.default.evaluator;
const operators_1 = __importDefault(require("./operators"));
const isJSONConditional = (conditional) => {
    return conditional && conditional.json && (0, lodash_1.isObject)(conditional.json);
};
exports.isJSONConditional = isJSONConditional;
const isLegacyConditional = (conditional) => {
    return conditional && conditional.when;
};
exports.isLegacyConditional = isLegacyConditional;
const isSimpleConditional = (conditional) => {
    return conditional && conditional.conjunction && conditional.conditions;
};
exports.isSimpleConditional = isSimpleConditional;
function conditionallyHidden(context) {
    const { scope, component, path } = context;
    if (scope.conditionals && path) {
        const hidden = (0, lodash_1.find)(scope.conditionals, (conditional) => {
            return conditional.path === path;
        });
        return hidden === null || hidden === void 0 ? void 0 : hidden.conditionallyHidden;
    }
    return false;
}
exports.conditionallyHidden = conditionallyHidden;
/**
 * Check custom javascript conditional.
 *
 * @param component
 * @param custom
 * @param row
 * @param data
 * @returns {*}
 */
function checkCustomConditional(condition, context, variable = 'show') {
    const { evalContext } = context;
    if (!condition) {
        return null;
    }
    const value = (0, jsonlogic_1.evaluate)(context, condition, variable, evalContext);
    if (value === null) {
        return null;
    }
    return value;
}
exports.checkCustomConditional = checkCustomConditional;
/**
 * Checks the legacy conditionals.
 *
 * @param conditional
 * @param context
 * @param checkDefault
 * @returns
 */
function checkLegacyConditional(conditional, context) {
    const { row, data, component } = context;
    if (!conditional || !(0, exports.isLegacyConditional)(conditional) || !conditional.when) {
        return null;
    }
    const value = (0, formUtil_1.getComponentActualValue)(component, conditional.when, data, row);
    const eq = String(conditional.eq);
    const show = String(conditional.show);
    if ((0, lodash_1.isObject)(value) && (0, lodash_1.has)(value, eq)) {
        return String(value[eq]) === show;
    }
    if (Array.isArray(value) && value.map(String).includes(eq)) {
        return show === 'true';
    }
    return (String(value) === eq) === (show === 'true');
}
exports.checkLegacyConditional = checkLegacyConditional;
/**
 * Checks the JSON Conditionals.
 * @param conditional
 * @param context
 * @returns
 */
function checkJsonConditional(conditional, context) {
    const { evalContext } = context;
    if (!conditional || !(0, exports.isJSONConditional)(conditional)) {
        return null;
    }
    const evalContextValue = evalContext ? evalContext(context) : context;
    return JSONLogicEvaluator.evaluate(conditional.json, evalContextValue);
}
exports.checkJsonConditional = checkJsonConditional;
/**
 * Checks the simple conditionals.
 * @param conditional
 * @param context
 * @returns
 */
function checkSimpleConditional(conditional, context) {
    const { component, data, row, instance } = context;
    if (!conditional || !(0, exports.isSimpleConditional)(conditional)) {
        return null;
    }
    const { conditions = [], conjunction = 'all', show = true } = conditional;
    if (!conditions.length) {
        return null;
    }
    const conditionsResult = (0, lodash_1.filter)((0, lodash_1.map)(conditions, (cond) => {
        const { value: comparedValue, operator, component: conditionComponentPath } = cond;
        if (!conditionComponentPath) {
            // Ignore conditions if there is no component path.
            return null;
        }
        const value = (0, formUtil_1.getComponentActualValue)(component, conditionComponentPath, data, row);
        const ConditionOperator = operators_1.default[operator];
        return ConditionOperator
            ? new ConditionOperator().getResult({ value, comparedValue, instance, component, conditionComponentPath })
            : true;
    }), (res) => (res !== null));
    let result = false;
    switch (conjunction) {
        case 'any':
            result = (0, lodash_1.some)(conditionsResult, res => !!res);
            break;
        default:
            result = (0, lodash_1.every)(conditionsResult, res => !!res);
    }
    return show ? result : !result;
}
exports.checkSimpleConditional = checkSimpleConditional;
