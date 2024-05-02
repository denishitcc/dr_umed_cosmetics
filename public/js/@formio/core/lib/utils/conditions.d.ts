import { ConditionsContext, JSONConditional, LegacyConditional, SimpleConditional } from "types";
export declare const isJSONConditional: (conditional: any) => conditional is JSONConditional;
export declare const isLegacyConditional: (conditional: any) => conditional is LegacyConditional;
export declare const isSimpleConditional: (conditional: any) => conditional is SimpleConditional;
export declare function conditionallyHidden(context: ConditionsContext): boolean | undefined;
/**
 * Check custom javascript conditional.
 *
 * @param component
 * @param custom
 * @param row
 * @param data
 * @returns {*}
 */
export declare function checkCustomConditional(condition: string, context: ConditionsContext, variable?: string): boolean | null;
/**
 * Checks the legacy conditionals.
 *
 * @param conditional
 * @param context
 * @param checkDefault
 * @returns
 */
export declare function checkLegacyConditional(conditional: LegacyConditional, context: ConditionsContext): boolean | null;
/**
 * Checks the JSON Conditionals.
 * @param conditional
 * @param context
 * @returns
 */
export declare function checkJsonConditional(conditional: JSONConditional, context: ConditionsContext): boolean | null;
/**
 * Checks the simple conditionals.
 * @param conditional
 * @param context
 * @returns
 */
export declare function checkSimpleConditional(conditional: SimpleConditional, context: ConditionsContext): boolean | null;
