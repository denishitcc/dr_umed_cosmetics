export default ConditionOperators;
declare const ConditionOperators: {
    [x: string]: typeof IsEqualTo | typeof IsEmptyValue | typeof DateGreaterThan;
};
import IsEqualTo from './IsEqualTo';
import IsEmptyValue from './IsEmptyValue';
import DateGreaterThan from './DateGreaterThan';
