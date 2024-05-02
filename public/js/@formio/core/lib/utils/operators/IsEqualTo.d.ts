export default class IsEqualTo extends ConditionOperator {
    execute({ value, comparedValue }: {
        value: any;
        comparedValue: any;
    }): any;
}
import ConditionOperator from './ConditionOperator';
