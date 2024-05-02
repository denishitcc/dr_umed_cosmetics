"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.NestedDataModel = void 0;
const lodash_1 = require("lodash");
const NestedModel_1 = require("./NestedModel");
function NestedDataModel(props = {}) {
    return function (BaseClass) {
        return class BaseNestedDataModel extends (0, NestedModel_1.NestedModel)(props)(BaseClass) {
            get emptyValue() {
                return {};
            }
            get defaultValue() {
                return {};
            }
            /**
             * Get the component data.
             */
            componentData() {
                if (!this.component.key) {
                    return this.data;
                }
                const compData = (0, lodash_1.get)(this.data, this.component.key, this.defaultValue);
                if (!Object.keys(compData).length) {
                    (0, lodash_1.set)(this.data, this.component.key, compData);
                }
                return compData;
            }
            get dataValue() {
                return this.component.key ? (0, lodash_1.get)(this.data, this.component.key) : this.data;
            }
            set dataValue(value) {
                this.eachComponentValue(value, (comp, val) => (comp.dataValue = val));
            }
        };
    };
}
exports.NestedDataModel = NestedDataModel;
;
