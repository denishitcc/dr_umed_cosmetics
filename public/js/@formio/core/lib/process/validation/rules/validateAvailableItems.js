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
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.validateAvailableItemsInfo = exports.validateAvailableItemsSync = exports.shouldValidate = exports.validateAvailableItems = void 0;
const isEmpty_1 = __importDefault(require("lodash/isEmpty"));
const error_1 = require("../../../error");
const utils_1 = require("../../../utils");
const util_1 = require("../util");
function isValidatableRadioComponent(component) {
    var _a;
    return (component &&
        component.type === 'radio' &&
        !!((_a = component.validate) === null || _a === void 0 ? void 0 : _a.onlyAvailableItems) &&
        component.dataSrc === 'values');
}
function isValidateableSelectComponent(component) {
    var _a;
    return (component &&
        !!((_a = component.validate) === null || _a === void 0 ? void 0 : _a.hasOwnProperty('onlyAvailableItems')) &&
        component.type === 'select' &&
        component.dataSrc !== 'resource');
}
function mapDynamicValues(component, values) {
    return values.map((value) => {
        if (component.valueProperty) {
            return value[component.valueProperty];
        }
        return value;
    });
}
function mapStaticValues(values) {
    return values.map((obj) => obj.value);
}
function getAvailableSelectValues(component, context) {
    return __awaiter(this, void 0, void 0, function* () {
        switch (component.dataSrc) {
            case 'values':
                if (Array.isArray(component.data.values)) {
                    return mapStaticValues(component.data.values);
                }
                throw new error_1.ProcessorError(`Failed to validate available values in static values select component '${component.key}': the values are not an array`, context, 'validate:validateAvailableItems');
            case 'json': {
                if (typeof component.data.json === 'string') {
                    try {
                        return mapDynamicValues(component, JSON.parse(component.data.json));
                    }
                    catch (err) {
                        throw new error_1.ProcessorError(`Failed to validate available values in JSON select component '${component.key}': ${err}`, context, 'validate:validateAvailableItems');
                    }
                }
                else if (Array.isArray(component.data.json)) {
                    // TODO: need to retype this
                    return mapDynamicValues(component, component.data.json);
                }
                else {
                    throw new error_1.ProcessorError(`Failed to validate available values in JSON select component '${component.key}': the values are not an array`, context, 'validate:validateAvailableItems');
                }
            }
            case 'custom':
                const customItems = utils_1.Evaluator.evaluate(component.data.custom, {
                    values: [],
                }, 'values');
                if ((0, util_1.isPromise)(customItems)) {
                    const resolvedCustomItems = yield customItems;
                    if (Array.isArray(resolvedCustomItems)) {
                        return resolvedCustomItems;
                    }
                    throw new error_1.ProcessorError(`Failed to validate available values in JSON select component '${component.key}': the values are not an array`, context, 'validate:validateAvailableItems');
                }
                if (Array.isArray(customItems)) {
                    return customItems;
                }
                else {
                    throw new error_1.ProcessorError(`Failed to validate available values in JSON select component '${component.key}': the values are not an array`, context, 'validate:validateAvailableItems');
                }
            default:
                throw new error_1.ProcessorError(`Failed to validate available values in select component '${component.key}': data source ${component.dataSrc} is not valid}`, context, 'validate:validateAvailableItems');
        }
    });
}
function getAvailableSelectValuesSync(component, context) {
    var _a;
    switch (component.dataSrc) {
        case 'values':
            if (Array.isArray((_a = component.data) === null || _a === void 0 ? void 0 : _a.values)) {
                return mapStaticValues(component.data.values);
            }
            throw new error_1.ProcessorError(`Failed to validate available values in static values select component '${component.key}': the values are not an array`, context, 'validate:validateAvailableItems');
        case 'json': {
            if (typeof component.data.json === 'string') {
                try {
                    return mapDynamicValues(component, JSON.parse(component.data.json));
                }
                catch (err) {
                    throw new error_1.ProcessorError(`Failed to validate available values in JSON select component '${component.key}': ${err}`, context, 'validate:validateAvailableItems');
                }
            }
            else if (Array.isArray(component.data.json)) {
                // TODO: need to retype this
                return mapDynamicValues(component, component.data.json);
            }
            else {
                throw new error_1.ProcessorError(`Failed to validate available values in JSON select component '${component.key}': the values are not an array`, context, 'validate:validateAvailableItems');
            }
        }
        case 'custom':
            const customItems = utils_1.Evaluator.evaluate(component.data.custom, {
                values: [],
            }, 'values');
            if (Array.isArray(customItems)) {
                return customItems;
            }
            else {
                throw new error_1.ProcessorError(`Failed to validate available values in JSON select component '${component.key}': the values are not an array`, context, 'validate:validateAvailableItems');
            }
        default:
            throw new error_1.ProcessorError(`Failed to validate available values in select component '${component.key}': data source ${component.dataSrc} is not valid}`, context, 'validate:validateAvailableItems');
    }
}
function compareComplexValues(valueA, valueB, context) {
    if (!(0, util_1.isObject)(valueA) || !(0, util_1.isObject)(valueB)) {
        return false;
    }
    try {
        // TODO: we need to have normalized values here at this moment, otherwise
        // this won't work
        return JSON.stringify(valueA) === JSON.stringify(valueB);
    }
    catch (err) {
        throw new error_1.ProcessorError(`Error while comparing available values: ${err}`, context, 'validate:validateAvailableItems');
    }
}
const validateAvailableItems = (context) => __awaiter(void 0, void 0, void 0, function* () {
    const { component, value } = context;
    const error = new error_1.FieldError('invalidOption', context, 'onlyAvailableItems');
    try {
        if (isValidatableRadioComponent(component)) {
            if (value == null || (0, isEmpty_1.default)(value)) {
                return null;
            }
            const values = component.values;
            if (values) {
                return values.findIndex(({ value: optionValue }) => optionValue === value) !== -1
                    ? null
                    : error;
            }
            return null;
        }
        else if (isValidateableSelectComponent(component)) {
            if (value == null || (0, isEmpty_1.default)(value)) {
                return null;
            }
            const values = yield getAvailableSelectValues(component, context);
            if (values) {
                if ((0, util_1.isObject)(value)) {
                    return values.find((optionValue) => compareComplexValues(optionValue, value, context)) !==
                        undefined
                        ? null
                        : error;
                }
                return values.find((optionValue) => optionValue === value) !== undefined ? null : error;
            }
        }
    }
    catch (err) {
        throw new error_1.ProcessorError(err.message || err, context, 'validate:validateAvailableItems');
    }
    return null;
});
exports.validateAvailableItems = validateAvailableItems;
const shouldValidate = (context) => {
    const { component, value } = context;
    if (value == null || (0, isEmpty_1.default)(value)) {
        return false;
    }
    if (isValidatableRadioComponent(component)) {
        return true;
    }
    if (isValidateableSelectComponent(component)) {
        return true;
    }
    return false;
};
exports.shouldValidate = shouldValidate;
const validateAvailableItemsSync = (context) => {
    const { component, value } = context;
    const error = new error_1.FieldError('invalidOption', context, 'onlyAvailableItems');
    try {
        if (!(0, exports.shouldValidate)(context)) {
            return null;
        }
        if (isValidatableRadioComponent(component)) {
            const values = component.values;
            if (values) {
                return values.findIndex(({ value: optionValue }) => optionValue === value) !== -1
                    ? null
                    : error;
            }
            return null;
        }
        else if (isValidateableSelectComponent(component)) {
            const values = getAvailableSelectValuesSync(component, context);
            if (values) {
                if ((0, util_1.isObject)(value)) {
                    return values.find((optionValue) => compareComplexValues(optionValue, value, context)) !==
                        undefined
                        ? null
                        : error;
                }
                return values.find((optionValue) => optionValue === value) !== undefined ? null : error;
            }
        }
    }
    catch (err) {
        throw new error_1.ProcessorError(err.message || err, context, 'validate:validateAvailableItems');
    }
    return null;
};
exports.validateAvailableItemsSync = validateAvailableItemsSync;
exports.validateAvailableItemsInfo = {
    name: 'validateAvailableItems',
    process: exports.validateAvailableItems,
    processSync: exports.validateAvailableItemsSync,
    shouldProcess: exports.shouldValidate
};
