import { ProcessorInfo } from './ProcessorInfo';
export * from './ProcessType';
export * from './ProcessorType';
export * from './ProcessorContext';
export * from './ProcessorFn';
export * from './ProcessContext';
export * from './ProcessorContext';
export * from './ProcessorScope';
export * from './ProcessorsScope';
export * from './ProcessConfig';
export * from './ProcessorInfo';
export * from './validation';
export * from './calculation';
export * from './conditions';
export * from './defaultValue';
export * from './fetch';
export * from './filter';
export * from './populate';
export * from './logic';
export declare const processes: {
    calculation: ProcessorInfo<import("./calculation").CalculationContext, void>;
    conditions: ProcessorInfo<import("./ProcessorContext").ProcessorContext<import("./conditions").ConditionsScope>, void>;
    defaultValue: ProcessorInfo<import("./ProcessorContext").ProcessorContext<import("./defaultValue").DefaultValueScope>, void>;
    fetch: ProcessorInfo<import("./fetch").FetchContext, void>;
    filter: ProcessorInfo<import("./filter").FilterContext, void>;
    logic: {
        name: string;
        process: import("./ProcessorFn").ProcessorFn<import("./ProcessorScope").ProcessorScope>;
        processSync: import("./ProcessorFn").ProcessorFnSync<import("./ProcessorScope").ProcessorScope>;
        shouldProcess: (context: import("./logic").LogicContext) => boolean;
    };
    populate: {
        name: string;
        shouldProcess: (context: import("./populate").PopulateContext) => boolean;
        processSync: import("./ProcessorFn").ProcessorFnSync<import("./populate").PopulateScope>;
    };
    validation: ProcessorInfo<import("./validation").ValidationContext, void>;
};
export type ProcessTarget = Record<string, ProcessorInfo<any, any>[]>;
