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
exports.isComponentDataEmpty = exports.getEmptyValue = exports.findComponent = exports.applyFormChanges = exports.generateFormChange = exports.getStrings = exports.getValue = exports.escapeRegExCharacters = exports.formatAsCurrency = exports.parseFloatExt = exports.hasCondition = exports.removeComponent = exports.searchComponents = exports.getComponent = exports.matchComponent = exports.isLayoutComponent = exports.getComponentActualValue = exports.getComponentData = exports.eachComponentAsync = exports.eachComponent = exports.componentInfo = exports.getContextualRowData = exports.getContextualRowPath = exports.getComponentKey = exports.eachComponentData = exports.eachComponentDataAsync = exports.componentChildPath = exports.componentPath = exports.isComponentNestedDataType = exports.isComponentModelType = exports.getComponentPath = exports.getComponentAbsolutePath = exports.getModelType = exports.MODEL_TYPES = exports.uniqueName = exports.guid = exports.flattenComponents = void 0;
const lodash_1 = require("lodash");
const fast_json_patch_1 = require("fast-json-patch");
const Evaluator_1 = require("./Evaluator");
/**
 * Flatten the form components for data manipulation.
 *
 * @param {Object} components
 *   The components to iterate.
 * @param {Boolean} includeAll
 *   Whether or not to include layout components.
 *
 * @returns {Object}
 *   The flattened components map.
 */
function flattenComponents(components, includeAll) {
    const flattened = {};
    eachComponent(components, (component, path) => {
        flattened[path] = component;
    }, includeAll);
    return flattened;
}
exports.flattenComponents = flattenComponents;
function guid() {
    return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, (c) => {
        const r = (Math.random() * 16) | 0;
        const v = c === "x" ? r : (r & 0x3) | 0x8;
        return v.toString(16);
    });
}
exports.guid = guid;
/**
 * Make a filename guaranteed to be unique.
 * @param name
 * @param template
 * @param evalContext
 * @returns {string}
 */
