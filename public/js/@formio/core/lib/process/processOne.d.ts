import { Component, ProcessorsContext } from "types";
export declare function dataValue(component: Component, row: any): any;
export declare function processOne<ProcessorScope>(context: ProcessorsContext<ProcessorScope>): Promise<void>;
export declare function processOneSync<ProcessorScope>(context: ProcessorsContext<ProcessorScope>): void;
