import { Component, ComponentInstances, DataObject, ValidationRuleInfo, ValidationFn, ValidationFnSync, ValidationScope, ProcessContext } from "types";
import { FieldError } from "error";
export type ProcessValidateContext = ProcessContext<ValidationScope> & {
    rules: ValidationRuleInfo[];
};
export declare function processValidate(context: ProcessValidateContext): Promise<ValidationScope>;
export declare function processValidateSync(context: ProcessValidateContext): ValidationScope;
export declare const validator: (rules: ValidationRuleInfo[]) => ValidationFn;
export declare const validatorSync: (rules: ValidationRuleInfo[]) => ValidationFnSync;
export declare function validate(components: Component[], data: DataObject, instances?: ComponentInstances): Promise<FieldError[]>;
export declare function validateSync(components: Component[], data: DataObject, instances?: ComponentInstances): FieldError[];
