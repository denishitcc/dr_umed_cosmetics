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
exports.conditionProcessInfo = exports.simpleConditionProcessInfo = exports.customConditionProcessInfo = exports.conditionProcessSync = exports.conditionProcess = exports.simpleConditionProcessSync = exports.simpleConditionProcess = exports.customConditionProcessSync = exports.customConditionProcess = exports.conditionalProcess = exports.isConditionallyHidden = exports.isSimpleConditionallyHidden = exports.isCustomConditionallyHidden = exports.hasConditions = void 0;
const utils_1 = require("../../utils");
const set_1 = __importDefault(require("lodash/set"));
const formUtil_1 = require("../../utils/formUtil");
const conditions_1 = require("../../utils/conditions");
const skipOnServer = (context) => {
    const { component, config } = context;
    const clearOnHide = component.hasOwnProperty('clearOnHide') ? component.clearOnHide : true;
    if ((config === null || config === void 0 ? void 0 : config.server) && !clearOnHide) {
        // No need to run conditionals on server unless clearOnHide is set.
        return true;
    }
    return false;
};
const hasCustomConditions = (context) => {
    const { component } = context;
    return !!component.customConditional;
};
const hasSimpleConditions = (context) => {
    const { component } = context;
    const { conditional } = component;
    if ((0, conditions_1.isLegacyConditional)(conditional) ||
        (0, conditions_1.isSimpleConditional)(conditional) ||
        (0, conditions_1.isJSONConditional)(conditional)) {
        return true;
    }
    return false;
};
const hasConditions = (context) => {
    return hasSimpleConditions(context) || hasCustomConditions(context);
};
exports.hasConditions = hasConditions;
const isCustomConditionallyHidden = (context) => {
    if (!hasCustomConditions(context)) {
        return false;
    }
    const { component } = context;
    const { customConditional } = component;
    let show = null;
    if (customConditional) {
        show = (0, conditions_1.checkCustomConditional)(customConditional, context, 'show');
    }
    if (show === null) {
        return false;
    }
    return !show;
};
exports.isCustomConditionallyHidden = isCustomConditionallyHidden;
const isSimpleConditionallyHidden = (context) => {
    if (!hasSimpleConditions(context)) {
        return false;
    }
    const { component } = context;
    const { conditional } = component;
    let show = null;
    if ((0, conditions_1.isJSONConditional)(conditional)) {
        show = (0, conditions_1.checkJsonConditional)(conditional, context);
    }
    if ((0, conditions_1.isLegacyConditional)(conditional)) {
        show = (0, conditions_1.checkLegacyConditional)(conditional, context);
    }
    if ((0, conditions_1.isSimpleConditional)(conditional)) {
        show = (0, conditions_1.checkSimpleConditional)(conditional, context);
    }
    if (show === null || show === undefined) {
        return false;
    }
    return !show;
};
exports.isSimpleConditionallyHidden = isSimpleConditionallyHidden;
const isConditionallyHidden = (context) => {
    return (0, exports.isCustomConditionallyHidden)(context) || (0, exports.isSimpleConditionallyHidden)(context);
};
exports.isConditionallyHidden = isConditionallyHidden;
const conditionalProcess = (context, isHidden) => {
    const { component, data, row, scope, path } = context;
    if (!(0, exports.hasConditions)(context)) {
        return;
    }
    if (!scope.conditionals) {
        scope.conditionals = [];
    }
    let conditionalComp = scope.conditionals.find((cond) => (cond.path === path));
    if (!conditionalComp) {
        conditionalComp = { path, conditionallyHidden: false };
        scope.conditionals.push(conditionalComp);
    }
    if (skipOnServer(context)) {
        return false;
    }
    conditionalComp.conditionallyHidden = conditionalComp.conditionallyHidden || isHidden(context);
    if (conditionalComp.conditionallyHidden) {
        const info = (0, formUtil_1.componentInfo)(component);
        if (info.hasColumns || info.hasComps || info.hasRows) {
            // If this is a container component, we need to add all the child components as conditionally hidden as well.
            utils_1.Utils.eachComponentData([component], row, (comp, data, compRow, compPath) => {
                var _a;
                if (comp !== component) {
                    (_a = scope.conditionals) === null || _a === void 0 ? void 0 : _a.push({ path: (0, formUtil_1.getComponentPath)(comp, compPath), conditionallyHidden: true });
                }
                (0, set_1.default)(comp, 'hidden', true);
            });
        }
        else {
            (0, set_1.default)(component, 'hidden', true);
        }
    }
};
exports.conditionalProcess = conditionalProcess;
const customConditionProcess = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.customConditionProcessSync)(context);
});
exports.customConditionProcess = customConditionProcess;
const customConditionProcessSync = (context) => {
    return (0, exports.conditionalProcess)(context, exports.isCustomConditionallyHidden);
};
exports.customConditionProcessSync = customConditionProcessSync;
const simpleConditionProcess = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.simpleConditionProcessSync)(context);
});
exports.simpleConditionProcess = simpleConditionProcess;
const simpleConditionProcessSync = (context) => {
    return (0, exports.conditionalProcess)(context, exports.isSimpleConditionallyHidden);
};
exports.simpleConditionProcessSync = simpleConditionProcessSync;
const conditionProcess = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.conditionProcessSync)(context);
});
exports.conditionProcess = conditionProcess;
const conditionProcessSync = (context) => {
    return (0, exports.conditionalProcess)(context, exports.isConditionallyHidden);
};
exports.conditionProcessSync = conditionProcessSync;
exports.customConditionProcessInfo = {
    name: 'customConditions',
    process: exports.customConditionProcess,
    processSync: exports.customConditionProcessSync,
    shouldProcess: hasCustomConditions,
};
exports.simpleConditionProcessInfo = {
    name: 'simpleConditions',
    process: exports.simpleConditionProcess,
    processSync: exports.simpleConditionProcessSync,
    shouldProcess: hasSimpleConditions,
};
exports.conditionProcessInfo = {
    name: 'conditions',
    process: exports.conditionProcess,
    processSync: exports.conditionProcessSync,
    shouldProcess: hasSimpleConditions,
};