function uniqueName(name, template, evalContext) {
    template = template || "{{fileName}}-{{guid}}";
    //include guid in template anyway, to prevent overwriting issue if filename matches existing file
    if (!template.includes("{{guid}}")) {
        template = `${template}-{{guid}}`;
    }
    const parts = name.split(".");
    let fileName = parts.slice(0, parts.length - 1).join(".");
    const extension = parts.length > 1 ? `.${(0, lodash_1.last)(parts)}` : "";
    //allow only 100 characters from original name to avoid issues with filename length restrictions
    fileName = fileName.substr(0, 100);
    evalContext = Object.assign(evalContext || {}, {
        fileName,
        guid: guid(),
    });
    //only letters, numbers, dots, dashes, underscores and spaces are allowed. Anything else will be replaced with dash
    const uniqueName = `${Evaluator_1.Evaluator.interpolate(template, evalContext)}${extension}`.replace(/[^0-9a-zA-Z.\-_ ]/g, "-");
    return uniqueName;
}
exports.uniqueName = uniqueName;
exports.MODEL_TYPES = {
    array: [
        'datagrid',
        'editgrid',
        'datatable',
        'dynamicWizard',
    ],
    dataObject: [
        'form'
    ],
    object: [
        'container',
        'address'
    ],
    map: [
        'datamap'
    ],
    content: [
        'htmlelement',
        'content'
    ],
    layout: [
        'table',
        'tabs',
        'well',
        'columns',
        'fieldset',
        'panel',
        'tabs'
    ],
};
function getModelType(component) {
    if (isComponentNestedDataType(component)) {
        if (isComponentModelType(component, 'dataObject')) {
            return 'dataObject';
        }
        if (isComponentModelType(component, 'array')) {
            return 'array';
        }
        return 'object';
    }
    if ((component.input === false) || isComponentModelType(component, 'layout')) {
        return 'inherit';
    }
    if (getComponentKey(component)) {
        return 'value';
    }
    return 'inherit';
}
exports.getModelType = getModelType;
function getComponentAbsolutePath(component) {
    let paths = [component.path];
    while (component.parent) {
        component = component.parent;
        // We only need to do this for nested forms because they reset the data contexts for the children.
        if (isComponentModelType(component, 'dataObject')) {
            paths[paths.length - 1] = `data.${paths[paths.length - 1]}`;
            paths.push(component.path);
        }
    }
    return paths.reverse().join('.');
}
exports.getComponentAbsolutePath = getComponentAbsolutePath;
function getComponentPath(component, path) {
    const key = getComponentKey(component);
    if (!key) {
        return path;
    }
    if (!path) {
        return key;
    }
    if (path.match(new RegExp(`${key}$`))) {
        return path;
    }
    return (getModelType(component) === 'inherit') ? `${path}.${key}` : path;
}
exports.getComponentPath = getComponentPath;
function isComponentModelType(component, modelType) {
    return component.modelType === modelType || exports.MODEL_TYPES[modelType].includes(component.type);
}
exports.isComponentModelType = isComponentModelType;
function isComponentNestedDataType(component) {
    return component.tree || isComponentModelType(component, 'array') ||
        isComponentModelType(component, 'dataObject') ||
        isComponentModelType(component, 'object') ||
        isComponentModelType(component, 'map');
}
exports.isComponentNestedDataType = isComponentNestedDataType;
function componentPath(component, parentPath) {
    parentPath = component.parentPath || parentPath;
    const key = getComponentKey(component);
    if (!key) {
        // If the component does not have a key, then just always return the parent path.
        return parentPath || '';
    }
    return parentPath ? `${parentPath}.${key}` : key;
}
exports.componentPath = componentPath;
const componentChildPath = (component, parentPath, path) => {
    parentPath = component.parentPath || parentPath;
    path = path || componentPath(component, parentPath);
    // See if we are a nested component.
    if (component.components && Array.isArray(component.components)) {
        if (isComponentModelType(component, 'dataObject')) {
            return `${path}.data`;
        }
        if (isComponentModelType(component, 'array')) {
            return `${path}[0]`;
        }
        if (isComponentNestedDataType(component)) {
            return path;
        }
        return parentPath === undefined ? path : parentPath;
    }
    return path;
};
exports.componentChildPath = componentChildPath;
// Async each component data.
const eachComponentDataAsync = (components_1, data_1, fn_1, ...args_1) => __awaiter(void 0, [components_1, data_1, fn_1, ...args_1], void 0, function* (components, data, fn, path = "", index, parent, includeAll = false) {
    if (!components || !data) {
        return;
    }
    return yield eachComponentAsync(components, (component, compPath, componentComponents, compParent) => __awaiter(void 0, void 0, void 0, function* () {
        const row = getContextualRowData(component, compPath, data);
        if ((yield fn(component, data, row, compPath, componentComponents, index, compParent)) === true) {
            return true;
        }
        if (isComponentNestedDataType(component)) {
            const value = (0, lodash_1.get)(data, compPath, data);
            if (Array.isArray(value)) {
                for (let i = 0; i < value.length; i++) {
                    yield (0, exports.eachComponentDataAsync)(component.components, data, fn, `${compPath}[${i}]`, i, component, includeAll);
                }
                return true;
            }
            else if ((0, lodash_1.isEmpty)(row) && !includeAll) {
                // Tree components may submit empty objects; since we've already evaluated the parent tree/layout component, we won't worry about constituent elements
                return true;
            }
            if (isComponentModelType(component, 'dataObject')) {
                // No need to bother processing all the children data if there is no data for this form.
                if ((0, lodash_1.has)(data, component.path)) {
                    // For nested forms, we need to reset the "data" and "path" objects for all of the children components, and then re-establish the data when it is done.
                    const childPath = (0, exports.componentChildPath)(component, path, compPath);
                    const childData = (0, lodash_1.get)(data, childPath, null);
                    yield (0, exports.eachComponentDataAsync)(component.components, childData, fn, '', index, component, includeAll);
                    (0, lodash_1.set)(data, childPath, childData);
                }
            }
            else {
                yield (0, exports.eachComponentDataAsync)(component.components, data, fn, (0, exports.componentChildPath)(component, path, compPath), index, component, includeAll);
            }
            return true;
        }
        else {
            return false;
        }
    }), true, path, parent);
});
exports.eachComponentDataAsync = eachComponentDataAsync;
const eachComponentData = (components, data, fn, path = "", index, parent, includeAll = false) => {
    if (!components || !data) {
        return;
    }
    return eachComponent(components, (component, compPath, componentComponents, compParent) => {
        const row = getContextualRowData(component, compPath, data);
        if (fn(component, data, row, compPath, componentComponents, index, compParent) === true) {
            return true;
        }
        if (isComponentNestedDataType(component)) {
            const value = (0, lodash_1.get)(data, compPath, data);
            if (Array.isArray(value)) {
                for (let i = 0; i < value.length; i++) {
                    (0, exports.eachComponentData)(component.components, data, fn, `${compPath}[${i}]`, i, component, includeAll);
                }
                return true;
            }
            else if ((0, lodash_1.isEmpty)(row) && !includeAll) {
                // Tree components may submit empty objects; since we've already evaluated the parent tree/layout component, we won't worry about constituent elements
                return true;
            }
            if (isComponentModelType(component, 'dataObject')) {
                // No need to bother processing all the children data if there is no data for this form.
                if ((0, lodash_1.has)(data, component.path)) {
                    // For nested forms, we need to reset the "data" and "path" objects for all of the children components, and then re-establish the data when it is done.
                    const childPath = (0, exports.componentChildPath)(component, path, compPath);
                    const childData = (0, lodash_1.get)(data, childPath, {});
                    (0, exports.eachComponentData)(component.components, childData, fn, '', index, component, includeAll);
                    (0, lodash_1.set)(data, childPath, childData);
                }
            }
            else {
                (0, exports.eachComponentData)(component.components, data, fn, (0, exports.componentChildPath)(component, path, compPath), index, component, includeAll);
            }
            return true;
        }
        else {
            return false;
        }
    }, true, path, parent);
};
exports.eachComponentData = eachComponentData;
function getComponentKey(component) {
    if (component.type === 'checkbox' &&
        component.inputType === 'radio' &&
        component.name) {
        return component.name;
    }
    return component.key;
}
exports.getComponentKey = getComponentKey;
function getContextualRowPath(component, path) {
    return path.replace(new RegExp(`\.?${getComponentKey(component)}$`), '');
}
exports.getContextualRowPath = getContextualRowPath;
function getContextualRowData(component, path, data) {
    const rowPath = getContextualRowPath(component, path);
    return rowPath ? (0, lodash_1.get)(data, rowPath, null) : data;
}
exports.getContextualRowData = getContextualRowData;
function componentInfo(component) {
    const hasColumns = component.columns && Array.isArray(component.columns);
    const hasRows = component.rows && Array.isArray(component.rows);
    const hasComps = component.components && Array.isArray(component.components);
    return {
        hasColumns,
        hasRows,
        hasComps,
        iterable: hasColumns || hasRows || hasComps || isComponentModelType(component, 'content'),
    };
}
exports.componentInfo = componentInfo;
/**
 * Iterate through each component within a form.
 *
 * @param {Object} components
 *   The components to iterate.
 * @param {Function} fn
 *   The iteration function to invoke for each component.
 * @param {Boolean} includeAll
 *   Whether or not to include layout components.
 * @param {String} path
 *   The current data path of the element. Example: data.user.firstName
 * @param {Object} parent
 *   The parent object.
 */
