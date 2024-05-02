"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.isComponentDataEmpty = exports.getEmptyValue = exports.findComponent = exports.applyFormChanges = exports.generateFormChange = exports.getStrings = exports.getValue = exports.escapeRegExCharacters = exports.formatAsCurrency = exports.parseFloatExt = exports.hasCondition = exports.removeComponent = exports.searchComponents = exports.getComponent = exports.matchComponent = exports.isLayoutComponent = exports.getComponentActualValue = exports.getComponentData = exports.eachComponentAsync = exports.eachComponent = exports.componentInfo = exports.getContextualRowData = exports.getContextualRowPath = exports.getComponentKey = exports.eachComponentData = exports.eachComponentDataAsync = exports.componentChildPath = exports.componentPath = exports.isComponentNestedDataType = exports.isComponentModelType = exports.getComponentPath = exports.getComponentAbsolutePath = exports.getModelType = exports.MODEL_TYPES = exports.uniqueName = exports.guid = exports.flattenComponents = exports.findComponents = void 0;
const core_1 = require("@formio/core");
const { flattenComponents, guid, uniqueName, MODEL_TYPES, getModelType, getComponentAbsolutePath, getComponentPath, isComponentModelType, isComponentNestedDataType, componentPath, componentChildPath, eachComponentDataAsync, eachComponentData, getComponentKey, getContextualRowPath, getContextualRowData, componentInfo, eachComponent, eachComponentAsync, getComponentData, getComponentActualValue, isLayoutComponent, matchComponent, getComponent, searchComponents, removeComponent, hasCondition, parseFloatExt, formatAsCurrency, escapeRegExCharacters, getValue, getStrings, generateFormChange, applyFormChanges, findComponent, getEmptyValue, isComponentDataEmpty } = core_1.Utils;
exports.flattenComponents = flattenComponents;
exports.guid = guid;
exports.uniqueName = uniqueName;
exports.MODEL_TYPES = MODEL_TYPES;
exports.getModelType = getModelType;
exports.getComponentAbsolutePath = getComponentAbsolutePath;
exports.getComponentPath = getComponentPath;
exports.isComponentModelType = isComponentModelType;
exports.isComponentNestedDataType = isComponentNestedDataType;
exports.componentPath = componentPath;
exports.componentChildPath = componentChildPath;
exports.eachComponentDataAsync = eachComponentDataAsync;
exports.eachComponentData = eachComponentData;
exports.getComponentKey = getComponentKey;
exports.getContextualRowPath = getContextualRowPath;
exports.getContextualRowData = getContextualRowData;
exports.componentInfo = componentInfo;
exports.eachComponent = eachComponent;
exports.eachComponentAsync = eachComponentAsync;
exports.getComponentData = getComponentData;
exports.getComponentActualValue = getComponentActualValue;
exports.isLayoutComponent = isLayoutComponent;
exports.matchComponent = matchComponent;
exports.getComponent = getComponent;
exports.searchComponents = searchComponents;
exports.removeComponent = removeComponent;
exports.hasCondition = hasCondition;
exports.parseFloatExt = parseFloatExt;
exports.formatAsCurrency = formatAsCurrency;
exports.escapeRegExCharacters = escapeRegExCharacters;
exports.getValue = getValue;
exports.getStrings = getStrings;
exports.generateFormChange = generateFormChange;
exports.applyFormChanges = applyFormChanges;
exports.findComponent = findComponent;
exports.getEmptyValue = getEmptyValue;
exports.isComponentDataEmpty = isComponentDataEmpty;
/**
 * Deprecated version of findComponents. Renamed to searchComponents.
 *
 * @param components
 * @param query
 * @returns {*}
 */
function findComponents(components, query) {
    console.warn('formio.js/utils findComponents is deprecated. Use searchComponents instead.');
    return searchComponents(components, query);
}
exports.findComponents = findComponents;
