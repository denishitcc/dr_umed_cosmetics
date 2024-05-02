import { FilterContext, FilterScope, ProcessorFn, ProcessorFnSync, ProcessorInfo } from "types";
export declare const filterProcessSync: ProcessorFnSync<FilterScope>;
export declare const filterProcess: ProcessorFn<FilterScope>;
export declare const filterPostProcess: ProcessorFnSync<FilterScope>;
export declare const filterProcessInfo: ProcessorInfo<FilterContext, void>;
