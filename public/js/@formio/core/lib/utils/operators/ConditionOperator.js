"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const lodash_1 = require("lodash");
/* eslint-disable no-unused-vars */
class ConditionOperator {
    static get operatorKey() {
        return '';
    }
    static get displayedName() {
        return '';
    }
    static get requireValue() {
        return true;
    }
    execute(options) {
        return true;
    }
    getResult(options = {}) {
        const { value } = options;
        if ((0, lodash_1.isArray)(value)) {
            return (0, lodash_1.some)(value, valueItem => this.execute(Object.assign(Object.assign({}, options), { value: valueItem })));
        }
        return this.execute(options);
    }
}
exports.default = ConditionOperator;