function eachComponent(components, fn, includeAll, path, parent) {
    if (!components)
        return;
    path = path || "";
    components.forEach((component) => {
        if (!component) {
            return;
        }
        const info = componentInfo(component);
        let noRecurse = false;
        // Keep track of parent references.
        if (parent) {
            // Ensure we don't create infinite JSON structures.
            Object.defineProperty(component, 'parent', {
                enumerable: false,
                writable: true,
                value: JSON.parse(JSON.stringify(parent))
            });
            Object.defineProperty(component.parent, 'parent', {
                enumerable: false,
                writable: true,
                value: parent.parent
            });
            Object.defineProperty(component.parent, 'path', {
                enumerable: false,
                writable: true,
                value: parent.path
            });
            delete component.parent.components;
            delete component.parent.componentMap;
            delete component.parent.columns;
            delete component.parent.rows;
        }
        Object.defineProperty(component, 'path', {
            enumerable: false,
            writable: true,
            value: componentPath(component, path)
        });
        if (includeAll || component.tree || !info.iterable) {
            noRecurse = fn(component, component.path, components, parent);
        }
        if (!noRecurse) {
            if (info.hasColumns) {
                component.columns.forEach((column) => eachComponent(column.components, fn, includeAll, path, parent ? component : null));
            }
            else if (info.hasRows) {
                component.rows.forEach((row) => {
                    if (Array.isArray(row)) {
                        row.forEach((column) => eachComponent(column.components, fn, includeAll, path, parent ? component : null));
                    }
                });
            }
            else if (info.hasComps) {
                eachComponent(component.components, fn, includeAll, (0, exports.componentChildPath)(component, path), parent ? component : null);
            }
        }
    });
}
exports.eachComponent = eachComponent;
// Async each component.
function eachComponentAsync(components_2, fn_1) {
    return __awaiter(this, arguments, void 0, function* (components, fn, includeAll = false, path = "", parent) {
        var _a, _b;
        if (!components)
            return;
        for (let i = 0; i < components.length; i++) {
            if (!components[i]) {
                continue;
            }
            let component = components[i];
            const info = componentInfo(component);
            // Keep track of parent references.
            if (parent) {
                // Ensure we don't create infinite JSON structures.
                Object.defineProperty(component, 'parent', {
                    enumerable: false,
                    writable: true,
                    value: JSON.parse(JSON.stringify(parent))
                });
                Object.defineProperty(component.parent, 'parent', {
                    enumerable: false,
                    writable: true,
                    value: parent.parent
                });
                Object.defineProperty(component.parent, 'path', {
                    enumerable: false,
                    writable: true,
                    value: parent.path
                });
                delete component.parent.components;
                delete component.parent.componentMap;
                delete component.parent.columns;
                delete component.parent.rows;
            }
            Object.defineProperty(component, 'path', {
                enumerable: false,
                writable: true,
                value: componentPath(component, path)
            });
            if (includeAll || component.tree || !info.iterable) {
                if (yield fn(component, component.path, components, parent)) {
                    continue;
                }
            }
            if (info.hasColumns) {
                for (let j = 0; j < component.columns.length; j++) {
                    yield eachComponentAsync((_a = component.columns[j]) === null || _a === void 0 ? void 0 : _a.components, fn, includeAll, path, parent ? component : null);
                }
            }
            else if (info.hasRows) {
                for (let j = 0; j < component.rows.length; j++) {
                    let row = component.rows[j];
                    if (Array.isArray(row)) {
                        for (let k = 0; k < row.length; k++) {
                            yield eachComponentAsync((_b = row[k]) === null || _b === void 0 ? void 0 : _b.components, fn, includeAll, path, parent ? component : null);
                        }
                    }
                }
            }
            else if (info.hasComps) {
                yield eachComponentAsync(component.components, fn, includeAll, (0, exports.componentChildPath)(component, path), parent ? component : null);
            }
        }
    });
}
exports.eachComponentAsync = eachComponentAsync;
// Provided components, data, and a key, this will return the components data.
function getComponentData(components, data, path) {
    const compData = { component: null, data: null };
    (0, exports.eachComponentData)(components, data, (component, data, row, compPath) => {
        if (compPath === path) {
            compData.component = component;
            compData.data = row;
            return true;
        }
    });
    return compData;
}
exports.getComponentData = getComponentData;
function getComponentActualValue(component, compPath, data, row) {
    var _a, _b;
    // The compPath here will NOT contain the indexes for DataGrids and EditGrids.
    //
    //   a[0].b[2].c[3].d
    //
    // Because of this, we will need to determine our parent component path (not data path),
    // and find the "row" based comp path.
    //
    //   a[0].b[2].c[3].d => a.b.c.d
    //
    if ((_a = component.parent) === null || _a === void 0 ? void 0 : _a.path) {
        const parentCompPath = (_b = component.parent) === null || _b === void 0 ? void 0 : _b.path.replace(/\[[0-9]+\]/g, '');
        compPath = compPath.replace(parentCompPath, '');
        compPath = (0, lodash_1.trim)(compPath, '. ');
    }
    let value = null;
    if (row) {
        value = (0, lodash_1.get)(row, compPath);
    }
    if (data && (0, lodash_1.isNil)(value)) {
        value = (0, lodash_1.get)(data, compPath);
    }
    if ((0, lodash_1.isNil)(value) || ((0, lodash_1.isObject)(value) && (0, lodash_1.isEmpty)(value))) {
        value = '';
    }
    return value;
}
exports.getComponentActualValue = getComponentActualValue;
/**
 * Determine if a component is a layout component or not.
 *
 * @param {Object} component
 *   The component to check.
 *
 * @returns {Boolean}
 *   Whether or not the component is a layout component.
 */
