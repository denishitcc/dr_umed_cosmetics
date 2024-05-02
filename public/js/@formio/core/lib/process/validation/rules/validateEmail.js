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
exports.validateEmailInfo = exports.validateEmailSync = exports.validateEmail = exports.shouldValidate = void 0;
const error_1 = require("../../../error");
const isValidatableEmailComponent = (component) => {
    return component && component.type === 'email';
};
const shouldValidate = (context) => {
    const { component, value } = context;
    if (!value) {
        return false;
    }
    if (!isValidatableEmailComponent(component)) {
        return false;
    }
    return true;
};
exports.shouldValidate = shouldValidate;
const validateEmail = (context) => __awaiter(void 0, void 0, void 0, function* () {
    return (0, exports.validateEmailSync)(context);
});
exports.validateEmail = validateEmail;
const validateEmailSync = (context) => {
    const error = new error_1.FieldError('invalid_email', context, 'email');
    const { value } = context;
    if (!(0, exports.shouldValidate)(context)) {
        return null;
    }
    // From http://stackoverflow.com/questions/46155/validate-email-address-in-javascript
    const emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    // Allow emails to be valid if the component is pristine and no value is provided.
    if (typeof value === 'string' && !emailRegex.test(value)) {
        return error;
    }
    return null;
};
exports.validateEmailSync = validateEmailSync;
exports.validateEmailInfo = {
    name: 'validateEmail',
    process: exports.validateEmail,
    processSync: exports.validateEmailSync,
    shouldProcess: exports.shouldValidate
};
