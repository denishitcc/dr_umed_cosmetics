import { ProcessorFn, ProcessorInfo, FetchContext, FetchScope } from 'types';
export declare const shouldFetch: (context: FetchContext) => boolean;
export declare const fetchProcess: ProcessorFn<FetchScope>;
export declare const fetchProcessInfo: ProcessorInfo<FetchContext, void>;
