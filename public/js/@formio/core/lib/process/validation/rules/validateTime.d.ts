import { RuleFn, RuleFnSync, ValidationContext } from "types";
import { FieldError } from 'error';
import { ProcessorInfo } from "types/process/ProcessorInfo";
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateTimeSync: RuleFnSync;
export declare const validateTime: RuleFn;
export declare const validateTimeInfo: ProcessorInfo<ValidationContext, FieldError | null>;
