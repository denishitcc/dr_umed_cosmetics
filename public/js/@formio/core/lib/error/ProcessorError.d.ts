import { ProcessorContext } from "types";
export declare class ProcessorError extends Error {
    context: Omit<ProcessorContext<any>, 'scope'>;
    constructor(message: string, context: ProcessorContext<any>, processor?: string);
}