function isLayoutComponent(component) {
    return Boolean((component.columns && Array.isArray(component.columns)) ||
        (component.rows && Array.isArray(component.rows)) ||
        (component.components && Array.isArray(component.components)));
}
exports.isLayoutComponent = isLayoutComponent;
/**
 * Matches if a component matches the query.
 *
 * @param component
 * @param query
 * @return {boolean}
 */
function matchComponent(component, query) {
    if ((0, lodash_1.isString)(query)) {
        return (component.key === query) || (component.path === query);
    }
    else {
        let matches = false;
        (0, lodash_1.forOwn)(query, (value, key) => {
            matches = ((0, lodash_1.get)(component, key) === value);
            if (!matches) {
                return false;
            }
        });
        return matches;
    }
}
exports.matchComponent = matchComponent;
/**
 * Get a component by its key
 *
 * @param {Object} components
 *   The components to iterate.
 * @param {String|Object} key
 *   The key of the component to get, or a query of the component to search.
 *
 * @returns {Object}
 *   The component that matches the given key, or undefined if not found.
 */
function getComponent(components, key, includeAll) {
    let result;
    eachComponent(components, (component, path) => {
        if ((path === key) || (component.path === key)) {
            result = component;
            return true;
        }
    }, includeAll);
    return result;
}
exports.getComponent = getComponent;
/**
 * Finds a component provided a query of properties of that component.
 *
 * @param components
 * @param query
 * @return {*}
 */
