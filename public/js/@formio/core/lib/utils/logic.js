"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.applyActions = exports.setCustomAction = exports.setMergeComponentSchema = exports.setValueProperty = exports.setActionProperty = exports.setActionStringProperty = exports.setActionBooleanProperty = exports.checkTrigger = exports.hasLogic = void 0;
const conditions_1 = require("./conditions");
const lodash_1 = require("lodash");
const jsonlogic_1 = require("../modules/jsonlogic");
const hasLogic = (context) => {
    const { component } = context;
    const { logic } = component;
    if (!logic || !logic.length) {
        return false;
    }
    return true;
};
exports.hasLogic = hasLogic;
const checkTrigger = (context, trigger) => {
    let shouldTrigger = false;
    switch (trigger.type) {
        case 'simple':
            if ((0, conditions_1.isLegacyConditional)(trigger.simple)) {
                shouldTrigger = (0, conditions_1.checkLegacyConditional)(trigger.simple, context);
            }
            else {
                shouldTrigger = (0, conditions_1.checkSimpleConditional)(trigger.simple, context);
            }
            break;
        case 'javascript':
            shouldTrigger = (0, conditions_1.checkCustomConditional)(trigger.javascript, context, 'result');
            break;
        case 'json':
            shouldTrigger = (0, conditions_1.checkJsonConditional)(trigger, context);
            break;
        default:
            shouldTrigger = false;
            break;
    }
    if (shouldTrigger === null) {
        return false;
    }
    return shouldTrigger;
};
exports.checkTrigger = checkTrigger;
function setActionBooleanProperty(context, action) {
    const { component, scope, path } = context;
    const property = action.property.value;
    const currentValue = (0, lodash_1.get)(component, property, false).toString();
    const newValue = action.state.toString();
    if (currentValue !== newValue) {
        (0, lodash_1.set)(component, property, newValue === 'true');
        // If this is "logic" forcing a component to be hidden, then we will set the "conditionallyHidden"
        // flag which will trigger the clearOnHide functionality.
        if (property === 'hidden' &&
            component.hidden &&
            path) {
            if (!scope.conditionals) {
                scope.conditionals = [];
            }
            const conditionalyHidden = scope.conditionals.find((cond) => {
                return cond.path === path;
            });
            if (conditionalyHidden) {
                conditionalyHidden.conditionallyHidden = true;
            }
            else {
                scope.conditionals.push({
                    path,
                    conditionallyHidden: true
                });
            }
        }
        return true;
    }
    return false;
}
exports.setActionBooleanProperty = setActionBooleanProperty;
function setActionStringProperty(context, action) {
    const { component } = context;
    const property = action.property.value;
    const textValue = action.property.component ? action[action.property.component] : action.text;
    const currentValue = (0, lodash_1.get)(component, property, '');
    const newValue = (0, jsonlogic_1.interpolate)(Object.assign(Object.assign({}, context), { value: '' }), textValue, (evalContext) => {
        evalContext.value = currentValue;
    });
    if (newValue !== currentValue) {
        (0, lodash_1.set)(component, property, newValue);
        return true;
    }
    return false;
}
exports.setActionStringProperty = setActionStringProperty;
function setActionProperty(context, action) {
    switch (action.property.type) {
        case 'boolean':
            return setActionBooleanProperty(context, action);
        case 'string':
            return setActionStringProperty(context, action);
    }
    return false;
}
exports.setActionProperty = setActionProperty;
function setValueProperty(context, action) {
    const { component, data, value, path } = context;
    const oldValue = (0, lodash_1.get)(data, path);
    const newValue = (0, jsonlogic_1.evaluate)(context, action.value, 'value', (evalContext) => {
        evalContext.value = (0, lodash_1.clone)(oldValue);
    });
    if (!(0, lodash_1.isEqual)(oldValue, newValue) &&
        !(component.clearOnHide && (0, conditions_1.conditionallyHidden)(context))) {
        (0, lodash_1.set)(data, path, newValue);
        return true;
    }
    return false;
}
exports.setValueProperty = setValueProperty;
function setMergeComponentSchema(context, action) {
    const { component, data, path } = context;
    const oldValue = (0, lodash_1.get)(data, path);
    const schema = (0, jsonlogic_1.evaluate)(Object.assign(Object.assign({}, context), { value: {} }), action.schemaDefinition, 'schema', (evalContext) => {
        evalContext.value = (0, lodash_1.clone)(oldValue);
    });
    const merged = (0, lodash_1.assign)({}, component, schema);
    if (!(0, lodash_1.isEqual)(component, merged)) {
        (0, lodash_1.assign)(component, schema);
        return true;
    }
    return false;
}
exports.setMergeComponentSchema = setMergeComponentSchema;
function setCustomAction(context, action) {
    return setValueProperty(context, { type: 'value', value: action.customAction });
}
exports.setCustomAction = setCustomAction;
const applyActions = (context) => {
    const { component } = context;
    const { logic } = component;
    if (!logic || !logic.length) {
        return false;
    }
    return logic.reduce((changed, logicItem) => {
        const { actions, trigger } = logicItem;
        if (!trigger || !actions || !actions.length || !(0, exports.checkTrigger)(context, trigger)) {
            return changed;
        }
        return actions.reduce((changed, action) => {
            switch (action.type) {
                case 'property':
                    if (setActionProperty(context, action)) {
                        return true;
                    }
                    return changed;
                case 'value':
                    return setValueProperty(context, action) || changed;
                case 'mergeComponentSchema':
                    if (setMergeComponentSchema(context, action)) {
                        return true;
                    }
                    return changed;
                case 'customAction':
                    return setCustomAction(context, action) || changed;
                default:
                    return changed;
            }
        }, changed);
    }, false);
};
exports.applyActions = applyActions;
