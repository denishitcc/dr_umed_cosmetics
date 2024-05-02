import { ProcessorFnSync, ProcessorFn, DefaultValueScope, ProcessorInfo, ProcessorContext } from "types";
type NormalizeScope = DefaultValueScope & {
    normalize?: {
        [path: string]: any;
    };
};
export declare const normalizeProcess: ProcessorFn<NormalizeScope>;
export declare const normalizeProcessSync: ProcessorFnSync<NormalizeScope>;
export declare const normalizeProcessInfo: ProcessorInfo<ProcessorContext<NormalizeScope>, void>;
export {};