function searchComponents(components, query) {
    const results = [];
    eachComponent(components, (component) => {
        if (matchComponent(component, query)) {
            results.push(component);
        }
    }, true);
    return results;
}
exports.searchComponents = searchComponents;
/**
 * Remove a component by path.
 *
 * @param components
 * @param path
 */
function removeComponent(components, path) {
    // Using _.unset() leave a null value. Use Array splice instead.
    // @ts-ignore
    var index = path.pop();
    if (path.length !== 0) {
        components = (0, lodash_1.get)(components, path);
    }
    components.splice(index, 1);
}
exports.removeComponent = removeComponent;
/**
 * Returns if this component has a conditional statement.
 *
 * @param component - The component JSON schema.
 *
 * @returns {boolean} - TRUE - This component has a conditional, FALSE - No conditional provided.
 */
function hasCondition(component) {
    return Boolean((component.customConditional) ||
        (component.conditional && (component.conditional.when ||
            component.conditional.json ||
            component.conditional.condition)));
}
exports.hasCondition = hasCondition;
/**
 * Extension of standard #parseFloat(value) function, that also clears input string.
 *
 * @param {any} value
 *   The value to parse.
 *
 * @returns {Number}
 *   Parsed value.
 */
function parseFloatExt(value) {
    return parseFloat((0, lodash_1.isString)(value)
        ? value.replace(/[^\de.+-]/gi, '')
        : value);
}
exports.parseFloatExt = parseFloatExt;
/**
 * Formats provided value in way how Currency component uses it.
 *
 * @param {any} value
 *   The value to format.
 *
 * @returns {String}
 *   Value formatted for Currency component.
 */
