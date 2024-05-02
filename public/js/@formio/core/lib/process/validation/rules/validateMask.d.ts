import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare function matchInputMask(value: any, inputMask: any): boolean;
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateMask: RuleFn;
export declare const validateMaskSync: RuleFnSync;
export declare const validateMaskInfo: ProcessorInfo<ValidationContext, FieldError | null>;
