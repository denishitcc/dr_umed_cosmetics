"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.validateUniqueInfo = exports.validateUnique = exports.shouldValidate = void 0;
const FieldError_1 = require("../../../error/FieldError");
const util_1 = require("../util");
const error_1 = require("../../../error");
const shouldValidate = (context) => {
    const { component, value } = context;
    if (!component.unique) {
        return false;
    }
    if (!value || (0, util_1.isEmptyObject)(value)) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateUnique = (context) => __awaiter(void 0, void 0, void 0, function* () {
    var _a;
    const { value, config, component } = context;
    if (!(0, exports.shouldValidate)(context)) {
        return null;
    }
    if (!config || !config.database) {
        throw new error_1.ProcessorError("Can't test for unique value without a database config object", context, 'validate:validateUnique');
    }
    try {
        const isUnique = yield ((_a = config.database) === null || _a === void 0 ? void 0 : _a.isUnique(context, value));
        if (typeof isUnique === 'string') {
            return new FieldError_1.FieldError('unique', Object.assign(Object.assign({}, context), { component: Object.assign(Object.assign({}, component), { conflictId: isUnique }) }));
        }
        return (isUnique === true) ? null : new FieldError_1.FieldError('unique', context);
    }
    catch (err) {
        throw new error_1.ProcessorError(err.message || err, context, 'validate:validateUnique');
    }
});
exports.validateUnique = validateUnique;
exports.validateUniqueInfo = {
    name: 'validateUnique',
    fullValue: true,
    process: exports.validateUnique,
    shouldProcess: exports.shouldValidate,
};
