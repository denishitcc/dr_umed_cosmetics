import { ProcessorScope, ProcessorContext, ProcessorInfo, ProcessorFnSync } from "types";
type ClearHiddenScope = ProcessorScope & {
    clearHidden: {
        [path: string]: boolean;
    };
};
/**
 * This processor function checks components for the `hidden` property and unsets corresponding data
 */
export declare const clearHiddenProcess: ProcessorFnSync<ClearHiddenScope>;
export declare const clearHiddenProcessInfo: ProcessorInfo<ProcessorContext<ClearHiddenScope>, void>;
export {};