function formatAsCurrency(value) {
    const parsedValue = parseFloatExt(value);
    if (isNaN(parsedValue)) {
        return '';
    }
    const parts = (0, lodash_1.round)(parsedValue, 2)
        .toString()
        .split('.');
    parts[0] = (0, lodash_1.chunk)(Array.from(parts[0]).reverse(), 3)
        .reverse()
        .map((part) => part
        .reverse()
        .join(''))
        .join(',');
    parts[1] = (0, lodash_1.pad)(parts[1], 2, '0');
    return parts.join('.');
}
exports.formatAsCurrency = formatAsCurrency;
/**
 * Escapes RegEx characters in provided String value.
 *
 * @param {String} value
 *   String for escaping RegEx characters.
 * @returns {string}
 *   String with escaped RegEx characters.
 */
function escapeRegExCharacters(value) {
    return value.replace(/[-[\]/{}()*+?.\\^$|]/g, '\\$&');
}
exports.escapeRegExCharacters = escapeRegExCharacters;
/**
 * Get the value for a component key, in the given submission.
 *
 * @param {Object} submission
 *   A submission object to search.
 * @param {String} key
 *   A for components API key to search for.
 */
function getValue(submission, key) {
    const search = (data) => {
        if ((0, lodash_1.isPlainObject)(data)) {
            if ((0, lodash_1.has)(data, key)) {
                return (0, lodash_1.get)(data, key);
            }
            let value = null;
            (0, lodash_1.forOwn)(data, (prop) => {
                const result = search(prop);
                if (!(0, lodash_1.isNil)(result)) {
                    value = result;
                    return false;
                }
            });
            return value;
        }
        else {
            return null;
        }
    };
    return search(submission.data);
}
exports.getValue = getValue;
/**
 * Iterate over all components in a form and get string values for translation.
 * @param form
 */
