import { ProcessContext, ProcessTarget, ProcessorInfo } from "types";
export declare function process<ProcessScope>(context: ProcessContext<ProcessScope>): Promise<ProcessScope>;
export declare function processSync<ProcessScope>(context: ProcessContext<ProcessScope>): ProcessScope;
export declare const ProcessorMap: Record<string, ProcessorInfo<any, any>>;
export declare const ProcessTargets: ProcessTarget;
