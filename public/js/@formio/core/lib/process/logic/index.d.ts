import { LogicContext, LogicScope, ProcessorFn, ProcessorFnSync } from "types";
export declare const logicProcessSync: ProcessorFnSync<LogicScope>;
export declare const logicProcess: ProcessorFn<LogicScope>;
export declare const logicProcessInfo: {
    name: string;
    process: ProcessorFn<import("types").ProcessorScope>;
    processSync: ProcessorFnSync<import("types").ProcessorScope>;
    shouldProcess: (context: LogicContext) => boolean;
};
