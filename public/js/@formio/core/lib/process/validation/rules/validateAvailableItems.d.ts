import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const validateAvailableItems: RuleFn;
export declare const shouldValidate: (context: any) => boolean;
export declare const validateAvailableItemsSync: RuleFnSync;
export declare const validateAvailableItemsInfo: ProcessorInfo<ValidationContext, FieldError | null>;
