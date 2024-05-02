import { PopulateContext, PopulateScope, ProcessorFnSync } from 'types';
export declare const populateProcessSync: ProcessorFnSync<PopulateScope>;
export declare const populateProcessInfo: {
    name: string;
    shouldProcess: (context: PopulateContext) => boolean;
    processSync: ProcessorFnSync<PopulateScope>;
};
