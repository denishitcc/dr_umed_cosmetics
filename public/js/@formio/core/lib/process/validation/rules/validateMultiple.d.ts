import { FieldError } from 'error';
import { Component, RuleFn, RuleFnSync, ValidationContext } from 'types';
import { ProcessorInfo } from 'types/process/ProcessorInfo';
export declare const isEligible: (component: Component) => boolean;
export declare const emptyValueIsArray: (component: Component) => boolean;
export declare const shouldValidate: (context: ValidationContext) => boolean;
export declare const validateMultiple: RuleFn;
export declare const validateMultipleSync: RuleFnSync;
export declare const validateMultipleInfo: ProcessorInfo<ValidationContext, FieldError | null>;
