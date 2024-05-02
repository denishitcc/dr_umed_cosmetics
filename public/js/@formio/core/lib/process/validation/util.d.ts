import { FieldError } from 'error';
import { Component, ValidationContext } from 'types';
export declare function isComponentPersistent(component: Component): string | true;
export declare function isComponentProtected(component: Component): boolean;
export declare function isEmptyObject(obj: any): obj is {};
export declare function getComponentErrorField(component: Component, context: ValidationContext): any;
export declare function toBoolean(value: any): boolean;
export declare function isPromise(value: any): value is Promise<any>;
export declare function isObject(obj: any): obj is Object;
/**
 * Interpolates @formio/core errors so that they are compatible with the renderer
 * @param {FieldError[]} errors
 * @param firstPass
 * @returns {[]}
 */
export declare const interpolateErrors: (errors: FieldError[], lang?: string) => {
    message: string | null;
    level: string | undefined;
    path: any;
    context: {
        validator: string;
        hasLabel: boolean | undefined;
        key: string;
        label: string;
        path: string;
        value: any;
        setting: string | number | boolean | undefined;
        index: number;
    };
}[];
