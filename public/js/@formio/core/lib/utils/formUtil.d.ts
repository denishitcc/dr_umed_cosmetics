import { AsyncComponentDataCallback, Component, ComponentDataCallback, DataObject } from "types";
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
export declare function flattenComponents(components: Component[], includeAll: boolean): any;
export declare function guid(): string;
/**
 * Make a filename guaranteed to be unique.
 * @param name
 * @param template
 * @param evalContext
 * @returns {string}
 */
export declare function uniqueName(name: string, template?: string, evalContext?: any): string;
export declare const MODEL_TYPES: Record<string, string[]>;
export declare function getModelType(component: Component): "object" | "array" | "value" | "dataObject" | "inherit";
export declare function getComponentAbsolutePath(component: Component): string;
export declare function getComponentPath(component: Component, path: string): string;
export declare function isComponentModelType(component: Component, modelType: string): boolean;
export declare function isComponentNestedDataType(component: any): any;
export declare function componentPath(component: Component, parentPath?: string): string;
export declare const componentChildPath: (component: any, parentPath?: string, path?: string) => string;
export declare const eachComponentDataAsync: (components: Component[], data: DataObject, fn: AsyncComponentDataCallback, path?: string, index?: number, parent?: Component, includeAll?: boolean) => Promise<void>;
export declare const eachComponentData: (components: Component[], data: DataObject, fn: ComponentDataCallback, path?: string, index?: number, parent?: Component, includeAll?: boolean) => void;
export declare function getComponentKey(component: Component): string;
export declare function getContextualRowPath(component: Component, path: string): string;
export declare function getContextualRowData(component: Component, path: string, data: any): any;
export declare function componentInfo(component: any): {
    hasColumns: any;
    hasRows: any;
    hasComps: any;
    iterable: any;
};
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
export declare function eachComponent(components: any, fn: any, includeAll?: boolean, path?: string, parent?: any): void;
export declare function eachComponentAsync(components: any[], fn: any, includeAll?: boolean, path?: string, parent?: any): Promise<void>;
export declare function getComponentData(components: Component[], data: DataObject, path: string): any;
export declare function getComponentActualValue(component: Component, compPath: string, data: any, row: any): any;
/**
 * Determine if a component is a layout component or not.
 *
 * @param {Object} component
 *   The component to check.
 *
 * @returns {Boolean}
 *   Whether or not the component is a layout component.
 */
export declare function isLayoutComponent(component: any): boolean;
/**
 * Matches if a component matches the query.
 *
 * @param component
 * @param query
 * @return {boolean}
 */
export declare function matchComponent(component: any, query: any): boolean;
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
export declare function getComponent(components: any, key: any, includeAll: any): undefined;
/**
 * Finds a component provided a query of properties of that component.
 *
 * @param components
 * @param query
 * @return {*}
 */
export declare function searchComponents(components: any, query: any): any[];
/**
 * Remove a component by path.
 *
 * @param components
 * @param path
 */
export declare function removeComponent(components: any, path: string): void;
/**
 * Returns if this component has a conditional statement.
 *
 * @param component - The component JSON schema.
 *
 * @returns {boolean} - TRUE - This component has a conditional, FALSE - No conditional provided.
 */
export declare function hasCondition(component: any): boolean;
/**
 * Extension of standard #parseFloat(value) function, that also clears input string.
 *
 * @param {any} value
 *   The value to parse.
 *
 * @returns {Number}
 *   Parsed value.
 */
export declare function parseFloatExt(value: any): number;
/**
 * Formats provided value in way how Currency component uses it.
 *
 * @param {any} value
 *   The value to format.
 *
 * @returns {String}
 *   Value formatted for Currency component.
 */
export declare function formatAsCurrency(value: string): string;
/**
 * Escapes RegEx characters in provided String value.
 *
 * @param {String} value
 *   String for escaping RegEx characters.
 * @returns {string}
 *   String with escaped RegEx characters.
 */
export declare function escapeRegExCharacters(value: string): string;
/**
 * Get the value for a component key, in the given submission.
 *
 * @param {Object} submission
 *   A submission object to search.
 * @param {String} key
 *   A for components API key to search for.
 */
export declare function getValue(submission: any, key: string): any;
/**
 * Iterate over all components in a form and get string values for translation.
 * @param form
 */
export declare function getStrings(form: any): any;
export declare function generateFormChange(type: any, data: any): {
    op: string;
    key: any;
    container: any;
    path: any;
    index: any;
    component: any;
    patches?: undefined;
} | {
    op: string;
    key: any;
    patches: import("fast-json-patch").Operation[];
    container?: undefined;
    path?: undefined;
    index?: undefined;
    component?: undefined;
} | {
    op: string;
    key: any;
    container?: undefined;
    path?: undefined;
    index?: undefined;
    component?: undefined;
    patches?: undefined;
} | null | undefined;
export declare function applyFormChanges(form: any, changes: any): {
    form: any;
    failed: any;
};
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
export declare function findComponent(components: any, key: any, path: any, fn: any): any;
export declare function getEmptyValue(component: Component): "" | never[] | null;
export declare function isComponentDataEmpty(component: Component, data: any, path: string): boolean;
