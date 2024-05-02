import { ProcessorFn, ProcessorFnSync, CalculationScope, CalculationContext, ProcessorInfo } from 'types';
export declare const shouldCalculate: (context: CalculationContext) => boolean;
export declare const calculateProcessSync: ProcessorFnSync<CalculationScope>;
export declare const calculateProcess: ProcessorFn<CalculationScope>;
export declare const calculateProcessInfo: ProcessorInfo<CalculationContext, void>;
