"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.FieldError = void 0;
const util_1 = require("../process/validation/util");
class FieldError {
    constructor(errorKeyOrMessage, context, ruleName = errorKeyOrMessage) {
        var _a;
        const { component, hasLabel = true, field = (0, util_1.getComponentErrorField)(component, context), level = 'error' } = context;
        this.ruleName = ruleName;
        if ((_a = context.component.validate) === null || _a === void 0 ? void 0 : _a.customMessage) {
            this.errorKeyOrMessage = context.component.validate.customMessage;
            this.context = Object.assign(Object.assign({}, context), { hasLabel: false, field, level });
        }
        else {
            this.errorKeyOrMessage = errorKeyOrMessage;
            this.context = Object.assign(Object.assign({}, context), { hasLabel, field });
            this.level = level;
        }
    }
}
exports.FieldError = FieldError;
