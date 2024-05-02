import { FieldError } from 'error';
import { RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateValueProperty: RuleFn;
export declare const validateValuePropertySync: RuleFnSync;
export declare const validateValuePropertyInfo: ProcessorInfo<ValidationContext, FieldError | null>;
