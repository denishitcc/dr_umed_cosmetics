export default class GreaterThanOrEqual extends ConditionOperator {
    execute({ value, comparedValue }: {
        value: any;
        comparedValue: any;
    }): any;
}
import ConditionOperator from './ConditionOperator';
