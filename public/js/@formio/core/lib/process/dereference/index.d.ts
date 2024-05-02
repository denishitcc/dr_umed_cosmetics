import { ProcessorFn, ProcessorScope, ProcessorContext, ProcessorInfo, Component } from "types";
type DereferenceScope = ProcessorScope & {
    dereference: {
        [path: string]: Component[];
    };
};
/**
 * This function is used to dereference reference IDs contained in the form.
 * It is currently only compatible with Data Table components.
 * @todo Add support for other components (if applicable) and for submission data dereferencing (e.g. save-as-reference, currently a property action).
 */
export declare const dereferenceProcess: ProcessorFn<DereferenceScope>;
export declare const dereferenceProcessInfo: ProcessorInfo<ProcessorContext<DereferenceScope>, void>;
export {};
