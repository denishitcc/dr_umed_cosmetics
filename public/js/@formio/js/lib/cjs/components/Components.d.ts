export default class Components {
    static _editFormUtils: {
        sortAndFilterComponents(components: any): any;
        unifyComponents(objValue: any, srcValue: any): any;
        logicVariablesTable(additional: any): {
            type: string;
            tag: string;
            content: string;
        };
        javaScriptValue(title: any, property: any, propertyJSON: any, weight: any, exampleHTML: any, exampleJSON: any, additionalParams: string | undefined, excludeJSONLogic: any): {
            type: string;
            title: any;
            theme: string;
            collapsible: boolean;
            collapsed: boolean;
            key: string;
            weight: any;
            components: ({
                type: string;
                tag: string;
                content: string;
            } | {
                type: string;
                title: string;
                collapsible: boolean;
                collapsed: boolean;
                style: {
                    'margin-bottom': string;
                };
                key: string;
                customConditional(): any;
                components: ({
                    type: string;
                    key: any;
                    rows: number;
                    editor: string;
                    hideLabel: boolean;
                    as: string;
                    input: boolean;
                    tag?: undefined;
                    content?: undefined;
                } | {
                    type: string;
                    tag: string;
                    content: string;
                    key?: undefined;
                    rows?: undefined;
                    editor?: undefined;
                    hideLabel?: undefined;
                    as?: undefined;
                    input?: undefined;
                })[];
            } | {
                type: string;
                title: string;
                collapsible: boolean;
                collapsed: boolean;
                key: string;
                components: ({
                    type: string;
                    tag: string;
                    content: string;
                    key?: undefined;
                    rows?: undefined;
                    editor?: undefined;
                    hideLabel?: undefined;
                    as?: undefined;
                    input?: undefined;
                } | {
                    type: string;
                    key: any;
                    rows: number;
                    editor: string;
                    hideLabel: boolean;
                    as: string;
                    input: boolean;
                    tag?: undefined;
                    content?: undefined;
                })[];
                style?: undefined;
                customConditional?: undefined;
            })[];
        };
    };
    static _baseEditForm: typeof BaseEditForm;
    static set EditFormUtils(value: {
        sortAndFilterComponents(components: any): any;
        unifyComponents(objValue: any, srcValue: any): any;
        logicVariablesTable(additional: any): {
            type: string;
            tag: string;
            content: string;
        };
        javaScriptValue(title: any, property: any, propertyJSON: any, weight: any, exampleHTML: any, exampleJSON: any, additionalParams: string | undefined, excludeJSONLogic: any): {
            type: string;
            title: any;
            theme: string;
            collapsible: boolean;
            collapsed: boolean;
            key: string;
            weight: any;
            components: ({
                type: string;
                tag: string;
                content: string;
            } | {
                type: string;
                title: string;
                collapsible: boolean;
                collapsed: boolean;
                style: {
                    'margin-bottom': string;
                };
                key: string;
                customConditional(): any;
                components: ({
                    type: string;
                    key: any;
                    rows: number;
                    editor: string;
                    hideLabel: boolean;
                    as: string;
                    input: boolean;
                    tag?: undefined;
                    content?: undefined;
                } | {
                    type: string;
                    tag: string;
                    content: string;
                    key?: undefined;
                    rows?: undefined;
                    editor?: undefined;
                    hideLabel?: undefined;
                    as?: undefined;
                    input?: undefined;
                })[];
            } | {
                type: string;
                title: string;
                collapsible: boolean;
                collapsed: boolean;
                key: string;
                components: ({
                    type: string;
                    tag: string;
                    content: string;
                    key?: undefined;
                    rows?: undefined;
                    editor?: undefined;
                    hideLabel?: undefined;
                    as?: undefined;
                    input?: undefined;
                } | {
                    type: string;
                    key: any;
                    rows: number;
                    editor: string;
                    hideLabel: boolean;
                    as: string;
                    input: boolean;
                    tag?: undefined;
                    content?: undefined;
                })[];
                style?: undefined;
                customConditional?: undefined;
            })[];
        };
    });
    static get EditFormUtils(): {
        sortAndFilterComponents(components: any): any;
        unifyComponents(objValue: any, srcValue: any): any;
        logicVariablesTable(additional: any): {
            type: string;
            tag: string;
            content: string;
        };
        javaScriptValue(title: any, property: any, propertyJSON: any, weight: any, exampleHTML: any, exampleJSON: any, additionalParams: string | undefined, excludeJSONLogic: any): {
            type: string;
            title: any;
            theme: string;
            collapsible: boolean;
            collapsed: boolean;
            key: string;
            weight: any;
            components: ({
                type: string;
                tag: string;
                content: string;
            } | {
                type: string;
                title: string;
                collapsible: boolean;
                collapsed: boolean;
                style: {
                    'margin-bottom': string;
                };
                key: string;
                customConditional(): any;
                components: ({
                    type: string;
                    key: any;
                    rows: number;
                    editor: string;
                    hideLabel: boolean;
                    as: string;
                    input: boolean;
                    tag?: undefined;
                    content?: undefined;
                } | {
                    type: string;
                    tag: string;
                    content: string;
                    key?: undefined;
                    rows?: undefined;
                    editor?: undefined;
                    hideLabel?: undefined;
                    as?: undefined;
                    input?: undefined;
                })[];
            } | {
                type: string;
                title: string;
                collapsible: boolean;
                collapsed: boolean;
                key: string;
                components: ({
                    type: string;
                    tag: string;
                    content: string;
                    key?: undefined;
                    rows?: undefined;
                    editor?: undefined;
                    hideLabel?: undefined;
                    as?: undefined;
                    input?: undefined;
                } | {
                    type: string;
                    key: any;
                    rows: number;
                    editor: string;
                    hideLabel: boolean;
                    as: string;
                    input: boolean;
                    tag?: undefined;
                    content?: undefined;
                })[];
                style?: undefined;
                customConditional?: undefined;
            })[];
        };
    };
    static set baseEditForm(value: typeof BaseEditForm);
    static get baseEditForm(): typeof BaseEditForm;
    static recalculateComponents(): void;
    static get components(): any;
    static setComponents(comps: any): void;
    static addComponent(name: any, comp: any): void;
    static setComponent(name: any, comp: any): void;
    /**
     * Return a path of component's value.
     *
     * @param {Object} component - The component instance.
     * @return {string} - The component's value path.
     */
    static getComponentPath(component: Object): string;
    static create(component: any, options: any, data: any): any;
}
import BaseEditForm from './_classes/component/Component.form';
