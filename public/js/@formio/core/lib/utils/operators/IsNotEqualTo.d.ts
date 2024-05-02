export default class IsNotEqualTo extends ConditionOperator {
    execute({ value, comparedValue }: {
        value: any;
        comparedValue: any;
    }): boolean;
}
import ConditionOperator from './ConditionOperator';