function getStrings(form) {
    const properties = ['label', 'title', 'legend', 'tooltip', 'description', 'placeholder', 'prefix', 'suffix', 'errorLabel', 'content', 'html'];
    const strings = [];
    eachComponent(form.components, (component) => {
        properties.forEach(property => {
            if (component.hasOwnProperty(property) && component[property]) {
                strings.push({
                    key: component.key,
                    type: component.type,
                    property,
                    string: component[property]
                });
            }
        });
        if ((!component.dataSrc || component.dataSrc === 'values') && component.hasOwnProperty('values') && Array.isArray(component.values) && component.values.length) {
            component.values.forEach((value, index) => {
                strings.push({
                    key: component.key,
                    property: `value[${index}].label`,
                    string: component.values[index].label
                });
            });
        }
        // Hard coded values from Day component
        if (component.type === 'day') {
            [
                'day',
                'month',
                'year',
                'Day',
                'Month',
                'Year',
                'january',
                'february',
                'march',
                'april',
                'may',
                'june',
                'july',
                'august',
                'september',
                'october',
                'november',
                'december'
            ].forEach(string => {
                strings.push({
                    key: component.key,
                    property: 'day',
                    string,
                });
            });
            if (component.fields.day.placeholder) {
                strings.push({
                    key: component.key,
                    property: 'fields.day.placeholder',
                    string: component.fields.day.placeholder,
                });
            }
            if (component.fields.month.placeholder) {
                strings.push({
                    key: component.key,
                    property: 'fields.month.placeholder',
                    string: component.fields.month.placeholder,
                });
            }
            if (component.fields.year.placeholder) {
                strings.push({
                    key: component.key,
                    property: 'fields.year.placeholder',
                    string: component.fields.year.placeholder,
                });
            }
        }
        if (component.type === 'editgrid') {
            const string = component.addAnother || 'Add Another';
            if (component.addAnother) {
                strings.push({
                    key: component.key,
                    property: 'addAnother',
                    string,
                });
            }
        }
        if (component.type === 'select') {
            [
                'loading...',
                'Type to search'
            ].forEach(string => {
                strings.push({
                    key: component.key,
                    property: 'select',
                    string,
                });
            });
        }
    }, true);
    return strings;
}
exports.getStrings = getStrings;
// ?????????????????????????
// questionable section
function generateFormChange(type, data) {
    let change;
    switch (type) {
        case 'add':
            change = {
                op: 'add',
                key: data.component.key,
                container: data.parent.key, // Parent component
                path: data.path, // Path to container within parent component.
                index: data.index, // Index of component in parent container.
                component: data.component
            };
            break;
        case 'edit':
            change = {
                op: 'edit',
                key: data.originalComponent.key,
                patches: (0, fast_json_patch_1.compare)(data.originalComponent, data.component)
            };
            // Don't save if nothing changed.
            if (!change.patches.length) {
                change = null;
            }
            break;
        case 'remove':
            change = {
                op: 'remove',
                key: data.component.key,
            };
            break;
    }
    return change;
}
exports.generateFormChange = generateFormChange;
function applyFormChanges(form, changes) {
    const failed = [];
    changes.forEach(function (change) {
        var found = false;
        switch (change.op) {
            case 'add':
                var newComponent = change.component;
                // Find the container to set the component in.
                findComponent(form.components, change.container, null, function (parent) {
                    if (!change.container) {
                        parent = form;
                    }
                    // A move will first run an add so remove any existing components with matching key before inserting.
                    findComponent(form.components, change.key, null, function (component, path) {
                        // If found, use the existing component. (If someone else edited it, the changes would be here)
                        newComponent = component;
                        removeComponent(form.components, path);
                    });
                    found = true;
                    var container = (0, lodash_1.get)(parent, change.path);
                    container.splice(change.index, 0, newComponent);
                });
                break;
            case 'remove':
                findComponent(form.components, change.key, null, function (component, path) {
                    found = true;
                    const oldComponent = (0, lodash_1.get)(form.components, path);
                    if (oldComponent.key !== component.key) {
                        path.pop();
                    }
                    removeComponent(form.components, path);
                });
                break;
            case 'edit':
                findComponent(form.components, change.key, null, function (component, path) {
                    found = true;
                    try {
                        const oldComponent = (0, lodash_1.get)(form.components, path);
                        const newComponent = (0, fast_json_patch_1.applyPatch)(component, change.patches).newDocument;
                        if (oldComponent.key !== newComponent.key) {
                            path.pop();
                        }
                        (0, lodash_1.set)(form.components, path, newComponent);
                    }
                    catch (err) {
                        failed.push(change);
                    }
                });
                break;
            case 'move':
                break;
        }
        if (!found) {
            failed.push(change);
        }
    });
    return {
        form,
        failed
    };
}
exports.applyFormChanges = applyFormChanges;
/**
* This function will find a component in a form and return the component AND THE PATH to the component in the form.
* Path to the component is stored as an array of nested components and their indexes.The Path is being filled recursively
* when you iterating through the nested structure.
* If the component is not found the callback won't be called and function won't return anything.
*
* @param components
* @param key
* @param fn
* @param path
* @returns {*}
*/
function findComponent(components, key, path, fn) {
    if (!components)
        return;
    path = path || [];
    if (!key) {
        return fn(components);
    }
    components.forEach(function (component, index) {
        var newPath = path.slice();
        // Add an index of the component it iterates through in nested structure
        newPath.push(index);
        if (!component)
            return;
        if (component.hasOwnProperty('columns') && Array.isArray(component.columns)) {
            newPath.push('columns');
            component.columns.forEach(function (column, index) {
                var colPath = newPath.slice();
                colPath.push(index);
                colPath.push('components');
                findComponent(column.components, key, colPath, fn);
            });
        }
        if (component.hasOwnProperty('rows') && Array.isArray(component.rows)) {
            newPath.push('rows');
            component.rows.forEach(function (row, index) {
                var rowPath = newPath.slice();
                rowPath.push(index);
                row.forEach(function (column, index) {
                    var colPath = rowPath.slice();
                    colPath.push(index);
                    colPath.push('components');
                    findComponent(column.components, key, colPath, fn);
                });
            });
        }
        if (component.hasOwnProperty('components') && Array.isArray(component.components)) {
            newPath.push('components');
            findComponent(component.components, key, newPath, fn);
        }
        if (component.key === key) {
            //Final callback if the component is found
            fn(component, newPath, components);
        }
    });
}
exports.findComponent = findComponent;
const isCheckboxComponent = (component) => component.type === 'checkbox';
const isDataGridComponent = (component) => component.type === 'datagrid';
const isEditGridComponent = (component) => component.type === 'editgrid';
const isDataTableComponent = (component) => component.type === 'datatable';
const hasChildComponents = (component) => component.components != null;
const isDateTimeComponent = (component) => component.type === 'datetime';
const isSelectBoxesComponent = (component) => component.type === 'selectboxes';
const isTextAreaComponent = (component) => component.type === 'textarea';
const isTextFieldComponent = (component) => component.type === 'textfield';
function getEmptyValue(component) {
    switch (component.type) {
        case 'textarea':
        case 'textfield':
        case 'time':
        case 'datetime':
        case 'day':
            return '';
        case 'datagrid':
        case 'editgrid':
            return [];
        default:
            return null;
    }
}
exports.getEmptyValue = getEmptyValue;
const replaceBlanks = (value) => {
    const nbsp = '<p>&nbsp;</p>';
    const br = '<p><br></p>';
    const brNbsp = '<p><br>&nbsp;</p>';
    const regExp = new RegExp(`^${nbsp}|${nbsp}$|^${br}|${br}$|^${brNbsp}|${brNbsp}$`, 'g');
    return typeof value === 'string' ? value.replace(regExp, '').trim() : value;
};
function trimBlanks(value) {
    if (!value) {
        return value;
    }
    if (Array.isArray(value)) {
        value = value.map((val) => replaceBlanks(val));
    }
    else {
        value = replaceBlanks(value);
    }
    return value;
}
function isValueEmpty(component, value) {
    const compValueIsEmptyArray = ((0, lodash_1.isArray)(value) && value.length === 1) ? (0, lodash_1.isEqual)(value[0], getEmptyValue(component)) : false;
    return value == null || value === '' || ((0, lodash_1.isArray)(value) && value.length === 0) || compValueIsEmptyArray;
}
function isComponentDataEmpty(component, data, path) {
    var _a;
    const value = (0, lodash_1.get)(data, path);
    if (isCheckboxComponent(component)) {
        return isValueEmpty(component, value) || value === false;
    }
    else if (isDataGridComponent(component) || isEditGridComponent(component) || isDataTableComponent(component) || hasChildComponents(component)) {
        if ((_a = component.components) === null || _a === void 0 ? void 0 : _a.length) {
            let childrenEmpty = true;
            // wrap component in an array to let eachComponentData handle introspection to child components (e.g. this will be different
            // for data grids versus nested forms, etc.)
            (0, exports.eachComponentData)([component], data, (thisComponent, data, row, path, components, index) => {
                if (component.key === thisComponent.key)
                    return;
                if (!isComponentDataEmpty(thisComponent, data, path)) {
                    childrenEmpty = false;
                }
            });
            return isValueEmpty(component, value) || childrenEmpty;
        }
        return isValueEmpty(component, value);
    }
    else if (isDateTimeComponent(component)) {
        return isValueEmpty(component, value) || value.toString() === 'Invalid date';
    }
    else if (isSelectBoxesComponent(component)) {
        let selectBoxEmpty = true;
        for (const key in value) {
            if (value[key]) {
                selectBoxEmpty = false;
                break;
            }
        }
        return isValueEmpty(component, value) || selectBoxEmpty;
    }
    else if (isTextAreaComponent(component)) {
        const isPlain = !component.wysiwyg && !component.editor;
        return isPlain ? typeof value === 'string' ? isValueEmpty(component, value.trim()) : isValueEmpty(component, value) : isValueEmpty(component, trimBlanks(value));
    }
    else if (isTextFieldComponent(component)) {
        if (component.allowMultipleMasks && !!component.inputMasks && !!component.inputMasks.length) {
            return isValueEmpty(component, value) || (component.multiple ? value.length === 0 : (!value.maskName || !value.value));
        }
        return isValueEmpty(component, value === null || value === void 0 ? void 0 : value.toString().trim());
    }
    return isValueEmpty(component, value);
}
exports.isComponentDataEmpty = isComponentDataEmpty;
