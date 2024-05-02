"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const ConditionOperator_1 = __importDefault(require("./ConditionOperator"));
const lodash_1 = require("lodash");
class IsEqualTo extends ConditionOperator_1.default {
    static get operatorKey() {
        return 'isEqual';
    }
    static get displayedName() {
        return 'Is Equal To';
    }
    execute({ value, comparedValue }) {
        if (value && comparedValue && typeof value !== typeof comparedValue && (0, lodash_1.isString)(comparedValue)) {
            try {
                comparedValue = JSON.parse(comparedValue);
            }
            // eslint-disable-next-line no-empty
            catch (e) { }
        }
        //special check for select boxes
        if ((0, lodash_1.isObject)(value) && comparedValue && (0, lodash_1.isString)(comparedValue)) {
            return value[comparedValue];
        }
        return (0, lodash_1.isEqual)(value, comparedValue);
    }
}
exports.default = IsEqualTo;
